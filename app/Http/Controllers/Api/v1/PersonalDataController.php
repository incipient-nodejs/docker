<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\PersonalDataRequest;
use App\Services\PersonalDataService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/personal-data")
 *
 * @OA\Tag(name="Personal data", description="Operations related to personal data")
 */
class PersonalDataController extends Controller
{
    private $personalDataService;

    function __construct(){
        $this->personalDataService = new PersonalDataService();
    }

    /**
     * @OA\Get(
     *     tags={"Personal data"},
     *     path="/api/v1/personal-data/{id}",
     *     summary="Show personal data by UUID or ID",
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
        return $this->personalDataService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Personal data"},
     *     path="/api/v1/personal-data",
     *     summary="List personal data",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->personalDataService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Personal data"},
     *     path="/api/v1/personal-data/page",
     *     summary="List personal data pageable",
     *     description="Personal data a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->personalDataService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Personal data"},
     *     path="/api/v1/personal-data",
     *     summary="Save personal data",
     *     description="Creates and returns a new personal data",
     *     @OA\RequestBody(ref="#/components/requestBodies/PersonalDataRequest"),
     *     @OA\Response(response=201, description="Product created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(PersonalDataRequest $request)
    {
        $request->validate(['user_id' => 'required', 'nif_bi' => 'required']);
        return $this->personalDataService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Personal data"},
     *     path="/api/v1/personal-data/{id}",
     *     summary="Update personal data",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/PersonalDataRequest"),
     *     @OA\Response(response=201, description="Product updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(PersonalDataRequest $request, $id)
    {
        return $this->personalDataService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Personal data"},
     *     path="/api/v1/personal-data/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete personal data",
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
        $this->personalDataService->delete($id);
        return response()->json([], 204);
    }
}
