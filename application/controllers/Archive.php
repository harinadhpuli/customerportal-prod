<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Archive extends CI_Controller
{

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

	public function __construct()
	{
		parent::__construct();
		check_UserSession();
		$this->load->model('Api_model');
		if($this->session->source=='IVigil'){
			//do nothing
		}else{
			redirect(base_url().'accessDenied');
			
		}
	}


	public function index()
	{
		$data['title'] = "Archive";
		$data['potentialList'] = $this->session->userdata('potentialList');
		if (!empty($this->session->userdata('USER_SELECTED_SITE'))) {
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
		$source=$this->session->userdata('source');
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		//$source =  $this->session->userdata('source');
		if (!empty($userSelectedSite)) {
			$potentialId = $userSelectedSite['potentialId'];
			$unitId = $userSelectedSite['unitId'];
		}
		$apiEndPoint = $this->api_endpoints->getAPIEndPointByUserSource('LIVE_VIEWS_API');
		if ($source == 'IVigil') {
			$params = array("event" => "potential", "potentialId" => $potentialId,"from"=>APISOURCE);
		} else {
			$params = array("event" => "potential", "potentialid" => $potentialId, "unitId" => $unitId, "isFetchImage" => true);
		}
		$cameraData = $this->Api_model->getLiveViews($apiEndPoint, $params);
		
		$camerasList = $cameraData[0];
		
		if($camerasList['analyticId']==7)
		{
			$data['cameraData'] = $cameraData;
			$this->home_template->load('home_template','footage-retrival',$data);    
		}
		else
		{
			$this->home_template->load('home_template', 'archive', $data);
		}


	}

	public function getArchive()
	{

		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$source =  $this->session->userdata('source');
		if (!empty($userSelectedSite)) {
			$potentialId = $userSelectedSite['potentialId'];
			$unitId = $userSelectedSite['unitId'];
		}

		$siteDateTime = getDateParametersByTimeZone($userSelectedSite['timezone']);
		//$currentDate = date('m-d-Y',strtotime($siteDateTime['currentTime']));
		$currentDate = date('m/d/Y',strtotime($siteDateTime['currentTime']));

		$archiveConfigAPI = $this->api_endpoints->getAPIEndPointByUserSource('ARCHIVE_CONFIG_API');
		$params = array("action"=>"repoconf","skipAuth"=>"true");

		$archiveDataConfiguration = $this->Api_model->archiveDeviceConfiguration($archiveConfigAPI,$params);
		$siteArchiveDays = 14;
		if(!empty($archiveDataConfiguration))
		{
			if($archiveDataConfiguration['archiveDays']!="")
			{
				$siteArchiveDays = $archiveDataConfiguration['archiveDays'];
			}
			else
			{
				$siteArchiveDays = 14;
			}
		}
		

		$apiEndPoint = $this->api_endpoints->getAPIEndPointByUserSource('LIVE_VIEWS_API');
		if ($source == 'IVigil') {
			$data = array("event" => "potential", "potentialId" => $potentialId,"from"=>APISOURCE);
		} else {
			$data = array("event" => "potential", "potentialid" => $potentialId, "unitId" => $unitId, "isFetchImage" => true);
		}
		$cameraData = $this->Api_model->getLiveViews($apiEndPoint, $data);
		// 		echo "<pre>";
		// print_r($cameraData);
		// echo "</pre>";
		// die;
		$str = '';
		/**
		 * left block starts here
		 */
		$str .= ' <div class="archiveBlock-left">
		<div class="archVideoImg"><img src="' . base_url("assets/images/archive-img.png") . '" alt="" /></div>
		
		<div class="videoControl">

			<a class="rewind videoOptions" data-video-option="rewind" href="javascript:void(0);"><img src="' . base_url("assets/images/previous.png") . '" alt=""> </a>

			<a class="fast-backward videoOptions" data-video-option="previous" href="javascript:void(0);"><img src="' . base_url("assets/images/fast-backward.png") . '" alt=""> </a>

			<a class="play" href="javascript:void(0);"><img src="' . base_url("assets/images/play.png") . '" alt=""> </a>

			<a class="fast-forward videoOptions" data-video-option="next" href="javascript:void(0);"><img src="' . base_url("assets/images/fast-forward.png") . '" alt=""> </a>

			<a class="forward videoOptions" data-video-option="forward" href="javascript:void(0);"><img src="' . base_url("assets/images/forward.png") . '" alt=""> </a>

		</div>

		</div>';
		/**
		 * left block ends here
		 */
		/**
		 * right block starts here
		 */
		$str .= '<div class="archiveBlock-right">

				<div class="filters-action">						

						<label class="select-camera">Select Camera</label>
						<select class="js-example-basic-single form-control" name="camera_list" id="archiveselect">';
							if (!empty($cameraData)) {
								$options = "";
								foreach ($cameraData as $key => $eachCamera) {
									if ($source == 'IVigil') {
										$cameraName = $eachCamera['name'];
									} else {
										$cameraName = $eachCamera['Name'];
									}
									$options .= '<option value="' . $eachCamera['cameraId'] . '">' . $cameraName . '</option>';
								}
								$str .= $options;
							}

					$str .= '</select>
			
			</div>
				<h5>' . $userSelectedSite['siteName'] . '</h5>

				<h4 class="camera_name">HOUSTON-BRANCH CAM02</h4>
					<div class="date-picker-block">
						<div class="form-group">
							<div class="input-group date downloadDtPicker">
								<input type="text" class="form-control" placeholder="Select Date" id="downloadDt" readonly value="'.$currentDate.'"/>											
								<span class="glyphicon glyphicon-calendar add-on"></span>										
							</div>										
						</div>
						<div class="buttonOrg downloadVideo"> <button class="btn">Download Video</button></div>
					</div>
			</div>
		';
		/**
		 * right block ends here
		 */

		$str .= '	<div class="clearfix"></div>
		 <div class="row">
			 <div class="col-sm-12">
			 <div class="playback-head"><h4>24 Hour Video Playback</h4></div>
				  <div class="playback-container">
<div   class="playback-body" >

<div class="playback-body-content">				

<svg width="1120" height="120" id="svg"	xmlns="http://www.w3.org/2000/svg" version="1.1" >

<rect id="activityBarView" width="720" height="15" x="10" y="33"	style="fill:white;stroke-width:1;stroke:#28323c;cursor:pointer;" />

<rect id="zoomBar" style="fill:none;stroke-width:1;stroke:red;stroke-style:dotted;cursor:pointer" x="10" y="29" width="20" height="22"  />

<rect id="zoomBarView" width="600" height="15" x="10" y="90" style="fill:white;stroke-width:1;stroke:red;cursor:pointer;" />

<line x1="11" y1="79" x2="11" y2="119" style="fill:rgb(255,0,255);stroke:rgb(255,0,0);stroke-width:2;cursor:pointer;" id="selector">
</svg>
</div>
</div>
		 </div>
			 </div>
		 </div>
	 </div>  
	           
';
	$responseArr = array("data"=>$str,"archieveDays"=>$siteArchiveDays);
	echo json_encode($responseArr);
	}
	public function getArchiveData()
	{
		$postData = json_decode($this->input->post('data'),1);
		$response = array();
		
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$siteDateTime = getDateParametersByTimeZone($userSelectedSite['timezone']);
		 

		$cameraid = $postData['cameraid'];
	
		$timestamp = convertdatetimepickerSeconds($postData['timestamp']);
		$userSelectedTime = date('Y-m-d H:i:s',strtotime($timestamp));
		$siteCurrentDateTime = date('Y-m-d H:i:s',strtotime($siteDateTime['currentTime']));

		$isvalidDates = compareDateRangeCondition($userSelectedTime,$siteCurrentDateTime);

		if($isvalidDates==0)
		{
			$response = array("error"=>"1", "msg"=>"Selected date and time should be less than current date and time");
			echo json_encode($response);
			die;
		}
		$timestamp = date('Y-m-d-H:i:s',strtotime($timestamp));

		
		

		// echo "<br>";
		// echo $this->session->userdata('CAMERA_DATA_SESSION');
		// die;
	
		// if($this->session->userdata('CAMERA_DATA_SESSION')=="")
		// {
		// 	$params = array("event"=>"sessionid","cameraid"=>$cameraid,"timestamp"=>$timestamp);
		// 	$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('CAMERA_SERVICE');
		// 	//echo $apiEndPoint;die;
		// 	$getSession = $this->Api_model->getEventSession($apiEndPoint,$params);

		// 	if(!empty($getSession['sessionId']))
		// 	{
		// 		$this->session->set_userdata("CAMERA_DATA_SESSION",$getSession['sessionId']);
		// 		$sessionId = $getSession['sessionId'];
		// 	}
		// }
		// else
		// {
		// 	$sessionId = $this->session->userdata('CAMERA_DATA_SESSION');
		// }
		
		$params = array("event"=>"sessionid","cameraid"=>$cameraid,"timestamp"=>$timestamp);
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('CAMERA_SERVICE');
		//echo $apiEndPoint;die;
		$getSession = $this->Api_model->getEventSession($apiEndPoint,$params);

		if(!empty($getSession['sessionId']))
		{
			$this->session->set_userdata("CAMERA_DATA_SESSION",$getSession['sessionId']);
			$sessionId = $getSession['sessionId'];
		}

		$apiEndPoint = $this->api_endpoints->getAPIEndPointByUserSource('ARCHIVE_DATA_API');
		$randomString = generateRandomString(13);
		//echo $apiEndPoint.'?event=init&sessionId='.$sessionId.'&'.$randomString;
		$resVideo = $apiEndPoint.'?event=play&sessionId='.$sessionId.'&'.$randomString;
		$response = array("error"=>"0", "videoPath"=>$resVideo);
		echo json_encode($response);
		die;
	}
	public function changeArchiveDataVideoControll()
	{
		$postData = json_decode($this->input->post('data'),1);

		$videoOption = $postData['videoOption'];

		$apiEndPoint = $this->api_endpoints->getAPIEndPointByUserSource('ARCHIVE_DATA_API');
		$sessionId = $this->session->userdata('CAMERA_DATA_SESSION');
		$randomString = generateRandomString(13);
		//echo $apiEndPoint.'?event='.$videoOption.'&sessionId='.$sessionId.'&'.$randomString;
		$resVideo = $apiEndPoint.'?event='.$videoOption.'&sessionId='.$sessionId.'&'.$randomString;
		$response = array("error"=>"0", "videoPath"=>$resVideo);
		echo json_encode($response);
	}
	public function downloadArchiveData()
	{
		$postData = $this->input->post();
		$date = explode(' ',$postData['startDate']);
		$postData['startDate'] = date('d-m-Y',strtotime($date[0]));
		$postData['startTime'] = $date[1].':00';
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('EXPORT_VIDEO_API');
		$duration = $postData['duration']*60;
		$url = $apiEndPoint.'?cameraId='.$postData['cameraId'].'&startDate='.$postData['startDate'].'&startTime='.$postData['startTime'].'&format='.$postData['format'].'&duration='.$duration.'&md='.$postData['md'];
		$filename = str_replace(' ','_',$postData['cameraname']).'.'.$postData['format'];
		header('Content-type: video/*');
		header('Content-Disposition: attachment; filename='.$filename);
		//$url ="https://aws0121.pro-vigil.info:8443/pro-vigil//ExportVideo?startDate=06-01-2020&startTime=00:00:04&duration=600&format=mp4&cameraId=Camera10&md=true";
		$data = file_get_contents($url);
		header("Content-Length: ".strlen($data));
		exit($data);
	}
}

