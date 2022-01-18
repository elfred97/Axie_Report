<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('players')) {
            Schema::create('players', function (Blueprint $table) {
                $table->increments('id');
                $table->string('ronin_address', 255)->nullable()->default(NULL);
                $table->string('account_name', 255)->nullable()->default(NULL);
                $table->string('password', 255)->nullable()->default(NULL);
                $table->string('market_place_email', 255)->nullable()->default(NULL);
                $table->integer('penalty')->nullable()->default(0);
                $table->integer('scholar_share')->nullable()->default(0);
                $table->integer('manager_share')->nullable()->default(0);
                $table->text('qr_code')->nullable();
                $table->dateTime('qr_code_date')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('players');
    }
}
