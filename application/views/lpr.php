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
                        <h4 class="sitetitle"><?php if(!empty($lprList) && sizeof($lprList)==1) { echo $lprList[0]['siteName'];}?></h4>
                    </div>
					<?php if(!empty($lprList) && sizeof($lprList)>1) {?>
                    <div class="col-sm-4 innerRightActions">
						<div class="pull-right">
							<div class="filters-action">
								<select id="lprsites" name="lprsites" class="form-control">
									<option disabled selected>Select Site List</option>
									<?php
										if(!empty($lprList))
										{
											foreach($lprList as $list)
											{?>
											<option value="<?php echo $list['potentialId'];?>"><?php echo $list['siteName'];?></option>	
										<?php	}
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<?php } else {?>
						<input type="hidden" id="lprsites" value="<?php echo $lprList[0]['potentialId'];?>" >
					<?php }?>
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
					<div class="row date-picker-block">
						<div class="col-md-4">
							<div class="form-group">
								<div class='input-group'>
									<input type='text' class="form-control" placeholder="From Date"  id="startDate"  autocomplete="off"/>
									<span class="glyphicon glyphicon-calendar calendarOpen" id="startOpen"></span>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<div class='input-group'>
									<input type='text' class="form-control" placeholder="To Date" id="endDate" autocomplete="off"/>
									<span class="glyphicon glyphicon-calendar calendarOpen" id="endOpen"></span>
								</div>
							</div>
						</div>
						<div class="col-sm-4 buttonOrg form-group"><button class="btn" id="searchBtn"><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Search</button></div>
					</div>
				</div>
				
				
            </div>
			<div class="container">
				<div class="lprcard" id="siteLPRDetails">
					
				</div>
			</div>
        </div>
        <!-- Workspace End -->
    </div>
    <!-- content -->
	
	<!-- Modal -->
<div class="modal fade modalBlock lprBlockModal" id="lprBlockModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>       
      </div>
      <div class="modal-body">
      <div class="numberlpr" id="LPRPlateImg"></div>
      </div>

    </div>
  </div>
</div>
	
    <script>
		$(document).ready(function () {
				//Inline DateTimePicker Example
            var startDate = $('#startDate').datetimepicker({
                format: 'm/d/Y H:i',
                
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
                        //maxDate:maximumDate,
                    })
                }
            });

            $('#startOpen').click(function(){
	            $('#startDate').datetimepicker('show');
            });
            $('#endOpen').click(function(){
	            $('#endDate').datetimepicker('show');
            });
				
			var sites = '<?php echo sizeof($lprList);?>'*1;
			//console.log(sites);
			if(sites>1){
				$('#lprsites').multiselect({
					enableClickableOptGroups: true,
					enableCollapsibleOptGroups: true,
					enableCaseInsensitiveFiltering:true,
					enableFiltering: true,		
					includeSelectAllOption: false				 
				}); 
			}
				
				//jQuery('#startDate, #endDate ').datetimepicker();
				
				
			});
        $(document).ready(function() {
            var pageno = 1;
            
            //getSitePSAList();
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
                    getSiteLPRList();
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
       
        function getSiteLPRList() {
            $("#page-overlay").show();
            var url = "<?php echo base_url() ?>lpr/getSiteLPRList";
			var potentialId = $("#lprsites").val();
            var fromdate = $("#startDate").val();
            var todate  = $("#endDate").val();
            var data = {
                "fromdate": fromdate,"todate":todate,"potentialId":potentialId
            };
            response = ajaxRequestPromiseReturnHtml(url, data);
            response.then(function(v) {
				
                var res = JSON.parse(v);
				$("#page-overlay").hide();
                if(res.error==0)
                {
                    var selectedSite = $("#lprsites option:selected").text();
					if(selectedSite!=undefined && selectedSite!="")
					{
						var selectedLPRSite = selectedSite;
					}
					else
					{
						var selectedLPRSite = $(".sitetitle").html();
					}
					
				$(".sitetitle").html(selectedLPRSite);
					
					$("#customErrorMsgDiv").hide();
                    $("#customErrorMsg").html('');
                    $("#siteLPRDetails").html(res.lprdata);
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

      
		/* $("#lprsites").change(function() {
            $("#siteLPRDetails").html('');
           
	    });*/
       $(document).on('click','.numberlpr',function(){
		   var numberplateImg = $(this).html();
		   
		   $('#lprBlockModal').modal('show');
		   $('#lprBlockModal #LPRPlateImg').html(numberplateImg);
		   
	   });
    </script>