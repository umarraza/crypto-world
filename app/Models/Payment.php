<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'current_balance', 'reference_bonus'];

    /**
     * @return string
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
