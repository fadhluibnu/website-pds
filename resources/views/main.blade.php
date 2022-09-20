<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="turbolinks-visit-control" content="reload">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    @if ($title != 'Login' || $title != 'Detail Pengguna')
        <link rel="stylesheet" href="{{ asset('css/sidebarheader.css') }}">
        <link rel="stylesheet" href="{{ asset('css/peninjauan.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endif
    @if ($title == 'Login')
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @endif
    @if ($title == 'Detail Pengguna')
        <link rel="stylesheet" href="{{ asset('css/detail-pengguna.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">

    <!-- icon  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @livewireStyles
    <title>{{ $title }}</title>
</head>

<body style="height: 100vh; overflow-y: hidden;">

    @if ($title == 'Login')
        @yield('login')
    @else
        <div class="d-flex">
            <livewire:layouts.sidebar :title="$title"></livewire:layouts.sidebar>
            <div class="content overflow-hidden position-relative" style="height: 100vh;">
                <livewire:layouts.navbar :title="$title"></livewire:layouts.navbar>

                @yield('content')
            </div>
        </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"
        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // $(function() {
        $("#datepicker").datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d'
        });
        // });
    </script>
    @if ($title == 'Peninjauan')
        <script src="{{ asset('js/event.js') }}"></script>
    @endif
    @livewireScripts

</body>

</html>
