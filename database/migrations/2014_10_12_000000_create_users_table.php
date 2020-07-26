<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = 'CREATE TABLE `users` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `block_chain_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `referred_by` int(10) DEFAULT NULL,
            `original_reffered_by` int(10) DEFAULT NULL,
            `payment_status` tinyint(2) DEFAULT 0,
            `avatar_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "gravatar",
            `avatar_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `two_factor_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `password_changed_at` timestamp NULL DEFAULT NULL,
            `active` tinyint(3) unsigned NOT NULL DEFAULT 1,
            `confirmation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `confirmed` tinyint(1) NOT NULL DEFAULT 1,
            `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `last_login_at` timestamp NULL DEFAULT NULL,
            `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `to_be_logged_out` tinyint(1) NOT NULL DEFAULT 0,
            `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `deleted_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `users_email_unique` (`email`)
          ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
