<?php

namespace App\Http\Controllers\Api\v1;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * @OA\PathItem(path="/api/v1/users/forget-recover-password")
 *
 * @OA\Tag(name="Forget Password", description="Operations related forget password")
 */
class RecoverPasswordController extends Controller
{

    private $userService;

    function __construct(){
        $this->userService = new UserService();
    }

    /**
     * @OA\Post(
     *     tags={"Forget Password"},
     *     path="/api/v1/users/forget-recover-password",
     *     summary="Recoved Password",
     *     description="Realization recoved password, inform you phone number, password and confirm password",
     *     @OA\RequestBody(
     *      required=true,
     *      description="Realization recoved password",
     *      @OA\JsonContent(
     *         required={"phoneNumber", "passowrd", "confirm"},
     *         @OA\Property(
     *             property="phoneNumber",
     *             type="string",
     *             description="You phone number"
     *         ),
     *         @OA\Property(
     *             property="password",
     *             type="string",
     *             description="Inform you password"
     *         ),
     *         @OA\Property(
     *             property="confirm",
     *             type="string",
     *             description="Confirm you password"
     *         )
     *     )
     * ),
     *     @OA\Response(response=200, description="Forget password successful")
     * )
     */
    function recover(Request $request){
        $request->validate(['phoneNumber' => 'required', 'password' => 'required', 'confirm' => 'required']);

        if($request->password != $request->confirm) return response()->json([], 401);

        $user = $this->userService->findByPhone($request->phoneNumber);

        $user->update([ "password" => bcrypt($request->password) ]);

        return (object)[
            "access_token" =>  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJmNjFkNTMyNC0wNzY1LTRiZGMtOThhZi1kYzU1NDk3NDAzZWMiLCJ1c2VybmFtZSI6IlRyaXN0aWFuIEhlYXRoY290ZSIsImlhdCI6MTczOTc4MzYyMCwiZXhwIjoxNzM5Nzg2NjIwfQ.Fub2uCJAEnFEx4XUHykrfvwdhEHJ44fY9GJa7mwXL-I",
            "expiresIn" => "3000s",
            "permissions" => [],
            "user" => $user,
            "counter" => (object) [
                "product" => $user->products()->count(),
                "service" => $user->services()->count(),
            ]
        ];
    }
}
