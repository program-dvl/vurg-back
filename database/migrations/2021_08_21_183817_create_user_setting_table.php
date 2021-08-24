<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('setting_id');
            $table->tinyInteger('web')->default(0)->comment("0:Inactive, 1:Active");
            $table->tinyInteger('email')->default(0)->comment("0:Inactive, 1:Active");
            $table->tinyInteger('telegram')->default(0)->comment("0:Inactive, 1:Active");
            $table->tinyInteger('app')->default(0)->comment("0:Inactive, 1:Active");
            $table->tinyInteger('other_setting')->default(0)->comment("0:Inactive, 1:Active");
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
        Schema::dropIfExists('user_setting');
    }
}
