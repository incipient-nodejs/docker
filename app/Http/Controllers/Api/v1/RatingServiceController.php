<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RatingServiceRequest;
use App\Services\RatingJobService;

/**
 * @OA\PathItem(path="/api/v1/rating-services")
 *
 * @OA\Tag(name="Rating services", description="Operations related to rating services")
 */
class RatingServiceController extends Controller
{
    private $ratingJobService;

    function __construct(){
        $this->ratingJobService = new RatingJobService();
    }

    /**
     * @OA\Get(
     *     tags={"Rating services"},
     *     path="/api/v1/rating-services",
     *     summary="List rating services",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->ratingJobService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Rating services"},
     *     path="/api/v1/rating-services/{id}",
     *     summary="Show account rating services by ID",
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
        return $this->ratingJobService->findById($id);
    }

    /**
     * @OA\Get(
     *     tags={"Rating services"},
     *     path="/api/v1/rating-services/page",
     *     summary="List rating services pageable",
     *     description="Rating services a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->ratingJobService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Rating services"},
     *     path="/api/v1/rating-services",
     *     summary="Save rating of services",
     *     description="Creates and returns a new rating services",
     *     @OA\RequestBody(ref="#/components/requestBodies/RatingServiceRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(RatingServiceRequest $request)
    {
        return $this->ratingJobService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Rating services"},
     *     path="/api/v1/rating-services/{id}",
     *     summary="Update account rating services",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/RatingServiceRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(RatingServiceRequest $request, $id)
    {
        return $this->ratingJobService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Rating services"},
     *     path="/api/v1/rating-services/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete account rating services",
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
        $this->ratingJobService->delete($id);
        return response()->json([], 204);
    }

    public function getUserRatingForService(Request $request){
        $getUserRatingByProduct = $this->ratingJobService->userRatingForService($request->all());
        return response()->json($getUserRatingByProduct, 200);
    }
}
