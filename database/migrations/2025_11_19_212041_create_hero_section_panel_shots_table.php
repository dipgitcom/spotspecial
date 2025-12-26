<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroSectionPanelShotsTable extends Migration
{
    public function up()
    {
        Schema::create('hero_section_panel_shots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_section_id')->constrained()->onDelete('cascade');
            $table->string('caption');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_section_panel_shots');
    }
}
