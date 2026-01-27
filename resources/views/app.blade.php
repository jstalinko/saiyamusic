<!doctype html>
<html data-theme="{{ j_active_theme() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="jadicms-token" content="{{ j_token() }}">
    @include('seo')
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
