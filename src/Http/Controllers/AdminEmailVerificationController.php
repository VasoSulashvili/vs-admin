<?php

namespace VS\Admin\Http\Controllers;

use Illuminate\Http\Request;
use VS\Auth\Http\Controllers\EmailVerificationController;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminEmailVerificationController extends EmailVerificationController implements HasMiddleware
{
    protected $guard = null;
    public function __construct()
    {
        $this->guard = 'admin';
    }

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
//            'auth',
//            new Middleware('log', only: ['index']),
//            new Middleware('subscribed', except: ['store']),
        ];
    }

}
