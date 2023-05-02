<?php

namespace App\Deal;

use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Storage;
use Webmagic\Core\Presenter\Presenter as CorePresenter;

class UpperAndLowerFilePresenter extends CorePresenter
{
    /**
     * @return Repository|mixed
     */
    public function getConfigPath()
    {
        return config('project.deal_img_path');
    }

    /**
     * @param $file_name
     * @return string
     */
    public function getLocalPath()
    {
        return $this->getConfigPath() . "/" . $this->entity->file_path;
    }

    /**
     * Pdf path
     *
     * @return string|null
     */
    public function file()
    {
        if ($this->entity->file_path) {
            return $this->prepareFileURL($this->entity->file_path);
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
    protected function prepareFileURL($file_name)
    {
        return Storage::disk('spaces')->url($this->getConfigPath()."/".$file_name);
    }

}
