<?php

namespace App\Services\Util;

use App\Util\Auditor;
use App\Models\ApiType;
use Database\Seeders\ApiTypeSeeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Util\FileUpload;

class ApiTypeService
{

    function __construct(){
    }

    public function findApiTypeProductOrFail(): ApiType {
        $code = ApiTypeSeeder::API_TYPE_PRODUCT['code'];
        return ApiType::where('code', $code)->firstOrFail();
    }


}
