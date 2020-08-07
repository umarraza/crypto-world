<?php

namespace App\Models\Auth\Traits\Relationship;


use App\Models\Roi;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\TeamBonus;
use App\Models\Auth\Role;
use App\Models\PaymentRequest;
use App\Models\Auth\PasswordHistory;
use App\Models\Conversation;
use App\Models\Message;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return string
     */
    public function profile() {
        return $this->hasOne(Profile::class);
    } 

    /**
     * @return string
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @return string
     */
    public function paymentHistory()
    {
        return $this->hasMany(PaymentRequest::class);
    }

    /**
     * @return int
     */
    public function teamBonus()
    {
        return $this->hasMany(TeamBonus::class,'to_user_id');
    }

    /**
     * @return int
     */
    public function roi()
    {
        return $this->hasMany(Roi::class);
    }

    /**
     * @return string
     */
    public function messages()
    {
        return $this->hasMany(Message::class,'from_user');
    }

    /**
     * @return string
     */
    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }
}