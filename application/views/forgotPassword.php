<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $formData=$this->form_validation->get_session_data();
?>
<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@@ Janapriya Builders @@</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

<link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet">

</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-8">
                        <div class="slider-light">
                            <div class="slick-slider">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-plum-plate" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('<?php echo base_url();?>assets/images/login-register.jpg');"></div>
                                       
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-4 col-lg-4 login_col">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo"><img src="<?php echo base_url();?>assets/images/logo-inverse.png"/></div>
                            
                            <div class="divider row"></div>
							<div align="center">
								<?php if (isset($page) && $page == "logout"): ?>
									<div class="alert alert-success hide_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> Logout Successfully &nbsp;
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
								</div>
								<?php endif ?>
							</div>
                            <div>
							
                             <?php echo $this->messages->getMessageFront(); 
                            
                                $url=base_url()."login/forgotPassword";
                                echo form_open($url,
                                            array('class' => 'passwordReset',
                                                 'id' => 'passwordReset',
                                                // 'onsubmit' => ""
                                                  )
                                             );
                                             ?>



                              <!--  <form class="" autocomplete="off" action="<?php echo base_url()?>login/userlogin" method="post"> -->
                                  
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group"><label for="exampleEmail" class="">Email</label>
                                            <input name="username" id="exampleEmail" placeholder="Email" type="email" value="<?php if(isset($formData['username'])){echo $formData['username'];} ?>" class="form-control" autocomplete="off"></div>
                                        </div>
                                    </div>
                                    <!--<div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Keep me logged in</label></div>-->
                                   
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto"><a href="<?php echo base_url('login') ?>"   class="btn-lg btn btn-link">Have Password? Click Here</a>
                                            <button class="btn btn-primary btn-lg">Recover Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

</body>

</html>