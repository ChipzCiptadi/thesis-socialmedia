@extends('layouts.app')

@section('title', 'Similarity')

@section('content')
<h1>Prediction</h1>

<?php $pivot = array(); $last_batch = 0; $count = 0; ?>
@foreach ($data as $row)
    @if ($last_batch != $row['batch'])
        @php
            $count++;
            array_push($pivot, array('batch'=>$row['batch'],'news'=>0,'entertainment'=>0,'health'=>0,'sport'=>0,'technology'=>0));
            $last_batch = $row['batch'];
        @endphp
    @endif
    @php
        $pivot[$count-1][$row['prediction']] = $row['count'];
    @endphp
@endforeach

<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Batch</th>
            <th>News</th>
            <th>Entertainment</th>
            <th>Health</th>
            <th>Sport</th>
            <th>Technology</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($pivot as $row)
        <tr>
            <td><a href="/prediction/{{ $row['batch'] }}" target="_blank">{{ $row['batch'] }}</a></td>
            <td>{{ $row['news'] }}</td>
            <td>{{ $row['entertainment'] }}</td>
            <td>{{ $row['health'] }}</td>
            <td>{{ $row['sport'] }}</td>
            <td>{{ $row['technology'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@endsection