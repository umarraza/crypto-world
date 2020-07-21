<?php

namespace App;


use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Collective\Html\Eloquent\FormAccessible;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;

class User extends Authenticatable
{
    use HasRoles,
        Notifiable,
        UserAttribute,
        UserMethod,
        SoftDeletes,
        UserRelationship;

    public const TYPE_ADMIN = 1;
    public const TYPE_USER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name','first_name', 'last_name', 'email','referred_by', 'payment', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
