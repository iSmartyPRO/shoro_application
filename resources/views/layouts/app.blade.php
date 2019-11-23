<!DOCTYPE html>
<html>
    <head>
        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{ config('app.name') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App Icons -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!--Morris Chart CSS -->
        <link href="{{ asset('assets/plugins/morris/morris.css') }}" rel="stylesheet">
        <!--Datepicker CSS -->
        <link href="{{ asset('assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet">
        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
        <!--Morris Chart-->
        <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>
        <!--DatePicker-->
        <script src="{{ asset('assets/plugins/datepicker/datepicker.min.js') }}"></script>
        <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}"/>


    </head>
    <body>

<ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <!-- Auth please -->
                        @else



<!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">
                    <div class="logo">
                        <a href="/" class="logo">
                            <img src="/assets/images/logo-sm.png" alt="" height="22" class="logo-small">
                            <img src="/assets/images/logo.png" alt="" height="24" class="logo-large">
                        </a>

                    </div>
                    <div class="menu-extras topbar-custom">
                        <ul class="list-inline float-right mb-0">
                            <!-- User-->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    {{ Auth::user()->name }} <img src="/assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <a class="dropdown-item" href="#"><i class="dripicons-user text-muted"></i> Profile</a>
                                    <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> <i class="dripicons-exit text-muted"></i>
                                        {{ __('Logout') }}
                                   </a>
                                </div>
                            </li>
                            <li class="menu-item list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>

                        </ul>
                    </div>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                    <!-- end menu-extras -->

                    <div class="clearfix"></div>

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">

                            <li class="has-submenu">
                                <a href="/"><i class="ti-home"></i>Dashboard</a>
                            </li>

                            <li class="has-submenu">
                                <a href="/report"><i class="ti-light-bulb"></i>Отчёты</a>
                            </li>
                            <li class="has-submenu">
                                <a href="/help"><i class="ti-help-alt"></i>О программе</a>
                            </li>

                        </ul>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->


        <div class="wrapper">
            <div class="container-fluid">



                        @endguest
                    </ul>







        




        <main class="py-4">
            @yield('content')
        </main>






            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->


        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        © 2019 ОАО "Чакан ГЭС"
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->


        


        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

    </body>
</html>