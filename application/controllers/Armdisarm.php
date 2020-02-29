<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armdisarm extends CI_Controller {

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
		$this->load->model('Api_model');
		check_UserSession();
		
    } 
	public function index()
	{
		$data['title']="Arm/Disarm History";
		$data['potentialList'] = $this->session->userdata('potentialList');
		$source =  $this->session->userdata('source');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{

			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
			$data['page'] = 'history';

		}
		$this->home_template->load('home_template','arm_disarm_history',$data);    
	}
	public function loadHistory(){
			$history = $this->getHistory();
			$selectedSite = $this->session->userdata('USER_SELECTED_SITE');
			$timeZone = $selectedSite['timezone'];
		/* 	echo "<pre>";
			print_r($history);
			die; */
			$str = "<table class='table custom-table'>
					<thead>
						<tr>
							<th>Name</th>
							<th>Armed/Disarmed</th>
							<th>Date</th>	
							<th>Time</th>															
																				
						</tr>
					</thead>
					<tbody>";
			if(isset($history) && !empty($history)){
				$dateSettings = getDateParametersByTimeZone($timeZone);
				 foreach($history as $eachHistory){
					if(isset($eachHistory['userId']) && !empty($eachHistory['userId'])){ $userId = ucfirst($eachHistory['userId']); }else{ $userId = ''; }
					if(isset($eachHistory['eventType']) && $eachHistory['eventType'] =='ACTIVATE'){
						$statusClass="armAction";
						$status= "Armed";
					}else{
						$statusClass="disarmAction";
						$status= "Disarmed";
					}
					$time = '';
					if(isset($eachHistory['eventTime']) && !empty($eachHistory['eventTime']))
					{
						$time = $eachHistory['eventTime']['hourOfDay'].':'.$eachHistory['eventTime']['minute'].':'.$eachHistory['eventTime']['second']; 
						$time = date("H:i:s",strtotime($time));
					}
					
					$date = '';
					if(isset($eachHistory['eventTime']) && !empty($eachHistory['eventTime']))
					{
						$source = $this->session->userdata('source');
						$dayOfMonth = $eachHistory['eventTime']['dayOfMonth'];
						$month = $eachHistory['eventTime']['month'];
						$year = $eachHistory['eventTime']['year'];
						if($source=="IVigil")
						{
							$month=$month+1;
						}
						
						$date = $dayOfMonth.'-'.$month.'-'.$year; 
						$date = date('d-m-Y',strtotime($date));
						$displayDate = $month.'/'.$dayOfMonth.'/'.$year; 
					}
					$convertedDate = dateConvertByTimeZone($date.$time, 'CST', $dateSettings['displayCode'], 'd-m-Y H:i:s');
					$dateTimeFinal = explode(' ',$convertedDate);
					if($source=="IVigil" && $timeZone !='CT')
					{
						$date = $dateTimeFinal[0];
						$time = $dateTimeFinal[1];
						$displayDate = date('m/d/Y',strtotime($date));
					}
					$str.= "<tr>
							<td>".$userId."</td>
							<td><span class='".$statusClass."'>".$status."</span></td>
							<td>".$displayDate."</td>	
							<td>".$time."</td>																			
						</tr>";
				 	} }else{
						$str.="<tr>
								<td colspan='4'>No History Found.</td>																	
							</tr>";
				 	}
					 $str.="</tbody></table>";
					 echo $str;
	}
	public function getStatus(){
		$selectedSiteData = $this->session->userdata('USER_SELECTED_SITE');
		$siteName = $selectedSiteData['siteName'];
		$potentialId = $selectedSiteData['potentialId'];
		$toDate = date('m/d/Y');
		$fromDate = date('m/d/Y', strtotime("-2 day"));
		$source =  $this->session->userdata('source');
		if($source=='IVigil')
		{
			$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('ONLY_STATUS_API');
			$data = array("event"=>"MonitoringStatus", "potentialId"=>$potentialId);
		}else{
			$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('ARM_DISARM_STATUS_API');
			$data = array("fdate"=>$fromDate, "tdate"=>$toDate,"sitename"=>$siteName,"event"=>"MonitoringStatus", "potentialid"=>$potentialId);
		}
	
		
		$armDisarmStatusList = $this->Api_model->getSiteStatus($apiEndPoint,$data);
		/* if($source=='IVigil')
		{
			if(isset($armDisarmStatusList['monitoringStatus']) && !empty($armDisarmStatusList['monitoringStatus'])){
				return $armDisarmStatusList['monitoringStatus']['status'];
			}else{
				return 0;
			}
		}else{
			return $armDisarmStatusList['monitoringstatus']['status'];
		} */
		if($source=='IVigil')
		{
			if(isset($armDisarmStatusList['status']) && !empty($armDisarmStatusList['status'])){
				return $armDisarmStatusList['status'];
			}else{
				return 0;
			}
		}else{
			return $armDisarmStatusList['monitoringstatus']['status'];
		} 
	}
	public function getHistory(){
		$selectedSiteData = $this->session->userdata('USER_SELECTED_SITE');
		$siteName = $selectedSiteData['siteName'];
		$potentialId = $selectedSiteData['potentialId'];
		$toDate = date('m/d/Y');
		$fromDate = date('m/d/Y', strtotime("-2 day"));
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('ARM_DISARM_STATUS_API');
		$source =  $this->session->userdata('source');
		if($source=='IVigil')
		{
			$data = array("fdate"=>$fromDate, "tdate"=>$toDate,"sitename"=>$siteName,"event"=>"MonitoringStatus", "potentialid"=>$potentialId,"from"=>APISOURCE);
		}
		else
		{
			$data = array("fdate"=>$fromDate, "tdate"=>$toDate,"sitename"=>$siteName,"event"=>"MonitoringStatus", "potentialid"=>$potentialId);
		}
		$armDisarmStatusList = $this->Api_model->getSiteStatus($apiEndPoint,$data);
		if($source=='IVigil')
		{
			if(isset($armDisarmStatusList['monitoringStatus']) && !empty($armDisarmStatusList['monitoringStatus'])){
				$history = $armDisarmStatusList['reverseEscalations'];
				 $this->session->set_userdata('siteStatus',$armDisarmStatusList['monitoringStatus']['status']);
			}else{
				$history = [];
			}
			return $history;
		}else
		{
			$history = [];
			if(!empty($armDisarmStatusList['armDisArmHistory']))
			{
				$history = $armDisarmStatusList['armDisArmHistory'];
			}
			$this->session->set_userdata('siteStatus',$armDisarmStatusList['monitoringstatus']['status']);
			return $history;
		}
	}
	public function getSiteStatus(){
		$status = $this->getStatus();
		$str ="";
		$this->session->set_userdata('siteStatus',$status);
		if($status==0 || $status == 4){
			$str ='<div class="switchBlock">
					<label class="switch"><input data-status="'.$status.'" type="checkbox" checked=""><span class="slider round"></span></label>
				</div>';
		}else{
			$str ='<div class="switchBlock">
				<label class="switch"><input data-status="'.$status.'" type="checkbox" ><span class="slider round"></span></label>
			</div>';
		}
		echo $str;
	}
	public function armDisarmSite(){
		$data = json_decode($this->input->post('data'));
		$siteStatus = $this->session->userdata('siteStatus');
		$selectedSiteData = $this->session->userdata('USER_SELECTED_SITE');
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('ARM_DISARM_ACTION_API');
		$source =  $this->session->userdata('source');
		
		if($siteStatus == 0 || $siteStatus == 4)
		{
			$action = 'DEACTIVATE';
			$msg='Disarming the site until next scheduled monitoring hours';
		}else
		{
			$action = 'ACTIVATE';
			$msg='Arming the site until next scheduled monitoring hours';
		}
		$potentialId =  $selectedSiteData['potentialId'];
		$user = $this->session->userdata('userName');
		$sitename = $selectedSiteData['siteName'];
		//$req_source = 'mobile';
		$req_source = SOURCE;
		$messageText = $data->msg;
		if($source=='IVigil')
		{
			$deviceId = 'Portal'; 
			$data = array("action"=>$action, "potentialId"=>$potentialId,"deviceId"=>$deviceId,"sitename"=>$sitename, "source"=>$req_source, "messageText"=>$messageText, "user" => $user,"from"=>APISOURCE);
		}else{
			$deviceId = $user;
			$data = array("action"=>$action, "potentialId"=>$potentialId,"deviceId"=>$deviceId,"sitename"=>$sitename, "source"=>$req_source, "messageText"=>$messageText, "user" => $user);
		}
		
		$armDisarmStatusList = $this->Api_model->armDisarmSite($apiEndPoint,$data);
		
		if($armDisarmStatusList['status'] == 200){
			if($source=='IVigil')
			{
				//$status = $this->getStatus();
				$historyMain = $this->getHistory();
				$status = $this->session->userdata('siteStatus');
				$history = (isset($historyMain[0]))?$historyMain[0]:[];
			}else{
				$status = $armDisarmStatusList['monitoringstatus']['status'];
				$history = array();
				if(!empty($armDisarmStatusList['armDisArmHistory']))
				$history = $armDisarmStatusList['armDisArmHistory'][0];
			$apiurl = $armDisarmStatusList['APIURL'];
			}

			$lastArmDisarmBy = array();
			if(!empty($history)){
				if($history['eventType'] == 'ACTIVATE'){
					$lastArmDisarmBy['title'] = "LAST ARMED BY ";
				}else{
					$lastArmDisarmBy['title'] = "LAST DISARMED BY ";
				}
				$lastArmDisarmBy['name'] = $history['userId'];
			}
			$this->session->set_userdata('siteStatus',$status);
			$this->session->set_userdata('history',$lastArmDisarmBy);
			echo json_encode(array('title' => 'Alert', 'message' => $msg, 'siteStatus'=>$status, 'status'=>'Success', 'history' => json_encode($lastArmDisarmBy)));
		}else{
			echo json_encode(array('status'=>'Failed','title' => 'Error', 'message' => $armDisarmStatusList['message']));
		}
	}
	public function checkingPreConditions(){
		$siteStatus = $this->session->userdata('siteStatus');
		$selectedSiteData = $this->session->userdata('USER_SELECTED_SITE');
		/* echo "<pre>";
		print_r($selectedSiteData);
		echo "<pre>"; */
		/**
		 * checking the site status if already admin changed starts here 
		 */
		$status = $this->getStatus();
		if ($status != $siteStatus) {
			$label = ($status == 0 || $status == 4) ? 'ARMED' : 'DISARMED';
		   $msg = "The site is already $label by Admin.";
		   $siteStatus = $this->session->set_userdata('siteStatus',$status);
		   echo json_encode(array('title' => 'Alert', 'message' => $msg, 'status'=>'Failed'));
		   exit;
		}
	/**
	 * checking the site status if already admin changed ends here 
	 */
	/**
	 * checking the upcoming PSA starts here
	 */
		$psaList = $this->getSitePSAList();
		if(!empty($psaList)){
			$upcomingPSA = $psaList[0];
			$psaStartDate = dateConvertByTimeZone($upcomingPSA['StartDateTime'], 'UTC', 'CST', 'Y-m-d H:i:s');
			$myDateTime = getDateParametersByTimeZone($selectedSiteData['timezone']);
			$currentDate = date('Y-m-d H:i:s',strtotime($myDateTime['currentTime']));
			$from_time = strtotime($psaStartDate);
			$to_time = strtotime($currentDate);
			$diff = round(($from_time - $to_time) / 60);
			if($diff< 60 && $diff>0){
				$msg = "There is upcoming PSA in $diff mins,Site will be disarmed in $diff mins";
				echo json_encode(array('title' => 'Alert', 'message' => $msg, 'status'=>'Failed'));
				exit;
			}
			
		}
	 /**
	  * checking the upcoming PSA ends here
	  */
	 echo json_encode(array('title' => 'Alert', 'message' => "", 'status'=>'Success'));

	}
	public function getSitePSAList()
    {
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$accountId = $userSelectedSite['sfaccountId'];
		$fromDt = date("Y-m-d");
		$todate = date("Y-m-d", strtotime("+1 day"));

		$params = array("accountid"=>$accountId,"FromDate"=>$fromDt,"ToDate"=>$todate);
		$psaList = $this->Api_model->getSitePSAList(PSA_LIST_API,$params);
	
		$tmpArry= array();
        if($psaList['status']=="200" && $psaList['message']=="Success")
        {
			$events = $psaList['events'];
			if(!empty($events))
			{
				foreach($events as $event)
				{
				   if($event['PSA_Cancelled__c']!='true')
				   {
						array_push($tmpArry, $event);
				   }
				}
			}
			return $tmpArry;
		}
		return $tmpArry;
	}
	public function getArmDisarmHistory($selectedSiteData){
		$siteName = $selectedSiteData['siteName'];
		$potentialId = $selectedSiteData['potentialId'];
		$toDate = date('m/d/Y');
		$fromDate = date('m/d/Y', strtotime("-2 day"));
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('ARM_DISARM_STATUS_API');
		$source =  $this->session->userdata('source');
		if($source=='IVigil')
		{
			$data = array("event"=>'MonitoringStatus', "potentialId"=>$potentialId,"from"=>APISOURCE);
		}else{
			$data = array("fdate"=>$fromDate, "tdate"=>$toDate,"sitename"=>$siteName,"event"=>"MonitoringStatus", "potentialid"=>$potentialId);
		}
		
		$armDisarmStatusList = $this->Api_model->getSiteStatus($apiEndPoint,$data);
	}
}
