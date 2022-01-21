<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Axie Tracker Report | Help</title>
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
	
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet" />

	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="assets/css/forum.css" rel="stylesheet" />

	<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body>
  <!-- begin #header -->
	<div id="header" class="header navbar navbar-default navbar-fixed-top navbar-expand-lg">
		<!-- begin container -->
		<div class="container">
			<!-- begin navbar-brand -->
			<a href="index.html" class="navbar-brand">
                <span class="brand-logo"><img src="/img/pet-logo.png" alt=""></span>
				<span class="brand-text">
					Axie Tracker Report
				</span>
			</a>
			<!-- end navbar-brand -->
			<!-- begin navbar-toggle -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!-- end navbar-toggle -->
			<!-- begin #header-navbar -->
			<div class="collapse navbar-collapse" id="header-navbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/login">Go to Login</a></li>
				</ul>
			</div>
			<!-- end #header-navbar -->
		</div>
		<!-- end container -->
	</div>
	<!-- end #header -->
	
	<!-- begin content -->
	<div class="content">
		<!-- begin container -->
		<div class="container">
			<!-- begin tabs -->
			<ul class="nav nav-tabs" data-sortable-id="index-2">
						<li class="nav-item"><a href="#admin" data-toggle="tab" class="nav-link active"><span class="d-none d-md-inline">Admin</span></a></li>
						<li class="nav-item"><a href="#scholars" data-toggle="tab" class="nav-link"> <span class="d-none d-md-inline">Scholars</span></a></li>
					</ul>
					<div class="tab-content" data-sortable-id="index-3">
						<div class="tab-pane fade active show" id="admin">
							<div class="row">
								<div class="col-md-12">
									<!-- begin #accordion -->
									<div id="admin_accordion" class="accordion">
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapseOne">
												<i class="fas fa-circle fa-fw text-blue mr-2 f-s-8"></i> What is Axie Tracker Report?
											</div>
											<div id="collapseOne" class="collapse show" data-parent="#admin_accordion">
												<div class="card-body">
												- Axie Tracker Report is a system to monitor and analyze daily scholars game activity
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseTwo">
												<i class="fas fa-circle fa-fw text-indigo mr-2 f-s-8"></i> What can I do inside the system?
											</div>
											<div id="collapseTwo" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
												- Inside the system, you can import files to insert game logs, axie accounts, scholar informations, and payroll.
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseThree">
												<i class="fas fa-circle fa-fw text-teal mr-2 f-s-8"></i> What is Axie Account?
											</div>
											<div id="collapseThree" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
													- List of all the axie account that can be use by the scholars
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseFour">
												<i class="fas fa-circle fa-fw text-info mr-2 f-s-8"></i> What is Scholars?
											</div>
											<div id="collapseFour" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
												- List of people that are ready to use the axie accounts and can view the system as scholars.
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseFive">
												<i class="fas fa-circle fa-fw text-warning mr-2 f-s-8"></i> What is the payroll schedule?
											</div>
											<div id="collapseFive" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
													- Every  10th of the month, the system will generate a payroll for every scholars that have an axie account and played.
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseSix">
												<i class="fas fa-circle fa-fw text-danger mr-2 f-s-8"></i> How can I add a Type?
											</div>
											<div id="collapseSix" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
													<p>A type is basically the group to which the scholars will be assign.</p>
													- Inside the settings you can see the type panel. You can add, delete or edit the type name
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseSeven">
												<i class="fas fa-circle fa-fw text-muted mr-2 f-s-8"></i> Setup Notification Settings?
											</div>
											<div id="collapseSeven" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
													<ul>
														<li>The admin can setup the a settings that will be check by the system to impose penalty</li>
														<li>Minimum SLP
															<ul>
																<li>Minimum SLP per day, once not met by the scholars will result to penalty</li>
															</ul>
														</li>
														<li>Target SLP Value
															<ul>
																<li>System will generate an email to every scholars if the SLP Value in the marketplace met the Target SLP Value.</li>
															</ul>
														</li>
														<li>Target SLP Unit
															<ul>
																<li>Unit in which the Target SLP will be converted.</li>
															</ul>
														</li>
														<li>MMR
															<ul>
																<li>Minimum MMR of the axie account that should be maintained by the scholars</li>
																<li>Subject for transferring axie account to other scholar if not maintained.</li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseEight">
												<i class="fas fa-circle fa-fw text-info mr-2 f-s-8"></i> Announcement
											</div>
											<div id="collapseEight" class="collapse" data-parent="#admin_accordion">
												<div class="card-body">
												- An admin can an announcement that will be sent to every scholars.
												</div>
											</div>
										</div>
										<!-- end card -->
									</div>
									<!-- end #accordion -->
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="scholars">
							<div class="row">
								<div class="col-md-12">
									<!-- begin #accordion -->
									<div id="scholars_accordion" class="accordion">
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center" data-toggle="collapse" data-target="#collapseOne">
												<i class="fas fa-circle fa-fw text-blue mr-2 f-s-8"></i> What can I do inside the system?
											</div>
											<div id="collapseOne" class="collapse show" data-parent="#scholars_accordion">
												<div class="card-body">
													- The scholar can view, monitor and add ronin wallet.
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseTwo">
												<i class="fas fa-circle fa-fw text-indigo mr-2 f-s-8"></i> What is ronin wallet?
											</div>
											<div id="collapseTwo" class="collapse" data-parent="#scholars_accordion">
												<div class="card-body">
													- This is the ronin address where the payroll will be sent
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseThree">
												<i class="fas fa-circle fa-fw text-teal mr-2 f-s-8"></i> About payroll
											</div>
											<div id="collapseThree" class="collapse" data-parent="#scholars_accordion">
												<div class="card-body">
													- Scholars can view the payroll that will be generated every 10th of the month
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseFour">
												<i class="fas fa-circle fa-fw text-info mr-2 f-s-8"></i> Scholars Contract
											</div>
											<div id="collapseFour" class="collapse" data-parent="#scholars_accordion">
												<div class="card-body">
													<ul>
														<li>The scholars contract is 2 months.</li>
														<li>The scholar will receive 30% for the 1st month of playing from the stated date.</li>
														<li>The scholar will receive 40% of daily SLP per day after playing for 1 month.</li>
													</ul>
												</div>
											</div>
										</div>
										<!-- end card -->
										<!-- begin card -->
										<div class="card">
											<div class="card-header pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapseFive">
												<i class="fas fa-circle fa-fw text-warning mr-2 f-s-8"></i> QR Code
											</div>
											<div id="collapseFive" class="collapse" data-parent="#scholars_accordion">
												<div class="card-body">
													- Every week, the QR Code of the axie account will be change and need to scan the new one inside the Account Tab.
												</div>
											</div>
										</div>
										<!-- end card -->
									</div>
									<!-- end #accordion -->
								</div>
							</div>
						</div>
					</div>
					<!-- end tabs -->
					
					<div class="row">
						<div class="col-md-12">
							<hr>
							
						</div>
					</div>
                    <div class="row">
						<div class="col-md-12">
							<h3 class="text-center">Contact Us</h3>
							<p class="response text-center"></p>
						</div>
                        <div class="col-md-8">							
							<form action="send_inquiries" method="POST" id="contact_us">
								@csrf
								<div class="row form-group">
									<div class="col-md-4">
										<label for="" class="form-label pull-right">Name <span class="text-danger">*</span> </label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="name">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label for="" class="form-label pull-right">Email <span class="text-danger">*</span> </label>
									</div>
									<div class="col-md-8">
										<input type="email" class="form-control" name="email">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label for="" class="form-label pull-right">Subject <span class="text-danger">*</span> </label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" name="subject">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label for="" class="form-label pull-right">Message <span class="text-danger">*</span> </label>
									</div>
									<div class="col-md-8">
										<textarea class="form-control" name="description" rows="10"></textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-8 offset-md-4">
										<button class="btn btn-dark btn-block" tpe="submit">Send Message</button>
									</div>
								</div>
							</form>
                        </div>
                        <div class="col-md-4">
							<p class="text-bold">Codev PH</p>
							<p>Level 29 Joy Nostalg Center​ 17 ADB Avenue, Ortigas Center Pasig City, 1600 Philippines</p>
							<p>(+632) 7798 8155​</p>
                        </div>
                    </div>
		</div>
		<!-- end container -->
	</div>
	<!-- end content -->
	
	<!-- begin #footer-copyright -->
	<div id="footer-copyright" class="footer-copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
				Axie Tracker Report by Codev PH &copy; <?php echo date("Y"); ?>					 
				</div>
				<div class="col-md-6 text-md-right">
					<a href="#header" class="mr-4">Go to Top</a> 					
				</div>
			</div>
		</div>
	</div>
	<!-- end #footer-copyright -->
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="/assets/js/forum.js"></script>
	<!-- ================== END BASE JS ================== -->

<script type="text/javascript">
    var frm = $('#contact_us');
	$('.response').text('');

    frm.submit(function (e) {

        e.preventDefault();

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log(data);
				$("p.response").text("Submission was successful").css({'color':'green', 'display':'block'});
				$(this).closest('form').find("input, textarea").val("");
            },
            error: function (data) {
                console.log(data.responseJSON.message);
				$("p.response").text(data.responseJSON.message).css({'color':'red', 'display':'block'});
            },
        });
    });
</script>
</body>
</html>
