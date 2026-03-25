<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}" type="text/css"/>
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/spa/main.jsx'])
</head>
<body>
    <div id="spa-root"></div>
</body>
</html>
