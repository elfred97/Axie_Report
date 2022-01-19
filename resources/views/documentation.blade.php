<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head lang="en">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title> Axie Tracker Report</title>
	<!-- Bootstrap styles -->
	<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="assets/bootstrap/css/docs.css" rel="stylesheet">
	<link href="assets/bootstrap/js/google-code-prettify/prettify.css" rel="stylesheet">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
	<![endif]-->
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar">
	<div class="navbar navbar-inverse navbar-page">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="#">
                <span class="brand-logo"><img src="/img/pet-logo.png" alt=""></span>
                Axie Tracker Report</a>
				<div class="nav-collapse collapse pull-right">
					<ul class="nav">
						
						<li class="active">
							<a href="/docs">Documentation</a>
						</li>
						<li class="">
							<a href="help">Help</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<header class="jumbotron subhead" id="overview">
		<div class="container">
			<h1 class="text-center">Documentation and Guide</h1>
			<p class="lead text-center">Documentation for Axie Tracker Report by <a href="https://www.codev-ph.com/">Codev PH</a></p>
		</div>
		<div class="jumbotron-cover"></div>
	</header>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="well with-cover">
					<p>
						<strong>
							Last Updated: January 19, 2022<br>
							By: Codev PH<br>
							Email: <a href="mailto:axie_tracker@codev-ph">axie_tracker@codev-ph</a>
						</strong>
					</p>
					<p>
						Thank you for choosing Axie Tracker Report by Codev PH.</br>
						Feel free to email your question to my email <a href="mailTo:axie_tracker@codev-ph">axie_tracker@codev-ph</a> or go to our help page to send inquiries. Thanks so much!
					</p>
			
				</div>
			</div><!-- end span12 -->
		</div><!-- end row -->
		<div class="row">
			<div class="span3 bs-docs-sidebar">
				<ul class="nav nav-list bs-docs-sidenav affix-top">
					<li><a href="#installation"><i class="icon-chevron-right"></i>Installation</a></li>
					<li><a href="#configuration"><i class="icon-chevron-right"></i>Configuration Setup</a></li>
					<li><a href="#feature"><i class="icon-chevron-right"></i>Feature</a></li>
					<li><a href="#creator"><i class="icon-chevron-right"></i>Creator</a></li>
					<li><a href="#author"><i class="icon-chevron-right"></i>Author</a></li>
					<li><a href="#npm-package"><i class="icon-chevron-right"></i>NPM Package</a></li>
				</ul>
			</div>
			<div class="span9">
				<div class="row-fluid">
					<div class="span12">
						<div class="page-header">
							<h3 id="installation"><strong>A) Installation</strong> - <a href="#top">top</a></h3>
						</div>
						<p>
							Follow the following step to install the project on your localhost<br />
							You may refer to their official documentation for how to setup the development environment. <br />
							<a href="https://github.com/elfred97/Axie_Report" target="_blank">Github Link</a>
						</p>
<pre class="prettyprint linenums">
# clone the repo
$ git clone https://github.com/elfred97/Axie_Report.git

# go into app's directory
$ cd axie_tracker_project

# install app's dependencies
$ composer install

# install app's dependencies
$ npm install
</pre>
					</div><!-- end span12 -->
				</div><!-- end row-fluid -->
				<div class="row-fluid">
					<div class="span12">
						<div class="page-header">
							<h3 id="configuration"><strong>B) Configuration Setup</strong> - <a href="#top">top</a></h3>
						</div>
						<p>Copy file ".env.example", and change its name to ".env". Then in file ".env" replace this database configuration:</p>
						<ul>
							<li>DB_CONNECTION=mysql</li>
							<li>DB_HOST=127.0.0.1</li>
							<li>DB_PORT=3306</li>
							<li>DB_DATABASE=test</li>
							<li>DB_USERNAME=root</li>
							<li>DB_PASSWORD=</li>

						</ul>
						<p>Run the command to create the database</p>
						<pre>
php artisan make:database tracker_axie
						</pre>
						<p>Update again the DB_DATABASE to the database created "tracker_axie"</p>
						<ul>
							<li>DB_DATABASE=tracker_axie</li>
						</ul>
						<p>Run the command below:</p>
						<pre>
# Clear configuration
php artisan config:clear
							
php artisan migrate:generate
							
php artisan db:seed
							
npm update
						</pre>
<p>Once npm is already updated. The node_modules will be added</p>
<pre class="prettyprint linenums">
axie_tracker_project/
├── app
├── config
├── database
└── node_modules
</pre>
					</div><!-- end span12 -->
				</div><!-- end row-fluid -->
				<div class="row-fluid">
					<div class="span12">
						<div class="page-header">
							<h3 id="feature"><strong>C) Feature</strong> - <a href="#top">top</a></h3>							
						</div>
						<h5>Table of Contents</h5>
						<ul>
							<li>Roles</li>
							<li>Manage Settings</li>							
							<li>Import</li>
						</ul>
						<h5>Role</h5>
						<h6>Admin</h6>
						<p>The responsibilities of the Admins are:</p>
						<ul>
							<li>Monitoring daily activities of the scholars</li>
							<li>Importing Files for daily game</li>
							<li>Managing Axie Account, Scholars, Type, Reminders, and Payroll</li>						
						</ul>
						<h6>Scholars</h6>
						<p>The scholars can review the information about the Axie that they are managing</p>

						<h5>Manage Settings</h5>
						<p>The admin can manage the settings that are being check by the system to impose penalties and warnings to the scholars</p>
						<ul>
							<li>Type - scholars group</li>
							<li>MMR - Minimum value of MMR per day of the scholars (Subject for transferring Axie Account to other scholars)</li>
							<li>SLP - Minimum SLP value that is going to check by the system</li>
							<li>Display - The list of tabs that are present in the Home Page</li>
						</ul>

						<h5>Import</h5>
						<p>CSV File can be imported to the following:</p>
						<ul>
							<li>Game Logs</li>
							<li>Payroll</li>
							<li>Axie Account</li>
							<li>Scholars</li>
							<li>Player Scholar History</li>
						</ul>
					</div><!-- end span12 -->
				</div><!-- end row-fluid -->
				
				<div class="row-fluid">
					<div class="span12">
						<div class="page-header">
							<h3 id="creator"><strong>D) Creator</strong> - <a href="#top">top</a></h3>
						</div>
						<h5>Elfred G. Tapar</h5>
						<ul>
							<li>Email: <a href="mailto:elfredtapar@gmail.com">elfredtapar@gmail.com</li>
							<li>Github: elfred97</li>
						</ul>
						<h5>Glenwin Bernabe</h5>
						<ul>
							<li>EMail: <a href="mailto:"> </a></li>
							<li>Github: </li>
						</ul>
					</div><!-- end span12 -->
				</div><!-- end row-fluid -->
				<div class="row-fluid">
					<div class="span12">
						<div class="page-header">
							<h3 id="author"><strong>E) Author</strong> - <a href="#top">top</a></h3>
						</div>
						<img src="img/codev.png" alt="" class="company-logo">
						<h5>Codev PH</h5>
						
					</div><!-- end span12 -->
				</div><!-- end row-fluid -->
				<div class="row-fluid">
					<div class="span12">
						<div class="page-header">
							<h3 id="npm-package"><strong>G) NPM Package</strong> - <a href="#top">top</a></h3>
						</div>
						<p>
							Below is the list of package that has been installed in this project. You may use the following example to find the package from their official website.
							<code>https://www.npmjs.com/package/</code><code>bootstrap-vue</code>
						</p>
<pre class="prettyprint linenums">
{
    "private": true,
    "scripts": {
        "dev": "npm run development",
        "development": "cross-env NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --config=node_modules/laravel-mix/setup/webpack.config.js",
        "watch": "npm run development -- --watch",
        "watch-poll": "npm run watch -- --watch-poll",
        "hot": "cross-env NODE_ENV=development node_modules/webpack-dev-server/bin/webpack-dev-server.js --inline --hot --disable-host-check --config=node_modules/laravel-mix/setup/webpack.config.js",
        "prod": "npm run production",
        "production": "cross-env NODE_ENV=production node_modules/webpack/bin/webpack.js --no-progress --config=node_modules/laravel-mix/setup/webpack.config.js"
    },
    "devDependencies": {
        "axios": "^0.19",
        "bootstrap": "^4.6.0",
        "jquery": "^3.2",
        "laravel-mix": "^5.0.1",
        "cross-env": "^5.0.1",
        "lodash": "^4.17.19",
        "popper.js": "^1.12",
        "resolve-url-loader": "^2.3.1",
        "sass": "^1.20.1",
        "sass-loader": "^8.0.0",
        "vue": "^2.6.14",
        "vue-template-compiler": "^2.6.10",
        "vuetable-2": "^2.0.0-beta.4"
    },
    "dependencies": {
        "@chenfengyuan/vue-qrcode": "^1.0.2",
        "apollo-boost": "^0.4.9",
        "footable": "^2.0.6",
        "graphql": "^15.6.0",
        "jscharting-vue": "^2.1.0",
        "moment": "^2.29.1",
        "vform": "^2.1.1",
        "vue-alertify": "^1.1.0",
        "vue-apollo": "^3.0.8",
        "vue-axios": "^3.3.7",
        "vue-events": "^3.1.0",
        "vue-loading-overlay": "^3.4.2",
        "vue-modaltor": "^1.3.12",
        "vue-multiselect": "^2.1.6",
        "vue-router": "^3.5.2",
        "vue2-datepicker": "^3.10.2",
        "vuejs-noty": "^0.1.4",
        "vuex": "^3.6.2"
    }
}

</pre>
					</div>
				</div><!-- end row-fluid -->
			</div><!-- end span12 -->
		</div><!-- end row-fluid -->
	</div><!-- end container -->
	
	<footer class="footer">
		<div class="container text-left">
			<p>Axie Tracker Report by Codev PH @2022</p> 
			<br />
			<p><a href="#top">Go To Top</a></p>
		</div>
	</footer><!-- end footer -->
	
	<script src="assets/bootstrap/js/jquery.js"></script>
	<script src="assets/bootstrap/js/bootstrap-transition.js"></script>
	<script src="assets/bootstrap/js/bootstrap-alert.js"></script>
	<script src="assets/bootstrap/js/bootstrap-modal.js"></script>
	<script src="assets/bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="assets/bootstrap/js/bootstrap-scrollspy.js"></script>
	<script src="assets/bootstrap/js/bootstrap-tab.js"></script>
	<script src="assets/bootstrap/js/bootstrap-tooltip.js"></script>
	<script src="assets/bootstrap/js/bootstrap-popover.js"></script>
	<script src="assets/bootstrap/js/bootstrap-button.js"></script>
	<script src="assets/bootstrap/js/bootstrap-collapse.js"></script>
	<script src="assets/bootstrap/js/bootstrap-carousel.js"></script>
	<script src="assets/bootstrap/js/bootstrap-typeahead.js"></script>
	<script src="assets/bootstrap/js/bootstrap-affix.js"></script>

	<script src="assets/bootstrap/js/holder/holder.js"></script>
	<script src="assets/bootstrap/js/google-code-prettify/prettify.js"></script>
	<script src="assets/bootstrap/js/application.js"></script>
</body>
</html>