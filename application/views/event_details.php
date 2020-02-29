<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page m-l-0">
    <!-- Start content -->
    <div class="content">
       <?php 
            // echo "<pre>";
            // print_r($eventdetails);
            // die;
       ?>
        <!-- Top Action Col -->
        <div class="main-action-col">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title"><?php echo $title; ?></h2>
                        <h4 class="sitetitle"><?php echo $selectedSite['siteName']; ?></h4>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Top Action Col End -->
        <!-- Workspace -->
        <div class="m-t-20"></div>
        
        <?php if(!empty($eventdetails)) {?>
        <div class="site-data-date-block eventlogdetails">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 date-picker-block">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Camera Name</label>
                                <h4><?php echo $eventdetails['cameraName'];?></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Event Time</label>
                                <h4><?php echo convertEventLogDateFormat($eventdetails['eventTimeStr']);?></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Notes</label>
                                <h4><?php echo $eventdetails['actionNotes'];?></h4>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Tags</label>
                                <h4><?php echo $eventdetails['finalActionType'];?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="camera-view-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="v-box box">
                            <div class="video-header">
                                <h3><i class="fa fa-circle" aria-hidden="true"></i><span class="eventName"><?php echo $eventdetails['siteName'];?></span></h3>
                                <!-- <span class="video-hd"><a href="" data-toggle="modal" data-target="#myModal">HD</a></span> -->
                            </div>
                            <div class="video-img">
                                <div class="date-time-row"><span><?php echo convertEventLogDateFormat($eventdetails['eventTimeStr']);?></span></div>
                                <span data-toggle="modal" class="eventVideoClip" data-target="#customModal" data-video-link="<?php echo $eventdetails['eventlink'];?>"><img src="<?php echo base_url();?>assets/images/15copy@3x.png" data-images="<?php echo base_url();?>assets/images/slide/v5/1.jpg, <?php echo base_url();?>assets/images/slide/v5/2.jpg, <?php echo base_url();?>assets/images/slide/v5/3.jpg, <?php echo base_url();?>assets/images/slide/v5/4.jpg, <?php echo base_url();?>assets/images/slide/v5/5.jpg"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } else {?>
            <div class="site-data-date-block eventlogdetails">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $error;?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
        <!-- Workspace End -->
    </div>
    <!-- content -->
    <script>
        $(document).ready(function(){
            $(".eventVideoClip").click(function(){
                var videoURL = $(this).attr('data-video-link');
                console.log(videoURL);
                if(videoURL!="" && videoURL!=undefined)
                {
                    //console.log(videoURL); 
                    var str='<video id="video" autoplay controls>';
                    str+='<source src="'+videoURL+'" type="video/mp4">Your browser does not support HTML5 video.';
                    str+='</video>';
                    var eventName = $(".eventName").text();
                  
                }
                else
                {
                    var eventName ="Event Details";
                    var str= "No data found.";
                }
                $("#customModal #dynamicTitle").html(eventName);
                $("#customModal #dynamicResponse").html(str);
            });
        });
    </script>