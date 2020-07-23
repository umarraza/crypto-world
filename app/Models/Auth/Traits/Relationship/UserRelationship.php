<?php

namespace App\Models\Auth\Traits\Relationship;


use App\Models\Payment;
use App\Models\Profile;
use App\Models\Auth\Role;
use App\Models\PaymentRequest;
use App\Models\Auth\PasswordHistory;

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
}