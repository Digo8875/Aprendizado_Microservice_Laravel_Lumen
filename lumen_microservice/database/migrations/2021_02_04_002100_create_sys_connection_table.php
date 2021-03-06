<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysConnectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_connection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('sys_key', 150);
            $table->string('sys_secret', 150);
            $table->string('sys_access_token', 150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_connection');
    }
}
