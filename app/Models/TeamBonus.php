<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TeamBonus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_team_bonuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['to_user_id','from_user_id','amount'];

    /**
     * @return string
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return string
     */
    public function fromUser()
    {
        return $this->hasOne(User::class,'id','from_user_id');
    }
}
