<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;
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
                'amount' => $data['withdraw_amount'],
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
     * @return User
     * @throws GeneralException
     * @throws \Throwable
     */
    public function deposit(array $data = []) : PaymentRequest {
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
        return $paymentRequest;
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
