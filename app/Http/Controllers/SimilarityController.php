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
        $show_exact = $request->input('show_exact');
        $operand = '<';

        if (!$batch)
        {
            $batch = Similarity::orderBy('batch', 'desc')->take(1)->select('batch')->first();
            $batch = ($batch) ? $batch->batch : 0;
        }

        if ($show_exact != null && $show_exact == 'on')
        {
            $operand = '<=';
        }

        $batches = Similarity::orderBy('batch','desc')->select('batch')->distinct()->take(50)->get();
        $similarities = Similarity::where('batch', $batch)
                                    ->where('similarity', '>=', 0.5)
                                    ->where('similarity', $operand, 1)
                                    ->orderBy('first_tweet_id', 'asc')
                                    ->orderBy('similarity', 'desc')
                                    ->get();
        $row_count = Similarity::where('batch', $batch)
                                    ->where('similarity', '>=', 0.5)
                                    ->where('similarity', $operand, 1)
                                    ->distinct('first_tweet_id')
                                    ->count();
        
        return view('similarity.index', [
            'current_batch' => $batch,
            'show_exact' => $show_exact,
            'batches' => $batches, 
            'similarities' => $similarities, 
            'row_count' => $row_count
        ]);
    }
}
