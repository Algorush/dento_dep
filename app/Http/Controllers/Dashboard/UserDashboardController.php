<?php

namespace App\Http\Controllers\Dashboard;

use App\CustomStyles\CustomContentService;
use App\CustomStyles\CustomStylingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAccountUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Users\User;
use App\Users\UserDashboardPresenter;
use App\Users\UserRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;
use Webmagic\Dashboard\Components\FormPageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Exception;

class UserDashboardController extends Controller
{
    /**
     * Create custom styles for user if fields exist
     *
     * @param Request $request
     * @param User|Model $user
     * @param CustomContentService $customContentService
     * @param CustomStylingService $customStylingService
     */
    protected function createCustomStylesForUser(
        Request $request,
        User $user,
        CustomContentService $customContentService,
        CustomStylingService $customStylingService
    ) {
        if ($request->has('primary_color') || $request->has('header_color') || $request->has('body_color') || $request->has('text_color') || $request->has('background_color') || $request->has('progressbar_color') || $request->has('progressbar_background_color')){
            $customStylingService->createCustomStylingForUser($user ,$request);
        }
        if ($request->has('point_image_1') || $request->has('point_image_2') || $request->has('point_image_3') || $request->has('point_image_4') || $request->has('point_text_header_1') || $request->has('point_text_header_2') || $request->has('point_text_header_3') || $request->has('point_text_header_4')){
            $customContentService->createCustomContentForUser($user, $request);
        }
    }

    /**
     * @param Request $request
     * @param User|Model $user
     * @param CustomContentService $customContentService
     * @param CustomStylingService $customStylingService
     */
    protected function updateCustomStylesForUser(
        Request $request,
        User $user,
        CustomContentService $customContentService,
        CustomStylingService $customStylingService
    ) {
        if ($request->has('primary_color') || $request->has('header_color') || $request->has('body_color') || $request->has('text_color') || $request->has('background_color') || $request->has('progressbar_color') || $request->has('progressbar_background_color')){
            $customStylingService->updateCustomStylingForUser($user, $request);
        }
        if ($request->has('point_image_1') || $request->has('point_image_2') || $request->has('point_image_3') || $request->has('point_image_4') || $request->has('point_text_header_1') || $request->has('point_text_header_2') || $request->has('point_text_header_3') || $request->has('point_text_header_4')) {
            $customContentService->updateCustomContentForUser($user, $request);
        }
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function destroy(int $item_id, UserRepo $userRepo)
    {
        if (! $user = $userRepo->getByID($item_id)) {
            abort(404);
        };

        $userRepo->destroy($user->id);

        return $this->redirect(route('dashboard::sellers.index'));
    }


    /**
     * @param UserDashboardPresenter $dashboardPresenter
     * @return void|FormPageGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function editAccount(UserDashboardPresenter $dashboardPresenter)
    {
        $user = Auth::user();

        return $dashboardPresenter->getEditAccountForm($user);
    }

    /**
     * @param int $item_id
     * @param UserRepo $userRepo
     * @param UserAccountUpdateRequest $request
     * @throws Exception
     */
    public function updateAccount(int $item_id, UserRepo $userRepo, UserAccountUpdateRequest $request)
    {
        if (! $user = $userRepo->getByID($item_id)) {
            return abort(404);
        }

        if (! $userRepo->update($item_id, $request->all())) {
            return abort(500);
        }
    }
}
