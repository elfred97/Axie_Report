<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlayerTableNormalize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('account_name');
            $table->dropColumn('scholar_email');
            $table->dropColumn('email_password');
            $table->dropColumn('date_started');
            $table->dropColumn('type');
            $table->dropColumn('status');
        });
        Schema::create('scholars', function (Blueprint $table) {
            $table->increments('id');
            $table->text('first_name')->nullable();
            $table->text('middle_name')->nullable();
            $table->text('last_name')->nullable();
            $table->string('username', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('password');
            $table->string('status', 255)->nullable();
            $table->integer('type_id')->nullable();
            $table->date('date_started')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player', function (Blueprint $table) {
            $table->text('first_name')->nullable();
            $table->text('middle_name')->nullable()->default(NULL);
            $table->text('last_name')->nullable();
            $table->string('account_name', 255)->nullable()->default(NULL);
            $table->string('scholar_email', 255)->nullable()->default(NULL);
            $table->string('email_password', 255)->nullable()->default(NULL);
            $table->date('date_started')->nullable()->default(NULL);
            $table->string('type', 255)->nullable()->default(NULL);
            $table->string('status', 255)->nullable()->default(NULL);
        });

        Schema::dropIfExists('scholars');
    }
}
