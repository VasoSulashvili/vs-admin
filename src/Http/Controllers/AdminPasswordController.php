<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use VS\Admin\Models\Admin;
use VS\Auth\Http\Requests\EmailRequest;
use VS\Auth\Http\Requests\PasswordResetRequest;
use VS\Auth\Http\Requests\UpdatePasswordRequest;
use VS\Auth\Services\PasswordService;
use VS\Base\Classes\API;

class AdminPasswordController extends Controller
{
    protected $passwordService;

    public function __construct()
    {
        $this->passwordService = new PasswordService(new Admin(), []);
    }



    public function update(UpdatePasswordRequest $request)
    {

        $this->passwordService->update(
            Auth::user(),
            $request->input('old_password'),
            $request->input('password'),
            $request->input('password_repeat')
        );

        return API::response(code: Response::HTTP_OK, message: 'Password updated successfully');
    }



    public function sendResetLinkEmail(EmailRequest $request)
    {

        $this->passwordService->sendResetLinkEmail('admin', $request->input('email'));

        return API::response(code: Response::HTTP_OK, message: 'Password reset link sent successfully');

    }

    public function reset(PasswordResetRequest $request)
    {

        $result = $this->passwordService->reset(
            'admins',
            $request->only('password', 'password_confirmation', 'email', 'token')
        );

        if (!$result) {
            return API::response(code: Response::HTTP_BAD_REQUEST, message: 'Password reset failed');
        }

        return API::response(code: Response::HTTP_OK, message: 'Password changed successfully');

    }

}
