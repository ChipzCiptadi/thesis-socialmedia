<?php

namespace App\Http\Controllers;

use App\TweetAccount;
use Illuminate\Http\Request;

class TweetAccountController extends Controller
{
    public function index()
    {
        $data = TweetAccount::all();
        return view('tweet_account.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $tweet_account = new TweetAccount;

        $tweet_account->screen_name = $request->screen_name;
        $tweet_account->name = $request->name;
        $tweet_account->is_active = 1;

        $tweet_account->save();

        return redirect('/tweet_account');
    }

    public function destroy(TweetAccount $id)
    {
        $id->delete();
        
        return redirect('/tweet_account');
    }
}
