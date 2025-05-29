<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Service;
use App\Util\Auditor;
use Illuminate\Support\Facades\DB;

/**
 * @OA\PathItem(path="/api/v1/products")
 *
 * @OA\Tag(name="Products", description="Operations related to products")
 */
class ProductController extends Controller
{
    private $productService;

    function __construct(){
        $this->productService = new ProductService();
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products",
     *     summary="List products",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->productService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products/{id}",
     *     summary="Show product by UUID or ID",
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
        return $this->productService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products/suppliers",
     *     summary="List products of suppliers",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function suppliers()
    {
        return $this->productService->findAllSuppliers();
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products/page",
     *     summary="List products pageable",
     *     description="products a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->productService->paginate();
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products/find-by-category/{id}",
     *     summary="Display products by category",
     *     description="Display a products",
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
        return $this->productService->paginateCategory($id);
    }

    /**
     * @OA\Post(
     *     tags={"Products"},
     *     path="/api/v1/products",
     *     summary="Save product",
     *     description="Creates and returns a new product",
     *     @OA\RequestBody(ref="#/components/requestBodies/ProductRequest"),
     *     @OA\Response(response=201, description="Product created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(ProductRequest $request)
    {
        $request->validate(['user_id' => 'required', 'category_id'  => 'required']);
        return $this->productService->create($request);
    }

    /**
     * @OA\Put(
     *     tags={"Products"},
     *     path="/api/v1/products/{id}",
     *     summary="Update product",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/ProductRequest"),
     *     @OA\Response(response=201, description="Product updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(Request $request, $id)
    {
        return $this->productService->update($request, $id);
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products/search/{search}",
     *     summary="Search product",
     *     description="Search product by text",
     *     @OA\Parameter(
     *      name="search",
     *      in="path",
     *      required=true,
     *      description="Search product",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function search($search)
    {
        return $this->productService->search($search);
    }

        /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/v1/products/suppliers/search/{search}",
     *     summary="Search product of suppliers",
     *     description="Search product of suppliers by text",
     *     @OA\Parameter(
     *      name="search",
     *      in="path",
     *      required=true,
     *      description="Search product of suppliers",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function supplierSearch($search)
    {
        return $this->productService->supplierSearch($search);
    }

    /**
     * @OA\Delete(
     *     tags={"Products"},
     *     path="/api/v1/products/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete product",
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
        $this->productService->delete($id);
        return response()->json([], 204);
    }

    public function counterView($id) {
        $isUpdate = $this->productService->counterView($id);
        return response()->json([], $isUpdate ? 200 : 401);
    }

    public function totalByUser($id){
        $sum = Product::where('user_id', $id)->sum('counter_view');
        return response()->json((int) $sum, 200);
    }

    public function totalByCompany($id){
        $sum = Product::join('company_data', 'products.user_id', '=', 'company_data.user_id')
            ->where('company_data.id', $id)
            ->sum('products.counter_view');
        return response()->json((int) $sum, 200);
    }

    public function similarProducts(Request $request){
        $request->validate([
            'product_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        $similarProducts = Product::where('id', '!=', $request->product_id)
            ->where('category_id', $request->category_id)
            ->limit(10)
            ->get();

            return response()->json([
                'similar_products' => $similarProducts
            ]);
    }

    public function compareProducts(Request $request){

    $request->validate([
        'name' => 'nullable|string',
    ]);

    $query = Product::query();
    // Always filter by product name if provided
    if ($request->filled('product_name')) {
        $query->where('name', 'like', '%' . $request->product_name . '%');
    }

    // Option 1: min and max both
    if ($request->filled('min_price') && $request->filled('max_price')) {
        $query->whereBetween('price', [$request->min_price, $request->max_price]);
    }

    // Option 2: only min price
    if ($request->filled('min_price') && !$request->filled('max_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    // Option 3: only max price
    if (!$request->filled('min_price') && $request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    return $query
        ->with('category', 'user')
        ->orderBy('price')
        ->paginate(20);
}

    public function productServiceFilter(Request $request)
    {
        $type = $request->input('type');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $location = $request->input('location');

        if ($type == "product") {
            $request->validate([
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|gte:min_price',
            ]);

            $query = Product::query()
                ->with('category', 'user.companyData')
                ->where(Auditor::filter());

            // Price filter on the products table
            if ($minPrice !== null) {
                $query->where('price', '>=', $minPrice);
            }
            if ($maxPrice !== null) {
                $query->where('price', '<=', $maxPrice);
            }

            // Location filter
            if (!empty($location)) {
                $query->whereHas('user.companyData', function ($q) use ($location) {
                    $q->where('location', 'LIKE', '%' . $location . '%');
                });
            }

            return $query->orderBy('price')->paginate(20);

        } elseif ($type == "service") {

            $query = Service::query()
            ->with('user.companyData')
            ->where(Auditor::filter());

            if($location){
                $query->whereHas('user.companyData', function ($q) use ($location) {
                    $q->where('location', 'like', '%' . $location . '%');
                });
            }
            return $query->paginate(20);

        } else {
            return response()->json(['error' => 'Invalid type parameter'], 400);
        }
    }
}
