<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }}</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
   
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .paddingFluid {
        padding: 15px;
    }
    .paddingFluid2 {
        padding: 35px;
    }
</style>
<body class="hold-transition sidebar-mini">
  
        @if (Auth::check())

            <div class="wrapper">
                <!-- Navbar -->
                @include('layouts.navbar')      
                <!-- Sidebar -->
                @include('layouts.sidebar')

                <!-- Content -->
                <div class="content-wrapper">
                    <section class="content">
                        <div class="container-fluid paddingFluid">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                             @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Footer -->
                @include('layouts.footer')
            </div>

        @else
            <!-- Content -->
            <div class="login-wrapper">
                <section class="content paddingFluid2">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>
        @endif
</body>
</html>
