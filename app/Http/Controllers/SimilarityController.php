<?php

namespace App\Http\Controllers;

use App\Similarity;
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
        $row_count = Similarity::where('batch', $batch)
                                    ->where('similarity','>=',0.5)
                                    ->distinct('first_tweet_id')
                                    ->count();
        
        return view('similarity.index', [
            'current_batch' => $batch,
            'batches' => $batches, 
            'similarities' => $similarities, 
            'row_count' => $row_count
        ]);
    }
}
