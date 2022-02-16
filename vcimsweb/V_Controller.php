<?php
include_once dirname(__FILE__) . '/QueryManager.php';
include_once dirname(__FILE__) . '/Responder.php';

define("STATUS", "status");
define("MSG", "msg");
define("RESPONSE", "response");
define("DEFAULT_MSG", "Something Wrong! Please Try Later.");
define("DEFAULT_STATUS", "0");

class Controller implements Responder
{
    public $model;
    private $STATUS = "status";
    private $MSG = "msg";
    private $RESPONSE = "response";

    public function __construct()
    {
        $this->model = QueryManager::getInstance();
    }

    public function _invoke()
    {
        if (!isset($_REQUEST['task'])) {
            $this->returnResponse(DEFAULT_STATUS, "No Task Given", null);
        } else {
            $task = trim(strtolower($_REQUEST['task']));
            switch ($task) {
                case "getsafalboothdetails" :
                    $this->getSafalBoothDetails();
                    break;
                case "getboothdetails" :
                    $this->getBoothDetails();
                    break;
                case "gettabid" :
                    $this->getTabIDs();
                    break;
                case "getprojectdetails" :
                    $this->getProjectDetails();
                    break;
                case "getprojectfp" :
                    $this->getProjectFP();
                    break;

                case "getroutineids" :
                    $this->getRoutineIds();
                    break;
                case "getquestiondetails" :
                    $this->getQuestionDetails();
                    break;
                case "getoptiondetails" :
                    $this->getOptionDetails();
                    break;

                case "getmlquestiondetails" :
                    $this->getMLQuestionDetails();
                    break;
                case "getmloptiondetails" :
                    $this->getMLOptionDetails();
                    break;

                case "getroutinedetails" :
                    $this->getRoutineDetails();
                    break;
                case "getcentres" :
                    $this->getCentres();
                    break;
                case "getprojectcentres" :
                    $this->getProjectCentres();
                    break;
                case "getprojectrespages" :
                    $this->getProjectRespAges();
                    break;
                case "getprojectsecs" :
                    $this->getProjectSECs();
                    break;
                case "getprojectstores" :
                    $this->getProjectStores();
                    break;
                case "getprojectproducts" :
                    $this->getProjectProducts();
                    break;
                case "exportresult" :
                    $this->exportResult();
                    break;
                case "exportboothdetails" :
                    $this->exportBoothDetails();
                    break;
                case "getquestionsetdetails" :
                    $this->getQuestionsetDetails();
                    break;
                case "exportrespondentdetails" :
                    $this->exportRespondentDetails();
                    break;
                case "exportmpresult" :
                    $this->exportMPResult();
                    break;
                case "exportmpresultoneresp" :
                    $this->exportMPResultOneResp();
                    break;

                case "appsignup" :
                    $this->appSignUp();
                    break;
                case "getquestionids" :
                    $this->getQuestionIds();
                    break;
                case "getquestionsequence" :
                    $this->getQuestionSequence();
                    break;
                case "getroutinecheckdetails" :
                    $this->getRoutineCheckDetails();
                    break;
                case "uploadimage" :
                    $this->uploadImage();
                    break;
                case "uploadvideo" :
                    $this->uploadVideo();
                    break;
                default :
                    $this->returnResponse(DEFAULT_STATUS, "Task Not Found", null);
                    break;
            }
        }
    }

    /* export details*/
    private function getSafalBoothDetails()
    {  
            $this->model->_getSafalBoothDetails($this);

    }

    private function getBoothDetails()
    {
            $this->model->_getBoothDetails($this);

    }

    /* export details*/
    private function exportResult()
    {
        if (!isset($_REQUEST['result']))
            $this->returnResponse(0, "Result is Not Given", null);
        else
            $this->model->_exportResult($this);

    }

    /* export details*/
    private function exportBoothDetails()
    {
        if (!isset($_REQUEST['result']))
            $this->returnResponse(0, "Result is Not Given", null);
        else
            $this->model->_exportBoothDetails($this);

    }
//exportRespondentDetails()

    /* export respondent details*/
    private function exportRespondentDetails()
    {
        if (!isset($_REQUEST['result']))
            $this->returnResponse(0, "Result is Not Given", null);
        else
            $this->model->_exportRespondentDetails($this);

    }

/* export mpresult details*/
    private function exportMPResult()
    {
        if (!isset($_REQUEST['result']))
            $this->returnResponse(0, "Result is Not Given", null);
        else
            $this->model->_exportMPResult($this);

    }
/* export mpresult details*/
    private function exportMPResultOneResp()
    {
        if (!isset($_REQUEST['result']) || !isset($_REQUEST['resp_id']))
            $this->returnResponse(0, "Resp Result is Not Given", null);
        else
            $this->model->_exportMPResultOneResp($this);

    }


    /* get project details*/
    private function getProjectDetails()
    {
        if(isset($_REQUEST['tab_id'])){
                $this->model->_getProjectDetails($this);
        }else
            $this->returnResponse(0, "tab_id is  Not Given", null);

    }
    private function getProjectFP()
    {
        if(isset($_REQUEST['project_id'])){
                $this->model->_getProjectFP($this);
        }else
            $this->returnResponse(0, "project_id is missing", null);

    }

    private function getTabIDs()
    {
            $this->model->_getTabIds($this);
    }

    /* get getRoutineIds*/
    private function getRoutineIds()
    {
        if (!isset($_REQUEST['project_id']))
            $this->returnResponse(0, "Project Id is Not Given", null);
        else
            $this->model->_getRoutineIds($this);
    }

    /* get routine of project questions*/
    private function getRoutineDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getRoutineDetails($this);
    }

    /* get questions*/
    private function getQuestionDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getQuestionDetails($this);
    }

    /* get questionsets*/
    private function getQuestionsetDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getQuestionsetDetails($this);
    }

    /* get all questions optioon details*/
    private function getOptionDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getOptionDetails($this);
    }
  
    /* get MULTI LANGUAGE questions*/
    private function getMLQuestionDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getMLQuestionDetails($this);
    }

     /* get multilanguage questions options details*/
    private function getMLOptionDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getMLOptionDetails($this);
    }

    /* get centres details*/
    private function getCentres()
    {
            $this->model->_getCentres($this);
    }

    /* get centres details*/
    private function getProjectCentres()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Centre Ids not Found", null);
        else
            $this->model->_getProjectCentres($this);
    }

    /* get centres SECs details*/
    private function getProjectSECs()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "SECs not Found", null);
        else
            $this->model->_getProjectSECs($this);
    }

    /* get centres details*/
    private function getProjectRespAges()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Resp Ages not Found", null);
        else
            $this->model->_getProjectRespAges($this);
    }

    /* get centres details*/
    private function getProjectStores()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Stores not Found", null);
        else
            $this->model->_getProjectStores($this);
    }

    /* get centres details*/
    private function getProjectProducts()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Products not Found", null);
        else
            $this->model->_getProjectProducts($this);
    }
    /* app user sign up details*/
    private function appSignUp()
    {
        if (!isset($_REQUEST['appsignup']))
            $this->returnResponse(0, "Result is Not Given", null);
        else
            $this->model->_appSignUp($this);
    }
       /* get question ids list*/
    private function getQuestionIds()
    {
        if (!isset($_REQUEST['project_id']))
            $this->returnResponse(0, "Project Ids not Found", null);
        else
            $this->model->_getQuestionIds($this);
    }
      /* get question sequence of project questions*/
    private function getQuestionSequence()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getQuestionSequence($this);
    }
      /* get routine check of project questions*/
    private function getRoutineCheckDetails()
    {
        if (!isset($_REQUEST['ids']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getRoutineCheckDetails($this);
    }
       /* get routine check of project questions*/
    private function uploadImage()
    {
        if (!isset($_REQUEST['image']))
            $this->returnResponse(0, "image not Found", null);
        else
            $this->model->_uploadImage($this);
    }
    private function uploadVideo()
    {
        
            $this->model->_uploadVideo($this);
    }
    private function returnResponse($status, $msg, $response)
    {  //echo 'b';
       //print_r($response);

        $jsonResponse = array(STATUS => $status, MSG => $msg, RESPONSE => $response);
        echo json_encode($jsonResponse,JSON_UNESCAPED_UNICODE);
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


}
