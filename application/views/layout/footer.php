<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		
	<footer class="footer text-center"> Copyright © <?php echo date('Y');?>, Pro-Vigil, Inc. All rights reserved.</footer>

		</div>
	</div>
	<!-- END wrapper -->

	<!-- jQuery  -->
	
	
	<!-- <script src="assets/js/modules.js"></script> -->
	
	<script src="<?php echo base_url() ?>assets/superfish/hoverIntent.js"></script>
	<script src="<?php echo base_url() ?>assets/superfish/superfish.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-confirm.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-multiselect.js"></script>
	
	<script src="<?php echo base_url() ?>assets/js/main.js"></script>
	
	<script>
		$(document).ready(function () {
			// $('.nav-menu').hide();
			$('#usersites').multiselect({
				enableCaseInsensitiveFiltering: true,
				maxHeight: 200
			});
			
		});
		
	</script>
	


<div id="page-overlay">
	<div id="ajax-loader"><img id="gif"  src="<?php echo base_url() ?>assets/images/ajax-loader.gif"></div>
	<div id="page-overlay1"></div>
</div>

<input type="hidden" id="csrfTokenName" value="<?php echo $this->security->get_csrf_token_name(); ?>">
<input type="hidden" id="csrfTokenValue" value="<?php echo $this->security->get_csrf_hash(); ?>">


<script>
	$(document).ready(function(){
		$('#page-overlay').hide();
		$('[data-toggle="tooltip"]').tooltip();
	});
	
</script>
<script>
	$(document).ready(function () {
		// $('.nav-menu').hide();
		$('.userSites').multiselect();
	});
</script>

<!-- custom ajax functions -->
<script>

function displayResponseMessage(response,response_type){
	$("#page-overlay").hide();
		data = JSON.parse(response);
		var message='';
		if(response_type=='array'){
			$.each(data, function() {
				
				if(this.error=='1'){
					message+='<div class="alert alert-danger alert-dismissible fade in"  >';
					message+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
					message+='<li style="alert-danger">'+this.msg+'</li>'; 
					message+='</div>';
				}else{
					message+='<div class="alert alert-success alert-dismissible fade in"  >';
					message+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
					message+='<li style="alert-danger">'+this.msg+'</li>'; 
					message+='</div>';
				}
			});
			$('#bulkErrorSuccessMessagesDiv').show();
			$('#bulkErrorSuccessMessagesDiv').html(message);
		
		}else{
			if(data.error=='0'){
				msg='<li style="alert-success">'+data.msg+'</li>'; 
				$('#customErrorMsgDiv').hide();
				$('#customErrorMsg').html('');
				$('#customSuccessMsgDiv').show();
				$('#customSuccessMsg').html(msg);
				triggerAutoCloseMsg('Success');
			}else{
				msg=data.msg; 
				$('#customErrorMsgDiv').show();
				$('#customErrorMsg').html(msg);
				$('#customSuccessMsgDiv').hide();
				$('#customSuccessMsg').html('');
				triggerAutoCloseMsg('Error');
			}
		}
	}


	function ajaxRequestWithPromise(url,parameterData,postKey) {
	$("#page-overlay").show();
	return new Promise(function(resolve, reject) {
	$.ajax({
		url: url,
		type: 'POST',
		data:{
			'postKey':postKey,
			data:JSON.stringify(parameterData),
		},
      success: function(data) {
			displayResponseMessage(data);
			data=JSON.parse(data);
			//console.log(data)
		resolve(data) // Resolve promise and go to then()
      },
      error: function(err) {
        reject(err) // Reject the promise and go to catch()
      }
    });
  });
}

function ajaxRequestPromiseReturnHtml(url,parameterData,postKey) {
	$("#page-overlay").show();
	return new Promise(function(resolve, reject) {
	$.ajax({
		url: url,
		type: 'POST',
		data:{
			'postKey':postKey,
			data:JSON.stringify(parameterData),
		},
      success: function(data) {
			resolve(data) // Resolve promise and go to then()
      },
      error: function(err) {
        reject(err) // Reject the promise and go to catch()
      }
    });
  });
}

function ajaxRequestArchiveData(url,parameterData,postKey) {
	//$("#page-overlay").show();
	return new Promise(function(resolve, reject) {
	$.ajax({
		url: url,
		type: 'POST',
		data:{
			'postKey':postKey,
			data:JSON.stringify(parameterData),
		},
      success: function(data) {
			displayResponseMessage(data);
			resolve(data) // Resolve promise and go to then()
      },
      error: function(err) {
        reject(err) // Reject the promise and go to catch()
      }
    });
  });
}

function showValidationMsg($msg){
		
		$('#customErrorMsgDiv').find('span').text($msg);
		$('#customErrorMsgDiv').show();
		scrollToMessagesDiv();
}

function showValidationMsgDynamic($msg,selector){
		$(selector).find('span').text($msg);
		$(selector).show();
		scrollToMessagesDivDynamic(selector);
		triggerAutoCloseMsg('Error');
}

function scrollToMessagesDivDynamic(selector){
		$('html, body').animate({
			scrollTop: $(selector).offset()
		}, 200);
	}

function scrollToMessagesDiv(){
		$('html, body').animate({
			scrollTop: $("#genericMessagesDiv").offset()
		}, 200);
	}
	function closeMessagesDivDynamic(msg,selector){
		if(msg=='Success'){
			$(selector).find('span').html('');
			$(selector).hide();
		}else if(msg=='Error'){
			$(selector).find('span').html('');
			$(selector).hide();
		}
	}

	function getSiteStatus(){
		var url="<?php echo base_url()?>armdisarm/getSiteStatus";
		var data = {};
		response=ajaxRequestPromiseReturnHtml(url,data);
		response.then(function(v) {
			//$("#page-overlay").hide();
			$(".res-headerSwitch").html(v)
		}, function(e) {
			console.log(v);
		});
	}
	var path = window.location.href;
    path = path.replace(/\/$/, "");	
	var result= path.split('/');
	var Param1 = result[result.length-1];
	if(Param1 !='usersites'){
		getSiteStatus();
	}
	function armDisarm(notes){
		var url="<?php echo base_url()?>Armdisarm/checkingPreConditions";
		var data = {};
		response=ajaxRequestPromiseReturnHtml(url,data);
		response.then(function(v) {
			let data = JSON.parse(v);
			if(data.status == 'Success'){
				armDisarmMain(notes);
				$('.infoButton').hide();
			}else{
				$('.infoButton').show();
				$('.infoModal').modal('show');
				$('.infoModal .modal-title').text(data.title);
				$('.infoModal .modal-body h4').text(data.message);
				$("#page-overlay").hide();
			}
			
		}, function(e) {
			console.log(v);
		});
	}
	function armDisarmMain(notes){
		var url="<?php echo base_url()?>Armdisarm/armDisarmSite";
		var data = {msg:notes};
		let page = "<?php if(isset($page)){ echo $page; }else{ ""; }?>";
		response=ajaxRequestPromiseReturnHtml(url,data);
		response.then(function(v) {
			$('.infoButton').hide();
			let data = JSON.parse(v);
			if(data.status == 'Success'){
				let history = JSON.parse(data.history);
				let siteStatus = data.siteStatus;
				$('.switchBlock input').attr('data-status',siteStatus);
				if(siteStatus == 0 || siteStatus == 4){
					$('.switchBlock input').prop('checked',true);
				}else{
					$('.switchBlock input').prop('checked',false);
				}
				$('.infoModal').modal('show');
				$('.infoModal .modal-title').text(data.title);
				$('.infoModal .modal-body h4').text(data.message);
				$('.lastDisarmed p').html(history.title);
				$('.lastDisarmed h3').html(history.name);
				if(page !=''){
					getHistory();
				}
			}else{
				$('.infoModal').modal('show');
				$('.infoModal .modal-title').text(data.title);
				$('.infoModal .modal-body h4').text(data.message);
			}
			$("#page-overlay").hide();
		}, function(e) {
			console.log(v);
		});
	}
	function getHistory(){
		var siteurl = "<?php echo base_url() ?>";
		if (siteurl != undefined) {
			$("#page-overlay").show();
			var url = "<?php echo base_url() ?>armdisarm/loadHistory/";
			var data = {};
			response = ajaxRequestPromiseReturnHtml(url, data);
			response.then(function(v) {
				$("#page-overlay").hide();
				$(".load-history").html(v);
			}, function(e) {
				console.log(e);
			});
		}	
	}
$(function () {

	let notes = "";
	 $('.datepicker').datepicker({
		autoclose: true,
		orientation: "auto right",
	});
	$(".sites-list").change(function(){
		getSiteStatus();
	});
	$(document).on('click','.infoButton',function(e){ //sending the arm/disarm after popup
		if(notes !==''){
			armDisarmMain(notes);
		}
	});
	$(document).on('click','.switchBlock input',function(e){
	 	$('.notesModal').modal('show');
	 	$('.error').hide();
	 	let current_status = $(this).attr('data-status');
	 	if(current_status == 0 || current_status == 4){
	 		$('.notesModal .armAlertBt').text('Disarm');
	 	}else{
	 		$('.notesModal .armAlertBt').text('Arm');
	 	}
	 });
	$(document).on('click','.armAlertBt',function(){
		notes = $('.notes').val();
		if(notes.trim() !==''){
			armDisarm(notes.trim());
			$('.notesModal').modal('hide');
			$('.notes').val('');
		}else{
			$('.error').show();
		}
	});
	$(document).on('keyup','.notes',function(e){
		let notes = $(this).val();
		if(notes.length > 0){
			$('.armAlertBt').attr('disabled',false);
			$('.error').hide();
		}else{
			$('.error').show();
			$('.armAlertBt').attr('disabled',true);
		}
	});
	$(document).on('click','.notesModal .close',function(){
		$('.notesModal').modal('hide');
		$('.notes').val('');
		let current_status = $('.switchBlock input').attr('data-status');
		if(current_status == 0 || current_status == 4){
			$('.switchBlock input').prop('checked',true);
			$('.error').hide();
		}else{
			$('.switchBlock input').prop('checked',false);
			$('.error').show();
		}
	});
	$(document).on('click','.infoModal .close',function(){
		$('.infoModal').modal('hide');
		let current_status = $('.switchBlock input').attr('data-status');
		if(current_status == 0 || current_status == 4){
			$('.switchBlock input').prop('checked',true);
		}else{
			$('.switchBlock input').prop('checked',false);
		}
	});
});

function triggerAutoCloseMsg(msg)
	{
		if(msg=='Success')
		{
			$("#customSuccessMsgDiv").fadeTo(5000, 2000).slideUp(1000, function(){
				$("#customSuccessMsgDiv").slideUp(3000);
				$('#customSuccessMsgDiv').find('span').html('');
				$('#customSuccessMsgDiv').hide();
			});
		}else if(msg=='Error'){
			$("#customErrorMsgDiv").fadeTo(5000, 1000).slideUp(1000, function(){
				$("#customErrorMsgDiv").slideUp(3000);
				$('#customErrorMsgDiv').find('span').html('');
				$('#customErrorMsgDiv').hide();
			});
		}
	}

 function changeSite(site,siteName)
 {
	var siteurl = "<?php echo base_url() ?>";
	if (site != undefined) {
		var url = "<?php echo base_url() ?>usersites/selectSite";
		var data = {
			'site': site
		};
		response = ajaxRequestPromiseReturnHtml(url, data);
		response.then(function(v) {
			$("#page-overlay").hide();
			$(".sitetitle").html(siteName);
		}, function(e) {
			console.log(v);
		});
	}
 }
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
$('body').tooltip({
    selector: '[data-toggle=tooltip]'
});
</script>
<!--Arm/Disarm Modal-->
<div class="modal modalBlock notesModal" id="armdisarm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Notes</h4>
		</div>

		<div class="modal-body">
			<textarea class="form-control notes" placeholder="Please Enter Notes" rows="3"></textarea>	
			<p class="error">Please Enter Notes.</p>	
		</div>
		<button class="armAlertBt">OK</button>  
		</div>
	</div>
</div>
<!-- Modal End-->
<!--Response Info Modal--->
<div class="modal modalBlock infoModal" id="customModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel">
  	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="dynamicTitle"></h4>
			</div>
			<div class="modal-body">
				<h4></h4>
				<div id="dynamicResponse"></div>
			</div>
			<button class="infoButton" style="display:none;">OK</button>  
		</div>
	</div>
</div>
</body>
</html>


