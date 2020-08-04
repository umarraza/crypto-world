<?php

namespace App\Listeners;

use App\Events\VerifyPaymentWithdraw;
use App\Mail\VerifyPaymentWithdrawEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class VerifyPaymentWithdrawListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(VerifyPaymentWithdraw $event)
    {   
        Mail::to(auth()->user()->email)->queue(new VerifyPaymentWithdrawEmail($event->withdraw_amount));
    }
}
