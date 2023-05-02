<?php

namespace App\Http\Controllers\Dashboard;

use App\CustomStyles\CustomContentService;
use App\CustomStyles\CustomStylingService;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\ImagePathManager;
use App\Services\ImagesPrepare;
use App\Users\Roles\RoleRepo;
use App\Users\UserDashboardPresenter;
use App\Users\UserRepo;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;

class ClientDashboardController extends UserDashboardController
{
    /**
     * @param int|null $seller_id
     * @param UserRepo $userRepo
     * @param Dashboard $dashboard
     * @param Request $request
     * @param UserDashboardPresenter $dashboardPresenter
     * @param RoleRepo $roleRepo
     * @return mixed|Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function index(
        int $seller_id = null,
        UserRepo $userRepo,
        Dashboard $dashboard,
        Request $request,
        UserDashboardPresenter $dashboardPresenter,
        RoleRepo $roleRepo
    ) {
        $role = $roleRepo->getByType('Client');

        if (! $seller_id){
            $seller_id = $request->has('seller_id') ? $request->seller_id : Auth::user()->id;
        }
        $items = $userRepo->getByFilter(
            $role->id,
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1),
            $seller_id
        );

        return $dashboardPresenter->getClientsTablePage($seller_id, $items, $dashboard, $request);
    }

    /**
     * @param UserDashboardPresenter $dashboardPresenter
     * @param Dashboard $dashboard
     * @return FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function create(int $seller_id, UserDashboardPresenter $dashboardPresenter, Dashboard $dashboard)
    {
        return $dashboardPresenter->getCreateUserForm($dashboard, 'Client', $seller_id);
    }

    /**
     * @param Request $request
     * @param UserRepo $userRepo
     * @param CustomStylingService $customStylingService
     * @param CustomContentService $customContentService
     * @param RoleRepo $roleRepo
     * @param ImagesPrepare $imagesPrepare
     * @return Application|ResponseFactory|JsonResponse|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function store(
        UserCreateRequest $request,
        UserRepo $userRepo,
        CustomStylingService $customStylingService,
        CustomContentService $customContentService,
        RoleRepo $roleRepo,
        ImagesPrepare $imagesPrepare
    ) {
        $role = $roleRepo->getByType('Client');

        //Creating By Seller
        if(Auth::user()->isSeller()){
            $data = $request->all();
            $data['role_id'] = $role->id;
            $data['seller_id'] = Auth::user()->id;

            if (! $user = $userRepo->create($data)) {
                return response('Error on creating', 500);
            }

            return $this->redirect(route('dashboard::clients.index'));
        }

        //Creating By Admin
        $data = $imagesPrepare->saveFiles(
            $request->all(),
            ['logo', 'pdf'],
            (new ImagePathManager())->publicPathForUsersImages()
        );

        $data['role_id'] = $role->id;
        $data['seller_id'] = $request->get('seller_id');

        if (! $user = $userRepo->create($data)) {
            return response('Error on creating', 500);
        }

        $this->createCustomStylesForUser($request, $user, $customContentService, $customStylingService);

        return $this->redirect(route('dashboard::clients.index', $data['seller_id']));
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @param UserDashboardPresenter $dashboardPresenter
     * @return void|FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function edit(int $item_id, UserRepo $userRepo, UserDashboardPresenter $dashboardPresenter, Dashboard $dashboard)
    {
        if (! $user = $userRepo->getByID($item_id)) {
            return abort(404);
        }

        return $dashboardPresenter->getEditUserForm($user, 'Client', $dashboard);
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @param UserUpdateRequest $request
     * @param ImagesPrepare $imagesPrepare
     * @param CustomStylingService $customStylingService
     * @param CustomContentService $customContentService
     * @return void
     * @throws Exception
     */
    public function update(
        int $item_id,
        UserRepo $userRepo,
        UserUpdateRequest $request,
        ImagesPrepare $imagesPrepare,
        CustomStylingService $customStylingService,
        CustomContentService $customContentService
    ) {
        if (! $user = $userRepo->getByID($item_id)) {
            return abort(404);
        }

        $data = $imagesPrepare->saveFiles(
            $request->all(),
            ['logo', 'pdf'],
            (new ImagePathManager())->publicPathForUsersImages()
        );

        if (is_null( $request->file('pdf')) && $request->get('delete_pdf_file')){
            $imagesPrepare->deleteLocalFile($user->present()->getLocalPath($user->pdf));

            $data['pdf'] = null;
        }

        if (isset($data['logo']) && $data['logo'] != $user->logo){
            $imagesPrepare->deleteLocalFile($user->present()->getLocalPath($user->logo));
        }

        if (! $userRepo->update($item_id, $data)) {
            return abort(404);
        }

        $this->updateCustomStylesForUser($request, $user, $customContentService, $customStylingService);
    }
}
