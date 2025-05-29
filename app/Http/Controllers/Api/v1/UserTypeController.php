<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTypeRequest;
use App\Services\UserTypeService;

/**
 * @OA\PathItem(path="/api/v1/user-types")
 *
 * @OA\Tag(name="User types", description="Operations related to user types")
 */
class UserTypeController extends Controller
{
    private $userTypeService;

    function __construct(){
        $this->userTypeService = new UserTypeService();
    }

    /**
     * @OA\Get(
     *     tags={"User types"},
     *     path="/api/v1/user-types/{id}",
     *     summary="Show  user type by UUID or ID",
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
        return $this->userTypeService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"User types"},
     *     path="/api/v1/user-types",
     *     summary="List user types",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->userTypeService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"User types"},
     *     path="/api/v1/user-types/page",
     *     summary="List user types pageable",
     *     description="User types a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->userTypeService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"User types"},
     *     path="/api/v1/user-types",
     *     summary="Save user type",
     *     description="Creates and returns a new  user type",
     *     @OA\RequestBody(ref="#/components/requestBodies/ServiceRequest"),
     *     @OA\Response(response=201, description="Service created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(UserTypeRequest $request)
    {
        return $this->userTypeService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"User types"},
     *     path="/api/v1/user-types/{id}",
     *     summary="Update user type",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/ServiceRequest"),
     *     @OA\Response(response=201, description="Service updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(UserTypeRequest $request, $id)
    {
        return $this->userTypeService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"User types"},
     *     path="/api/v1/user-types/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete user type",
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
        $this->userTypeService->delete($id);
        return response()->json([], 204);
    }
}
