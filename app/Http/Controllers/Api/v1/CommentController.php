<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Services\CommentService;

/**
 * @OA\PathItem(path="/api/v1/comments")
 *
 * @OA\Tag(name="Comments", description="Operations related to comments")
 */
class CommentController extends Controller
{
    private $commentService;

    function __construct(){
        $this->commentService = new CommentService();
    }

    /**
     * @OA\Get(
     *     tags={"Comments"},
     *     path="/api/v1/comments",
     *     summary="List comments",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->commentService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Comments"},
     *     path="/api/v1/comments/{id}",
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
        return $this->commentService->findById($id);
    }

    /**
     * @OA\Get(
     *     tags={"Comments"},
     *     path="/api/v1/comments/page",
     *     summary="List comments pageable",
     *     description="Comments a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->commentService->paginate();
    }

    /**
     * @OA\Post(
     *     tags={"Comments"},
     *     path="/api/v1/comments",
     *     summary="Save service",
     *     description="Creates and returns a new category",
     *     @OA\RequestBody(ref="#/components/requestBodies/CommentRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(CommentRequest $request)
    {
        return $this->commentService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Comments"},
     *     path="/api/v1/comments/{id}",
     *     summary="Update category",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/CommentRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(CommentRequest $request, $id)
    {
        return $this->commentService->update($request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Comments"},
     *     path="/api/v1/comments/{id}",
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
    public function destroy($id)
    {
        $this->commentService->delete($id);
        return response()->json([], 204);
    }
}
