<?php

namespace App\Http\Controllers;

use App\Similarity;
use App\Tweet;
use Illuminate\Http\Request;

class SimilarityController extends Controller
{
    public function index(Request $request)
    {
        // get latest batch number
        $batch = $request->input('batch');
        if (!$batch)
        {
            $batch = Similarity::orderBy('batch', 'desc')->take(1)->select('batch')->first();
            $batch = ($batch) ? $batch->batch : 0;
        }

        $batches = Similarity::orderBy('batch','desc')->select('batch')->distinct()->get();
        $similarities = Similarity::where('batch', $batch)->orderBy('first_tweet_id', 'asc')->orderBy('second_tweet_id', 'asc')->get();
        $tweets = Tweet::where('batch', $batch)->orderBy('tweet_id', 'asc')->get();
        $row_count = count($tweets);
        
        return view('similarity.index', [
            'current_batch' => $batch,
            'batches' => $batches, 
            'similarities' => $similarities, 
            'tweets' => $tweets, 
            'row_count' => $row_count
        ]);
    }
}
