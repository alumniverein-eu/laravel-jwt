<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique();
            $table->float('amount', 8, 2)->nullable();
            $table->enum('project', ['sbe', 'sbw', 'epd', 'none'])->default('none');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->char('end_reason', 200)->nullable();
            $table->jsonb('json')->default('{}');
            $table->enum('project', ['active', 'passive'])->default('active');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('memberships');
    }
}
