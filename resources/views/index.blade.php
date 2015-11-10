<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('page_title')</title>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/js/vendor/bootstrap.js"></script>
</head>
<body>
    <div class="vm-container">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>