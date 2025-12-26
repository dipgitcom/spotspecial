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
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique();
            $table->string('badge')->nullable();
            $table->string('headline')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();       // ticked features
            $table->json('buttons')->nullable();        // CTAs
            $table->string('rating')->nullable();       // e.g. "4.9/5 blandt københavnske kunder"
            $table->json('panel')->nullable();          // right-side panel grid content (title, items)
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
