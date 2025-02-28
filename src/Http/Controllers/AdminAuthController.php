<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use VS\Admin\Http\Requests\RegisterAdminRequest;
use VS\Admin\Http\Resources\AdminResource;
use VS\Admin\Models\Admin;
use VS\Auth\Http\Requests\LoginRequest;
use VS\Auth\Services\AuthService;
use VS\Base\Classes\API;
use Illuminate\Auth\Events\Registered;
use VS\Base\Exceptions\APIException;

class AdminAuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new Admin(), []);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            if (!$admin->hasVerifiedEmail()) {

                throw new APIException('Email not verified.', 403);

            }

            $user = $this->authService->login('admins', $request->all());

            $token = $this->authService->createPersonalAccessToken($user);

            return new AdminResource($user, ['token' => $token]);

        } else {

            throw new APIException('Unauthorized', 401);

        }
    }

    public function register(RegisterAdminRequest $request)
    {
        $user = $this->authService->register($request->all());

        event(new Registered($user));

        $token = null;

        return new AdminResource($user, $token);
    }

    public function logout()
    {
        $this->authService->logout(Auth::user());

        return API::response(message: 'Successfully logged out');

    }
}
