<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stats extends CI_Controller {

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
		
		$data['title']="Statistics";
		$data['potentialList'] = $this->session->userdata('potentialList');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
		
		$this->home_template->load('home_template','stats',$data);     
	}
	
	public function getStats()
	{
        $postData = json_decode($this->input->post('data'),1);
        $response = array();
        if(isset($postData['status']) && $postData['status']!="")
        {
            $status = $postData['status'];
		}
		if($status =='current'){
			$str = $this->getCurrentStats();
		}else if($status =='history'){
			$str = $this->getHistoryStats();
		}else if($status =='clips'){
			$str = $this->getClipsStats();
		}
		echo $str;
	}
	private function getCurrentStats(){

		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		if(!empty($userSelectedSite))
		{
			$potentialId = $userSelectedSite['potentialId'];
		}
		$source =  $this->session->userdata('source');
		if($source=='IVigil')
		{
			$data = array("action"=>"STATS","requestFrom"=>"mobileapp","potentialId"=>$potentialId, "device"=>"asd","date"=>date('Y-m'),"from"=>APISOURCE);
		}else{
			$data = array("requireddata"=>"current","installationid"=>$potentialId);
		}

		  $apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('STATS_API');
		  $StatsData = $this->Api_model->getStats($apiEndPoint,$data);
		  $str='';
		 if(!empty($StatsData) && $StatsData['status'] == 200){
			$Activites = $StatsData['SiteStatistics']['ActivitiesSeen'];
			$Alarms = $StatsData['SiteStatistics']['Outputs']; 
			$Thefts = $StatsData['SiteStatistics']['TheftsAverted'];
			$Arrests = $StatsData['SiteStatistics']['Arrests'];
			$Missed = $StatsData['SiteStatistics']['Missed'];
		 }else{
			$Activites = 0;
			$Alarms = 0;
			$Thefts = 0;
			$Arrests = 0;
			$Missed = 0;
		 }

			$str ='<div class="container">
			<div class="row">
				<div>
					<div class="col-md-12 site-data-view">								
						<ul>
							<li>
								<a href="javascript:void(0);">

								<div class="site-data-ui">
									<div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.151 29.623">
										<g id="Group_153" data-name="Group 153" transform="translate(-6204 1421)">
										<g id="Group_151" data-name="Group 151" transform="translate(6186.165 -1517.518)">
										<g id="Group_99" data-name="Group 99" transform="translate(17.835 96.518)">
										<path id="Path_97" data-name="Path 97" d="M20.306,96.518a2.48,2.48,0,0,0-2.471,2.468v3.176a.834.834,0,0,0,1.648,0V98.986c0-.6.224-.82.822-.82H48.518c.6,0,.82.222.82.82v18.455H19.483V106.393a.834.834,0,0,0-1.648,0h0v17.281a2.48,2.48,0,0,0,2.471,2.468H48.518a2.478,2.478,0,0,0,2.468-2.468V98.986a2.478,2.478,0,0,0-2.468-2.468Zm-.822,22.571H49.338v4.585a1.039,1.039,0,0,1-1.057,1.057H20.543a1.041,1.041,0,0,1-1.059-1.057Z" transform="translate(-17.835 -96.518)" fill="#16adf2"/>
										<path id="Path_98" data-name="Path 98" d="M113.129,489.414a2.125,2.125,0,0,0-1.989,1.411h-3.3a.706.706,0,0,0,0,1.411h3.3a2.11,2.11,0,0,0,3.979,0H129a.706.706,0,0,0,0-1.411H115.119A2.127,2.127,0,0,0,113.129,489.414Zm0,1.411a.706.706,0,1,1-.706.705A.695.695,0,0,1,113.129,490.825Z" transform="translate(-101.843 -466.137)" fill="#16adf2"/>
										<path id="Path_99" data-name="Path 99" d="M19.269,216.278a.705.705,0,0,1-.705.705h0a.705.705,0,0,1-.705-.705h0a.705.705,0,0,1,.705-.705h0a.705.705,0,0,1,.705.705Z" transform="translate(-17.857 -208.52)" fill="#16adf2"/>
										</g>
										<path id="Path_100" data-name="Path 100" d="M226.218,186.514v10.58a.705.705,0,0,0,1.067.6l8.818-5.29a.705.705,0,0,0,0-1.208l-8.818-5.29a.705.705,0,0,0-1.067.6Zm1.559,1.555,6.325,3.794-6.325,3.794Z" transform="translate(-196.038 -84.001)" fill="#16adf2"/>
										</g>
										<g id="Group_152" data-name="Group 152" transform="translate(6186.165 -1517.518)">
										<g id="Group_99-2" data-name="Group 99" transform="translate(17.835 96.518)">
										<path id="Path_97-2" data-name="Path 97" d="M20.306,96.518a2.48,2.48,0,0,0-2.471,2.468v3.176a.834.834,0,0,0,1.648,0V98.986c0-.6.224-.82.822-.82H48.518c.6,0,.82.222.82.82v18.455H19.483V106.393a.834.834,0,0,0-1.648,0h0v17.281a2.48,2.48,0,0,0,2.471,2.468H48.518a2.478,2.478,0,0,0,2.468-2.468V98.986a2.478,2.478,0,0,0-2.468-2.468Zm-.822,22.571H49.338v4.585a1.039,1.039,0,0,1-1.057,1.057H20.543a1.041,1.041,0,0,1-1.059-1.057Z" transform="translate(-17.835 -96.518)" fill="#16adf2"/>
										<path id="Path_98-2" data-name="Path 98" d="M113.129,489.414a2.125,2.125,0,0,0-1.989,1.411h-3.3a.706.706,0,0,0,0,1.411h3.3a2.11,2.11,0,0,0,3.979,0H129a.706.706,0,0,0,0-1.411H115.119A2.127,2.127,0,0,0,113.129,489.414Zm0,1.411a.706.706,0,1,1-.706.705A.695.695,0,0,1,113.129,490.825Z" transform="translate(-101.843 -466.137)" fill="#16adf2"/>
										<path id="Path_99-2" data-name="Path 99" d="M19.269,216.278a.705.705,0,0,1-.705.705h0a.705.705,0,0,1-.705-.705h0a.705.705,0,0,1,.705-.705h0a.705.705,0,0,1,.705.705Z" transform="translate(-17.857 -208.52)" fill="#16adf2"/>
										</g>
										<path id="Path_100-2" data-name="Path 100" d="M226.218,186.514v10.58a.705.705,0,0,0,1.067.6l8.818-5.29a.705.705,0,0,0,0-1.208l-8.818-5.29a.705.705,0,0,0-1.067.6Zm1.559,1.555,6.325,3.794-6.325,3.794Z" transform="translate(-196.038 -84.001)" fill="#16adf2"/>
										</g>
										</g>
										</svg></div>
									<h3>Activites</h3>	
									<h4 class="total-c">'.$Activites.'</h4>
								</div>
							</a>
							</li>

							<li>
								<a href="javascript:void(0);">
									<div class="site-data-ui">
										<div class="icon">		
											<svg class="alarmsActivated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.413 31.247">
											<path id="Path_135" data-name="Path 135" d="M7.291,121.83v-4.166a1.041,1.041,0,0,1,1.041-1.042H9.374v-6.249a8.333,8.333,0,1,1,16.665,0v6.249h1.042a1.042,1.042,0,0,1,1.042,1.042v4.166h6.249a1.042,1.042,0,0,1,0,2.083H1.042a1.042,1.042,0,0,1,0-2.083Zm16.665-11.457a6.249,6.249,0,1,0-12.5,0v6.249h12.5ZM9.374,121.83H26.039v-3.125H9.374Zm13.02-11.457a1.042,1.042,0,0,1-2.083,0,2.6,2.6,0,0,0-2.6-2.6,1.042,1.042,0,0,1,0-2.083A4.687,4.687,0,0,1,22.394,110.373Zm-5.729-12.5V93.708a1.042,1.042,0,1,1,2.083,0v4.166A1.042,1.042,0,1,1,16.665,97.874Zm9.143,2.924,2.946-2.946a1.042,1.042,0,1,1,1.473,1.473l-2.946,2.946A1.042,1.042,0,0,1,25.808,100.8ZM8.132,102.271,5.186,99.325a1.042,1.042,0,1,1,1.473-1.473L9.605,100.8A1.042,1.042,0,0,1,8.132,102.271Zm-2.924,7.06a1.042,1.042,0,0,1,0,2.083H1.042a1.042,1.042,0,0,1,0-2.083Zm29.164,0a1.042,1.042,0,0,1,0,2.083H30.205a1.042,1.042,0,1,1,0-2.083Z" transform="translate(0 -92.666)" fill="#16adf2"/>
											</svg>
										</div>
										<h3>Alarms Activated</h3>	
										<h4 class="events-c">'.$Alarms.'</h4>
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);">
									<div class="site-data-ui">
										<div class="icon">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.651 40.08">
											<g id="Group_154" data-name="Group 154" transform="translate(-47.741 -48.895)">
											<path id="Path_94" data-name="Path 94" d="M63.26,60.99c-1.287,1.388-2.541,1.236-2.826-.63h.191a18.17,18.17,0,0,0,2.635.63m2.628,0a18.17,18.17,0,0,0,2.635-.63h.191C68.429,62.226,67.176,62.378,65.888,60.99Zm-3.418,5.5c.192-.315,1.165-.446,2.136-.435.971-.011,1.945.121,2.136.435a9.114,9.114,0,0,1,.639,1.581,4.769,4.769,0,0,1-2.777.652,4.767,4.767,0,0,1-2.775-.649A9.142,9.142,0,0,1,62.47,66.488Zm2.136-4.348c.219.117,1.74.992,1.94,1.074,2.253.933,3.34-.241,3.739-2.655h.747c-.118.513.1.616.148.989a1.192,1.192,0,0,1-.527,1.318c-.065.343-.126.672-.169,1.021a2.318,2.318,0,0,1-.263,1.028c-.554.62-.977,1.139-1.347,1.594l-.586.7c.024-1.592-.532-2.724-3.44-2.143a1.271,1.271,0,0,1-.242.01,1.423,1.423,0,0,1-.242-.01c-2.911-.581-3.465.553-3.44,2.148l-.576-.695c-.372-.457-.8-.98-1.357-1.607a2.316,2.316,0,0,1-.262-1.03c-.043-.346-.1-.677-.168-1.019a1.192,1.192,0,0,1-.529-1.315c.049-.385.262-.5.148-.992h.746c.4,2.414,1.486,3.588,3.739,2.655C62.866,63.133,64.387,62.258,64.606,62.141Zm8.543-7.057a8.974,8.974,0,0,0-17.062,0h-.644V60.56h.418l.033.183A3.8,3.8,0,0,0,56.448,64,3.989,3.989,0,0,0,57.3,66.43c.494.552.917,1.073,1.287,1.527,1.937,2.385,2.8,3.047,6.018,3.034,3.232,0,4.078-.651,6.03-3.048.367-.451.787-.967,1.276-1.513A4,4,0,0,0,72.765,64a3.8,3.8,0,0,0,.555-3.254l.033-.184h.44V55.084h-.644Zm-2.435,0H58.521a6.707,6.707,0,0,1,12.193,0ZM64.563,84.2h2.806v1.086l2.359,1.421-10.318,0,2.344-1.412.008-1.091h2.8Zm12.443-10.49c1.322,1.11,2.109,2.809,2.109,5.38v2.832H50.056V79.089c0-2.572.787-4.27,2.109-5.38a10.564,10.564,0,0,1,5.2-2,7.671,7.671,0,0,0,2.626,1.737,14.351,14.351,0,0,0,9.207.012,7.511,7.511,0,0,0,2.623-1.748A10.569,10.569,0,0,1,77.006,73.709ZM74.874,59.178v2.277h4.24V72.574c-2.152-2.257-5.222-2.888-8.192-3.281a6.166,6.166,0,0,1-2.575,2.055,12.293,12.293,0,0,1-7.518-.012,6.214,6.214,0,0,1-2.588-2.042c-2.991.4-6.072,1.031-8.225,3.321V61.455h4.45V59.178H47.741V84.2H59.158l-3.444,2.073v2.7l17.7.006,0-2.707L69.974,84.2H81.392V59.178Zm-8.322,7.929h-3.89c0,.508.871.919,1.945.919S66.551,67.616,66.551,67.107Zm4.963-8.825H57.721v-.922H71.514Z" transform="translate(0 0)" fill="#16adf2"/>
											</g>
											</svg>
										</div>
										<h3>Thefts Averted</h3>	
										<h4 class="customer-c">'.$Thefts.'</h4>
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);">
									<div class="site-data-ui">
										<div class="icon">			
											<svg class="arrests" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36.267 34.924">
											<g id="Group_155" data-name="Group 155" transform="translate(-55.808 -104.702)">
											<g id="Group_157" data-name="Group 157">
											<path id="Path_89" data-name="Path 89" d="M66.554,219.207a6.7,6.7,0,0,1-.293-13.4l.024-.03h5.076l.011-.012a2.009,2.009,0,0,0,1.9-2V200.4a2.686,2.686,0,0,0-2.687-2.686H62.524a2.686,2.686,0,0,0-2.686,2.686v3.707a10.738,10.738,0,0,0,11.614,17.939,12,12,0,0,1-1.719-3.678A6.623,6.623,0,0,1,66.554,219.207Zm0-18.805a1.343,1.343,0,1,1-1.343,1.343A1.344,1.344,0,0,1,66.554,200.4Z" transform="translate(0 -86.297)" fill="#16adf2"/>
											<path id="Path_90" data-name="Path 90" d="M170.034,110.075h2.686a2.672,2.672,0,0,0,2.018-.935,2.672,2.672,0,0,0,2.018.935h2.686l.032,0a2.38,2.38,0,0,0-.032.31,2.694,2.694,0,0,0,2.686,2.687h2.686a2.686,2.686,0,0,0,0-5.373h-2.686l-.032,0a2.358,2.358,0,0,0,.032-.31,2.694,2.694,0,0,0-2.686-2.686h-2.686a2.672,2.672,0,0,0-2.018.935,2.674,2.674,0,0,0-2.018-.935h-2.686a2.686,2.686,0,1,0,0,5.373Zm14.781-1.036a1.343,1.343,0,0,1,0,2.686h-2.686a1.343,1.343,0,1,1,0-2.686Zm-8.059-2.994h2.686a1.343,1.343,0,0,1,0,2.686h-2.686a1.343,1.343,0,1,1,0-2.686Zm-6.721,0h2.686a1.343,1.343,0,0,1,0,2.686h-2.686a1.343,1.343,0,1,1,0-2.686Z" transform="translate(-103.486)" fill="#16adf2"/>
											<path id="Path_91" data-name="Path 91" d="M278.96,242.3a3.36,3.36,0,0,1-3.079,2.026h-.713a6.708,6.708,0,1,1-4.281-1.314l.024-.03h5.076l.011-.012a2.009,2.009,0,0,0,1.9-2v-3.358a2.686,2.686,0,0,0-2.686-2.686H267.15a2.686,2.686,0,0,0-2.686,2.686v3.707a10.75,10.75,0,1,0,14.5.983Zm-7.78-4.691a1.343,1.343,0,1,1-1.343,1.343A1.344,1.344,0,0,1,271.18,237.606Z" transform="translate(-189.851 -120.815)" fill="#16adf2"/>
											</g>
											</g>
											</svg>
										</div>
										<h3>Arrests</h3>	
										<h4 class="total-c">'.$Arrests.'</h4>
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);">
								<div class="site-data-ui">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.885 33.934">
										<g id="Group_156" data-name="Group 156" transform="translate(-101.197 -78.659)">
										<path id="Path_95" data-name="Path 95" d="M250.851,367.786a3.393,3.393,0,1,0-5.037,2.968l-.572,4.576a.325.325,0,0,0,.33.374h3.77a.325.325,0,0,0,.33-.374l-.572-4.576A3.391,3.391,0,0,0,250.851,367.786Z" transform="translate(-133.818 -267.636)" fill="#16adf2"/>
										<path id="Path_96" data-name="Path 96" d="M122.689,92.233h-1.131V86.577a7.918,7.918,0,1,0-15.836,0v.754a.378.378,0,0,0,.377.377h1.508a.378.378,0,0,0,.377-.377v-.754a5.656,5.656,0,0,1,11.311,0v5.656h-14.7a3.4,3.4,0,0,0-3.393,3.393V109.2a3.4,3.4,0,0,0,3.393,3.393h18.1a3.4,3.4,0,0,0,3.393-3.393V95.626A3.4,3.4,0,0,0,122.689,92.233ZM123.82,109.2a1.133,1.133,0,0,1-1.131,1.131h-18.1a1.133,1.133,0,0,1-1.131-1.131V95.626a1.133,1.133,0,0,1,1.131-1.131h18.1a1.132,1.132,0,0,1,1.131,1.131Z" fill="#16adf2"/>
										</g>
										</svg>
									</div>
									<h3>Missed</h3>
									<h4 class="customer-c">'.$Missed.'</h4>	
								</div>
							</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>';
		return $str;
	}
	private function getHistoryStats(){

		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		if(!empty($userSelectedSite))
		{
			$potentialId = $userSelectedSite['potentialId'];
		}
		$source =  $this->session->userdata('source');
		if($source=='IVigil')
		{
			$data = array("action"=>"STATS","requestFrom"=>"mobileapp","potentialId"=>$potentialId, "device"=>"asd","from"=>APISOURCE);
		}else{
			$data = array("requireddata"=>"history","installationid"=>$potentialId);
		}

		  $apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('STATS_API');
		  $StatsData = $this->Api_model->getStats($apiEndPoint,$data);
		  $str='';
		 if(!empty($StatsData) && $StatsData['status'] == 200){
			$Activites = $StatsData['SiteStatistics']['ActivitiesSeen'];
			$Alarms = $StatsData['SiteStatistics']['Outputs']; 
			$Thefts = $StatsData['SiteStatistics']['TheftsAverted'];
			$Arrests = $StatsData['SiteStatistics']['Arrests'];
			$Missed = $StatsData['SiteStatistics']['Missed'];
		 }else{
			$Activites = 0;
			$Alarms = 0;
			$Thefts = 0;
			$Arrests = 0;
			$Missed = 0;
		 }

			$str ='<div class="container">
			<div class="row">
				<div>
					<div class="col-md-12 site-data-view">								
						<ul>
							<li>
								<a href="javascript:void(0);">
								<div class="site-data-ui">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.151 29.623">
											<g id="Group_153" data-name="Group 153" transform="translate(-6204 1421)">
											<g id="Group_151" data-name="Group 151" transform="translate(6186.165 -1517.518)">
											<g id="Group_99" data-name="Group 99" transform="translate(17.835 96.518)">
											<path id="Path_97" data-name="Path 97" d="M20.306,96.518a2.48,2.48,0,0,0-2.471,2.468v3.176a.834.834,0,0,0,1.648,0V98.986c0-.6.224-.82.822-.82H48.518c.6,0,.82.222.82.82v18.455H19.483V106.393a.834.834,0,0,0-1.648,0h0v17.281a2.48,2.48,0,0,0,2.471,2.468H48.518a2.478,2.478,0,0,0,2.468-2.468V98.986a2.478,2.478,0,0,0-2.468-2.468Zm-.822,22.571H49.338v4.585a1.039,1.039,0,0,1-1.057,1.057H20.543a1.041,1.041,0,0,1-1.059-1.057Z" transform="translate(-17.835 -96.518)" fill="#16adf2"/>
											<path id="Path_98" data-name="Path 98" d="M113.129,489.414a2.125,2.125,0,0,0-1.989,1.411h-3.3a.706.706,0,0,0,0,1.411h3.3a2.11,2.11,0,0,0,3.979,0H129a.706.706,0,0,0,0-1.411H115.119A2.127,2.127,0,0,0,113.129,489.414Zm0,1.411a.706.706,0,1,1-.706.705A.695.695,0,0,1,113.129,490.825Z" transform="translate(-101.843 -466.137)" fill="#16adf2"/>
											<path id="Path_99" data-name="Path 99" d="M19.269,216.278a.705.705,0,0,1-.705.705h0a.705.705,0,0,1-.705-.705h0a.705.705,0,0,1,.705-.705h0a.705.705,0,0,1,.705.705Z" transform="translate(-17.857 -208.52)" fill="#16adf2"/>
											</g>
											<path id="Path_100" data-name="Path 100" d="M226.218,186.514v10.58a.705.705,0,0,0,1.067.6l8.818-5.29a.705.705,0,0,0,0-1.208l-8.818-5.29a.705.705,0,0,0-1.067.6Zm1.559,1.555,6.325,3.794-6.325,3.794Z" transform="translate(-196.038 -84.001)" fill="#16adf2"/>
											</g>
											<g id="Group_152" data-name="Group 152" transform="translate(6186.165 -1517.518)">
											<g id="Group_99-2" data-name="Group 99" transform="translate(17.835 96.518)">
											<path id="Path_97-2" data-name="Path 97" d="M20.306,96.518a2.48,2.48,0,0,0-2.471,2.468v3.176a.834.834,0,0,0,1.648,0V98.986c0-.6.224-.82.822-.82H48.518c.6,0,.82.222.82.82v18.455H19.483V106.393a.834.834,0,0,0-1.648,0h0v17.281a2.48,2.48,0,0,0,2.471,2.468H48.518a2.478,2.478,0,0,0,2.468-2.468V98.986a2.478,2.478,0,0,0-2.468-2.468Zm-.822,22.571H49.338v4.585a1.039,1.039,0,0,1-1.057,1.057H20.543a1.041,1.041,0,0,1-1.059-1.057Z" transform="translate(-17.835 -96.518)" fill="#16adf2"/>
											<path id="Path_98-2" data-name="Path 98" d="M113.129,489.414a2.125,2.125,0,0,0-1.989,1.411h-3.3a.706.706,0,0,0,0,1.411h3.3a2.11,2.11,0,0,0,3.979,0H129a.706.706,0,0,0,0-1.411H115.119A2.127,2.127,0,0,0,113.129,489.414Zm0,1.411a.706.706,0,1,1-.706.705A.695.695,0,0,1,113.129,490.825Z" transform="translate(-101.843 -466.137)" fill="#16adf2"/>
											<path id="Path_99-2" data-name="Path 99" d="M19.269,216.278a.705.705,0,0,1-.705.705h0a.705.705,0,0,1-.705-.705h0a.705.705,0,0,1,.705-.705h0a.705.705,0,0,1,.705.705Z" transform="translate(-17.857 -208.52)" fill="#16adf2"/>
											</g>
											<path id="Path_100-2" data-name="Path 100" d="M226.218,186.514v10.58a.705.705,0,0,0,1.067.6l8.818-5.29a.705.705,0,0,0,0-1.208l-8.818-5.29a.705.705,0,0,0-1.067.6Zm1.559,1.555,6.325,3.794-6.325,3.794Z" transform="translate(-196.038 -84.001)" fill="#16adf2"/>
											</g>
											</g>
										</svg>
									</div>
									<h3>Activites</h3>	
									<h4 class="total-c">'.$Activites.'</h4>
								</div>
							</a>
							</li>
							<li>
								<a href="javascript:void(0);">
								<div class="site-data-ui">
									<div class="icon">		
										<svg class="alarmsActivated" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.413 31.247">
										<path id="Path_135" data-name="Path 135" d="M7.291,121.83v-4.166a1.041,1.041,0,0,1,1.041-1.042H9.374v-6.249a8.333,8.333,0,1,1,16.665,0v6.249h1.042a1.042,1.042,0,0,1,1.042,1.042v4.166h6.249a1.042,1.042,0,0,1,0,2.083H1.042a1.042,1.042,0,0,1,0-2.083Zm16.665-11.457a6.249,6.249,0,1,0-12.5,0v6.249h12.5ZM9.374,121.83H26.039v-3.125H9.374Zm13.02-11.457a1.042,1.042,0,0,1-2.083,0,2.6,2.6,0,0,0-2.6-2.6,1.042,1.042,0,0,1,0-2.083A4.687,4.687,0,0,1,22.394,110.373Zm-5.729-12.5V93.708a1.042,1.042,0,1,1,2.083,0v4.166A1.042,1.042,0,1,1,16.665,97.874Zm9.143,2.924,2.946-2.946a1.042,1.042,0,1,1,1.473,1.473l-2.946,2.946A1.042,1.042,0,0,1,25.808,100.8ZM8.132,102.271,5.186,99.325a1.042,1.042,0,1,1,1.473-1.473L9.605,100.8A1.042,1.042,0,0,1,8.132,102.271Zm-2.924,7.06a1.042,1.042,0,0,1,0,2.083H1.042a1.042,1.042,0,0,1,0-2.083Zm29.164,0a1.042,1.042,0,0,1,0,2.083H30.205a1.042,1.042,0,1,1,0-2.083Z" transform="translate(0 -92.666)" fill="#16adf2"/>
										</svg>
									</div>
									<h3>Alarms Activated</h3>	
									<h4 class="events-c">'.$Alarms.'</h4>
								</div>
							</a>
							</li>
							<li>
								<a href="javascript:void(0);">
								<div class="site-data-ui">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 33.651 40.08">
										<g id="Group_154" data-name="Group 154" transform="translate(-47.741 -48.895)">
										<path id="Path_94" data-name="Path 94" d="M63.26,60.99c-1.287,1.388-2.541,1.236-2.826-.63h.191a18.17,18.17,0,0,0,2.635.63m2.628,0a18.17,18.17,0,0,0,2.635-.63h.191C68.429,62.226,67.176,62.378,65.888,60.99Zm-3.418,5.5c.192-.315,1.165-.446,2.136-.435.971-.011,1.945.121,2.136.435a9.114,9.114,0,0,1,.639,1.581,4.769,4.769,0,0,1-2.777.652,4.767,4.767,0,0,1-2.775-.649A9.142,9.142,0,0,1,62.47,66.488Zm2.136-4.348c.219.117,1.74.992,1.94,1.074,2.253.933,3.34-.241,3.739-2.655h.747c-.118.513.1.616.148.989a1.192,1.192,0,0,1-.527,1.318c-.065.343-.126.672-.169,1.021a2.318,2.318,0,0,1-.263,1.028c-.554.62-.977,1.139-1.347,1.594l-.586.7c.024-1.592-.532-2.724-3.44-2.143a1.271,1.271,0,0,1-.242.01,1.423,1.423,0,0,1-.242-.01c-2.911-.581-3.465.553-3.44,2.148l-.576-.695c-.372-.457-.8-.98-1.357-1.607a2.316,2.316,0,0,1-.262-1.03c-.043-.346-.1-.677-.168-1.019a1.192,1.192,0,0,1-.529-1.315c.049-.385.262-.5.148-.992h.746c.4,2.414,1.486,3.588,3.739,2.655C62.866,63.133,64.387,62.258,64.606,62.141Zm8.543-7.057a8.974,8.974,0,0,0-17.062,0h-.644V60.56h.418l.033.183A3.8,3.8,0,0,0,56.448,64,3.989,3.989,0,0,0,57.3,66.43c.494.552.917,1.073,1.287,1.527,1.937,2.385,2.8,3.047,6.018,3.034,3.232,0,4.078-.651,6.03-3.048.367-.451.787-.967,1.276-1.513A4,4,0,0,0,72.765,64a3.8,3.8,0,0,0,.555-3.254l.033-.184h.44V55.084h-.644Zm-2.435,0H58.521a6.707,6.707,0,0,1,12.193,0ZM64.563,84.2h2.806v1.086l2.359,1.421-10.318,0,2.344-1.412.008-1.091h2.8Zm12.443-10.49c1.322,1.11,2.109,2.809,2.109,5.38v2.832H50.056V79.089c0-2.572.787-4.27,2.109-5.38a10.564,10.564,0,0,1,5.2-2,7.671,7.671,0,0,0,2.626,1.737,14.351,14.351,0,0,0,9.207.012,7.511,7.511,0,0,0,2.623-1.748A10.569,10.569,0,0,1,77.006,73.709ZM74.874,59.178v2.277h4.24V72.574c-2.152-2.257-5.222-2.888-8.192-3.281a6.166,6.166,0,0,1-2.575,2.055,12.293,12.293,0,0,1-7.518-.012,6.214,6.214,0,0,1-2.588-2.042c-2.991.4-6.072,1.031-8.225,3.321V61.455h4.45V59.178H47.741V84.2H59.158l-3.444,2.073v2.7l17.7.006,0-2.707L69.974,84.2H81.392V59.178Zm-8.322,7.929h-3.89c0,.508.871.919,1.945.919S66.551,67.616,66.551,67.107Zm4.963-8.825H57.721v-.922H71.514Z" transform="translate(0 0)" fill="#16adf2"/>
										</g>
										</svg>
									</div>
									<h3>Thefts Averted</h3>	
									<h4 class="customer-c">'.$Thefts.'</h4>
								</div>
							</a>
							</li>
							<li>
								<a href="javascript:void(0);">
									<div class="site-data-ui">
										<div class="icon">			
											<svg class="arrests" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36.267 34.924">
												<g id="Group_155" data-name="Group 155" transform="translate(-55.808 -104.702)">
												<g id="Group_157" data-name="Group 157">
												<path id="Path_89" data-name="Path 89" d="M66.554,219.207a6.7,6.7,0,0,1-.293-13.4l.024-.03h5.076l.011-.012a2.009,2.009,0,0,0,1.9-2V200.4a2.686,2.686,0,0,0-2.687-2.686H62.524a2.686,2.686,0,0,0-2.686,2.686v3.707a10.738,10.738,0,0,0,11.614,17.939,12,12,0,0,1-1.719-3.678A6.623,6.623,0,0,1,66.554,219.207Zm0-18.805a1.343,1.343,0,1,1-1.343,1.343A1.344,1.344,0,0,1,66.554,200.4Z" transform="translate(0 -86.297)" fill="#16adf2"/>
												<path id="Path_90" data-name="Path 90" d="M170.034,110.075h2.686a2.672,2.672,0,0,0,2.018-.935,2.672,2.672,0,0,0,2.018.935h2.686l.032,0a2.38,2.38,0,0,0-.032.31,2.694,2.694,0,0,0,2.686,2.687h2.686a2.686,2.686,0,0,0,0-5.373h-2.686l-.032,0a2.358,2.358,0,0,0,.032-.31,2.694,2.694,0,0,0-2.686-2.686h-2.686a2.672,2.672,0,0,0-2.018.935,2.674,2.674,0,0,0-2.018-.935h-2.686a2.686,2.686,0,1,0,0,5.373Zm14.781-1.036a1.343,1.343,0,0,1,0,2.686h-2.686a1.343,1.343,0,1,1,0-2.686Zm-8.059-2.994h2.686a1.343,1.343,0,0,1,0,2.686h-2.686a1.343,1.343,0,1,1,0-2.686Zm-6.721,0h2.686a1.343,1.343,0,0,1,0,2.686h-2.686a1.343,1.343,0,1,1,0-2.686Z" transform="translate(-103.486)" fill="#16adf2"/>
												<path id="Path_91" data-name="Path 91" d="M278.96,242.3a3.36,3.36,0,0,1-3.079,2.026h-.713a6.708,6.708,0,1,1-4.281-1.314l.024-.03h5.076l.011-.012a2.009,2.009,0,0,0,1.9-2v-3.358a2.686,2.686,0,0,0-2.686-2.686H267.15a2.686,2.686,0,0,0-2.686,2.686v3.707a10.75,10.75,0,1,0,14.5.983Zm-7.78-4.691a1.343,1.343,0,1,1-1.343,1.343A1.344,1.344,0,0,1,271.18,237.606Z" transform="translate(-189.851 -120.815)" fill="#16adf2"/>
												</g>
												</g>
											</svg>
										</div>
										<h3>Arrests</h3>	
										<h4 class="total-c">'.$Arrests.'</h4>
									</div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0);">
								<div class="site-data-ui">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.885 33.934">
										<g id="Group_156" data-name="Group 156" transform="translate(-101.197 -78.659)">
										<path id="Path_95" data-name="Path 95" d="M250.851,367.786a3.393,3.393,0,1,0-5.037,2.968l-.572,4.576a.325.325,0,0,0,.33.374h3.77a.325.325,0,0,0,.33-.374l-.572-4.576A3.391,3.391,0,0,0,250.851,367.786Z" transform="translate(-133.818 -267.636)" fill="#16adf2"/>
										<path id="Path_96" data-name="Path 96" d="M122.689,92.233h-1.131V86.577a7.918,7.918,0,1,0-15.836,0v.754a.378.378,0,0,0,.377.377h1.508a.378.378,0,0,0,.377-.377v-.754a5.656,5.656,0,0,1,11.311,0v5.656h-14.7a3.4,3.4,0,0,0-3.393,3.393V109.2a3.4,3.4,0,0,0,3.393,3.393h18.1a3.4,3.4,0,0,0,3.393-3.393V95.626A3.4,3.4,0,0,0,122.689,92.233ZM123.82,109.2a1.133,1.133,0,0,1-1.131,1.131h-18.1a1.133,1.133,0,0,1-1.131-1.131V95.626a1.133,1.133,0,0,1,1.131-1.131h18.1a1.132,1.132,0,0,1,1.131,1.131Z" fill="#16adf2"/>
										</g>
										</svg>
									</div>
									<h3>Missed</h3>
									<h4 class="customer-c">'.$Missed.'</h4>	
								</div>
							</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>';
		return $str;
	}
	private function getClipsStats(){

		$userSelectedSite = $this->session->userdata('USER_SELECTED_SITE');
		if(!empty($userSelectedSite))
		{
			$potentialId = $userSelectedSite['potentialId'];
		}
		$source =  $this->session->userdata('source');
		if($source=='IVigil')
		{
			$data = array("action"=>"clips","requestFrom"=>"mobileapp","potentialId"=>$potentialId, "device"=>"asd","date"=>date('Y-m'));
		}else{
			$data = array("requireddata"=>"clips","installationid"=>$potentialId);
		}

		  $apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('STATS_API');
		  $StatsData = $this->Api_model->getStats($apiEndPoint,$data);
		//   echo "<pre>";
		//   print_r($StatsData);
		//   die;
		  $str='';
		 if(!empty($StatsData) && $StatsData['status'] == 200 && sizeof($StatsData['clips']) > 0){
			$videoFalg = false; 
			$str = '<div class="container">
			 			<div class="row">
				 			<div>';
			 foreach($StatsData['clips'] as $eachClip){
				 $thumbImage = ($eachClip['thumbnailUrl'])?$eachClip['thumbnailUrl']: base_url('assets/images/slide/v6/1.jpg');
				 $ext = pathinfo($eachClip['clipUrl'], PATHINFO_EXTENSION);
				 if($ext != 'mov'){
					$videoFalg = true;
					$str .='<div class="col-lg-4 col-md-4">	
					<a href="javascript:void(0)" class="clip" data-url="'.$eachClip['clipUrl'].'">
					   <div class="clipsCard">
						   <img src="'.$thumbImage.'">
							   <div class="clipsCard-text">
								   <h4>'.$eachClip['title'].'</h4>
								   <h5>'.convertDBDateFormat($eachClip['eventTime']).'</h5>
							   </div>
					   </div>	
				   </a>
				   </div>';
				 }
			 }
			 if(!$videoFalg){
				$str .= '<h5 center="grayText">No Clips Available.</h5>';
			 }
			$str .= '</div></div></div>';
		 }else{
			$str ='<div class="container">
			<div class="row">
				<div>
					<h5 class="grayText">No Clips Available.</h5>
				</div>
			</div>
		</div>';
		 }
		return $str;
	}
}
