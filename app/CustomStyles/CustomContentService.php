<?php

namespace App\CustomStyles;


use App\Services\ImagePathManager;
use App\Services\ImagesPrepare;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Http\Request;
use Laracasts\Presenter\Exceptions\PresenterException;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;

class CustomContentService
{
    /**
     * @var CustomContentRepo
     */
    protected $stylingRepo;

    /**
     * @var ImagesPrepare
     */
    protected $imagesPrepare;

    /**
     * CustomContentService constructor.
     *
     * @param CustomContentRepo $contentRepo
     * @param ImagesPrepare $imagesPrepare
     */
    public function __construct(CustomContentRepo $contentRepo, ImagesPrepare $imagesPrepare)
    {
        $this->contentRepo = $contentRepo;
        $this->imagesPrepare = $imagesPrepare;
    }


    public function createCustomContentForUser(Model $user, Request $request)
    {
        $data = $this->imagesPrepare->saveFiles(
            $request->all(),
            ['point_image_1', 'point_image_2', 'point_image_3', 'point_image_4'],
            (new ImagePathManager())->publicPathForCustomContentImages()
        );

        $this->contentRepo->create([
            'point_image_1' => $data['point_image_1'] ?? null,
            'point_text_1'  => $request->get('point_text_1', null),
            'point_image_2' => $data['point_image_2'] ?? null,
            'point_text_2'  => $request->get('point_text_2', null),
            'point_image_3' => $data['point_image_3'] ?? null,
            'point_text_3'  => $request->get('point_text_3', null),
            'point_image_4' => $data['point_image_4'] ?? null,
            'point_text_4'  => $request->get('point_text_4', null),
            'point_text_header_1'  => $request->get('point_text_header_1', null),
            'point_text_header_2'  => $request->get('point_text_header_2', null),
            'point_text_header_3'  => $request->get('point_text_header_3', null),
            'point_text_header_4'  => $request->get('point_text_header_4', null),
            'user_id' => $user->id
        ]);
    }

    public function updateCustomContentForUser(Model $user, Request $request)
    {
        $customContent = $this->contentRepo->getByUserID($user->id);

        if (is_null($customContent)) {
            $this->createCustomContentForUser($user, $request);
        } else {
            $data = $this->imagesPrepare->saveFiles($request->all(), [
                'point_image_1',
                'point_image_2',
                'point_image_3',
                'point_image_4',
            ], (new ImagePathManager())->publicPathForCustomContentImages());

            for ($i = 1; $i <= 4; $i++) {
                if (isset($data["point_image_$i"]) && $data["point_image_$i"] != $customContent->{"point_image_$i"}) {
                    $this->imagesPrepare->deleteLocalFile($customContent->present()->getLocalPath($customContent->{"point_image_$i"}));
                }
            }
            $this->contentRepo->update($customContent->id, $data);
        }
    }
}
