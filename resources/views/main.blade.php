<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Axie Tracker Report</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN FAVICON ================== -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('favicon/site.webmanifest')}}">
	<link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#00aba9">
	<meta name="theme-color" content="#ffffff">
	<!-- ================== END FAVICON ================== -->  
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{ asset('css/app.min.css')}}" rel="stylesheet" />
  	<link href="{{ asset('css/style.css')}}" rel="stylesheet" />
	<link href="{{ asset('css/widget.css')}}" rel="stylesheet" />
	<link href="{{ asset('assets/css/panel.css')}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->

</head>
<body>
    <div id="app">
		<!-- BEGIN #page-container -->
		<div id="page-container" class="fade show">
			<!-- BEGIN #header -->
			<header-component></header-component>
			<!-- END #header -->
			
			<router-view></router-view>
			
			<!-- <footer-component></footer-component> -->
			
			<copyright-component></copyright-component>
			
		</div>
		<!-- END #page-container -->
	</div>
    <!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- ================== END BASE JS ================== -->
  </body>
</html>
