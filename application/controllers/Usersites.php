<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usersites extends CI_Controller {

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
	} 
	public function index(){
		
        $data['title']="Sites List";
        $data['potentialList'] = $this->session->userdata('potentialList');
		$this->session->unset_userdata('USER_SELECTED_SITE'); /** To destory the user selected site session value for hiding the menu*/
		$this->home_template->load('home_template','usersites',$data);    
		//$this->load->view('admin/dashboard',$data);   
    }
    public function selectSite()
    {
        $postData = json_decode($this->input->post('data'),1);
        $response = array();
        if(isset($postData['site']) && $postData['site']!="")
        {
            $selectedSite = $postData['site'];
            $userSiteData = $this->session->userdata['potentialList'][ $selectedSite];
            $this->session->set_userdata("USER_SELECTED_SITE",$userSiteData);
            $response = array("error"=>0,"msg"=>"User selected site successfully.");
        }
        else{
            $response = array("error"=>1,"msg"=>"Something Went Wrong, Please try again."); 
        }
        echo json_encode($response); 

    }
}
