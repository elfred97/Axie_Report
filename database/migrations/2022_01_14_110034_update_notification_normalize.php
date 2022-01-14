<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationNormalize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn('account_name');
            $table->dropColumn('status_scholar');
            $table->dropColumn('admin_id');
        });
        Schema::table('notification', function (Blueprint $table) {
            $table->integer('scholar_id')->after('id')->nullable();
            $table->integer('admin_id')->after('scholar_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('notification', function(Blueprint $table){
            $table->text('account_name')->nullable();
            $table->tinyInteger('status_scholar')->nullable()->default(NULL);           
            $table->integer('admin_id')->nullable();
        });
    }
}
