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
        $table->string('media_url')->nullable()->after('message');
        $table->string('media_type')->nullable()->after('media_url');
    });
}

public function down()
{
    Schema::table('chats', function (Blueprint $table) {
        $table->dropColumn(['media_url', 'media_type']);
    });
}

};
