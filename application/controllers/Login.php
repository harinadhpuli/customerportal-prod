<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	protected $isLogin;
	public function __construct(){
		parent::__construct();
		//$this->load->library(array('session','session_check','messages'));
		/*  */
		$this->load->model('Api_model');
		
    }

	public function index(){
               //echo $this->isLogin;
        /* $data['title']="Dashboard";
		if(($this->session->userdata('user_type')!='') && ($this->session->userdata('id')!='')){
			$role = $this->session->userdata('user_type');
			if(($role == 'Administrator'))
			{
				redirect('administrator/dashboard');
			}
			elseif($role == 'User')
			{
				redirect('user/dashboard');
			}
		} */
		$this->isLogin = loggedId();
		if($this->isLogin){
			redirect('dashboard');
		}
		$data['title']="Login";
		$this->load->view('login',$data);    
		   
	}


	public function userlogin(){
        if($this->input->post()){
			$this->form_validation->set_session_data($this->input->post());
			$this->form_validation->checkXssValidation($this->input->post());
            $this->form_validation->set_rules('username','text','required|trim');
            $this->form_validation->set_rules('password','password','required|trim');
            if($this->form_validation->run() === FALSE){   
				$this->messages->setMessageFront('Invalid username or password.','error');
                redirect('login');
                return FALSE;
            }else{
                $email = $this->input->post('username');
                $password = $this->input->post('password');
               
				
                //$userdata = $this->user_model->validate_user($email,$password);
				
				$userdata = $this->Api_model->doLogin($email,$password);
				$loggedUserId = session_id();
				
				/* echo "<pre>";
				print_r($userdata);
				die; */
               
                if($userdata){

					if($userdata['status']!="200"){
						$this->messages->setMessageFront("Invalid username or password",'error');
						redirect(base_url('login'));
					}else {	
							if($userdata['source']=="IVigil")
							{
								$loggedInUserData = $userdata;
								$loggedInUsername = $loggedInUserData['userName'];
								$apiEndPoint = 'https://workspace.pro-vigil.info:8443/ivigil-shield/UserLprSitesServlet';
								$params = array("action"=>"PotentialList","userName"=>$loggedInUsername);
								$lprList = $this->Api_model->getSiteLPRSites($apiEndPoint,$params);
								if(!empty($lprList))
								{
									if(isset($lprList['error']) && $lprList['error']!="")
									{
										$isAccountHasLPR = 0;
									}
									else
									{
										$isAccountHasLPR = 1;
									}
								}
								else
								{
									$isAccountHasLPR = 0;
								}
								
							}
							elseif($userdata['source']=="PVM")
							{
								$loggedInUserData = json_decode($userdata['data']['provigilUserData'],1);
								$loggedInUserData['source'] = $userdata['source'];
								$isAccountHasLPR = 0;
							}
						
							foreach($loggedInUserData as $row)
							{
								$data = array(
									'userId' => $loggedUserId,
									'userName' => $loggedInUserData['userName'],
									'userType' => $loggedInUserData['userType'],
									"potentialList" => $loggedInUserData['potentialList'],
									"source" => $loggedInUserData['source'],
									"isAccountHasLPR"=>$isAccountHasLPR,
									'is_login' => TRUE
								);
							}
							
							$this->session->set_userdata($data);
					
						$sitesCount = sizeof($loggedInUserData['potentialList']);
						if($sitesCount==1)
						{
							$userSiteData = $loggedInUserData['potentialList'][0];
							$this->session->set_userdata("USER_SELECTED_SITE",$userSiteData);
							$redirectLink = 'dashboard';
						}
						else
						{
							$redirectLink = 'usersites';
						}
						redirect(base_url() . $redirectLink);
					}
				}else{
                    $this->messages->setMessageFront('Invalid username or password.','error');
                    redirect(base_url('login'));
                }
            }           
        
        }else{
			$this->messages->setMessageFront('Invalid username or password.','error');
			redirect(base_url('login'));
		}
    }

	public function doLogout()
	{
		$array_items = array('id', 'user_type');
		/* $this->session->unset_userdata('id');
		$this->session->unset_userdata('user_type'); */
		//$this->session->unset_userdata($array_items);
		
		$this->session->sess_destroy();
		$this->messages->setMessageFront('You Have Logged Out Successfully.','success');
		redirect(base_url('login') );
	 }


	


	
}
