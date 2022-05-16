<?php
include_once dirname(__FILE__) . '/NewQueryManager.php';
include_once dirname(__FILE__) . '/Responder.php';

define("STATUS", "status");
define("MSG", "msg");
define("RESPONSE", "response");
define("DEFAULT_MSG", "Something Wrong! Please Try Later.");
define("DEFAULT_STATUS", "0");

class NewController implements Responder
{
    public $model;
    private $STATUS = "status";
    private $MSG = "msg";
    private $RESPONSE = "response";

    public function __construct()
    {
        $this->model = NewQueryManager::getInstance();
    }

    public function _invoke()
    {
        if (!isset($_REQUEST['tasks'])) {
            $this->returnResponse(DEFAULT_STATUS, "No Task Given", null);
        } else {
            $task = trim(strtolower($_REQUEST['tasks']));
            switch ($task) {
                
                case "applogin" :
                    $this->appLogin();
                    break;
                case "appsignup" :
                    $this->appSignUp();
                    break;
                case "appuserproject" :
                    $this->appUserProject();
                    break;
                case "getroutinedetails" :
                    $this->getRoutineDetails();
                    break;
                case "appforgetpassword" :
                    $this->appForgetPassword();
                    break;
                case "appchangepassword" :
                    $this->appChangePassword();
                    break;
                case "appexportstatus" :
                    $this->appExportStatus();
                    break;
                case "appgetcrstore" :
                    $this->appGetCrStore();
                    break;
                case "appgetredeem" :
                    $this->appGetRedeem();
                    break;
                case "gcmgetuser" :
                    $this->gcmGetUser();
                    break;
                case "appdoredeem" :
                    $this->appDoRedeem();
                    break;
                case "getmobichecksum" :
                    $this->getMobiChecksum();
                    break;
                case "userprofileupdate" :
                    $this->userProfileUpdate();
                    break;
                case "getsurveycount" :
                    $this->getSurveyCount();
                    break;  
                case "validaterefcode" :
                    $this->validateRefCode();
                    break;
                case "userprojects" :
                    $this->userProjects();
                    break;
                case "mpuserlocation" :
                    $this->mpUserLocation();
                    break;
               case "checkandroutine" :
                    $this->checkAndRoutine();
                    break;
               case "getrule1" :
                    $this->getRule1();
                    break;
               case "getrule2" :
                    $this->getRule2();
                    break;
               case "gpilogin" :
                    $this->gpiLogin();
                    break;
               case "gpiexport" :
                    $this->gpiExport();
                    break;
               case "gpibarcode" :
                    $this->gpiBarcode();
                    break;
               case "gpirdetail" :
                    $this->gpiRDetail();
                    break;
               case "applogexport" :
                    $this->appLogExport();
                    break;
	       case "getappversion" :
                    $this->getAppVersion();
                    break;
               case "mouserlogin":
                    $this->moUserLogin();
			break;
		case "mouserfbglogin":
                    $this->moUserFBGLogin();
                        break;
		case "mouserprofileproject":
                    $this->moUserProject();
                        break;
		 case "momediashare":
                    $this->moMediaShare();
                        break;
		case "ismobikwikuser" :
                    $this->isMobikwikUser();
                    break;
               case "domobikwikredeem" :
                    $this->doMobikwikRedeem();
                    break;

                default :
                    $this->returnResponse(DEFAULT_STATUS, "app Task  Not Found", null);
                    break;
            }
        }
    }

   

    /* get centres details*/
    private function appLogin()
    {
        if (!isset($_POST['applogin']))
            $this->returnResponse(0, "Request is not valid.", null);
        else
            
            $this->model->_appLogin($this);
    }
    /* app user sign up details*/
    public function appSignUp()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
        {
            echo "Forbiden !";
            die;
        }
        if (!isset($_POST['appsignup']))
        {
                $status = false;
                $msg = 'Invalid parameter!';
                $userid = null;
                $data = array();
                $this->apiReturnError( $status, $msg, $userid, $data);
        }  
        else
            $this->model->_appSignUp($this);

    }

     /*appuser project details*/
     private function appUserProject()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET")
        {
            echo "Forbiden !";
            die;
        }
        if (!isset($_POST['appuserid']))
        {
                $status = false;
                $msg = 'Invalid parameter!';
                $userid = null;
                $data = array();
                $this->apiReturnError( $status, $msg, $userid, $data);


        }
           // $this->returnResponse(0, "AppUserid is not found", null);
        else
            $this->model->_appUserProject($this);

    }

     /*appforget password */
     private function appForgetPassword()
    {
        if (!isset($_REQUEST['appuseremail']))
            $this->returnResponse(0, "AppUserEmail is not found", null);
        else
            $this->model->_appForgetPassword($this);

    }


    /*appuser change password */
     private function appChangePassword()
    {
        if (!isset($_REQUEST['appmanagepwd']))
            $this->returnResponse(0, "AppUserid is not found", null);
        else
            $this->model->_appChangePassword($this);

    }

      /*app export status */
     private function appExportStatus()
    {
        if (!isset($_REQUEST['appexpst']))
            $this->returnResponse(0, "appexpst is not found", null);
        else
            $this->model->_appExportStatus($this);

    }

      /*app credit points */
     private function appGetCrStore()
    {
        if (!isset($_REQUEST['userid']))
            $this->returnResponse(0, "userid is not found", null);
        else
            $this->model->_appGetCrStore($this);
    }

    private function appGetRedeem()
    {
        if (!isset($_REQUEST['userid']))
            $this->returnResponse(0, "userid is not found", null);
        else
            $this->model->_appGetRedeem($this);
    }

    private function gcmGetUser()
    {
        if (!isset($_REQUEST['userdata']))
            $this->returnResponse(0, "userid is not found", null);
        else
            $this->model->_gcmGetUser($this);
    }

    private function appDoRedeem()
    {
        if (!isset($_REQUEST['rdata']))
            $this->returnResponse(0, "rdata is not found", null);
        else
            $this->model->_appDoRedeem($this);
    }
    
    private function getMobiChecksum()
    {
            $this->model->_getMobiChecksum($this);
    }

    private function userProfileUpdate()
    {
            $this->model->_userProfileUpdate($this);
    }
  
    private function getSurveyCount()
    {
            $this->model->_getSurveyCount($this);
    } 

    private function validateRefCode()
    {
            $this->model->_validateRefCode($this);
    }

    private function userProjects()
    {
            $this->model->_userProjects($this);
    }
    private function mpUserLocation()
    {
            $this->model->_mpUserLocation($this);
    } 
    private function checkAndRoutine()
    {
            $this->model->_checkAndRoutine($this);
    }
    // rules for PSM/Tom/Spont
    private function getRule1()
    {
            $this->model->_getRule1($this);
    }
    //rules for quotas
    private function getRule2()
    {
            $this->model->_getRule2($this);
    }

    private function gpiLogin()
    {
            $this->model->_gpiLogin($this);
    }
    private function gpiExport()
    {
            $this->model->_gpiExport($this);
    }
    private function gpiBarcode()
    {
            $this->model->_gpibarcode($this);
    }
    private function gpiRDetail()
    {
            $this->model->_gpiRDetail($this);
    }
     private function appLogExport()
    {
            $this->model->_appLogExport($this);
    }
    private function getAppVersion()
    {
            $this->model->_getAppVersion($this);
    }
    private function moUserLogin()
    {
	    $this->model->_moUserLogin($this);
    }
    private function moUserFBGLogin()
    {
            $this->model->_moUserFBGLogin($this);
    }
    private function moUserProject()
    {
            $this->model->_moUserProject($this);
    }
    private function moMediaShare()
    {
            $this->model->_moMediaShare($this);
    }
    
    private function isMobikwikUser()
    {
            $this->model->_isMobikwikUser($this);
    }
    private function doMobikwikRedeem()
    {
	    if (!isset($_REQUEST['userid']))
            	$this->returnResponse(0, "userid is not found", null);

            $this->model->_doMobikwikRedeem($this);
    }

    private function returnResponse($status, $msg, $response)
    {  

        $jsonResponse = array(STATUS => $status, MSG => $msg, RESPONSE => $response);
        echo json_encode($jsonResponse);
    } 

    private function apireturnResponse($status, $msg, $userid, $data)
    {  
        if(($data == null) ||($data == '')) {
        $data =$data;
        }else{
            $data =$data;  
        } 
           $dataarray[]  = [
                "status" => $status,
               "msg" => $msg,
               "user_id" => $userid,
                
               "data" => $data
           ];
           
           echo json_encode($dataarray,true);
       
    } 
    private function returnResponseMobi($status, $msg, $response)
    {  //echo 'b';
       //print_r($response);

        $jsonResponse = array(STATUS => $status, MSG => $msg, order_number => $response);
        echo json_encode($jsonResponse);
    }

    public function onError($error)
    {
//        echo $error;
//        $this->returnResponse(DEFAULT_STATUS, DEFAULT_MSG, null);
        $this->returnResponse(DEFAULT_STATUS, $error, null);
    }

    public function onSuccess($status, $msg, $response)
    {  
        $this->returnResponse($status, $msg, $response);
    }
    public function onSuccessMobi($status, $msg, $response)
    {
        $this->returnResponseMobi($status, $msg, $response);
    }

    //get routine details based on project ids
    private function getRoutineDetails()
    {
        if (!isset($_REQUEST['pid']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getRoutineDetails($this);
    }

    public function apionSuccess($status, $msg, $userid, $data)
    {  
        $this->apireturnResponse($status, $msg, $userid, $data);
    }

    function apiReturnError( $status, $msg, $userid, $data)
    {   
        
        $data =$data;
           
           $dataarray[]  = [
                "status" => $status,
               "msg" => $msg,
               "user_id" => $userid,
                
               "data" => $data
           ];
           
           echo json_encode($dataarray,true);
           die;
    }
    


}
