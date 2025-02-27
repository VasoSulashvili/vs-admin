<?php

namespace VS\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use VS\Admin\Http\Requests\RegisterAdminRequest;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterAdminRequest $request)
    {
        dd($request->all());
    }
}
