<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->unique(); // username needs to be unique
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique(); // email needs to be unique
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->string('language')->nullable();
            $table->rememberToken();
            $table->timestamp('online_at');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
