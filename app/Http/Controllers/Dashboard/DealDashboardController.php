<?php

namespace App\Http\Controllers\Dashboard;

use App\Deal\DealDashboardPresenter;
use App\Deal\DealRepo;
use App\Deal\LowerFile;
use App\Deal\LowerFileRepo;
use App\Deal\UpperFile;
use App\Deal\UpperFileRepo;
use App\Http\Controllers\Controller;
use App\Services\ImagePathManager;
use App\Services\ImagesPrepare;
use App\Users\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;
use Webmagic\Dashboard\Components\FormGenerator;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Webmagic\Dashboard\Elements\Tables\Observers\ManualSorting\ManualSortingObserver;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DealDashboardController extends Controller
{
    /**
     * @param string $file_name
     * @return string
    */
    private function get_orig_name($file_name) {
        $arr_file_name = explode('_', $file_name);
        $last_part_file = last($arr_file_name);
        if ($last_part_file == 'I2M.obj' || $last_part_file == 'I2M.drc') {
            $orig_name = implode('_',array_slice($arr_file_name, -2));
        } else {
            $orig_name = $last_part_file;
        }
        return $orig_name;
    }

    /**
     * @param int|null $seller_id
     * @param DealRepo $dealRepo
     * @param Dashboard $dashboard
     * @param Request $request
     * @param DealDashboardPresenter $dashboardPresenter
     * @return mixed|Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function indexBySeller(
        int $seller_id = null,
        DealRepo $dealRepo,
        Dashboard $dashboard,
        Request $request,
        DealDashboardPresenter $dashboardPresenter
    ) {
        if (! $seller_id){
            $seller_id = $request->has('seller_id') ? $request->seller_id : Auth::user()->id;
        }

        $items = $dealRepo->getByFilter(
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1),
            null,
            $seller_id
        );

        return $dashboardPresenter->getDealsTablePage($seller_id, null, $items, $dashboard, $request);
    }

    /**
     * @param int|null $client_id
     * @param DealRepo $dealRepo
     * @param Dashboard $dashboard
     * @param Request $request
     * @param DealDashboardPresenter $dashboardPresenter
     * @return mixed|Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function indexByClient(
        int $client_id = null,
        DealRepo $dealRepo,
        Dashboard $dashboard,
        Request $request,
        DealDashboardPresenter $dashboardPresenter
    ) {
        if (! $client_id){
            $client_id = $request->get('client_id', null);
        }

        $items = $dealRepo->getByFilter(
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1),
            $client_id
        );

        return $dashboardPresenter->getDealsTablePage(null, $client_id, $items, $dashboard, $request);
    }

    /**
     * @param int $client_id
     * @param DealDashboardPresenter $dashboardPresenter
     * @param UserRepo $userRepo
     * @return FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function createByClient(int $client_id, DealDashboardPresenter $dashboardPresenter, UserRepo $userRepo)
    {
        if(! $client = $userRepo->getByID($client_id)){
            abort(404);
        }
        $seller_id = $client->seller->id;

        $clients = $userRepo->getForSelect('name', 'id', $seller_id);

        $user = Auth::user();
        if ($user->isSeller()) {
            $clients = array(0 => $user->name) + $clients;
        } elseif($user->isAdmin()) {
            $clients = array(0 => $client->seller->name) + $clients;
        }

        return $dashboardPresenter->getCreateForm($clients, $seller_id, $client->id);
    }

    /**
     * @param int $seller_id
     * @param DealDashboardPresenter $dashboardPresenter
     * @param UserRepo $userRepo
     * @return FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function createBySeller(int $seller_id, DealDashboardPresenter $dashboardPresenter, UserRepo $userRepo)
    {
        $clients = $userRepo->getForSelect('name', 'id', $seller_id);
        $seller = $userRepo->getByID($seller_id);

        $user = Auth::user();
        if ($user->isSeller()) {
            $clients = array(0 => $user->name) + $clients;
        } elseif($user->isAdmin()) {
            $clients = array(0 => $seller->name) + $clients;
        }

        return $dashboardPresenter->getCreateForm($clients, $seller_id);
    }

    /**
     * @param Request $request
     * @param DealRepo $dealRepo
     * @param ImagesPrepare $imagesPrepare
     * @return Application|ResponseFactory|JsonResponse|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function store(Request $request, DealRepo $dealRepo, ImagesPrepare $imagesPrepare)
    {
        $request->validate([
            'pdf' => 'sometimes|mimes:pdf',
            'ipr' => 'sometimes|image'
        ]);        
        $data = $imagesPrepare->saveFiles(
            $request->all(),
            ['pdf', 'ipr'],
            (new ImagePathManager())->publicPathForDealsPdf()
        );        

        if (! $deal = $dealRepo->create($data)) {
            return response('Error on creating', 500);
        }

        // Prepare file names for saving

        $upperFilesNames = json_decode($request->get('upper_files_files_names', '{}'));
        foreach ($upperFilesNames as $file){

            $files_data = [
                #'original_name' => last(explode('_', $file)),
                'original_name' => $this->get_orig_name($file),
                'file_path' => last(explode('/', $file)),
                'deal_id' => $deal->id
            ];

            $upper_file = new UpperFile($files_data);           
            $deal->upperFiles()->save( $upper_file );
            
        }

        $lowerFilesNames =  json_decode($request->get('lower_files_files_names', '{}'));
        foreach ($lowerFilesNames as $file) {         
            $files_data = [
                'original_name' => $this->get_orig_name($file),
                'file_path' => last(explode('/', $file)),
                'deal_id' => $deal->id
            ];

            $lower_file = new LowerFile($files_data);
            $deal->lowerFiles()->save( $lower_file );
        }

        if ($request->get('client_id')){
            return $this->redirect(route('dashboard::deals.index-by-client', $request->get('client_id')));
        }

        return $this->redirect(route('dashboard::deals.index-by-seller'));
    }

    /**
     * @param int $deal_id
     * @param DealDashboardPresenter $dashboardPresenter
     * @param DealRepo $dealRepo
     * @param UserRepo $userRepo
     * @param Dashboard $dashboard
     * @param null $active_tab
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function edit(
        int $deal_id,
        DealDashboardPresenter $dashboardPresenter,
        DealRepo $dealRepo,
        UserRepo $userRepo,
        Dashboard $dashboard,
        $active_tab = null
    ) {
        if(! $deal = $dealRepo->getByID($deal_id)){
            abort(404);
        }

        $clients = $userRepo->getForSelect('name', 'id', $deal->seller_id);

        $user = Auth::user();
        if ($user->isSeller()) {
            $clients = array(0 => $user->name) + $clients;
        } elseif($user->isAdmin()) {
            $clients = array(0 => $deal->seller->name) + $clients;
        }

        return $dashboardPresenter->getEditForm($dashboard, $deal, $clients, $active_tab);
    }

    /**
     * @param int $deal_id
     * @param DealRepo $dealRepo
     * @param Request $request
     * @param ImagesPrepare $imagesPrepare
     * @return Application|ResponseFactory|JsonResponse|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function update(int $deal_id, DealRepo $dealRepo, Request $request, ImagesPrepare $imagesPrepare)
    {
        $request->validate([
            'pdf' => 'sometimes|mimes:pdf',
            'ipr' => 'sometimes|image'
        ]);

        if(! $deal = $dealRepo->getByID($deal_id)){
            abort(404);
        }

        $data = $imagesPrepare->saveFiles(
            $request->all(),
            ['pdf', 'ipr'],
            (new ImagePathManager())->publicPathForDealsPdf()
        );

        if (is_null( $request->file('ipr')) && $request->get('delete_ipr_file')){
            $imagesPrepare->deleteLocalFile($deal->present()->getLocalPath($deal->ipr));

            $data['ipr'] = null;
        }

        if (is_null( $request->file('pdf')) && $request->get('delete_pdf_file')){
            $imagesPrepare->deleteLocalFile($deal->present()->getLocalPath($deal->pdf));

            $data['pdf'] = null;
        }

        if (! $dealRepo->update($deal_id, $data)) {
            return response('Error on updating', 500);
        }

        return $this->redirect(route('dashboard::deals.edit', $deal_id));
    }

    /**
     * @param int $deal_id
     * @param DealRepo $dealRepo
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     * @throws Exception
     */
    public function destroy(int $deal_id, DealRepo $dealRepo)
    {
        if (! $deal = $dealRepo->getByID($deal_id)) {
            abort(404);
        };

        $dealRepo->destroy($deal->id);

        return $this->redirect(route('dashboard::deals.index-by-client', $deal->client_id));
    }

    /**
     * @param int $deal_id
     * @param string $type
     * @param DealDashboardPresenter $dashboardPresenter
     * @return FormGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function addUpperOrLowerFile(int $deal_id, string $type, DealDashboardPresenter $dashboardPresenter)
    {
        if ($type != 'upper' && $type != 'lower'){
            abort(404);
        }

        return $dashboardPresenter->getUpperOrLowerFileInputInPopup($deal_id, $type);
    }

    /**
     * @param int $deal_id
     * @param string $type
     * @param DealRepo $dealRepo
     * @param ImagesPrepare $imagesPrepare
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector|void
     * @throws Exception
     */
    public function saveUpperOrLowerFile(
        int $deal_id,
        string $type,
        DealRepo $dealRepo,
        ImagesPrepare $imagesPrepare,
        Request $request
    ) {
        if (! $deal = $dealRepo->getByID($deal_id)) {
            return abort(404);
        }

        $data = $imagesPrepare->saveFiles(
            $request->all(),
            ['upper_file', 'lower_file'],
            (new ImagePathManager())->publicPathForDealsFiles()
        );

        if (isset($data['upper_file']) && $type == 'upper'){            
            $files_data = [
                #'original_name' => last(explode('_', $data['upper_file'])),
                'original_name' => $this->get_orig_name($data['upper_file']),
                'file_path' => $data['upper_file'],
                'deal_id' => $deal->id
            ];

            $upper_file = new UpperFile($files_data);   
            $deal->upperFiles()->save( $upper_file );
        }

        if (isset($data['lower_file']) && $type == 'lower'){            
            $files_data = [
                'original_name' => $this->get_orig_name($data['lower_file']),
                'file_path' => $data['lower_file'],
                'deal_id' => $deal->id
            ];

            $lower_file = new LowerFile($files_data); 

            $deal->lowerFiles()->save( $lower_file );
        }


        return $this->redirect(route('dashboard::deals.edit', [$deal_id, $type]));
    }

    /**
     * @param string $type
     * @param int $file_id
     * @param UpperFileRepo $upperFileRepo
     * @param LowerFileRepo $lowerFileRepo
     * @param ImagesPrepare $imagesPrepare
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function destroyUpperOrLowerFile(
        string $type,
        int $file_id,
        UpperFileRepo $upperFileRepo,
        LowerFileRepo $lowerFileRepo,
        ImagesPrepare $imagesPrepare
    ) {
        switch ($type){
            case 'upper':
                $fileRepo = $upperFileRepo;
                break;
            case 'lower':
                $fileRepo = $lowerFileRepo;
                break;
            default:
                abort(404);
        }

        if (! $file = $fileRepo->getByID($file_id)) {
            abort(404);
        };

        $imagesPrepare->deleteLocalFile($file->present()->getLocalPath());
        $fileRepo->destroy($file->id);
    }

    /**
     * @param string $type
     * @param ManualSortingObserver $manualSorter
     * @param UpperFileRepo $upperFileRepo
     * @param LowerFileRepo $lowerFileRepo
     * @throws Exception
     */
    public function updatePositionUpperOrLowerFile(
        string $type,
        ManualSortingObserver $manualSorter,
        UpperFileRepo $upperFileRepo,
        LowerFileRepo $lowerFileRepo
    ) {
        switch ($type){
            case 'upper':
                $fileRepo = $upperFileRepo;
                break;
            case 'lower':
                $fileRepo = $lowerFileRepo;
                break;
            default:
                abort(404);
        }

        if (! $file = $fileRepo->getByID($manualSorter->itemId())) {
            return abort(404);
        }

        if (! $referenceFile = $fileRepo->getByID($manualSorter->referenceItemId())) {
            return abort(404);
        }

        if ($manualSorter->isItemSetAfterReference()) {
            $file->moveAfter($referenceFile);
        }

        if ($manualSorter->isItemSetBeforeReference()) {
            $file->moveBefore($referenceFile);
        }
    }

    /**
     * Do not show more notification about soon deleting current case
     *
     * @param Request $request
     * @param DealRepo $dealRepo
     * @throws Exception
     */
    public function notifications(Request $request, DealRepo $dealRepo)
    {
        if (! $deal = $dealRepo->getByID($request->get('id'))) {
            abort(404);
        }
        $dealRepo->update($deal->id, [
            'need_shown_notification' => false
        ]);
    }

}
