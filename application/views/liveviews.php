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
						<div class="col-sm-8">
							<h2 class="title"><?php echo $title; ?></h2> <h4 class="sitetitle"><?php echo $selectedSite['siteName'];?></h4>
						</div>
						<?php include('potentialList.php');?>
					</div>

				</div>
			</div>

			<!-- Top Action Col End -->
            <!-- Workspace -->
			<div class="camera-view-block">
				<div class="container">
					<div class="live-views">                            
						                          
					</div>
				</div>
			</div>
			 <!-- Workspace End -->
	<!--Masking Modal starts here-->
	<div class="video-popup-model masking-model">
		<div class="modal modalBlock" id="maskingimg" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"> <i class="fa fa-circle" aria-hidden="true"></i><span class="camTitle">Houston-branch Outside Cam</span></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-6">
								<h4>Camera View</h4>
								<div class="cameraView"><img class="img-responsive" src="assets/images/img1.png" alt=""></div>
							</div>
							<div class="col-sm-6">
								<h4>Masking View</h4>
								<div class="maskingView"><img class="img-responsive" src="assets/images/daynightimg.png" alt=""></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Masking modal ends here-->
	<!--Video Play modal starts here-->
	<div class="video-popup-model">
		<!-- Modal -->
		<div class="modal modalBlock" id="myModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                  
						<h4 class="modal-title"> <i class="fa fa-circle" aria-hidden="true"></i><span>Houston-branch Outside Cam</span></h4>
					</div>
					<div class="modal-body">
						<!--<div class="liveswitchBlock">
							<label class="switchToggle"><input type="checkbox" ><span class="hdSlider round"></span></label>
						</div>-->
						<div class="liveswitchVideo">
							<img src="" class="displaynone video-frame">
							<div id="rtmpLiveStram"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--Video Play modal ends here-->
			</div>
			<!-- content -->
			<script>
                $(document).ready(function(){
					setTimeout(() => {
						$("#page-overlay").show();
					}, 50);
					getLiveViews();
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
							let viewType = $(".activeGrid").attr('data-show');
							getLiveViews(viewType);
                               $(".sitetitle").html(siteName);
                            }, function(e) {
                                //$('#contactRequestError').html(v.msg);
                                console.log(v);
                            });
                       }
                    });
					function getLiveViews(parm='multi'){
						var siteurl = "<?php echo base_url() ?>";
						if (siteurl != undefined) {
							$("#page-overlay").show();
							var url = "<?php echo base_url() ?>liveviews/getLiveViews/"+parm;
							var data = {};
							response = ajaxRequestPromiseReturnHtml(url, data);
							response.then(function(v) {
								$("#page-overlay").hide();
								$(".live-views").html(v);
								if(parm==1){
									$('.camera-view-block').removeClass('camera-view-Three');
									$('.camera-view-block').removeClass('camera-view-Two');
									$('.camera-view-block').addClass('camera-view-One');
								}else if(parm==2){
									$('.camera-view-block').removeClass('camera-view-Three');
									$('.camera-view-block').addClass('camera-view-Two');
									$('.camera-view-block').removeClass('camera-view-One');
								}else{
									$('.camera-view-block').addClass('camera-view-Three');
									$('.camera-view-block').removeClass('camera-view-Two');
									$('.camera-view-block').removeClass('camera-view-One');
								}
							}, function(e) {
								//$('#contactRequestError').html(v.msg);
								console.log(e);
							});
						}	
					}
					/*  for masking script is start here */
					$(document).on('click','.masking',function(){
						let source = $(this).attr('data-source');
						let cameara = $(this).attr('data-camera');
						let masking = $(this).attr('data-masking');
						let connected = $(this).attr('data-connected');
						var cameraName = $(this).closest('.video-header').find('h3').text();
						$('#maskingimg').modal('show');
						$("#maskingimg .modal-title .camTitle").text(cameraName);
						if(source=='IVigil'){
							$('.masking-model .cameraView').find('img').attr('src', cameara);
							$('.masking-model .maskingView').find('img').attr('src', masking);
						}else{
							$('.masking-model .cameraView').html(cameara).css('text-align','center');
							$('.masking-model .maskingView').html(masking).css('text-align','center');
						}
						if(connected !=''){
							$('.masking-model .fa-circle').addClass(connected);
						}else{
							$('.masking-model .fa-circle').removeClass('redcircle');
						}
						
					});
					$(document).on('click','.masking-model .close', function(){
						$('#maskingimg').modal('hide');
					});
					/*  for masking script is ends here */
					/* Play video script starts here */
					let interval;
					let sdurl;
					$(document).on('click','.play-live, .video-img', function(){
						$("#page-overlay").show();
						let source = $(this).attr('data-source');
						let hdurl = $(this).attr('data-hdurl');
						let cameraId = $(this).attr('data-cameraId');
						sdurl = $(this).attr('data-sdurl');
						//console.log(sdurl);
						let connected = $(this).attr('data-connected');
						let name = $(this).attr('data-name');
						let analyticId = $(this).attr('data-analyticId');
						let i = 1;
						$('.video-popup-model .modal-title span').html(name);
						if(connected !=''){
							$('.video-popup-model .fa-circle').addClass(connected);
						}else{
							$('.video-popup-model .fa-circle').removeClass('redcircle');
						}
						if(source=='IVigil'){
							//$('.video-popup-model').find('img').attr('src', sdurl);
							if(analyticId === '3'){
								interval = setInterval(() => {
									tmpsdurl = sdurl+i;
									//console.log(tmpsdurl);
									$('.video-popup-model').find('img').attr('src', tmpsdurl);
									$("#page-overlay").hide();
									i++;
                        		}, 1000);
								$('.liveswitchBlock').hide();
								$('.switchToggle').hide();
							}else if(analyticId === '1'){
								$('.liveswitchBlock').show();
								$('.switchToggle').show();
								//$('.video-popup-model').find('img').attr('src', hdurl);
								//$('.switchToggle').find('input[type="checkbox"]').prop('checked',true);
								var rtmpURL = getCamioRTMPLiveURL(cameraId);
							
							}
						}else{
							//$('.video-popup-model').find('img').attr('src', hdurl);
							var rtmpURL = getCamioRTMPLiveURL(name);
							
						}
						$('#myModal').modal('show');
						setTimeout(() => {
							$("#page-overlay").hide();
						}, 500);
						
					});
					$(document).on('click','.video-popup-model .close', function(){
						$('#myModal').modal('hide');
						clearInterval(interval);
					});
					$(document).on('click','.video-popup-model input[type="checkbox"]', function(){
						let current = $('.switchToggle').find('input[type="checkbox"]').prop('checked');
						let hdurl = $('.video-img').attr('data-hdurl');
						let sdurl = $('.video-img').attr('data-sdurl');
						if(current){
							$('.video-popup-model').find('img').attr('src', hdurl);
						}else{
							$('.video-popup-model').find('img').attr('src', sdurl);
						}
					});
					/* Play video script ends here */
					/* */
					$(document).on('click','.display-type', function(){
						let viewType = $(this).attr('data-show');
						$('.display-type').removeClass('activeGrid');
						$(this).addClass('activeGrid');
						getLiveViews(viewType);
					});
					/* */
                });
				
				function getCamioRTMPLiveURL(cameraId)
				{
					$("#page-overlay").show();
					var url = "<?php echo base_url() ?>liveviews/getCamioRTMPLiveURL/";
					var data = {"cameraId":cameraId};
					response = ajaxRequestPromiseReturnHtml(url, data);
					response.then(function(v) {
						$("#page-overlay").hide();
						var rtmpURL = v;
						if(rtmpURL!="" && rtmpURL!=undefined)
						{
							var cameraRTMPLiveURL = "<div class='rtmp' style=' height: 430px;'><object type='application/x-shockwave-flash' id='player' data='assets/plugins/GrindPlayer.swf' width='100%' height='100%' style='visibility: visible;'><param name='allowFullScreen' value='true'><param name='allowScriptAccess' value='always'><param name='wmode' value='opaque'><param name='flashvars' value='autoPlay=true&amp;src=" + rtmpURL + "&amp;streamType=live&amp;scaleMode=letterbox'></object></div>";
						}
						else
						{
							var msg = "Live View is not available";
							var cameraRTMPLiveURL = "<div class='liveview_col text-center'>"+msg+"</div>";
						}
						$('#rtmpLiveStram').html(cameraRTMPLiveURL);
						
					}, function(e) {
						//$('#contactRequestError').html(v.msg);
						console.log(e);
					});
				}
				
            </script>