<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Axie Management Tracker | Registration Page</title>
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
	<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet" />
    <style>
        .register.register-with-news-feed .news-feed{
            right: 700px;
        }
        .register.register-with-news-feed .right-content{
            width: 700px;
        }
    </style>
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin register -->
		<div class="register register-with-news-feed">
			<!-- begin news-feed -->
			<div class="news-feed">
				<div class="news-image" style="background-image: url(../assets/img/login-bg/login-bg-15.jpg)"></div>
				<div class="news-caption">
					<h4 class="caption-title"><b>Axie Management Tracker</b></h4>
					<p>
						Manage, Import, and Analyze the Scholars SLP and Stats.
					</p>
				</div>
			</div>
			<!-- end news-feed -->
			<!-- begin right-content -->
			<div class="right-content">
				<!-- begin register-header -->
				<h1 class="register-header">
					Sign Up
					<small>Create your Axie Management Tracker Account. It’s free and always will be.</small>
				</h1>
				<!-- end register-header -->
				<!-- begin register-content -->
				<div class="register-content">
					<form action="index.html" method="GET" class="margin-bottom-0">
						<label class="control-label">Name <span class="text-danger">*</span></label>
						<div class="row row-space-10">
							<div class="col-md-6 m-b-15">
								<input type="text" class="form-control" placeholder="First name" required />
							</div>
							<div class="col-md-6 m-b-15">
								<input type="text" class="form-control" placeholder="Last name" required />
							</div>
						</div>
						<label class="control-label">Email <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="Email address" required />
							</div>
						</div>
						<label class="control-label">Re-enter Email <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12">
								<input type="text" class="form-control" placeholder="Re-enter email address" required />
							</div>
						</div>
						<label class="control-label">Password <span class="text-danger">*</span></label>
						<div class="row m-b-15">
							<div class="col-md-12">
								<input type="password" class="form-control" placeholder="Password" required />
							</div>
						</div>
						
						<div class="register-buttons">
							<button type="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
						</div>
						<div class="m-t-30 m-b-30 p-b-30">
							Already a member? Click <a href="/login">here</a> to login.
						</div>
						<hr />
						<p class="text-center mb-0">
							Copyright &copy; <?php echo date("Y"); ?> Codev PH. All rights reserved.
						</p>
					</form>
				</div>
				<!-- end register-content -->
			</div>
			<!-- end right-content -->
		</div>
		<!-- end register -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('assets/js/app.min.js') }}"></script>
	<script src="{{ asset('assets/js/default.min.js') }}"></script>
	<!-- ================== END BASE JS ================== -->
</body>
</html>
