<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimilaritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('similarities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch');
            $table->bigInteger('first_tweet_id');
            $table->bigInteger('second_tweet_id');
            $table->float('similarity', 8, 6);
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
        Schema::dropIfExists('similarities');
    }
}
