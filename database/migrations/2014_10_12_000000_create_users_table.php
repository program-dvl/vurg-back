<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->tinyInteger('is_username_changed')->nullable()->default(0)->comment("0:No, 1:Yes");
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar_url')->nullable();
            $table->tinyInteger('display_name')->default(1)->comment("1:First name and initial, 2:Full name, 3:Hide full name");
            $table->tinyInteger('preferred_currency')->nullable();
            $table->string('notification_time_interval')->nullable();
            $table->tinyInteger('timezone')->nullable();
            $table->text('bio')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('preferred_currency')
                    ->references('id')->on('currencies')
                    ->onDelete('cascade');
            $table->foreign('timezone')
                    ->references('id')->on('timezones')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
