<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
        parent::__construct();
	   
		
	} 

	public function index(){
		$this->load->library(array('session_check','messages'));
		if(($this->session->userdata('user_type')!='') && ($this->session->userdata('id')!='')){
			$role = $this->session->userdata('user_type');
			if(($role == 'Administrator'))
			{
				redirect('administrator/dashboard');
			}
			if($role == 'User')
			{
				redirect('user/dashboard');
			}
		}
		else
		{
			redirect('login');
		}
		redirect('login');
	}


	
}
