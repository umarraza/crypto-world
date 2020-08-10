<?php

namespace App\Models\Auth\Traits\Method;

use DB;
use App\User;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Message;
use App\Models\TeamBonus;
use App\Models\Auth\Role;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->hasRole('administrator');
    }

    /**
     * @return mixed
     */
    public function isCustomer()
    {
        return $this->hasRole(config('access.users.customer_role'));
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return mixed
     */
    public function canChangeEmail(): bool
    {
        return config('access.user.change_email');
    }

    /**
     * @param bool $size
     *
     * @throws \Illuminate\Container\EntryNotFoundException
     * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getPicture($size = false)
    {
        switch ($this->avatar_type) {
            case 'gravatar':
                if (! $size) {
                    $size = config('gravatar.default.size');
                }

                return gravatar()->get($this->email, ['size' => $size]);

            case 'storage':
                return url('storage/'.$this->avatar_location);
        }

        $social_avatar = $this->providers()->where('provider', $this->avatar_type)->first();

        if ($social_avatar && strlen($social_avatar->avatar)) {
            return $social_avatar->avatar;
        }

        return false;
    }

    /**
     * Check users refeerals count
     * 
     * @return int
     */
    public function refferalsCount() {
        return $this->where('referred_by', $this->id)->count();
    }

    /**
     * Check users refeerals count
     * 
     * @return int
     */
    public function getRefferalBonus($refferalUserId) {
        // 
    }

    /**
     * Generate two factor authentication code
     * 
     * @return int
     */
    public function generateTwoFactorCode() {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->save();
    }

    /**
     * Generate two factor authentication code for withdraw requests
     * 
     * @return int
     */
     public function generateWithdrawTwoFactorCode() {
        $this->timestamps = false;
        $this->withdraw_two_factor_code = rand(100000, 999999);
        $this->save();
    }

    /**
     * Reset two factor authentication code
     * 
     * @return int
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->save();
    }

     /**
     * Reset two factor authentication code
     * 
     * @return int
     */
     public function resetWithdrawTwoFactorCode()
     {
        $this->timestamps = false;
        $this->withdraw_two_factor_code = null;
        $this->save();
     }

    public static function getUsersByRole($type){
        $modelRole = Role::findByType($type);
        if(!empty($modelRole)){
            return self::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->where('users.payment_status','=',Payment::DEFAULT_BALANCE_ZERO)
                ->where('role_id','=',$modelRole->id)->get();
        }
        return [];
    }

    /**
     * Reset two factor authentication code
     * 
     * @return int
     */
    public function originalReffereName($id) {
        $id = intval($id);
        if ($id) {
            return $this->find($id)->name;
        }
        return '';
    }

    /**
     * Reset two factor authentication code
     * 
     * @return int
     */
    public function totalDeposit() {

        return $this->paymentHistory->where('type', PaymentRequest::DEPOSIT)->where('status', PaymentRequest::APPROVED)->sum('amount');
    }

    /**
     * Reset two factor authentication code
     * 
     * @return int
     */
    public function totalWithdraw() {

        return $this->paymentHistory->where('type', PaymentRequest::WITHDRAW)->where('status',PaymentRequest::APPROVED)->sum('amount');
    }

    /**
     * Reset two factor authentication code
     * 
     * @return int
     */
    public function calculateTeamBonus($users, $percentage) {

        $sum = 0;

        foreach($users as $user) {

            $totalDeposit = $user->totalDeposit();
            $roi = $totalDeposit * ($percentage/(30*100));
            $sum += $roi;

            $teamBonus = TeamBonus::create(['to_user_id' => $this->id, 'from_user_id'=>$user->id, 'amount' => $roi]);
        }

        return $sum;
    }

    /**
     * @return int;
     */
    public function getTeamBonus() {

        return $this->teamBonus->sum('amount');
    }

    /**
     * @return int;
     */
    public function getDailyTeamBonus() {

        return $this->teamBonus->where('status',0)->sum('amount');
    }

    /**
     * @return int;
     */
    public function getTotalRoi() {
        return $this->roi->sum('amount');
    }

    /**
     * @return int;
     */
    public function getDailyRoi() {
        return $this->roi->where('status',0)->sum('amount');
    }

    /**
     * @return int;
     */
    public function getTeamBonusByUsersLevel($level) {

        $usersIds = $this->getUsersByRefferalLevel($level)->pluck('id');

        return TeamBonus::where('to_user_id', auth()->user()->id)
            ->whereIn('from_user_id', $usersIds)->sum('amount');
    }

    /**
     * @return string;
     */
    public function getRefferalLevelPercentage($level) {

        switch ($level) {
            case self::LEVEL_ONE:
                return '2%';
            break;

            case self::LEVEL_TWO:
                return '1.5%';
            break;

            case self::LEVEL_THREE:
                return '1%';
            break;

            case self::LEVEL_FOUR:
                return '0.75%';
            break;

            case self::LEVEL_FIVE:
                return '0.5%';
            break;

            case self::LEVEL_SIX:
                return '0.25%';
            break;
        }
    }

    /**
     * Reset two factor authentication code
     * 
     * @return App\User;
     */
    public function getUsersByRefferalLevel($level) {
        
        switch ($level) {
            case self::LEVEL_ONE:
                return self::where('referred_by', $this->id)
                    // ->where('payment_status', Payment::PAID)
                    ->get();
            break;

            case self::LEVEL_TWO:
                $userIds = self::where('referred_by', $this->id)->pluck('id');
                return self::whereIn('referred_by', $userIds)
                    // ->where('payment_status', Payment::PAID)
                    ->get();
            break;

            case self::LEVEL_THREE:
                $userIds = self::where('referred_by', $this->id)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                return self::whereIn('referred_by', $userIds)
                    // ->where('payment_status', Payment::PAID)
                    ->get();
            break;

            case self::LEVEL_FOUR:
                $userIds = self::where('referred_by', $this->id)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                return self::whereIn('referred_by', $userIds)
                    // ->where('payment_status', Payment::PAID)
                    ->get();
            break;

            case self::LEVEL_FIVE:
                $userIds = self::where('referred_by', $this->id)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                return self::whereIn('referred_by', $userIds)
                    // ->where('payment_status', Payment::PAID)
                    ->get();
            break;

            case self::LEVEL_SIX:
                $userIds = self::where('referred_by', $this->id)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                $userIds = self::whereIn('referred_by', $userIds)->pluck('id');
                return self::whereIn('referred_by', $userIds)
                    // ->where('payment_status', Payment::PAID)
                    ->get();
            break;
        }
    }

    /**
     * @param void
     *
     * @return Illuminate\Support\Collection
     */
    public function getMessages() {
        
        return Message::where(function($query) {
            $query->where('from_user', 1) // where admin has sent messages to user
                ->where('to_user', $this->id);
        })->orWhere(function($query) {
            $query->where('from_user',  $this->id) // where user has sent messages to admin
                ->where('to_user', 1);
        })->get();
    }

    /**
     * @param void
     *
     * @return Illuminate\Support\Collection
     */
    public function conversations() {
        
        $models = Conversation::all();

        $conversations = array();

        foreach($models as $conversation) {

            if (!empty($conversation->messages->toArray())) {
                $conversations[] = [
                    'id' => $conversation->id,
                    'user_name' => $conversation->user->full_name,
                    'message' =>  $conversation->messages->last()->content,
                ];
            }
        }
        return $conversations;
    }
}