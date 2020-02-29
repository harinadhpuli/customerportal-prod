<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page m-l-0">
    <!-- Start content -->
    <div class="content showpsaBlock">
        <!-- Top Action Col -->
        <div class="main-action-col">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="responseMsg" style="position: relative">
                            <div class="alertPsa alert alert-danger alert-dismissible fade in" id="customErrorMsgDiv" style="display:none">
                                <a href="#" id="successMsgClose" onclick="closeMessagesDivDynamic('Error','#customErrorMsgDiv')" class="close" aria-label="close">&times;</a>
                                <span id="customErrorMsg"></span>
                            </div>
                            <div class="alertPsa alert alert-success alert-dismissible fade in" id="customSuccessMsgDiv" style="display:none;">
                                <a href="#" id="errorMsgClose" onclick="closeMessagesDivDynamic('Success','#customSuccessMsgDiv')" class="close" aria-label="close">&times;</a>
                                <span id="customSuccessMsg"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 date-picker-block">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class='input-group date' id="fromdatepicker">
                                    <input type='text' class="form-control " id="fromdate" placeholder="From Date" readonly/>
                                    <span class="glyphicon glyphicon-calendar add-on"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class='input-group date' id="todatepicker">
                                    <input type='text' class="form-control" id="todate" placeholder="To Date" readonly/>
                                    <span class="glyphicon glyphicon-calendar add-on"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 buttonOrg form-group"><button class="btn" id="searchBtn"><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Search</button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-block">
            <div class="container">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Requested By</th>
                                    <th>Requested on</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Arm/Disarm</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="sitePSAList">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Workspace End -->
    </div>
    <!-- content -->
    <script>
        $(document).ready(function() {
            var pageno = 1;
            setTimeout(() => {
                $("#page-overlay").show();
            }, 50);
            getSitePSAList();
            $("#searchBtn").click(function(){
                var fromdate = $("#fromdate").val();
                var todate  = $("#todate").val();
                if(fromdate=="" || fromdate==undefined)
                {
                    msg = 'Please select From Date';
                    showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                }
                else if(todate=="" || todate==undefined)
                {
                    msg = 'Please select To Date';
                    showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                }
                else{
                    getSitePSAList();
                }
                
            });
            $('#fromdatepicker').datepicker({				
                autoclose: true,
                //todayBtn:true,
                todayBtn: "linked",
                todayHighlight:true,
                orientation: "bottom left"

                //endDate: '+0d',
            });
            $('#todatepicker').datepicker({				
                autoclose: true,
                todayBtn: "linked",
                todayHighlight:true,
                orientation: "bottom left"
                //endDate: '+0d',
               
            });
           
        });
       
        function getSitePSAList() {
            $("#page-overlay").show();
            var url = "<?php echo base_url() ?>psa/getSitePSAList";
            var fromdate = $("#fromdate").val();
            var todate  = $("#todate").val();
            var data = {
                "fromdate": fromdate,"todate":todate
            };
            response = ajaxRequestPromiseReturnHtml(url, data);
            response.then(function(v) {
                $("#page-overlay").hide();
                var res = JSON.parse(v);
                if(res.error==0)
                {
                    $("#customErrorMsgDiv").hide();
                    $("#customErrorMsg").html('');
                    $("#sitePSAList").html(res.msg);
                }
                else
                {
                    $("#customErrorMsgDiv").show();
                    $("#customErrorMsg").html(res.msg);
                    triggerAutoCloseMsg('Error');
                }
                
                //console.log(v);
            }, function(e) {
                //$('#contactRequestError').html(v.msg);
                console.log(v);
            });
        }

       $(document).on('click','.deletePSA',function()
       {
           var eventId = $(this).attr('data-eventId');
           var ele = $(this);
          
           $.confirm({
				title: 'Please Confirm ',
				content: 'Are You Sure You Want To Do This Action',
				buttons: {
					
					confirm: function (e) {
                        this.$$confirm.prop('disabled', true);
                        var url = "<?php echo base_url() ?>psa/deletePSA";
                        var data = {"eventId": eventId};
                        var response = ajaxRequestWithPromise(url,data);
						btnClass: 'btn-blue',
                        response.then(function(v) {
							
                            if (v.error == 0) {
                                $(ele).parents('tr').remove();
                                var len = $('#sitePSAList tr').length;
                                if(len==0)
                                {
                                    $('#sitePSAList').html('<tr><td colspan="6" align="center">No records are found.</td></tr>');
                                }
                            }
                        }, function(e) {
							btnClass: 'btn-blue',
                            //$('#contactRequestError').html(v.msg);
                            console.log(v);
                        });
					},
					cancel: function () {
						$("#page-overlay").hide();
						
					},
				}
			});
       });
       $(".sites-list").change(function() {
            var site = $(this).val();
            var siteName = $(".sites-list :selected").text();
            changeSite(site,siteName);
           
	    });
       $(document).on('click',".psaDescription",function(){
           var description = $(this).attr('data-description');
           $("#customModal").modal('show');
           $("#customModal .modal-title").html('Description');
           $("#customModal #dynamicResponse").html('<p>'+description+'</p>');
       });
    </script>