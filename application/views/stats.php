<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
						<h2 class="title"><?php echo $title; ?></h2>
						<h4 class="sitetitle"><?php echo $selectedSite['siteName'];?></h4>
					</div>
					<?php include('potentialList.php');?>
				</div>
			</div>
		</div>
		<!-- Top Action Col End -->
		<!-- Workspace -->
		<div class="tabsStats">
			<div class="container">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#current" aria-controls="current" role="tab" data-toggle="tab">Current</a></li>
					<li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab">History</a></li>
					<li role="presentation"><a href="#clips" aria-controls="clips" role="tab" data-toggle="tab">Clips</a></li>
				</ul>
			</div>
		</div>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active site-data-block statsCurrentTab" id="current"></div>
			<div role="tabpanel" class="tab-pane site-data-block statsHistoryTab" id="history"></div>
			<div role="tabpanel" class="tab-pane site-data-block" id="clips"></div>
		</div>
		<!-- Workspace End -->
	</div>
	<!-- content -->
	<div class="video-popup-model">
		<!-- Modal -->
		<div class="modal modalBlock" id="clipModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<!--<h4 class="modal-title"> <i class="fa fa-circle" aria-hidden="true"></i><span class="clipTitle"></span></h4>-->
						<h4 class="modal-title"><span class="clipTitle"></span></h4>
					</div>
					<div class="modal-body">
						<video id="myVideo0" autoplay="" class="displaynone video-frame" controls="" controlsList="nodownload">
							<source src="assets/images/slide/v6/v.mp4" type="video/mp4">Your browser does not support HTML5 video.
						</video>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			setTimeout(() => {
				$("#page-overlay").show();
			}, 50);
			getStats('current');
			$('.nav-tabs li').on('click', function() {
				let href = $(this).find('a').attr('href');
				getStats(href.substr(1, href.length - 1));
			});
			$(document).on('click', '.clip', function() {
				let url = $(this).attr('data-url');
				let clipTitle = $(this).find('.clipsCard-text h4').text();
				//$("#clipModal .modal-title .clipTitle").text(clipTitle);
				$('#myVideo0').attr('src', url);
				$('#clipModal').modal('show');
			});
			$(document).on('click', '.close', function() {
				$('#myVideo0').attr('src', '');
				$('#clipModal').modal('hide');
			});
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
						let href = $('.nav-tabs li.active').find('a').attr('href');
						getStats(href.substr(1, href.length - 1));
						$(".sitetitle").html(siteName);
					}, function(e) {
						//$('#contactRequestError').html(v.msg);
						console.log(v);
					});
				}       
            });
		});

		function getStats(status) {
			var siteurl = "<?php echo base_url() ?>";
			if (siteurl != undefined) {
				$("#page-overlay").show();
				var url = "<?php echo base_url() ?>stats/getStats";
				var data = {
					'status': status
				};
				response = ajaxRequestPromiseReturnHtml(url, data);
				response.then(function(v) {
					$("#page-overlay").hide();
					if (status == 'current') {
						$renderId = "current";
					} else if (status == 'history') {
						$renderId = "history";
					} else {
						$renderId = "clips";
					}
					$("#" + $renderId).html(v);
				}, function(e) {
					//$('#contactRequestError').html(v.msg);
					console.log(v);
				});
			}
		}
	</script>