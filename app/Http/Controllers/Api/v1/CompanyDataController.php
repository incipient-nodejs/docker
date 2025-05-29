<?php

namespace App\Http\Controllers\Api\v1;

use App\Services\Mobile\CompanyDataService as CompanyDataMobileService;
use App\Http\Requests\CompanyDataRequest;
use App\Services\CompanyDataService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/company-data")
 *
 * @OA\Tag(name="Company data", description="Operations related to company data")
 */
class CompanyDataController extends Controller
{
    private $companyDataService;
    private $companyDataMobileService;

    function __construct()
    {
        $this->companyDataService = new CompanyDataService();
        $this->companyDataMobileService = new CompanyDataMobileService();
    }

    /**
     * @OA\Get(
     *     tags={"Company data"},
     *     path="/api/v1/company-data/{id}",
     *     summary="Show company data by UUID or ID",
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
        return $this->companyDataService->findByIdOrUuid($id);
    }

    /**
     * @OA\Get(
     *     tags={"Company data"},
     *     path="/api/v1/company-data",
     *     summary="List company data",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->companyDataService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Company data"},
     *     path="/api/v1/company-data/page",
     *     summary="List company data pageable",
     *     description="Company data a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->companyDataService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Company data"},
     *     path="/api/v1/company-data",
     *     summary="Save company data",
     *     description="Creates and returns a new company data",
     *     @OA\RequestBody(ref="#/components/requestBodies/CompanyDataRequest"),
     *     @OA\Response(response=201, description="Product created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(CompanyDataRequest $request)
    {
        $request->validate(['user_id' => 'required', 'nif' => 'required']);
        return $this->companyDataService->create($request, $request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Company data"},
     *     path="/api/v1/company-data/{id}",
     *     summary="Update company data",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/CompanyDataRequest"),
     *     @OA\Response(response=201, description="Product updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(CompanyDataRequest $request, $id)
    {
        return $this->companyDataService->update($request, $request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Company data"},
     *     path="/api/v1/company-data/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete company data",
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
        $this->companyDataService->delete($id);
        return response()->json([], 204);
    }

    /**
     * @OA\Post(
     *     tags={"Company data"},
     *     path="/api/v1/company-data/updateMobile",
     *     summary="Update company data",
     *     description="Update the specified resource in storage",
     *     @OA\RequestBody(
     *     required=true,
     *     description="Informações para registrar uma empresa",
     *     @OA\JsonContent(
     *         required={"user_id", "companyName", "contact"},
     *         @OA\Property(property="user_id", type="string", example="abc123"),
     *         @OA\Property(property="companyName", type="string", example="XPTO Angola Lda"),
     *         @OA\Property(property="nif", type="string", example="123456789"),
     *         @OA\Property(property="personalNif", type="string", example="987654321"),
     *         @OA\Property(property="address", type="string", example="Rua do Comércio, Luanda"),
     *         @OA\Property(property="category", type="string", example="Tecnologia"),
     *         @OA\Property(property="contactMethod", type="string", example="whatsapp"),
     *         @OA\Property(property="contact", type="string", example="+244912345678"),
     *         @OA\Property(property="hasSite", type="boolean", example=true),
     *         @OA\Property(property="website", type="string", example="https://empresa.co.ao")
     *     )
     * ),
     *     @OA\Response(response=201, description="Product updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function updateMobile(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'companyName' => 'required',
            'nif' => 'nullable',
            'personalNif' => 'nullable',
            'address' => 'nullable',
            'category' => 'nullable',
            'contactMethod' => 'nullable',
            'contact' => 'required',
            'hasSite' => 'nullable',
            'website' => 'nullable',
        ]);

        return $this->companyDataMobileService->updateMobile($request, $request->all());
    }

    public function counterView($id) {
        $isUpdate = $this->companyDataService->counterView($id);
        return response()->json([], $isUpdate ? 200 : 401);
    }
}
