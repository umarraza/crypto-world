<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentRequest;
use App\Http\Requests\Auth\WithdrawPaymentRequest;
use App\Http\Requests\Auth\DepositPaymentRequest;
use Illuminate\Support\Facades\Auth;

class PaymentRequestController extends Controller
{
     /**
     * PaymentRequestController constructor.
     *
     * @param  PaymentRequest  $paymentRequest
     */
    public function __construct(PaymentRequest $paymentRequest)
    {
        $this->paymentRequest = $paymentRequest;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withdrawRequests() {
        return view('auth.payment.withdraw-requests')
            ->withWithdrawRequests($this->paymentRequest->where('status', PaymentRequest::PENDING)
                ->where('type', PaymentRequest::WITHDRAW)->get());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withdrawRequestAction(Request $request) {
        $flag = decrypt($request->flag);

        $model = $this->paymentRequest->find(decrypt($request->id));


        if ($flag === PaymentRequest::APPROVED) {

            $model->status = PaymentRequest::APPROVED;
            $model->save();

            return redirect()->back()->withFlashInfo(__('Request approved suucessfully'));
        }

        if ($flag === PaymentRequest::REJECTED) {

            $payment = Payment::where('user_id', decrypt($request->user_id))->first();
            $payment->current_balance += $model->amount;
            $payment->save();

            $model->status = PaymentRequest::REJECTED;
            $model->save();

            return redirect()->back()->withFlashInfo(__('Request rejected suucessfully'));
        }
    }
}
