<?php


namespace App\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Webmagic\Dashboard\Api\Http\ImagesController as WebmagicImagesController;

class ImagesController extends WebmagicImagesController
{
    /**
     * Upload image
     *
     * @param string  $fieldName
     * @param Request $request
     *
     * @return mixed
     */
    public function upload(string $fieldName, Request $request)
    {
        // For situation when block works with multiple files
        $fieldName = str_replace(['[', ']', '%5B', '%5D'],'',$fieldName);

        $request->validate([
            "$fieldName" => "required"
        ]);

        $file = $request->file($fieldName);
        // For situation when block works with multiple files
        if(is_array($file)){
            $file = array_first($file);
        }

        $real_file_name = $file->getClientOriginalName();
        $file_name = str_replace(' ', '-', $real_file_name);
        $file_name = uniqid(time())."_$file_name";

        $photoPath = config('webmagic.dashboard.dashboard.images_directory');
        $storage = Storage::disk('spaces')->putFileAs($photoPath,$file,$file_name);
        // $path = $file->disk('spaces')->storeAs($photoPath, $file_name, 'public');
        return Storage::disk('spaces')->url($storage);

        // return Storage::url($path);
    }

}
