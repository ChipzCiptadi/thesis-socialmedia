<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tweets</title>
</head>
<body>
    <div>
        Links: 
        <a href="/tweets">Tweets</a> | 
        <a href="/tweet_account">Tweet Account</a> |
        <a href="/normalization">Normalization</a>
    </div>
    <h1>Tweets</h1>

    <div>
        Total: <strong>{{ $count }}</strong> rows | Showing last 100 tweets
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>tweet_id</th>
                <th>screen_name</th>
                <th>full_text</th>
                <th>full_text_clean</th>
                <th>tweet_created_at</th>
                <th>in_reply_to_status_id</th>
                <th>in_reply_to_user_id</th>
                <th>is_reply</th>
                <th>retweet_count</th>
                <th>favorite_count</th>
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
                <td>{{ $row->in_reply_to_status_id }}</td>
                <td>{{ $row->in_reply_to_user_id }}</td>
                <td>{{ $row->is_reply }}</td>
                <td>{{ $row->retweet_count }}</td>
                <td>{{ $row->favorite_count }}</td>
                <td>
                    <form action="/tweets/{{ $row->tweet_id }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Remove" onclick="return confirm('Delete this?');">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>