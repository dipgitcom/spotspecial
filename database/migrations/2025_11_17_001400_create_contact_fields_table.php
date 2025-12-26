<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('contact_fields', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // name, phone, email, area, spots, description, button
        $table->string('label');
        $table->string('placeholder')->nullable();
        $table->string('type')->default('text'); // text, email, number, select, textarea, button
        $table->boolean('required')->default(true);
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_fields');
    }
};
