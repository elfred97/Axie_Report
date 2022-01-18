<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('scholars')) {
            Schema::create('scholars', function (Blueprint $table) {
                $table->increments('id');
                $table->text('first_name')->nullable();
                $table->text('middle_name')->nullable();
                $table->text('last_name')->nullable();
                $table->string('username', 255)->nullable();
                $table->string('email', 255)->nullable();
                $table->string('password');
                $table->text('ronin_wallet')->nullable();
                $table->string('status', 255)->nullable();
                $table->integer('type_id')->nullable();
                $table->date('date_started')->nullable();
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
        Schema::dropIfExists('scholars');
    }
}
