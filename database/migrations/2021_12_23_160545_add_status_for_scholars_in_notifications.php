<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusForScholarsInNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->tinyInteger('status_scholar')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn('status_scholar')->nullable()->default(NULL);
        });
    }
}
