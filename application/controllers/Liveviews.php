<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Liveviews extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		check_UserSession();
		$this->load->model('Api_model');
		
    } 


	public function index(){
		$data['title']="Camera Views";
		$data['potentialList'] = $this->session->userdata('potentialList');
		$data['isLiveViews']=true;
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
		$this->home_template->load('home_template','liveviews',$data);  		   
	}
	
	public function getLiveViews($view='multi'){
		
		$postData = json_decode($this->input->post('data'),1);
		$class_lg ='col-lg-3';
		$class_md ='col-md-4';
		$class_sm ='col-sm-6';
		$class_xs ='col-xs-12';   
		if($view==1){
			$class_lg ='col-lg-12';
			$class_md ='col-md-12';
			$class_sm ='col-sm-12';
			$class_xs ='col-xs-12';  
		}else if($view==2){
			$class_lg ='col-lg-6';
			$class_md ='col-md-6';
			$class_sm ='col-sm-6';
			$class_xs ='col-xs-12';  
		}
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$source =  $this->session->userdata('source');
		if(!empty($userSelectedSite))
		{
			$potentialId = $userSelectedSite['potentialId'];
			$unitId = $userSelectedSite['unitId'];
		}
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('LIVE_VIEWS_API');
		//echo $apiEndPoint;die;
		if($source=='IVigil')
		{
			$pageNo = $postData['pageNo'];
			$data = array("event"=>"potential","potentialId"=>$potentialId,"from"=>APISOURCE,"pagination"=>'true','pageno'=>$pageNo);
			//$data = array("event"=>"potential","potentialId"=>$potentialId,"from"=>APISOURCE);
			
		}else{
			$data = array("event"=>"potential","potentialid"=>$potentialId, "unitId"=>$unitId, "isFetchImage"=>true,"from"=>APISOURCE);
		}
		$liveCameraViewsData = $this->Api_model->getLiveViews($apiEndPoint,$data);
		
		
		$str='';
		$noOfPages = 0;
		$current_pageNo = 0;
		if(!empty($liveCameraViewsData)){
			$i=0;
			$key=0;
			if($source=='IVigil')
			{
				$noOfPages = $liveCameraViewsData['noOfPages'];
				$current_pageNo = $liveCameraViewsData['current pageNo'];
				$liveViewsData = $liveCameraViewsData['cameraList'];
			}
			else
			{
				$noOfPages = 0;
				$current_pageNo = 0;
				$liveViewsData = $liveCameraViewsData;
			}
			/* echo "<pre>";
			print_r($liveViewsData);
			die; */
			foreach($liveViewsData as $eachVideo){
				
				$playIcon = "";
				$analyticId = (isset($eachVideo['analyticId']))?$eachVideo['analyticId']:1;
				if($source=='IVigil')
				{
					$imageUrl = (isset($eachVideo['dayImg']))?$eachVideo['dayImg']:base_url('assets/images/15copy@3x.png');
					$DefaultView ='SD';
					$connected = (isset($eachVideo['connected']))?($eachVideo['connected']=='false')?'redcircle':'':'';
					
					if($analyticId == 3){
						$hdurl = '';
						$cameraId = (isset($eachVideo['cameraId']))?$eachVideo['cameraId']:'';
						$name = (isset($eachVideo['name']))?$eachVideo['name']:'';
						$sdurl = (isset($userSelectedSite['url']))?$userSelectedSite['url'].'SnapShot?channel='.$cameraId.'&withmd=true&station=recordingStation':'';
						//$playIcon = '<div class="playIconc"><img src="assets/images/playiconc.png" alt="play Icon" /> <p>Click for Live Views</p></div>';
						$playIcon = "";
					}elseif($analyticId == 1){
						$DefaultView ='HD';
						$hdurl = (isset($eachVideo['hdurl']))?$eachVideo['hdurl']:'';
						$sdurl = (isset($eachVideo['sdUrl']))?$eachVideo['sdUrl']:'';
						$cameraId = (isset($eachVideo['localcameraID']))?$eachVideo['localcameraID']:'';
						$name = (isset($eachVideo['name']))?$eachVideo['name']:'';
						if(isset($eachVideo['dayImg']) && $eachVideo['dayImg']!="")
						{
							$playIcon = '<div class="playIconc"><img src="assets/images/playiconc.png" alt="play Icon" /> <p>Click for Live Views</p></div>';
						}
					}
					elseif($analyticId == 7 || $analyticId == 8 || $analyticId == 9){
						$DefaultView ='HD';
						$hdurl = (isset($eachVideo['hdurl']))?$eachVideo['hdurl']:'';
						//$sdurl = (isset($eachVideo['sdUrl']))?$eachVideo['sdUrl']:'';
						$cameraId = (isset($eachVideo['cameraId']))?$eachVideo['cameraId']:'';
						$name = (isset($eachVideo['name']))?$eachVideo['name']:'';
						$sdurl = (isset($userSelectedSite['url']))?$userSelectedSite['url'].'SnapShot?channel='.$cameraId.'&withmd=true&station=recordingStation':'';
						/* if(isset($eachVideo['dayImg']) && $eachVideo['dayImg']!="")
						{
							$playIcon = '<div class="playIconc"><img src="assets/images/playiconc.png" alt="play Icon" /> <p>Click for Live Views</p></div>';
						} */
						$playIcon = "";
					}
					if(isset($eachVideo['ptz']) && $eachVideo['ptz']!="")
					{
						$isPTZ=$eachVideo['ptz'];
					}
					else
					{
						$isPTZ="0";
					}
					//$cameraImage = (isset($userSelectedSite['url']))?$userSelectedSite['url']."CameraSnapShot?channel=".$cameraId."&station=recordingStation&view=day":'';
					//$maskingImage = (isset($userSelectedSite['url']))?$userSelectedSite['url']."CameraSnapShot?channel=".$cameraId."&station=recordingStation&view=day&overlay=Mask":'';
					/* if(isset($eachVideo['dayImg']) && $eachVideo['dayImg']!="")
					{
						$playIcon = '<div class="playIconc"><img src="assets/images/playiconc.png" alt="play Icon" /> <p>Click for Live Views</p></div>';
					} */
					//$playIcon = "";
					$lastmodifiedon = "NA";
					$night_lastmodifiedon = "NA";
					if($eachVideo['lastmodifiedon']!="" && $eachVideo['lastmodifiedon']!="-")
					{
						$lastmodifiedon = convertDBDateFormat($eachVideo['lastmodifiedon']);
					}
					if($eachVideo['night_lastmodifiedon']!="" && $eachVideo['night_lastmodifiedon']!="-")
					{
						$night_lastmodifiedon = convertDBDateFormat($eachVideo['night_lastmodifiedon']);
					}
					$cameradayImg = $daymaskimage = $nightimage = $nightmaskimage = COMINGSOONIMG;
					if(isset($eachVideo['dayImg']) && $eachVideo['dayImg']!="")
					{
						$cameradayImg = $eachVideo['dayImg'];
					}
					if(isset($eachVideo['daymaskimage']) && $eachVideo['daymaskimage']!="")
					{
						$daymaskimage = $eachVideo['daymaskimage'];
					}
					if(isset($eachVideo['nightimage']) && $eachVideo['nightimage']!="")
					{
						$nightimage = $eachVideo['nightimage'];
					}
					if(isset($eachVideo['nightimage']) && $eachVideo['nightimage']!="")
					{
						$nightimage = $eachVideo['nightimage'];
					}
					$nightmaskimage = $eachVideo['nightmaskimage'];
					
					$ownerEmail = "";
					$authToken = "";
					if(isset($eachVideo['owners_email']) && $eachVideo['owners_email']!="")
					{
						$ownerEmail = $eachVideo['owners_email'];
					}
					if(isset($eachVideo['auth_token']) && $eachVideo['auth_token']!="")
					{
						$authToken = $eachVideo['auth_token'];
					}
				}else{
					$name = (isset($eachVideo['Name']))?$eachVideo['Name']:'';
					$imageUrl = (isset($eachVideo['imgurl']))?$eachVideo['imgurl']:base_url('assets/images/15copy@3x.png');
					$DefaultView ='HD';
					$connected = (isset($eachVideo['connected']))?($eachVideo['connected']=='0')?'redcircle':'':'';
					$cameraImage = "Camera view is not available for this site";
					$maskingImage = "Masking view is not available for this site";
					$hdurl = (isset($eachVideo['hdUrl']))?$eachVideo['hdUrl']:'';
					$sdurl = (isset($eachVideo['sdUrl']))?$eachVideo['sdUrl']:'';
					
					$ownerEmail = $eachVideo['owners_email'];
					$authToken = $eachVideo['auth_token'];

					if($eachVideo['imgurl']!="")
					{
						$playIcon = '<div class="playIconc"><img src="assets/images/playiconc.png" alt="play Icon" /> <p>Click for Live Views</p></div>';
					}
					
					$cameraId= $eachVideo['localcameraID'];
					$isPTZ=$eachVideo['PTZ'];
					
					$lastmodifiedon = "";
					$night_lastmodifiedon = "";
					$cameradayImg = "Day view is not available for this site";
					$daymaskimage = "Day Masking is not available for this site";
					$nightimage = "Night view is not available for this site";
					$nightmaskimage = "Night Masking view is not available for this site";
				}
				
				$ptzControls = "";
				if($isPTZ=='true')
				{
					$ptzControls = '<div class="camControls">
						<div class="singleBt">
							<button class="camPTZAction" data-action="TILTUP"><img src="assets/images/tilt_up.png"> </button>
						</div>
						<div class="multiBt">
							<button class="camPTZAction" data-action="PANLEFT"><img src="assets/images/pan_left.png"></button>
							<button class="camPTZAction" data-action="GOTOPRESET"><img src="assets/images/preset.png"> </button> 
							<button class="camPTZAction" data-action="PANRIGHT"><img src="assets/images/pan_right.png"> </button>
						</div>
						<div class="singleBt">
							<button class="camPTZAction" data-action="TILTDOWN"><img src="assets/images/tilt_down.png"> </button>
						</div>
						<div class="singleBt">
							<button class="camPTZAction" data-action="ZOOMIN"><img src="assets/images/zoom_in.png"> </button>
						</div>
						<div class="singleBt">
							<button class="camPTZAction" data-action="ZOOMOUT"><img src="assets/images/zoom_out.png"> </button>
						</div>
						<div class="multiBt bottomControl">
							<button class="camStreamSpeed" data-speed="1">L</button> 
							<button class="camStreamSpeed active" data-speed="2">M</button> 
							<button class="camStreamSpeed" data-speed="3">H
						</div>
					</div>';
				} 
				//echo $name;die;
				if($key%4==0){
					$rowend = $key+3;
					$str .='<div class="row">';
				}
				$str .='<div class="'.$class_lg.' '.$class_md.' '.$class_sm.' '.$class_xs.'">
				<div class="v-box box">
					<div class="video-header"><h3 data-toggle="tooltip" data-placement="top" title="'.$name.'"><i class="fa fa-circle '.$connected.'" aria-hidden="true"></i> '.$name.'</h3>
						<div class="videohdimg">
							<span class="video-hd"><a class="play-live" data-toggle="tooltip" data-placement="top" title="Video" href="javascript:void(0)" data-name="'.$name.'" data-hdurl="'.$hdurl.'" data-sdurl="'.$sdurl.'" data-source="'.$source.'" data-ptz="'.$isPTZ.'" data-connected="'.$connected.'" data-analyticId="'.$analyticId.'">'.$DefaultView.'</a></span>
							<span class="maskingImg-Bt" >
								<a data-toggle="tooltip" data-placement="top" title="Masking" href="javascript:void(0)" class="masking" data-cameradayImg="'.$cameradayImg.'" data-daymaskimage="'.$daymaskimage.'" data-nightimage="'.$nightimage.'" data-nightmaskimage="'.$nightmaskimage.'" data-lastmodifiedon="'.$lastmodifiedon.'" date-night_lastmodifiedon="'.$night_lastmodifiedon.'" data-source="'.$source.'" data-connected="'.$connected.'">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129.176 110.5">
									<g id="noun_Image_2160593" transform="translate(-13.439 -2.675)">
										<path id="Path_124" data-name="Path 124" d="M127.06,2.675H5.666A3.892,3.892,0,0,0,1.775,6.566V109.284a3.892,3.892,0,0,0,3.891,3.891H127.06a3.892,3.892,0,0,0,3.891-3.891V6.566A3.892,3.892,0,0,0,127.06,2.675Zm-3.891,102.718H9.557V10.457H123.169Z" transform="translate(11.664 0)" fill="#67ba2c"/>
										<path id="Path_125" data-name="Path 125" d="M7.063,56.926H99.51a3.892,3.892,0,0,0,2.895-6.5L79.713,25.218a3.9,3.9,0,0,0-5.79,0L68.414,31.34,47.777,8.41a4.023,4.023,0,0,0-5.79,0L4.169,50.431a3.892,3.892,0,0,0,2.895,6.5ZM76.818,33.633,90.773,49.145H84.434L73.654,37.161ZM44.882,16.825l20.637,22.93,8.446,9.39H15.8Z" transform="translate(24.741 42.242)" fill="#67ba2c"/>
										<path id="Path_126" data-name="Path 126" d="M22.654,31.833A13.229,13.229,0,1,0,9.425,18.6,13.244,13.244,0,0,0,22.654,31.833Zm0-18.676A5.447,5.447,0,1,1,17.207,18.6,5.447,5.447,0,0,1,22.654,13.157Z" transform="translate(83.387 25.314)" fill="#67ba2c"/>
									</g>
									</svg>
								</a>
							</span>
						</div>
					</div>
					<div class="video-img" data-ptz="'.$isPTZ.'" data-analyticId="'.$analyticId.'" data-cameraId="'.$cameraId.'" data-ownerEmail="'.$ownerEmail.'" data-authToken="'.$authToken.'" data-hdurl="'.$hdurl.'" data-name="'.$name.'" data-sdurl="'.$sdurl.'" data-source="'.$source.'" data-connected="'.$connected.'">
					<div class="videoImgPosition">
					'.$playIcon	.'
					<img src="'.$imageUrl.'" class="camLiveView">
					</div>
					</div>
				</div>
				'.$ptzControls.'
			</div>';
			if($key==$rowend){
				$str .='</div>';
			}
			$key++;
			}
		}else{
			$str = '<span class="grayText">No Live Views</span>';
		}
		
			$str = str_replace("\n", "", $str);
			$str = str_replace("\r", "", $str);
			$str = str_replace("\t",'', $str);
			//$str = stripslashes($str);
			$response = array("result"=>$str,"noOfPages"=>$noOfPages,"currentpageNo"=>$current_pageNo);
			echo json_encode($response,JSON_UNESCAPED_SLASHES);
		}
	public function getCamioRTMPLiveURLOld()
	{
		$postData = json_decode($this->input->post('data'),1);
        $response = array();
		$cameraId = "";
        if(isset($postData['cameraId']) && $postData['cameraId']!="")
        {
           $cameraId = $postData['cameraId'];
        }
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		
		$source =  $this->session->userdata('source');
		if(!empty($userSelectedSite))
		{
			$potentialId = $userSelectedSite['potentialId'];
			$unitId = $userSelectedSite['unitId'];
		}
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('RTMP_API');
		if($source=="IVigil")
		{
			$params = array('uniqueCameraID'=>$cameraId,"potentialID"=>$potentialId);
			//$params = array('uniqueCameraID'=>"722072VGSTEST1016CAM36792","potentialID"=>"722072");
		}
		elseif($source=="PVM")
		{
			$params = array('cameraname'=>$cameraId,"installationid"=>$potentialId);
		}
		
		$rtmpData = $this->Api_model->getRTMPLiveData($apiEndPoint,$params);
		
		$cameraRTMPURL = "";
		if(!empty($rtmpData))
		{
			if($source=="IVigil")
			{
				$cameraRTMPURL =  $rtmpData['liveurl'];
			}
			else
			{
				$cameraRTMPURL = $rtmpData['live_streaming']['liveurl'];
			}
		}
		echo $cameraRTMPURL;
	}
	public function getCamioRTMPLiveURL()
	{
		$postData = json_decode($this->input->post('data'),1);
        $response = array();
		$cameraId = "";
        if(isset($postData['cameraId']) && $postData['cameraId']!="")
        {
           $cameraId = $postData['cameraId'];
        }
		$ownerEmail = $postData['ownerEmail'];
		$authToken = $postData['authToken'];
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('RTMP_API');
		
		$rtmpData = $this->Api_model->getRTMPLiveStreamData($apiEndPoint,$cameraId,$ownerEmail,$authToken);
		
		$cameraRTMPURL = "";
		if(!empty($rtmpData))
		{
			//$cameraRTMPURL = $rtmpData['streaming_server_url'];
			$cameraRTMPURL = $rtmpData['hls_url'];
		}
		echo $cameraRTMPURL;
	}
	public function getCamioPTZLiveURL()
	{
		$postData = json_decode($this->input->post('data'),1);
        $response = array();
		
		$cameraId = $postData['cameraId'];
		$selectedAction = $postData['selectedAction'];
		$selectedSpeed = $postData['selectedSpeed'];
		 
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('PTZ_API');
		$params = array("event"=>"ptz","cameraid"=>$cameraId,"speed"=>$selectedSpeed,"action"=>$selectedAction);
		
		$camPTZData = $this->Api_model->getPTZLiveData($apiEndPoint,$params);
	}
	public function closeRTMPStream()
	{
		$postData = json_decode($this->input->post('data'),1);
        $response = array();
		
		$cameraId = $postData['cameraId'];
		$ownerEmail = $postData['ownerEmail'];
		$authToken = $postData['authToken'];
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('RTMP_API');
		$params = array("local_camera_id"=>$cameraId,"user"=>$ownerEmail);
		$response = $this->Api_model->deleteRTMPStream($apiEndPoint,$params,$authToken);
	}
	public function getHLSStreamURL()
	{
		$postData = json_decode($this->input->post('data'),1);
        $response = array();
		
		$hlsurl = $postData['hdurl'];
		
		$hlsStream = $this->Api_model->executeCurlRequest($hlsurl,"GET","");
		
		if(!empty($hlsStream))
		{
			if($hlsStream['success']==1 && $hlsStream['data']['hlsUrl']!='')
			{
				$hlsUrl = $hlsStream['data']['hlsUrl'];
				$expirySeconds = $hlsStream['data']['expirySeconds'];
				$response = array('success'=>1,'hlsUrl'=>$hlsUrl,'expirySeconds'=>$expirySeconds);
			}
			else
			{
				$response = array('success'=>0,'msg'=>'Stream not available, Please try again');
			}
		}
		else
		{
			$response = array('success'=>0,'msg'=>'Stream not available, Please try again');
		}
		
		echo json_encode($response);
	}
}