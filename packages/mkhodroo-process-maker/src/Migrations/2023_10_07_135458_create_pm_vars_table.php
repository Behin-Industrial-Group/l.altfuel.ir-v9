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
        Schema::create('pm_variables', function (Blueprint $table) {
            $table->id();
            $table->string('process_uid');
            $table->string('var_uid')->unique();
            $table->string('var_title');
            $table->string('type');
            $table->string('accepted_value');
            $table->string('default_value')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('pm_vars');
    }
};
