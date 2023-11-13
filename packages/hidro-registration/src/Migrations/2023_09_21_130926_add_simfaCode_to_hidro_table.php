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
        Schema::table('hidro', function (Blueprint $table) {
            $table->string('simfaCode')->nullable();
            $table->string('legalNationalId')->nullable();
            $table->string('standardCertificateNumber')->nullable();
            $table->string('standardCertificateExpDate')->nullable();
            $table->string('Authority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
