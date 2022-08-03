<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="css/sidebarheader.css">
    <link rel="stylesheet" href="css/peninjauan.css">
    <link rel="stylesheet" href="css/style.css">
    @if (
        $title == "Login"
    )
        <link rel="stylesheet" href="css/login.css">
    @endif
    @if (
        $title == "Detail Pengguna"
    )
        <link rel="stylesheet" href="css/detail-pengguna.css">
    @endif

    <!-- icon  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    {{-- <meta name="turbolinks-visit-control" content="reload"> --}}
    <title>{{ $title }}</title>
    <style>
        .turbolinks-progress-bar {
            position: absolute;
            width: 100% !important;
            height: 100%;
            z-index: 90000000 !important;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(31, 31, 31, 0.20);
        }

        .turbolinks-progress-bar::before {
            position: absolute;
            content: "";
            width: 20px;
            height: 20px;
            background: #0f57e6;
            border-radius: 50%;
            left: 50%;
            top: 50%;
            animation: turbo-loading .5s infinite;
        }

        .turbolinks-progress-bar::after {
            position: absolute;
            content: "";
            width: 20px;
            height: 20px;
            background: #0f57e6;
            border-radius: 50%;
            left: 52%;
            top: 50%;
            animation: turbo-loading .5s infinite;
            animation-delay: 0.10s;
        }

        @keyframes turbo-loading {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <SCript>
        function modalTarget(param, id) {
        if(param == "link"){
            // window.location.href=`${id}`
            alert(id)
        }
        }
    </SCript>
    <script src="js/script.js"></script>
    <script>
        
        $(function() {
            $("#datepicker").datepicker();
        });
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>

</html>
