<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DeleteAccountRequest;
use App\Services\DeleteAccountService;

/**
 * @OA\PathItem(path="/api/v1/delete-accounts")
 *
 * @OA\Tag(name="Delete Accounts", description="Operations related to delete accounts")
 */
class DeleteAccountController extends Controller
{
    private $deleteAccountService;

    function __construct(){
        $this->deleteAccountService = new DeleteAccountService();
    }

    /**
     * @OA\Get(
     *     tags={"Delete accounts"},
     *     path="/api/v1/delete-accounts",
     *     summary="List delete-accounts",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->deleteAccountService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Delete accounts"},
     *     path="/api/v1/delete-accounts/{id}",
     *     summary="Show account removed by ID",
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
        return $this->deleteAccountService->findById($id);
    }

    /**
     * @OA\Get(
     *     tags={"Delete accounts"},
     *     path="/api/v1/delete-accounts/page",
     *     summary="List delete-accounts pageable",
     *     description="Delete accounts a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->deleteAccountService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Delete accounts"},
     *     path="/api/v1/delete-accounts",
     *     summary="Save accout delete",
     *     description="Creates and returns a new account removed",
     *     @OA\RequestBody(ref="#/components/requestBodies/DeleteAccountRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(DeleteAccountRequest $request)
    {
        return $this->deleteAccountService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Delete accounts"},
     *     path="/api/v1/delete-accounts/{id}",
     *     summary="Update account removed",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/DeleteAccountRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(DeleteAccountRequest $request, $id)
    {
        return $this->deleteAccountService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Delete accounts"},
     *     path="/api/v1/delete-accounts/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete account removed",
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
        $this->deleteAccountService->delete($id);
        return response()->json([], 204);
    }
}
