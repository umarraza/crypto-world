<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAlterations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = 'ALTER TABLE `user_roi` ADD `status` TINYINT(3) NOT NULL DEFAULT 0 AFTER `amount`;
                ALTER TABLE `user_team_bonuses` ADD `status` TINYINT(3) NOT NULL DEFAULT 0 AFTER `amount`;
                ALTER TABLE `payments` CHANGE `current_balance` `current_balance` DECIMAL(10,2) NULL DEFAULT 0;';

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
