<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->increments('id');
                $table->text('first_name')->nullable();
                $table->text('middle_name')->nullable()->default(NULL);
                $table->text('last_name')->nullable();
                $table->string('username', 255)->nullable()->default(NULL);
                $table->text('password')->nullable()->default(NULL);
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
        Schema::dropIfExists('user');
    }
}
