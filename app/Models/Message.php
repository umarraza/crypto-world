<?php

namespace App\Models;

use DB;
use Carbon;
use App\Models\Conversation;
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

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
     * @return string
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
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

            $thread = Conversation::where('user_id', Auth::user()->id)->first();

            if (empty($thread)) {
               $thread = Conversation::create(['user_id'=>Auth::user()->id]);
            }

            $message = parent::create([
                'to_user' => 1,
                'from_user' => Auth::user()->id,
                'conversation_id'=> $thread->id,
                'content' => $data['message'],

            ]);

        
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem while sending message. Please try again.'));
        }

        DB::commit();

        return $message;
    }

    /**
     * @param App\Models\Conversation $conversation
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function storeAdminMessage(array $data = []) {

        DB::beginTransaction();
        try {

            $conversation = Conversation::find(intval($data['conversation_id']));

            $message = parent::create([
                'to_user' => $conversation->user->id,
                'from_user' => Auth::user()->id,
                'conversation_id'=> $conversation->id,
                'content' => $data['message'],
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem while sending message. Please try again.'));
        }
        DB::commit();

        return $message;
    }

    /**
     * @param App\Models\Conversation $id
     *
     * @return Illuminate\Support\Collection
     */
    public function getConversationMessages($id) {

        return parent::where('conversation_id', intval($id))->get();
    }

     /**
     * Get the messages' created_at formated value.
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        $date = Carbon\Carbon::parse($value);

        return [
            'minutes_ago' => $date->diffForHumans(),
            'date' => $date->toFormattedDateString()
        ];
    }
}
