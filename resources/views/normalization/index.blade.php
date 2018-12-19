<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Normalization</title>
</head>
<body>
    <div>
        <a href="/">&lt; back</a>
    </div>
    <h1>Normalization</h1>

    <div>
        <strong>Note:</strong>
        <ul>
            <li>Abnormal hanya boleh satu kata</li>
            <li>Fitur yang belum ada: searching kata</li>
        </ul>
    </div>

    <br>

    <div>
        random 5 tweets:
    </div>
    <table border="1">
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

    <div>
        <h3>Add new dictionary</h3>
        <form action="/normalization" method="post">
            @method('POST')
            @csrf
            <div>
                <label for="abnormal">Abnormal Word:</label>
                <input type="text" name="abnormal" id="abnormal" placeholder="Abnormal word" required>
            </div>
            <div>
                <label for="normal">Normal Word:</label>
                <input type="text" name="normal" id="normal" placeholder="Normal word" required>
            </div>
            <div>
                <input type="submit" value="Create">
            </div>
        </form>
    </div>

    <div>
        Total: <strong>{{ $count }}</strong> rows | Showing last 100 words
    </div>
    
    <table border="1">
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
                        <input type="submit" value="Remove" onclick="return confirm('Delete this?');">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.getElementById('abnormal').focus();
    </script>
</body>
</html>