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
        </ul>
    </div>

    <div class="jumbotron">
        <form action="/similarity" method="get">
            <div class="form-group">
                <label for="batch">Batch Number</label>
                <select class="form-control" name="batch" id="batch">
                    @foreach ($batches as $batch)
                    <option value="{{ $batch->batch }}" {{ ($batch->batch == $current_batch) ? 'selected' : '' }}>{{ $batch->batch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="show_exact" id="show_exact" {{ ($show_exact == 'on') ? 'checked' : '' }}>
                <label class="form-check-label" for="show_exact">Show similarity = 1.0</label>
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
                <th>Prediction</th>
            </tr>
        </thead>
        <tbody>
            @php
                $last_tweet_id = 0
            @endphp

            @foreach ($similarities as $similarity)
                @if ($last_tweet_id != $similarity->first_tweet_id)
                    <tr class="table-primary">
                        <td colspan="5"></td>
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
                    <td>{{ $similarity->prediction }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.getElementById('screen_name').focus();
    </script>
@endsection