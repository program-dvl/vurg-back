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
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('username')->unique();
            $table->tinyInteger('is_username_changed')->nullable()->default(0)->comment("0:No, 1:Yes");
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar_image')->nullable();
            $table->tinyInteger('display_name')->default(1)->comment("1:First name and initial, 2:Full name, 3:Hide full name");
            $table->tinyInteger('preferred_currency')->nullable();
            $table->string('notification_time_interval')->nullable();
            $table->tinyInteger('timezone')->nullable();
            $table->text('bio')->nullable();
            $table->rememberToken();
            $table->datetime('last_activity')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
