<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/users")
 *
 * @OA\Tag(name="Users", description="Operations related to users")
 */
class UserController extends Controller
{
    private $userService;

    function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/v1/users",
     *     summary="List users",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->userService->findAll();
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/v1/users/page",
     *     summary="List users pageable",
     *     description="Display a listing pageable of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function page()
    {
        return $this->userService->paginate();
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}",
     *     summary="Show user by UUID or ID",
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
        return $this->userService->findByIdOrUuid($id);
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/v1/users/exist-by-phone",
     *     summary="Verify number phone exists",
     *     description="Retorn true if phone exists",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="phoneNumber", type="string"),
     *                 example={"phoneNumber": 902389232}
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function existByPhone(Request $request)
    {
        try {
            $request->validate(['phoneNumber' => 'required']);
            $user = $this->userService->findByPhone($request->phoneNumber);
            $exists = isset($user->id);
            return response()->json((object) ['exists' => $exists], $exists ? 200 : 400);
        } catch (\Exception) {
            return response()->json((object) ['exists' => false], 400);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/v1/users",
     *     summary="Save user",
     *     description="Creates and returns a new user",
     *      @OA\RequestBody(ref="#/components/requestBodies/UserRequest"),
     *     @OA\Response(response=201, description="User created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(UserRequest $request)
    {
        $request->validate(['password' => 'required', 'confirmed' => 'required']);
        return $this->userService->create($request->all());
    }

    /**
     * @OA\Put(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}",
     *     summary="Update user",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UserPutRequest"),
     *     @OA\Response(response=201, description="User updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     *
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}",
     *     summary="Update user",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UserRequest"),
     *     @OA\Response(response=201, description="User updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function update(UserRequest $request, $id)
    {
        return $this->userService->update($request->all(), $id);
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}/updateMobile",
     *     summary="Update user, request made by the mobile application",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Search by UUID or ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "phone"},
     *                 @OA\Property(property="password", type="string", example="password"),
     *                 @OA\Property(property="yourPassword", type="string", example="password"),
     *                 @OA\Property(property="name", type="string", example="Jhon Paul"),
     *                 @OA\Property(property="phone", type="string", example="919324323"),
     *                 @OA\Property(property="email", type="string", example="update.test@gmail.com"),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     format="binary",
     *                     description="User image (format: file)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="User updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     *
     * @OA\Put(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}/updateMobile",
     *     summary="Update user, request made by the mobile application",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="password", type="string", example="password"),
     *                 @OA\Property(property="yourPassword", type="string", example="password"),
     *                 @OA\Property(property="name", type="string", example="Jhon Paul"),
     *                 @OA\Property(property="phone", type="string", example="919324323"),
     *                 @OA\Property(property="email", type="string", example="update.test@gmail.com"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="User updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function updateMobile(Request $request, $id)
    {
        $request->validate([
            'password' => 'nullable',
            'yourPassword' => 'nullable',
        ]);

        return $this->userService->updateMobile($request, $request->all(), $id);
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}/updatePassword",
     *     summary="Update password of user",
     *     description="Update password",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="password", type="string", example="password"),
     *                 @OA\Property(property="yourPassword", type="string", example="password"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="User password updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     *
     * @OA\Put(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}/updatePassword",
     *     summary="Update password of user",
     *     description="Update password",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by UUID or ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="password", type="string", example="password"),
     *                 @OA\Property(property="yourPassword", type="string", example="password"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="User password updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
            'yourPassword' => 'required',
            'old_password' => 'required',
        ]);

        return $this->userService->updatePassword($request, $request->all(), $id);
    }

    /**
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/api/v1/users/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Display a listing by UUID or ID",
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
        $this->userService->delete($id);
        return response()->json([], 204);
    }
}
