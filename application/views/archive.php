<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<style>

.xdsoft_datetimepicker{ z-index:999999 !important; }

</style>
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
						<h2 class="title"><?php echo $title; ?></h2>
						<h4 class="sitetitle"><?php echo $selectedSite['siteName']; ?></h4>
					</div>
					<?php include('potentialList.php'); ?>
				</div>

			</div>
		</div>

		<!-- Top Action Col End -->
		<!-- Workspace -->
		<div class="m-t-20"></div>
		
		<div class="container archiveBlock">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="responseMsg" style="position: relative">
						<div class="alert alert-danger alert-dismissible fade in" id="customErrorMsgDiv" style="display:none">
							<a href="#" id="successMsgClose" onclick="closeMessagesDivDynamic('Error','#customErrorMsgDiv')" class="close" aria-label="close">&times;</a>
							<span id="customErrorMsg"></span>
						</div>
						
					</div>
				</div>
			</div>
			<div class="archiveVideoBlock margin-top-30" >
			</div>
		</div>
		<!-- Workspace End -->

	</div>
	<!-- content -->
	<!-- Modal -->
	<div class="modal modalBlock footageDownload-modal" id="downloadVideo" role="dialog">

		<div class="modal-dialog">



			<!-- Modal content-->

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<!-- <button type="button" class="close" data-dismiss="modal">HD</button>   -->

					<h4 class="modal-title">Footage Download</h4>

				</div>

				<div class="modal-body">
					<form class="form-inline download-form" method="post" action="<?php echo base_url('archive/downloadArchiveData'); ?>">

						<div class="form-group">
							<label class="label-control">Camera name: </label>
							<h6 class="form-control download-camera-label">houston-branch Cam01</h6>
							<input type="hidden" name="cameraId" class="download-camera" value="">
							<input type="hidden" name="cameraname" class="download-camera-name" value="">
						</div>

						<div class="form-group date-picker-block">
							<label class="label-control">Start date:</label>
							<div class="input-group" >
								<input class="form-control" id="startDate" autocomplete="off" type="text" name="startDate" value="" placeholder="Select Date">
								<span class="glyphicon glyphicon-calendar" id="startOpen"></span>
							</div>
							
						</div>
						<span class="error date-error" style="margin-left:155px;display:none;">Please select date</span>
						<div class="form-group">
							<label class="label-control">Format:</label>
							<select class="form-control" name="format">
								<option value="mp4">mp4</option>
								<option value="mov">mov</option>
							</select>
						</div>
						<div class="form-group">
							<label class="label-control">Duration(minutes):</label>
							<select class="form-control" name="duration">
								<option value="15">15</option>
								<option value="30">30</option>
								<option value="45">45</option>
								<option value="60">60</option>
							</select>
						</div>
						<div class="form-group">
							<label class="label-control">Motion detection:</label>
							<select class="form-control" name="md">
								<option value="true">Yes</option>
								<option value="false">No</option>
							</select>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<div class="buttonOrg"><button type="button" class="btn" id="downloadVideoBtn">Download</button></div>
				</div>
			</div>
		</div>

	</div>
	<!-- Modal -->

	<script>
		let interval;
		$(document).ready(function() {
			setTimeout(() => {
				$("#page-overlay").show();
			}, 50);
			getArchive();
			$(".sites-list").change(function() {
				var site = $(this).val();
				var siteName = $(".sites-list :selected").text();
				var siteurl = "<?php echo base_url() ?>";
				if (site != undefined) {
					var url = "<?php echo base_url() ?>usersites/selectSite";
					var data = {
						'site': site
					};
					response = ajaxRequestWithPromise(url, data);
					response.then(function(v) {
						//getArchive();
						location.reload();
						$(".sitetitle").html(siteName);
					}, function(e) {
						console.log(v);
					});
				}
			});

			function getArchive() {
				var siteurl = "<?php echo base_url() ?>";
				if (siteurl != undefined) {
					$("#page-overlay").show();
					var url = "<?php echo base_url() ?>archive/getArchive/";
					var data = {};
					response = ajaxRequestPromiseReturnHtml(url, data);
					response.then(function(v) {
						var res = JSON.parse(v);
						var archiveDays = res.archieveDays*1 - 1;
						$("#page-overlay").hide();
						$(".archiveVideoBlock").html(res.data);
						$.getScript('<?php echo base_url("assets/js/eventplayer.js"); ?>');
						//$.getScript('<?php echo base_url("assets/js/activitybar.js"); ?>');
						var camName = $("#archiveselect option:selected").text();
						var camId  = $("#archiveselect").val();
						$(".camera_name").text(camName);
						$('.downloadDtPicker').datepicker({
							autoclose: true,
							todayBtn: false,
							todayHighlight: true,
							orientation: "bottom left",
							endDate: '+0d',
							startDate: new Date(new Date().setDate(new Date().getDate() - archiveDays)),
						}).on('changeDate', function(e) {
							
							getCameraVideo();
							clearInterval(interval);
							changeVideoControls();
							loadInitialSelection();
						});
						
						var currentTime = new Date();
						currentTime.setDate(currentTime.getDate()-archiveDays);
						$('#startDate').datetimepicker({
							format: 'm/d/Y H:i',
							minDate:currentTime,
							maxDate: $.now(),
							step:05
						});
				
						$('#startOpen').click(function(){
							$('#startDate').datetimepicker('show');
						});
			
						$('#archiveselect').multiselect({
							enableClickableOptGroups: true,
							enableCaseInsensitiveFiltering: true,
							enableCollapsibleOptGroups: true,
							enableFiltering: true,
							includeSelectAllOption: false
						});

						getCameraVideo();
						setTimeout(function(){ loadInitialSelection(); }, 500);
						
						//var sessionResponse =  ajaxRequestPromiseReturnHtml(url, data);
					}, function(e) {
						console.log(e);
					});
				}
			}
			/*
			* download modal popup video script starts here
			*/
			$(document).on('click','.downloadVideo',function(){
				let cameraId = $('#archiveselect').val();
				let cameraText = $('#archiveselect option:selected').text();
				$('.download-camera').val(cameraId);
				$('.download-camera-label').html(cameraText);
				$('.download-camera-name').val(cameraText);
				$('#startDate').val('');
				$('select[name="format"]').val('mp4');
				$('select[name="duration"]').val('10');
				$('select[name="md"]').val('true');
				$('#downloadVideo').modal('show');
			});
			$(document).on('click','#downloadVideoBtn',function(){
				let date = $('#startDate').val();

				if(date == "" || date == undefined || date == null){
					$('.date-error').show();
				}else{
					$('.date-error').hide();
					$('.download-form').submit();
					
				}
			});
			
			/*
			* download modal popup video script ends here
			*/
		});
		var imageVal;
		
		function getCameraVideo()
		{
			$(".archVideoImg img").attr('src','');
			var camId  = $("#archiveselect").val();
			//var dateTime = $("#downloadDt").val();

			var dateTime = $("#downloadDt").val();
			var selectedTime = $("#svg #selector").attr('title');
			if(selectedTime==undefined)
			{
				selectedTime = "00:00:05";	
			}
			else
			{
				selectedTime = selectedTime;
			}
			
			dateTime = dateTime+" "+selectedTime;
			
			$("#page-overlay").show();
			var url = "<?php echo base_url() ?>archive/getArchiveData";
			var data = {"cameraid":camId,"timestamp":dateTime};
			response = ajaxRequestArchiveData(url, data);
			response.then(function(v) {
				var res = JSON.parse(v);
				imageVal = res.videoPath;
					$(".archVideoImg img").attr("src",res.videoPath);
					
					$("#page-overlay").hide();
			}, function(e) {
				console.log(e);
			});
		}
	
		
		var playicon = "play.png";
		$(document).ready(function() {
			
			$(document).on('click','.play', function(){
				if($(this).hasClass('active')){
					$(this).removeClass('active');
					clearInterval(interval);
					var icon = "play.png";
					
				}else{
					let i = 1;
					
					interval = setInterval(()=>{
						var imgPath = '';
						var currentPath = $(".archVideoImg img").attr('src');
						imgPath = currentPath.replace('next','play');
						imgPath = imgPath.replace('previous','play');
						imgPath = imgPath.replace('forward','play');
						imgPath = imgPath.replace('rewind','play');
						imageVal = imgPath;
					videoPath = imageVal+i;
					$(".archVideoImg img").attr('src',videoPath);
						i++;
					},2000)
					$(this).addClass('active');
					icon = "pause.png";
				}
				$(".play img").attr("src","<?php echo base_url("assets/images/") ?>"+icon);
			});
		});

		$(document).on("change","#archiveselect",function(){
			loadInitialSelection();
			getCameraVideo();
			clearInterval(interval);
			changeVideoControls()
			var cameraName = $("#archiveselect :selected").text();
			$(".archiveBlock-right .camera_name").text(cameraName);
		});

		$(document).on("click","#svg",function(){
			getCameraVideo();
			clearInterval(interval);
			changeVideoControls()
		});
		function changeVideoControls()
		{
			$(".play img").attr("src","<?php echo base_url("assets/images/") ?>"+playicon);
			$(".play").removeClass('active');
		}

		$(document).on("click",".videoOptions",function(){
			var selectedOption = $(this).attr('data-video-option');
			var videoOption = "";
			
			switch(selectedOption)
			{
				case 'rewind': videoOption='rewind';break;
				case 'forward' : videoOption='forward';break;
				case 'next' : videoOption='next';break;
				case 'previous' : videoOption='previous';break;
			}
			var url = "<?php echo base_url() ?>archive/changeArchiveDataVideoControll";
			var data = {"videoOption":videoOption};
			response = ajaxRequestArchiveData(url, data);
			response.then(function(v) {
				var res = JSON.parse(v);
				imageVal = res.videoPath;
				$(".archVideoImg img").attr("src",res.videoPath);
				//$(".archVideoImg img").attr("src",v);
				$("#page-overlay").hide();
			}, function(e) {
				console.log(e);
			});
		});

		$(document).on("click",".videoControlls",function(){
			$(".archVideoImg img").attr('src','');
			var camId  = $("#archiveselect").val();
			var newDate = new Date($("#downloadDt").val());
			var month = newDate.getMonth()+1;

			if($(this).hasClass('previous'))
			{
				var day = newDate.getDate() - 1;
			}
			else
			{
				var day = newDate.getDate() + 1;
			}
			
			var year = newDate.getFullYear();
			var dateTime = month+'/'+day+'/'+year;
		    var selectedTime = "00:00:05";
			dateTime = dateTime+" "+selectedTime;
			
			$("#page-overlay").show();
			var url = "<?php echo base_url() ?>archive/getArchiveData";
			var data = {"cameraid":camId,"timestamp":dateTime};
			response = ajaxRequestArchiveData(url, data);
			loadInitialSelection();
			response.then(function(v) {
				var res = JSON.parse(v);
				imageVal = res.videoPath;
				$(".archVideoImg img").attr("src",res.videoPath);
				$("#page-overlay").hide();
			}, function(e) {
				console.log(e);
			});
		});
		$(document).on('click','.modal-calendar',function(){
			$('.startDate').focus();
		});
	</script>

	<script src="<?php echo base_url("assets/js/activitybar.js"); ?>" type="text/javascript"></script>

	<script src="<?php echo base_url("assets/js/jquery.serce.min.js"); ?>" type="text/javascript"></script>
	<script src="<?php echo base_url("assets/superfish/hoverIntent.js"); ?>"></script>