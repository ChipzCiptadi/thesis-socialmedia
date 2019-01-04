<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->bigIncrements('tweet_id');
            $table->string('screen_name', 50);
            $table->string('full_text', 350);
            $table->string('full_text_clean', 300)->nullable();
            $table->dateTime('tweet_created_at');
            $table->string('in_reply_to_status_id', 30)->nullable();
            $table->string('in_reply_to_user_id', 30)->nullable();
            $table->tinyInteger('is_reply');
            $table->unsignedSmallInteger('retweet_count');
            $table->unsignedSmallInteger('favorite_count');
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
        Schema::dropIfExists('tweets');
    }
}
