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
        if (!Schema::hasTable('player')) {
            Schema::create('player', function (Blueprint $table) {
                $table->increments('id');
                $table->text('first_name')->nullable();
                $table->text('middle_name')->nullable()->default(NULL);
                $table->text('last_name')->nullable();
                $table->string('account_name', 255)->nullable()->default(NULL);
                $table->string('ronin_address', 255)->nullable()->default(NULL);
                $table->string('scholar_email', 255)->nullable()->default(NULL);
                $table->string('market_place_email', 255)->nullable()->default(NULL);
                $table->string('email_password', 255)->nullable()->default(NULL);
                $table->date('date_started')->nullable()->default(NULL);
                $table->integer('penalty')->nullable()->default(0);
                $table->integer('scholar_share')->nullable()->default(0);
                $table->integer('manager_share')->nullable()->default(0);
                $table->string('type', 255)->nullable()->default(NULL);
                $table->string('status', 255)->nullable()->default(NULL);
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
        Schema::dropIfExists('player');
    }
}
