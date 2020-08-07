<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['to_user','from_user','conversation_id','content'];

    /**
     * @return string
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  array  $data
     *
     * @return Message
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []) : Message {
        DB::beginTransaction();

        try {
            $message = parent::create([

                'to_user' => 1,
                'from_user' => Auth::user()->id,
                'conversation_id'=>Auth::user()->conversation->id,
                'content' => $data['message'],

            ]);
        
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem while sending message. Please try again.'));
        }

        DB::commit();
        return $message;
    }
}
