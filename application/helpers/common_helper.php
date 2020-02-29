<?php 
	
 ////////////////////////// Check Login for authenticaion //////////////////////
	
	/** admin helper code start **/
	// verifing login user session exist or not
	if (!function_exists('check_login_user')) {
	    function check_UserSession() {
			$ci = get_instance();
			
			//echo "<pre>";print_r($ci->session);exit;

	        if ($ci->session->userdata('is_login') != TRUE) {
				
	            $ci->session->sess_destroy();
	            redirect(base_url('login'));
			}
			
			if($ci->session->userdata('userType')==''){
				$ci->session->sess_destroy();
				$ci->messages->setMessageFront('Invalid Credentials','error');
	            redirect(base_url('login'));
			}

	    }
	}
	
	/*
	 * @descript: This function is used to check is user login
	 * @return userid or flase
	 */ 


	if(!function_exists('logedId')){	 
		 function loggedId(){
			$CI = get_instance();	
			$userId  = $CI->session->userdata('is_login');
			if($userId>0){			
				return $userId;
			}
			else{			
				return FALSE;
			}
		 }
	}


	if(!function_exists('adminLoginCheck')){	 
		 function adminLoginCheck(){
		
			$CI = get_instance();	
			$admin_type  = $CI->session->userdata('user_type');			
			if($admin_type=='Administrator'){
				return true;
			}else{
				$CI->session->sess_destroy();
				return false;
			}
		}
	}

	if(!function_exists('loadBreadCrumbs'))
	{
		function loadBreadCrumbs($pageTitle,$helpText,$addLink="",$icon='',$actions=array())
		{
			$data=array();
			if($icon==''){
				$data['icon_class']="fa fa-sitemap";
			}else{
				$data['icon_class']=$icon;
			}
			
			$data['title'] = $pageTitle;
			if($addLink!="")
			{
				$data['addLink'] = $addLink;
			}
			$data['helptext']= $helpText;

			if(isset($actions) && !empty($actions)){

			}
			$data['actions']=$actions;

			return $data;
		}
	}
	
	//-- current date time function
	if(!function_exists('current_datetime')){
	    function current_datetime(){        
	        $dt = new DateTime('now', new DateTimezone('Asia/Calcutta'));
	        $date_time = $dt->format('Y-m-d H:i:s');      
	        return $date_time;
	    }
	}
		
	if(!function_exists('displayCustomDateTime')){
	    function displayCustomDateTime($date){       
	        if($date != ''){
	            $date2 = date_create($date);
	            $date_new = date_format($date2,"d M Y h:i A");
	            return $date_new;
	        }else{
	            return '';
	        }
	    }
	}


	if(!function_exists('displayDateTime')){
	    function displayDateTime($date){       
			if($date != '')
			{
	            $date2 = date_create($date);
	            $date_new = date_format( $date2,"d-m-Y H:i");
	            return $date_new;
			}
			else
			{
	            return '';
	        }
	    }
	}

	if(!function_exists('displayDateTime')){
	    function displayDateTime($date){       
			if($date != '')
			{
	            $date2 = date_create($date);
	            $date_new = date_format( $date2,"d-m-Y H:i");
	            return $date_new;
			}
			else
			{
	            return '';
	        }
	    }
	}

	if(!function_exists('convertdatepickerFormate')){
	    function convertdatepickerFormate($date){    
			   
			if($date!='')
			{
				$date= str_replace("-","/",$date);
				$date = DateTime::createFromFormat("m/d/Y", $date);
				return $date->format('Y-m-d');
			}
			else
			{
	            return '';
	        }
	    }
	}

	if(!function_exists('convertdatetimepickerFormate')){
	    function convertdatetimepickerFormate($date){    
			 
			if($date != '')
			{
				$date = DateTime::createFromFormat("m/d/Y H:i" , $date);
				return $date->format('Y-m-d H:i');
			}
			else
			{
	            return '';
	        }
	    }
	}

	if(!function_exists('convertdatetimepickerSeconds')){
	    function convertdatetimepickerSeconds($date){    
			
			if($date != '')
			{
				$date= str_replace("-","/",$date);
				$date = DateTime::createFromFormat("m/d/Y H:i:s" , $date);
				return $date->format('Y-m-d H:i:s');
			}
			else
			{
	            return '';
	        }
	    }
	}

	if(!function_exists('compareDateRangeCondition')){
		function compareDateRangeCondition($fromDate,$toDate)
		{       
			$isValid=0;
			if($fromDate != '' && $toDate!="")
			{
	            $datetime1 = new DateTime($fromDate);
				$datetime2 = new DateTime($toDate);
				if ($datetime1 > $datetime2) {
					$isValid = 0;
				}
				else
				{
					$isValid = 1;
				}
			}
			return $isValid;
	    }
	}
	if(!function_exists('dateConvertByTimeZone')){
		function dateConvertByTimeZone($time, $oldTZ, $newTZ, $format) {
			// create old time
			$d = new DateTime($time, new DateTimeZone($oldTZ));
			// convert to new tz
			$d->setTimezone(new DateTimeZone($newTZ));
		
			// output with new format
			return $d->format($format);
		}
	}

	if(!function_exists('getDateParametersByTimeZone')){
	function getDateParametersByTimeZone($timeZone)
	{
   		   switch($timeZone)
		   {
			   case 'CT': $displayTZ = "CST";
			   date_default_timezone_set('America/Chicago');
			   $currentTime = date('Y-m-d H:i:s');
			   $location='America/Chicago';
			   //$currentTime = $commonObj->displayDateFormatWithTime($time);
			   break;
			   case 'ET': $displayTZ = "EST";
			   date_default_timezone_set('America/New_York');
			   $currentTime = date('Y-m-d H:i:s');
			   $location='America/New_York';
			   //$currentTime = $commonObj->displayDateFormatWithTime($time);
			   break;
			   case 'PT': $displayTZ = "PST";
			   date_default_timezone_set('America/Los_Angeles');
			   $currentTime = date('Y-m-d H:i:s');
			   $location='America/Los_Angeles';
			   //$currentTime = $commonObj->displayDateFormatWithTime($time);
			   break;	
			   case 'MT': $displayTZ = "MST";
			   date_default_timezone_set('America/Denver');
			   $currentTime = date('Y-m-d H:i:s');
			   $location='America/Denver';
			   //$currentTime = $commonObj->displayDateFormatWithTime($time);
			   break;	
			   case 'UTC': $displayTZ = "UTC";
			   date_default_timezone_set('UTC');
			   $currentTime = date('Y-m-d H:i:s');
			   $location='UTC';
			   //$currentTime = $commonObj->displayDateFormatWithTime($time);
			   break;
			   default:
			   $displayTZ = "CST";
			   date_default_timezone_set('America/Chicago');
			   $currentTime = date('Y-m-d H:i:s');
			   $location='America/Chicago';
			   //$currentTime = $commonObj->displayDateFormatWithTime($time);
			   break;
		   }
		   $data = array();
		   $data['currentTime']=$currentTime;
		   $data['location']=$location;
		   $data['timeZone']=$timeZone;
		   $data['displayCode']=$displayTZ ;
		   return $data;
	}
}
if(!function_exists('getUTCOffset_OOP'))
{
	function getUTCOffset_OOP($timezone)
	{
		$current   = timezone_open($timezone);
		$utcTime  = new DateTime('now', new DateTimeZone('UTC'));
		$offsetInSecs =  $current->getOffset($utcTime);
		$hoursAndSec = gmdate('H:i', abs($offsetInSecs));
		return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
	}
}

//Procedural style
if(!function_exists('getUTCOffset'))
{
	function getUTCOffset($timezone)
	{
		$current   = timezone_open($timezone);
		$utcTime  = new DateTime('now', new DateTimeZone('UTC'));
		$offsetInSecs =  timezone_offset_get( $current, $utcTime);
		$hoursAndSec = gmdate('H:i', abs($offsetInSecs));
		return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
	}
}
if(!function_exists('dateDiffByTime'))
{
	function dateDiffByTime($date1, $date2,$reqFormat)  
	{ 
		// Calulating the difference in timestamps 
		$diff = strtotime($date2) - strtotime($date1); 
		//echo $diff;die;
		// 1 day = 24 hours 
		// 24 * 60 * 60 = 86400 seconds 
		if($reqFormat=="Days")
		{
			$res = ceil(abs($diff / 86400)); 
			//$res = $diff / 86400;
		}
		elseif($reqFormat=="Hours")
		{
			$res = round(abs($diff) / 60,2);
		}
		
		return $res;
	} 
}
if(!function_exists('generateRandomString'))
{
	function generateRandomString($n) { 
		$characters = '0123456789'; 
		$randomString = ''; 
	
		for ($i = 0; $i < $n; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
		} 
	
		return $randomString; 
	} 
}
if(!function_exists('convertEventLogDateFormat'))
{
	function convertEventLogDateFormat($date) { 
		$edate =  substr($date,0,10);
		$time = substr($date,11,19);
		$time = str_replace("-",":",$time);
		
		$fulldate = $edate.' '.$time;
		
		$formatDate = date('m/d/Y H:i:s',strtotime($fulldate));
	
		return $formatDate; 
	} 
}
if(!function_exists('convertDBDateFormat'))
{
	function convertDBDateFormat($date) { 
		
		$formatDate = date('m/d/Y H:i:s',strtotime($date));
	
		return $formatDate; 
	} 
}
?>
