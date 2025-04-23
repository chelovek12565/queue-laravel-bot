<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>

    <script src="https://telegram.org/js/telegram-web-app.js?57"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

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
