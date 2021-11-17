<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlayerNormalization2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::rename('player','players');

        Schema::create('player_scholar_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('scholar_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('scholar_id')
                ->references('id')->on('scholars');
            $table->foreign('player_id')
                ->references('id')->on('players');
        });

//        Schema::create('reminders', function (Blueprint $table) {
//           $table->increments('id');
//           $table->integer('scholar_id');
//           $table->tinyInteger('type')->default(1);
//           $table->timestamp('remind_on')->nullable()->default(null);
//           $table->string('subject');
//           $table->text('message');
//           $table->timestamps();
//            $table->foreign('scholar_id')
//                ->references('id')->on('scholars')
//                ->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('players','player');
        Schema::drop('player_scholar_histories');
//        Schema::drop('reminders');
    }
}
