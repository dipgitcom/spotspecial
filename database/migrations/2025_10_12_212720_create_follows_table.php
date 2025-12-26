<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('follower_id');    // The user who follows
            $table->unsignedBigInteger('following_id');   // The user being followed
            $table->enum('status', ['pending', 'accepted'])->default('accepted');
            $table->timestamps();

            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['follower_id', 'following_id']); // Prevent duplicate follows
        });
    }

    public function down()
    {
        Schema::dropIfExists('follows');
    }
}

