<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payrolls');

        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->integer('scholar_id')->unsigned();
            $table->integer('player_id')->unsigned();
            $table->integer('total_slp')->nullable()->default(0);
            $table->string('txn_id',100)->nullable()->default(null);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('scholar_id')->nullable()
                ->references('id')->on('scholars')->onDelete('cascade');
            $table->foreign('player_id')->nullable()
                ->references('id')->on('players')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
