<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddButtonTextAndUrlToContactFieldsTable extends Migration
{
    public function up()
    {
        Schema::table('contact_fields', function (Blueprint $table) {
            $table->string('button_text')->nullable()->after('placeholder');
            $table->string('button_url')->nullable()->after('button_text');
        });
    }
    public function down()
    {
        Schema::table('contact_fields', function (Blueprint $table) {
            $table->dropColumn(['button_text', 'button_url']);
        });
    }
}
