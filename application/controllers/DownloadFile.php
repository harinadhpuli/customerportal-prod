<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DownloadFile extends CI_Controller {
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
			
    } 
	public function downloadClip()
	{
		
		//$postdata = json_decode($_POST['data'],1);
		$eventClip = $_POST['eventclip'];
		$eventTimeStamp = $_POST['eventclipTime'];
		$eventclipName = str_replace(" ","_",$_POST['eventclipName']);
		
		$downloadClipName = $eventclipName.'_'.$eventTimeStamp.'.mp4';
		
		header('Content-type: video/*');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename='.$downloadClipName);
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	
		$data = file_get_contents($eventClip);
		header("Content-Length: ".strlen($data));
		exit($data);
	}

}

?>