<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calls_report', function (Blueprint $table) {
            $table->integer('answer')->default(0);
            $table->integer('unanswer')->default(0);
            $table->integer('busy')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_report', function (Blueprint $table) {
            //
        });
    }
};
