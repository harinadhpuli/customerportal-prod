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
                        <h2 class="title"><?php echo $title;?></h2>
                        <h4 class="sitetitle"><?php echo $selectedSite['siteName']; ?></h4>
                   </div>
                   <?php include('potentialList.php'); ?>
                </div>
            </div>
        </div>
        <!-- Top Action Col End -->
        <!-- Workspace -->
        <div class="tabsStats ticketstabs">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" id="tktsList" class="active"><a href="#tickets" aria-controls="current" role="tab" data-toggle="tab">Tickets</a></li>
                    <li role="presentation" id="newTkt"><a href="#newtickets" aria-controls="history" role="tab" data-toggle="tab">New Ticket </a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active site-data-block" id="tickets">
                <div class="container">
                    <div class="radioStyle">
                        <div class="radiogr">
                            <input type="radio" id="test1" class="ticketsopen" value="Open" name="ticketsopenclose" checked>
                            <label for="test1">Open</label>
                        </div>
                        <div class="radiogr">
                            <input type="radio" id="test2" class="ticketsclose" name="ticketsopenclose" value="Closed">
                            <label for="test2">Close</label>
                        </div>
                    </div>
                    <div class="clearfix m-b-20"></div>
                    <div id="ticketsopen-content">
                        <div class="ticketFillter">
                            <input type="text" name="filterinput" class="form-control" id="filterinput" placeholder="Search Ticket Number"></input>
                            <!--  <input type="button" name="clear" value="Clear" id="clearfilter"></input> -->
                            <input type="button" name="clear" value="Clear" id="clearfilter"></input>
                            <!--  <span id="count" class="badge badge-danger"></span> -->
                        </div>
                        <div class="openTickets ticketcreation-block"></div>
                    </div>
                    <div class="notificationBlock" id="ticketsclose-content" style="display:none;">
                        <div class="ticketFillter">
                            <input type="text" name="filterinput" class="form-control" id="tktfilter" placeholder="Search Ticket Number"></input>
                            <!--  <input type="button" name="clear" value="Clear" id="clearfilter"></input> -->
                            <input type="button" name="clear" value="Clear" id="cleartktfilter"></input>
                            <!--  <span id="count" class="badge badge-danger"></span> -->
                        </div>
                        <div class="closedTickets ticketcreation-block"></div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane site-data-block" id="newtickets">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
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
                    <div class="row createTicket-block">
                        <div>
                            <div class="col-md-6 col-md-offset-3 site-data-view">
                                <textarea class="form-control" rows="5" id="tktDescription" placeholder="Enter Description*"></textarea>
                                <div class="buttonOrg"><button class="newtickets-btn btn" id="createTicket">Submit</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Workspace End -->

    </div>
    <!-- content -->
    <script src="<?php echo base_url() ?>assets/js/jquery.listfilter.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.ticketsclose').click(function() {
                $("#ticketsclose-content").css("display", "block");
                $("#ticketsopen-content").css("display", "none");
            });
            $('.ticketsopen').click(function() {
                $("#ticketsopen-content").css("display", "block");
                $("#ticketsclose-content").css("display", "none");
            });
            setTimeout(() => {
                $("#page-overlay").show();
            }, 50);
            getUserTickets('Open');
            $("#newTkt").click(function(){
                $('#customErrorMsgDiv').find('span').text('');
                $('#customErrorMsgDiv').hide();
                $('#customSuccessMsgDiv').find('span').text('');
                $('#customSuccessMsg').html("");
            });

            $("#tktsList").click(function(){
                $("input[name='ticketsopenclose'][value='Open']").prop('checked', true);
                $("#ticketsopen-content").show();
                $("#ticketsclose-content").hide();
                getUserTickets('Open');
                
            });
        });
        $(".sites-list").change(function(){
            var site = $(this).val();
            var siteName = $(".sites-list :selected").text();
            var siteurl = "<?php echo base_url()?>";
            //var status = $("input['type=radio']['name=ticketsopenclose']");
            var status = $("input[name='ticketsopenclose']:checked").val();
            if(site!=undefined)
            {
                var url="<?php echo base_url()?>usersites/selectSite";
                var data = { 'site': site};
                response=ajaxRequestPromiseReturnHtml(url,data);
                response.then(function(v) {
                    getUserTickets(status);
                    $(".sitetitle").html(siteName);
                }, function(e) {
                    //$('#contactRequestError').html(v.msg);
                    console.log(v);
                });
            }
        });
        $("input[type=radio][name='ticketsopenclose']").click(function() {
            var statusVal = $(this).val();
            $("#filterinput").val('');
            $("#tktfilter").val('');
            getUserTickets(statusVal);
        });

        function getUserTickets(status) {
            var siteurl = "<?php echo base_url() ?>";
            if (siteurl != undefined) {
                $("#page-overlay").show();
                var url = "<?php echo base_url() ?>tickets/getTickets";
                var data = {
                    'status': status
                };
                response = ajaxRequestPromiseReturnHtml(url, data);
                response.then(function(v) {
                    $("#page-overlay").hide();
                    var renderCls = '';
                    if (status == 'Open') {
                        renderCls = "openTickets";
                        var filter = $('input#filterinput'),
                            clearfilter = $('input#clearfilter');
                    } else {
                        renderCls = "closedTickets";
                        var filter = $('input#tktfilter'),
                            clearfilter = $('input#cleartktfilter');
                    }
                    $("." + renderCls).html(v);

                    //var filter = $('input#filterinput'), clearfilter = $('input#clearfilter');
                    $('.' + renderCls).listfilter({
                        'filter': filter,
                        'clearlink': clearfilter,
                        'alternate': true,
                        'alternateclass': 'cardticket',
                        'count': $('#count')
                    });

                }, function(e) {
                    //$('#contactRequestError').html(v.msg);
                    console.log(v);
                });
            }
        }

        $("#createTicket").click(function() {
            var description = $("#tktDescription").val();
            if (description == '' || description == undefined) {
                msg = 'Please Enter Ticket Description';
                showValidationMsgDynamic(msg, '#customErrorMsgDiv');
                //triggerAutoCloseMsg('Error');
            } else {
                $('#customErrorMsgDiv').find('span').text('');
                $('#customErrorMsgDiv').hide();
                $("#page-overlay").show();
                var url = "<?php echo base_url() ?>tickets/createTicket";
                var data = {
                    'description': description
                };
                response = ajaxRequestWithPromise(url, data);
                response.then(function(v) {
                    if (v.error == '0') {
                        $("#tktDescription").val('');
                        //triggerAutoCloseMsg('Success');
                    }
                }, function(e) {
                    //$('#contactRequestError').html(v.msg);
                    console.log(v);
                });
            }
        });
    </script>