@extends('layouts.app')

@section('title', 'Similarity')

@section('content')
<h1>Prediction for batch {{ $batch }}</h1>

<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>tweet_id</th>
            <th>full_text_clean</th>
            <th>similarity</th>
            <th>prediction</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data as $row)
        <tr>
            <td>{{ $row->first_tweet_id }}</td>
            <td>{{ $row->first_tweet->full_text_clean }}</td>
            <td>{{ $row->similarity }}</td>
            <td>{{ $row->prediction }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection