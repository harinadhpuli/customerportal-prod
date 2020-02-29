<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventlog extends CI_Controller {

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
		$data['title']="Event Log";
		$data['potentialList'] = $this->session->userdata('potentialList');
		$source=$this->session->userdata('source');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
	
		$this->home_template->load('home_template','event_logs',$data);    
	}
	public function getSiteEventLogs()
	{
		$postData = json_decode($this->input->post('data'),1);
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		if(isset($postData['pageno']) && $postData['pageno']!="")
		{
			$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('EVENT_LOG_API');
			
			$pageNo = $postData['pageno'];
			$source = $this->session->userdata('source');

			$fromDt = convertdatepickerFormate($postData['fromdate']);
			$todate = convertdatepickerFormate($postData['todate']);

			$isvalidDates = compareDateRangeCondition($fromDt,$todate); 
			if($isvalidDates==0)
			{
				$response = array("error"=>"1", "msg"=>"From Date should be less than are equal to To Date");
				echo json_encode($response);
				die;
			}

			if($source=="PVM")
			{
				$currentDate = date('Y-m-d');
				$installationID = $userSelectedSite['installationId'];
				$data = array("installationID"=>$installationID,"pageNo"=>$pageNo,"pageSize"=>"10","date" => "test","fromdate"=>$fromDt,"todate"=>$todate);
				$params = json_encode($data);
				//echo $params;die;
				$requestMethod="POST";
			}
			elseif($source=="IVigil")
			{
				$potentialId = $userSelectedSite['potentialId'];
				$params = array("potentialid"=>$potentialId,"pageno"=>$pageNo,"fromDate"=>$fromDt,"toDate"=>$todate);
				$requestMethod="GET";
			}
			
			$siteEventLogs = $this->Api_model->getSiteEventLogs($apiEndPoint,$requestMethod,$params);
			// echo "<pre>";
			// print_r($siteEventLogs);
			// die;
			$str='';
			
			if(!empty($siteEventLogs['recentEscalations']) && $siteEventLogs['status']==200)
			{
				foreach($siteEventLogs['recentEscalations'] as $escalation)
				{
					if($source=="IVigil")
					{
						$cameraname = $escalation['cameraName'];
						$startTime = convertEventLogDateFormat($escalation['eventTimeStr']);
						$notes = $escalation['actionNotes'];
						$tagName = $escalation['finalActionType'];
					}else
					{
						if(isset($escalation['notes']) && $escalation['notes']!="")
						{
							$notes = $escalation['notes'];
						}
						else{
							$notes = "N/A";
						}
						$cameraname = $escalation['cameraname'];
						$startTime = convertEventLogDateFormat($escalation['starttime']);
						//$notes = $escalation['tagname'];
						$tagName = $escalation['tagname'];
					}
					$str.='<tr>';
					$str.='<td>'.$cameraname.'</td>';
					$str.='<td>'.$startTime.'</td>';
					$str.='<td>'.$notes.'</td>';
					$str.='<td>'.$tagName.'</td>';
					if($source=="PVM")
					{
						$groupId= $escalation['groupID'];
						$_SESSION[$groupId]['groupId'] = $groupId;
						$_SESSION[$groupId]['cameraname'] = $cameraname;
						$_SESSION[$groupId]['notes'] = $notes;
						$_SESSION[$groupId]['starttime'] = $startTime;
						$_SESSION[$groupId]['tagname'] = $tagName;
						$_SESSION[$groupId]['endtime'] = date("Y-m-d",strtotime($escalation['endtime']));
						
						$str.='<td><a href="'.base_url().'eventlogdetails/'.$groupId.'" data-toggle="tooltip" data-placement="top" title="View Details" class="singleEventLogDetails" target="_new" ><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
					}												
					else
					{
						$eventId = $escalation['idx'];
						$str.='<td><a href="'.base_url().'eventdetails/'.$eventId.'" data-toggle="tooltip" data-placement="top" title="View Details" target="_new"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
					}
					$str.='</tr>';
				}
			}
			else
			{
				$str.='<tr>';
				$str.='<td colspan="5" align="center">No data found</td>';	
				$str.='</tr>';
			}
			
			$isAllItemsLoaded = $siteEventLogs['isAllItemsLoaded'];
			$response = array("error"=>"0","msg"=>$str,"isAllItemsLoaded"=>$isAllItemsLoaded);
			echo json_encode($response);
		}
	}
	public function eventdetails($eventId)
	{
		if($eventId!="")
		{
			$data['title'] = "Event Details";
			if(!empty($this->session->userdata('USER_SELECTED_SITE')))
			{
				$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
			}
	
			$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('EVENT_LOG_DETAILS');
			$params = array("eventid"=>$eventId);
			$details = $this->Api_model->getEventDetailsByEventId($apiEndPoint,$params);
			// echo "<pre>";
			// print_r($details);
			// die;
			if($details['status']==200)
			{
				if(!empty($details['eventdetails']))
				{
					$data['eventdetails'] = $details['eventdetails'][0];
				}
				else
				{
					$data['error'] = "Records are not found.";
				}
			}
		}
		else
		{
			$data['error'] = "Event Id should not be empty";
		}
		$this->home_template->load('home_template','event_details',$data);
	}
	public function eventlogdetails($groupId)
	{
		$data['title'] = "Event Log Details";
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$data['groupId'] = $groupId;
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
	
		$this->home_template->load('home_template','event_log_details',$data);    
	}
	public function getSiteEventLogDetails()
	{
		$postData = json_decode($this->input->post('data'),1);
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$pageNo = $postData['pageno'];
		$groupId = $postData['groupId'];
		//$groupId = "GRP20190731120216PM216834615833056";
		$installationID = $userSelectedSite['installationId'];
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('EVENT_LOG_DETAILS');
		//$currentDate = date('Y-m-d');
	
		$endDatetime = $_SESSION[$groupId]['endtime'];
		
		//echo $endDatetime = $this->session->userdata('".$groupId."')['endtime'];die;
		$installationID = $userSelectedSite['installationId'];
		$data = array("groupid"=>$groupId,"installationID"=>$installationID,"installDate"=>$endDatetime,"tagType"=>"0","pageNo"=>$pageNo,"pageSize"=>"10");
	
		//echo json_encode($data);die;
		$logDetails = $this->Api_model->getEventDetailsByGroupId($apiEndPoint,$data);
		
		$str='';
		if($logDetails['status']==200)
		{
			if(!empty($logDetails['eventReports']['eventarray']))
			{
				foreach($logDetails['eventReports']['eventarray'] as $event)
				{
					$str.='<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">';
					$str.='<div class="v-box box">';
					$str.='<div class="video-header">';
					$str.='<h3><i class="fa fa-circle" aria-hidden="true"></i>'.$event['camname'].'</h3>';
				   	$str.='</div>';
					$str.='<div class="video-img">';
					$str.='<div class="date-time-row"><span>'.convertDBDateFormat($event['strttime']).'</span></div>';
					$str.='<span class="eventLogVideos" data-camname="'.$event['camname'].'" data-video-url="'. $event['cloudfronturl'].'">';
					if(!empty($event['imageurl']))
					{
						$str.='<img src="'.$event['imageurl'][0].'"></span>';
					}
					else
					{
						$str.='<img src="'.base_url().'assets/images/slide/v5/1.jpg" data-images="'.base_url().'assets/images/slide/v5/1.jpg, '.base_url().'assets/images/slide/v5/2.jpg, '.base_url().'assets/images/slide/v5/3.jpg, '.base_url().'assets/images/slide/v5/4.jpg, '.base_url().'assets/images/slide/v5/5.jpg"></span>';
					}
					
					$str.='</div>';
					$str.='</div>';
					$str.='</div>';
				}
			}
			
			echo $str;
		}
	}
}
