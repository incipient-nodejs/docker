<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProductService;
use App\Services\UserService;
use App\Services\JobService;

/**
 * @OA\PathItem(path="/api/v1/product-service/find-by-user")
 *
 * @OA\Tag(name="Product and Service", description="Operations related product and services")
 */
class ProductServiceController extends Controller
{
    private $productService;
    private $userService;
    private $jobService;

    function __construct(){
        $this->productService = new ProductService();
        $this->userService = new UserService();
        $this->jobService = new JobService();
    }

    /**
     * @OA\Get(
     *     tags={"Product and Service"},
     *     path="/api/v1/product-service/find-by-user/{id}",
     *     summary="Get products and service created por user",
     *     description="Display a listing products or services created by user",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Inform by UUID or ID of user",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function getProductAndService($id){
        $user = $this->userService->findByIdOrUuid($id);
        return (object)[
            "products" => $this->productService->findAllByUser($user),
            "services" => $this->jobService->findAllByUser($user),
        ];
    }
}
