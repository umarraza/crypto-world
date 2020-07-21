<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Profile;
use App\Models\Auth\Role;
use App\Models\Auth\PasswordHistory;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    public function profile() {
        return $this->hasOne(Profile::class);
    } 
}