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
					<div class="col-md-8">
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

				<div class="table-block">

					<div class="container">
						<div class="row">
									<div class="table-responsive load-history">

									</div>

								</div>
					</div>
				</div>
             <!-- Workspace End -->
	</div>
	<!-- content -->
	<script>
		$(document).ready(function() {
			setTimeout(() => {
				$("#page-overlay").show();
			}, 100);
			getHistory();
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
						getHistory();
						$(".sitetitle").html(siteName);
					}, function(e) {
						//$('#contactRequestError').html(v.msg);
						console.log(v);
					});
				}

			});
			
		});
	</script>