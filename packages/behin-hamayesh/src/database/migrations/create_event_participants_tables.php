<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create tables for each event
        for ($i = 1; $i <= 4; $i++) {
            Schema::create("event_{$i}_participants", function (Blueprint $table) {
                $table->id();
                $table->string('ticket_id')->nullable();
                $table->string('user_id');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('username');
                $table->string('national_code')->unique();
                $table->string('ticket');
                $table->string('role');
                $table->string('type');
                $table->string('status');
                $table->boolean('is_verified')->default(false);
                $table->string('verified_by')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        for ($i = 1; $i <= 4; $i++) {
            Schema::dropIfExists("event_{$i}_participants");
        }
    }
};