<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

abstract class Controller
{
    public function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);

        if (!$imagePath || !File::exists($fullPath)) {

            return false;
        }

        if (File::delete($fullPath)) {
            return true;
        }

        return false;
    }



    /**
     * Upload an image, resize it, and return the path.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string|null $oldImage
     * @param string $folder
     * @param int $width
     * @param int $height
     * @param string $customName
     * @return string|null
     */


    public function uploadImage($image, $oldImage = null, $folder = 'uploads', $width = 150, $height = 150, $customName = 'image')
    {
        if (!$image || !$image->isValid()) {
            return $oldImage;
        }

        // Delete old image if it exists
        if ($oldImage && File::exists(public_path($oldImage))) {
            File::delete(public_path($oldImage));
        }

        // Ensure folder exists
        $folderPath = public_path($folder);
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0775, true);
        }

        // Generate new image name
        $extension = $image->getClientOriginalExtension();
        $imageName = $customName . '-' . uniqid() . '.' . $extension;

        // Full path to save the image
        $imagePath = $folder . '/' . $imageName;
        $fullImagePath = public_path($imagePath);

        // Resize and save image
        Image::make($image)->resize($width, $height)->save($fullImagePath);

        return $imagePath; // Relative path for saving in DB or showing in views
    }


    /**
     * Upload a file to the specified folder.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string|null
     */


    public static function uploadFile($file, $folder)
    {
        try {
            if (!$file || !$file->isValid()) {
                Log::warning('Invalid file upload attempt.');
                return null;
            }

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $targetPath = public_path('uploads/' . $folder);

            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0777, true, true);
            }

            $file->move($targetPath, $fileName);

            return 'uploads/' . $folder . '/' . $fileName;
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate a unique slug for a given name.
     *
     * @param string $name
     * @param string $modelClass
     * @return string
     */


    public function generateUniqueSlug($name, $modelClass)
    {
        $slug = Str::slug($name);
        $count = $modelClass::where('slug', 'LIKE', "$slug%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
