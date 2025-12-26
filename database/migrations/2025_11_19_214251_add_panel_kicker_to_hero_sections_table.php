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
    Schema::table('hero_sections', function (Blueprint $table) {
        $table->string('panel_kicker', 120)->nullable()->after('rating');
    });
}

public function down()
{
    Schema::table('hero_sections', function (Blueprint $table) {
        $table->dropColumn('panel_kicker');
    });
}

};
