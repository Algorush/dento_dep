<?php


namespace App\Deal;


use Illuminate\Support\Facades\Storage;
use Webmagic\Core\Presenter\Presenter;

class DealPresenter extends Presenter
{
    public function getConfigPath()
    {
        return config('project.deal_pdf_path');
    }

    /**
     * Wear count
     *
     * @return string|null
     */
    public function wear_count()
    {
        if ($this->entity->wear_count) {
            return strval($this->entity->wear_count);
        }
        return null;
    }

    /**
     * Wear count
     *
     * @return string|null
     */
    public function wear_times_of_day()
    {
        if ($this->entity->wear_times_of_day) {
            return strval($this->entity->wear_times_of_day);
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
     * Ipr path
     *
     * @return string|null
     */
    public function ipr()
    {
        if ($this->entity->ipr) {
            return $this->prepareFileURL($this->entity->ipr);
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


    /**
     * @return string
     */
    public function routeForCaseView()
    {
        $clientName = str_replace(' ', '-', $this->entity->client->name ?? $this->entity->seller->name);
        $customerName = str_replace(' ','-', $this->entity->name);
        $hash = $customerName . '-' . $this->entity->uniqid;

        return route('case.index', [$clientName, $hash]);
    }
}
