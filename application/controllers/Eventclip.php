<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventclip extends CI_Controller {

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
	public function index()
	{
		$data['title']="Event Clips";
		$data['potentialList'] = $this->session->userdata('potentialList');
		$source=$this->session->userdata('source');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
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
		/* echo "<pre>";
		print_r($cameraData);
		die; */
		$data['cameraData'] = $cameraData;
		$this->home_template->load('home_template','footage-retrival',$data);    
	}
	public function getSiteEventClips()
	{ 
		$postData = json_decode($this->input->post('data'),1);
		
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$potentialId = $userSelectedSite['potentialId'];
		if(isset($postData['fromdate']) && $postData['fromdate']!="")
		{
			$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('EVENT_CLIP_API');
			
			$cameraUniqId = "-";
			if($postData['cameraUniqId']!='')
			{
				$cameraUniqId = $postData['cameraUniqId'];
			}
			$lastkey = "-";
			if($postData['lastkey']!='')
			{
				$lastkey = $postData['lastkey'];
			}
			$source = $this->session->userdata('source');
			
			$frmDt = convertdatetimepickerFormate($postData['fromdate']);
			$endDt = convertdatetimepickerFormate($postData['todate']);
			$isSameStartAndEndDateCon = dateDiffByTime($frmDt,$endDt,'Hours');
			if($isSameStartAndEndDateCon<=0)
			{
				$response = array("error"=>"1", "msg"=>"Start & End date and time should not be same.");
				echo json_encode($response);
				die;
			}
			$isvalidDates = compareDateRangeCondition($frmDt,$endDt);
			
			if($isvalidDates==0)
			{
				$response = array("error"=>"1", "msg"=>"Start Date should be less than End Date");
				echo json_encode($response);
				die;
			}
			$fromDt = date('Y-m-d H:i:s',strtotime($postData['fromdate']));
			$todate = date('Y-m-d H:i:s',strtotime($postData['todate']));
			/*$fromDt = convertdatepickerFormate($postData['fromdate']);
			$todate = convertdatepickerFormate($postData['todate']);*/
			//$fromDt = "25-10-2020-16-26-21";
			//$todate = "28-10-2020-17-08-41";

			/* $isvalidDates = compareDateRangeCondition($fromDt,$todate); 
			if($isvalidDates==0)
			{
				$response = array("error"=>"1", "msg"=>"From Date should be less than are equal to To Date");
				echo json_encode($response);
				die;
			} */
			$fromDt = str_replace(" ","T",$fromDt);
			$todate = str_replace(" ","T",$todate);
						
			$currentDate = date('Y-m-d');
			$data = array("fromdate"=>$fromDt,"todate"=>$todate,"potentialid"=>$potentialId,"cameraid"=>$cameraUniqId,"lastkey"=>$lastkey,"pagesize" => 12);
			$params = json_encode($data);
			//echo $params;die;
			$requestMethod="POST";
			
			$siteEventClips = $this->Api_model->getSiteEventClips($apiEndPoint,$requestMethod,$params);
			/* echo "<pre>";
			print_r($siteEventClips);
			die; */
			$str='';
			
			if(!empty($siteEventClips['eventdata']) && $siteEventClips['lastkey']!='')
			{
				$lastkey = $siteEventClips['lastkey'];
				$i=1;
				foreach($siteEventClips['eventdata'] as $eventClip)
				{
					
					$eventTimeStamp = str_replace('T',' ',$eventClip['timestamp']);
					$eventClipTime = str_replace('T','-',$eventClip['timestamp']);
					$str.='<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">';
						$str.='<div class="v-box">';
						$str.='<div class="video-header">';
						$str.='<h6>'.$eventClip['cameraname'].' '.$eventTimeStamp.'</h6>';
						$str.='<div class="videohdimg">';
								//$str.='<span class="checkBt"><button><i class="fa fa-check" aria-hidden="true"></i></button></span>';
						$str.='<span class="download-Bt"><a href="javascript:void(0);" data-camera-name="'.$eventClip['cameraname'].'" data-eventClip="'.$eventClip['eventLink'].'" data-timestamp="'.$eventClipTime.'" class="downloadEventClip" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a></span>';
						$imagesList = implode(',',$eventClip['thumbnails']);
						$str.='</div>';
						$str.='</div>';
						$str.='<div class="c-video">';
						$str.='<div class="c-video box">';
						if(!empty($eventClip['thumbnails']))						
						$str.='<img src="'.$eventClip['thumbnails'][0].'" data-images="'.$imagesList.'" class="img-responsive">';
						else
						$str.='<img src="'.CONFIG_SERVER_ROOT.'assets/images/15copy@3x.png" alt="play Icon" class="img-responsive"/>';
						$str.='<video id="myVideo'.$i.'" autoplay class="displaynone" controls disablePictureInPicture controlsList="nodownload">';
						$str.='<source src="'.$eventClip['eventLink'].'" type="video/mp4" disablePictureInPicture>Your browser does not support HTML5 video.</video>';
						$str.='</div>';
						$str.='</div>';
						$str.='</div>';
						/* $str.='<div class="v-box">';
							$str.='<div class="video-header">';
								$str.='<h6>'.$eventClip['cameraname'].' '.$eventClip['timestamp'].'</h6>';
								
								$imagesList = implode(',',$eventClip['thumbnails']);
								
								$str.='<img src="'.$eventClip['thumbnails'][0].'" data-images="'.$imagesList.'" class="img-responsive"/>';
								$str.='<div class="videohdimg">';
								//$str.='<span class="checkBt"><button><i class="fa fa-check" aria-hidden="true"></i></button></span>';
								$str.='<span class="download-Bt"><a href="javascript:void(0);" data-eventClip='.$eventClip['eventLink'].' class="downloadEventClip" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a></span>';
								$str.='</div>';//videohdimg end
							$str.='</div>';//video header end
							$str.='<div class="video-img">';
							$str.='<video controls autoplay class="displaynone"><source type="video/mp4" src='.$eventClip['eventLink'].'></video>';
							$str.='</div>';
						$str.='</div>'; //v-box end */
					$str.='</div>';
					$i++;
				}
				$response = array("error"=>"0","msg"=>$str,"lastkey"=>$lastkey);
			}
			else
			{
				$str.='<div class="noClipsdataFound"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">No records are found</div></div>';
				$response = array("error"=>"0","msg"=>$str,"lastkey"=>"-");
			}
			
			//$isAllItemsLoaded = $siteEventLogs['isAllItemsLoaded'];
			
			echo json_encode($response);
		}
	}
	
	
	
}
