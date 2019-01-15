<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Similarity;

class PredictionController extends Controller
{
    public function index()
    {
        $data = Similarity::select('batch', 'prediction', DB::raw('count(1) as count'))->orderBy('batch','desc')->groupBy('batch', 'prediction')->get();
        return view('prediction.index', [
            'data' => $data
        ]);
    }

    public function view($batch)
    {
        $data = Similarity::where('batch', $batch)->get();
        return view('prediction.view', [
            'batch' => $batch,
            'data' => $data
        ]);
    }
}
