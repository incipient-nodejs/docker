<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Services\JobService;

/**
 * @OA\PathItem(path="/api/v1/services")
 *
 * @OA\Tag(name="Services", description="Operations related to services")
 */
class ServiceController extends Controller
{
    private $jobService;

    function __construct(){
        $this->jobService = new JobService();
    }

    /**
     * @OA\Get(
     *     tags={"Services"},
     *     path="/api/v1/services",
     *     summary="List services",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->jobService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Services"},
     *     path="/api/v1/services/{id}",
     *     summary="Show service by UUID or ID",
     *     description="Display a listing by UUID or ID",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Search by UUID or ID",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id)
    {
        return $this->jobService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Services"},
     *     path="/api/v1/services/page",
     *     summary="List services pageable",
     *     description="Services a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->jobService->paginate();
    }

    /**
     * @OA\Get(
     *     tags={"Services"},
     *     path="/api/v1/services/find-by-category/{id}",
     *     summary="Display services by category",
     *     description="Display a services",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Search by UUID or ID of category",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function paginateCategory($id)
    {
        return $this->jobService->paginateCategory($id);
    }

    /**
     * @OA\Get(
     *     tags={"Services"},
     *     path="/api/v1/services/search/{search}",
     *     summary="Search service",
     *     description="Search service by text",
     *     @OA\Parameter(
     *      name="search",
     *      in="path",
     *      required=true,
     *      description="Search service",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function search($search)
    {
        return $this->jobService->search($search);
    }

    /**
     * @OA\Post(
     *     tags={"Services"},
     *     path="/api/v1/services",
     *     summary="Save service",
     *     description="Creates and returns a new service",
     *     @OA\RequestBody(ref="#/components/requestBodies/ServiceRequest"),
     *     @OA\Response(response=201, description="Service created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(ServiceRequest $request)
    {
        $request->validate(['user_id' => 'required', 'category_id'  => 'required']);
        return $this->jobService->create($request, $request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Services"},
     *     path="/api/v1/services/{id}",
     *     summary="Update service",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/ServiceRequest"),
     *     @OA\Response(response=201, description="Service updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(ServiceRequest $request, $id)
    {
        return $this->jobService->update($request, $request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Services"},
     *     path="/api/v1/services/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete service",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Delete by UUID or ID",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy($id)
    {
        $this->jobService->delete($id);
        return response()->json([], 204);
    }
}
