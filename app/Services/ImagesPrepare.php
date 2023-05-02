<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class ImagesPrepare
{

    /**
     * Save images from validated data to directory
     *
     * @param array $data
     * @param array $imageFieldsKeys
     * @param string $dirPath
     *
     * @param bool $withZeroEnding
     * @return array
     */
    public function saveFiles(array $data, array $imageFieldsKeys, string $dirPath, bool $withZeroEnding = true)
    {
        foreach ($imageFieldsKeys as $fieldName) {

            if($withZeroEnding){
                $fieldUpdateKey = $fieldName.'0';
            } else{
                $fieldUpdateKey = $fieldName;
            }

            if (array_has($data, $fieldName)) {
                $file = request()->file($fieldUpdateKey);

                    $real_file_name = $file->getClientOriginalName();
                    $file_name = str_replace(' ', '-', $real_file_name);
                    $file_name = uniqid()."_$file_name";
                    if($fieldName == "pdf")
                        $file_name = uniqid()."_Treatment-Plan.pdf";
                    // print_r($file_name);exit;
                    // $full_file_name = $file->move($dirPath, $file_name)->getFilename();
                    Storage::disk('spaces')->putFileAs($dirPath,$file,$file_name);
                    $data[$fieldName] = $file_name;

            }
        }

        return $data;
    }


    /**
     * Return local disk
     *
     * @return Filesystem
     */
    public function getLocalStorage(): Filesystem
    {
        return Storage::disk('spaces');
    }

    /**
     * @param string $localBasePath
     * @return bool
     */
    public function deleteLocalFile(string $localBasePath)
    {
        if($this->getLocalStorage()->exists($localBasePath)){
            return $this->getLocalStorage()->delete($localBasePath);
        }
    }





}
