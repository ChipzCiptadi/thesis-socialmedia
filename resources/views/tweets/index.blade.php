@extends('layouts.app')

@section('title', 'Tweets')

@section('content')
    <h1>Tweets</h1>

    <div>
        <strong>Note:</strong>
        <ul>
            <li>Tweet diambil dari tweet yang mention @tweet_account (exclude retweet)</li>
            <li>full_text_clean = full_text + cleansing (lowercase, @mention, url/links, #hashtag, $ymb0l&amp;Num83r) + normalization + stemming + stopwords removal</li>
            <li>Tweet yang umurnya > 3 hari akan dihapus</li>
        </ul>
    </div>

    <div>
        Total: <strong>{{ $count }}</strong> rows | Showing 100 tweets sorted by recent
    </div>

    {{ $data->links() }}

    <table class="table table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th>tweet_id</th>
                <th>screen_name</th>
                <th>full_text</th>
                <th>full_text_clean</th>
                <th>tweet_created_at</th>
                <!-- <th>in_reply_to_status_id</th>
                <th>in_reply_to_user_id</th>
                <th>is_reply</th>
                <th>retweet_count</th>
                <th>favorite_count</th> -->
                <th>remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->tweet_id }}</td>
                <td>{{ $row->screen_name }}</td>
                <td>{{ $row->full_text }}</td>
                <td>{{ $row->full_text_clean }}</td>
                <td>{{ $row->tweet_created_at }}</td>
                <!-- <td>{{ $row->in_reply_to_status_id }}</td>
                <td>{{ $row->in_reply_to_user_id }}</td>
                <td>{{ $row->is_reply }}</td>
                <td>{{ $row->retweet_count }}</td>
                <td>{{ $row->favorite_count }}</td> -->
                <td>
                    <form action="/tweets/{{ $row->tweet_id }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" value="Remove" onclick="return confirm('Delete this?');">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection