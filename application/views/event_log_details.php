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
        <div class="site-data-date-block eventlogdetails">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 date-picker-block">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Camera Name</label>
                                <h4><?php echo $_SESSION[$groupId]['cameraname']?></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Event Time</label>
                                <h4><?php echo $_SESSION[$groupId]['starttime']?></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Notes</label>
                                <h4><?php echo $_SESSION[$groupId]['notes']?></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Tags</label>
                                <h4><?php echo $_SESSION[$groupId]['tagname']?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="camera-view-Three camera-view-block">
            <div class="container">
                <div class="row" id="eventLogDetails">
                    <!-- <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="v-box box">
                            <div class="video-header">
                                <h3><i class="fa fa-circle" aria-hidden="true"></i> Houston-branch Outside Cam1</h3>
                               
                           </div>
                            <div class="video-img">
                                <div class="date-time-row"><span>2019-07-31 &nbsp; 07:02:13 AM</span></div>
                                <span data-toggle="modal" data-target="#eventlogdetails"><img src="<?php //echo base_url()?>assets/images/slide/v5/1.jpg" data-images="assets/images/slide/v5/1.jpg, assets/images/slide/v5/2.jpg, assets/images/slide/v5/3.jpg, assets/images/slide/v5/4.jpg, assets/images/slide/v5/5.jpg"></span></span>
                            </div>
                        </div>
                    </div> -->
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
            getSiteEventLogDetail(pageno);


        });

        function getSiteEventLogDetail(pageno) {
            $("#page-overlay").show();
            var url = "<?php echo base_url() ?>eventlog/getSiteEventLogDetails";
            var data = {
                "pageno": pageno,"groupId":"<?php echo $groupId;?>"
            };
            response = ajaxRequestPromiseReturnHtml(url, data);
            response.then(function(v) {
                $("#page-overlay").hide();
                var currentLen = $("#eventLogDetails .v-box").length * 1;
                if(v=="" && currentLen==0){
                    $("#eventLogDetails").append('<h5 class="grayText">No records are found.</h5>');
                }
                $("#eventLogDetails").append(v)
            }, function(e) {
                //$('#contactRequestError').html(v.msg);
                console.log(v);
            });
        }

        $(window).on("scroll", function() {
            var scrollHeight = $(document).height();
            var scrollPosition = $(window).height() + $(window).scrollTop();
            if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
                //console.log('rpweb');
                var currentLen = $("#eventLogDetails .v-box").length * 1;
                if (currentLen > 9) {
                    var pageno = (currentLen * 1 / 10) + 1 * 1;
                    if (pageno <= 5) {
                        getSiteEventLogDetail(pageno);
                    }
                }
            }
        });


        $(document).on("click",".eventLogVideos",function(){
            var videoURL = $(this).attr('data-video-url');
            //console.log("videoURL");
            if(videoURL!="" && videoURL!=undefined)
            {
                //console.log(videoURL); 
                $("#customModal").modal('show');
                var str='<video id="video" autoplay controls>';
                str+='<source src="'+videoURL+'" type="video/mp4">Your browser does not support HTML5 video.';
                str+='</video>';
                var eventName = $(this).attr('data-camname');
                
            }
            else
            {
                var eventName ="Event Details";
                var str= "No data found.";
            }
            $("#customModal #dynamicTitle").html(eventName);
            $("#customModal #dynamicResponse").html(str);
        });
        
    </script>