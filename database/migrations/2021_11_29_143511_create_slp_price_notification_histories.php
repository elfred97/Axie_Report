<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlpPriceNotificationHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slp_price_notification_histories', function (Blueprint $table) {
            $table->id();
            $table->decimal('value',20,10);
            $table->string('currency');
            $table->timestamp('sent_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slp_price_notification_histories');
    }
}
