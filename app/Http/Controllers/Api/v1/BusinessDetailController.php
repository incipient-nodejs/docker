<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\BusinessDetailRequest;
use App\Services\BusinessDetailService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/business-details")
 *
 * @OA\Tag(name="Business Details", description="Operations related to business details")
 */
class BusinessDetailController extends Controller
{
    private $businessDetailService;

    function __construct(){
        $this->businessDetailService = new BusinessDetailService();
    }

        /**
     * @OA\Get(
     *     tags={"Business Details"},
     *     path="/api/v1/business-details/{id}",
     *     summary="Show business detail by ID",
     *     description="Display a listing by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Search by ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id)
    {
        return $this->businessDetailService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Business Details"},
     *     path="/api/v1/business-details",
     *     summary="List business details",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->businessDetailService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Business Details"},
     *     path="/api/v1/business-details/page",
     *     summary="List business details pageable",
     *     description="Business details listing pageable",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->businessDetailService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Business Details"},
     *     path="/api/v1/business-details",
     *     summary="Create business detail",
     *     description="Creates and returns a new business detail",
     *     @OA\RequestBody(ref="#/components/requestBodies/BusinessDetailRequest"),
     *     @OA\Response(response=201, description="Business detail created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(BusinessDetailRequest $request)
    {
        $request->validate(['user_id' => 'required']);
        return $this->businessDetailService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Business Details"},
     *     path="/api/v1/business-details/{id}",
     *     summary="Update business detail",
     *     description="Update the specified business detail",
     *     @OA\Parameter(
     *         name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/BusinessDetailRequest"),
     *     @OA\Response(response=201, description="Business detail updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function update(BusinessDetailRequest $request, $id)
    {
        return $this->businessDetailService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Business Details"},
     *     path="/api/v1/business-details/{id}",
     *     summary="Delete business detail",
     *     description="Remove the specified business detail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Delete by ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Deleted"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy($id)
    {
        $this->businessDetailService->delete($id);
        return response()->json([], 204);
    }
}
