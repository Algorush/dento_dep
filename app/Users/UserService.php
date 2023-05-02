<?php

namespace App\Users;

use App\CustomStyles\CustomContent;
use App\CustomStyles\CustomContentRepo;
use App\CustomStyles\CustomStylingRepo;
use App\Deal\Deal;
use App\Deal\DealService;
use App\Services\ImagesPrepare;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\Exceptions\PresenterException;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;

class UserService
{
    /**
     * @var UserRepo
     */
    protected $userRepo;

    /**
     * @var ImagesPrepare
     */
    protected $imagesPrepare;

    /**
     * @var DealService
     */
    protected $dealService;

    /**
     * UserService constructor.
     *
     * @param UserRepo $userRepo
     * @param ImagesPrepare $imagesPrepare
     * @param DealService $dealService
     */
    public function __construct(UserRepo $userRepo, ImagesPrepare $imagesPrepare, DealService $dealService)
    {
        $this->userRepo = $userRepo;
        $this->imagesPrepare = $imagesPrepare;
        $this->dealService = $dealService;
    }

    /**
     * Force delete user and his custom styles and content
     *
     * @param User|Model $user
     * @throws PresenterException
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function realDestroy(User $user)
    {
        $this->deleteRelatedCustomStyles($user);

        $this->imagesPrepare->deleteLocalFile($user->present()->getLocalPath($user->logo));
        $this->imagesPrepare->deleteLocalFile($user->present()->getLocalPath($user->pdf));

        if ($user->isSeller()){
            foreach ($user->clients()->withTrashed()->get() as $client){
                $this->realDestroy($client);
            }
        }
        if ($user->isClient()){
            $this->deleteRelatedCases($user);
        }
        $user->forceDelete();
    }

    /**
     * @param User $user
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    protected function deleteRelatedCustomStyles(User $user)
    {
        $contentRepo = new CustomContentRepo();
        $stylingRepo = new CustomStylingRepo();

        $customContent = $contentRepo->getByUserID($user->id);

        if (! is_null($customContent)) {
            for ($i = 1; $i <= 4; $i++) {
                if ($customContent->{"point_image_$i"}) {
                    $this->imagesPrepare->deleteLocalFile($customContent->present()->getLocalPath($customContent->{"point_image_$i"}));
                }
            }
            $contentRepo->destroy($customContent->id);
        }

        $customStyling = $stylingRepo->getByUserID($user->id);
        if (! is_null($customStyling)) {
            $stylingRepo->destroy($customStyling->id);
        }
    }

    /**
     * @param User $user
     */
    protected function deleteRelatedCases(User $user)
    {
        $deals = $user->cases()->withTrashed()->get();
        foreach ($deals as $deal){
            $this->dealService->realDestroy($deal);
        }
    }

    /**
     * Prepare custom styling and content for user.
     * If user is client and he has his own unique styles, they will be used.
     * If hasn't, check styles for seller and if he has own styles, they will be used
     *
     * @param Model|User $user
     * @param Model|Deal $deal
     * @return array
     * @throws PresenterException
     */
    public function getActualStylesForClient(Model $deal, Model $user)
    {
        if ($user->isClient()) {
            $seller = $user->seller;
            $clientStyling = $user->customStyling;
            $clientContent = $user->customContent;
            $title = $user->name;
        } else{
            $seller = $user;
            $clientStyling = null;
            $clientContent = null;
            $title = $seller->name;
        }

        $sellerStyling = $seller->customStyling;
        $sellerContent = $seller->customContent;

        $styles = [
            'body_color' => $clientStyling->body_color ?? $sellerStyling->body_color ?? null,
            'header_color' => $clientStyling->header_color ?? $sellerStyling->header_color ?? null,
            'primary_color' => $clientStyling->primary_color ?? $sellerStyling->primary_color ?? null,
            'text_color' => $clientStyling->text_color ?? $sellerStyling->text_color ?? null,
            'background_color' => $clientStyling->background_color ?? $sellerStyling->background_color ?? null,
            'progressbar_color' => $clientStyling->progressbar_color ?? $sellerStyling->progressbar_color ?? null,
            'progressbar_background_color' => $clientStyling->progressbar_background_color ?? $sellerStyling->progressbar_background_color ?? null,
            'custom_css' => $user->custom_css ?? $seller->cusom_css ?? null,
            'logo' => $user->present()->logo ?? $seller->present()->logo ?? null,
            'logo_width' => $user->logo_width ?? $seller->logo_width ?? null,
            'logo_height' => $user->logo_height ?? $seller->logo_height ?? null,
            'pdf' => $deal->present()->pdf ?? $user->present()->pdf ?? $seller->present()->pdf ?? null,
            'ipr' => $deal->present()->ipr ?? $user->present()->ipr ?? $seller->present()->ipr ?? null,
            'wear_count' => $deal->present()->wear_count ?? $user->present()->wear_count ?? $seller->present()->wear_count ?? null,
            'wear_times_of_day' => $deal->present()->wear_times_of_day ?? $user->present()->wear_times_of_day ?? $seller->present()->wear_times_of_day ?? null,
            'point_image_1' => $this->findExistedCustomContentImage('image_1', $clientContent, $sellerContent),
            'point_text_1' => $clientContent->point_text_1 ?? $sellerContent->point_text_1 ?? null,
            'point_image_2' => $this->findExistedCustomContentImage('image_2', $clientContent, $sellerContent),
            'point_text_2' => $clientContent->point_text_2 ?? $sellerContent->point_text_2 ?? null,
            'point_image_3' => $this->findExistedCustomContentImage('image_3', $clientContent, $sellerContent),
            'point_text_3' => $clientContent->point_text_3 ?? $sellerContent->point_text_3 ?? null,
            'point_image_4' => $this->findExistedCustomContentImage('image_4', $clientContent, $sellerContent),
            'point_text_4' => $clientContent->point_text_4 ?? $sellerContent->point_text_4 ?? null,
            'point_text_header_1' => $clientContent->point_text_header_1 ?? $sellerContent->point_text_header_1 ?? null,
            'point_text_header_2' => $clientContent->point_text_header_2 ?? $sellerContent->point_text_header_2 ?? null,
            'point_text_header_3' => $clientContent->point_text_header_3 ?? $sellerContent->point_text_header_3 ?? null,
            'point_text_header_4' => $clientContent->point_text_header_4 ?? $sellerContent->point_text_header_4 ?? null,
            'title' => $title,
            'client_name' => strtoupper($deal->name),
        ];

        return $styles;
    }

    /**
     * @param string $field_name
     * @param CustomContent|null $clientContent
     * @param CustomContent|null $sellerContent
     * @return string|null
     * @throws PresenterException
     */
    protected function findExistedCustomContentImage(
        string $field_name,
        CustomContent $clientContent = null,
        CustomContent $sellerContent = null
    ) {

        if (! is_null($clientContent) && ! is_null($clientContent->present()->{$field_name})) {
            return $clientContent->present()->{$field_name};
        } elseif (! is_null($sellerContent) && ! is_null($sellerContent->present()->{$field_name})) {
            return $sellerContent->present()->{$field_name};
        }

        return null;
    }
}
