<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSectionButtonsTable extends Migration
{
    public function up()
    {
        Schema::create('hero_section_buttons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_section_id')->constrained()->onDelete('cascade');
            $table->string('text');
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_section_buttons');
    }
}
