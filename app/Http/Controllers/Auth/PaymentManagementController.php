<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CoinGate\CoinGate;
use App\Models\Payment;
use App\Models\PaymentRequest;
use App\Http\Requests\Auth\WithdrawPaymentRequest;
use App\Http\Requests\Auth\DepositPaymentRequest;
use Illuminate\Support\Facades\Auth;

class PaymentManagementController extends Controller
{
    /**
     * PaymentManagementController constructor.
     *
     * @param  Payment  $payment
     */
    public function __construct(Payment $payment, PaymentRequest $paymentRequest)
    {
        $this->payment = $payment;
        $this->paymentRequest = $paymentRequest;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withdraw() {
        return view('auth.payment.withdraw');
    }

    /**
     * @param  WithdrawPaymentRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function withDrawAmount(WithdrawPaymentRequest $request) {

        $paymentRequest = $this->paymentRequest->withdraw($request->validated());
        return redirect()->route('user.home')->withFlashSuccess(__('Your rqeuest to withdraw payment sent successfully.'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deposit() {
        return view('auth.payment.deposit');
    }

    /**
     * @param  DepositPaymentRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function depositAmount(DepositPaymentRequest $request) {

        $payment = $this->payment->store($request->validated());

        return redirect()->route('user.home')->withFlashSuccess(__('The payment was deposited successfully.'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withdrawHistory() {
        return view('auth.payment.history.withdraw')
            ->withPaymentRequests(Auth::user()->paymentHistory->where('type', PaymentRequest::WITHDRAW));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function depositHistory() {
        return view('auth.payment.history.deposit')
            ->withPaymentRequests(Auth::user()->paymentHistory->where('type', PaymentRequest::DEPOSIT));
    }
}