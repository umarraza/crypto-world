<?php

use App\User;
use App\Models\Profile;
use App\Models\Payment;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        // Add the master administrator, user id of 1
        $admin =  User::create([
            'id' => 1,
            'user_name' => 'admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
        ]);

        Profile::create([
            'id' => 1,
            'user_id' => $admin->id,
            'mobile_number' => '03031000000',
            'birthday' => '07/13/2020',
            'street' => 'Street # 6',
            'city' => 'Lahore',
            'post_code' => '53720',
        ]);
        
        $customer = User::create([
            'id' => 2,
            'user_name' => 'umarraza',
            'first_name' => 'Umar',
            'last_name' => 'Raza',
            'email' => 'umarraza@gmail.com',
            'password' => Hash::make('secret'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
        ]);

        Profile::create([
            'id' => 2,
            'user_id' => $customer->id,
            'mobile_number' => '03031000000',
            'birthday' => '07/13/2020',
            'street' => 'Street # 6',
            'city' => 'Lahore',
            'post_code' => '53720',
        ]);

        Payment::create(['user_id' => $customer->id,'current_balance' => Payment::DEFAULT_BALANCE_ZERO]);                
    }
}
