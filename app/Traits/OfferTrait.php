<?php
namespace App\Traits;

trait OfferTrait
{
    protected function saveImage($photo, $folder)
    {
        //save photo in folder offers
        $file_extension = $photo->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $path = $folder;
        $photo->move($path, $file_name);
        return $file_name;
    }

}