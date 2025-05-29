<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/register")
 *
 * @OA\Tag(name="Register", description="Operations related create account")
 */
class RegisterController extends Controller
{
    private $userService;

    function __construct(){
        $this->userService = new UserService();
    }

    /**
     * @OA\Post(
     *     tags={"Register"},
     *     path="/api/v1/register",
     *     summary="Realization register",
     *     description="Realization register, inform name, password",
     *     @OA\RequestBody(
     *      required=true,
     *      description="Operation register",
     *      @OA\JsonContent(
     *         required={"name", "phone", "password", "confirmed"},
     *         @OA\Property(
     *             property="name",
     *             type="string",
     *             description="You name"
     *         ),
     *         @OA\Property(
     *             property="phone",
     *             type="string",
     *             description="Your phone number"
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
     *     @OA\Response(response=200, description="Login successful")
     * )
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            // 'email' => 'required',
            'password' => 'required',
            'confirmed' => 'required'
        ]);

        if($request->password != $request->confirmed) throw new NotFoundHttpException();

        $user = $this->userService->create($request->all());

        return (object)[
            "access_token" =>  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJmNjFkNTMyNC0wNzY1LTRiZGMtOThhZi1kYzU1NDk3NDAzZWMiLCJ1c2VybmFtZSI6IlRyaXN0aWFuIEhlYXRoY290ZSIsImlhdCI6MTczOTc4MzYyMCwiZXhwIjoxNzM5Nzg2NjIwfQ.Fub2uCJAEnFEx4XUHykrfvwdhEHJ44fY9GJa7mwXL-I",
            "expiresIn" => "3000s",
            "permissions" => [],
            "user" => $user,
            "counter" => (object)[
                "product" => 0,
                "service" => 0,
            ]
        ];
    }
}
