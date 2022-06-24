<?php
include_once dirname(__FILE__) . '/DBConnector.php';
date_default_timezone_set('asia/calcutta'); 

class QueryManager
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new QueryManager();
        }

        return self::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {

    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
    /* query for fetch Safal booth detail*/
    public function _getSafalBoothDetails(Controller $instance)
    {
        $tag = "**_getSafalBoothDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);  
        } else {
            $sql2 = "SELECT `b_id`, `address`, `city`, `bcentre_id` FROM `safal_list`";
            $result = mysqli_query($conn, $sql2);
            if (!$result) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $bd = array("b_id" => (int)$row["b_id"], "address" => $row["address"], "city" => $row["city"], "centre" => $row["bcentre_id"]);
                        array_push($response, $bd);
                    }
                    $status = 1;
                    $msg = "Safal Booth Details is here";
                } else {
                    $msg = "No Safal Booths are Found";
                }
            }
  //print_r($response);
        }
         $responses=$response;
 //print_r($response);
          
        $this->_returnResponse($conn, $instance, $status, $msg, $responses);
    }

    /* query for fetch booth detail*/
    public function _getBoothDetails(Controller $instance)
    {
        $tag = "**_getBoothDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT b_id,address,mobile,area from mdbooth";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $bd = array("b_id" => (int)$row["b_id"], "address" => $row["address"], "mobile" => $row["mobile"], "area" => $row["area"]);
                        array_push($response, $bd);
                    }
                    $status = 1;
                    $msg = "Booth Details is here";
                } else {
                    $msg = "No Booths are Found";
                }
            }
 //print_r($response);
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }


    /* query for project detail*/
    public function _getTabIds(Controller $instance)
    {
        $tag = "**_getTabIds**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sqlTAB = "SELECT tab_id,tab_name from vcims_tablets";
  //to hide the listing of tablet name
              if(isset($_REQUEST['emei']))
                 $sqlTAB = "SELECT tab_id,tab_name from vcims_tablets where tab_imei_1='".$_REQUEST['emei']."' or tab_imei_2='".$_REQUEST['emei']."'";

            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("tab_id" => (int)$row["tab_id"], "tab_name" => $row["tab_name"]);
                        array_push($response, $bd);
                        }
                        $status = 1;
                        $msg = "TAB ID is Here";
                    }
                } else {
                    $msg = "No Tab Id is Found";
                }
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

   //To get project_id from qset_id 
   public function getPidFQset($qset_id)
    {
           $conn = DBConnector::getDBInstance();

	    $pq = "SELECT project_id FROM  questionset WHERE qset_id=$qset_id";
            $rpq = mysqli_query($conn, $pq);
            if ($rpq) {
                    if ($rpq->num_rows > 0) {
                       while ($rowpq = $rpq->fetch_assoc()) {  
                            $pid = $rowpq["project_id"]; 
                            return $pid;
                      } //end while
                    } //end if
           } //end if
    }

    /* query for project detail*/
    public function _getProjectDetails(Controller $instance)
    {
        $tag = "**_getProjectDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = array();
        
        $status = 0; $tab_imei = ''; $fp_arr=array();
        $response = array(); 
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
		$imei=$_REQUEST['imei'];$qset=0;
            $sqlMAP = "SELECT distinct project_id, imei  from vcims.tab_project_map where (tab_id=" . $_REQUEST["tab_id"] . " OR mobile='" . $_REQUEST["tab_id"] . "')  and status=1";
            $rsMAP = mysqli_query($conn, $sqlMAP);
            if (!$rsMAP) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsMAP->num_rows > 0) {
                    $project_ids = "";
                    $isFirst = true;
           	while ($rowMAP = $rsMAP->fetch_assoc()) {
			$qset=$rowMAP["project_id"];
                        $pid=$this->getPidFQset($qset);
			//echo "qset : $qset , pid: $pid ; "; 
		      if($pid > 0){
                        if ($isFirst) {
                            //$project_ids = $this->getPidFQset($pid);
			    $project_ids= $pid; 
			    $tab_imei=$rowMAP["imei"];
                            $isFirst = false;
                        } else{
                            //$pid=$this->getPidFQset($rowMAP["project_id"]);
			    //$ppid=$this->getPidFQset($pid); 
                            $project_ids = $project_ids . "," . $pid; 
       			    $tab_imei=$rowMAP["imei"];
                 	}
		    // } //end of check blank pid
                  //} //end of while

			//to all only one user for a tab/mobile for a project
			if($tab_imei == ''){
				$mob=$_REQUEST['tab_id'];
				$sqlm="UPDATE vcims.tab_project_map SET imei='$imei' WHERE project_id IN ($pid) AND mobile = '$mob'";
                		$nmi=mysqli_query($conn, $sqlm);
				$status = 1;
			}
			else{
				if($imei == $tab_imei){
				
					$status = 1;
				}
				else{
					$msgg="Somebody has already registered with this Access Key";
					$status = 2;
					return $this->_returnResponse($conn, $instance, $status, $msgg, $response);
				}
			}
                    $sql = "SELECT * from vcims.project where project_id IN(" . $pid . ") and `survey_end_date` >= DATE(NOW()) ";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $dtable=$row["data_table"];$tabid=$_REQUEST["tab_id"];$pid=$row["project_id"];$ssize=$row["sample_size"]; $rcont=0;
                                  $qww="SELECT max( DISTINCT resp_id ) as rcnt FROM  $dtable WHERE resp_id LIKE  '$tabid%'";
                                  $rrss = mysqli_query($conn, $qww);
				  $rrowcount=mysqli_num_rows($rrss);
                                  if ($rrowcount > 0) 
                                  {
                                       while ($ro = $rrss->fetch_assoc())
                                       {
                                          $rcont=$ro["rcnt"];
                                          if($rcont==null) $rcont='0';
					  
                                          $p = array("project_id" => $row["project_id"],"qset_id"=>$qset, "project_name" => $row["name"],"sample_size" => $ssize, "company_name" => $row["company_name"], "brand" => $row["brand"], "research_type" => $row["research_type"],"tot_visit" => $row["tot_visit"], "data_table" => $row["data_table"], "resp_count" => $rcont);
	                                  array_push($response, $p);

					//begin of first page details of a project
					  //$fp_arr=array();
					  $sqry="SELECT id, term, title,type FROM vcims.app_first_page where id in (SELECT fpid FROM project_fp_map where pid=$pid)";
					  $fpdata = mysqli_query($conn, $sqry);
					  $frowcount=mysqli_num_rows($fpdata);
                                  	  if ($frowcount > 0) 
                                          {
                                         	while ($fpd = $fpdata->fetch_assoc())
                                       		{
							$fa = array("fpid" => $fpd["id"],"project_id"=>$row["project_id"],"qset_id"=>$qset, "term" => $fpd["term"],"title" => $fpd["title"],"type" => $fpd["type"]);
							array_push($fp_arr, $fa);
						}
					  }
					  $msg=$fp_arr;
					//end of first page details
                                       }
                                  }  
                            }
                            //$status = 1;
                            //$msg = "Project List is Here";
                           }}
                        }
                    }
                } 
                    //$msg = "No Project Related To This TAB ID";
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

   /* query for project FP detail*/
    public function _getProjectFP(Controller $instance)
    {
        $tag = "**_getProjectFP**";
        $conn = DBConnector::getDBInstance();
        $msg = 'No detail available';
        
        $status = 0;   $fp_arr=array();
        $response = array(); 
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
		$pid=$_REQUEST['project_id']; 

		//begin of first page details of a project
					  //$fp_arr=array();
			$sqry="SELECT id, term, title,type FROM vcims.app_first_page where id in (SELECT fpid FROM project_fp_map where pid=$pid)";
			$fpdata = mysqli_query($conn, $sqry);
			$frowcount=mysqli_num_rows($fpdata);
                        if ($frowcount > 0) 
                        {
			     $msg='Done';
			     $status = 1;
                             while ($fpd = $fpdata->fetch_assoc())
                             {
				$fa = array("fpid" => $fpd["id"],"project_id"=>$pid, "term" => $fpd["term"],"title" => $fpd["title"],"type" => $fpd["type"]);
				array_push($fp_arr, $fa);
			     }
			}
			$response=$fp_arr;
		//end of first page details
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    /* query for project detail*/
    public
    function _getRoutineIds(Controller $instance)
    {
        $tag = "**_getRoutineIds**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

            $sql = "SELECT DISTINCT q_id from question_routine_detail where qset_id=" . $_REQUEST["project_id"] . " ORDER BY  q_id ASC ";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $response[] = $row["q_id"];
//                        $response[] = $row["q_id"];
                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    /* query for rotine details */

    public
    function _getRoutineDetails(Controller $instance)
    {
        $tag = "**_getRoutineDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT * from question_routine_detail where q_id IN(" . $_REQUEST['ids'] . ")";
            //         $sql = "SELECT * from question_routine_detail where qset_id=" . $_REQUEST['project_id'];
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $r = array("id" => (int)$row["id"], "qset_id" => (int)$row["qset_id"], "q_id" => (int)$row["q_id"],
                            "next_qid" => (int)$row["next_qid"], "qsequence" => (int)$row["qsequence"],
                            "op_value" => (int)$row["op_value"], "qsec" => (int)$row["qsec"], "routine" => $row["routine"]
                        , "compare_sign" => $row["compare_sign"], "join_with" => $row["join_with"]);
                        array_push($response, $r);

                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    /* query for qution details*/
    public
    function _getQuestionDetails(Controller $instance)
    {
        $tag = "**_getQuestionDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

            $sql = "SELECT * from question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"], "q_type" => $row["q_type"],"qno" => $row["qno"],
                            "image" => $row["image"], "video" => $row["video"],
                            "audio" => $row["audio"],"timestamp" => $row["timestamp_flag"], "condition" => $row["condition"]);
                        array_push($response, $q);
                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    /* query for option details */
    public
    function _getOptionDetails(Controller $instance)
    {
        $tag = "**_getOptionDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

            $sql = "SELECT * from question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $o = array("op_id" => (int)$row["op_id"], "q_id" => (int)$row["q_id"],"flag" => $row["flag"], "opt_text_value" => $row["opt_text_value"],
                            "term" => $row["term"], "value" => (int)$row["value"], "column_value" => (int)$row["column_value"],"scale_start_value" => (int)$row["scale_start_value"],"scale_end_value" => (int)$row["scale_end_value"],"scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
                       
                            if($o['flag'] =='1')
                        {
                            $o['term'] = $o['term'].'_'.$o['value'].'_'.'o';
                        }
                            array_push($response, $o);
                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    	/* query for Multi Language qution details*/
    public
    function _getMLQuestionDetails(Controller $instance)
    {
        $tag = "**_getQuestionDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
		if($_REQUEST["ml"]==1)
		{
	            $sql = "SELECT * from hindi_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
	                        array_push($response, $q);
	                    }
	                    $status = 1;
	                }
	            }
	         }
	         
	         if($_REQUEST["ml"]==6)
		 {
	            $sql = "SELECT * from bengali_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
	                        array_push($response, $q);
	                    }
	                    $status = 1;
	                }
	            }
	         }
                 if($_REQUEST["ml"]==7)
                 {
                    $sql = "SELECT * from odia_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
                                array_push($response, $q);
                            }
                            $status = 1;
                        }
                    }
                 }

                 if($_REQUEST["ml"]==8)
                 {
                    $sql = "SELECT * from gujrati_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
                                array_push($response, $q);
                            }
                            $status = 1;
                        }
                    }
                 }

	         if($_REQUEST["ml"]==2)
		 {
	             $sql = "SELECT * from kannar_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    //$sql = "SELECT * from kannar_question_detail where q_id IN(1679,1681,1682,1683,1684,1685,1686,1687,1688,1689,1690,1691,1692,1693,1694,1695,1696,1697,1698,1699,1700,1701, 1702,1703,1704,1705,1706,1707,1708,1709,1710)";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $q = array("id" => (int)$row["id"],"q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
	                        array_push($response, $q);
	                    }
	                    $status = 1;
	                }
	            }
	         }
	         if($_REQUEST["ml"]==4)
		 {
	              $sql = "SELECT * from tammil_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                     //$sql = "SELECT * from tammil_question_detail where q_id IN(1852,1853,1855,1856,1885)";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $q = array("id" => (int)$row["id"],"q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
	                        array_push($response, $q);
	                    }
	                    $status = 1;
	                }
	            }
	         }
	         if($_REQUEST["ml"]==5)
		 {
	            $sql = "SELECT * from telgu_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
	                        array_push($response, $q);
	                    }
	                    $status = 1;
	                }
	            }
	         }
	         if($_REQUEST["ml"]==3)
		 {
	            $sql = "SELECT * from malyalam_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
	                        array_push($response, $q);
	                    }
	                    $status = 1;
	                }
	            }
	         }
                 if($_REQUEST["ml"]==9)
                 {
                    $sql = "SELECT * from marathi_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
                                array_push($response, $q);
                            }
                            $status = 1;
                        }
                    }
                 }
                 if($_REQUEST["ml"]==10)
                 {
                    $sql = "SELECT * from asami_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"]);
                                array_push($response, $q);
                            }
                            $status = 1;
                        }
                    }
                 }
	         
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
    
	 /* query for Multi Language option details */
    public
    function _getMLOptionDetails(Controller $instance)
    {
        $tag = "**_getMLOptionDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
        	if($_REQUEST["ml"]==1)
		{
	            $sql = "SELECT * from hindi_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $o = array( "id" => (int)$row["id"],"q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" => $row["opt_text_value"],  "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
	                        array_push($response, $o);
	                    }
	                    $status = 1;
	                }
	            }
	       }
	       if($_REQUEST["ml"]==6)
	       {
	            $sql = "SELECT * from bengali_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $o = array( "id" => (int)$row["id"],"q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" => $row["opt_text_value"], "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
	                        array_push($response, $o);
	                    }
	                    $status = 1;
	                }
	            }
	       }
                 if($_REQUEST["ml"]==7)
                 {
                    $sql = "SELECT * from odia_question_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $o = array( "id" => (int)$row["id"],"q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" =>$row["opt_text_value"], "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
                                array_push($response, $o);
                            }
                            $status = 1;
                        }
                    }
                 }
                 if($_REQUEST["ml"]==8)
                 {
                    $sql = "SELECT * from gujrati_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $o = array( "id" => (int)$row["id"],"q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" =>$row["opt_text_value"], "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
                                array_push($response, $o);
                            }
                            $status = 1;
                        }
                    }
                 }
	       if($_REQUEST["ml"]==2)
	       {
	            $sql = "SELECT * from kannar_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $o = array("id" => (int)$row["id"], "q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" => $row["opt_text_value"], "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
	                        array_push($response, $o);
	                    }
	                    $status = 1;
	                }
	            }
	       }
	       if($_REQUEST["ml"]==4)
	       {
	            $sql = "SELECT * from tammil_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $o = array("id" => (int)$row["id"], "q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" => $row["opt_text_value"], "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
	                        array_push($response, $o);
	                    }
	                    $status = 1;
	                }
	            }
	       }
	       if($_REQUEST["ml"]==5)
	       {
	            $sql = "SELECT * from telgu_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $o = array("id" => (int)$row["id"], "q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" => $row["opt_text_value"], "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
	                        array_push($response, $o);
	                    }
	                    $status = 1;
	                }
	            }
	       }
	       if($_REQUEST["ml"]==3)
	       {
	            $sql = "SELECT * from malyalam_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
	            $rs = mysqli_query($conn, $sql);
	            if (!$rs) {
	                $this->_returnError($conn, $instance, $tag);
	            } else {
	                if ($rs->num_rows > 0) {
	                    // output data of each row
	                    while ($row = $rs->fetch_assoc()) {
	                        $o = array("id" => (int)$row["id"], "q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" => 
$row["opt_text_value"],  "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
	                        array_push($response, $o);
	                    }
	                    $status = 1;
	                }
	            }
	       }
	      
               if($_REQUEST["ml"]==9)
               {
                    $sql = "SELECT * from marathi_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $o = array("id" => (int)$row["id"], "q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" =>
$row["opt_text_value"],  "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
                                array_push($response, $o);
                            }
                            $status = 1;
                        }
                    }
               }

               if($_REQUEST["ml"]==10)
               {
                    $sql = "SELECT * from asami_question_option_detail where q_id IN(" . $_REQUEST["ids"] . ")";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $o = array("id" => (int)$row["id"], "q_id" => (int)$row["q_id"],"code" => (int)$row["code"], "opt_text_value" =>
$row["opt_text_value"],  "scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
                                array_push($response, $o);
                            }
                            $status = 1;
                        }
                    }
               }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
    

         /* query for Centre detail*/
          public function _getCentres(Controller $instance)
    {
        $tag = "**_getCentres**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sqlTAB = "SELECT centre_id, cname FROM centre";

         
            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("centre_id" => (int)$row["centre_id"], "cname" => $row["cname"]);
                        array_push($response, $bd);
                        }
                        $status = 1;
                        $msg = "Centre is Here";
                    }
                } else {
                    $msg = "No Centre is Found";
                }
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

   
        /* query for project centres detail*/
         public function _getProjectCentres(Controller $instance)
    {
        $tag = "**_getProjectCentres**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();$c=array(); $ca = array(); $csa = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {


               $sqlca = "SELECT  qset,cid,area,value FROM project_centre_area_map WHERE qset=".$_REQUEST['ids'];
               $rsca = mysqli_query($conn, $sqlca);
                if ($rsca->num_rows > 0) {
                    if ($rsca->num_rows > 0) {
                        // output data of each row
                        while ($row1 = $rsca->fetch_assoc()) {
                            $arrca = array("cid" => $row1["cid"], "qset" => $row1["qset"], "area" => $row1["area"], "code" => $row1["value"]);
                            array_push($ca, $arrca);
                        }
                    }
                }
               $sqlcsa = "SELECT  qset,cid,aid, suarea,value FROM project_centre_subarea_map WHERE qset=".$_REQUEST['ids'];
               $rscsa = mysqli_query($conn, $sqlcsa);
                if ($rscsa->num_rows > 0) {
                    if ($rscsa->num_rows > 0) {
                        // output data of each row
                        while ($row2 = $rscsa->fetch_assoc()) {
                            $arrcsa = array("cid" => $row2["cid"], "qset" => $row2["qset"], "area" => $row2["aid"], "subarea" => $row2["suarea"],  "code" => $row2["value"]);
                            array_push($csa, $arrcsa);
                        }
                    }
                }


            $sqlTAB = "SELECT  centre_id, project_id, q_id FROM centre_project_details WHERE q_id=".$_REQUEST['ids'];
            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("centre_id" => (int)$row["centre_id"], "project_id" => $row["project_id"], "q_id" => $row["q_id"]);
                        array_push($c, $bd);
                        }
                        $status = 1;
                        $msg = "Centre Ids is Here";
                    }
                } else {
                    $msg = "No Centre Id is Found";
                }
            }
        }
       $response['centre']=$c; $response['area']=$ca; $response['subarea']=$csa;
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

         /* query for project SEC detail*/
         public function _getProjectSECs(Controller $instance)
    {
        $tag = "**_getProjectSECs**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sqlTAB = "SELECT  qset, sec, valuee FROM project_sec_map WHERE qset=".$_REQUEST['ids'];

          
            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("qset" => (int)$row["qset"], "sec" => $row["sec"], "valuee" => (int)$row["valuee"]);
                        array_push($response, $bd);
                        }
                        $status = 1;
                        $msg = "SECs is Here";
                    }
                } else {
                    $msg = "No SEC is Found";
                }
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

         /* query for project respondent ages detail*/
         public function _getProjectRespAges(Controller $instance)
    {
        $tag = "**_getProjectRespAge**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sqlTAB = "SELECT age, valuee, qset FROM project_age_map WHERE  qset =".$_REQUEST['ids'];

          
            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("age" => $row["age"], "valuee" => $row["valuee"], "qset" => $row["qset"]);
                        array_push($response, $bd);
                        }
                        $status = 1;
                        $msg = "Ages is Here";
                    }
                } else {
                    $msg = "No Age is Found";
                }
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

         /* query for project Stores detail*/
         public function _getProjectStores(Controller $instance)
    {
        $tag = "**_getProjectStores**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sqlTAB = "SELECT qset_id, store, valuee FROM project_store_loc_map WHERE qset_id =".$_REQUEST['ids'];

          
            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("qset_id" => (int)$row["qset_id"], "store" => $row["store"], "valuee" => (int)$row["valuee"]);
                        array_push($response, $bd);
                        }
                        $status = 1;
                        $msg = "Stores are Here";
                    }
                } else {
                    $msg = "No Store is Found";
                }
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

         /* query for project Products detail*/
         public function _getProjectProducts(Controller $instance)
    {
        $tag = "**_getProjectProducts**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sqlTAB = "SELECT  qset_id, product, valuee FROM project_product_map WHERE qset_id=".$_REQUEST['ids'];

          
            $rsTAB = mysqli_query($conn, $sqlTAB);
            if (!$rsTAB) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rsTAB->num_rows > 0) {
                    if ($rsTAB->num_rows > 0) {
                        // output data of each row
                        while ($row = $rsTAB->fetch_assoc()) {
                            $bd = array("qset_id" => (int)$row["qset_id"], "product" => $row["product"], "valuee" => (int)$row["valuee"]);
                        array_push($response, $bd);
                        }
                        $status = 1;
                        $msg = "Products are Here";
                    }
                } else {
                    $msg = "No Product is Found";
                }
            }
        }

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    /* query for exporting result  details */
    public
    function _exportResult(Controller $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
//        $first_id=0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['result']);
            $result = json_decode($jsonPost);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    if (!$isFirst) {
                        $column = $key;
                        $value = "'" . $val . "'";
                        $isFirst = true;
                    } else {
                        $column = $column . ", " . $key;
                        //$value = $value . ", '" . $val . "'";
                        $value = $value . ", '" . mysqli_real_escape_string($conn,$val) . "'";
                    }
                }
                if ($column != null && $value != null) {
                    $sql = "INSERT INTO UMEED2_40 (" . $column . ") VALUES (" . $value . ")";
                    if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
//                    if($first_id==0){
//                        $sql = "SELECT INTO UMEED2_40 (" . $column . ") VALUES (" . $value . ")";
//                    }
                }
            }
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported Successfully";
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }

    /* query for exporting result  details */
    public
    function _exportBoothDetails(Controller $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['result']);
            $result = json_decode($jsonPost);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    if (!$isFirst) {
                        $column = $key;
                        $value = "'" . $val . "'";
                        $isFirst = true;
                    } else {
                        $column = $column . ", " . $key;
                        $value = $value . ", '" . $val . "'";
                    }
                }
                if ($column != null && $value != null) {
                    $sql = "INSERT INTO mdbooth_details (" . $column . ") VALUES (" . $value . ")";
                    if (!mysqli_query($conn, $sql))
                        $this->_returnError($conn, $instance, $sql);
                }
            }
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported Successfully";
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }


        /* query for exporting multiple project respondent result  details */
    public
    function _exportRespondentDetails(Controller $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['result']);
            $result = json_decode($jsonPost);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    if (!$isFirst) {
                        $column = $key;
                        $value = "'" . mysqli_real_escape_string($conn,$val) . "'";
                        $isFirst = true;
                    } else {
                        $column = $column . ", " . $key;
                        $value = $value . ", '" . mysqli_real_escape_string($conn,$val) . "'";
                    }
                }
                if ($column != null && $value != null) {
                    $sql = "INSERT INTO app_respondent (" . $column . ") VALUES (" . $value . ")";
                    if (!mysqli_query($conn, $sql))
                        $this->_returnError($conn, $instance, $sql);
                } 
            }
            if ($isFirst) {
                $status = 1;
                $msg = "Respondent Exported Successfully";
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }

/////////////////////////////////////////////////////   NEW API //////////////////////////////////


public
function _exportMPResult(Controller $instance)
{   
$tag = "**_exportResult**";
    $conn = DBConnector::getDBInstance();
    $msg = "Unable To Export";
    $status = 0;
    $table = "";
    $rsp = 0; $qset_status = 0; $idt = null; $flag_tr=null;
    $checkFlag = 0;
    
    $arrData =  json_decode($_REQUEST['result']);
    $respId  =   $arrData['0']->resp_id; 
    $qset=$_REQUEST["qset_id"];
   
      
    if ($conn->connect_error) {
        $this->_returnError($conn, $instance, $tag);
        die("Connection failed: " . $conn->connect_error);
    } else {

////////////////////////////////////////// VALIDATION SECTION USERID AND NOT DUPLICATE /////////////////////////////////////////
$jsonPost = stripslashes($_REQUEST['result']);
      
        $result = json_decode($jsonPost); 
        foreach ($result as $json) { 
         $respid = $json->resp_id;
        }

    $flagsql = "SELECT `status`,`appuser_id` FROM `appuser_project_map` WHERE `project_id` ='$qset' AND `appuser_id`= '$respId' ";
  
    $resQ=  mysqli_query($conn, $flagsql);

    if ($resQ->num_rows > 0) {
        
        while ($row = $resQ->fetch_assoc()) {
            $flagstatus = $row["status"];
            $usrExist = $row["appuser_id"];
           
            if($flagstatus == 2){
                $status= 'false';
                $msg = 'Data is already inserted so please avoid redundancy';
                $data = array();
                $checkFlag = 1;
             $this->_returnResponse($conn, $instance, $status, $msg, $data);
                    die;

            }

        }
    } else{
        $status= 'false';
                $msg = 'Invalid User Data!';
                $data = array();
                $checkFlag = 1;
             $this->_returnResponse($conn, $instance, $status, $msg, $data);
                    die;


    }

////////////////////////////////////////    END OF THE VALIDATION SECTION /////////////////////////////
   
        //to find project table
   

        $sql = "SELECT `data_table` FROM `project` WHERE `project_id` = (SELECT distinct `project_id` FROM `questionset` WHERE `qset_id` IN(" . $_REQUEST["qset_id"] . "))";
        $rs = mysqli_query($conn, $sql);
        if (!$rs) {
            $this->_returnError($conn, $instance, $tag);
        } else {
            if ($rs->num_rows > 0) {
                
                while ($row = $rs->fetch_assoc()) {
                    $table = $row["data_table"];
                }
            }
        }

        $jsonPost = stripslashes($_REQUEST['result']);
        $str='Attempting..';
        $result = json_decode($jsonPost); 
        foreach ($result as $json) {
      $column = null; $isFirst = false;  $value = null; $idtt="i_date";
        
           
 foreach ($json as $key => $val) {
                if (!$isFirst) {
                    if($key == 'resp_id')
                       {$rsp = $val;}
                       $column = $key;
                    $value = "'" . mysqli_real_escape_string($conn,$val) . "'";
                    $isFirst = true;
                } else {
                   if($key =='resp_id')
                      { $rsp =$val;$column = $column . ", " . $key;}
                   else
                       {$column = $column . ", " . $key;}
                       $value = $value . ", '" . mysqli_real_escape_string($conn,$val) . "'";
      
                }
            }
            if ($column != null && $value != null) {
                 $sql = "INSERT INTO $table (" . $column . ") VALUES (" . $value . ");\n";
                           
                if (!mysqli_query($conn, $sql)){
                    $this->_returnError($conn, $instance, $sql);
                 }
            }
           $msg= $result;
        }
        if ($isFirst) {
            $status = 1;$dt = date('Y-m-d H:i:s');
    //to check the export status except for qset=111 if not exported

            $psqry="select  status from appuser_project_map WHERE appuser_id=$rsp AND project_id=$qset";
            $psr=mysqli_query($conn, $psqry);
            if($psr->num_rows > 0)
            {
                        while ($ps = $psr->fetch_assoc())
                        {
                            $qset_status=$ps["status"];
                        }
            }
    if($qset_status < 2 || $qset == 111)
    { 
      $flag_tr = null;
;

        if($qset == 111)
        {
                     
        }

            
            $dt = date('Y-m-d H:i:s');
            $qchk="UPDATE `appuser_project_map` SET `status`=2, exp_date='$dt'  WHERE `appuser_id`= $rsp and `project_id`=$qset";
               $ss=mysqli_query($conn, $qchk);
                    $qa="SELECT cr_point FROM `appuser_project_map` where `project_id`= ( select project_id from questionset where qset_id=$qset) and appuser_id=$rsp";
                    $rsq=mysqli_query($conn, $qa);
                               $rsq->num_rows;
                    if($rsq->num_rows>0)
                    {
                            while ($row = $rsq->fetch_assoc())
                            {
                                    $rpnt = $row["cr_point"];
                            }

                            if($rpnt>0)
                            {
                
                $remark="for contest : $qset ";
                if($qset != 111){
                                        echo $qq="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`,remarks) VALUES ($rsp,$qset,'$dt',$rpnt,'$remark')";
                                        mysqli_query($conn, $qq);
                } 
                                    if($qset == 111 && $flag_tr ==1){
                                        $qq="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`,remarks) VALUES ($rsp,$qset,'$dt',$rpnt,'$remark')";
                                        mysqli_query($conn, $qq);
                  }
                           }
                    }
            
        
            $msg = "Result Exported  Successfully";
        } //end of isFirst check
 } //end for export status
    } //end of else
    if($rsp!='')
    {
        $api=$_SERVER['QUERY_STRING'];
        $dt= date('Y/m/d H:i:s');
        $rip=$_SERVER['REMOTE_ADDR'];
        $uagent=$_SERVER['HTTP_USER_AGENT'];
        //$token= '' ;

        //$qrry="INSERT INTO api_log (user_id, api, timestamp, remote_ip, user_agent, token, status) VALUES ('$rsp','$api','$dt','$rip','$uagent','$token','$status')";
            //$rsq=mysqli_query($conn, $qrry);
    } $daata = array();
    $this->_returnResponse($conn, $instance, $status, $msg, $daata);
}



///////////////////////////////////////////////////// END NEW API FOR EXPORT RESULT //////////////////////////////

      /* query for exporting result  details of multiple projects*/
//     public
//     function _exportMPResult(Controller $instance)
//     {
// 	$tag = "**_exportResult**";
//         $conn = DBConnector::getDBInstance();
//         $msg = "Unable To Export";
//         $status = 0;
//         $table = "";
//         $rsp = 0; $qset_status = 0; $idt = null; $flag_tr=null;
// 	$qset=$_REQUEST["qset_id"];
       
          
//         if ($conn->connect_error) {
//             $this->_returnError($conn, $instance, $tag);
//             die("Connection failed: " . $conn->connect_error);
//         } else {

// 		//to find project table
//             $sql = "SELECT `data_table` FROM `project` WHERE `project_id` = (SELECT distinct `project_id` FROM `questionset` WHERE `qset_id` IN(" . $_REQUEST["qset_id"] . "))";
//             $rs = mysqli_query($conn, $sql);
//             if (!$rs) {
//                 $this->_returnError($conn, $instance, $tag);
//             } else {
//                 if ($rs->num_rows > 0) {
//                     // output data of each row
//                     while ($row = $rs->fetch_assoc()) {
//                         $table = $row["data_table"];
//                     }
//                 }
//             }
	
// //        $first_id=0;
	
//             $jsonPost = stripslashes($_REQUEST['result']); $str='Attempting..';
//             $result = json_decode($jsonPost);   
//                //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/test.txt", $jsonPost,FILE_APPEND | LOCK_EX, null);
//             foreach ($result as $json) {
//                 $column = null;
//                 $isFirst = false;
//                 $value = null; $idtt="i_date";
//                 foreach ($json as $key => $val) {
//                     if (!$isFirst) {
//                         if($key == 'resp_id')
//                            {$rsp = $val;}
// 			//if($key == 'i_date_111')
// 			//   { $idt = $val; }
// 			//else
//                           // {$column = $key;}
//                         $column = $key;
//                         //$value = "'" . $val . "'";
//                         $value = "'" . mysqli_real_escape_string($conn,$val) . "'";
//                         $isFirst = true;
//                     } else {
//                        if($key =='resp_id')
//                           { $rsp =$val;$column = $column . ", " . $key;}
//                        else
//                            {$column = $column . ", " . $key;}
//                         //$value = $value . ", '" . $val . "'";
//                        	$value = $value . ", '" . mysqli_real_escape_string($conn,$val) . "'";
// 			//if($key == 'i_date_111') { $idt = $val; }
//                     }
//                 }
//                 if ($column != null && $value != null) {
//                      $sql = "INSERT INTO $table (" . $column . ") VALUES (" . $value . ");\n";
//                                 //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/query.txt", $sql,FILE_APPEND | LOCK_EX, null); 
//                     if (!mysqli_query($conn, $sql)){
//                         $this->_returnError($conn, $instance, $sql);
//                      }
//                 }
//                $msg= $result;
//             }
//             if ($isFirst) {
//                 $status = 1;$dt = date('Y-m-d H:i:s');
//         //to check the export status except for qset=111 if not exported
   
//                 $psqry="select  status from appuser_project_map WHERE appuser_id=$rsp AND project_id=$qset";
//                 $psr=mysqli_query($conn, $psqry);
//                 if($psr->num_rows > 0)
//                 {
//                             while ($ps = $psr->fetch_assoc())
//                             {
//                                 $qset_status=$ps["status"];
//                             }
//                 }
//         if($qset_status < 2 || $qset == 111)
//         { 
//   		$flag_tr = null;
// ;
// /*
//             if(is_numeric($rsp))
//             {
//                          $irr="select sum(cr_point) as cr_point from credit_store where user_id=$rsp AND qset_id=$qset";
//                          $irk=mysqli_query($conn, $irr);
//                          if($irk->num_rows > 0)
//                          {        $iruid='';$irmk='';
//                             while ($ire = $irk->fetch_assoc())
//                             {
//                                 $crpnt=$ire["cr_point"];
//                             }
//                          }
//             }
// */
//             if($qset == 111)
//             {
//                          //$irq="select travel_status from app_log where resp_id=$rsp AND travel_status=1 AND start_time = '$idt'";
//                          //$irj=mysqli_query($conn, $irq);
//                          //if($irj->num_rows > 0)
//                          //{
//                          //       $flag_tr = 1;
//                          //}
//             }

//                 //to allow user to add credit point only if below condition is true i.e. max point in a project
//               //if($crpnt < 70)
//               //{

//                 //$response=array();$userid='';$login_status=0;$rpnt=0;
//                 $dt = date('Y-m-d H:i:s');
//                 $qchk="UPDATE `appuser_project_map` SET `status`=2, exp_date='$dt'  WHERE `appuser_id`= $rsp and `project_id`=$qset";
//                	$ss=mysqli_query($conn, $qchk);
//                         $qa="SELECT cr_point FROM `appuser_project_map` where `project_id`= ( select project_id from questionset where qset_id=$qset) and appuser_id=$rsp";
//                         $rsq=mysqli_query($conn, $qa);
//                                    $rsq->num_rows;
//                         if($rsq->num_rows>0)
//                         {
//                                 while ($row = $rsq->fetch_assoc())
//                                 {
//                                         $rpnt = $row["cr_point"];
//                                 }

//                                 if($rpnt>0)
//                                 {
// 					//echo "qset: $qset , $flag_tr .";
// 					$remark="for contest : $qset ";
// 					if($qset != 111){
//                                         	echo $qq="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`,remarks) VALUES ($rsp,$qset,'$dt',$rpnt,'$remark')";
//                                         	mysqli_query($conn, $qq);
// 					} 
//                                         if($qset == 111 && $flag_tr ==1){
//                                         	$qq="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`,remarks) VALUES ($rsp,$qset,'$dt',$rpnt,'$remark')";
//                                         	mysqli_query($conn, $qq);
//   					}
//                                }
//                         }
                
//              // } // end of crpnt
//                 $msg = "Result Exported  Successfully";
//             } //end of isFirst check
// 	 } //end for export status
//         } //end of else
//         if($rsp!='')
//         {
//         	$api=$_SERVER['QUERY_STRING'];
//         	$dt= date('Y/m/d H:i:s');
//         	$rip=$_SERVER['REMOTE_ADDR'];
//         	$uagent=$_SERVER['HTTP_USER_AGENT'];
//         	//$token= '' ;

//         	//$qrry="INSERT INTO api_log (user_id, api, timestamp, remote_ip, user_agent, token, status) VALUES ('$rsp','$api','$dt','$rip','$uagent','$token','$status')";
//                 //$rsq=mysqli_query($conn, $qrry);
//         }
//         $this->_returnResponse($conn, $instance, $status, $msg, null);
//     }

     /* query for exporting result  details of multiple projects one respondent at a time */
   
     public function _exportMPResultOneResp(Controller $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        $table="";
        $dt = date('Y-m-d H:i:s');

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $respid=$_REQUEST['resp_id']; $qsetid=$_REQUEST["qset_id"]; $pid=0;$st='0';

            $sql = "SELECT `data_table`, project_id FROM `project` WHERE `project_id` = (SELECT distinct `project_id` FROM `questionset` WHERE `qset_id` IN(" . $_REQUEST["qset_id"] . "))";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $table = $row["data_table"]; $pid= $row["project_id"];
                    }
                }
              }

       	    $resp_flag=0;
       	    $sql2 = "SELECT distinct resp_id FROM $table WHERE `q_id` = $qsetid AND resp_id=$respid";
            $rspc = mysqli_query($conn, $sql2);
            if (!$rspc) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rspc->num_rows > 0) { 
                       $resp_flag=1;
               }
            }

          if($resp_flag==0)
          {
            $jsonPost = stripslashes($_REQUEST['result']); 
            $result = json_decode($jsonPost);   
               //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/test.txt", $jsonPost,FILE_APPEND | LOCK_EX, null);
	if($result)
            foreach ($result as $json) {
		//print_r($json);  
              $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    if (!$isFirst) {
                        	$column = $key;
                        	//$value = "'" . $val . "'";
                        	$value = "'" . mysqli_real_escape_string($conn,$val) . "'";
                        $isFirst = true;
                    } else {
		
                       if($key == 'st')
                       {
				$st=$val;
		       }
                        	//$value = $value . ", '" . $val . "'";
				$column = $column . ", " . $key;
                       		$value = $value . ", '" . mysqli_real_escape_string($conn,$val) . "'";
                    }
                }
                if ($column != null && $value != null) {
                    $sql = "INSERT INTO $table (" . $column . ") VALUES (" . $value . ");\n";
                                //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/query.txt", $sql,FILE_APPEND | LOCK_EX, null); 
                    if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
                }
               $msg= $result;
             
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported in $table Successfully";
            }
          } 
          }
          if($resp_flag==1)
          {
             $status = 2;
                $msg = "Error! Result not Exported of resp_id: $respid";
          }
         
        }
                $dt = date('Y-m-d H:i:s');
                $msql="INSERT INTO `project_export_log`( `resp_id`, `qset_id`, `task`, `updated`, `remarks`, `pid`,st) VALUES ('$respid', $qsetid ,'Data Export','$dt','$msg',$pid,'$st' )";
                mysqli_query($conn, $msql);

		$tsq="UPDATE $table SET timestamp='$dt'  WHERE `q_id` = $qsetid AND resp_id=$respid AND r_name!='';";
                mysqli_query($conn, $tsq);

       $this->_returnResponse($conn, $instance, $status, $msg, null);
    }


    /* query for qutionset details*/
    public
    function _getQuestionsetDetails(Controller $instance)
    {
        $tag = "**_getQuestionDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

            $sql = "SELECT * from questionset where project_id IN(" . $_REQUEST["ids"] . ")";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $q = array("qset_id" => (int)$row["qset_id"], "project_id" => $row["project_id"], "visit_no" => $row["visit_no"]);
                        array_push($response, $q);
                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

   /* query for project detail*/
    public
    function _getQuestionIds(Controller $instance)
    {
        $tag = "**_getQuestionIds**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

           //$sql = "SELECT DISTINCT(qid) from question_sequence where qset_id=" . $_REQUEST["project_id"] . " ORDER BY  sid ASC ";
           $sql = "SELECT qid from question_sequence where qset_id=" . $_REQUEST["project_id"] . " ORDER BY  sid ASC ";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                $msg = 'Data Found';
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $response[] = $row["qid"];
                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }


    /* query for question sequence details */

    public
    function _getQuestionSequence(Controller $instance)
    {
        $tag = "**_getQuestionSequence**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
             $sql = "SELECT * from question_sequence where qid IN(" . $_REQUEST['ids'] . ")";
            
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $r = array("qset_id" => (int)$row["qset_id"], "qid" => (int)$row["qid"],
                            "sid" => (int)$row["sid"], "chkflag" => (int)$row["chkflag"]);
                        array_push($response, $r);

                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    /* query for routine check details */

    public
    function _getRoutineCheckDetails(Controller $instance)
    {
        $tag = "**_getRoutineCheckDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT * from question_routine_check where qid IN(" . $_REQUEST['ids'] . ")";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $r = array("qset_id" => (int)$row["qset_id"], "qid" => (int)$row["qid"],
                            "pqid" => (int)$row["pqid"], "opval" => (int)$row["opval"],
                            "flow" => (int)$row["flow"]);
                        array_push($response, $r);

                    }
                    $status = 1;
                }
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

     /* query for upload/save image on server  */

    public
    function _uploadImage(Controller $instance)
    {
        $tag = "**_uploadImage**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                    $image = $_REQUEST['image'];
                      $name = $_POST['name'];
                       $type = $_POST['type']; 
                       //$name.=".jpg";

                    if ($image!='')
                    {     
                        $path="http://13.232.11.235/digiamin-web/vcimsweb/uploads/image/$name";
                        if ($type=='image')
                        { $name.=".jpg";  file_put_contents($_SERVER['DOCUMENT_ROOT']."/html/digiamin-web/vcimsweb/uploads/image/$name",base64_decode($image)); $status = 1;
                                        $msg="Image Successfully uploaded";}
                        if ($type=='audio')
                        {   file_put_contents($_SERVER['DOCUMENT_ROOT']."/html/digiamin-web/vcimsweb/uploads/audio/$name".".mp3",base64_decode($image)); $status = 1;$msg="Audio Successfully uploaded"; }
                        if ($type=='video')
                        {   //file_put_contents($_SERVER['DOCUMENT_ROOT']."/vcimsweb/uploads/video/$name".".mp4", $image);
                             $target_path  = "./upload/";
                             $src = $_FILES['uploadedfile']['name'];

                             echo $target_path .= basename($src);
                             $msg="Not uploaded video $target_path";
                             if(file_exists($src) && move_uploaded_file($src, $target_path)) 
                             {
                               echo $msg="The file ".basename( $_FILES['uploadedfile']['name'])." has been uploaded"; $status = 1;
                             }
                                            
                         }

                        //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/image/$name",base64_decode($image));
     
                    }           
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $name);
    }

     /* query for upload video on server  */


    function _uploadmediaimageaudio(Controller $instance)
    {
        $tag = "**_uploadImage**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else{  // ELSE CONDITION START FROM HERE
            
            //CHEKING THE CORRECT VARIABLE PARAMETER
            $jsonPost = stripslashes($_POST['file_data']);
            $result = json_decode($jsonPost,true); 
            $errorflage1=0; $errorflage2=0;$errorflage3=0;$errorflage4=0;

     foreach ($result as $key => $val) 
                {    
	                 
                    if($key == 'user_id')
			                {   
                                  $user_id=$val;
                                  $errorflage1 =1;
                            }       
			                if($key == 'project_id')
			                {     
                                $project_id=$val;
                                $errorflage2 =1;
                            } 
                            if($key == 'question_id')
			                {     
                                $question_id=$val;
                                $errorflage3 =1;
                            }

                            if($key == 'option_id')
			                {     
                                $option_id=$val;
                                $errorflage4 =1;
                            }
   
                } 

                        //VALIDATING THE VARIABLE 
                            if(($errorflage1 != 1) || ($errorflage2 != 1) || ($errorflage3 != 1) || ($errorflage4 != 1)) {
                                    
                                $status = 0;
                                $msg = 'Invalid parameter!';
                                $userid = null;
                                $data = array();
                                $this->_returnResponse($conn, $instance, $status, $msg, $data);

                        } else {
                            
                            $dateTime = date('Y-m-d H:i:s');
                            $time = strtotime($dateTime);
            
                            $dateOnly = date('Y-m-d', $time);
                            $houronly = date('H', $time);
                            $minuteOnly = date('i', $time);
                            $fileVarName = $user_id.'_'.$project_id.'_'.$dateOnly.'_'.$houronly.'_'.$minuteOnly;
                                $mime = mime_content_type($_FILES['file_name']['tmp_name']);
                                
                                if(strstr($mime, "image/")){
                                    $extension  = pathinfo( $_FILES["file_name"]["name"], PATHINFO_EXTENSION );
                                    $allowedExts = array("gif", "jpeg", "jpg", "png","JPG","PNG","JPEG");
                                    if(in_array($extension, $allowedExts)){
                                       // $fielName =$user_id.'_'.$project_id.'_'.$question_id.'_'.$option_id.'.'.$extension;
                                        $newFileName= $fileVarName.'.'.$extension;
                                        $source       = $_FILES["file_name"]["tmp_name"];
                                        $destination  = $_SERVER['DOCUMENT_ROOT']."/digiamin-web/vcimsweb/uploads/image/$newFileName";
                                        $ftype = 'Image';
                                        $qidQset = $question_id.'_'.$project_id;
                                       $fupload = move_uploaded_file( $source, $destination );
                                       if($fupload){
 $mqq="INSERT INTO `media_tbl`(`file_name`, `file_type`, `user_id`, `project_id`,`question_id`,`option_id`,`qid_qset`,`dateTime`,`pathofstorage`) VALUES ('$newFileName','$ftype','$user_id','$project_id','$question_id','$option_id','$qidQset','$dateTime','$destination')";
		                              mysqli_query($conn, $mqq);
                                        $status = 1;
                                        $msg = 'Image File is uploaded successfully!';
                                        $data = array("file_name"=>"$newFileName");
                                        $this->_returnResponse($conn, $instance, $status, $msg, $data);
        
                                       }
        
                                    }
                                   
                               
                                }
                                
                                else if(strstr($mime, "audio/")){  
                                    $extension  = pathinfo( $_FILES["file_name"]["name"], PATHINFO_EXTENSION );

                                    //$fielName =$user_id.'_'.$project_id.'_'.$question_id.'_'.$option_id.'.'.$extension;
                                    $newFileName= $fileVarName.'.'.$extension;
                                    $source       = $_FILES["file_name"]["tmp_name"];
                                    $destination  = $_SERVER['DOCUMENT_ROOT']."/digiamin-web/vcimsweb/uploads/audio/$newFileName";
                                    $ftype = 'Audio';
                                    $qidQset = $question_id.'_'.$project_id;
                                    $fupload = move_uploaded_file( $source, $destination );
                                    if($fupload){
$mqq="INSERT INTO `media_tbl`(`file_name`, `file_type`, `user_id`, `project_id`,`question_id`,`option_id`,`qid_qset`,`dateTime`,`pathofstorage`) VALUES ('$newFileName','$ftype','$user_id','$project_id','$question_id','$option_id','$qidQset','$dateTime','$destination')";
                                   mysqli_query($conn, $mqq);
                                     $status = 1;
                                     $msg = 'Audio file is uploaded successfully!';
                                     $data = array("file_name"=>"$newFileName");
                                     $this->_returnResponse($conn, $instance, $status, $msg, $data);
     
                                    }

                                   
                                }
                                else if(strstr($mime, "video/")){
                                    $extension  = pathinfo( $_FILES["file_name"]["name"], PATHINFO_EXTENSION );
                                   // $fielName =$user_id.'_'.$project_id.'_'.$question_id.'_'.$option_id.'.'.$extension;
                                    $newFileName= $fileVarName.'.'.$extension;
                                    $source       = $_FILES["file_name"]["tmp_name"];
                                    $destination  = $_SERVER['DOCUMENT_ROOT']."/digiamin-web/vcimsweb/uploads/video/$newFileName";
                                    $ftype = 'Video';
                                    $qidQset = $question_id.'_'.$project_id;
                                    $fupload = move_uploaded_file( $source, $destination );
                                    if($fupload){
$mqq="INSERT INTO `media_tbl`(`file_name`, `file_type`, `user_id`, `project_id`,`question_id`,`option_id`,`qid_qset`,`dateTime`,`pathofstorage`) VALUES ('$newFileName','$ftype','$user_id','$project_id','$question_id','$option_id','$qidQset','$dateTime','$destination')";
                                   mysqli_query($conn, $mqq);
                                     $status = 1;
                                     $msg = 'Video file is uploaded successfully!';
                                     $data = array("file_name"=>"$newFileName");
                                     $this->_returnResponse($conn, $instance, $status, $msg, $data);
     
                                    }

                                }
                               
                        }
            

            // END THE CHEKING CORRECT PARAMETER
        } // ELSE CONDITION END HERE


    } 
     
    function _uploadVideo(Controller $instance)
    {
        $tag = "**_uploadVideo**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                    
/* 
 $target_path = "uploads/video/";

$msg=$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
{
    $msg="The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded"; $status=1;
}   
*/

$fn=basename( $_FILES['uploadedfile']['name']);
$fz=$_FILES['uploadedfile']['size'];
$msg=$fn; $msg.=" ,size: ".$fz;

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/html/digiamin-web/vcimsweb/uploads/video/$fn") )
{
    $status=1;
}

              /*     
                             $target_path  = $_SERVER['DOCUMENT_ROOT']."/uploads/video/";
                             $src = $_FILES['uploadedfile']['name'];

                             $target_path .= basename($src);
                             $msg="Not uploaded video $target_path"; 
    file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/image/$target_path.mp4",$src));
                             if(move_uploaded_file($src, $target_path)) 
                             {
                                $msg="The file ".basename( $_FILES['uploadedfile']['name'])." has been uploaded"; $status = 1;
                             }
             */              
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }



    /* query for appsignup result  details */
     
    function _appSignUp(Controller $instance)
    {
        
    }

     
    function _returnError($conn, $instance, $tag)
    {
        $instance->onError($tag . "->" . mysqli_error($conn));
        $conn->close();
        exit();
    }

     
    function _returnResponse($conn, $instance, $status, $msg, $response)
    {    //print_r($response);
        $conn->close();
        $instance->onSuccess($status, $msg, $response);
    }

}

