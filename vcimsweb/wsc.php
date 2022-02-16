<?php
include_once dirname(__FILE__) . '/wsq.php';
include_once dirname(__FILE__) . '/Responder.php';

define("STATUS", "status");
define("MSG", "msg");
define("RESPONSE", "response");
define("DEFAULT_MSG", "Something Wrong! Please Try Later.");
define("DEFAULT_STATUS", "0");

class WSC implements Responder
{
    public $model;
    private $STATUS = "status";
    private $MSG = "msg";
    private $RESPONSE = "response";

    public function __construct()
    {
        $this->model = WSQ::getInstance();
    }

    public function _invoke()
    {
        if (!isset($_REQUEST['tasks'])) {
            $this->returnResponse(DEFAULT_STATUS, "No Task Given", null);
        } else {
            $task = trim(strtolower($_REQUEST['tasks']));
            switch ($task) {
               case "uploadimageforcamera":
                   $this->uploadImageForCamera();
                   break;
               case "uploadempimage":
		   $this->uploadEmpImage();
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
               case "kapplogexport" :
                    $this->kappLogExport();
                    break;

		case "gpilogin_i":
			$this->gpiLogin_i();
			break;
               case "exportmpresultoneresp":
                     $this->exportMPResultoneresp();
                     break;
	       case "gpibarcodecn" :
                    $this->gpiBarcodeCn();
                    break;
	       case "exportmp" :
                    $this->exportMP();
                    break;
               case "vccsttoken" :
                    $this->vccstToken();
                    break;
               case "vccstexport" :
                    $this->vccstExport();
                    break;
               case "projectdescription" :
                    $this->projectDescription();
                    break;
               case "vcuserlogintest" :
                    $this->vcuserlogintest();
                    break;
               case "vcuserlogin" :
                    $this->vcuserlogin();
                    break;
               case "vcuserlogout" :
                    $this->vcuserlogout();
                    break;

               case "vcuserlogindev" :
                    $this->vcuserlogindev();
                    break;
               case "vcuserlogoutdev" :
                    $this->vcuserlogoutdev();
                    break;

               case "vcusertaglist" :
                    $this->vcusertaglist();
                    break;
               case "vcusertaglisttest" :
                    $this->vcusertaglisttest();
                    break;
               case "vcusertaglistdev" :
                    $this->vcusertaglistdev();
                    break;
	      case "vemplogin":
		    $this->vEmpLogin();
		    break;
	       case "vempattendance":
		    $this->vEmpAttendance();
		    break;
              case "vempviewallattendance":
                    $this->vEmpViewAllAttendance();
                    break;
              case "vempapprove":
                    $this->vEmpApprove();
                    break;
              case "vempviewoneattendance":
                    $this->vEmpViewOneAttendance();
                    break;
              case "vempforgetpass":
                    $this->vEmpForgetPass();
                    break;

	      case "ctrdataexport":
		    $this->ctrDataExport();
		    break;
              case "locationexport":
                    $this->locationExport();
                    break;
              case "apptrackermanual":
                    $this->appTrackerManual();
                    break;
              case "apptrackersystem":
                    $this->appTrackerSystem();
                    break;
              case "apptrackerscreen":
                    $this->appTrackerScreen();
                    break;
              case "apptrackercamera":
                    $this->appTrackerCamera();
                    break;
              case "apptrackersetting":
                    $this->appTrackerSetting();
                    break;
              case "apptrackersms":
                    $this->appTrackerSms();
                    break;

              case "apptrackeruser":
                    $this->appTrackerUser();
                    break;
              case "apptrackerstart":
                    $this->appTrackerStart();
                    break;
              case "apptrackerdata":
                    $this->appTrackerData();
                    break;


                 default :
                    $this->returnResponse(DEFAULT_STATUS, "app Task  Not Found", null);
                    break;
            }
        }
    }

    private function vEmpForgetPass()
    {
            $this->model->_vEmpForgetPass($this);
    }

    private function uploadEmpImage()
    {
            $this->model->_uploadEmpImage($this);
    }
    private function uploadImageForCamera()
    {
            $this->model->_uploadImageForCamera($this);
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
     private function kappLogExport()
    {
            $this->model->_kappLogExport($this);
    }
      private function gpiLogin_i()
    {
            $this->model->_gpiLogin_i($this);
    }
    private function exportMPResultoneresp()
    {
	$this->model->_exportMPResultOneResp($this);
    }
    private function gpiBarcodeCn()
    {
            $this->model->_gpibarcodecn($this);
    }

    private function vccstToken()
    {
            $this->model->_vccstToken($this);
    }
    private function vccstExport()
    {
            $this->model->_vccstExport($this);
    }
    private function projectDescription()
    {
            $this->model->_getProjectDescription($this);
    }

    private function vcuserlogintest()
    {
            $this->model->_vcuserlogintest($this);
    }

    private function vcuserlogin()
    {
            $this->model->_vcuserlogin($this);
    }
    private function vcuserlogout()
    {
            $this->model->_vcuserlogout($this);
    }

    private function vcuserlogindev()
    {
            $this->model->_vcuserlogindev($this);
    }
    private function vcuserlogoutdev()
    {
            $this->model->_vcuserlogoutdev($this);
    }

    private function vcusertaglist()
    {
            $this->model->_vcusertaglist($this);
    }
    private function vcusertaglisttest()
    {
            $this->model->_vcusertaglisttest($this);
    }
    private function vcusertaglistdev()
    {
            $this->model->_vcusertaglistdev($this);
    }
    private function vEmpLogin()
    {
	   $this->model->_vEmpLogin($this);
    }
    private function vEmpAttendance()
    {
   	$this->model->_vEmpAttendance($this);
    }
    private function vEmpViewAllAttendance()
    {
           $this->model->_vEmpViewAllAttendance($this);
    }
    private function vEmpViewOneAttendance()
    {
           $this->model->_vEmpViewOneAttendance($this);
    }
    private function vEmpApprove()
    {
           $this->model->_vEmpApprove($this);
    }
    private function ctrDataExport()
    {
        $this->model->_ctrDataExport($this);
    }
    private function locationExport()
    {
        $this->model->_locationExport($this);
    }
    private function appTrackerManual()
    {
        $this->model->_appTrackerManual($this);
    }
    private function appTrackerSystem()
    {
        $this->model->_appTrackerSystem($this);
    }
    private function appTrackerScreen()
    {
        $this->model->_appTrackerScreen($this);
    }
    private function appTrackerCamera()
    {
        $this->model->_appTrackerCamera($this);
    }
    private function appTrackerSetting()
    {
        $this->model->_appTrackerSetting($this);
    }
    private function appTrackerSms()
    {
        $this->model->_appTrackerSms($this);
    }
    private function appTrackerUser()
    {
        $this->model->_appTrackerUser($this);
    }
    private function appTrackerData()
    {
        $this->model->_appTrackerData($this);
    }
    private function appTrackerStart()
    {
        $this->model->_appTrackerStart($this);
    }


    private function returnResponse($status, $msg, $response)
    {  //echo 'b';
       //print_r($response);

        $jsonResponse = array(STATUS => $status, MSG => $msg, RESPONSE => $response);
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

    //get routine details based on project ids
    private function getRoutineDetails()
    {
        if (!isset($_REQUEST['pid']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getRoutineDetails($this);
    }


}
