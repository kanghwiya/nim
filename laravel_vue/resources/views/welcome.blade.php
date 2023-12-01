<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Vue</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- defer : html을 먼저 로드하고 이후에 javascript를 로드하는 속성 --}}
</head>
<body>
    <div id="app">

        부.

        <App-Component :laravel-Data="{{ $data }}"></App-Component>
    </div>
</body>
</html>