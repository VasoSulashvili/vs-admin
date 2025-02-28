<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use VS\Admin\Models\Admin;
use VS\Auth\Http\Requests\UpdatePasswordRequest;
use VS\Auth\Services\AuthService;
use VS\Base\Classes\API;

class AdminPasswordController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService(new Admin(), []);
    }

    public function update(UpdatePasswordRequest $request)
    {

        $this->authService->updatePassword(
            Auth::user(),
            $request->input('old_password'),
            $request->input('password'),
            $request->input('password_repeat')
        );

        return API::response(code: Response::HTTP_OK, message: 'Password updated successfully');
    }

}
