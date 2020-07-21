<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $table = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'mobile_number', 'birthday', 'street', 'city', 'post_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
