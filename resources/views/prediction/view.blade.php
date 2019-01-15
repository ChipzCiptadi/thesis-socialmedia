@extends('layouts.app')

@section('title', 'Prediction')

@section('content')
<h1>Prediction for batch {{ $batch }}</h1>

<div class="jumbotron">
    <form action="/prediction/{{ $batch }}" method="get">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="show_exact" id="show_exact" {{ ($show_exact == 'on') ? 'checked' : '' }}>
            <label class="form-check-label" for="show_exact">Show similarity = 1.0</label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Go</button>
    </form>
</div>

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