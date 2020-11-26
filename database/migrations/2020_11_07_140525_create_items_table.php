<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('gender');
            $table->integer('level');
            $table->integer('sub_category_id');
            $table->string('job');
            $table->string('icon');
            $table->integer('ability_min')->nullable();
            $table->integer('ability_max')->nullable();
            $table->string('effect_1');
            $table->string('effect_2');
            $table->string('effect_3');
            $table->string('handed');
            $table->integer('set_id')->nullable();
            $table->enum('status', ['active', 'in-active'])->default('active');
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
        Schema::dropIfExists('items');
    }
}
