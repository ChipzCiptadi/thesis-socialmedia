@extends('layouts.app')

@section('title', 'Normalization')

@section('content')
    <h1>Normalization</h1>

    <div>
        <strong>Note:</strong>
        <ul>
            <li>Abnormal hanya boleh satu kata</li>
        </ul>
    </div>

    <br>

    <div>
        random 5 tweets:
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>tweet_id</th>
                <th>full_text</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($random_tweets as $tweet)
            <tr>
                <td>{{ $tweet->tweet_id }}</td>
                <td>{{ $tweet->full_text }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="jumbotron">
        <h3>Add new dictionary</h3>
        <form action="/normalization" method="post">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="abnormal">Abnormal Word:</label>
                <input type="text" class="form-control" name="abnormal" id="abnormal" placeholder="Abnormal word" required>
            </div>
            <div class="form-group">
                <label for="normal">Normal Word:</label>
                <input type="text" class="form-control" name="normal" id="normal" placeholder="Normal word" required>
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Create">
            </div>
        </form>
    </div>

    <div>
        Total: <strong>{{ $count }}</strong> rows | Showing 100 words sorted by recent
    </div>

    {{ $data->links() }}
    
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>id</th>
                <th>abnormal</th>
                <th>normal</th>
                <th>remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->abnormal }}</td>
                <td>{{ $row->normal }}</td>
                <td>
                    <form action="/normalization/{{ $row->id }}" method="post">
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
        document.getElementById('abnormal').focus();
    </script>
@endsection