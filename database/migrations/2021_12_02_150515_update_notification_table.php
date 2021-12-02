<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('notification')) {
            if (!Schema::hasColumn('notification', 'reminder_id')) {
                Schema::table('notification', function(Blueprint $table){
                    $table->integer('reminder_id')->nullable()->default(NULL)->after('category')->references('id')->on('reminders');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
