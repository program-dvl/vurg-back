<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('cryptocurreny_type')->default(1)->comment("1:Bitcoin,2:Tether,3: Ethereum");
            $table->tinyInteger('offer_type')->default(1)->comment("1:Buy,2:Sell");
            $table->integer('payment_method')->nullable();
            $table->integer('preferred_currency')->nullable();
            $table->tinyInteger('trade_price_type')->default(1)->comment("1:Market Price, 2:Fixed Price");
            $table->decimal('offer_margin_percentage',15,2)->nullable();
            $table->decimal('offer_margin_fixed_price',15,2)->nullable();
            $table->integer('minimum_offer_trade_limits')->nullable()->default(0);
            $table->integer('maximum_offer_trade_limits')->nullable()->default(0);
            $table->integer('offer_time_limit')->nullable()->default(30)->comment("In Minutes only");
            $table->string('offer_label', 1000)->nullable();
            $table->string('offer_terms', 5000)->nullable();
            $table->string('trade_instruction', 5000)->nullable();
            $table->tinyInteger('require_verified_id')->default(0)->comment("0:No, 1:Yes");
            $table->integer('target_country')->nullable();
            $table->tinyInteger('offer_visibility')->nullable()->default(0);
            $table->integer('minimum_trade_Required')->nullable()->default(0);
            $table->integer('limit_for_new_users')->nullable()->default(0);
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
        Schema::dropIfExists('offers');
    }
}
