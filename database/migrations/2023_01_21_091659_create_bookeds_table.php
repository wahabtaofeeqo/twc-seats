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
        Schema::create('bookeds', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->date('event_date')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('seat_id')->unsigned()->nullable();
            $table->integer('seat_number')->unsigned()->nullable();
            $table->enum('type', ['white', 'blue'])->default('blue');
            $table->boolean('confirmed')->nullable()->default(false);
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('bookeds');
    }
};
