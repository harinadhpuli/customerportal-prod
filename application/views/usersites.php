<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
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
								<h2 class="title"><?php echo $title;?></h2>
							</div>
							<div class="alert alert-danger alert-dismissible fade in" id="customErrorMsgDivMsg" style="display:none">
                                <a href="#"  id="successMsgClose" onclick="closeMessagesDivDynamic('Error','#customErrorMsgDivMsg')" class="close"  aria-label="close">&times;</a>
                                    <span id="customErrorMsg"></span>
                            </div>
                            <div class="alert alert-success alert-dismissible fade in" id="customSuccessMsgDivMsg" style="display:none">
                                    <a href="#" id="errorMsgClose" onclick="closeMessagesDivDynamic('Success','#customSuccessMsgDivMsg')" class="close" aria-label="close">&times;</a>
                                    <span id="customSuccessMsg"></span>
                            </div>
						</div>
					</div>
				</div>
				<!-- Top Action Col End -->
				<!-- Workspace -->
                <div class="sitelistBlock">
                    <div class="container">
                        
						<div class="row">
							<div class="col-md-12">
								
								<?php
									if(!empty($potentialList) && sizeof($potentialList) > 1)
									{
                                     ?>
                                         
                                    <div class="filters-action">
                                        <ul>
                                            <li class="filters-action-li">
                                            <select class="userSites form-control" name="state" id="usersites">
                                                <option disabled selected>Select Site</option>
                                                <?php 
                                                 $i=0;
                                                foreach($potentialList as $site)
                                                {
                                                   
                                                ?>
                                                    <option value="<?php echo $i;?>"><?php echo $site['siteName'];?></option>
                                                <?php $i++;}?> 
                                            </select>
                                            </li>
                                        </ul>	
                                    </div>
								<?php }?>
								
							</div>
						</div>
                    </div>
               </div>
             <!-- Workspace End -->
			
			</div>
            <!-- content -->
            <script>
                $(document).ready(function(){
                    $(".userSites").change(function(){
                        setTimeout(() => {
				            $("#page-overlay").show();
			            }, 50);
                        var site = $(this).val();
                        var siteurl = "<?php echo base_url()?>";
                       
                       if(site!=undefined)
                       {
                           var url="<?php echo base_url()?>usersites/selectSite";
                           var data = { 'site': site};
                           response=ajaxRequestWithPromise(url,data);
                           response.then(function(v) {
                               if(v.error==0)
                               {
                                 location.href="<?php echo base_url()?>dashboard";
                               }
                            }, function(e) {
                                //$('#contactRequestError').html(v.msg);
                                console.log(v);
                            });
                       }
                        
                    });
                });
            </script>