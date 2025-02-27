<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use VS\Admin\Http\Requests\RegisterAdminRequest;
use VS\Admin\Http\Resources\AdminResource;
use VS\Admin\Models\Admin;
use VS\Auth\Services\AuthService;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new Admin(), []);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterAdminRequest $request)
    {
        $user = $this->authService->register($request->all());

        $token = null;

        return new AdminResource($user, $token);
    }
}
