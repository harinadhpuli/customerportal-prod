<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page m-l-0 eventLogminH">
    <!-- Start content -->
    <div class="content">
        <!-- Top Action Col -->
        <div class="main-action-col">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="title"><?php echo $title; ?></h2> <h4 class="sitetitle"><?php echo $selectedSite['siteName'];?></h4>
                    </div>
                    <?php include('potentialList.php');?>
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
                    <div class="table-responsive" id="eventLogBlock" style="display: none;">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Camera Name</th>
                                    <th>Event Time</th>
                                    <th>Notes</th>
                                    <th>Tags</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="siteEventLogList">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="isAllItemsLoaded" value="true">
        <!-- Workspace End -->
    </div>
    <!-- content -->
    <script>
        $(document).ready(function(){
            $("#eventLogBlock").hide();
            var pageno=1;
           
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
                    $("#siteEventLogList").html("");
                    getSiteEventLogs(pageno);
                }
            });

            $('#fromdatepicker').datepicker({				
                autoclose: true,
                //todayBtn:true,
                todayBtn: "linked",
                todayHighlight:true,
                orientation: "bottom left",

                endDate: '+0d',
            });
            $('#todatepicker').datepicker({				
                autoclose: true,
                todayBtn: "linked",
                todayHighlight:true,
                orientation: "bottom left",
                endDate: '+0d',
               
            });

            $(".sites-list").change(function(){
                var site = $(this).val();
                var siteName = $(".sites-list :selected").text();
                var siteurl = "<?php echo base_url()?>";
                if(site!=undefined)
                {
                    $("#fromdate").val('');
                    $("#todate").val('');
                    var url="<?php echo base_url()?>usersites/selectSite";
                    var data = { 'site': site};
                    response=ajaxRequestWithPromise(url,data);
                    response.then(function(v) {
                    $("#siteEventLogList").html("");
                    
                    $(".sitetitle").html(siteName);
                    }, function(e) {
                        //$('#contactRequestError').html(v.msg);
                        console.log(v);
                    });
                }
            });
        });

        function getSiteEventLogs(pageno)
        {
            $("#eventLogBlock").show();
            $("#page-overlay").show();
            var url="<?php echo base_url()?>eventlog/getSiteEventLogs";
            var fromdate = $("#fromdate").val();
            var todate  = $("#todate").val();
          
            var data = {"pageno":pageno,"fromdate":fromdate,"todate":todate};
            response=ajaxRequestPromiseReturnHtml(url,data);
            response.then(function(v) {
            $("#page-overlay").hide();
            var res = JSON.parse(v);
                if(res.error==0)
                {
                    $("#customErrorMsgDiv").hide();
                    $("#customErrorMsg").html('');
                    //$("#sitePSAList").html(res.msg);
                    var currentLen = $("#siteEventLogList tr").length*1;
                    $("#siteEventLogList").append(res.msg);
                }
                else
                {
                    $("#customErrorMsgDiv").show();
                    $("#customErrorMsg").html(res.msg);
                    triggerAutoCloseMsg('Error');
                }
                var isAllItemsLoaded = 'true';
                if(res.isAllItemsLoaded=='false' || res.isAllItemsLoaded=='')
                {
                    isAllItemsLoaded = 'false';
                }
                $("#isAllItemsLoaded").val(isAllItemsLoaded);
            }, function(e) {
                //$('#contactRequestError').html(v.msg);
                console.log(v);
            });
        }

        function getEventDetails(groupId)
        {
            window.open();
        }

        $(window).on("scroll", function() {
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        console.log((scrollHeight - scrollPosition) / scrollHeight);
        if ((scrollHeight - scrollPosition) / scrollHeight === 0)
        {
            
            var currentLen = $("#siteEventLogList tr").length*1;
            //console.log(currentLen);
            var isAllItemsLoaded = $("#isAllItemsLoaded").val();
            console.log(isAllItemsLoaded);
            if(isAllItemsLoaded!='true' && currentLen>9)
            {
                var pageno = (currentLen*1/10)+1*1;
                if(pageno<=5)
                {
                    getSiteEventLogs(pageno);
                }
            }
        }
});

    </script>