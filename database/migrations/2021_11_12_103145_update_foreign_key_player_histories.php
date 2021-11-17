<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyPlayerHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_scholar_histories', function (Blueprint $table) {
            $table->foreign('scholar_id')->nullable()
                ->references('id')->on('scholars');
            $table->foreign('player_id')->nullable()
                ->references('id')->on('players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_scholar_histories', function (Blueprint $table) {
            $table->foreign('scholar_id')->nullable()
                ->references('id')->on('scholars');
            $table->foreign('player_id')->nullable()
                ->references('id')->on('players');
        });
    }
}
