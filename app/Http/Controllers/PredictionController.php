<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Similarity;

class PredictionController extends Controller
{
    public function index()
    {
        $data = Similarity::select('batch', 'prediction', DB::raw('count(1) as count'))->orderBy('batch','desc')->groupBy('batch', 'prediction')->take(10)->get();
        return view('prediction.index', [
            'data' => $data
        ]);
    }
}
