<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tweet Account</title>
</head>
<body>
    <div>
        <a href="/">&lt; back</a>
    </div>
    <h1>Tweet Account</h1>

<div>
    <h3>Add new account</h3>
    <form action="/tweet_account" method="post">
        @method('POST')
        @csrf
        <div>
            <label for="screen_name">Screen Name:</label>
            <input type="text" name="screen_name" id="screen_name" placeholder="Screen Name" required>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Name" required>
        </div>
        <div>
            <input type="submit" value="Create">
        </div>
    </form>
</div>

    <table border="1">
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
                <td>{{ $row->screen_name }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->last_tweet_id }}</td>
                <td>{{ $row->is_active }}</td>
                <td>
                    <form action="/tweet_account/{{ $row->id }}" method="post">
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
        document.getElementById('screen_name').focus();
    </script>
</body>
</html>