<?php

namespace App\Http\Controllers\Dashboard;

use App\Deal\DealRepo;
use App\Deal\DealService;
use App\Http\Controllers\Controller;
use App\Trash\TrashDashboardPresenter;
use App\Users\Roles\RoleRepo;
use App\Users\UserRepo;
use App\Users\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Presenter\Exceptions\PresenterException;
use Webmagic\Core\Controllers\AjaxRedirectTrait;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;
use Webmagic\Dashboard\Components\TableGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard;

class TrashDashboardController extends Controller
{
    use AjaxRedirectTrait;

    /**
     * @param Dashboard $dashboard
     * @return string
     * @throws NoOneFieldsWereDefined
     */
    public function index(
        Dashboard $dashboard,
        UserRepo $userRepo,
        Request $request,
        TrashDashboardPresenter $dashboardPresenter,
        DealRepo $dealRepo,
        RoleRepo $roleRepo
    ) {
        $sellersTab =  $this->getSellersTable($roleRepo, $request, $userRepo, $dashboardPresenter);
        $clientsTab =  $this->getClientsTable($roleRepo, $request, $userRepo, $dashboardPresenter);
        $casesTab = $this->getCasesTable($request, $dealRepo, $dashboardPresenter);

        $dashboard
            ->page()->addTitle('tets')
            ->addElement()->tabs()
            ->addElement('tabs')->tab()->title('Sellers')->active(true)
            ->content($sellersTab->render())
            ->parent('tabs')
            ->addElement('tabs')->tab()->title('Clients')
            ->content($clientsTab)
            ->parent('tabs')
            ->addElement('tabs')->tab()->title('Cases')
            ->content($casesTab->render());


        if ($request->ajax()) {
            $tab = $request->get('tab');
            switch ($tab){
                case 'client':
                    $content = $clientsTab->render();
                    break;
                case 'case':
                    $content = $casesTab->render();
                    break;
                case 'seller':
                default:
                    $content = $sellersTab->render();
            }

            return $content;

        }

        return $dashboard;
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @return JsonResponse|RedirectResponse|Redirector|void
     * @throws Exception
     */
    public function restoreUser(int $item_id, UserRepo $userRepo)
    {
        if (! $user = $userRepo->getByID($item_id, true)) {
            return abort(404);
        }

        if ($user->isClient()){
            if (! $seller = $userRepo->getByID($user->seller_id)) {
                return response()->json(
                    ['message'=> 'Can\'t restore the customer because his Seller does not exist'], 500);
            }
        }

        $user->restore();

        return $this->redirect(route('dashboard::trash.index'));
    }

    /**
     * @param int $item_id
     * @param DealRepo $dealRepo
     * @param UserRepo $userRepo
     * @return JsonResponse|RedirectResponse|Redirector|void
     * @throws Exception
     */
    public function restoreCase(int $item_id, DealRepo $dealRepo, UserRepo $userRepo)
    {
        if (! $deal = $dealRepo->getByID($item_id, true)) {
            return abort(404);
        }

        if (! $user = $userRepo->getByID($deal->client_id)) {
            return response()->json(
                ['message'=> 'Can\'t restore the case because his Client does not exist'], 500);
        }

        $deal->restore();

        return $this->redirect(route('dashboard::trash.index'));
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @param UserService $userService
     * @return JsonResponse|RedirectResponse|Redirector|void
     * @throws PresenterException
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function destroyUser(int $item_id, UserRepo $userRepo, UserService $userService)
    {
        if (! $user = $userRepo->getByID($item_id, true)) {
            return abort(404);
        }

        $userService->realDestroy($user);

        return $this->redirect(route('dashboard::trash.index'));
    }

    /**
     * @param int $item_id
     * @param DealRepo $dealRepo
     * @param DealService $dealService
     * @return JsonResponse|RedirectResponse|Redirector|void
     * @throws PresenterException
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function destroyCase(int $item_id, DealRepo $dealRepo, DealService $dealService)
    {
        if (! $deal = $dealRepo->getByID($item_id, true)) {
            return abort(404);
        }

        $dealService->realDestroy($deal);

        return $this->redirect(route('dashboard::trash.index'));
    }

    /**
     * @param Request $request
     * @param DealRepo $dealRepo
     * @param TrashDashboardPresenter $dashboardPresenter
     * @return TableGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getCasesTable(Request $request, DealRepo $dealRepo, TrashDashboardPresenter $dashboardPresenter)
    {
        $cases = $dealRepo->getByFilter(
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1),
            null,
            null,
            null,
            null,
            'deleted_at',
            'desc',
            true
        );

        return  $dashboardPresenter->getCasesTable($cases, $request);
    }


    /**
     * @param RoleRepo $roleRepo
     * @param Request $request
     * @param UserRepo $userRepo
     * @param TrashDashboardPresenter $dashboardPresenter
     * @return TableGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getSellersTable(
        RoleRepo $roleRepo,
        Request $request,
        UserRepo $userRepo,
        TrashDashboardPresenter $dashboardPresenter
    ) {
        $role = $roleRepo->getByType('Seller');

        $sellers = $userRepo->getByFilter(
            $role->id,
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1),
            null,
            null,
            null,
            'deleted_at',
            'desc',
            true
        );

        return  $dashboardPresenter->getSellersTable($sellers, $request);
    }

    /**
     * @param RoleRepo $roleRepo
     * @param Request $request
     * @param UserRepo $userRepo
     * @param TrashDashboardPresenter $dashboardPresenter
     * @return TableGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getClientsTable(
        RoleRepo $roleRepo,
        Request $request,
        UserRepo $userRepo,
        TrashDashboardPresenter $dashboardPresenter
    ) {
        $role = $roleRepo->getByType('Client');

        $clients = $userRepo->getByFilter(
            $role->id,
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1),
            null,
            null,
            null,
            'deleted_at',
            'desc',
            true
        );

        return  $dashboardPresenter->getClientsTable($clients, $request);
    }
}
