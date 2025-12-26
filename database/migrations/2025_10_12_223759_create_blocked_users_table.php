<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockedUsersTable extends Migration
{
    public function up()
    {
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('block_by'); // Who is blocking
            $table->unsignedBigInteger('blocked_user_id'); // Who is being blocked
            $table->timestamps();

            $table->foreign('block_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blocked_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['block_by', 'blocked_user_id']); // Prevent duplicate blocks
        });
    }

    public function down()
    {
        Schema::dropIfExists('blocked_users');
    }
}
