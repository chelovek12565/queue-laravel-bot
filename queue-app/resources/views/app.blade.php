<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <script src="https://telegram.org/js/telegram-web-app.js?57"></script>
    <!-- CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- JS -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @yield('linksAndStyles')

</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Очередь</a>
            </div>
          </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Common footer content -->
    </footer>

</body>
</html>
