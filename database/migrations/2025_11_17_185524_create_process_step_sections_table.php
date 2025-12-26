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
    Schema::create('process_step_sections', function (Blueprint $table) {
        $table->id();
        $table->string('title')->default('This is how it takes');
        $table->string('subtitle')->nullable(); // e.g. Transparency note
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_step_sections');
    }
};
