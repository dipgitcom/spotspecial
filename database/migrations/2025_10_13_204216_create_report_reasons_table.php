<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportReasonsTable extends Migration
{
    public function up()
    {
        Schema::create('report_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_reasons');
    }
}