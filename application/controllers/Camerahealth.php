<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Camerahealth extends CI_Controller {

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
		$this->load->model('Netalytics_model');
		
    } 


	public function index()
	{
		$data['title']="Equipment Health";
		$potentialListData = $this->session->userdata('USER_SELECTED_SITE');
		
		$siteName = $potentialListData['unitId'];

		//$siteName = "F1016";
		$data = array("siteName"=>$siteName);
		$params = json_encode($data);
		
		//$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('CAMERA_HEALTH_API');
		
		//$cameraHealthList = $this->Netalytics_model->getSiteDevicesList($apiEndPoint,$siteName);
		// echo "<pre>";
		// print_r($cameraHealthList);
		// die;
		$data['potentialList'] = $this->session->userdata('potentialList');
		//$data['cameraHealthList'] = $cameraHealthList;
		$data['selectedSite'] = $potentialListData;
		$this->home_template->load('home_template','camera_health',$data);    
		//$this->load->view('admin/dashboard',$data);   
	}
	public function getSiteCameraHelath()
	{
		$potentialListData = $this->session->userdata('USER_SELECTED_SITE');
		$siteName = $potentialListData['unitId'];
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('CAMERA_HEALTH_API');
		$cameraHealthList = $this->Netalytics_model->getSiteDevicesList($apiEndPoint,$siteName);
		
		if($cameraHealthList['status']=='ok' && !empty($cameraHealthList['msg']))
		{
			$str='';
			foreach($cameraHealthList['msg'] as $device)
			{
				$deviceSts = "unhealthy"; 
				if($device['status']=='1')
				{
					$deviceSts = "healthy"; 
				}
			?>
				<li class="<?php echo $deviceSts;?>">
				<div class="camera-icon">
				<img src="<?php echo base_url()?>assets/images/icons/cc-camera.png">											
				</div>
				<h3 class="ellipsisTxt" data-toggle="tooltip" data-placement="top" title="<?php echo $device['name'];?>"><?php echo $device['name'];?></h3>																		
			</li>
		<?php	}} else {?>
			<h5 class="grayText">No Results Found.</h5>
		<?php }
	}
}
