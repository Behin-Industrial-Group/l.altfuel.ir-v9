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
        Schema::create('fin_info', function (Blueprint $table) {
            $table->id();
            $table->string('agency_table');
            $table->unsignedBigInteger('agency_id');
            $table->string('name');
            $table->string('ref_id')->nullable();
            $table->string('pay_date')->nullable();
            $table->text('description');
            $table->binary('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_info');
    }
};
