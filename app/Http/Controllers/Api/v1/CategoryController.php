<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;

/**
 * @OA\PathItem(path="/api/v1/categories")
 *
 * @OA\Tag(name="Categories", description="Operations related to categories")
 */
class CategoryController extends Controller
{
    private $categoryService;

    function __construct(){
        $this->categoryService = new CategoryService();
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/v1/categories",
     *     summary="List categories",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->categoryService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/v1/categories/{id}",
     *     summary="Show category by UUID or ID",
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
        return $this->categoryService->findByUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/v1/categories/products",
     *     summary="List categories of products",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function findAllProduct()
    {
        return $this->categoryService->findAllProduct();
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/v1/categories/services",
     *     summary="List categories of service",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function findAllService()
    {
        return $this->categoryService->findAllService();
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/v1/categories/suppliers",
     *     summary="List categories of suppliers",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function findAllSupplier()
    {
        return $this->categoryService->findAllSupplier();
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/v1/categories/page",
     *     summary="List categories pageable",
     *     description="Categories a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->categoryService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Categories"},
     *     path="/api/v1/categories",
     *     summary="Save service",
     *     description="Creates and returns a new category",
     *     @OA\RequestBody(ref="#/components/requestBodies/CategoryRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(CategoryRequest $request)
    {
        return $this->categoryService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Categories"},
     *     path="/api/v1/categories/{id}",
     *     summary="Update category",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/CategoryRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(CategoryRequest $request, string $id)
    {
        return $this->categoryService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Categories"},
     *     path="/api/v1/categories/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete category",
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
    public function destroy(string $id)
    {
        $this->categoryService->delete($id);
        return response()->json([], 204);
    }
}
