<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Similarity extends Model
{
    public function first_tweet()
    {
        return $this->belongsTo('App\Tweet', 'first_tweet_id', 'tweet_id');
    }

    public function second_tweet()
    {
        return $this->belongsTo('App\Tweet', 'second_tweet_id', 'tweet_id');
    }
}
