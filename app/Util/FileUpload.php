<?php

namespace App\Util;

use Illuminate\Support\Facades\Storage;

class FileUpload{

    private static function uploadStorage($request, &$data, $name, $param, $folder, $path = null){

        if ($request->hasFile($name)) {
            if (isset($path)) {

                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    $parsedPath = parse_url($path, PHP_URL_PATH);
                    $path = str_replace('/storage/', '/', $parsedPath);
                }

                $existingFilePath = Storage::disk('public')->exists($path);
                if ($existingFilePath) Storage::disk('public')->delete($path);
            }

            $file = $request->file($name);
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $fileExtension;
            $filePath = $file->storeAs($folder, $fileName, 'public');

            $domain = request()->getHost();
            $scheme = request()->getScheme();
            $port = request()->getPort();

            if(isset($port)){
                $data[$param] = $scheme . "://" . $domain.":".$port . "/storage/" . $folder . "/" . $fileName;
            }else{
                $data[$param] = $scheme ."://". $domain ."/storage/". $folder. "/". $fileName;
            }
        }
    }

    //     private static function uploadStorage($request, &$data, $name, $param, $folder, $path = null)
    // {
    //     if ($request->hasFile($name)) {
    //         if ($path && filter_var($path, FILTER_VALIDATE_URL)) {
    //             $parsedPath = parse_url($path, PHP_URL_PATH); // /storage/product/images/abc.jpg
    //             $path = ltrim(str_replace('/storage/', '', $parsedPath), '/'); // product/images/abc.jpg

    //             if (Storage::disk('public')->exists($path)) {
    //                 Storage::disk('public')->delete($path);
    //             }
    //         }

    //         $file = $request->file($name);
    //         $fileExtension = $file->getClientOriginalExtension();
    //         $fileName = uniqid() . '.' . $fileExtension;
    //         $filePath = $file->storeAs($folder, $fileName, 'public');

    //         $domain = request()->getHost();
    //         $scheme = request()->getScheme();
    //         $port = request()->getPort();

    //         $data[$param] = $scheme . "://" . $domain.":".$port . "/storage/" . $folder . "/" . $fileName;

    //     }
    // }

    public static function uploadImageUser($request, &$data, $user = null){
        static::uploadStorage($request, $data, 'image', 'image', 'users', $user->image ?? null);
    }

    public static function uploadImageCategory($request, &$data, $category = null){
        static::uploadStorage($request, $data, 'file', 'icon', 'categories', $category->icon ?? null);
    }

    public static function uploadImageService($request, &$data, $service = null){
        static::uploadStorage($request, $data, 'image', 'image', 'service/images', $service->image ?? null);
    }

    public static function uploadVideoService($request, &$data, $service = null){
        static::uploadStorage($request, $data, 'video', 'video', 'service/videos', $service->video ?? null);
    }

    public static function uploadImageProduct($request, &$data, $product = null){
        static::uploadStorage($request, $data, 'image', 'image', 'product/images', $product->image ?? null);
    }

    public static function uploadImageTraseiroProduct($request, &$data, $product = null){
        static::uploadStorage($request, $data, 'image_traseiro', 'image_traseiro', 'product/images_traseiro', $product->image_traseiro ?? null);
    }

    public static function uploadImageEsquerdaProduct($request, &$data, $product = null){
        static::uploadStorage($request, $data, 'image_esquerda', 'image_esquerda', 'product/images_esquerda', $product->image_esquerda ?? null);
    }

    public static function uploadImageDireitaProduct($request, &$data, $product = null){
        static::uploadStorage($request, $data, 'image_direita', 'image_direita', 'product/images_direita', $product->image_direita ?? null);
    }

    public static function uploadVideoProduct($request, &$data, $product = null){
        static::uploadStorage($request, $data, 'video', 'video', 'product/videos', $product->video ?? null);
    }

    public static function uploadDocFormalData($request, &$data, $formaData = null){
        static::uploadStorage($request, $data, 'doc', 'docs', 'formal-type/docs', $formaData->docs ?? null);
    }

    public static function uploadDocInformalData($request, &$data, $formaData = null){
        static::uploadStorage($request, $data, 'doc', 'docs', 'informal-type/docs', $formaData->docs ?? null);
    }

    public static function uploadCertificationCompanyData($request, &$data, $companyData = null){
        static::uploadStorage($request, $data, 'certification', 'doc', 'company-data/certs', $companyData->certification ?? null);
    }

    public static function uploadImageUrlCompanyData($request, &$data, $companyData = null){
        static::uploadStorage($request, $data, 'image_url', 'image_url', 'company-data/logo', $companyData->certification ?? null);
    }

    public static function uploadImageUrlPersonalData($request, &$data, $personalData = null){
        static::uploadStorage($request, $data, 'image', 'image', 'personal-data/logo', $personalData->image ?? null);
    }
}
