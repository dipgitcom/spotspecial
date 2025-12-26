<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique()->index();
            $table->boolean('push_notification')->default(true);
            $table->boolean('sound')->default(true);
            $table->boolean('vibration')->default(true);
            $table->boolean('reactions')->default(true);
            $table->boolean('community_alerts')->default(true);
            $table->boolean('critical_safety_alerts')->default(true);
            $table->boolean('proximity_warnings')->default(true);
            $table->boolean('direct_messages')->default(true);
            $table->boolean('calls')->default(true);
            $table->boolean('subscriptions_updates')->default(true);
            $table->boolean('system_notifications')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_notification_settings');
    }
}

