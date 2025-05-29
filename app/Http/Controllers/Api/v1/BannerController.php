<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Services\BannerService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/banners")
 *
 * @OA\Tag(name="Banners", description="Operations related to banners")
 */
class BannerController extends Controller
{
    private $bannerService;

    function __construct(){
        $this->bannerService = new BannerService();
    }

    /**
     * @OA\Get(
     *     tags={"Banners"},
     *     path="/api/v1/banners/{id}",
     *     summary="Show banner by UUID or ID",
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
        return $this->bannerService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Banners"},
     *     path="/api/v1/banners",
     *     summary="List banners",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->bannerService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Banners"},
     *     path="/api/v1/banners/page",
     *     summary="List banners pageable",
     *     description="Banners a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->bannerService->paginate();
    }

    /**
     * @OA\Get(
     *     tags={"Banners"},
     *     path="/api/v1/banners/find-by-screen/{screen}",
     *     summary="Search banner by screen (tudo, servicos, produtos)",
     *     description="Display a listing banners",
     *     @OA\Parameter(
     *      name="screen",
     *      in="path",
     *      required=true,
     *      description="Screen (tudo, servicos, produtos)",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function getBannersByScreen($screen){
        return $this->bannerService->getBannersByScreen($screen);
    }

        /**
     * @OA\Get(
     *     tags={"Banners"},
     *     path="/api/v1/banners/find-by-screen-vertical/{screen}",
     *     summary="Search banner with type is vertical and screen (tudo, servicos, produtos)",
     *     description="Display a listing banners",
     *     @OA\Parameter(
     *      name="screen",
     *      in="path",
     *      required=true,
     *      description="Screen (tudo, servicos, produtos)",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function getBannersByScreenVertical($screen){
        return $this->bannerService->getBannersByScreenVertical($screen);
    }

    /**
     * @OA\Get(
     *     tags={"Banners"},
     *     path="/api/v1/banners/find-by-screen-all-produtos",
     *     summary="Display banners of products",
     *     description="Display a banners",
     *     @OA\Response(response=200, description="OK"),
     * )
     */
    public function getBannersByScreenProdutos(){
        return $this->bannerService->getBannersByScreenProdutos();
    }

    /**
     * @OA\Post(
     *     tags={"Banners"},
     *     path="/api/v1/banners",
     *     summary="Save banner",
     *     description="Creates and returns a new banner",
     *     @OA\RequestBody(ref="#/components/requestBodies/BannerRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(BannerRequest $request)
    {
        return $this->bannerService->create($request);
    }

    /**
     * @OA\Put(
     *     tags={"Banners"},
     *     path="/api/v1/banners/{id}",
     *     summary="Update banner",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/BannerRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(Request $request, $id)
    {
        return $this->bannerService->update($request, $id);
    }

   /**
     * @OA\Delete(
     *     tags={"Banners"},
     *     path="/api/v1/banners/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete banner",
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
        $this->bannerService->delete($id);
        return response()->json([], 204);
    }
}
