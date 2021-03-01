<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

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
		//redirect(CONFGI_SERVER_ROOT.'dashboard');
		redirect(base_url().'accessDenied');
		
		$data['title']="Ticket Creation";
		$data['potentialList'] = $this->session->userdata('potentialList');
		if(!empty($this->session->userdata('USER_SELECTED_SITE')))
		{
			$data['selectedSite'] = $this->session->userdata('USER_SELECTED_SITE');
		}
		$this->home_template->load('home_template','tickets',$data);    
	}
	public function getTickets()
	{
        $postData = json_decode($this->input->post('data'),1);
        $response = array();
        if(isset($postData['status']) && $postData['status']!="")
        {
            $status = $postData['status'];
        }
		$potentialListData = $this->session->userdata('USER_SELECTED_SITE');
		$accountId = $potentialListData['sfaccountId'];
		$installationId = $potentialListData['installationId'];
        $username = $this->session->userdata('userName');
        $userData = array("user_name"=>$username,"accountid"=>$accountId,"installationid"=>$installationId,"source"=>"Portal","status"=>$status);
        $params = json_encode($userData);

        $apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('TICKETS_API');
		$ticketsList = $this->Api_model->getUserTickets($apiEndPoint,$params);
	
		// $isDataExists = 1;
		// if(array_key_exists("msg",$ticketsList))
		// {
		// 	$isDataExists = 0;
		// }
	
		// echo "<pre>";
		// print_r($ticketsList);
		// die;
		$str='';
		
		if(!empty($ticketsList) && $ticketsList['status']=='Success')
		{
			foreach($ticketsList['tickets'] as $ticket)
			{
				$str.='';
				$str.='<div class="col-md-4 col-sm-6">';
				$str.='<div class="cardBox">';
				$str.='<div class="cardBox-heading">';
				$str.='<ul>';
				$str.='<li>Ticket Number<span>'.$ticket['ticket_number'].'</span></li>';
				$str.='<li>Status<span class="'.$ticket['status'].'-text">'.$ticket['status'].'</span></li>';
				if($status=="Closed")	
				{
					$tktDate = $ticket['closed_on'];
				}
				else{

					$tktDate = $ticket['created_on'];
				}
				$str.='<li>'.$status.' Date<span>'.convertDBDateFormat($tktDate).'</span></li>';
				$str.='<ul>';
				$str.='</div>';
				$str.='<p>'.$ticket['description'].'</p>';
				$str.='</div>';
				$str.='</div>';
			}
		}
		else
		{
			$str.='<h5 class="noticket">There are no tickets for this site</h5>';
		}
		echo $str;
	}
	public function createTicket()
	{
		$postData = json_decode($this->input->post('data'),1);
		$ticketDescription = trim($postData['description']);
		if($ticketDescription=="")
		{
			$response = array("error"=>"1","msg"=>"Ticket description should not be empty");
			echo json_encode($response);
			die;
		}
		$potentialListData = $this->session->userdata('USER_SELECTED_SITE');
		$accountId = $potentialListData['sfaccountId'];
		$installationId = $potentialListData['installationId'];
		$userName = $this->session->userdata('userName');
		$source="Portal";
		$ticketCreateData = array(
								"account" => $accountId,
								"installation" =>$installationId,
								"user_name" => $userName,
								"description"=>$ticketDescription,
								"source" => $source
							);
		$params = json_encode($ticketCreateData);
		$apiEndPoint=$this->api_endpoints->getAPIEndPointByUserSource('CREATE_TICKET_API');
		$apiResponse = $this->Api_model->createTicket($apiEndPoint,$params);
		
		if($apiResponse['status']=='Success')
		{
			$response = array("error"=>"0","msg"=>$apiResponse['msg']);
		}
		elseif($apiResponse['status']=='Failed')
		{
			$response = array("error"=>"1","msg"=>"Something went wrong, Please try again");
		}
		echo json_encode($response);
	}
}
