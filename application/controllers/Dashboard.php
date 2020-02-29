<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$data['title']="Dashboard";
		$data['potentialList'] = $this->session->userdata('potentialList');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
			$history = $this->getHistory();	
			$lastArmDisarmBy = array();
			if(!empty($history)){
				if($history['eventType'] == 'ACTIVATE'){
					$lastArmDisarmBy['title'] = "LAST ARMED BY ";
				}else{
					$lastArmDisarmBy['title'] = "LAST DISARMED BY ";
				}
				$lastArmDisarmBy['name'] = $history['userId'];
			}
			
			$this->session->set_userdata('history',$lastArmDisarmBy);
		}
		$this->home_template->load('home_template','dashboard',$data);    
	}
	public function getHistory(){
		$selectedSiteData = $this->session->userdata('USER_SELECTED_SITE');
		$siteName = $selectedSiteData['siteName'];
		$potentialId = $selectedSiteData['potentialId'];
		$toDate = date('m/d/Y');
		$fromDate = date('m/d/Y', strtotime("-2 day"));
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('ARM_DISARM_STATUS_API');
		$source =  $this->session->userdata('source');
		$data = array("fdate"=>$fromDate, "tdate"=>$toDate,"sitename"=>$siteName,"event"=>"MonitoringStatus", "potentialid"=>$potentialId);
		$armDisarmStatusList = $this->Api_model->getSiteStatus($apiEndPoint,$data);
	
		if(!empty($armDisarmStatusList))
		{
			if($source=='IVigil')
			{
				if(isset($armDisarmStatusList['reverseEscalations']) && !empty($armDisarmStatusList['reverseEscalations'])){
					$history = $armDisarmStatusList['reverseEscalations'][0];
				}else{
					$history = [];
				}
				return $history;
			}else{
				$history = array();
				if(!empty($armDisarmStatusList['armDisArmHistory']))
				{
					$history = $armDisarmStatusList['armDisArmHistory'][0];
				}
			
				return $history;
			}
		}
		else
		{
			return $history = [];
		}
		
	}

	public function loadHistory(){
		$history = $this->getHistory();
	
		$lastArmDisarmBy = array();
		if(!empty($history)){
			if($history['eventType'] == 'ACTIVATE'){
				$lastArmDisarmBy['title'] = "LAST ARMED BY ";
			}else{
				$lastArmDisarmBy['title'] = "LAST DISARMED BY ";
			}
			$lastArmDisarmBy['name'] = $history['userId'];
		}
		$this->session->set_userdata('history',$lastArmDisarmBy);
		$str ='';
		$title='';
		$name='';
		if(!empty($history)){ $title = $lastArmDisarmBy['title']; }else{ $title = "No History"; }

		if(!empty($history)){ $name = $lastArmDisarmBy['name']; }else{ $name = 'FOUND'; } 
		$str .= '<p>'.$title.'</p>';
		$str .= '<h3>'.$name.'</h3>';
		echo $str;
	}
	
}
