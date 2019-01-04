@extends('layouts.app')

@section('title', 'Tweet Account')

@section('content')
    <h1>Tweet Account</h1>

    <div class="jumbotron">
        <h3>Add new account</h3>
        <form action="/tweet_account" method="post">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="screen_name">Screen Name:</label>
                <input type="text" class="form-control" name="screen_name" id="screen_name" placeholder="Screen Name" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Create">
            </div>
        </form>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>id</th>
                <th>screen_name</th>
                <th>name</th>
                <th>last_tweet_id</th>
                <th>is_active</th>
                <th>remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td><a href="https://twitter.com/{{ $row->screen_name }}" target="_blank">{{ $row->screen_name }}</a></td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->last_tweet_id }}</td>
                <td>{{ $row->is_active }}</td>
                <td>
                    <form action="/tweet_account/{{ $row->id }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" value="Remove" onclick="return confirm('Delete this?');">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.getElementById('screen_name').focus();
    </script>

@endsection