<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->text('qr_code')->after('manager_share')->nullable();
            $table->dateTime('qr_code_date')->after('qr_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('qr_code');
            $table->dropColumn('qr_code_date');
         });
    }
}
