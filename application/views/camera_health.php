<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="content-page m-l-0">
			<!-- Start content -->
			<div class="content">
				<!-- Top Action Col -->
				<div class="main-action-col">
					<div class="container">
						<div class="row">
							<div class="col-md-8">
								<h2 class="title">Equipment Health</h2>
								<h4 class="sitetitle"><?php echo $selectedSite['siteName'];?></h4>
								
							</div>
							<?php include('potentialList.php');?>
						</div>
					</div>
				</div>
				<!-- Top Action Col End -->
				<!-- Workspace -->
                <div class="camera-health-block">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 healthy-ui">
								<ul>
									<li><span class="healthy-icon"><i class="fa fa-circle" aria-hidden="true"></i></span>Disconnected</li>
									<li><span class="not-healthy-icon"><i class="fa fa-circle" aria-hidden="true"></i></span>Connected</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 camera-block">
								<ul id="siteCamerasHealthReport">
								
								</ul>
							</div>
						</div>
                    </div>
               </div>
             <!-- Workspace End -->
			
			</div>
			<!-- content -->
			<script>
                $(document).ready(function(){

					setTimeout(() => {
						$("#page-overlay").show();
					}, 50);
					getSiteDevicesHelath();


                    $(".sites-list").change(function(){
                        var site = $(this).val();
						var siteName = $(".sites-list :selected").text();
						var siteurl = "<?php echo base_url()?>";
                        if(site!=undefined)
                       {
                           var url="<?php echo base_url()?>usersites/selectSite";
                           var data = { 'site': site};
                           response=ajaxRequestWithPromise(url,data);
                           response.then(function(v) {
							getSiteDevicesHelath()
                               $(".sitetitle").html(siteName);
                            }, function(e) {
                                //$('#contactRequestError').html(v.msg);
                                console.log(v);
                            });
                       }
                    });
                });
				function getSiteDevicesHelath()
				{
					var siteurl = "<?php echo base_url() ?>";
						if (siteurl != undefined) {
							$("#page-overlay").show();
							var url="<?php echo base_url()?>camerahealth/getSiteCameraHelath";
							var data = {};
							response = ajaxRequestPromiseReturnHtml(url, data);
							response.then(function(v) {
								$("#page-overlay").hide();
								
								$("#siteCamerasHealthReport").html(v)
							}, function(e) {
							//$('#contactRequestError').html(v.msg);
							console.log(v);
							});
						}
				}
            </script>