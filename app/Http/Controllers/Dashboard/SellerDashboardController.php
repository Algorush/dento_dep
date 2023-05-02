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
use Illuminate\Http\Request;
use Webmagic\Dashboard\Dashboard;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;

class SellerDashboardController extends UserDashboardController
{
    /**
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
        UserRepo $userRepo,
        Dashboard $dashboard,
        Request $request,
        UserDashboardPresenter $dashboardPresenter,
        RoleRepo $roleRepo
    ) {
        $role = $roleRepo->getByType('Seller');

        $items = $userRepo->getByFilter(
            $role->id,
            $request->get('keyword', ''),
            $request->get('items', 10),
            $request->get('page', 1)
        );

        return $dashboardPresenter->getSellersTablePage($items, $dashboard, $request);
    }

    /**
     * @param UserDashboardPresenter $dashboardPresenter
     * @param Dashboard $dashboard
     * @return Dashboard
     */
    public function create(UserDashboardPresenter $dashboardPresenter, Dashboard $dashboard)
    {
        return $dashboardPresenter->getCreateUserForm($dashboard, 'Seller');
    }

    /**
     * @param UserCreateRequest $request
     * @param UserRepo $userRepo
     * @param RoleRepo $roleRepo
     * @param ImagesPrepare $imagesPrepare
     * @param CustomStylingService $customStylingService
     * @param CustomContentService $customContentService
     * @return Application|ResponseFactory|JsonResponse|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function store(
        UserCreateRequest $request,
        UserRepo $userRepo,
        RoleRepo $roleRepo,
        ImagesPrepare $imagesPrepare,
        CustomStylingService $customStylingService,
        CustomContentService $customContentService
    ) {
        $data = $imagesPrepare->saveFiles(
            $request->all(),
            ['logo', 'pdf'],
            (new ImagePathManager())->publicPathForUsersImages()
        );

        $role = $roleRepo->getByType('Seller');
        $data['role_id'] = $role->id;

        if (! $user = $userRepo->create($data)) {
            return response('Error on creating', 500);
        }

       $this->createCustomStylesForUser($request, $user, $customContentService, $customStylingService);

        return $this->redirect(route('dashboard::sellers.index'));
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @param UserDashboardPresenter $dashboardPresenter
     * @param Dashboard $dashboard
     * @return void|FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws Exception
     */
    public function edit(int $item_id, UserRepo $userRepo, UserDashboardPresenter $dashboardPresenter, Dashboard $dashboard)
    {
        if (! $user = $userRepo->getByID($item_id)) {
            return abort(404);
        }

        return $dashboardPresenter->getEditUserForm($user, 'Seller', $dashboard);
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
            return abort(500);
        }

        $this->updateCustomStylesForUser($request, $user, $customContentService, $customStylingService);
    }
}
