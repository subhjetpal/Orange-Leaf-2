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
        rel="stylesheet"integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


    {{--  --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/main.css') }}" />


</head>

<body>
    {{ View::make('home.components.header') }}
    {{ View::make('home.components.sidebar') }}

    @yield('content')

    {{ View::make('home.components.footer') }}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{--  --}}
    <script type="text/javascript" src="{{ asset('admin/js/main.js') }}"></script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#TradeTable').DataTable();
        });
    </script> --}}
</body>

</html>
