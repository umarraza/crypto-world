<?php

use App\Exceptions\GeneralException;
use App\Helpers\SystemHelpers;
use App\Models\PaymentRequest;
use App\User;

if (! function_exists('CurrentBtcRate')) {
    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function CurrentBtcRate()
    {
        $jsnsrc = "https://blockchain.info/ticker";
        $json = file_get_contents($jsnsrc);
        $json = json_decode($json);
        $btcrate = $json->USD->last;
        return $btcrate;
    }
}

if (! function_exists('totalUsers')) {
    
    /**
     * @param  $void
     *
     * @return int
     */
    function totalUsers() {
        return User::count();
    }
}

if (! function_exists('totalUnpaidUsers')) {
    
    /**
     * @param  $void
     *
     * @return int
     */
    function totalUnpaidUsers() {
        return User::where('payment_status', 0)->where('id', '!=', 1)->count();
    }
}

if (! function_exists('totalDeposit')) {
    
    /**
     * @param  $void
     *
     * @return int
     */
    function totalDeposit() {
        return PaymentRequest::where('type', PaymentRequest::DEPOSIT)
            ->where('status', PaymentRequest::APPROVED)->sum('amount');
    }
}

if (! function_exists('totalWithdraw')) {
    
    /**
     * @param  $void
     *
     * @return int
     */
    function totalWithdraw() {
        return PaymentRequest::where('type', PaymentRequest::WITHDRAW)
            ->where('status', PaymentRequest::APPROVED)->sum('amount');
    }
}

if (! function_exists('totalPendingWithdrawRequests')) {
    
    /**
     * @param  $void
     *
     * @return int
     */
    function totalPendingWithdrawRequests() {
        return PaymentRequest::where('type', PaymentRequest::WITHDRAW)
            ->where('status', PaymentRequest::PENDING)->count();
    }
}

if (! function_exists('totalApprovedWithdrawRequests')) {
    
    /**
     * @param  $void
     *
     * @return int
     */
    function totalApprovedWithdrawRequests() {
        return PaymentRequest::where('type', PaymentRequest::WITHDRAW)
            ->where('status', PaymentRequest::APPROVED)->count();
    }
}