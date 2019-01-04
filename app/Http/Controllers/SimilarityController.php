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
        $similarities = Similarity::where('batch', $batch)
                                    ->where('similarity','>=',0.5)
                                    ->orderBy('first_tweet_id', 'asc')
                                    ->orderBy('similarity', 'desc')
                                    ->get();
        $similarities_distinct = Similarity::where('batch', $batch)
                                    ->where('similarity','>=',0.5)
                                    ->select('first_tweet_id')
                                    ->distinct()
                                    ->get();
        $row_count = count($similarities_distinct);
        
        return view('similarity.index', [
            'current_batch' => $batch,
            'batches' => $batches, 
            'similarities' => $similarities, 
            'similarities_distinct' => $similarities_distinct,
            'row_count' => $row_count
        ]);
    }
}
