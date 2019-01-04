@extends('layouts.app')

@section('title', 'Similarity')

@section('content')
    <h1>Similarity</h1>

    <div>
        <strong>Note:</strong>
        <ul>
            <li>Definisi batch adalah tweets yang diambil dalam kurun waktu 15 menit</li>
            <li>Step 1: <a href="https://scikit-learn.org/stable/modules/generated/sklearn.feature_extraction.text.TfidfVectorizer.html" target="_blank">TF-IDF</a> untuk konversi teks ke document term matrix</li>
            <li>Step 2: <a href="https://scikit-learn.org/stable/modules/generated/sklearn.metrics.pairwise.cosine_similarity.html" target="_blank">cosine similarity</a> untuk mendapatkan similarity result nya</li>
            <li>Step 3: ulangi step 2 untuk setiap tweet dalam batch</li>
            <li>Matrix tidak bisa show terlalu banyak data, kalau tweet terlalu banyak maka bisa error page</li>
        </ul>
    </div>

    <div class="jumbotron">
        <form action="/similarity" method="get">
            @method('GET')
            @csrf
            <div class="form-group">
                <label for="batch">Batch Number</label>
                <select class="form-control" name="batch" id="batch">
                    @foreach ($batches as $batch)
                    <option value="{{ $batch->batch }}" {{ ($batch->batch == $current_batch) ? 'selected' : '' }}>{{ $batch->batch }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Go</button>
        </form>
    </div>

    <h3>Tweets</h3>
    <div>
        Total: <strong>{{ count($tweets) }}</strong> tweets
    </div>
    <table class="table table-hover table-sm">
        <thead>
            <tr>
                <th>Tweet ID</th>
                <th>Text clean</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tweets as $tweet)
            <tr>
                <td>{{ $tweet->tweet_id }}</td>
                <td>{{ $tweet->full_text_clean }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h3>Similarities</h3>
    <div>
        Note: similarity value yang di bold adalah yang value nya >= 0.5
    </div>
    <table class="table table-striped table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th>Tweet</th>
                @for ($i = 0; $i < $row_count; $i++)
                <th><p style="writing-mode:vertical-rl;">{{ $similarities[$i]->second_tweet_id }}</p></th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @for ($row = 0; $row < $row_count; $row++)
            <tr>
                <th>{{ $similarities[$row * $row_count]->first_tweet_id }}</th>
                @for ($column = 0; $column < $row_count; $column++)
                <td>
                    @if ($similarities[($row * $row_count) + $column]->similarity >= 0.5)
                    <strong>{{ $similarities[($row * $row_count) + $column]->similarity }}</strong>
                    @else
                    {{ $similarities[($row * $row_count) + $column]->similarity }}
                    @endif
                </td>
                @endfor
            </tr>
            @endfor
        </tbody>
    </table>

    <script>
        document.getElementById('screen_name').focus();
    </script>
@endsection