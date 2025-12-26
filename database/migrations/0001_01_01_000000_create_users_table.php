<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->string('name', 100)->comment('User full name');
            $table->string('username', 255)->nullable()->comment('nullable');
            $table->string('last_name', 255)->nullable();
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();


            $table->dateTime('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('post_code', 50)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->text('short_bio')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->string('profile_image', 255)->nullable();
            $table->text('work_information')->nullable();
            $table->string('dot_information', 255)->nullable();
            $table->enum('relationship_status', ['single', 'married', 'unmarried'])->nullable();
            $table->string('sexual_orientation', 50)->nullable();
            $table->string('hiv_status')->nullable();

            $table->string('google_id', 255)->nullable();
            $table->string('facebook_id', 255)->nullable();
            $table->string('apple_id', 255)->nullable();


            $table->string('fcm_token', 255)->nullable();


            // $table->enum('shop_status', ['approve', 'pending', 'cancel'])->default('pending');
            $table->boolean('is_agree')->default(true);
            $table->enum('block_status', ['blocked', 'unblock'])->default('unblock');


            $table->string('reset_password_token', 255)->nullable();
            $table->dateTime('reset_password_token_expires_at')->nullable();


            $table->decimal('latitude', 10, 8)->nullable()->comment('User GPS latitude');
            $table->decimal('longitude', 11, 8)->nullable()->comment('User GPS longitude');


            $table->string('otp', 50)->nullable();
            $table->dateTime('otp_expires_at')->nullable();
            $table->dateTime('otp_verified_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('verification_status', ['pending', 'verified'])->default('pending');


            $table->enum('user_type', ['admin', 'superadmin', 'civilian', 'driver'])->default('civilian');

             $table->timestamp('deleted_at')->nullable();
            $table->text('account_delete_comment')->nullable();
            $table->text('account_delete_reason')->nullable();

            $table->dateTime('last_login')->nullable();

           $table->unsignedBigInteger('truck_id')->nullable();
           $table->foreign('truck_id')->references('id')->on('truck_manages')->onDelete('set null');


            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
