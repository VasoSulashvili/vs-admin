<?php

namespace VS\Admin\Http\Controllers;

use Illuminate\Http\Request;
use VS\Auth\Http\Controllers\EmailVerificationController;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminEmailVerificationController extends EmailVerificationController
{
    public function __construct(protected $guard = 'admin') {}

}
