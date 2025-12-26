<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSectionFeaturesTable extends Migration
{
    public function up()
    {
        Schema::create('hero_section_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_section_id')->constrained()->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('text');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_section_features');
    }
}

