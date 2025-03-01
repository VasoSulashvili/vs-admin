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

class AdminAuthController extends Controller
{
    protected $authService;



    public function __construct()
    {
        $this->authService = new AuthService(new Admin(), []);
    }



    /**
     * @param LoginRequest $request
     * @return AdminResource
     * @throws \VS\Base\Exceptions\APIException
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = $this->authService->login('admins', $credentials);

        $token = $this->authService->createPersonalAccessToken($user);

        return new AdminResource($user, ['token' => $token]);
    }



    /**
     * @param RegisterAdminRequest $request
     * @return AdminResource
     * @throws \VS\Base\Exceptions\APIException
     */
    public function register(RegisterAdminRequest $request)
    {
        $user = $this->authService->register($request->all());

        event(new Registered($user));

        $token = null;

        return new AdminResource($user, $token);
    }



    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->authService->logout(Auth::user());

        return API::response(message: 'Successfully logged out');

    }
}
