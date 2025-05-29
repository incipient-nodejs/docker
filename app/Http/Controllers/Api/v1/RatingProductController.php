<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RatingProductRequest;
use App\Services\RatingProductService;
use App\Models\RatingProduct;

/**
 * @OA\PathItem(path="/api/v1/rating-products")
 *
 * @OA\Tag(name="Rating products", description="Operations related to rating products")
 */
class RatingProductController extends Controller
{
    private $ratingProductService;

    function __construct(){
        $this->ratingProductService = new RatingProductService();
    }

    /**
     * @OA\Get(
     *     tags={"Rating products"},
     *     path="/api/v1/rating-products",
     *     summary="List rating products",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->ratingProductService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Rating products"},
     *     path="/api/v1/rating-products/{id}",
     *     summary="Show account rating products by ID",
     *     description="Display a listing by ID",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Search by ID",
     *      @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id)
    {
        return $this->ratingProductService->findById($id);
    }

    /**
     * @OA\Get(
     *     tags={"Rating products"},
     *     path="/api/v1/rating-products/page",
     *     summary="List rating products pageable",
     *     description="Rating products a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->ratingProductService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Rating products"},
     *     path="/api/v1/rating-products",
     *     summary="Save rating of products",
     *     description="Creates and returns a new rating products",
     *     @OA\RequestBody(ref="#/components/requestBodies/RatingProductRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(RatingProductRequest $request)
    {
        return $this->ratingProductService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Rating products"},
     *     path="/api/v1/rating-products/{id}",
     *     summary="Update account rating products",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/RatingProductRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(RatingProductRequest $request, $id)
    {
        return $this->ratingProductService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Rating products"},
     *     path="/api/v1/rating-products/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete account rating products",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Delete by ID",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy($id)
    {
        $this->ratingProductService->delete($id);
        return response()->json([], 204);
    }

    public function countProduct($id)
    {
        $count = RatingProduct::join('products','product_id','products.id')
                ->join('company_data', 'products.user_id', '=', 'company_data.user_id')
                ->where('company_data.id', $id)
                ->count();
        return response()->json((int) $count, 200);
    }

    public function getUserRatingForProduct(Request $request){
        $getUserRatingByProduct = $this->ratingProductService->userRatingForProduct($request);
        return response()->json($getUserRatingByProduct, 200);
    }
}
