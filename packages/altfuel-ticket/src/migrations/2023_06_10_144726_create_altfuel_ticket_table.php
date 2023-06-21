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
        Schema::create('altfuel_ticket_catagories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('altfuel_tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('cat_id')->unsigned();
            $table->string('title');
            $table->string('status')->default('new');
            $table->tinyInteger('junk')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cat_id')->references('id')->on('altfuel_ticket_catagories');
        });

        Schema::create('altfuel_ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_id')->unsigned();
            $table->integer('user_id');
            $table->text('text')->nullable();
            $table->string('voice')->nullable();
            $table->timestamps();
            $table->foreign('ticket_id')->references('id')->on('altfuel_tickets');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('altfuel_comment_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('comment_id')->unsigned();
            $table->string('file');
            $table->timestamps();
            $table->foreign('comment_id')->references('id')->on('altfuel_ticket_comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('altfuel_ticket_catagories');
        Schema::dropIfExists('altfuel_tickets');
        Schema::dropIfExists('altfuel_ticket_comments');
        Schema::dropIfExists('altfuel_comment_attachments');
    }
};
