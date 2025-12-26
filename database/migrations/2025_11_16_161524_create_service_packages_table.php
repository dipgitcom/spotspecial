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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('price');
            $table->text('subtitle')->nullable();    // description
            $table->json('features')->nullable();    // list of features/benefits
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->string('type')->default('default'); // e.g. start, design, bath
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
