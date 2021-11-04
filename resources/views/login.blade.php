<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Axie Management Tracker | Login Page</title>
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
	<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet" />
	<style>
		.login.login-v2 .login-header .brand .logo{
			background: none;
			border: none;
		}
		.login.login-v2 .login-header .brand .logo img{
			width: 4rem;
		}
		.login.login-v2{
			width: 30%;
			left: 35%;
			margin: 0;
		}
		.errors{
			display: none;
		}
	</style>
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin login-cover -->
	<div class="login-cover">
		<div class="login-cover-image" style="background-image: url(../assets/img/login-bg/login-bg-17.jpg)" data-id="login-cover-image"></div>
		<div class="login-cover-bg"></div>
	</div>
	<!-- end login-cover -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin login -->
		<div class="login login-v2" data-pageload-addclass="animated fadeIn">
			<!-- begin brand -->
			<div class="login-header">
				<div class="brand">
					<span class="logo"><img src="../img/pet-logo-white.png" alt=""></span> 
					<b>Axie Management Tracker</b>
					<!-- <small>responsive bootstrap 4 admin template</small> -->
				</div>
			</div>
			<!-- end brand -->
			<!-- begin login-content -->
			<div class="login-content">
				<form action="login" method="POST" class="margin-bottom-0">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group m-b-20">
						<div class="">
							<label for="">Username</label>
							@if(session()->has('username'))
							<input type="text" placeholder="Username" id="username" name="username" class="form-control" value="{{session('username')}}" required>
							@else
							<input type="text" placeholder="Username" id="username" name="username" class="form-control" required autofocus>
							@endif
							<span id="user_error" class="errors pull-right">Username is required</span>
						</div>
					</div>
					<div class="form-group m-b-20">
						<div class="">
							<label for="">Password</label>
							@if(session()->has('password'))
							<input type="password" placeholder="Password" id="password" name="password" class="form-control" value="{{session('password')}}" required>
							@else
							<input type="password" placeholder="Password" id="password" name="password" class="form-control" requires autofocus>
							@endif
							<span id="password_error" class="errors pull-right">Password is required</span>
						</div>
					</div>
					<hr/>
					<!-- <div class="checkbox checkbox-css m-b-20">
						<input type="checkbox" id="remember_checkbox" /> 
						<label for="remember_checkbox">
							Remember Me
						</label>
					</div> -->
					<div class="login-buttons">
						<button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
					</div>
					<div class="m-t-20">
						<!-- Not a member yet? Click <a href="/registration">here</a> to register. -->
					</div>
				</form>
			</div>
			<!-- end login-content -->
		</div>
		<!-- end login -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('assets/js/app.min.js') }}"></script>
	<script src="{{ asset('assets/js/default.min.js') }}"></script>
	<!-- ================== END BASE JS ================== -->

	<script type="text/javascript">
        $('#login').on('click', function(){ loginUser(); });
        $('#password, #username').on('keydown', function(e){ if (e.which == 13) loginUser(); });
        $('#show-pass')
        .hover(
            function(){
                $(this).css('cursor', 'pointer');
                $('#password').attr('type', 'text');
            })
        .mouseout( function(){ $('#password').attr('type', 'password'); });
        function loginUser(){
            username = $.trim($('#username').val());
            password = $('#password').val();
            if (username == '' || username.length < 1) {
                alertify.set('notifier','position', 'top-right');
                $('#username').css('border-color', '#ff9595').focus().parent().next().text('Username is required').css('display', 'block');
            }else if(password == '' || username.length < 1) {
                $('#password').css('border-color', '#ff9595').focus().parent().next().text('Password is required').css('display', 'block');
            }else{
                $('#password').attr('type', 'password');
                $('#frm_login').submit();
            }
        }
    </script>
	
	@if (session()->has('error'))
        <script>
            error = <?php echo json_encode(session('error'))?>;
			console.log(error);
            field = $('#' + error[0]);
            field.css('border-color', '#ff9595').focus();
            field.next().text(error[1]).css('display', 'block');
        </script>
    @endif
</body>
</html>
