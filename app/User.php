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

    public const ACTIVE = 1;
    public const UN_ACTIVE = 0;

    public const TYPE_ADMIN = 1;
    public const TYPE_USER = 2;

    public const LEVEL_ONE = 1;
    public const LEVEL_TWO = 2;
    public const LEVEL_THREE = 3;
    public const LEVEL_FOUR = 4;
    public const LEVEL_FIVE = 5;
    public const LEVEL_SIX = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name','first_name', 'last_name', 'email','block_chain_address','referred_by','original_reffered_by','payment_status', 'password','two_factor_code','withdraw_two_factor_code',
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
