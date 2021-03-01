<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	if($title!='')
	{
		$title = $title;
	}
	else
	{
		$title = 'Pro-Vigil Monitoring';
	}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title><?php echo $title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> 
	<meta http-equiv="Pragma" content="no-cache" /> 
	<meta http-equiv="Expires" content="0" />
	<link rel='shortcut icon' type='image/png' href='<?php echo base_url() ?>assets/images/favicon.ico'/>
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
	<!-- App css -->

	<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />
	
	<link href="<?php echo base_url() ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" />
	
	

	<link href="<?php echo base_url() ?>assets/css/icon-style.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/css/jquery-confirm.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://use.typekit.net/gkf2ief.css">
	<link href="<?php echo base_url() ?>assets/css/customer-portal.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/css/vg-style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url() ?>assets/css/customer-portal-responsive.css" rel="stylesheet">
	<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>
    <link href="<?php echo base_url() ?>assets/css/bootstrap-multiselect.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" />
	<?php 
		$activePage = $this->uri->segment(1);
		$supportMenuArr = array("tips","tickets","customer-support");
		$cameraMenuArr  = array("liveviews","camerahealth");
		$siteDetailsMenuArr = array("monitoringhours","stats");
		$psaMenuArr = array("createPSA","psa");
	?>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-7WECK8WBEW"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-7WECK8WBEW');
	</script>
	
</head>
<body>
	<div id="wrapper">
		<div class="navbar navbar-fixed-top headerBlock" role="navigation" id="header">
			<?php if(!empty($this->session->userdata('USER_SELECTED_SITE')) && $activePage!="lpr") {?>
			<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="pull-left navbar-brand"><a href="<?php echo base_url(); ?>dashboard"><img src="<?php echo base_url()?>assets/images/logo.png" class="logo" alt="" /></a></div>
			</div>
			<div class="navbar-right">
				<!--<div class="res-headerSwitch"></div>For switch block-->
				
				<div class="res-headerSwitch">
					<div class="switchBlock">
						<!--<label class="switch"><input type="checkbox" checked><span class="slider round"></span></label>-->
					</div>
				</div>
				<nav id="nav-menu-container">	
					<div class="navbar-leftblock">
						<div id="navbar" class="navbar-collapse" aria-expanded="false">
							<ul class="nav navbar-nav nav-menu">				
								<?php if($this->session->userdata('source')=='IVigil') {?>
								<li class="dropdown custinfo-menu <?php if(in_array($activePage,$psaMenuArr)) {?> active <?php }?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PSA</a>
									<ul class="dropdown-menu animation slideDownIn">									
										<li <?php if($activePage=="createPSA") {?>class="active"<?php }?>><a href="<?php echo base_url()?>createPSA">Create PSA</a></li>
										<li <?php if($activePage=="psa") {?>class="active"<?php }?>><a href="<?php echo base_url()?>psa">Show PSA</a></li>
									</ul>
								</li>
								<?php }?>
								<li class="dropdown custinfo-menu <?php if(in_array($activePage,$siteDetailsMenuArr)) {?> active <?php }?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Site Details</a>
									<ul class="dropdown-menu animation slideDownIn">									
										<li <?php if($activePage=="monitoringhours") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>monitoringhours">Monitoring Hours</a></li>
										<li <?php if($activePage=="stats") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>stats">Statistics</a></li>
									</ul>
								</li>
								<li class="dropdown custinfo-menu <?php if(in_array($activePage,$cameraMenuArr)) {?> active <?php }?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Camera</a>
									<ul class="dropdown-menu animation slideDownIn">								
										<li <?php if($activePage=="liveviews") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>liveviews">Camera Views</a></li>												
										<li <?php if($activePage=="camerahealth") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>camerahealth">Equipment Health</a></li>	
									</ul>

								</li>
								<li class="dropdown custinfo-menu <?php if($activePage=="eventlog") {?> active <?php }?>"><a class="eventlogMenu" href="<?php echo base_url(); ?>eventlog">Event Log</a></li>
								<li class="dropdown custinfo-menu <?php if(in_array($activePage,$supportMenuArr)) {?> active <?php }?>">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Support</a>
									<ul class="dropdown-menu animation slideDownIn">									
										<li <?php if($activePage=="tips") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>tips">Tips</a></li>
										<!--<li <?php if($activePage=="tickets") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>tickets">Ticket Creation</a></li>-->
										<li <?php if($activePage=="tickets") {?>class="active"<?php }?>><a href="https://support.pro-vigil.com/hc/en-us/requests/new" target="_new">Ticket Creation</a></li>
										<li <?php if($activePage=="customer-support") {?>class="active"<?php }?>><a href="<?php echo base_url(); ?>customer-support">Customer Support</a></li>
										<!--<li><a href="notifications.html">Notifications</a></li>											-->
									</ul>
								</li>
								<!--<li class="dropdown custinfo-menu <?php if($activePage=="eventclip") {?> active <?php }?>"><a href="<?php echo base_url(); ?>eventclip">EVENT CLIP</a></li>-->
								
								<?php if($this->session->userdata('source')=='IVigil') {?>
									<li class="dropdown custinfo-menu <?php if($activePage=="archive") {?> active <?php }?>"><a href="<?php echo base_url(); ?>archive">Archive</a></li>
									<?php if($this->session->userdata('isAccountHasLPR')==1) {?>
									<li class="dropdown custinfo-menu <?php if($activePage=="lpr") {?> active <?php }?>"><a href="<?php echo base_url(); ?>lpr">LPR</a></li>
									<?php }?>
								<?php }?>
							</ul>
						</div>
					</div>
				</nav>
			<?php }else{?>
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="pull-left navbar-brand"><a href="javascript:void(0)"><img src="<?php echo base_url()?>assets/images/logo.png" class="logo" alt="" /></a></div>
				</div>
			<?php } ?>
				<div class="navbar-right">	
					<?php if($this->session->userdata('isAccountHasLPR')==1 && $activePage=="lpr") {?>
					<nav id="nav-menu-container">	
						<div class="navbar-leftblock">
							<div id="navbar" class="navbar-collapse" aria-expanded="false">
								<ul class="nav navbar-nav nav-menu">
										<li class="dropdown custinfo-menu"><a href="<?php echo base_url(); ?>dashboard">Dashboard</a></li>									
										<li class="dropdown custinfo-menu"><a href="<?php echo base_url(); ?>lpr">LPR</a></li>
								</ul>
							</div>
						</div>
					</nav>
					<?php }?>
					<div class="header-right">
						<ul class="nav navbar-toolbar user-nav navbar-toolbar-right">
							<li class="nav-item dropdown user-box userbox-border">
								<a href="#" class="nav-link navbar-avatar dropdown-toggle user-link" data-toggle="dropdown" aria-expanded="true">
								<span class="avatar avatar-online user-icondot"><div class="icon icon-profile-user"></div><i></i> </span> </a>
								<ul class="dropdown-menu header-dropdown-menu-right user-list animation slideDownIn">
									<li class="user-li-bg"><div class="avatar avatar-online user-icondot pull-left"><div class="icon icon-profile-user"></div></div>
										<h4><?php echo ucfirst($this->session->userdata('userName'));?>  <!--<span>&nbsp;</span>--></h4>
									</li> 
									
									<li><a class="dropdown-item" href="<?php echo base_url() ?>login/doLogout"><img src="<?php echo base_url() ?>assets/images/user-dropdown-icon-10.png" alt=""> Log out</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--<div class="row">
				<div class="col-md-12" style="color:#f00">
					<marquee behavior="scroll" scrollamount="3" direction="left">San Antonio, Texas is experiencing unprecedented weather conditions, fortunately, Pro-Vigil is still operational.  We’ve deployed extra crews, but our responses may be slower than normal. If you need immediate assistance, please call us at 866-616-1318.</marquee>
				</div>
			</div>-->
		</div> <!-- end container -->
	</div>
