<?php

namespace App\Http\Controllers\Auth;

use App\Events\VerifyPaymentWithdraw;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CoinGate\CoinGate;
use App\Models\Payment;
use App\Models\PaymentRequest;
use App\Models\Roi;
use App\Models\TeamBonus;
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
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withDrawAmountIndex(Request $request) {

        return view('auth.withdrawTwoFactor')->withAmount($request->amount);
    }

    /**
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyWithdraw(Request $request) {

        $request->validate([
            'withdraw_two_factor_code' => 'integer|required',
        ]);

        if($request->input('withdraw_two_factor_code') == auth()->user()->withdraw_two_factor_code)
        {
            $paymentRequest = $this->paymentRequest->withdraw($request->all());

            auth()->user()->resetWithdrawTwoFactorCode();

            return redirect()->route('user.home')->withFlashSuccess('Your request to withdraw amount sent successfully');
        }

        return redirect()->back()
            ->withErrors(['withdraw_two_factor_code' => 
                'The withdraw verification code you have entered does not match']);

    }

    /**
     * Proccess payment deposit.
     */
    public function ipnbtc() {
        
        $invoice_id = $_GET['invoice_id'];
        
        $model = PaymentRequest::find($invoice_id);
        $model->status = PaymentRequest::APPROVED;
        $model->save();

        $user = Auth::user();
        $user->payment_status = 1;
        $user->save();

        // $secret = $_GET['secret'];
        // $address = $_GET['address'];
        // $value = $_GET['value'];
        // $confirmations = $_GET['confirmations'];
        // $value_in_btc = $_GET['value'] / 100000000;

        // $trx_hash = $_GET['transaction_hash'];

        Storage::put('btcresponse.txt', json_encode($invoice_id));

        // if response 200, change deposit status
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

        $user = Auth::user();
        if (!auth()->user()->block_chain_address) {

            return redirect('profile/'.auth()->user()->id.'/edit')->withFlashDanger(__('You must provide your BTC address to proccess your withdraw.'));
        }

        if ($user->payment->current_balance == Payment::DEFAULT_BALANCE_ZERO) {
            return redirect()->back()->withFlashDanger(__('You do not have any balance to withdraw.'));
        }

        if ($request->withdraw_amount > $user->payment->current_balance) {
            return redirect()->back()->withFlashDanger(__('You cannot withdraw amount greater then your current amount.'));
        }

        $user->generateWithdrawTwoFactorCode();
        
        event(new VerifyPaymentWithdraw($request));

        return redirect()->back()->withFlashInfo(__('Check your email to verify payment withdraw request.'));
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

        if ($request->deposit_amount < 0) {
            return redirect()->back()->withFlashDanger(__('Minimum amount to deposit is $100.'));
        }

        $model = $this->paymentRequest->deposit($request->all());

        if (!$model) {
            return redirect()->route('user.home')->withFlashDanger('BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER');
        }

        return view('auth.payment.bitcoin')->withBitcoin($model['bitcoin']);
    }

    /**
     * @param  void
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function transferRoiPayment() {
        
        $user = Auth::user();
        $request['deposit_amount'] = Roi::where('user_id',$user->id)
                ->where('status',0)
                ->sum('amount');

        $payment = $this->payment->store($request);

        $roi = Roi::where('user_id',$user->id)
                ->where('status',0)
                ->update(['status'=>1]);


        return redirect()->route('user.home')->withFlashSuccess(__('The ROI payment was transferred successfully.'));
    }

    /**
     * @param  void
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function transferTeamBonusPayment() {
        $user = Auth::user();
        $request['deposit_amount'] = TeamBonus::where('to_user_id',$user->id)
                                            ->where('status',0)
                                            ->sum('amount');

        $payment = $this->payment->store($request);

        $roi = TeamBonus::where('to_user_id',$user->id)
                        ->where('status',0)
                        ->update(['status'=>1]);


        return redirect()->route('user.home')->withFlashSuccess(__('The Team Bonus payment was transferred successfully.'));
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
            ->withPaymentRequests(Auth::user()->paymentHistory->where('type', PaymentRequest::DEPOSIT)->where('status', PaymentRequest::APPROVED));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roiHistory() {
        return view('auth.payment.history.roi')
            ->withPaymentRequests(Auth::user()->roi);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teamBonusHistory() {
        return view('auth.payment.history.teamBonus')
            ->withPaymentRequests(Auth::user()->teamBonus);
    }
}