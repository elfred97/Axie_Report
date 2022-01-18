<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerScholarHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('player_scholar_histories')) {
            Schema::create('player_scholar_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('scholar_id')->unsigned();
                $table->integer('player_id')->unsigned();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
                $table->foreign('scholar_id')->nullable()
                ->references('id')->on('scholars');
                $table->foreign('player_id')->nullable()
                    ->references('id')->on('players');
                });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('player_scholar_histories');
    }
}
