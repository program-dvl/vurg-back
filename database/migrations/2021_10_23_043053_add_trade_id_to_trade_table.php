<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTradeIdToTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('trade', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->decimal('currency_amount',32,4)->nullable()->change();
            $table->decimal('crypto_amount',32,16)->nullable()->change();
        });
        Schema::table('trade', function (Blueprint $table) {
            $table->uuid('trade_id')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade', function (Blueprint $table) {
            $table->dropColumn('trade_id');
        });
    }
}
