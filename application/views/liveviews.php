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
						<div class="col-sm-5">
							<h2 class="title"><?php echo $title; ?></h2> <h4 class="sitetitle"><?php echo $selectedSite['siteName'];?></h4>
						</div>
						<div class="col-sm-7">
							<div class="cam-pagination-listsImg">
								<div class="cam-pagination" id="cam-pagination">
									
								</div>
								<?php include('potentialList.php');?>
							</div>
						</div>
					</div>

				</div>
			</div>
			<input type="hidden" id="noOfPages" />
			<input type="hidden" id="currentPage" value="0"/>
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
							<div class="col-sm-8">
								<ul class="nav nav-tabs" role="tablist" id="myTab">
									<li class="active"><a href="#cameraview" role="tab" data-toggle="tab">Camera View</a></li>
									<li><a href="#maskingview" role="tab" data-toggle="tab">Masking View</a></li>
									
								</ul>
							</div>
							<div class="col-sm-4">
								<!--<div class="lastmodifiedonsec">
									<label>Last Modified On:</label> <p class="lastmodifiedon"></p>
								</div>-->
							</div>
						</div>
						<div class="tab-content">
							<div class="tab-pane active" id="cameraview">
								<div class="row">
									<div class="col-sm-6">
										<h4>Day View</h4>
										<div class="cameraDayView"><img class="img-responsive" src="assets/images/img1.png" alt=""></div>
										<div class="lastmodifiedonsec text-center"><label>Last Modified On:</label> <p class="dayLastModifiedDt displayInlineBlock"></p></div>
									</div>
									<div class="col-sm-6">
										<h4>Night View</h4>
										<div class="cameraNightView"><img class="img-responsive" src="assets/images/img1.png" alt=""></div>
										<div class="nightLastmodifiedonsec text-center"><label>Last Modified On:</label> <p class="nightLastModifiedDt displayInlineBlock"></p></div>
										
									</div>
									
								</div>
							</div>
							<div class="tab-pane" id="maskingview">	
								<div class="row">
									<div class="col-sm-6">
										<h4>Day Masking View</h4>
										<div class="dayMaskingView"><img class="img-responsive" src="assets/images/daynightimg.png" alt=""></div>
										<div class="lastmodifiedonsec text-center"><label>Last Modified On:</label> <p class="dayLastModifiedDt displayInlineBlock"></p></div>
									</div>
									<div class="col-sm-6">
										<h4>Night Masking View</h4>
										<div class="nightMaskingView"><img class="img-responsive" src="assets/images/daynightimg.png" alt=""></div>
										<div class="nightLastmodifiedonsec text-center"><label>Last Modified On:</label> <p class="nightLastModifiedDt displayInlineBlock"></p></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--<script src="https://hls-js.netlify.app/dist/hls.js"></script>-->
	
	<script src="<?php echo base_url()?>assets/js/hls.js"></script>
	<!--Masking modal ends here-->
	<!--Video Play modal starts here-->
	<div class="video-popup-model">
		<!-- Modal -->
		<div class="modal modalBlock" id="myModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRTMPStream()"><span aria-hidden="true">&times;</span></button>                  
						<h4 class="modal-title"> <i class="fa fa-circle" aria-hidden="true"></i><span>Houston-branch Outside Cam</span></h4>
					</div>
					<div class="modal-body">
						<!--<div class="liveswitchBlock">
							<label class="switchToggle"><input type="checkbox" ><span class="hdSlider round"></span></label>
						</div>-->
						<div id="hlsTimer"></div>
						<div class="liveswitchVideo">
							<img src="" class="displaynone video-frame" id="cameraLiveView">
							<div class="camControls displaynone">
								<div class="singleBt">
									<button class="camPTZAction" data-action="TILTUP"><img src="assets/images/tilt_up.png"> </button>
								</div>
								<div class="multiBt">
									<button class="camPTZAction" data-action="PANLEFT"><img src="assets/images/pan_left.png"></button>
									<button class="camPTZAction" data-action="GOTOPRESET"><img src="assets/images/preset.png"> </button> 
									<button class="camPTZAction" data-action="PANRIGHT"><img src="assets/images/pan_right.png"> </button>
								</div>
								<div class="singleBt">
									<button class="camPTZAction" data-action="TILTDOWN"><img src="assets/images/tilt_down.png"> </button>
								</div>
								<div class="singleBt">
									<button class="camPTZAction" data-action="ZOOMIN"><img src="assets/images/zoom_in.png"> </button>
								</div>
								<div class="singleBt">
									<button class="camPTZAction" data-action="ZOOMOUT"><img src="assets/images/zoom_out.png"> </button>
								</div>
								<div class="multiBt bottomControl">
									<button class="camStreamSpeed" data-speed="1">L</button> 
									<button class="camStreamSpeed active" data-speed="2">M</button> 
									<button class="camStreamSpeed" data-speed="3">H
								</div>
							</div>
							<div id="rtmpLiveStram">
								
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="video-popup-model">
		<!-- Modal -->
		<div class="modal modalBlock" id="hlsModal" role="dialog" >
			<div class="modal-dialog modal-lg" >
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeHLSStream()"><span aria-hidden="true">&times;</span></button>                  
						<h4 class="modal-title"> <i class="fa fa-circle" aria-hidden="true"></i><span>HLS Video</span></h4>
					</div>
					<div class="modal-body">
						<!--<div class="liveswitchBlock">
							<label class="switchToggle"><input type="checkbox" ><span class="hdSlider round"></span></label>
						</div>-->
						<div id="hlsStreamSection">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<input type="hidden" id="isHLSMaxTimeReached" value="0">
	

	<!--Video Play modal ends here-->
			</div>
			<style>
				video::-webkit-media-controls-play-button { display: none;}
				video::-webkit-media-controls-pause-button {
					display: none; 
				}
				video::-webkit-media-controls-fullscreen-button {
					display: none;
				}
				video::-webkit-media-controls-volume-slider {  display: none; }

				video::-webkit-media-controls-mute-button {  display: none; }
				video::-webkit-media-controls-timeline { display: none;}
				video::-webkit-media-controls-current-time-display{ display: none;}
				video::-webkit-media-controls-time-remaining-display { display: none;}
			</style>
			<!-- content -->
			<script>
				var initial;
				
                $(document).ready(function(){
					clearTimeout(initial);
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
							$("#cam-pagination").html('').removeClass('showpgnation');
							let viewType = $(".activeGrid").attr('data-show');
							getLiveViews(viewType);
                               $(".sitetitle").html(siteName);
                            }, function(e) {
                                //$('#contactRequestError').html(v.msg);
                                console.log(v);
                            });
                       }
                    });
					
					/*  for masking script is start here */
					$(document).on('click','.masking',function(){
						let source = $(this).attr('data-source');
						let cameraDayView = $(this).attr('data-cameradayImg');
						let dayMaskingView = $(this).attr('data-daymaskimage');
						let cameraNightView = $(this).attr('data-nightimage');
						let nightMaskingView = $(this).attr('data-nightmaskimage');
						let lastmodifiedon  = $(this).attr('data-lastmodifiedon');
						let night_lastmodifiedon  = $(this).attr('date-night_lastmodifiedon');
						let connected = $(this).attr('data-connected');
						var cameraName = $(this).closest('.video-header').find('h3').text();
						$('#maskingimg').modal('show');
						$("#maskingimg .modal-title .camTitle").text(cameraName);
						if(source=='IVigil'){
							if(lastmodifiedon!="")
							{
								$('.masking-model .dayLastModifiedDt').text(lastmodifiedon);
							}
							else{
								$('.masking-model .lastmodifiedonsec').hide();
							}
							if(night_lastmodifiedon!="")
							{
								$('.masking-model .nightLastModifiedDt').text(night_lastmodifiedon);
							}
							else{
								$('.masking-model .lastmodifiedonsec').hide();
							}
							$('.masking-model .cameraDayView').find('img').attr('src', cameraDayView);
							$('.masking-model .dayMaskingView').find('img').attr('src', dayMaskingView);
							$('.masking-model .cameraNightView').find('img').attr('src', cameraNightView);
							$('.masking-model .nightMaskingView').find('img').attr('src', nightMaskingView);
						}else{
							$('.masking-model .lastmodifiedonsec').hide();
							$('.masking-model .cameraDayView').html(cameraDayView).css('text-align','center');
							$('.masking-model .dayMaskingView').html(dayMaskingView).css('text-align','center');
							$('.masking-model .cameraNightView').html(cameraNightView).css('text-align','center');
							$('.masking-model .nightMaskingView').html(nightMaskingView).css('text-align','center');
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
						//$('#myModal').show();
						
						$(".liveswitchVideo .camControls").hide();
						let source = $(this).attr('data-source');
						let hdurl = $(this).attr('data-hdurl');
						let cameraId = $(this).attr('data-cameraId');
						localStorage.setItem('selectedCameraId', cameraId);
						localStorage.setItem('selectedSource', source);
						sdurl = $(this).attr('data-sdurl');
						//console.log(sdurl);
						let connected = $(this).attr('data-connected');
						let name = $(this).attr('data-name');
						let analyticId = $(this).attr('data-analyticId');
						localStorage.setItem('selectedAnalyticId', analyticId);
						let i = 1;
						$('.video-popup-model .modal-title span').html(name);
						if(connected !=''){
							$('.video-popup-model .fa-circle').addClass(connected);
						}else{
							$('.video-popup-model .fa-circle').removeClass('redcircle');
						}
						let ownerEmail = $(this).attr('data-ownerEmail');
						localStorage.setItem('selectedownerEmail', ownerEmail);
						let authToken  = $(this).attr('data-authToken');
						localStorage.setItem('selectedauthToken', authToken);
						if(source=='IVigil'){
							//$('.video-popup-model').find('img').attr('src', sdurl);
							var isPTZ = $(this).attr('data-ptz');
							
							
							if(analyticId === '3'){
								
								interval = setInterval(() => {
									tmpsdurl = sdurl+i;
									$('.video-popup-model').find('img#cameraLiveView').attr('src', tmpsdurl);
									if(isPTZ=="true")
									{
										$(".liveswitchVideo .camControls").show();
									}
									else
									{
										$(".liveswitchVideo .camControls").hide();
									}
									$("#page-overlay").hide();
									i++;
                        		}, 1000);
								$('.liveswitchBlock').hide();
								$('.switchToggle').hide();
							}else if(analyticId === '1'){
								$('.liveswitchBlock').show();
								$('.switchToggle').show();
								var rtmpURL = getCamioRTMPLiveURL(cameraId,ownerEmail,authToken);
							    
							}
							else if(analyticId === '7' || analyticId === '8' || analyticId === '9')
							{
								//console.log(hdurl); Get the HLS stream
								getHLSStream(hdurl);
							}
						}
						else
						{
							$(".liveswitchVideo .camControls").hide();
							var rtmpURL = getCamioRTMPLiveURL(cameraId,ownerEmail,authToken);
							
							
						}
						
						if(analyticId === '1' || analyticId === '3')
						{
							$('#myModal').modal('show');
							$('#myModal').data('bs.modal').options.backdrop = 'static';
							setTimeout(() => {
								$("#page-overlay").hide();
							}, 500);
						}
						else if(analyticId === '7' || analyticId === '8' || analyticId === '9')
						{
							$('#hlsModal').modal('show');
							$('#hlsModal').data('bs.modal').options.backdrop = 'static';
						}
						
						
					});
					$(document).on('click','.video-popup-model .close', function(){
						$('#myModal').modal('hide');
						$('#hlsModal').modal('hide');
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
				
				function getCamioRTMPLiveURL(cameraId,ownerEmail,authToken)
				{
					$("#page-overlay").show();
					var url = "<?php echo base_url() ?>liveviews/getCamioRTMPLiveURL/";
					var data = {"cameraId":cameraId,"ownerEmail":ownerEmail,"authToken":authToken};
					response = ajaxRequestPromiseReturnHtml(url, data);
					response.then(function(v) {
						$("#page-overlay").hide();
						var rtmpURL = v;
						if(rtmpURL!="" && rtmpURL!=undefined)
						{
							//var cameraRTMPLiveURL = "<div class='rtmp' style=' height: 430px;'><object type='application/x-shockwave-flash' id='player' data='assets/plugins/GrindPlayer.swf' width='100%' height='100%' style='visibility: visible;'><param name='allowFullScreen' value='true'><param name='allowScriptAccess' value='always'><param name='wmode' value='opaque'><param name='flashvars' value='autoPlay=true&amp;src=" + rtmpURL + "&amp;streamType=live&amp;scaleMode=letterbox'></object></div>";
							//var cameraRTMPLiveURL = '<video width="320" height="240" autoplay oncontextmenu="return false;" disablePictureInPicture controlsList="nodownload">  <source src='+ rtmpURL +' type="video/mp4">  <source src="movie.ogg" type="video/ogg">  Your browser does not support the video tag.</video>';
							showCamioRTMPHLSStream(rtmpURL);
						}
						else
						{
							var msg = "Live View is not available";
							var cameraRTMPLiveURL = "<div class='liveview_col text-center'>"+msg+"</div>";
							$('#rtmpLiveStram').html(cameraRTMPLiveURL);
						}
						
						
					}, function(e) {
						//$('#contactRequestError').html(v.msg);
						$("#page-overlay").hide();
						console.log(e);
					});
				}
				function showCamioRTMPHLSStream(hlsURL)
				{
					$('#rtmpLiveStram').html('');
					$("#page-overlay").show();
					$('#rtmpLiveStram').html('<video oncontextmenu="return false;" id="video" autoplay height="auto" controls controlsList="nodownload" disablePictureInPicture></video>');
					var video = document.getElementById('video');
					if(Hls.isSupported()) {
						var hls = new Hls({
							debug: false
						});
						
						$("#page-overlay").hide();
						$('#myModal .modal-dialog').addClass('modal-lg');
						hls.loadSource(hlsURL);
						hls.attachMedia(video);
						var vUrl="";
						var isplayed = 0;
						hls.on(Hls.Events.MEDIA_ATTACHED, function() {
							video.muted = false;								
							clearTimer = setTimeout(function(){
								
								if (video.currentTime < 0.01 || video.ended) {
									
									hls.loadSource(hlsURL);
									hls.attachMedia(video);
								}
													
							},3000);
						
						});
							
					}
					else if (video.canPlayType('application/vnd.apple.mpegurl')) {
						video.src = hlsURL;
						video.addEventListener('canplay',function() {
						video.play();
						
						});
					}
				}
				
				$(document).on("click",".camPTZAction",function(){
					$(".camPTZAction").removeClass('active');
					$(this).addClass('active');
					camPTZControl();
				});
				
				$('.multiBt.bottomControl button').on('click', function(){
				$(this).siblings().removeClass('active'); // if you want to remove class from all sibling buttons
				$(this).toggleClass('active');
				camPTZControl();
				});
				
				function camPTZControl()
				{
					var ptzActionVal = $(".camPTZAction.active").attr('data-action');
					var camStreamSpeedVal = $(".camStreamSpeed.active").attr('data-speed');
					
					//var cameraId = "Camera127";
					var cameraId = localStorage.getItem('selectedCameraId');
					$("#page-overlay").show();
					var url = "<?php echo base_url() ?>liveviews/getCamioPTZLiveURL/";
					var data = {"cameraId":cameraId,"selectedSpeed":camStreamSpeedVal,"selectedAction":ptzActionVal};
					response = ajaxRequestPromiseReturnHtml(url, data);
					response.then(function(v) {
						$("#page-overlay").hide();
					}, function(e) {
						//$('#contactRequestError').html(v.msg);
						console.log(e);
					});
				}
				
				function closeRTMPStream()
				{
					var selectedAnalyticId = localStorage.getItem('selectedAnalyticId');
					
					if(selectedAnalyticId=='1')
					{
						$("#page-overlay").show();
						var cameraId = localStorage.getItem('selectedCameraId');
						var ownerEmail = localStorage.getItem('selectedownerEmail');
						var authToken  = localStorage.getItem('selectedauthToken');
						
						var url = "<?php echo base_url() ?>liveviews/closeRTMPStream/";
						var data = {"cameraId":cameraId,"ownerEmail":ownerEmail,"authToken":authToken};
						response = ajaxRequestPromiseReturnHtml(url, data);
						response.then(function(v) {
							$("#page-overlay").hide();
						}, function(e) {
							//$('#contactRequestError').html(v.msg);
							console.log(e);
						});
						$('#video').attr('src','');
						$('#rtmpLiveStram').html('');
					}
					else if(selectedAnalyticId==7 || selectedAnalyticId==8 || selectedAnalyticId==9)
					{
						$('#video').attr('src','');
					}
				}
				
				function autoPlayAllCameras()
				{
					
					let j = 1;
					interval = setInterval(() => {
						$(".video-img").each(function(i){
							var analyticId = $(this).attr('data-analyticid');
							//if(analyticId==3)
							if(analyticId!=1)
							{
								var sdURL = $(this).attr('data-sdurl');
								tmpsdurl = sdURL+j*1;
								var image = $(this).find('.videoImgPosition img').attr('src',tmpsdurl);
							}
						});
					j++;
					}, 1000);
					
				}
				function getLiveViews(parm='multi'){
						var siteurl = "<?php echo base_url() ?>";
						if (siteurl != undefined) {
							$("#page-overlay").show();
							var currentPage = $("#camerasPagination").val()*1;
							if(isNaN(currentPage))
							{
								currentPage = 1;
							}
							else
							{
								currentPage = $("#camerasPagination").val()*1;
							}
							var url = "<?php echo base_url() ?>liveviews/getLiveViews/"+parm;
							var data = {'pageNo':currentPage};
							response = ajaxRequestPromiseReturnHtml(url, data);
							response.then(function(v) {
								$("#page-overlay").hide();
								var res = JSON.parse(v);
								$(".live-views").html(res.result);
								$("#noOfPages").val(res.noOfPages);
							
								if(res.noOfPages>1 && !$("#cam-pagination").hasClass("showpgnation"))
								{
									showPagination(res.noOfPages);
								}
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
								autoPlayAllCameras(); // Auto play all IVR cameras
							}, function(e) {
								//$('#contactRequestError').html(v.msg);
								console.log(e);
							});
						}	
					}
				function showPagination(noOfPages)
				{
					if(noOfPages>1 && noOfPages!=undefined)
					{
						var str='<label>Select Page</label>';
						str+='<select class="form-control" id="camerasPagination">';
						for(var i =1;i<=noOfPages;i++)
						{
							str+='<option value='+i+'>'+i+'</option>';
						}
						str+='</select>';
						
						$("#cam-pagination").html(str).addClass('showpgnation');
					}
				}
				$(document).on("change","#camerasPagination",function()
				{
					let viewType = $(".activeGrid").attr('data-show');
					
					getLiveViews(viewType);
				});
				
				
				function getHLSStream(hdurl)
				{
					$("#page-overlay").show();
					//$("#video").hide();
					$('#hlsStreamSection .liveview_col').html('');
					$("#video").attr('src','');
					setTimeout(() => {
						$("#page-overlay").show();
					}, 50);
					
					var url = "<?php echo base_url() ?>liveviews/getHLSStreamURL/";
					var data = {"hdurl":hdurl};
					response = ajaxRequestPromiseReturnHtml(url, data);
					var j=0;
					response.then(function(v) {
						
						var res = JSON.parse(v);
						var hlsurl = res.hlsUrl;
						var expirySeconds = res.expirySeconds;
						if(res.success=="1" && hlsurl!=undefined && hlsurl!="")
						{
							$("#page-overlay").hide();
							$('#hlsStreamSection').html('<video oncontextmenu="return false;" id="video" autoplay height="auto" controls controlsList="nodownload" disablePictureInPicture></video>');
							//enableHLSStream(hlsurl);
							var video = document.getElementById('video');
							if(Hls.isSupported()) {
							
							var hls = new Hls({
								debug: false
							});
							//hlsurl='https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8';
							hls.loadSource(hlsurl);
							hls.attachMedia(video);
							var vUrl="";
							var isplayed = 0;
							hls.on(Hls.Events.MEDIA_ATTACHED, function() {
								video.muted = false;								
								clearTimer = setTimeout(function(){
									
									if (video.currentTime < 0.01 || video.ended) {
										
										hls.loadSource(hlsurl);
									    hls.attachMedia(video);
										
										isplayed = 1;
										clearTimeout(clearTimer); //4mins
										if($('.jconfirm').hasClass('jconfirm-open')===true)
										{
											$('#video')[0].pause();
										}
									}
									else{
										if (isplayed ==1 && video.currentTime>=0.01) {
											if($('.jconfirm').hasClass('jconfirm-open')===true)
											{
												$('#video')[0].pause();
											}	
											if($('#isHLSMaxTimeReached').val()==0)
											{
												showContinuealertmsg();
											}
											
										}
									}
									
								},3000);
								if($('#isHLSMaxTimeReached').val()==0)
								{
									showContinuealertmsg();
								}
							});
							
							}
							// hls.js is not supported on platforms that do not have Media Source Extensions (MSE) enabled.
							// When the browser has built-in HLS support (check using `canPlayType`), we can provide an HLS manifest (i.e. .m3u8 URL) directly to the video element throught the `src` property.
							// This is using the built-in support of the plain video element, without using hls.js.
							else if (video.canPlayType('application/vnd.apple.mpegurl')) {
							video.src = hlsurl;
							video.addEventListener('canplay',function() {
							video.play();
							
							});
							}
							//showContinuealertmsg();
							showHLSExpiryMsg(expirySeconds,hdurl);
						}
						else
						{
							$("#video").hide();
							$("#page-overlay").hide();
							var msg = res.msg;
							var hlsLiveURL = "<div class='liveview_col text-center'>"+msg+"</div>";
							$('#hlsStreamSection').html(hlsLiveURL);
						}
					
						
					}, function(e) {
						$("#page-overlay").hide();
						console.log(e);
					});
				}
				function showHLSExpiryMsg(expirySeconds,hlsurl)
				{
					
					let j = expirySeconds;
					interval = setInterval(() => {
					var isHLSWindowOpen = $('#hlsModal').hasClass('in');	
					
						if(j==0 && isHLSWindowOpen==true)
						{
							clearInterval(interval);
							getHLSStream(hlsurl);
							
						}
					j--;
					}, 1000);
				}
				
				function showMaxFeedTimedOut()
				{
					let j = 60000;
					interval = setInterval(() => {
					var isHLSWindowOpen = $('#hlsModal').hasClass('in');	
					
						if(j==0 && $('#hlsModal').hasClass('in') && hlsUrl!='unknown' && hlsUrl!=undefined && isHLSMaxTimeReached==0) 
						{
							var hlsUrl = $("#video").attr('src');
							var isHLSMaxTimeReached = $('#isHLSMaxTimeReached').val(); 
							
							$('#isHLSMaxTimeReached').val(1);
							$.confirm({
								title: 'Please Confirm ',
								content: 'Video feed has timed out. Do you want to continue?',
								buttons: {

								confirm: function (e) {
									this.$$confirm.prop('disabled', true);
									$('#isHLSMaxTimeReached').val(0);
									clearInterval(interval);
								},
								cancel: function () {
									$('#hlsModal').modal('hide');
									$("#page-overlay").hide();
									$("#video").attr('src','');
									$('#hlsStreamSection').html('');
									$('#isHLSMaxTimeReached').val(0);
								},
								}
							});
								
						}			
						
					j--;
					}, 1000);
				}
				
				function showContinuealertmsg()
				{
					console.log('calling');
					
					var hlsUrl = $("#video").attr('src');
					//var isHLSMaxTimeReached = $('#isHLSMaxTimeReached').val(); 
					//clearTimeout(initial);
					$('#isHLSMaxTimeReached').val(1);
					initial = setTimeout(function(){ 
						//console.log($('.jconfirm').hasClass('jconfirm-open'));
						if($('#hlsModal').hasClass('in') && hlsUrl!='unknown' && hlsUrl!=undefined) 
						{
							//console.log($('.jconfirm').hasClass('jconfirm-open'));
							//clearTimeout(initial);
							//$('#video')[0].pause();
							//$('#isHLSMaxTimeReached').val(1);
							
							if($('.jconfirm').hasClass('jconfirm-open')===false){
								$('#video')[0].pause();
								//clearTimeout(initial);
							$.confirm({
								title: 'Please Confirm ',
								content: 'Video feed has timed out. Do you want to continue?',
								buttons: {

								confirm: function (e) {
									this.$$confirm.prop('disabled', true);
									$('#video')[0].play();
									clearTimeout(initial);
									$('#isHLSMaxTimeReached').val(0);
									showContinuealertmsg();
									
									
								},
								cancel: function () {
									$('#hlsModal').modal('hide');
									$("#page-overlay").hide();
									$("#video").attr('src','');
									$('#hlsStreamSection').html('');
									$('#isHLSMaxTimeReached').val(0);
									clearTimeout(initial);
								},
								}
							});
							}
						}
						clearTimeout(initial);
					}, 600000); //600000
				}
				function closeHLSStream()
				{
					$('#isHLSMaxTimeReached').val(0); 
					$('#hlsStreamSection').html('');
					clearInterval(interval);
					clearTimeout(initial);
					
				}
				
				jQuery(document).ready(function(){
					jQuery('body').on('contextmenu', 'video', function() { return false; });
					$('body').on('click', '#video', function() { return false; });
				});

            </script>