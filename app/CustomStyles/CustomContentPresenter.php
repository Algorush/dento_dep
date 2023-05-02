<?php

namespace App\CustomStyles;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Storage;
use Webmagic\Core\Presenter\Presenter as CorePresenter;

class CustomContentPresenter extends CorePresenter
{
    /**
     * @return Repository|mixed
     */
    public function getConfigPath()
    {
        return config('project.custom_content_img_path');
    }

    /**
     * @return string|null
     */
    public function image_1()
    {
        if($this->entity->point_image_1){
            return $this->prepareImageURL($this->entity->point_image_1);
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function image_2()
    {
        if($this->entity->point_image_2){
            return $this->prepareImageURL($this->entity->point_image_2);
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function image_3()
    {
        if($this->entity->point_image_3){
            return $this->prepareImageURL($this->entity->point_image_3);
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function image_4()
    {
        if($this->entity->point_image_4){
            return $this->prepareImageURL($this->entity->point_image_4);
        }
        return null;
    }

    /**
     * Prepare url for images
     *
     * @param $file_name
     *
     * @return string
     */
    protected function prepareImageURL($file_name)
    {
        return Storage::disk('spaces')->url($this->getConfigPath()."/".$file_name);
    }

    /**
     * @param $file_name
     * @return string
     */
    public function getLocalPath($file_name)
    {
        return $this->getConfigPath()."/".$file_name;
    }
}
