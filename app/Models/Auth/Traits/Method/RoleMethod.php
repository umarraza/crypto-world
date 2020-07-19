<?php

namespace App\Models\Auth\Traits\Method;

/**
 * Trait RoleMethod.
 */
trait RoleMethod
{
   

    /**
     * @return string
     */
    public static function admin() {
        return config('access.users.super_admin');
    }

    /**
     * @return string
     */
    public static function teacher() {
        return config('access.users.customer_role');
    }

    /**
     * @return string
     */
    public static function findByType($type){
        return self::where('name',$type)->first();
    } 
}