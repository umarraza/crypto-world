<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','amount'];

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
