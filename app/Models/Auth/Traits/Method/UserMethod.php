<?php

namespace App\Models\Auth\Traits\Method;

use DB;
use App\User;
use Carbon\Carbon;
use App\Models\Auth\Role;
use Illuminate\Http\Request;
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
        dd($refferalUserId);
        $refferalUser = $this->find($refferalUserId);
        dd($refferalUser);

    }


}