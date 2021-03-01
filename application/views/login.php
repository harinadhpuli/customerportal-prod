<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $formData=$this->form_validation->get_session_data();
?>
<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Pro-Vigil Monitoring</title>
    <link rel='shortcut icon' type='image/png' href='<?php echo base_url() ?>assets/images/favicon.ico'/>
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>assets/css/login.css" rel="stylesheet">

    <link href="<?php echo base_url() ?>assets/css/general-style.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.typekit.net/gkf2ief.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

     <![endif]-->   
    
     <link href="<?php echo base_url() ?>assets/css/customer-portal-responsive.css" rel="stylesheet">
     <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
</head>

<body class="bg-overlay">
	
		<div class="container">
		<div class="login-block">
					<!--<div class="row">
						<div class="col-md-12 text-center logo">
							<img src="<?php echo base_url() ?>assets/images/logo-login.png">
						</div>
					</div>-->
			<!--<div class="row">
				<div class="col-md-12" style="color:#f00">
					<marquee behavior="scroll" scrollamount="3" direction="left">San Antonio, Texas is experiencing unprecedented weather conditions, fortunately, Pro-Vigil is still operational.  We’ve deployed extra crews, but our responses may be slower than normal. If you need immediate assistance, please call us at 866-616-1318.</marquee>
				</div>
			</div>-->
			<div class="row login-form">
						<div class="text-center logo">
							<img src="<?php echo base_url() ?>assets/images/logo-login.png">
						</div>
						
				<div class="col-md-12">              
					<div align="center">
						<?php if (isset($page) && $page == "logout"): ?>
							<div class="alert alert-success hide_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> Logout Successfully &nbsp;
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
						</div>
						<?php endif ?>
					</div>
					<?php echo $this->messages->getMessageFront(); 
                            
                                $url=base_url()."login/userlogin";
                                echo form_open($url,
                                            array('class' => 'adminLogin',
                                                 'id' => 'adminLogin',
                                                // 'onsubmit' => ""
                                                  )
                                             );
                                             ?>

								<div class="form-group">

								  <div class="field">

									  <input type="text" name="username" id="email" placeholder="USER NAME">
									

									</div>
								</div>

								<div class="form-group">

									<div class="field">
									  <input type="password" name="password" id="password" placeholder="PASSWORD">
									 

									</div>
								</div>
								<div class="form-group login-action-col">

									<button class="btn btn-default">Log in</button>

								</div>
                                   
                            </form>
				</div>
			</div>
							<!--<div class="row">
								<div class="col-md-12 text-center login-footer">
								  Copyright © <?php echo date('Y');?>, Pro-Vigil, Inc. All rights reserved. 
								</div>
							</div>-->
		</div>
  </div>
   <script>

	   $("#messages .close").click(function(e){
		   	e.preventDefault();
			$("#messages").find('span').html('');
			$("#messages").hide();
	   });
	  
   </script>
</body>
</html>