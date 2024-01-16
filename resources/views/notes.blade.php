@extends('layouts.app')
@extends('index_styles')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Laravel Website</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Optional: Hide scroll bars */
        }

        iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
</head>
<body>

<!-- Embedding the Google Docs webpage using iframe -->
<iframe src="https://docs.google.com/document/d/{{ $id }}/edit?usp=sharing" frameborder="0"></iframe>

</body>
</html>

@endsection