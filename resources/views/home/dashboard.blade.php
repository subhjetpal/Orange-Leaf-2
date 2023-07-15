<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <!-- Favicons -->
    <link href="{{ asset('img/orange_leaf_icon_favicon.png') }}" rel="icon">
    <link href="{{ asset('img/orange_leaf_touch_icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    @stack('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/main.css') }}" />

</head>

<body>
    {{ View::make('home.components.header') }}
    {{ View::make('home.components.sidebar') }}

    @yield('content')

    {{ View::make('home.components.footer') }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>

    @stack('script')

    <script type="text/javascript" src="{{ asset('admin/js/main.js') }}"></script>
    
</body>

</html>
