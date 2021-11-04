<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('notification')) {
            Schema::create('notification', function(Blueprint $table){
                $table->increments('id');
                $table->text('account_name')->nullable();
                $table->integer('gained_slp_today')->nullable()->default(NULL);
                $table->integer('penalty')->nullable()->default(NULL);           
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
        Schema::dropIfExists('notification');
    }
}
