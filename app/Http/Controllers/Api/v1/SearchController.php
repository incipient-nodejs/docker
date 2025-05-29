<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\ApiSyncProductService;
use App\Services\Util\SearchProductService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Services\JobService;
use Illuminate\Http\Request;
use App\Models\ApiEndpoint;
use App\Models\Product;
use App\Util\Auditor;

/**
 * @OA\PathItem(path="/api/v1/search")
 *
 * @OA\Tag(name="Search", description="Operations related with search of product and service")
 */
class SearchController extends Controller
{

    function __construct(){
        $this->apiSyncProductService = new ApiSyncProductService();
        $this->searchProductService = new SearchProductService();
        $this->jobService = new JobService();
    }

    /**
     * @OA\Get(
     *     tags={"Search"},
     *     path="/api/v1/search/product/{text}",
     *     summary="Search product",
     *     description="Search product by text",
     *     @OA\Parameter(
     *      name="text",
     *      in="path",
     *      required=true,
     *      description="Inform text for search",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function searchProduct(Request $request,  $text){
        return $this->searchProductService->search($request, $text);
    }

    public function listProduct(Request $request){
        return $this->apiSyncProductService->getProduct($request);
    }

    /**
     * @OA\Get(
     *     tags={"Search"},
     *     path="/api/v1/search/service/{text}",
     *     summary="Search service",
     *     description="Search service by text",
     *     @OA\Parameter(
     *      name="text",
     *      in="path",
     *      required=true,
     *      description="Inform text for search",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function searchService($text){
        return $this->jobService->search($text);
    }
}
