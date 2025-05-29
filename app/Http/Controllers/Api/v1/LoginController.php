<?php

namespace App\Http\Controllers\Api\v1;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Interfaces\AuthServiceInterface;
/**
 * @OA\PathItem(path="/api/v1/login")
 *
 * @OA\Tag(name="Autentication", description="Operations related autentication")
 */
class LoginController extends Controller
{
    private $userService;
    protected AuthServiceInterface $authService;

    function __construct(AuthServiceInterface $authService){
        $this->userService = new UserService();
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *     tags={"Authentication"},
     *     path="/api/v1/login",
     *     summary="Realization authentication",
     *     description="Realization authentication, inform username, password",
     *     @OA\RequestBody(
     *      required=true,
     *      description="Operation authentication",
     *      @OA\JsonContent(
     *         required={"username", "passowrd"},
     *         @OA\Property(
     *             property="username",
     *             type="string",
     *             description="Username is phone number or email"
     *         ),
     *         @OA\Property(
     *             property="password",
     *             type="string",
     *             description="Inform you password"
     *         )
     *     )
     * ),
     *     @OA\Response(response=200, description="Login successful")
     * )
     */
    public function authentication(Request $request)
    {
        return $this->authService->authenticate($request);
    }
}
