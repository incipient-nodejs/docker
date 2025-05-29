<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormalTypeRequest;
use App\Services\FormalTypeService;
use App\Services\Mobile\FormalTypeService as FormalTypeMobileService;

/**
 * @OA\PathItem(path="/api/v1/formal-types")
 *
 * @OA\Tag(name="Formal Type", description="Operations related to formal types")
 */
class FormalTypeController extends Controller
{
    private $formalTypeService;
    private $formalTypeMobileService;

    function __construct(){
        $this->formalTypeService = new FormalTypeService();
        $this->formalTypeMobileService = new FormalTypeMobileService();
    }

    /**
     * @OA\Get(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types",
     *     summary="List formal-types",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->formalTypeService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types/{id}",
     *     summary="Show account formal type by ID",
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
        return $this->formalTypeService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types/page",
     *     summary="List formal-types pageable",
     *     description="Formal Type a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->formalTypeService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types",
     *     summary="Save account formal type",
     *     description="Creates and returns a new account formal type",
     *     @OA\RequestBody(ref="#/components/requestBodies/FormalTypeRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(FormalTypeRequest $request)
    {
        $request->validate(['user_id' => 'required']);
        return $this->formalTypeService->create($request->all());
    }

    /**
     * @OA\Post(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types/store-mob",
     *     summary="Save account formal type, route for application mobile",
     *     description="Creates and returns a new account formal type",
     *     @OA\RequestBody(ref="#/components/requestBodies/FormalTypeRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function storeMobile(FormalTypeRequest $request)
    {
        $request->validate(['user_id' => 'required']);
        return $this->formalTypeMobileService->create($request, $request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types/{id}",
     *     summary="Update account formal type",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/FormalTypeRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(FormalTypeRequest $request, $id)
    {
        return $this->formalTypeService->update($request, $request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Formal Type"},
     *     path="/api/v1/formal-types/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete account formal type",
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
        $this->formalTypeService->delete($id);
        return response()->json([], 204);
    }
}
