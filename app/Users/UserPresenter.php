<?php


namespace App\Users;


use Illuminate\Support\Facades\Storage;
use Webmagic\Core\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function getConfigPath()
    {
        return config('project.users_img_path');
    }

    /**
     * Logo image
     *
     * @return string|null
     */
    public function logo()
    {
        if ($this->entity->logo) {
            return $this->prepareFileURL($this->entity->logo);
        }

        return null;
    }

    /**
     * Pdf path
     *
     * @return string|null
     */
    public function pdf()
    {
        if ($this->entity->pdf) {
            return $this->prepareFileURL($this->entity->pdf);
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

    /**
     * @param $file_name
     * @return string
     */
    public function getLocalPath($file_name)
    {
        return $this->getConfigPath()."/".$file_name;
    }
}
