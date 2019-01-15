<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::delete('/tweet_account/{id}', 'TweetAccountController@destroy');
Route::post('/tweet_account', 'TweetAccountController@store');
Route::get('/tweet_account', 'TweetAccountController@index');

Route::delete('/tweets/{id}', 'TweetController@destroy');
Route::get('/tweets', 'TweetController@index');

Route::delete('/normalization/{id}', 'NormalizationController@destroy');
Route::post('/normalization', 'NormalizationController@store');
Route::get('/normalization', 'NormalizationController@index');

Route::get('/similarity', 'SimilarityController@index');

Route::get('/prediction', 'PredictionController@index');
Route::get('/prediction/{batch}', 'PredictionController@view');