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
        Schema::create('navbar_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();       // Store logo filename
            $table->string('name');                   // Site name or logo text
            $table->string('phone');                  // Phone number
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbar_settings');
    }
};
