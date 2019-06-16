<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cve', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->unique('name');
            $table->string('status',255)->nullable();
            $table->text('description')->nullable();
            $table->text('references')->nullable();
            $table->text('phase')->nullable();
            $table->text('votes')->nullable();
            $table->text('comments')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cve');
    }
}
