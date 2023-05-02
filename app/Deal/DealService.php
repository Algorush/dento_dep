<?php

namespace App\Deal;

use App\Services\ImagesPrepare;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\Exceptions\PresenterException;
use Webmagic\Core\Entity\Exceptions\EntityNotExtendsModelException;
use Webmagic\Core\Entity\Exceptions\ModelNotDefinedException;

class DealService
{
    /**
     * @var DealRepo
     */
    protected $dealRepo;

    /**
     * @var ImagesPrepare
     */
    protected $imagesPrepare;

    /**
     * DealService constructor.
     *
     * @param DealRepo $dealRepo
     * @param ImagesPrepare $imagesPrepare
     */
    public function __construct(DealRepo $dealRepo, ImagesPrepare $imagesPrepare)
    {
        $this->dealRepo = $dealRepo;
        $this->imagesPrepare = $imagesPrepare;
    }

    /**
     * Force delete deal and his related files
     *
     * @param Deal|Model $deal
     * @throws PresenterException
     * @throws EntityNotExtendsModelException
     * @throws ModelNotDefinedException
     */
    public function realDestroy(Deal $deal)
    {
        $this->deleteRelatedFiles($deal->upperFiles);
        $this->deleteRelatedFiles($deal->lowerFiles);

        $deal->upperFiles()->delete();
        $deal->lowerFiles()->delete();
        $deal->forceDelete();
    }

    /**
     * Delete files from storage
     *
     * @param Collection $files
     */
    protected function deleteRelatedFiles(Collection $files)
    {
        foreach ($files as $file){
            $this->imagesPrepare->deleteLocalFile($file->present()->getLocalPath());
        }
    }

}
