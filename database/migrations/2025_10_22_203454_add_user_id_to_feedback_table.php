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
    Schema::table('feedback', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable()->after('id');
        // Optionally: add foreign key constraint
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('feedback', function (Blueprint $table) {
        $table->dropColumn('user_id');
    });
}

};
