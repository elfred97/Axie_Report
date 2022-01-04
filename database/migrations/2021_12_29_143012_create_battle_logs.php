<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBattleLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('battle_logs')) {
            Schema::create('battle_logs', function (Blueprint $table) {
                $table->increments('id');
                $table->text('ronin_address')->nullable();
                $table->text('account_name')->nullable();
                $table->dateTime('last_claim_date')->nullable()->default(NULL);
                $table->dateTime('claimable_on')->nullable()->default(NULL);
                $table->integer('draw_total')->nullable()->default(NULL);
                $table->integer('lose_total')->nullable()->default(NULL);
                $table->integer('win_total')->nullable()->default(NULL);
                $table->integer('total_matches')->nullable()->default(NULL);
                $table->integer('win_rate')->nullable()->default(NULL);
                $table->integer('average_per_day')->nullable()->default(NULL);
                $table->integer('gained_slp_today')->nullable()->default(NULL);
                $table->integer('last_claim_days')->nullable()->default(NULL);
                $table->integer('thirty_percent')->nullable()->default(NULL);
                $table->integer('forty_percent')->nullable()->default(NULL);
                $table->integer('manager_share')->nullable()->default(NULL);
                $table->integer('scholar_share')->nullable()->default(NULL);
                $table->integer('manager_slp')->nullable()->default(NULL);
                $table->integer('scholar_slp')->nullable()->default(NULL);
                $table->integer('claimed')->nullable()->default(NULL);
                $table->integer('raw_total')->nullable()->default(NULL);
                $table->integer('unclaimed')->nullable()->default(NULL);
                $table->integer('lifetime_slp')->nullable()->default(NULL);
                $table->integer('total_slp')->nullable()->default(NULL);
                $table->integer('mmr')->nullable()->default(NULL);
                $table->integer('rank')->nullable()->default(NULL);
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
        Schema::dropIfExists('battle_logs');
    }
}
