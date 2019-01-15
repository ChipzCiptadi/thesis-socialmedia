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

    public function view(Request $request, $batch)
    {
        $show_exact = $request->input('show_exact');
        $operand = '<';
        if ($show_exact != null && $show_exact == 'on')
        {
            $operand = '<=';
        }

        $data = Similarity::where('batch', $batch)->where('similarity', $operand, '1.0')->get();

        return view('prediction.view', [
            'batch' => $batch,
            'show_exact' => $show_exact,
            'data' => $data
        ]);
    }
}
