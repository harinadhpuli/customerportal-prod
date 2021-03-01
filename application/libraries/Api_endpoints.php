<?php 
//error_reporting(0); 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	class Api_endpoints 
	{		
		public function getAPIEndPointByUserSource($apiName)
		{
			$CI = get_instance();
			$userSelectedSite = $CI->session->userdata('USER_SELECTED_SITE');
			$source =  $CI->session->userdata('source');
			$apiEndPoints = array();
			//echo $_SERVER['HTTP_HOST'];die;
			if($source=='IVigil')
			{
				$siteURL = $userSelectedSite['url'];
				$MONITORING_HOURS_API = $siteURL."getMonitoringHours"; // monitoring url should be dynamic from potential data
				$LIVE_VIEWS_API = $siteURL."ProvigilService"; // live views url should be dynamic from potential data
				$ONLY_STATUS_API = $siteURL."CameraService";
				$ARCHIVE_CONFIG_API = $siteURL."ProvigilRestService";
				$CAMERA_SERVICE = $siteURL."CameraService";
				$ARCHIVE_DATA_API = $siteURL."MobileArchivePlayer";
				$EXPORT_VIDEO_API = $siteURL."ExportVideo";

				if($_SERVER['HTTP_HOST']=="localhost")
				{
					$EVENT_LOG_DETAILS = "http://testconsole1.pro-vigil.com:8080/ivigil-console/EventlogById";
					$STATS_API = "http://testworkspace.pro-vigil.com:777/ivigil-workspace/mobile";	
					$EVENT_LOG_API = "http://testconsole1.pro-vigil.com:8080/ivigil-console/EventLog";
					$ARM_DISARM_ACTION_API = "http://testconsole1.pro-vigil.com:8080/ivigil-console/mobile";
					$ARM_DISARM_STATUS_API = "http://testconsole1.pro-vigil.com:8080/ivigil-console/reverseEscallations";
				}
				else
				{
					$EVENT_LOG_DETAILS = "https://console-vigilx.pro-vigil.com:8443/ivigil-console/EventlogById";
					$STATS_API = "https://workspace.pro-vigil.info:8443/ivigil-workspace/mobile";	
					$EVENT_LOG_API = "https://console-vigilx.pro-vigil.com:8443/ivigil-console/EventLog";
					$ARM_DISARM_ACTION_API = "https://console-vigilx.pro-vigil.com:8443/ivigil-console/mobile";
					$ARM_DISARM_STATUS_API = "https://console-vigilx.pro-vigil.com:8443/ivigil-console/reverseEscallations";
				}
				//echo $LIVE_VIEWS_API.'<br>'.$STATS_API;die;
				//$RTMP_API = $siteURL."getlivestreamingurl";
				$PTZ_API  = $siteURL."CameraService";
				$RTMP_API = "https://video.pro-vigil.info/api/cameras/sessions";
				
				$SITE_LPR_LIST_API = 'https://workspace.pro-vigil.info:8443/ivigil-shield/UserLprSitesServlet';
				$LPR_DETAILS_API = 'https://workspace.pro-vigil.info:8443/ivigil-lpr/LprJsonDataServlet';
				$LPR_DOWNLOAD_PDF_API = 'https://workspace.pro-vigil.info:8443/ivigil-lpr/ExportPDFServlet';
			}
			elseif($source=='PVM')
			{
				if($_SERVER['HTTP_HOST']=="localhost")
				{
					$MONITORING_HOURS_API = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/getmonitoringhours";
					$STATS_API = "http://testing-vigil-x.pro-vigil.com:8080/vgsservices/sitedetails/getsitestatistics";
					$LIVE_VIEWS_API = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/camiocameralist";
					$EVENT_LOG_API = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/recentEscalationsByPageAPI.do";
					$ARM_DISARM_ACTION_API = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/armdisarm";
					$ARM_DISARM_STATUS_API = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/ArmDisarmStausHistory";
					$EVENT_LOG_DETAILS = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/recentReportsByPageAPI.do";
				}
				else
				{
					$MONITORING_HOURS_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/getmonitoringhours";
					$STATS_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/getsitestatistics";
					$LIVE_VIEWS_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/camiocameralist";
					//$EVENT_LOG_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/recentEscalationsByPageAPI.do";
					$EVENT_LOG_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/recentEscalationsByPageAPICP.do";
					$ARM_DISARM_ACTION_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/armdisarm";
					$ARM_DISARM_STATUS_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/ArmDisarmStausHistory";
					$EVENT_LOG_DETAILS = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/recentReportsByPageAPI.do";
				}
				//$RTMP_API = "https://monitoring.pro-vigil.com:8443/vgsservices/getlivestreamingurl";
				$RTMP_API = "https://video.pro-vigil.info/api/cameras/sessions";
				$ONLY_STATUS_API = "";
				
				$EXPORT_VIDEO_API = "";
				$CAMERA_SERVICE = "";
				$ARCHIVE_DATA_API = "";
				$ARCHIVE_CONFIG_API = "";
				$PTZ_API  = "";
				
				$SITE_LPR_LIST_API = "";
				$LPR_DETAILS_API = "";
				$LPR_DOWNLOAD_PDF_API = "";
			}
			if($_SERVER['HTTP_HOST']=="localhost")
			{
				$CAMERA_HEALTH_API = "https://stagingpro-vigil.my-netalytics.com/datahandler/api/netalytics_utilities/dummy/getCamioDevicesStatus";
				$CREATE_TICKET_API = "https://ticketing-test.pro-vigil.com/webservices/ws/createTicket";
				$TICKETS_API = "https://ticketing-test.pro-vigil.com/webservices/ws/getTickets";
			}
			else
			{
				$CAMERA_HEALTH_API = "https://pro-vigil.my-netalytics.com/datahandler/api/netalytics_utilities/dummy/getCamioDevicesStatus";
				$CREATE_TICKET_API = "https://ticketing.pro-vigil.com/webservices/ws/createTicket";
				$TICKETS_API = "https://ticketing.pro-vigil.com/webservices/ws/getTickets";
			}
			
			
			$EVENT_CLIP_API = "http://apps.pro-vigil.info:8089/api/eventdata/geteventclips";
			$apiEndPoints = array(
				"CAMERA_HEALTH_API" => $CAMERA_HEALTH_API,
				"MONITORING_HOURS_API" => $MONITORING_HOURS_API,
				"CREATE_TICKET_API" => $CREATE_TICKET_API,
				"TICKETS_API" => $TICKETS_API,
				"STATS_API" => $STATS_API,
				"LIVE_VIEWS_API" => $LIVE_VIEWS_API,
				"EVENT_LOG_API" => $EVENT_LOG_API,
				"EVENT_LOG_DETAILS" => $EVENT_LOG_DETAILS,
				"ARM_DISARM_STATUS_API" => $ARM_DISARM_STATUS_API,
				"ARM_DISARM_ACTION_API" => $ARM_DISARM_ACTION_API,
				"ONLY_STATUS_API" => $ONLY_STATUS_API,

				"ARCHIVE_CONFIG_API" => $ARCHIVE_CONFIG_API,
				"CAMERA_SERVICE" => $CAMERA_SERVICE,
				"ARCHIVE_DATA_API" => $ARCHIVE_DATA_API,
				
				"EXPORT_VIDEO_API" => $EXPORT_VIDEO_API,
				"RTMP_API" => $RTMP_API,
				"PTZ_API"=>$PTZ_API,
				"SITE_LPR_LIST_API"=>$SITE_LPR_LIST_API,
				"LPR_DETAILS_API"=>$LPR_DETAILS_API,
				"LPR_DOWNLOAD_PDF_API"=>$LPR_DOWNLOAD_PDF_API,
				"EVENT_CLIP_API" => $EVENT_CLIP_API,
			);
			return $apiEndPoints[$apiName];
		}
	}
