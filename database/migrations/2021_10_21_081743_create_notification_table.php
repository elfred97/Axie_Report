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
                $table->integer('scholar_id')->nullable();
                $table->integer('admin_id')->nullable();
                $table->tinyInteger('category')->nullable()->default(NULL);
                $table->integer('notification_reminder_id')->nullable();
                $table->tinyInteger('status')->nullable()->default(1);           
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
