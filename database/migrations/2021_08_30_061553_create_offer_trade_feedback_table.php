<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferTradeFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_trade_feedback', function (Blueprint $table) {
            $table->id();
            $table->integer("offer_id");
            $table->integer("from_buyer");
            $table->integer("from_seller");
            $table->tinyInteger("positive")->default(0);
            $table->tinyInteger("negative")->default(0);
            $table->string("comment")->default(0);
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
        Schema::dropIfExists('offer_trade_feedback');
    }
}
