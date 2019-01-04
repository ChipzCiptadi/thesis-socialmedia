<?php

namespace App\Http\Controllers;

use App\Normalization;
use App\Tweet;
use Illuminate\Http\Request;

class NormalizationController extends Controller
{
    public function index()
    {
        $data = Normalization::orderBy('id', 'desc')->simplePaginate(100);
        $count = Normalization::count();
        $random_tweets = Tweet::inRandomOrder()->take(5)->get();
        return view('normalization.index', ['data' => $data, 'count' => $count, 'random_tweets' => $random_tweets]);
    }

    public function store(Request $request)
    {
        if (!Normalization::where('abnormal','=',strtolower($request->abnormal))->exists()) {
            $normalization = new Normalization;

            $normalization->abnormal = strtolower($request->abnormal);
            $normalization->normal = strtolower($request->normal);

            $normalization->save();
        }

        return redirect('/normalization');
    }

    public function destroy(Normalization $id)
    {
        $id->delete();

        return redirect('/normalization');
    }
}
