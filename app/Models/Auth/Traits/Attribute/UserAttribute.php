<?php

namespace App\Models\Auth\Traits\Attribute;

use Illuminate\Support\Facades\Hash;

/**
 * Trait UserAttribute.
 */
trait UserAttribute
{
    /**
     * @param $password
     */
    public function setPasswordAttribute($password) : void
    {
        // If password was accidentally passed in already hashed, try not to double hash it
        if (
            (\strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
            (\strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password))
        ) {
            $hash = $password;
        } else {
            $hash = Hash::make($password);
        }

        // Note: Password Histories are logged from the \App\Observer\User\UserObserver class
        $this->attributes['password'] = $hash;
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getRolesLabelAttribute()
    {
        $roles = $this->getRoleNames()->toArray();

        if (\count($roles)) {
            return implode(', ', array_map(function ($item) {
                if ($item === config('access.users.super_admin'))
                    return '<span class="kt-badge kt-badge--primary kt-badge--inline">'.ucwords($item).'</span>';
                elseif($item === config('access.users.customer_role')) 
                    return '<span class="kt-badge kt-badge--warning kt-badge--inline">'.ucwords($item).'</span>';
            }, $roles));
        }

        return 'N/A';
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->full_name;
    }

    /**
     * @return mixed
     */
    public function getPictureAttribute()
    {
        return $this->getPicture();
    }

    /**
     * @return string
     */
    public function getEmailVerifiedLabelAttribute() {
        if ($this->email_verified === 1) {
            return '<span class="badge badge-success">Verfied</span>';
        } else {
            return '<span class="badge badge-danger">Not Verfied</span>';
        }
    }

        /**
     * @return string
     */
    public function getActiveLabelAttribute() {
        if ($this->active === 1) {
            return '<span class="badge badge-success">Yes</span>';
        } else {
            return '<span class="badge badge-danger">No</span>';
        }
    }
}