<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lpr extends CI_Controller {

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
		if($this->session->source=='IVigil' && $this->session->userdata('isAccountHasLPR')==1){
			//do nothing
		}else{
			redirect(base_url().'accessDenied');
			
		}
	} 
	public function index()
	{
		$data['title']="LPR";
		$loggedInUsername = $this->session->userdata('userName');
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('SITE_LPR_LIST_API');
		$source =  $this->session->userdata('source');
		$params = array("action"=>"PotentialList","userName"=>$loggedInUsername);
		$lprList = $this->Api_model->getSiteLPRSites($apiEndPoint,$params);
		
		$data['lprList'] = $lprList;
		$this->home_template->load('home_template','lpr',$data);  
    }
	public function getSiteLPRList()
	{
		$errMessage = '';
		$postData = json_decode($this->input->post('data'),1);
        $response = array();
		$mandatoryFields = array('fromdate','todate');

		foreach($mandatoryFields as $each){
			if(!isset($postData[$each])){
				$fieldname = ucwords(strtolower(str_replace("_", " ", $each)));
				$errMessage.="<li>Please Enter $fieldname</li>";
			}   
		}
		if($postData['potentialId']=="")
		{
			$response = array("error"=>"1", "msg"=>"Please select site");
			echo json_encode($response);
			die;
		}
		if($errMessage!='')
		{
			$res = array("error"=>"1","msg"=>$errMessage);	
			echo json_encode($res);
			exit;
		}
		$potentialId = $postData['potentialId'];
				
		$fromdate = convertdatetimepickerFormate($postData['fromdate']).':00';
		$todate = convertdatetimepickerFormate($postData['todate']).':59';
		
		$isvalidDates = compareDateRangeCondition($fromdate,$todate);
		if($isvalidDates==0)
		{
			$response = array("error"=>"1", "msg"=>"From Date should be less than are equalto To Date");
			echo json_encode($response);
			die;
		}
		
		$params = array("reportName"=>"potentialLprEvents","potentialId"=>$potentialId,"fromDate"=>$fromdate,"toDate"=>$todate);
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('LPR_DETAILS_API');
		
		
		$lprDetails = $this->Api_model->getSiteLPRDetails($apiEndPoint,$params);
		/* echo "<pre>";
		print_r($lprDetails);
		die; */
		$str='<div class="row">';
		if(!empty($lprDetails))
		{
			$LPR_DOWNLOAD_PDF_API=$this->api_endpoints->getAPIEndPointByUserSource('LPR_DOWNLOAD_PDF_API');
			foreach($lprDetails as $each)
			{
				$str.='<div class="col-md-3 col-sm-4">';
				$str.='<div class="cardBox">';
				$str.='<div class="numberlpr"><img src="'.$each['plateImage'].'"></div>';
				$str.='<p>'.$each['plateNumber'].'</p>';
				$str.='<p>'.convertDBDateFormat($each['dateTimeStr']).'</p>';
				$str.='<a target="new" href="https://workspace.pro-vigil.info:8443/ivigil-lpr/ExportPDFServlet?report=singleRowReport&template=singleRowReportLprInformation&id='.$each['id'].'">Download PDF</a>';
				$str.='</div></div>';
			}
			$dataexists = 0;
		}
		else
		{
			$dataexists = 1;
			$str.='<div class="col-md-12"><span class="grayText">No records are found!!</span></div>';
		}
		$str.='</div>';
		
		$response = array("error"=>0,"lprdata"=>$str);
		
		echo json_encode($response);
		//$response = $this->Api_model->executeCurlRequest($url,"GET",$params);
		
	}
	
}
