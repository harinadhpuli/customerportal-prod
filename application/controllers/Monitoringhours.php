<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoringhours extends CI_Controller {

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
		$data['title']="Monitoring Hours";
		$data['potentialList'] = $this->session->userdata('potentialList');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
			$data['timezone'] = $data['selectedSite']['timezone'];
		}
		$this->home_template->load('home_template','monitoring_hours',$data);  		   
	}
	
	public function getMonitoringHours(){
		
		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		$source =  $this->session->userdata('source');
		if(!empty($userSelectedSite))
		{
			$potentialId = $userSelectedSite['potentialId'];
			$timezone = $userSelectedSite['timezone'];
		}
		
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('MONITORING_HOURS_API');
		if($source=='IVigil')
		{
			$data = array("potentialId"=>$potentialId);
		}else{
			$data = array("action"=>"mhrs","installationid"=>$potentialId);
		}
		$monitoringHoursData = $this->Api_model->getSietMonitoringHours($apiEndPoint,$data);
		$response['monitoringHoursData'] = $monitoringHoursData;
		$response['source'] = $source;
		$str='';
		if($monitoringHoursData['status']== 200 && sizeof($monitoringHoursData['monitoringHours']) > 0 ){
			$tmp = array();
			$key=0;
			foreach($monitoringHoursData['monitoringHours'] as $device)
			{
				if($key>1){
					$key=0;
				}
				$tmp[$device['WeekofDay']][$key] = str_replace('-','- ',str_replace('AM','',str_replace('PM','',$device['MonitoringHours'])));	
				$key++;
			}
		}
		$str .='<div class="table-responsive"><table class="table custom-table">
					<thead>
						<tr>
							<th>Day</th>
							<th>24 Hours</th>';
			if(isset($tmp) && sizeof($tmp['Monday']) > 1){ 
				$str .='<th>Morning <span>Start to End Time</span></th>
						<th>Evening <span>Start to End Time</span></th>';
			}else{
				$str .='<th><span>Start to End Time</span></th>';
			}
			$str .='</tr></thead><tbody>';
			if($monitoringHoursData['status']== 200 && sizeof($monitoringHoursData['monitoringHours']) > 0 )
				{
													
					foreach($tmp as $key=>$dayValue)
					{	
						$twentyfourhours = "No";	
						$twentyfourflag = false;
					$str .='<tr>
						<td>'.$key.'</td>';
						if($source != 'IVigil'){ 
							$str.='<td>'.ucfirst(strtolower($monitoringHoursData['schedule'][0][$key])).'</td>';	
						}
						foreach($dayValue as $time){
							$startTime = explode('-',$time)[0];
							$endTime =  explode('-',$time)[1];
							
							if((trim($startTime) === '00:00' && trim($endTime) === '23:59') || (trim($startTime) === '00:00' && trim($endTime) === '11:59') || (trim($startTime) === '12:00' && trim($startTime) === '23:59')){
								$twentyfourhours =  'Yes';
							} 
							if(!$twentyfourflag && $source == 'IVigil'){
								$str .='<td>'.$twentyfourhours.'</td>';
								$twentyfourflag = true;	
							} if(sizeof($dayValue)>1){
							$str .= '<td>'.$time.'</td>';
							}else{
							$str .= '<td colspan="2">'.$time.'</td>';
						}}
					$str .='</tr>';
				 }
				} else {
						$str .='<tr>';
						if(isset($tmp) && sizeof($tmp['Monday']) > 1){
							$str .= '<td colspan="4" >No Monitoring Hours Available</td>';
						 }else{ 
							$str .= '<td colspan="3" >No Monitoring Hours Available</td>';
						 } 
						$str .= '</tr>';
				} 
			$str .='</tbody></table></div>';
			$title = "Monitoring & Additional Monitoring Hours (".$timezone.")";
			echo json_encode(array('title'=>$title,'data'=>$str));
			//echo $str;
		}
}