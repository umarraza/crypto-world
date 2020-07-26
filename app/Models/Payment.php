<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class Payment extends Model
{
    public const PAID = 1;
    public const DEFAULT_BALANCE_ZERO = 0;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'payment_date', 'current_balance', 'reference_bonus', 'payment_status'];

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
    public function store(array $data = []) : Payment {
        DB::beginTransaction();

        try {

            $user = Auth::user();

            $payment = parent::where('user_id', $user->id)->first();

            if ($payment) {
                $payment->current_balance += $data['deposit_amount'];
                $payment->payment_date = date('Y-m-d');
                
                if ($user->payment_status == self::DEFAULT_BALANCE_ZERO) {
                    $user->payment_status = self::PAID;
                    $user->save();
                }
    
                $payment->save();
            }

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem depositing this amount. Please try again.'));
        }

        DB::commit();
        return $payment;
    }

     /**
     * @param  array  $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Throwable
     */
    public function withdraw(array $data = []) : Payment {
        DB::beginTransaction();

        try {
            
            $amount = self::where('user_id', Auth::user()->id)->first();
        
            $amount->current_balance -= $data['withdraw_amount'];

            $amount->save();

        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem withdrawing this amount. Please try again.'));
        }

        DB::commit();
        return $amount;
    }
}
