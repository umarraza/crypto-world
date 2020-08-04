<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyPaymentWithdrawEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     *  var amount
    */
    public $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verify-withdraw')->withAmount($this->amount)->subject('Payment Withdraw verification');
    }
}
