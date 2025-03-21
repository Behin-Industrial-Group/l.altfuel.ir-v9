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
        Schema::table('kamfeshar', function (Blueprint $table) {
            $table->string('InsUserDelivered')->after('FinDetails')->nullable();
        });

        Schema::table('hidro', function (Blueprint $table) {
            $table->string('InsUserDelivered')->after('FinDetails')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kamfeshar', function (Blueprint $table) {
            //
        });
    }
};
