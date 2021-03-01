<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/*
====================================================================================================
	* 
	* @description: This is coomon model for admin and all user type
	* 
	* 
====================================================================================================*/

class Api_model extends CI_Model{
   
    function __construct(){
        parent::__construct();   
        
    }
	public function doLogin($userName,$password)
	{
		$loginurl = IVIGIL_LOGIN_API;

		$params = "action=LOGIN"
		. "&userName=" . $userName
		. "&password=" . $password
		. "&deviceId=" . 'asd'
		;
		//$url = sprintf("%s?%s", $loginurl, http_build_query($params));
		//echo $url;die;
		$curl = curl_init($loginurl);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		//$url = sprintf("%s?%s", $loginurl, http_build_query($params));
		//echo $url;die;
		$json_response = curl_exec($curl);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		// echo $status;die;
		// if ( $status != 200 ) {
		// die("Error: call to URL failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
		// }
		curl_close($curl);
		$data=json_decode($json_response,1);

		if($data['status']==200 && $status==200)
		{
			$data["source"] = "IVigil";
			$response = $data;
		}
		else
		{
			/*** Checking User login in PVM***/			
			$pvmLoginUserData = array("action"=> "LOGIN","userName"=> $userName,"password"=> $password,"deviceId"=> null);
			$payLoad = json_encode($pvmLoginUserData);
			$loginURL = PVM_LOGIN_API;
			$data = $this->executeCurlRequest($loginURL,'POST',$payLoad);
			$data["source"] = "PVM";
			$response = $data;
		}
	
		return $response;
	}

		
		public function executeCurlRequest($url,$httpMethod,$requestData,$headers='')
		{
			if($httpMethod=="POST")
			{
			
				$curl = curl_init();
                curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
				CURLOPT_CUSTOMREQUEST => $httpMethod,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
			
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_POST=>true,
				CURLOPT_POSTFIELDS=>$requestData,
				CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Cache-Control: no-cache",
                    "Content-Type: application/json; charset=UTF-8"
                    
                    ),
				));
				if($headers==true)
				{
					curl_setopt($curl, CURLOPT_HTTPHEADER, array("API: c726736ed6a469e5e713118332558b54"));
				}
			}
			else
			{
				if(isset($requestData['fdate'])){
					$CI = get_instance();
					$source =  $CI->session->userdata('source');
					if($source=='PVM')
					{
						$requestData['sitename']= $requestData['sitename'];
					}
					else
					{
						$requestData['sitename']='';
					}
				}
				$url = sprintf("%s?%s", $url, http_build_query($requestData));
				//echo $url;
				$curl = curl_init($url);
				
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );
			}
	
			$data = curl_exec($curl);
			
			
			$resdata = $data ;
			
			
			$err = curl_error($curl);
			curl_close($curl);
			$response=json_decode($resdata ,1);
			
			return $response;
		}
		
		public function getSiteDevicesList($url,$params)
        {
			$response = $this->executeCurlRequest($url,"POST",$params);
			return $response;
        }
		public function getSietMonitoringHours($url, $params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getUserTickets($url,$params)
		{
			$response = $this->executeCurlRequest($url,"POST",$params,'true');
			return $response;
		}
		public function getStats($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function createTicket($url,$params)
		{
			$response = $this->executeCurlRequest($url,"POST",$params,'true');
			return $response;
		}
		public function getLiveViews($url,$params)
		{
			//$url = sprintf("%s?%s", $url, http_build_query($params));
			//echo $url;die;
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getSiteEventLogs($url,$requestMethod,$params)
		{
			$response = $this->executeCurlRequest($url,$requestMethod,$params);
			return $response;
		}
		public function doSFLogin()
		{
			$url= PSA_LOGIN_AUTH;
			$params = array("grant_type"=>"password","client_id"=>SF_CLIENT_ID,"client_secret"=>SF_SECRET_CODE,"username"=>SF_USER_NAME,"password"=>SF_PASSWORD);
			$url = sprintf("%s?%s", $url, http_build_query($params));
			$response = $this->executeCurlRequest($url,"POST",$params);
		    return $response;
		}
		public function getSitePSAList($url,$params)
		{
			$sfAutenticationData = $this->doSFLogin();
			$url = sprintf("%s?%s", $url, http_build_query($params));
			$authenticationToken = array("auth"=>$sfAutenticationData['access_token']);
			$authenticationBody = json_encode($authenticationToken);
			$response = $this->executeCurlRequest($url,"POST",$authenticationBody);
			return $response;
		}
		public function deletePSA($url,$params)
		{
			$sfAutenticationData = $this->doSFLogin();
			$url = sprintf("%s?%s", $url, http_build_query($params));
			$authenticationToken = array("auth"=>$sfAutenticationData['access_token']);
			$authenticationBody = json_encode($authenticationToken);
			$response = $this->executeCurlRequest($url,"POST",$authenticationBody);
			return $response;
		}
		public function getSiteStatus($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function armDisarmSite($url,$params)
		{
			
			//$url = sprintf("%s?%s", $url, http_build_query($params));
			//echo $url;die;
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function createPSA($url,$accountId,$params)
		{
			$sfAutenticationData = $this->doSFLogin();
			$authenticationToken = $sfAutenticationData['access_token'];
			$headerArr = array("accountid"=>$accountId,"auth"=>$authenticationToken);
			$url = sprintf("%s?%s", $url, http_build_query($headerArr));
			$response = $this->executeCurlRequest($url,"POST",$params);
			return $response;
		}
		public function getEventDetailsByEventId($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getEventDetailsByGroupId($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function archiveDeviceConfiguration($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getEventSession($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getArchiveData($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		
		public function getRTMPLiveData($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getPTZLiveData($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getRTMPLiveStreamData($url,$cameraId,$ownerEmail,$authToken)
		{
			
			$requestData = json_encode(array("local_camera_id"=>$cameraId));
			
			$url = sprintf("%s?%s", $url, http_build_query(array("user"=>$ownerEmail)));
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
		
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS=>$requestData,
			CURLOPT_HTTPHEADER => array(
				
				"Content-Type: application/json",
				"Authorization:Bearer $authToken"
			),
			));
			
			//$response = curl_exec($curl);
			$data = curl_exec($curl);
			$resdata = $data ;
			$err = curl_error($curl);
			//echo $err;
			curl_close($curl);
			$response=json_decode($resdata ,1);
			
			return $response;
		}
		public function deleteRTMPStream($url,$params,$authToken)
		{
			$requestData = "";
			
			$url = sprintf("%s?%s", $url, http_build_query($params));
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "DELETE",
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
		
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_POST=>true,
			CURLOPT_POSTFIELDS=>$requestData,
			CURLOPT_HTTPHEADER => array(
				
				"Content-Type: application/json",
				"Authorization:token $authToken"
			),
			));
			
			//$response = curl_exec($curl);
			$data = curl_exec($curl);
			$resdata = $data ;
			$err = curl_error($curl);
			//echo $err;
			curl_close($curl);
			$response=json_decode($resdata ,1);
			
			return $response;
		}
		public function getSiteLPRSites($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getSiteLPRDetails($url,$params)
		{
			$response = $this->executeCurlRequest($url,"GET",$params);
			return $response;
		}
		public function getSiteEventClips($url,$requestMethod,$params)
		{
			$response = $this->executeCurlRequest($url,$requestMethod,$params);
			return $response;
		}
}

