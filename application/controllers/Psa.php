<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Psa extends CI_Controller {

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
		if($this->session->source=='IVigil'){
			//do nothing
		}else{
			redirect(base_url().'accessDenied');
			
		}
		
    } 


	public function index()
	{
		$data['title']="PSA List";
		$data['potentialList'] = $this->session->userdata('potentialList');
		$source=$this->session->userdata('source');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
		// echo "<pre>";
		// print_r($data['selectedSite']);
		// die;
		$this->home_template->load('home_template','psa',$data);    
	}
    public function getSitePSAList()
    {
		$postData = json_decode($this->input->post('data'),1);
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$accountId = $userSelectedSite['sfaccountId'];
		if($postData['fromdate']=="")
		{
			$fromDt = date("Y-m-d", strtotime("-30 days"));
		}
		else
		{
			$fromDt = convertdatepickerFormate($postData['fromdate']);
		}
		if($postData['todate']=="")
		{
			$todate = date("Y-m-d");
		}
		else
		{
			$todate = convertdatepickerFormate($postData['todate']);
		}
		$isvalidDates = compareDateRangeCondition($fromDt,$todate); 
		
		if($isvalidDates==0)
		{
			$response = array("error"=>"1", "msg"=>"From Date should be less than are equal to To Date");
			echo json_encode($response);
			die;
		}

		$params = array("accountid"=>$accountId,"FromDate"=>$fromDt,"ToDate"=>$todate);
		$psaList = $this->Api_model->getSitePSAList(PSA_LIST_API,$params);
		
		// echo "<pre>";
		// print_r($psaList);
		// die;
	
		$str='';
		
        if($psaList['status']=="200" && $psaList['message']=="Success")
        {
			$events = $psaList['events'];
			if(!empty($events))
			{
				foreach($events as $event)
				{
					$action = "Arm";
					$actionCls = "armAction";
				   if($event['PSA_Cancelled__c']!='true')
				   {
					
						// echo $event['StartDateTime'];
						// echo $event['StartDateTime'];
						//$siteTimezone = $userSelectedSite['timezone'];
						$currentSiteTimeArr = getDateParametersByTimeZone($userSelectedSite['timezone']);
						$siteTimezone = $currentSiteTimeArr['displayCode'];
						$psaCreatedDate = dateConvertByTimeZone($event['CreatedDate'], 'UTC', $siteTimezone, 'Y-m-d H:i:s');
						//$psaCreatedDate = dateConvertByTimeZone($event['CreatedDate'], 'UTC', 'CST', 'Y-m-d H:i:s');
						$psaStartDate = dateConvertByTimeZone($event['StartDateTime'], 'UTC', 'CST', 'Y-m-d H:i:s');
						$psaEndDate = dateConvertByTimeZone($event['EndDateTime'], 'UTC', 'CST', 'Y-m-d H:i:s');
						
						$str.='<tr>';
						$str.='<td>'.ucfirst($event['PSA_Requested_by__c']).'</td>';
					
						$str.='<td>'.convertDBDateFormat($psaCreatedDate).'</td>';
						$str.='<td>'.convertDBDateFormat($psaStartDate).'</td>';
						$str.='<td>'.convertDBDateFormat($psaEndDate).'</td>';
					
						if($event['Disable_Alarm__c']==true)
						{
							$action = "Disarm";
							$actionCls = "disarmAction";
						}
						$str.='<td><span class="'.$actionCls.'">'.$action.'</span></td>';
						$str.='<td><button  data-description="'.str_replace('"',"'",$event['Subject']).'" class="psaDescription"><span data-toggle="tooltip" data-placement="top" title="Description"><i class="fa fa-file-text-o" aria-hidden="true"></i></span></button><button data-eventId="'.$event['Id'].'" class="deletePSA" data-toggle="tooltip" data-placement="top" title="Delete PSA"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>';
						$str.='</tr>';
				   }
				   
				}
				//echo $str;die;
			}
		}
		
		if($str=="")
		{
			$str = '<tr><td colspan="6" align="center">No records are found.</td></tr>';
		}
		
		$response = array("error"=>"0","msg"=>$str);
		echo json_encode($response);
		
	}
	public function deletePSA()
	{
		$postData = json_decode($this->input->post('data'),1);
		$eventId = $postData['eventId'];
		$params = array("eventid"=>$eventId);
		$apiResponse = $this->Api_model->getSitePSAList(DELETE_PSA_API,$params);
		//$apiResponse = array("message"=>"Success","status"=>"200");
		if($apiResponse['message']=='Success' && $apiResponse['status']=="200")
		{
			$response = array("error"=>"0","msg"=>"PSA has been deleted successfully");
		}
		elseif($apiResponse['message']!='Success')
		{
			$response = array("error"=>"1","msg"=>"Something went wrong, Please try again");
		}
		echo json_encode($response);
	}
	public function createPSA()
	{
		$data['title']="Create PSA";
		$data['potentialList'] = $this->session->userdata('potentialList');
		$source=$this->session->userdata('source');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
		
		$this->home_template->load('home_template','create_psa',$data);    
	}
	public function savePSA()
	{
		$errMessage = '';
		$postData = json_decode($this->input->post('data'),1);
		$mandatoryFields = array('description','startDate','endDate');

		foreach($mandatoryFields as $each){
			if(!isset($postData[$each])){
				$fieldname = ucwords(strtolower(str_replace("_", " ", $each)));
				$errMessage.="<li>Please Enter $fieldname</li>";
			}   
		}
	
		foreach ($postData as $fieldname => $fieldValue){	
			if (empty($fieldValue) && in_array($fieldname,$mandatoryFields)) {
			$fieldname = ucwords(strtolower(str_replace("_", " ", $fieldname)));
			$errMessage .= "<li>Please Enter $fieldname</li>";
			}
		}

		if($errMessage!='')
		{
			$res = array("error"=>"1","msg"=>$errMessage);	
			echo json_encode($res);
			exit;
		}

		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$accountId = $userSelectedSite['sfaccountId'];
		
		$currentSiteTimeArr = getDateParametersByTimeZone($userSelectedSite['timezone']);
		
		$currentSiteTime = date('Y-m-d H:i',strtotime($currentSiteTimeArr['currentTime']));


		$psaStartDate = convertdatetimepickerFormate($postData['startDate']);
		$psaEndDate = convertdatetimepickerFormate($postData['endDate']);
		
		$psaStartTimeCon = dateDiffByTime($currentSiteTime,$psaStartDate,'Hours'); //getting diiference in minutes
		
		/** PSA should be created 2-hours from current time */ 
		if($psaStartTimeCon < PSA_MIN_FUTURE_TIME)
		{
			$response = array("error"=>"1", "msg"=>"PSA can be created only after 2-hours from current time");
			echo json_encode($response);
			die;
		}
		/** End  */

		$isvalidDates = compareDateRangeCondition($psaStartDate,$psaEndDate);
		$dateDiffVal = dateDiffByTime($psaStartDate,$psaEndDate,'Days');
				
		$isSameStartAndEndDateCon = dateDiffByTime($psaStartDate,$psaEndDate,'Hours');

		/*** Checking PSA start and End date & time validation and PSA duration should not exceeded 14 days */
		if($isSameStartAndEndDateCon<=0)
		{
			$response = array("error"=>"1", "msg"=>"PSA Start & End date and time should not be same.");
			echo json_encode($response);
			die;
		}
		elseif($isvalidDates==0)
		{
			$response = array("error"=>"1", "msg"=>"Start Date should be less than are equalto End Date");
			echo json_encode($response);
			die;
		}
		elseif($dateDiffVal > PSA_MAX_DURATION)
		{
			$response = array("error"=>"1", "msg"=>"PSA duration should not be exceeded maximum of ".PSA_MAX_DURATION." days");
			echo json_encode($response);
			die;
		}
		/** End  */

		$utcOffset = getUTCOffset_OOP(CONVERSIONTIMEZONE); // UTC to CT offset
		$description = $postData['description'];
		$startDate = str_replace(" ","T",$psaStartDate).''.$utcOffset;
		$endDate = str_replace(" ","T",$psaEndDate).''.$utcOffset;
		$requestedBy = $this->session->userdata('userName');

		$inputArr = array("endDateTime"=>$endDate,
						"psaRequestedBy"=>$requestedBy,
						"startDateTime"=>$startDate,
						"source"=>SOURCE,
						"subject"=>$description,
						"onDemandMonitoring"=>"false"
		);

		$params = json_encode($inputArr);
		$response = $this->Api_model->createPSA(CREATE_PSA_API,$accountId,$params);
	
		if(!empty($response) && $response['status']=="200")
		{
			$myDateTime = getDateParametersByTimeZone($userSelectedSite['timezone']);
    		$siteCurrentTime = date('m/d/Y H:i',strtotime('+2 hours',strtotime($myDateTime['currentTime'])));
			$res = array("error"=>0,"msg"=>"PSA has been created successfully","siteCurrentTime"=>$siteCurrentTime);
		}
		elseif($response['status']=="400")
		{
			$res = array("error"=>1,"msg"=>"PSA already exists");
		}
		else
		{
			$res = array("error"=>1,"msg"=>"Something went wrong, Try again");
		}
		echo json_encode($res);
	}
	
}
