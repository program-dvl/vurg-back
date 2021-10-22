<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLockedToUserWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->decimal('locked',15,10);
        });
        Schema::table('user_wallet', function (Blueprint $table) {
            $table->decimal('locked')->default(0)->change();
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
            $table->dropColumn('locked');
        });
    }
}
