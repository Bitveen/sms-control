<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('page_title')</title>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/smoothness/jquery-ui-1.9.2.custom.css">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>
<body>
    <div class="container">
        @yield('content')
        <footer class="footer">
            <p class="footer__text">&copy; 2015. Made by <a href="https://github.com/Bitveen">Bitveen</a></p>
        </footer>
    </div>
    @yield('scripts')
</body>
</html>