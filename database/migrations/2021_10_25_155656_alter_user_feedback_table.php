<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_trade_feedback', function (Blueprint $table) {
            $table->integer('from_user')->after('id');
            $table->integer('to_user')->after('from_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_trade_feedback', function (Blueprint $table) {
            $table->dropColumn('from_user');
            $table->dropColumn('to_user');
        });
    }
}
