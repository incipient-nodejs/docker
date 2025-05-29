<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannedTermRequest;
use App\Services\BannedTermService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/banned-terms")
 *
 * @OA\Tag(name="Banned Terms", description="Operations related to terms banned")
 */
class BannedTermsController extends Controller
{
    private $bannedTermService;

    function __construct(){
        $this->bannedTermService = new BannedTermService();
    }

    /**
     * @OA\Get(
     *     tags={"Banned Terms"},
     *     path="/api/v1/banned-terms/{id}",
     *     summary="Show banned terms by ID",
     *     description="Display a listing by ID",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Search by ID",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id)
    {
        return $this->bannedTermService->findById($id);
    }

    /**
     * @OA\Get(
     *     tags={"Banned Terms"},
     *     path="/api/v1/banned-terms",
     *     summary="List banned-terms",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->bannedTermService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Banned Terms"},
     *     path="/api/v1/banned-terms/page",
     *     summary="List banned-terms pageable",
     *     description="Banned Terms a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->bannedTermService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Banned Terms"},
     *     path="/api/v1/banned-terms",
     *     summary="Save banned terms",
     *     description="Creates and returns a new banned terms",
     *     @OA\RequestBody(ref="#/components/requestBodies/BannedTermRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(BannedTermRequest $request)
    {
        return $this->bannedTermService->create($request);
    }

    /**
     * @OA\Put(
     *     tags={"Banned Terms"},
     *     path="/api/v1/banned-terms/{id}",
     *     summary="Update banned terms",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/BannedTermRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(BannedTermRequest $request, $id)
    {
        return $this->bannedTermService->update($request, $id);
    }

   /**
     * @OA\Delete(
     *     tags={"Banned Terms"},
     *     path="/api/v1/banned-terms/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete banned terms",
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
        $this->bannedTermService->delete($id);
        return response()->json([], 204);
    }
}
