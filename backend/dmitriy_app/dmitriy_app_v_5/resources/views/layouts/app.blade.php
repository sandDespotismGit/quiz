<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://widget.cloudpayments.ru/bundles/cloudpayments.js"></script>
    <script src="https://checkout.cloudpayments.ru/checkout.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Victor+Mono:wght@200;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <title>Главная</title>
</head>
<body id="body">
    @include('inc.header')
    <div class="container mt-5">
        <div class="row">
            <script>
                
            </script>
            <div class="col-8">
                @yield('content')
            </div>
        </div>
    </div>
    @include('inc.footer')
</body>
</html>
