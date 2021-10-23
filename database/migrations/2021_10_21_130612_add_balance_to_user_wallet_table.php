<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceToUserWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->decimal('balance',32,16)->after('wallet_id');
        });
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->decimal('balance',32,16)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
}
