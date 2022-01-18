<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationScholarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('notification_scholars')) {
            Schema::create('notification_scholars', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('player_id')->nullable();
                $table->text('account_name')->nullable();
                $table->integer('category')->nullable()->comment('1 = slp , 2 = mmr, 3 = terminated_resigned');
                $table->tinyInteger('status')->nullable()->default(1)->comment('1 = unread , 2 = read');
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
        Schema::dropIfExists('notification_scholars');
    }
}
