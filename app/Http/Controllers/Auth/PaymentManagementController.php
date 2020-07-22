<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\Auth\WithdrawPaymentRequest;
use App\Http\Requests\Auth\DepositPaymentRequest;

class PaymentManagementController extends Controller
{
    /**
     * PaymentManagementController constructor.
     *
     * @param  Payment  $payment
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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

        $payment = $this->payment->withdraw($request->validated());

        return redirect()->route('home')->withFlashSuccess(__('The payment was withdrawn successfully.'));
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

        return redirect()->route('home')->withFlashSuccess(__('The payment was deposited successfully.'));
    }
}
