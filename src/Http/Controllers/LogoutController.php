<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use VS\Admin\Models\Admin;
use VS\Auth\Services\AuthService;
use VS\Base\Classes\API;

class LogoutController extends Controller
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
        $this->authService->logout($request->user());

        return API::response(message: 'Successfully logged out');
    }
}
