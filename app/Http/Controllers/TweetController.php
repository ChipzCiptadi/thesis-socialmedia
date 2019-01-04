<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        $data = Tweet::orderBy('tweet_id', 'desc')->simplePaginate(100);
        $count = Tweet::count();
        return view('tweets.index', ['data' => $data, 'count' => $count]);
    }

    public function destroy(Tweet $id)
    {
        $id->delete();
        
        return redirect('/tweets');
    }
}
