<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Axie Management Tracker</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- ================== BEGIN BASE CSS STYLE ================== -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" />
        <!-- ================== END BASE CSS STYLE ================== -->
        
        <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
        <link href="{{ asset('assets/plugins/jvectormap-next/jquery-jvectormap.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/plugins/nvd3/build/nv.d3.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <!-- ================== END PAGE LEVEL CSS STYLE ================== -->
        
        <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet" />
        
    </head>
    <body>
       <div id="app">
            <!-- begin #page-loader -->
            <div id="page-loader" class="fade show"><span class="spinner"></span></div>
            <!-- end #page-loader -->
            
            <!-- begin #page-container -->
            <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
                <header-component></header-component>
                <sidebar-component></sidebar-component>
                <!-- begin #content -->
                <div id="content" class="content">
                    <router-view></router-view>
                </div>
                <!-- end #content -->
                <footer-component></footer-component>
            </div> 
        </div>
        <!-- end page container -->

        <!-- <script src="{{ asset('js/jquery-3.6.0.js') }}"></script> -->
        <!-- ================== BEGIN BASE JS ================== -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/js/theme/default.min.js') }}"></script>
        <!-- ================== END BASE JS ================== -->
        
        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="{{ asset('assets/plugins/d3/d3.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/nvd3/build/nv.d3.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jvectormap-next/jquery-jvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/jvectormap-next/jquery-jvectormap-world-mill.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/gritter/js/jquery.gritter.js') }}"></script>
        <script src="{{ asset('assets/js/demo/dashboard-v2.min.js') }}"></script>
        <!-- ================== END PAGE LEVEL JS ================== -->
    </body>        
</html>