<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\WebsiteRequest;
use App\Http\Controllers\Controller;
use App\Services\WebsiteService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/websites")
 *
 * @OA\Tag(name="Websites", description="Operations related to websites")
 */
class WebsiteController extends Controller
{
    private $websiteService;

    function __construct(){
        $this->websiteService = new WebsiteService();
    }

    /**
     * @OA\Get(
     *     tags={"Websites"},
     *     path="/api/v1/websites/{id}",
     *     summary="Show  website by UUID or ID",
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
        return $this->websiteService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Websites"},
     *     path="/api/v1/websites",
     *     summary="List websites",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->websiteService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Websites"},
     *     path="/api/v1/websites/page",
     *     summary="List websites pageable",
     *     description="Websites a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->websiteService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Websites"},
     *     path="/api/v1/websites",
     *     summary="Save website",
     *     description="Creates and returns a new  website",
     *     @OA\RequestBody(ref="#/components/requestBodies/WebsiteRequest"),
     *     @OA\Response(response=201, description="Service created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(WebsiteRequest $request)
    {
        $request->validate(['user_id' => 'required']);
        return $this->websiteService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Websites"},
     *     path="/api/v1/websites/{id}",
     *     summary="Update website",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/WebsiteRequest"),
     *     @OA\Response(response=201, description="Service updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(WebsiteRequest $request, $id)
    {
        return $this->websiteService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Websites"},
     *     path="/api/v1/websites/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete website",
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
        $this->websiteService->delete($id);
        return response()->json([], 204);
    }
}
