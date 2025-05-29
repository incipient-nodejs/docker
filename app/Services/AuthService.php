<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function authenticate(Request $request): object
    {
       
        $request->validate(['username' => 'required', 'password' => 'required']);
        $credentials = ['password' => $request->password];
        if (str_contains($request->username, '@')) {
            $credentials['email'] = $request->username;
        }else{
            $credentials['phone'] = $request->username;
        }
        // $token = auth('api')->attempt(['password' => $request->password, 'phone' => $request->username,]);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            throw new UnauthorizedHttpException('Invalid credentials');
        }

        $user = $this->userService->findByEmailOrPhone($request->username);

        if(isset($user->status) &&  $user->status == 'inativo') throw new UnauthorizedHttpException();

        if(isset($user->deleted_at) || isset($user->deleted_by)) throw new NotFoundHttpException();

        return (object)[
            "access_token" =>  $token,
            'token_type' => 'bearer',
            "expiresIn" =>  auth('api')->factory()->getTTL() * 60,
            "permissions" => [],
            "user" => $user,
            "counter" => (object)[
                "product" => $user->products()->count(),
                "service" => $user->services()->count(),
            ]
        ];
    }
}
