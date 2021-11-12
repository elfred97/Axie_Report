<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotificationSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->string('model', 50)->after('id')->default('App\Models\User');
            $table->integer('model_id')->after('model')->nullable();
            if(Schema::hasColumn('notification_settings','username')) {
                $table->dropColumn('username');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->dropColumn('model');
            $table->dropColumn('model_id');
        });
    }
}
