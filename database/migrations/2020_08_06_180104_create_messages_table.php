<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = 'CREATE TABLE `messages` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `to_user` int(10) unsigned NOT NULL,
            `from_user` int(10) unsigned NOT NULL,
            `conversation_id` int(10) unsigned DEFAULT NULL,
            `content` text NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            KEY `to_user` (`to_user`),
            KEY `from_user` (`from_user`),
            KEY `conversation_id` (`conversation_id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4';

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
