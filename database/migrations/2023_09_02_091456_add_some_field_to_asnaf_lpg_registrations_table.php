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
        Schema::table('asnaf_lpg_registerations', function (Blueprint $table) {
            $table->string('father_name');
            $table->string('birth_date', 10);
            $table->string('postal_code');
            $table->text('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asnaf_lpg_registrations', function (Blueprint $table) {
            //
        });
    }
};
