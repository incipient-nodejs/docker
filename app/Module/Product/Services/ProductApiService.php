<?php

namespace App\Module\Product\Services;

use App\Module\Product\Models\ProductApi;

class ProductApiService{

    public function save($data){
        try{
            return ProductApi::create($data);
        }catch(\Exception $e){
            return null;
        }
    }


}
