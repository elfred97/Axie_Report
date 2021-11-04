<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('import')) {
            Schema::create('import', function(Blueprint $table){
                $table->increments('id');
                $table->text('file_name')->nullable();
                $table->text('path')->nullable();
                $table->integer('status')->nullable()->default(NULL);
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
        Schema::dropIfExists('import');
    }
}
