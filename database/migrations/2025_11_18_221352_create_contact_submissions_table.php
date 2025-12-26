<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // in migration file
public function up()
{
    Schema::create('contact_submissions', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->json('data'); // Store key-value pairs of submitted form data
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
