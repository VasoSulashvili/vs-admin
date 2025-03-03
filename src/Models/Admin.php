<?php

namespace VS\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use VS\Auth\Notifications\ResetPasswordEmail;
use VS\Auth\Notifications\VerifyApiEmail;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Admin extends Authenticatable implements MustVerifyEmail, CanResetPasswordContract
{
    use HasFactory, Notifiable, HasApiTokens, CanResetPassword;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'two_fa_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail('api.vs.admin.verification.verify'));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordEmail($token, 'api.vs.admin.password.reset'));
    }
}
