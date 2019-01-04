<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Similarity extends Model
{
    public function tweet()
    {
        return $this->belongsTo('App\Tweet', 'first_tweet_id', 'tweet_id');
    }
}
