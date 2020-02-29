<?php
defined('BASEPATH') or exit('No direct script access allowed');

$myDateTime = getDateParametersByTimeZone($selectedSite['timezone']);

$todayDate = date('m-d-Y',strtotime($myDateTime['currentTime']));

$fromTime =  date('H:i A',strtotime("+2 hours"));


$endTime =  date('H:i A',strtotime("+2 hours"));
//echo $fromTime;die;

// echo "<pre>";
// print_r($myDateTime);

// echo "<br>";



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
                    <div class="col-md-6">
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
        <div class="site-data-date-block">
            <div class="container createPsa">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="responseMsg">
                            <div class="alert alert-danger alert-dismissible fade in" id="customErrorMsgDiv" style="display:none">
                                <a href="#" id="successMsgClose" onclick="closeMessagesDivDynamic('Error','#customErrorMsgDiv')" class="close" aria-label="close">&times;</a>
                                <span id="customErrorMsg"></span>
                            </div>
                            <div class="alert alert-success alert-dismissible fade in" id="customSuccessMsgDiv" style="display:none">
                                <a href="#" id="errorMsgClose" onclick="closeMessagesDivDynamic('Success','#customSuccessMsgDiv')" class="close" aria-label="close">&times;</a>
                                <span id="customSuccessMsg"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 date-picker-block col-md-offset-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" placeholder="Enter Description*"></textarea>
                            </div>
                        </div>
                        <div class="clearfix">
                            <h4>Add Start Date & Time (<?php echo $selectedSite['timezone'];?>)</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <div class='input-group'>
                                    <input type='text' class="form-control datepicker" placeholder="From Date"  id="fromDate" readonly value="<?php echo $todayDate;?>" />
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class='input-group'>
                                    <!-- <input type='text' class="form-control datepicker" placeholder="To Date"/> -->
                                    <input type="text" value="" class="form-control datepicker" placeholder="From Time" id="fromTime" readonly value="12:30 AM">
                                    <span class="glyphicon glyphicon-time"></span>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 date-picker-block col-md-offset-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" placeholder="Enter Description*"></textarea>
                            </div>
                        </div>
                        <div class="clearfix">
                            <h4>Add Start Date & Time (<?php echo $selectedSite['timezone'];?>)</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <div class='input-group'>
                                    <input type='text' class="form-control datepicker" placeholder="From Date"  id="fromDate" readonly value="<?php echo $todayDate;?>" />
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class='input-group'>
                                    <!-- <input type='text' class="form-control datepicker" placeholder="To Date"/> -->
                                    <input type="text" value="" class="form-control timepicker" placeholder="From Time" id="fromTime" readonly value="12:30 AM">
                                    <span class="glyphicon glyphicon-time"></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix">
                            <h4>Add End Date & Time (<?php echo $selectedSite['timezone'];?>)</h4>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                                <div class='input-group'>
                                    <input type='text' class="form-control datepicker" placeholder="To Date" id="endDate" readonly value="<?php echo $todayDate;?>"/>
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class='input-group'>
                                    <!-- <input type='text' class="form-control datepicker" placeholder="To Date"/> -->
                                    <input type="text" value="" class="form-control timepicker" placeholder="To Time" id="endTime" readonly>
                                    <span class="glyphicon glyphicon-time"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 addSchedule"><button class="btn">Create PSA</button></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Workspace End -->
    </div>
    <!-- content -->

    <!-- Modal Start-->
    <div class="modal modalBlock fade" id="createpsa-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Info</h4>
                </div>
                <div class="modal-body alertinfo">
                    <h4>You can create a PSA (Planned Site Activity) 2 hours from the current time.</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->


    <script type="text/javascript">
        $(document).ready(function () {
			
			//DatePicker Example
			$('#datetimepicker').datetimepicker();
			
			//TimePicke Example
			$('#datetimepicker1').datetimepicker({
				datepicker:false,
				format:'H:i'
			});
			
			//Inline DateTimePicker Example
			$('#datetimepicker2').datetimepicker({
				format:'Y-m-d H:i',
				inline:true
			});
			
			//minDate and maxDate Example
			$('#datetimepicker3').datetimepicker({
				 format:'Y-m-d',
				 timepicker:false,
				 minDate:'-1970/01/02', //yesterday is minimum date
				 maxDate:'+1970/01/02' //tomorrow is maximum date
			});
			
		});
    </script>
    <script>
        $(window).on('load',function(){
           $('#createpsa-info').modal('show');
           
        //    console.log('<?php echo $endTime;?>');
        //      $('input.timepicker').timepicker(
        //      'setTime', '<?php echo $endTime;?>','option',{'startTime': '<?php echo $endTime;?>'} ,
                 
        // );
        // $('#endTime').timepicker({
        //        'setTime': '<?php echo $endTime;?>',
        //        'minTime': '<?php echo $endTime;?>'
        
        // });
    });  
    $(function () {
     $('#datetimepicker').datetimepicker({  
         minDate:new Date()
      });
 });
        $(document).on('click', '.deletePSA', function() {
            var eventId = $(this).attr('data-eventId');
            var ele = $(this);
            $.confirm({
                title: 'Please Confirm ',
                content: 'Are You Sure You Want To Do This Action',
                buttons: {
                    confirm: function(e) {
                        this.$$confirm.prop('disabled', true);
                        var url = "<?php echo base_url() ?>psa/deletePSA";
                        var data = {
                            "eventId": eventId
                        };
                        var response = ajaxRequestWithPromise(url, data);

                        response.then(function(v) {

                            if (v.error == 0) {
                                $(ele).parents('tr').remove();
                                var len = $('#sitePSAList tr').length;
                                if (len == 0) {
                                    $('#sitePSAList').html('<tr><td colspan="5" align="center">No records are found.</td></tr>');
                                }
                            }
                        }, function(e) {
                            //$('#contactRequestError').html(v.msg);
                            console.log(v);
                        });
                    },
                    cancel: function() {
                        $("#page-overlay").hide();

                    },
                }
            });
        });
    </script>