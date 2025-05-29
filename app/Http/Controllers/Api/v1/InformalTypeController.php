<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InformalTypeRequest;
use App\Services\InformalTypeService;
use App\Services\Mobile\InformalTypeService as InformalTypeMobileService;

/**
 * @OA\PathItem(path="/api/v1/informal-types")
 *
 * @OA\Tag(name="Informal Type", description="Operations related to informal Types")
 */
class InformalTypeController extends Controller
{
    private $informalTypeService;
    private $informalTypeMobileService;

    function __construct(){
        $this->informalTypeService = new InformalTypeService();
        $this->informalTypeMobileService = new InformalTypeMobileService();
    }

    /**
     * @OA\Get(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types/{id}",
     *     summary="Show account informal Type by ID",
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
        return $this->informalTypeService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types",
     *     summary="List informal-types",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->informalTypeService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types/page",
     *     summary="List informal-types pageable",
     *     description="Informal Type a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->informalTypeService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types",
     *     summary="Save account informal Type",
     *     description="Creates and returns a new account informal Type",
     *     @OA\RequestBody(ref="#/components/requestBodies/InformalTypeRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(InformalTypeRequest $request)
    {
        $request->validate(['user_id' => 'required']);
        return $this->informalTypeService->create($request->all());
    }

    /**
     * @OA\Post(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types/store-mob",
     *     summary="Save account informal Type, route for application mobile",
     *     description="Creates and returns a new account informal Type",
     *     @OA\RequestBody(ref="#/components/requestBodies/InformalTypeRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function storeMobile(InformalTypeRequest $request)
    {
        $request->validate(['user_id' => 'required']);
        return $this->informalTypeMobileService->create($request, $request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types/{id}",
     *     summary="Update account informal Type",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/InformalTypeRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(InformalTypeRequest $request, $id)
    {
        return $this->informalTypeService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Informal Type"},
     *     path="/api/v1/informal-types/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete account informal Type",
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
        $this->informalTypeService->delete($id);
        return response()->json([], 204);
    }
}
