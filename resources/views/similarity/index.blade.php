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

    <h3>Similarities</h3>
    <div>
        Total: <strong>{{ $row_count }}</strong> tweets
    </div>
    <div>
        Note: similarity value yang di bold adalah yang value nya >= 0.5
    </div>
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Batch</th>
                <th>Tweet ID</th>
                <th>Tweet ID compared</th>
                <th>Similarity</th>
            </tr>
        </thead>
        <tbody>
            @php
                $last_tweet_id = 0
            @endphp

            @foreach ($similarities as $similarity)
                @if ($last_tweet_id != $similarity->first_tweet_id)
                    <tr class="table-primary">
                        <td colspan="4"></td>
                    </tr>
                    @php
                        $last_tweet_id = $similarity->first_tweet_id
                    @endphp
                @endif
                <tr>
                    <td>{{ $similarity->batch}}</td>
                    <td><abbr title="{{ $similarity->first_tweet->full_text_clean }}">{{ $similarity->first_tweet_id }}</abbr></td>
                    <td><abbr title="{{ $similarity->second_tweet->full_text_clean }}">{{ $similarity->second_tweet_id }}</abbr></td>
                    <td>{{ $similarity->similarity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.getElementById('screen_name').focus();
    </script>
@endsection