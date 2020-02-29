<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Netalytics_model extends CI_Model{
    public function getCookie(){
        //$cookieFile = "/var/tmp/cookies.txt";
        //echo dirname(__DIR__);die;
        $cookieFile=dirname(__DIR__).'/cookie/cookies.txt';
        if(!file_exists($cookieFile)) {
            $fh = fopen($cookieFile, "w");
            fwrite($fh, "");
            fclose($fh);
        }
        return $cookieFile;
    }

    public function removeFile(){
        $cookieFile=dirname(__DIR__).'/cookie/cookies.txt';
        unlink($cookieFile);
    }

    public function executeCurl($url,$post,$cookieFile=''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $cookieFile=$this->getCookie();
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Cookie aware
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile); // Cookie aware
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $content = curl_exec($ch);
        curl_close($ch);
        return $details=json_decode($content,1);
    }

    public function getLogin(){
        $this->removeFile();
        //$url = "https://pro-vigil.my-netalytics.com/api/login";
        $url =  NET_LOGIN_URL;
        $email = urlencode("dominic@pro-vigil.com");
        $apiKey = "Yjg4OGU2ZmY2Y2Q1NmE0MjY4ZWUzMjBlNjY1Yjg1NTdiY2Y5OTk1MTdkNmI5NWM1MWQ4YWVmMmFhZDkzZDkzOQ==";
        $ikey = urlencode($apiKey);
        $post="email=$email&apiKey=$ikey";
        $data=$this->executeCurl($url,$post);
        return $data;
    }
    public function getSiteDevicesList($apiEndPoint,$siteName)
    {
        $loginDetails=$this->getLogin();
        $url = $apiEndPoint;
        $siteName = urlencode("$siteName");
        $post="siteName=$siteName";
        $resultArr=$this->executeCurl($url,$post);
      
        return $resultArr;
    }

}
?>