<?php
defined('BASEPATH') or exit('No direct script access allowed');
    $myDateTime = getDateParametersByTimeZone($selectedSite['timezone']);
    $todayDate = date('m/d/Y H:i',strtotime('+2 hours',strtotime($myDateTime['currentTime'])));
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
                                <textarea class="form-control" rows="5" placeholder="Enter Description*" id="description"></textarea>
                                <span id="remain" class="text-muted">230</span> Character(s) Remaining
                            </div>
                        </div>
                        <div class="clearfix">
                            <h4>Add Start & End Date (<?php echo $selectedSite['timezone'];?>)</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                               <div class='input-group'>
                                    <input type='text' class="form-control" placeholder="From Date"  id="startDate" value="<?php echo $todayDate;?>" />
                                    <span class="glyphicon glyphicon-calendar calendarOpen" id="startOpen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                                <div class='input-group'>
                                    <input type='text' class="form-control" placeholder="To Date" id="endDate" value="<?php echo $todayDate;?>"/>
                                    <span class="glyphicon glyphicon-calendar calendarOpen" id="endOpen"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 addSchedule"><button class="btn" id="createPSA">Create PSA</button></div>
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
                    <div class="text-center"><button class="infoButton"  data-dismiss="modal" aria-label="Close">OK</button></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->

    <script type="text/javascript">
        $(document).ready(function () {
			//Inline DateTimePicker Example
            var startDate = $('#startDate').datetimepicker({
                format: 'm/d/Y H:i',
                minDate: '<?php echo $todayDate;?>',
                step: 30,
                autoclose: true,
                onChangeDateTime:function(dp,$input){
                    $('#endDate').val($input.val());
                }
            })
			$('#endDate').datetimepicker({
                format: 'm/d/Y H:i',
                step: 30,
                onShow:function( ct ){
                
                    var newDate = new Date(jQuery('#startDate').val())
                    let month = newDate.getMonth()+1;
                    let day = newDate.getDate();
                    let year = newDate.getFullYear();
                    let minimumDate =year+'/'+month+'/'+day; 
                    newDate.setDate(newDate.getDate() + 13);
                    month = newDate.getMonth()+1;
                    day = newDate.getDate();
                    year = newDate.getFullYear();
                    maximumDate =year+'/'+month+'/'+day; 
                    this.setOptions({
                        minDate:minimumDate,
                        maxDate:maximumDate,
                    })
                }
            });

            $('#startOpen').click(function(){
	            $('#startDate').datetimepicker('show');
            });
            $('#endOpen').click(function(){
	            $('#endDate').datetimepicker('show');
            });
            $("#createPSA").click(function(){
                var description = $("#description").val();
                var startDate = $("#startDate").val();
                var endDate = $("#endDate").val();
                description = description.trim();
                if (description == '' || description == undefined) {
                    msg = 'Please enter description';
                    showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                }
                else if (description!= '' && description.length > 231) {
                    msg = 'Description length should not be exceed 230 characters';
                    showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                }
                else if (startDate == '' || startDate == undefined) {
                    msg = 'Please Select Start Date & Time';
                    showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                }
                else if (endDate == '' || endDate == undefined) {
                    msg = 'Please Select End Date & Time';
                    showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                }
                else {
                    $('#customErrorMsgDiv').find('span').text('');
                    $('#customErrorMsgDiv').hide();
                    $("#page-overlay").show();
                    var url = "<?php echo base_url() ?>psa/savePSA";
                    var data = {
                        'description': description,'startDate':startDate,'endDate':endDate
                    };
                    response = ajaxRequestWithPromise(url, data);
                    response.then(function(v) {
                        if (v.error == '0') {
                            $("#description").val('');
                            $("#startDate").val(v.siteCurrentTime);
                            $("#endDate").val(v.siteCurrentTime);
                            $("#remain.text-muted").text('230');
                        }
                    }, function(e) {
                        //$('#contactRequestError').html(v.msg);
                        console.log(v);
                    });
                }
            });
            /** Validating description length */
            var maxchars = 230;
            $('#description').keyup(function () {
                var tlength = $(this).val().length;
                $(this).val($(this).val().substring(0, maxchars));
                var tlength = $(this).val().length;
                remain = maxchars - parseInt(tlength);
                $('#remain').text(remain);
            });
            /** End */

            $(".sites-list").change(function()
            {
                var site = $(this).val();
                var siteName = $(".sites-list :selected").text();
                changeSite(site,siteName);
            });

		});
    </script>
   
    <script>
        $(window).on('load',function(){
            $('#createpsa-info').modal('show');
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