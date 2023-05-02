<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagePathManager
{
    /**
     * @return mixed
     */
    public function publicPathForUsersImages()
    {
        return Storage::disk('spaces')->path(config('project.users_img_path'));
    }

    /**
     * @return mixed
     */
    public function publicPathForCustomContentImages()
    {
        return Storage::disk('spaces')->path(config('project.custom_content_img_path'));
    }

    /**
     * @return mixed
     */
    public function publicPathForDealsFiles()
    {
        return Storage::disk('spaces')->path(config('project.deal_img_path'));
    }

    /**
     * @return mixed
     */
    public function publicPathForDealsPdf()
    {
        return Storage::disk('spaces')->path(config('project.deal_pdf_path'));
    }
}
