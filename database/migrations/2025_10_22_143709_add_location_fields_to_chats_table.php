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
    Schema::table('chats', function (Blueprint $table) {
        
        $table->decimal('latitude', 10, 7)->nullable()->after('media_type');
        $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
    });
}

public function down()
{
    Schema::table('chats', function (Blueprint $table) {
        $table->dropColumn(['media_url', 'media_type', 'latitude', 'longitude']);
    });
}

};
