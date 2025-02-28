<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use VS\Admin\Http\Resources\AdminResource;
use VS\Admin\Models\Admin;
use VS\Auth\Services\AuthService;

class LoginController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new Admin());
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $this->authService->login('admins', $request->all());

        $token = $this->authService->createPersonalAccessToken($user);

        return new AdminResource($user, ['token' => $token]);
    }
}
