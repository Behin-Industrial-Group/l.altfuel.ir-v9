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
        Schema::create('irngv_users_info', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->string('issued_date');
            $table->string('owner_national_id');
            $table->string('owner_fullname');
            $table->string('owner_mobile');
            $table->string('customer_fullname');
            $table->string('customer_mobile');
            $table->string('car_name');
            $table->string('chassis');
            $table->string('plaque');
            $table->string('agency_code');
            $table->string('agency_name');
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
        Schema::dropIfExists('irngv_users_info_tbale');
    }
};
