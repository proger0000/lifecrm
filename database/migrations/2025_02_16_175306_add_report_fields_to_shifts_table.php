<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportFieldsToShiftsTable extends Migration
{
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->integer('visitors')->nullable()->after('check_out_time');
            $table->integer('incidents')->nullable()->after('visitors');
            $table->integer('first_aid')->nullable()->after('incidents');
            $table->integer('violations')->nullable()->after('first_aid');
        });
    }

    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn(['visitors', 'incidents', 'first_aid', 'violations']);
        });
    }
}
