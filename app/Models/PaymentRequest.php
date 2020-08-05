<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

class PaymentRequest extends Model
{
    public const PENDING = 0;
    public const APPROVED = 1;
    public const REJECTED = 2;
    public const WITHDRAW = 'withdraw';
    public const DEPOSIT = 'deposit';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','amount','date','type','status'];

    /**
     * @return string
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  array  $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Throwable
     */
    public function withdraw(array $data = []) : PaymentRequest {
        DB::beginTransaction();

        try {
            $paymentRequest = parent::create([
                'user_id' => Auth::user()->id,
                'amount' => decrypt($data['withdraw_amount']),
                'type' => self::WITHDRAW,
                'status' => self::PENDING,
                'date' => date('Y-m-d'),
            ]);
        
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem depositing this amount. Please try again.'));
        }

        DB::commit();
        return $paymentRequest;
    }

    /**
     * @param  array  $data
     *
     * @return array
     * @throws GeneralException
     * @throws \Throwable
     */
    public function deposit(array $data = []) {

        DB::beginTransaction();

        try {
            $paymentRequest = parent::create([
                'user_id' => Auth::user()->id,
                'amount' => $data['deposit_amount'],
                'type' => self::DEPOSIT,
                'status' => self::PENDING,
                'date' => date('Y-m-d'),
            ]);
        
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem depositing this amount. Please try again.'));
        }

        DB::commit();

        $all = file_get_contents("https://blockchain.info/ticker");
        $res = json_decode($all);

        $btcrate = $res->USD->last;
        $amount = intval($data['deposit_amount']);

        $usd = $amount;
        $btcamount = $usd/$btcrate;
        $btc = round($btcamount, 8);
        
        $bcid = auth()->user()->id;

        $bitcoin['amount'] = $btc;
     
        $secret = 'ZzsMLGKe162CfA5EcG6j';

        $xpub = 'xpub6CgNjrZMcXv2B9LRQamKmqKreBn51CKQ25hzXWMZ6tSXZ9nH1hg1UQsXNsGmEZZjKB5v869KERQyF17deGK2m5Fz2Q4JTjR8wpFgymPqKiY';
        $api_key = '10712c83-d168-4700-862a-ff97883d2463';
        
        $base_url = 'https://kcw.global/kcw/';
        $blockchain_receive_root = "https://api.blockchain.info/";
        
        $callback_url = $base_url.'ipnbtc?invoice_id='.$paymentRequest->id.'&secret='.$secret;
        
        $parameters = 'xpub=' .$xpub. '&callback=' .urlencode($callback_url). '&key=' .$api_key;
        
        $response = @file_get_contents($blockchain_receive_root. 'v2/receive?' . $parameters);
        
        if (!$response) {
            return false;
        }
    
        
         $response2 = json_decode($response);
            
           $sendto = $response2->address;
           $bitcoin['sendto'] = $sendto;

        $var = "bitcoin:$sendto?amount=$btc";
        $bitcoin['code'] =  "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$var&choe=UTF-8\" title='' style='width:300px;' />";
dd($response2);
        
        return ['paymentRequest'=>$paymentRequest, 'bitcoin'=>$bitcoin];
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute() {
        if ($this->status == self::APPROVED) {
            return '<span class="badge badge-success">Approved</span>';
        } else if($this->status == self::PENDING) {
            return '<span class="badge badge-info">Pending</span>';
        } else {
            return '<span class="badge badge-danger">Rejected</span>';
        }
    }
}
