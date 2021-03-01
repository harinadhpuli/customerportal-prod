<?php
defined('BASEPATH') or exit('No direct script access allowed');
    $myDateTime = getDateParametersByTimeZone($selectedSite['timezone']);
	$todayDate = date('m/d/Y H:i',strtotime($myDateTime['currentTime']));
	
	$fromtDate = date('m/d/Y H:i',strtotime('-1 hours',strtotime($myDateTime['currentTime'])));
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
		 <div class="container">
		
			 </div>
        <div class="site-data-date-block">
       
            <div class="container">
                
				<div class="clearfix"></div>
               
                <div class="row">
                    <div class="col-md-12 date-picker-block">
						<div class="col-sm-3">
                            <div class="form-group">
								<div class="filters-action">
									<select class='form-control' id="cameraUniqId" name="cameraUniqId">
										<option value="">All</option>
										<?php
											if(!empty($cameraData))
											{
												foreach($cameraData as $eachCamera)
												{?>
													<option value="<?php echo $eachCamera['camerauniqueid']?>"><?php echo $eachCamera['name']?></option>
												<?php }
											}
										?>
									</select>
								</div>
							</div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class='input-group'>
                                    <input type='text' class="form-control" placeholder="From Date"  id="startDate" value="<?php echo $fromtDate;?>" />
                                    <span class="glyphicon glyphicon-calendar calendarOpen" id="startOpen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                               <div class='input-group'>
                                    <input type='text' class="form-control" placeholder="To Date" id="endDate" value="<?php echo $todayDate;?>"/>
                                    <span class="glyphicon glyphicon-calendar calendarOpen" id="endOpen"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 buttonOrg form-group">
							<button class="btn" id="searchBtn"><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Search</button>
							<!--<button class="btn" id="searchBtn"><i class="fa fa-share" aria-hidden="true"></i>&nbsp; Share</button>-->
						</div>
						
			
                    </div>
                </div>
              
              
               
            </div>
          
        </div>
		
		 <div class="container">
		     			 <div class="clearfix text-center">
                        <div class="responseMsg">
                            <div class="alert alert-danger alert-dismissible fade in" id="customErrorMsgDiv" style="display:none">
                                <a href="#" id="successMsgClose" onclick="closeMessagesDivDynamic('Error','#customErrorMsgDiv')" class="close" aria-label="close">&times;</a>
                                <span id="customErrorMsg"></span>
                            </div>
                            
                        </div>
                    </div>
			</div>		
					
		<!-- Workspace -->
                <div class="camera-view-block camera-view-Three">
                    <div class="container">
                        <div class="row" id="siteEventClipList"> 
							
                        </div>
                    </div>
                    
                </div>
             <!-- Workspace End -->
        
        <input type="hidden" id="lastkey" value="">
        <!-- Workspace End -->
    </div>
    <!-- content -->
	
	<form class="form-inline download-form" method="post" action="<?php echo base_url('downloadFile/downloadClip'); ?>">
		<input type="hidden" name="eventclip" id="eventclip">
		<input type="hidden" name="eventclipTime" id="eventclipTime">
		<input type="hidden" name="eventclipName" id="eventclipName">
	</form>
	<script src="<?php echo base_url();?>assets/js/jquery.serce.min.js" type="text/javascript"></script>
	
    <script>
        $(document).ready(function(){
			
			$('#startOpen').click(function(){
	            $('#startDate').datetimepicker('show');
            });
            $('#endOpen').click(function(){
	            $('#endDate').datetimepicker('show');
            });
            $('#cameraUniqId').multiselect({
				enableClickableOptGroups: true,
				enableCaseInsensitiveFiltering: true,
				enableCollapsibleOptGroups: true,
				enableFiltering: true,
				includeSelectAllOption: false
			});
            var pageno=1;
			getSiteEventClips();
            $("#searchBtn").click(function(){
            	
                var fromdate = $("#startDate").val();
                var todate  = $("#endDate").val();
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
                    $("#siteEventClipList").html("");
					$("#lastkey").val('-');
                    getSiteEventClips();
                }
            });

			var startDate = $('#startDate').datetimepicker({
                format: 'm/d/Y H:i',
                maxDate: '<?php echo $todayDate;?>',
                step: 30,
                autoclose: true,
                onChangeDateTime:function(dp,$input){
                    $('#endDate').val($input.val());
                }
            })
			$('#endDate').datetimepicker({
                format: 'm/d/Y H:i',
				//maxDate: '<?php echo $todayDate;?>',
                step: 30,
                onShow:function( ct ){
                
                    var newDate = new Date(jQuery('#startDate').val())
                    let month = newDate.getMonth()+1;
                    let day = newDate.getDate();
                    let year = newDate.getFullYear();
                    let minimumDate =year+'/'+month+'/'+day; 
                    newDate.setDate(newDate.getDate());
                    month = newDate.getMonth()+1;
                    day = newDate.getDate();
                    year = newDate.getFullYear();
                    maximumDate =year+'/'+month+'/'+day; 
					
                    this.setOptions({
                        minDate:minimumDate,
                        //maxDate:maximumDate,
                    })
                }
            });
	
            /* $('#fromdatepicker').datepicker({				
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
               
            }); */

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
                    $("#siteEventClipList").html("");
					//getSiteEventClips();
					location.reload(); 
                    $(".sitetitle").html(siteName);
                    }, function(e) {
                        //$('#contactRequestError').html(v.msg);
                        console.log(v);
                    });
                }
            });
        });

        function getSiteEventClips()
        {
            
            $("#page-overlay").show();
			/* setTimeout(() => {
				$("#page-overlay").show();
			}, 50); */
					
            var url="<?php echo base_url()?>eventclip/getSiteEventClips";
            var fromdate = $("#startDate").val();
            var todate  = $("#endDate").val();
			var lastkey = $("#lastkey").val();
			var cameraUniqId = $("#cameraUniqId").val();
			
            var data = {"cameraUniqId":cameraUniqId,"fromdate":fromdate,"todate":todate,"lastkey":lastkey};
            response=ajaxRequestPromiseReturnHtml(url,data);
            response.then(function(v) {
            $("#page-overlay").hide();
            var res = JSON.parse(v);
                if(res.error==0)
                {
                    $("#customErrorMsgDiv").hide();
                    $("#customErrorMsg").html('');
					$(".noClipsdataFound").html('');
                    //$("#sitePSAList").html(res.msg);
                    var currentLen = $("#siteEventClipList tr").length*1;
                    $("#siteEventClipList").append(res.msg);
					
					$("#lastkey").val(res.lastkey);
					$('.box').serce();
                }
                else
                {
                    $("#customErrorMsgDiv").show();
                    $("#customErrorMsg").html(res.msg);
                    triggerAutoCloseMsg('Error');
                }
                
            }, function(e) {
                //$('#contactRequestError').html(v.msg);
                console.log(v);
            });
        }

       
    $(window).on("scroll", function() {
        /* var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
		console.log((scrollHeight - scrollPosition) / scrollHeight);
        if ((scrollHeight - scrollPosition) / scrollHeight === 0)
        {
            var isAllItemsLoaded = $("#lastkey").val();
            if(isAllItemsLoaded!='-')
            {
                getSiteEventClips();
            }
        } */
		
		var scrollPosition=$(window).scrollTop() + $(window).height();
		scrollPosition=scrollPosition.toFixed();
		if(scrollPosition == getDocHeight()){
			var isAllItemsLoaded = $("#lastkey").val();
            if(isAllItemsLoaded!='-')
            {
                getSiteEventClips();
            }
		}
	});
	
	$(document).on('click','.downloadEventClip',function(){
		var eventClipLink = $(this).attr('data-eventClip');
		var eventTimeStamp = $(this).attr('data-timestamp');
		var eventclipName = $(this).attr('data-camera-name');
		$('#eventclip').val(eventClipLink);
		$('#eventclipTime').val(eventTimeStamp);
		$('#eventclipName').val(eventclipName);
		$('.download-form').submit();
		$('#eventclip').val('');
		$('#eventclipTime').val('');
		$('#eventclipName').val('');
	});
	
	$(document).on('click', '.box img', function () {
        $(this).addClass('displaynone');
        $(this).closest('.box').find('video').removeClass('displaynone');
        //$(this).closest('.cardbox').find('.play').toggleClass('icon-pause icon-play');
        $(this).closest('.cardbox').find('.play').parent('a').attr("data-original-title", "Pause");
        var idVal = $(this).closest('.box').find('video').attr('id');
        playVid(idVal);

        $(this).closest('.box').find('video').bind("ended", function() {
          //alert('test');
          $(this).addClass('displaynone');
          $(this).closest('.box').find('img').removeClass('displaynone');
      });

    });	
	
	function playVid(id) {
			document.getElementById(id).play();
			document.getElementById(id).addEventListener("ended", function () {
				$('#' + id).closest('.cardbox').find('.play').toggleClass('icon-pause icon-play');
				$('#' + id).closest('.cardbox').find('.play').parent('a').attr("data-original-title", "Play");
			});
		}
	function pauseVid(id) {
		document.getElementById(id).pause();
	}
		

    </script>