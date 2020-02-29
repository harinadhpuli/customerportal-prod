<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


if($_SERVER['HTTP_HOST']=='localhost')
{
  
    $IVIGIL_LOGIN_API = "http://testworkspace.pro-vigil.com:777/ivigil-shield/2.0/mobile?";
    $PVM_LOGIN_API = "http://testing-vigil-x.pro-vigil.com:8080/vigilx-mobileapi/api/auth/login";
    $NET_LOGIN_URL = 'https://stagingpro-vigil.my-netalytics.com/api/login';

    $PSA_LOGIN_AUTH = "http://test-monitoring.pro-vigil.com:8090/vigilx-salesforce/login";
    $PSA_LIST_API = "http://test-monitoring.pro-vigil.com:8090/vigilx-salesforce/listofpsa";
    $DELETE_PSA_API = "http://test-monitoring.pro-vigil.com:8090/vigilx-salesforce/deletepsa";
    $CREATE_PSA_API = "http://test-monitoring.pro-vigil.com:8090/vigilx-salesforce/createpsa";

    $SF_CLIENT_ID = "3MVG9xOCXq4ID1uEpCSWAjJTe9cY35S2.RwjFFIfIjclDhrPInGJw..pMipIPcnCSjKHOAOr7Z683pfe9YiyE";
    $SF_SECRET_CODE = "3A67BAE9551CCC202399491D86833DDB66A0D696650A0A5E2A826302A55013F2";
    $SF_USER_NAME = "likhitha.musham@pro-vigil.com";
    $SF_PASSWORD = "M@pp!12019>>rKUXcPvnVuCCqV4taYgyF0lR";

    $CONFIG_SERVER_ROOT = "http://localhost/pvcustomerportal/";
}
else
{
    $CONFIG_SERVER_ROOT = "http://18.210.96.138/";
    //$CONFIG_SERVER_ROOT = "http://localhost/pvcustomerportal/";

    $IVIGIL_LOGIN_API = "https://workspace.pro-vigil.info:8443/ivigil-shield/MobileHttpsUrlServlet?";
    $PVM_LOGIN_API = "https://monitoring.pro-vigil.com:8443/vigilx-mobileapi/api/auth/login";
    $NET_LOGIN_URL = 'https://pro-vigil.my-netalytics.com/api/login';
    
    $PSA_LOGIN_AUTH = "http://ivigil-cg.pro-vigil.com:8080/vigilx-salesforce/login";
    $PSA_LIST_API = "http://ivigil-cg.pro-vigil.com:8080/vigilx-salesforce/listofpsa";
    $DELETE_PSA_API = "http://ivigil-cg.pro-vigil.com:8080/vigilx-salesforce/deletepsa";
    $CREATE_PSA_API = "http://ivigil-cg.pro-vigil.com:8080/vigilx-salesforce/createpsa";
    
    //$SF_CLIENT_ID = "3MVG9xOCXq4ID1uEpCSWAjJTe9ZSeV4INLNSISv9VA0u3y5tMkD7PAyduDwMs9zu4bCBSTuc.GPmxihKT1SJq";
	$SF_CLIENT_ID = "3MVG9xOCXq4ID1uEpCSWAjJTe9ZSeV4INLNSl8v9VA0u3y5tMkD7PAyduDwMs9zu4bCBSTuc.GPmxihKT1SJq";
    $SF_SECRET_CODE = "2528928582978047281";
    $SF_USER_NAME = "integration.user@pro-vigil.com";
    $SF_PASSWORD = "NewStrategy18V7C79bdo5Wk7GxBJsKNalzUxd";
}

//API end point declarations

//echo $this->session->userdata('source');die;
defined('CONFIG_SERVER_ROOT') OR define('CONFIG_SERVER_ROOT',$CONFIG_SERVER_ROOT);
defined('IVIGIL_LOGIN_API') OR define('IVIGIL_LOGIN_API',$IVIGIL_LOGIN_API);
defined('PVM_LOGIN_API') OR define('PVM_LOGIN_API',$PVM_LOGIN_API);

defined('PSA_LOGIN_AUTH') OR define('PSA_LOGIN_AUTH',$PSA_LOGIN_AUTH);
defined('PSA_LIST_API') OR define('PSA_LIST_API',$PSA_LIST_API);
defined('DELETE_PSA_API') OR define('DELETE_PSA_API',$DELETE_PSA_API);
defined('CREATE_PSA_API') OR define('CREATE_PSA_API',$CREATE_PSA_API);

defined('SF_CLIENT_ID') OR define('SF_CLIENT_ID',$SF_CLIENT_ID);
defined('SF_SECRET_CODE') OR define('SF_SECRET_CODE',$SF_SECRET_CODE);
defined('SF_USER_NAME') OR define('SF_USER_NAME',$SF_USER_NAME);
defined('SF_PASSWORD') OR define('SF_PASSWORD',$SF_PASSWORD);


$CONVERSIONTIMEZONE = 'America/Chicago';
defined('CONVERSIONTIMEZONE') OR define('CONVERSIONTIMEZONE',$CONVERSIONTIMEZONE);

$SOURCE = 'WEB';
defined('SOURCE') OR define('SOURCE',$SOURCE);

$APISOURCE = 'newmobileapp';
defined('APISOURCE') OR define('APISOURCE',$APISOURCE);

$PSA_MAX_DURATION = '14';
defined('PSA_MAX_DURATION') OR define('PSA_MAX_DURATION',$PSA_MAX_DURATION);

$PSA_MIN_FUTURE_TIME = '120'; // mintues
defined('PSA_MIN_FUTURE_TIME') OR define('PSA_MIN_FUTURE_TIME',$PSA_MIN_FUTURE_TIME);


defined('NET_LOGIN_URL') OR define('NET_LOGIN_URL',$NET_LOGIN_URL);


