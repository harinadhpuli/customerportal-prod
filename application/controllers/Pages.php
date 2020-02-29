<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

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
		$data['title']="Pages";
		$data['potentialList'] = $this->session->userdata('potentialList');
    }
    public function customersupport()
	{
		$data['title']="Customer Support";
		$this->home_template->load('home_template','customer_support',$data);    
	}
	public function tips()
	{
		$data['title']="Tips";
		$this->home_template->load('home_template','tips',$data);    
    }
    public function pageNotFound()
    {
        //$this->output->set_status_header('404');
        $data['title'] = "Page Not Found";
        $data['helpText'] = "This is an example dashboard created using build-in elements and components.";
        
        $this->home_template->load('home_template','pageNotFound',$data); 
    }
	//public getSiteEventLo
	
}
