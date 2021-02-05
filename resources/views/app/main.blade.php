<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{$theme_options['Tên_công_ty'] ?? 'Demo'}}</title>
</head>
<body>
    <div id="app">

    </div>
</body>
@php
    $logo = Str::replaceLast(',', '', $theme_options['logo'] ?? '')
@endphp
<script>
    var theme_options = {
        logo: "{{$logo}}"
    }
</script>
<script src="{{ asset('js/app.js') }}"></script>
</html>
