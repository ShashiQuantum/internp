<?php
include_once('DBConnector.php');
include_once('functions.php');

include_once('survey-function.php');

date_default_timezone_set('asia/calcutta'); 

class NewQueryManager
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
            self::$instance = new NewQueryManager();
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
 
    /* query for appsignup result  details */
    
    public  function _appSignUp(NewController $instance)
    {
        $tag = "**_appSignUp**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Signup";
        $status = 0;
               
	$dt = date('Y-m-d H:i:s');
	
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } 
        
        else {
$jsonPost = stripslashes($_POST['appsignup']);
   
$mobileKeyFlag =0;
$verfyKeyStatus =0;
$fcmKeyToken =0;
    $result = json_decode($jsonPost,true); 
     foreach ($result as $key => $val) 
                {    
	                    if($key == 'mobile')
			                {   
                                  $mobile=$val;
                                  $mobileKeyFlag =1;
                            }       
			                if($key == 'verifystatus')
			                {     
                                $verfyStatus=$val;
                                $verfyKeyStatus =1;
                            } 
                            if($key == 'fcm_token')
			                {     
                                $fcm_token=$val;
                                $fcmKeyToken =1;
                            }
                            
                } 

                 //VALIDATING THE VARIABLE 
    if(($mobileKeyFlag != 1) || ($verfyKeyStatus != 1) || ($fcmKeyToken != 1) ) {
            
        $status = false;
        $msg = 'Invalid parameter!';
        $userid = null;
        $data = array();
        $this->apiReturnError( $status, $msg, $userid, $data);

}

      //VALIDATING THE MOBILE NUMBER          
    if((!preg_match("/^\d+\.?\d*$/",$mobile)) || (strlen($mobile)!=10)  )
        {
            $status = false;
            $msg = 'Mobile number is not valid !';
            $userid = null;
            $data = array();
            $this->apiReturnError( $status, $msg, $userid, $data);
            

            
        }
              
                $qry="SELECT * FROM `app_user` WHERE  `mobile` ='$mobile' "; 
                $qresult=mysqli_query($conn, $qry);

                if($qresult->num_rows < 1){
                    
                   $sq1="INSERT INTO `app_user`(`mobile`, `status`,`fcm_token`) VALUES ('$mobile','$verfyStatus','$fcm_token')";
                   $rs1=mysqli_query($conn, $sq1);
                   if($rs1){
                    $userid=  mysqli_insert_id($conn);
                    $msg = "user register successfully ";
                    $status = 'true';
                    $data= array();
                    $this->apireturnResponse($conn, $instance, $status, $msg, $userid, $data);
                   }

                   
                } 
                
                else {   
                    while($obj = mysqli_fetch_assoc($qresult)){
                           $ustatus = $obj['status']; 
                           $userid = $obj['user_id']; 
           if(($ustatus == '0') &&  ($verfyStatus == '1') ){
            $sq1="UPDATE `app_user`  SET `status` = '1' WHERE `user_id` = $userid";
            $rs1=mysqli_query($conn, $sq1);
            if($rs1){

                $msg = "you already registered, successfully sign in : Welcome";
                    $status = 'true';
                    $data= array();

         $this->apireturnResponse($conn, $instance, $status, $msg, $userid, $data);

            }  
           
                
               }
            if($ustatus == '2'){
                $msg = "you already registered, but block by admin please contact admin@quantumcs.com";
                $status = 'true';
                $data= array();

     $this->apireturnResponse($conn, $instance, $status, $msg, $userid, $data);
                
                }

                if($ustatus == '1'){
                $msg = "successful signing : Welcome ";
                $status = 'true';
                $data= array();

     $this->apireturnResponse($conn, $instance, $status, $msg, $userid, $data);
                    }

                    }


                } 
             
        } 
    }    


    //COMMENT BY SHASHI

    //                                     if($key == 'plang')
	// 	              		{   $plang=$val;}

    //                                     if($key == 'imei')
	// 	              		{   $imei=$val;}
    //                                     if($key == 'oprator_name')
	// 	              		{   $oprator_name=$val;}
    //                                     if($key == 'network_circlr_location')
	// 	              		{   $net_loc=$val;}
    //                                     if($key == 'phone_type')
	// 	              		{   $phone_type=$val;}
    //                                     if($key == 'pin_code')
	// 	              		{   $pin_code=$val;}
	//            	}
    //             }
            
    //         } 
 
    //           $qchk="SELECT user_id FROM app_user WHERE user='$email' or mobil='$mobile' ";
    //           $rchk=mysqli_query($conn, $qchk);  
    //         if($rchk->num_rows < 1)
    //         {
    //                $sq1="INSERT INTO `app_user`(`user_name`, `user`, `mobil`, `pass`, `role`,`status`,`create_date`) VALUES ('$name','$email','$mobile','$pwd',5,1,'$dt')";
    //                $rs1=mysqli_query($conn, $sq1);
    //                $touser_id=mysqli_insert_id($conn);

			
    //        $qq1="INSERT INTO `mangopinion_57`(q_id,`resp_id`, `r_name`, `mobile`,`gender_57`, `email`, `nresp_educ`, `age_yrs`, `address`, `nresp_working_st`, `state`, `city`, `ref`, `imei`, `oprator_name`, `network_circlr_location`, `phone_type`, `nresp_dob`, plang) VALUES (57,$touser_id,'$name','$mobile','$gender','$email','$nresp_educ','$age_yrs','$address','$nresp_working_st','$state','$city','$ref','$imei','$oprator_name','$network_circle_location','$phone_type','$nresp_dob','$plang')";
    //          $aa=mysqli_query($conn, $qq1);

    //                          function generateRandomString($length = 6) 
    //            {
    //                   //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //                   $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //                   $charactersLength = strlen($characters);
    //                   $randomString = '';
    //                   for ($i = 0; $i < $length; $i++) {
    //                   $randomString .= $characters[rand(0, $charactersLength - 1)];
    //                   }
    //                  return $randomString;
    //             }
    //             $tokenparta = generateRandomString(6);

    //            $qrr1="INSERT INTO `app_refralcode_detail`( `user_id`, `refcode`, `remarks`) VALUES ($touser_id,'$tokenparta','$name')";
    //            $a2=mysqli_query($conn, $qrr1);
    //            $rfid=mysqli_insert_id($conn);
    //             if($rfid<1)
    //             {   $strt=$touser_id; $strt.=substr($name,0,3);
    //                 $qrr2="INSERT INTO `app_refralcode_detail`( `user_id`, `refcode`, `remarks`) VALUES ($touser_id,'$strt','$name')";
    //                 $a3=mysqli_query($conn, $qrr2);      
    //             }

    //             //to credit Rs 50/- for each user
    //             $qw1="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($touser_id,0,'$dt',50,'Welcome points')";
    //                          mysqli_query($conn, $qw1);

    //            if($ref!='')
    //            {   
    //                  //$fruid=intval(preg_replace('/[^0-9]+/', '', $ref), 10);

    //                  // $rr= "SELECT `user_id`, `user_name`, `user`, `mobil`, `pass`, `salt`, `role`, `create_date`, `last_login`, `status` FROM `app_user` WHERE `user_id`=$fruid";
    //                  //and `user_name`like 'gre%'
    //                  //$rk=mysqli_query($conn, $rr);

    //                if(is_numeric($ref))
    //                {
    //                      $irr="SELECT `intvr_id`, `remarks`, `centre`, `irefcode` FROM `mangop_interviewer_referral_detail` WHERE `irefcode`= $ref";
    //                      $irk=mysqli_query($conn, $irr);
    //                      if($irk->num_rows > 0)
    //                      {        $iruid='';$irmk='';
    //                         while ($ire = $irk->fetch_assoc()) 
    //         	            {
    //               	        $iruid=$ire["intvr_id"];
    //               	        $cen=$ire["centre"];
    //                         }
    //                         $iq3="INSERT INTO `mangop_interviewer_app_user_ref`(`user_id`, refcode, `intvr_id`, `dtime`,centre) VALUES ($touser_id,'$ref',$iruid,'$dt',$cen)";
    //                         mysqli_query($conn, $iq3); 
    //                      }
        
    //                }
    //                else if(!is_numeric($ref))
    //                {
    //                  echo $rr="SELECT `id`, `user_id`, `refcode`, `remarks` FROM `app_refralcode_detail` WHERE `refcode`= '$ref'";
    //                   $rk=mysqli_query($conn, $rr);
    //                   if($rk->num_rows > 0)
    //                   {   $ruid='';$rmk='';
    //                       while ($re = $rk->fetch_assoc()) 
    //         	          {
    //               	     $ruid=$re["user_id"];
    //               	     $rmk=$re["remarks"];
    //                       }
    //           	         echo $q3="INSERT INTO `app_user_ref`(`to_user_id`, `ref_code`,fr_user_id,dtime) VALUES ($touser_id,'$ref',$ruid,'$dt')";
    //           	         mysqli_query($conn, $q3);

    //                        // $qw="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($touser_id,0,'$dt',0,'refered by his friend with userid: $ruid $rmk')";
    //                        // mysqli_query($conn, $qw);
    //                           $qw1="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($ruid,0,'$dt',0,'refered to his friend of userid: $touser_id')";
    //                          mysqli_query($conn, $qw1);
    //                    }
    //                 }
                    

    //            } 
    //             $status = 1;
    //             $msg = "Sign Up Successfully";
    //       if($email!='')
	// 	  {	
	// 	  	$headers  = 'MIME-Version: 1.0' . "\r\n";
	// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// 		$headers .= 'From: contact@mangopinion.com' . "\r\n" .'Reply-To: $email';
	// 		$m.='Dear '.$name.', <br><br><br> Welcome from Mangopinion! <br> Please login to continue to attend the contest and earn the reward points. <br><br><br> Thanks,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
	// 		$s="Mangopinion user account created ";
			
	// 		$fs= mail($email, $s, nl2br($m), $headers);
    //  		}		

    //         }
    //         else {$status=2; $msg="User already registered with this mobile/email";}
    //       //}
    //         //else {$status=0; $msg="Duplicate imei";} 
    //     }
    //     $this->_returnResponse($conn, $instance, $status, $msg, null);
    // }
    
    
    /* query for applogin result  details */
    public
    function _appLogin(NewController $instance)
    {
        $tag = "**_appLogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Login";
        $status = 0; $token='';$respd='';
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
		//print_r($_POST['applogin']);
            $jsonPost = stripslashes($_POST['applogin']);
            $loginid=''; $pwd=''; $userid='';
            $result = json_decode($jsonPost);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "loginid")
                   		$loginid=trim($val);
              		if($key == "password")
                   		$pwd=$val;
                }                
            }
 		$token="login: $loginid , $pwd";
            //print_r($dlist);
     		$response=array();$userid='';$login_status=0;$qq='';
          
     	       if(is_numeric($loginid))
               {
                   $qq="SELECT `user_id`,status FROM `app_user` WHERE `mobil`='$loginid' AND pass='$pwd'";
               }else {$qq="SELECT `user_id`,status FROM `app_user` WHERE user='$loginid' AND pass='$pwd'";}
  		//echo $qq;
              //$qchk="SELECT user_id, status FROM app_user WHERE user='$loginid' AND pass='$pwd'";
                 $rchk=mysqli_query($conn, $qq);
                 $status = 0;
            if($rchk->num_rows > 0)
            {   
            	while ($re = $rchk->fetch_assoc()) 
            	{
                  	$status=$re["status"];
                  	$userid=$re["user_id"];
                }
               
               /*  
                $qrr="SELECT `user_id`, `name`, `mobile`, `email`, `address`,`nresp_age_yrs`,`nresp_gender`,plang FROM respondent_detail WHERE user_id='$userid' AND name!=''";
                $rso=mysqli_query($conn, $qrr);
                while ($row = $rso->fetch_assoc()) {
                        $bd = array("user_id" => $row["user_id"], "name" => $row["name"], "mobile" => $row["mobile"],"email" => $row["email"],"address" => $row["address"],"age" => $row["nresp_age_yrs"],"gender" => $row["nresp_gender"],"plang" => $row["plang"],"sec" => $row["nresp_sec"],"login_status" => $status);
                        
                        array_push($response, $bd);                        
                }
               */
 

                $qrr="SELECT a.`resp_id`, a.`r_name`, a.`mobile`, a.`email`, a.`address`,a.state,city, a.`age_yrs`, a.`gender_57`, a.nresp_educ, a.nresp_working_st, b.refcode, a.nresp_dob ,a.plang FROM mangopinion_57 a join app_refralcode_detail b ON a.resp_id=b.user_id WHERE a.resp_id='$userid' AND a.email!=''";
                $rso=mysqli_query($conn, $qrr);
                while ($row = $rso->fetch_assoc()) {
                        $bd = array("user_id" => $row["resp_id"], "name" => $row["r_name"], "mobile" => $row["mobile"],"email" => $row["email"],"address" => $row["address"],"state" => $row["state"],"city" => $row["city"],"age" => $row["age_yrs"],"gender" => $row["gender_57"],"nresp_educ" => $row["nresp_educ"],"nresp_working_st" => $row["nresp_working_st"],"refralcode" => $row["refcode"], "nresp_dob" => $row["nresp_dob"],"plang" => $row["plang"], "login_status" => $status);
                        
                        array_push($response, $bd);             
                }


                $dt = date('Y-m-d H:i:s');
                $ull="UPDATE `app_user` SET  `last_login`='$dt' WHERE `user_id`=$userid ";
                mysqli_query($conn, $ull);
                        
                $status = 1;
                $msg = "Login Successfully";

          // add default Jasmin1 (111) instead of mangopinion(57) project 
          $cst=DB::getInstance()->query("SELECT * FROM `appuser_project_map` WHERE `appuser_id`=$userid AND `project_id`=111");
          if($cst->count() < 1)
          {
             DB::getInstance()->query("INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`, cr_point, `status`) VALUES (111,$userid,5,0)");
                     
	    		    //DB::getInstance()->query("UPDATE `appuser_project_map` SET  `cr_point`=5  WHERE `appuser_id`=$userid AND `project_id`=111 AND `status`=0");
          }
        
         //end to add mangopinion project
	//add project profile with 20 point
          $cst=DB::getInstance()->query("SELECT * FROM `appuser_project_map` WHERE `appuser_id`=$userid AND `project_id`=122");
          if($cst->count() < 1)
          {
             DB::getInstance()->query("INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`, cr_point, `status`) VALUES (122,$userid, 20,0)");

                            //DB::getInstance()->query("UPDATE `appuser_project_map` SET  `cr_point`=20 WHERE `appuser_id`=$userid AND `project_id`=120 AND `status`=0");
          }
	//end of profile project

            }            
        }

        	// for API call log
        if($userid!='')
        {
	$api=$_SERVER['QUERY_STRING'];
        $dt= date('Y/m/d H:i:s');
	$rip=$_SERVER['REMOTE_ADDR'];
	$uagent=$_SERVER['HTTP_USER_AGENT'];
	//$token= '' ;
 
 	$qrry="INSERT INTO api_log (user_id, api, timestamp, remote_ip, user_agent, token, status) VALUES ('$userid','$api','$dt','$rip','$uagent','$token','$status');";
		$rsq=mysqli_query($conn, $qrry);
        }

	//DB::getInstance()->query($qrry);
	// end of API
      

        $this->_returnResponse($conn, $instance, $status, $respd, $response);
    }
    
    /* query for appuser project map  details */
   // NEW API 
   
   public function _appUserProject(NewController $instance)
   {
       $tag = "**_appUserProject**";
       $conn = DBConnector::getDBInstance();
       
       $userid =  stripslashes($_POST['appuserid']);
       if ($conn->connect_error) 
       {
           $this->_returnError($conn, $instance, $tag);
           die("Connection failed: " . $conn->connect_error);
           die;
       } 

       
   $sqlTAB = "SELECT appuser_project_map.project_id , appuser_project_map.status as surveyStatus ,  appuser_project_map.response_type , appuser_project_map.survey_type , appuser_project_map.cr_point, project.name , project.company_name , project.brand, project.sample_size, project.data_table, project.research_type, project.survey_start_date ,  project.survey_end_date, project.category,project.tot_visit, project.status as projectStatus FROM appuser_project_map INNER join project ON appuser_project_map.project_id= project.project_id WHERE appuser_project_map.status=0 AND appuser_project_map.exp_date >= DATE( NOW( ) ) AND appuser_project_map.appuser_id = $userid";
   $rsTAB = mysqli_query($conn, $sqlTAB);

           if ($rsTAB->num_rows < 1) 
           {  
               $status = 'true';
               $msg = 'user_data_not_found';
               $userid = $userid;
               $data = array();
               $this->apiReturnError( $status, $msg, $userid, $data);
           } 


           //IF FIRST TIME QUERY EXCUTE
           else 
           {
               $dataArray1 = mysqli_fetch_all ($rsTAB, MYSQLI_ASSOC);
       
             //  print_r($dataArray1);die;


               //MAIN FOREACH LOOP 
               $j=0;
        foreach($dataArray1 as $data1){

           $k=0;
           if($data1['survey_type'] == 1)
                  {
       $projectid= $data1['project_id'];
       $remidsql = "SELECT interval_hours, occurence, restrict_occurance_between ,excution_time FROM reminder  WHERE project_id = $projectid";
       $resRem = mysqli_query($conn, $remidsql);
       $dataArray2 = mysqli_fetch_all ($resRem, MYSQLI_ASSOC);
                 
            
                //SECOUND FOREACH LOOP
                $i=0;   
                foreach($dataArray2 as $data2){
                  $timestringe =($data2['excution_time']);
                  

                  $timeArray = explode(",",$timestringe);
                  $data2['excution_time'] =$timeArray;

                  $i++;
              
               
                }  
                    //END SECOUND FOREACH 


                $data1['reminder'] = $data2;
              
                  }
                 //END IF CONDITION IF SURVEY TYPE 1          

               
                 // IF SURVEY IS SINGLE TYPES
                  else 
                  {
                   
                   $remNullArray = array();
                   $data1['reminder'] =  $remNullArray;
                   
                   
                
               }
               $datalast[$j]= $data1;  
               $j++;

                 }
               }
               
               $status = 'true';
               $msg = 'data_found';
               $userid = $userid;
               $data =  $datalast;

              $this->apireturnResponse($conn, $instance, $status, $msg, $userid, $data);
   
           } 
               
    


    function _getRoutineDetails(NewController $instance)
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
            
                     $sql = "SELECT * from question_routine_detail where qset_id=" . $_REQUEST['pid'];
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

    /* query for app forget password */
    public
    function _appForgetPassword(NewController $instance)
    {
        $tag = "**_appforgetpassword**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To go forget password";
        $status = 0;$loginid='';$m='';
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['appuseremail']);
            $loginid='';$uname='';$email='';$pass='';
            $result = json_decode($jsonPost);
            foreach ($result as $json) 
            {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "loginid")
                   		$loginid=$val;              		
                }                
            }
            //print_r($dlist);
     		$response=array();$userid='';$login_status=0;
     		 if(is_numeric($loginid))
               {
                   $qchk="SELECT `user_id`,user_name,user,mobil,pass FROM `app_user` WHERE `mobil`='$loginid'";
               }else 
                 {
                     $qchk="SELECT user_id, user_name, user,mobil,pass FROM app_user WHERE  user='$loginid'";
                 }

                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {   
                while ($row = $rchk->fetch_assoc()) 
                {
                    $uname=$row["user_name"]; $email=$row["user"];                 
                    $pass = $row["pass"];                        
                }
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: contact@mangopinion.com' . "\r\n" ;
                $m.='Dear '.$uname.', <br><br><br>Your password : '.$pass.' <br><br><br> Thanks,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
                $s="Mangopinion App Forget Password";

               $fs= mail($email, $s, nl2br($m), $headers);
                
                if($fs)
                {    $status = 1;
                    $msg = "Password in email send Successfully";
                }
                else
                {
                     $status = 0;
                    $msg = "email failed to send";
           
                }
            }
            else $status = 0;
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    
    //app user change password
    public
    function _appChangePassword(NewController $instance)
    {
        $tag = "**_appChangePassword**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To go Change Password";
        $status = 0;$loginid='';$m='';
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['appmanagepwd']);
            $userid='';$op='';$np='';$status='';$uname='';$pass='';$email='';
            $result = json_decode($jsonPost);
            foreach ($result as $json) 
            {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "userid")
                   		$userid=$val; 
                        if($key == "old_pwd")
                   		$op=$val;
                        if($key == "new_pwd")
                   		$np=$val;             		
                }                
            }
            //print_r($result);
     		$response=array();$login_status=0;
     		                
                   $qchk="SELECT `user_id`,user_name,user,mobil,pass FROM `app_user` WHERE `user_id`=$userid";
              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {   
                while ($row = $rchk->fetch_assoc()) 
                {
                    $uname=$row["user_name"];
                    $pass = $row["pass"];
                    $email=$row["user"];    
                }  
                if($op==$pass)
                {    $up="UPDATE app_user SET pass=$np WHERE user_id=$userid";
                     mysqli_query($conn, $up);
                     $status=1;
                }
            }
             if($status > 0)
            {  
                 
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: contact@mangopinion.com';
                $m.='Dear '.$uname.', <br><br><br>Your old password has changed now and your new login password : '.$np.' <br><br><br> With Regards,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
                $s="Mangopinion App user Password Changed";
                $fs= mail($email, $s, nl2br($m), $headers);
                $msg = "Mangopinion user's password changed Successfully";                 
            }
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    
    /* query export status update */
    public
    function _appExportStatus(NewController $instance)
    {
        $tag = "**_exportstatusupdate**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;$loginid='';$m='';
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['appexpst']);
            $loginid='';$qsetid='';
            $result = json_decode($jsonPost);
            foreach ($result as $json) 
            {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "loginid")
                   		$loginid=$val;
                        if($key == "qsetid")
                   		$qsetid=$val;              		
                }                
            }
            //print_r($dlist);
              /*     $crpnt=0;
		   if(is_numeric($loginid))
                   {
                         $irr="select sum(cr_point) as cr_point from credit_store where user_id=$loginid AND qset_id=$qsetid";
                         $irk=mysqli_query($conn, $irr);
                         if($irk->num_rows > 0)
                         {        $iruid='';$irmk='';
                            while ($ire = $irk->fetch_assoc()) 
            	            {
                  	        $crpnt=$ire["cr_point"];
                  	        
                            }
                            
                         }
        
                   }

		//to allow user to add credit point only if below condition is true i.e. max point in a project
              if($crpnt < 70)
              {
		*/
     		$response=array();$userid='';$login_status=0;$rpnt=0;
     		$cdate = date('Y-m-d H:i:s');
                 $qchk="UPDATE `appuser_project_map` SET `status`=2, exp_date='$cdate'  WHERE `appuser_id`= $loginid and `project_id`=$qsetid";
                 mysqli_query($conn, $qchk);
                          $status=1;
              /*  else
                 {      
                 	$qa="SELECT `cr_point` FROM `appuser_project_map` where `project_id`= ( select project_id from questionset where qset_id=$qsetid) and appuser_id=$loginid";
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
                 			$qq="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`) VALUES ($loginid,$qsetid,'$cdate',$rpnt)";
                 	 		mysqli_query($conn, $qq);
                 	 	}
                 	}
                 	$status=1;
                        $msg = "export status updated sucessfully";
                 }       
              } // end of crpnt
	*/
        }
	           // for API call log
        if($userid!='')
        {
        $api=$_SERVER['QUERY_STRING'];
        $dt= date('Y/m/d H:i:s');
        $rip=$_SERVER['REMOTE_ADDR'];
        $uagent=$_SERVER['HTTP_USER_AGENT'];
        //$token= '' ;

        $qrry="INSERT INTO api_log (user_id, api, timestamp, remote_ip, user_agent, token, status) VALUES ('$loginid','$api','$dt','$rip','$uagent','$token','$status');";
                $rsq=mysqli_query($conn, $qrry);
        }

        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    
        /* query for getting credit store  details */
    public
    function _appGetCrStore(NewController $instance)
    {
        $tag = "**_appcrstore**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get Cr Store";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();$userid='';$login_status=0;
     		$uid=$_REQUEST['userid'];
               $qchk="SELECT  `user_id`, `qset_id`, `i_date`, `cr_point`, remarks FROM `credit_store` WHERE user_id=$uid";
              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {   
            	while ($row = $rchk->fetch_assoc()) 
            	{       $qset= $row["qset_id"];
            	        $pn=get_qset_project_name($qset);
                         if($qset==0)
                           $pn='NA';
                  	$r = array("user_id" => (int)$row["user_id"], "project" => $row["qset_id"], "i_date" => $row["i_date"],"cr_point" => $row["cr_point"],"project" => $pn,"remarks" => $row["remarks"]);
                  	array_push($response,$r);
                }
                        
                $status = 1;
                $msg = "Get Credit Store Successfully";
            }
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
    
        /* query for getting redeem  details */
    public
    function _appGetRedeem(NewController $instance)
    {
        $tag = "**_appcrstore**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get redeem details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();$userid='';$login_status=0;
     		$uid=$_REQUEST['userid'];
               $qchk="SELECT `user_id`, `rd_date`, `rd_mode`, `ord_id`, `transaction_id`, `rd_point`, flag,`remarks` FROM `credit_redeem` WHERE `user_id`=$uid order by rd_date desc";
              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {   
            	while ($row = $rchk->fetch_assoc()) 
            	{
            		
                  	$r = array("user_id" => (int)$row["user_id"], "rd_mode" => (int)$row["rd_mode"], "rd_date" => $row["rd_date"],"rd_point" => $row["rd_point"],"ord_id" => $row["ord_id"],"transaction_id" => $row["transaction_id"],"flag" => $row["flag"],"remarks" => $row["remarks"]);
                  	array_push($response,$r);
                }
                        
                $status = 1;
                $msg = "Get Redeem Details Successfully";
            }
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    //get and store gcm user registration
       
    public  function _gcmGetUser(NewController $instance)
    {
        $tag = "**_gcmgetUser**";
        $conn = DBConnector::getDBInstance();

        $msg = "Unable To get user reg details";
        $status = 0;
        
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['userdata']);
            $result = json_decode($jsonPost); 
            $useridFlag =0;
            $gcmidFlag =0;
           
            foreach ($result as $key => $val) {
               
                if($key == "userid"){
                   $userid=$val;
                   $useridFlag =1;
                }
                if($key == "gcmid"){
                   $gcmid=$val; 
                   $gcmidFlag =1;
                }
            
            }

      if($useridFlag != 1 || $gcmidFlag !=1)     
      {
        $status =0;
        $msg = 'Parameter Variable  Name is Not Valid !';
        $data = array();
        $this->_returnResponse($conn, $instance, $status, $msg, $data);
        die;

      }
        $currdate = date('Y-m-d H:i:s'); 
            
         // CHECK IF USER IS EXIST ALREADY IN TABLE   

         
               $qchk="SELECT `user_id`, `gcm_regid` FROM `gcm_users` WHERE `user_id`= '$userid'";
                 $qqchk=mysqli_query($conn, $qchk);
                 
                 if($qqchk->num_rows > 0)
                 {    
                        $qq="UPDATE `gcm_users` SET `gcm_regid`='$gcmid' WHERE `user_id`=$userid";
                        $qupdflag = mysqli_query($conn, $qq);
                        if($qqchk)
                        {
                        $status =1;
                        $msg = "User $userid GCM ID updated successfully !";
                        $data = array("userId"=>$userid ,"GCMID"=>$gcmid);
                        $this->_returnResponse($conn, $instance, $status, $msg, $data);
                        }   
                 } else {
                    $qqq="INSERT INTO `gcm_users`(`user_id`, `gcm_regid`,  `created_at`) VALUES ('$userid','$gcmid','$currdate')";
                 	 	$qryflag =	mysqli_query($conn, $qqq);
                        if($qryflag){
                        $status =1;
                        $msg = "User $userid Registered successfully !";
                        $data = array("userId"=>$userid ,"GCMID"=>$gcmid);
                        $this->_returnResponse($conn, $instance, $status, $msg, $data);

                        }

                 }
           	
		
    }
    }
    //do redeem request process
        
    public function _appDoRedeem(NewController $instance)
    {
        $tag = "**_appDoRedeem**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To do redeemtion";
        $status = 0;$mode=0;$oid=0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['rdata']);

            $userid=null;$rpnt=null;$email='';
            $result = json_decode($jsonPost); 
            foreach ($result as $json) 
            {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "userid")
                   		$userid=$val;
                        if($key == "rpoint")
                   		$rpnt=$val;
                        if($key == "mode")
                   		$mode=$val; 
                        if($key == "order_number")
                   		$oid=$val;                                    		
                 }
     		$cdate = date('Y-m-d H:i:s'); 
                 $qchk="SELECT  sum(cr_point) as cr FROM `credit_store` WHERE user_id= $userid";
                 $qqchk=mysqli_query($conn, $qchk);
                     $cr=0; 
                      while($row1 = $qqchk->fetch_assoc()) 
                      {  $cr = $row1["cr"];}
                 $qchk2="SELECT  sum(rd_point) as rd FROM `credit_redeem` WHERE user_id= $userid";
                 $qqchk2=mysqli_query($conn, $qchk2);
                     $rd=0; while($row2 = $qqchk2->fetch_assoc()){  $rd = $row2["rd"];}
                  $bal=$cr-$rd;
                 if($bal>0)
                 {     
                       
                        $qq="INSERT INTO `credit_redeem`(`user_id`, `rd_date`, `rd_mode`, `ord_id`, `transaction_id`, `rd_point`,flag, `remarks`) VALUES ($userid,'$cdate','$mode','$oid','NA',$rpnt,1,'pay mode 2')";
                         mysqli_query($conn, $qq);
                         $qq3="UPDATE `order_detail` SET status=1 WHERE user_id=$userid AND ord_id=$oid";
                         mysqli_query($conn, $qq3);

                         $qa="SELECT `resp_id`, `r_name`, `mobile`, `email` FROM mangopinion_57 WHERE resp_id=$userid and email!=''";
                 	$rsq=mysqli_query($conn, $qa);
                 	if($rsq->num_rows>0)
                 	{   $name='';$email='';$mob='';
                 		while ($row = $rsq->fetch_assoc()) 
		                {
		                        $name = $row["r_name"];
                                        $email = $row["email"];
                                        $mob = $row["mobile"];
                                 }
                                 if($email!='')
                                 {
                                 $headers  = 'MIME-Version: 1.0' . "\r\n";
                                 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                 $headers .= 'From: contact@mangopinion.com';
                                 $m.='Dear '.$name.', <br><br><br>Your request of redemption point : '.$rpnt.' has done successfully.<br><br> With Regards,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
                                 $s="Mangopinion reward points Redeem details";

                                 $fs= mail($email, $s, nl2br($m), $headers);
                                 }
                         }

                         $status=1;$msg = "Reward points Redeemed successfully";
                       
                 }
                 else
                 {      
                 	$status=0;
                        $msg = "Redeem request not successfully";
                 } }     
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $mode);
    }

        /* query for getting Mobikwik checksum details */
    public
    function _getMobiChecksum(NewController $instance)
    {
        $tag = "**_getmobichecksum**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get mobi checksum details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();$userid='';$login_status=0;
     		$uid=$_REQUEST['userid'];
                $amount=$_REQUEST['amount'];
                $mobile=$_REQUEST['mobile'];
                $email=$_REQUEST['email'];

                $qchk="SELECT * FROM `credit_store` WHERE `user_id`=$uid and cr_point > 0";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {   
            	$date = date('Y-m-d H:i:s');
                $qq="INSERT INTO `order_detail`(`user_id`, `mobile`, `email`, `pay_mode`, `amount`, `status`, `remarks`,ord_date) VALUES ($uid,'$mobile','$email',1,$amount,0,'','$date')";
                $inv=mysqli_query($conn, $qq);
                $orderid=mysqli_insert_id($conn);

                $mtype=0;$crmethod='cashback'; 
                        //$mid='MBK9002';
                $mid='MBK5959';
                $marname='Digiadmin Consumer';
//$marname='TestMerchant'; 
$cmnt='check';
 
                //$wid='testapisupport@gmail.com';
                $wid='abhishek.chaubey@digiadmin.quantumcs.com';
                $algo = 'sha256';
                 //$markey='ju6tygh7u7tdg554k098ujd5468o';  
                //old one $markey='So2hFlP8JFjRsF1LlxMT507TUzA8';
		$markey='p0hmX4ug5pMhFrt5hL4hYRZeX7II';
    	        $checksum_string = "'{$amount}''{$mobile}''{$cmnt}''{$crmethod}''{$marname}''{$mid}''{$orderid}''{$mtype}''{$wid}'";    	
    	       
                $checksum = hash_hmac($algo, $checksum_string, $markey);
                        	   
                $response= $checksum;   
     
                $status = 1;
                //$msg = "Get MobiChecksum Details Successfully";
                $msg=$orderid;
            }
            else
            {  $status=0; }
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
       //To check existing Mobikwik user or not
    public
    function _isMobikwikUser(NewController $instance)
    {
        $tag = "**_isMobikwikUser**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get isMobikwikUser detail";
        $status = 0;$resp=null;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           	//write code here
		$mobile=$_REQUEST['mobile'];
		$userid=$_REQUEST['userid'];

           	//$status = 1;
		if($mobile!='' && $userid!='')
		{
			$msg="Successful";
			$skey="p0hmX4ug5pMhFrt5hL4hYRZeX7II";
			$resp=$chks_str = "'existingusercheck''$mobile''Digiadmin Consumer''MBK5959''500'";
			$chks=$this->calculateChecksum($skey, $chks_str);
			
			$data=array("checksum"=>"$chks","cell" => "$mobile","msgcode"=>"500","mid"=>"MBK5959","merchantname"=>"Digiadmin Consumer","action"=>"existingusercheck");
			$url="https://walletapi.mobikwik.com/querywallet";
			$method="GET";

			$rdd=$this->CallAPI($method, $url, $data);
			$tf='SUCCESS';
			$pos = strpos($rdd, $tf);
			if($pos === FALSE ){
  				$status=0; }
			else{
   				$status=1; }
		}

         } //end of else 
         
             $this->_returnResponse($conn, $instance, $status,$msg,null);
    }
    
    //checksum function for check mobkwik user
        private function calculateChecksum($secretKey,$allParamValue){
                $hash = hash_hmac('sha256', $allParamValue , $secretKey);
				$checksum = $hash;
                return $checksum;
        }
    //Function to call API
    //begin of function
     private function CallAPI($method, $url, $data = false)
     {
    	$curl = curl_init();
    	switch ($method)
    	{
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    	}
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array( 'postman-token' => '9a007300-6c17-8786-6079-c03e04570c3f',  'cache-control' => 'no-cache','content-type' => 'application/x-www-form-urlencoded','authorization' => 'Basic ZGV2LmFwcC5yZXBvcnRAZ21haWwuY29tOnZhcmVuaWE0MjU=','payloadtype' => 'json'));
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	$result = curl_exec($curl);
    	curl_close($curl);

    	return $result;
    }
    
    //To process the point redeemption by mobikwik
    public
    function _doMobikwikRedeem(NewController $instance)
    {
        $tag = "**_doMobikwikRedeem**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get doMobikwikRedeem details";
	$msg=null; $token=null;
        $status = 0;$response=null; $email='';$uid=null;$amount=null;$orderid=null;  
		
		//total allowed point to redeeem
		$max_pnt_user = 101;
		$max_pnt_alluser = 1001;
		
		$date = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                //write code here
                $mobile=$_REQUEST['mobile'];
                $uid=$_REQUEST['userid'];
                $amount=$_REQUEST['points'];
				$token="mobile: $mobile , uid: $uid , point : $amount";

					//to get credit point earned details
					$qchk="SELECT  sum(cr_point) as cr FROM `credit_store` WHERE user_id= $uid";
					$qqchk=mysqli_query($conn, $qchk);
                    			$cr=0;$user_flag=0; 
					while($row1 = $qqchk->fetch_assoc()) {  $cr = $row1["cr"]; $user_flag=1; }
		if(!($uid == 0 || $uid == '0' || $uid == '' || $user_flag == 0) ){			
					//to get debited / redeem details
					$qchk2="SELECT  sum(rd_point) as rd FROM `credit_redeem` WHERE user_id= $uid";
					$qqchk2=mysqli_query($conn, $qchk2);
                    			$rd=0; while($row2 = $qqchk2->fetch_assoc()){  $rd = $row2["rd"];}
					
					$bal=$cr-$rd;
					
					//to get debited / redeem details of today of current user
					$qchk3="SELECT  sum(rd_point) as rd FROM `credit_redeem` WHERE user_id= $uid AND date(rd_date)=date('$date')";
					$qqchk3=mysqli_query($conn, $qchk3);
                    			$rd_today=0; $rd_today_flag=0;
					while($row = $qqchk3->fetch_assoc())
					{  $rd_today = $row["rd"]; $rd_today_flag=1; }

					//to get debited / redeem details of today of all users
					$qchk4="SELECT  sum(rd_point) as rd FROM `credit_redeem` WHERE date(rd_date)=date('$date')";
					$qqchk4=mysqli_query($conn, $qchk4);
                    			$rd_today_all=0; 
					while($row = $qqchk4->fetch_assoc())
					{  $rd_today_all = $row["rd"]; }
					
					//$msg="bal: $bal , amt: $amount , rd_total: $rd_today ,max_user:  $max_pnt_user , max_alluser: $max_pnt_alluser";

					//to check total permitted limit per user and per day for total amount
					if($bal >= $amount )
					{
						if($rd_today < $max_pnt_user){
                                                if($rd_today_all < $max_pnt_alluser){

						if($mobile!='' && $uid!='' && $amount!='')
						{
							//	$msg="Successful";
								$skey="p0hmX4ug5pMhFrt5hL4hYRZeX7II";
								//$response=$chks_str = "'existingusercheck''$mobile''Digiadmin Consumer''MBK5959''500'";
								//$chks=$this->calculateChecksum($skey, $chks_str);
								$qchk="SELECT * FROM `credit_store` WHERE `user_id`=$uid and cr_point >= 0";
								$rchk=mysqli_query($conn, $qchk);

								if($rchk->num_rows > 0)
								{
									$date = date('Y-m-d H:i:s');
									$qq="INSERT INTO `order_detail`(`user_id`, `mobile`, `email`, `pay_mode`, `amount`, `status`, `remarks`,ord_date) VALUES ($uid,'$mobile','$email',1,$amount,0,'','$date')";
									$inv=mysqli_query($conn, $qq);
									$response= $orderid = mysqli_insert_id($conn);
              								//$response="order_number:$orderid";
									}
								$mtype=0;
								$crmethod='cashback';
								$mid='MBK5959';
								$marname='Digiadmin Consumer';
								$cmnt='check';
								$wid='abhishek.chaubey@digiadmin.quantumcs.com';
								$chks_str = "'{$amount}''{$mobile}''{$cmnt}''{$crmethod}''{$marname}''{$mid}''{$orderid}''{$mtype}''{$wid}'";
								$chks=$this->calculateChecksum($skey, $chks_str);
								$data=array("checksum"=>"$chks","amount"=>$amount,"cell" => "$mobile","creditmethod"=>"$crmethod","mid"=>"$mid","merchantname"=>"$marname","orderid"=>"$orderid","typeofmoney"=>"$mtype","walletid"=>"$wid","comment"=>"$cmnt");
								$url="https://walletapi.mobikwik.com/loadmoney";
								$method="GET";
								$rdd=$this->CallAPI($method, $url, $data);
								$tf='SUCCESS';
								$pos = strpos($rdd, $tf);
								if($pos === FALSE ){
										$status=0; }
								else{
										$status=1; }
										
						}//if not blank value check
						}
						}
					}
			} //end of user flag check
         } //end of else

			if($status == 1)
			{
				$qq="INSERT INTO `credit_redeem`(`user_id`, `rd_date`, `rd_mode`, `ord_id`, `transaction_id`, `rd_point`,flag, `remarks`) VALUES ($uid,'$date','2','$orderid','NA',$amount,1,'redeemed by mobikwik pay mode 2')";
                		mysqli_query($conn, $qq);
                		$qq3="UPDATE `order_detail` SET status=1 WHERE user_id=$uid AND ord_id=$orderid";
                		mysqli_query($conn, $qq3);
			}
                       // for API call log
        //if($userid!='')
        //{
        $api=$_SERVER['QUERY_STRING'];
        $dt= date('Y/m/d H:i:s');
        $rip=$_SERVER['REMOTE_ADDR'];
        $uagent=$_SERVER['HTTP_USER_AGENT'];
        //$token= '' ;

        $qrry="INSERT INTO api_log (user_id, api, timestamp, remote_ip, user_agent, token, status) VALUES ('$uid','$api','$dt','$rip','$uagent','$token','$status');";
                $rsq=mysqli_query($conn, $qrry);
        //}

            $this->_returnResponseMobi($conn, $instance, $status,$msg,$response);
    }

    public
    function _userProfileUpdate(NewController $instance)
    {
        $tag = "**_appProfileUpdate**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Profile Update";
        $status = 0;
               
	$dt = date('Y-m-d H:i:s');
	
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['userprofileupdate']);
            $user_id=null;$name=null;$email=null;$mobile=null;$address=null;$gender=null;$age=null;$pwd=null;$ref=0;$nresp_dob=0;$sq1=null;$sq2=null;
            $nresp_sec_educ=null;$nresp_sec_occup=null;$nresp_educ=null;$nresp_occup=null;$nresp_m_status=null;
            $nresp_income=null;$nresp_tot_kids=null;$nresp_hfd=null;$nresp_hfd_frequency=null;$nresp_twowheeler=null;
            $nresp_fourwheeler=null;$city=null;$state=null;$nresp_working_st=null;$nresp_hh_mob_user_cnt=null;$plang=null;
            $imei=null;$oprator_name=null;$net_loc=null;$phone_type=null;$pin_code=null;
            $marr=array();
            $result = json_decode($jsonPost,true); //print_r($result);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                //print_r($result[0]['_hfd_consumption_mul'] );
                 //print_r($json);
                foreach ($json as $key => $val) 
                {
	                 if(is_array($val))  
	                 {
	                 	//print_r($result[0][$key] );
	                 	foreach ($val as $akey => $aval) 
                		{
                			if($aval != ' ')
                			{$temp=array($key => $aval);array_push($marr, $temp); }
                		}
		              
	           	}
	           	else
	           	{ 
	           		// echo "<br>$key=".$val;
	           		     if($key == 'name')
			              {    $name=$val;}
			              if($key == 'email')
			              {     $email=$val;}
			              if($key == 'mobile')
			              {     $mobile=$val;}
			              if($key == 'address')
			              {     $address=$val;}
			              if($key == 'gender')
			              {     $gender=$val;}
			              if($key == 'age_yrs')
			              {     $age=$val;}
			              if($key == 'nresp_dob')
			              {     $nresp_dob=$val;}
			              if($key == 'password')
			              {     $pwd=$val;}
			              if($key == 'ref')
		              	      {   $ref=$val;}
		              	 	if(trim ($key) == 'nresp_sec_educ')
		              		{   $nresp_sec_educ=$val;}
		              		if(trim ($key) == 'nresp_sec_occup')
		              		{   $nresp_sec_occup=$val;}
		              		if($key == 'nresp_educ')
		              		{   $nresp_educ=$val;}
		              		if($key == 'nresp_occup')
		              		{   $nresp_occup=$val;}
		              		if($key == 'nresp_m_status')
		              		{   $nresp_m_status=$val;}
		              		if($key == 'nresp_income')
		              		{   $nresp_income=$val;}
		              		if($key == 'nresp_tot_kids')
		              		{   $nresp_tot_kids=$val;}
		              		if($key == 'nresp_hfd')
		              		{   $nresp_hfd=$val;}
		              		if($key == 'nresp_hfd_frequency')
		              		{   $nresp_hfd_frequency=$val;}
		              		if($key == 'nresp_twowheeler')
		              		{   $nresp_twowheeler=$val;}
		              	        if($key == 'nresp_fourwheeler')
		              		{   $nresp_fourwheeler=$val;}
                                        if($key == 'nresp_working_st')
			                {     $nresp_working_st=$val;}
			                if($key == 'nresp_hh_mob_user_cnt')
			                {     $nresp_hh_mob_user_cnt=$val;}
		              		if($key == 'city')
		              		{   $city=$val;}
                                        if($key == 'state')
		              		{   $state=$val;}
                                        if($key == 'plang')
		              		{   $plang=$val;}

                                        if($key == 'imei')
		              		{   $imei=$val;}
                                        if($key == 'oprator_name')
		              		{   $oprator_name=$val;}
                                        if($key == 'network_circlr_location')
		              		{   $net_loc=$val;}
                                        if($key == 'phone_type')
		              		{   $phone_type=$val;}
                                        if($key == 'pin_code')
		              		{   $pin_code=$val;}
                                        if($key == 'userid')
		              		{   $user_id=$val;}
	           	}
                }
            
            } 
  // print_r($marr);

                 $qchk="SELECT user_id FROM app_user WHERE user='$email' or mobil='$mobile' or imei='$imei'";
             
   
                 $rchk=mysqli_query($conn, $qchk);
            if($rchk->num_rows < 1)
            {
                 $sq2="UPDATE `mangopinion_57` SET  `address`='$address',`age_yrs`=$age, `gender_57`='$gender', nresp_educ='$nresp_educ',nresp_working_st='$nresp_working_st', nresp_dob='$nresp_dob' WHERE `resp_id`=$user_id and mobile!=''";

                $aa=mysqli_query($conn, $sq2);
                  
                $status = 1;
                $msg = "Profile Updated Successfully";
                  if($email!='')
		  {	
		  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: contact@mangopinion.com';
			$m.='Dear '.$name.', <br><br><br>Welcome from Mangopinion! Your Mangopinion user profile is updated sucessfuly.<br> Please login and continue to attempt the contest and earn the reward points.<br><br><br> Thanks,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
			$s="Mangopinion user profile updated";
			
			$fs= mail($email, $s, nl2br($m), $headers);
     		}		

            }
            else $status=0;
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }    

    public
    function _getSurveyCount(NewController $instance)
    {
        $tag = "**_getsurveycount**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get survey count";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
     		$qset=$_REQUEST['qset'];
                
                $qchk="SELECT `data_table`, sample_size FROM `project` WHERE `project_id`= (SELECT `project_id` FROM `questionset` WHERE `qset_id`=$qset )";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {    
               while ($row = $rchk->fetch_assoc()) 
               {
                  $dtb =  $row["data_table"]; $ss =  $row["sample_size"];

                $qq1="SELECT count(*) as cnt from $dtb WHERE r_name!=''";
                $qq=mysqli_query($conn, $qq1);
                 
                   if($qq->num_rows > 0)
                   {    
                      while ($row1 = $qq->fetch_assoc()) 
                      {
                        $count =  $row1["cnt"];
                        $response = $ss-$count; 
                      }                        	   
                   }
          
              }  
     
                $status = 1;
                //$msg = "Get MobiChecksum Details Successfully";
                $msg=$orderid;
            }
            else
            {  $status=0; }
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
 
    public
    function _validateRefCode(NewController $instance)
    {
        $tag = "**_validate referal code**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To validate refral code";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
     		$ref=$_REQUEST['ref'];
                
                 if(!is_numeric($ref))
                 {
                		$qchk="SELECT `id`, `user_id`, `refcode`, `remarks` FROM `app_refralcode_detail` WHERE `refcode`='$ref'";              
                 		$rchk=mysqli_query($conn, $qchk);
                 
		            if($rchk->num_rows > 0)
		            {    	$uid='';
			               while ($row = $rchk->fetch_assoc()) 
			               {
			                  $uid =  $row["user_id"];
			          
			               }  
		                     	$status = 1;
		                	$msg=$uid;
		            }
		            else
		            {  $status=0; $msg='Not Valid'; }
		}
		else if(is_numeric($ref))
		{
				$qchk="SELECT `intvr_id`, `remarks`, `centre`, `irefcode` FROM `mangop_interviewer_referral_detail` WHERE `irefcode`=$ref";              
                 		$rchk=mysqli_query($conn, $qchk);
                 
		            if($rchk->num_rows > 0)
		            {    	$uid='';
			               while ($row = $rchk->fetch_assoc()) 
			               {
			                  $uid =  $row["intvr_id"];
			          
			               }  
		                     	$status = 1;
		                	$msg=$uid;
		            }
		            else
		            {  $status=0; $msg='Not Valid'; }
		}
		            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    public
    function _userProjects(NewController $instance)
    {
        $tag = "**_USERPROJECTS code**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get userProjects details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
     		$uid=$_REQUEST['user_id'];
                
                $qchk="SELECT `id`, `appuser_id`, `project_id`, `status`, `cr_point`, `exp_date` FROM `appuser_project_map` WHERE `appuser_id`=$uid";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {    $uid='';
               while ($row = $rchk->fetch_assoc()) 
               {
                  $qset =  $row["project_id"];
                  $pn=get_qset_project_name($qset);
                   if($qset==0) $pn='NA';
            
                  $pid=$row["project_id"]; $edt=get_peoject_edt($pid);

                  $r = array("user_id" => (int)$row["appuser_id"], "project_id" => $row["project_id"], "exp_date" => "$edt","cr_point" => $row["cr_point"],"project" => $pn,"status" => $row["status"]);
                  	array_push($response,$r);
          
               }  
     
                $status = 1;
               
                $msg=$uid;
            }
            else
            {  $status=0; $msg='Not Valid';}
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

   //to store mp user location
      public    
    function _mpUserLocation(NewController $instance)
    {
        $tag = "**_mpUserLocation**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To do store mp user location";
        $status = 0; $doflag=1;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['rlocation']);

            $userid=null;$latt=null;$lang='';$area='';$timestamp='';$spotm='';$speed='';
            $result = json_decode($jsonPost);  
            foreach ($result as $json) 
            {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "user_id")
                   		$userid=$val;
                        if($key == "loc_lat")
                   		$latt=$val;
                        if($key == "loc_lang")
                   		$lang=$val; 
                        if($key == "loc_area")
                   		$area=$val;
                        if($key == "loc_time_stamp")
                   		$timestamp=$val;
                        if($key == "spot_meet")
                   		$spotm=$val;  
                        if($key == "mdevice_speed")
                   		$speed=$val;                                  		
                 }
                 date_default_timezone_set('asia/calcutta'); 
     		$cdate = date('Y-m-d H:i:s'); 
                    
                          $qq="INSERT INTO `mp_user_location`(`uid`, `latt`, `lang`, `area`, `timestamp`,update_time, `meet_flag`,speed) VALUES ($userid,'$latt','$lang','$area','$timestamp','$cdate','$spotm','$speed')";
                         mysqli_query($conn, $qq);
                         
                         $status=1;
                         $msg = "Location added successfully";
                       
           }     
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $doflag);
    }
    
    public
    function _checkAndRoutine(NewController $instance)
    {
        $tag = "**_USERPROJECTS code**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get checkAndRoutine details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
     		$qid=$_REQUEST['qset_id'];
                
                $qchk="SELECT  `qset_id`, `qid`, `cqid`,flag FROM `question_routine_and` WHERE  `qset_id`= $qid";
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {    $uid='';
               while ($row = $rchk->fetch_assoc()) 
               {
                  $qset =  $row["qset_id"];
                 
                  $qid=$row["qid"];
                  $cqid=$row["cqid"];
		  $flg=$row["flag"];

                  $r = array("qset_id" => (int)$qset, "q_id" => $qid, "cqid" => $cqid,"flag"=>$flg);
                  array_push($response,$r);
          
               }  
     
                $status = 1;
               
                $msg=$uid;
            }
            else
            {  $status=0; $msg='Not Valid';}
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

   //rules for PSM/Tom/Spont type questions
        public
    function _getRule1(NewController $instance)
    {
        $tag = "**_USERRULE code**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get getRule1 details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
		$rule0=array(); $rule1=array();$rule2=array(); $rule3=array(); $rule4=array(); $rule5=array(); $rule6=array(); $rule7=array();$rule8=array(); $rule9=array();$rule10 = array(); $rule11=array(); $rule12 = array(); $rule13 = array(); $rule14 = array();
		$rulerk=array();

                $qsid=$_REQUEST['qset_id'];
                // for Grid ext consideratio, rank
                 $qchk ="SELECT `id`, `qset`, `group`, consider, rank FROM `question_rule_3_ext` WHERE `qset`=$qsid";
                 $rchk = mysqli_query($conn, $qchk);

            if($rchk){
                if($rchk->num_rows > 0)
            {    $uid='';
               while ($row0 = $rchk->fetch_assoc())
               {
                  $qset = $row0["qset"];
                  $grp=$row0["group"];
                  $cons = $row0["consider"];
                  $rank = $row0["rank"];
                  $r0 = array("qset" => $qset, "group" => $grp, "consider" => $cons, "rank"=> $rank );
                         array_push($rule0,$r0);
               }
                $status = 1;
                $msg=$uid;
            }
            }else{
                //var_dump($rchk);
            }

                // for Grid type
                 $qchk3="SELECT `id`, `qid`, `qset_id`, `grp_id`, row_no, flag FROM `question_rule_3` WHERE `qset_id`=$qsid  and flag <= 4 ;";              
                 $rchk3=mysqli_query($conn, $qchk3);
                 
            if($rchk3->num_rows > 0)
            {    $uid='';
               while ($row3 = $rchk3->fetch_assoc())
               {
                  $qset = $row3["qset_id"];
                  $qid=$row3["qid"];
                  $grp=$row3["grp_id"];
		  $flag = $row3["flag"];
		  $rowno = $row3["row_no"];
                  $r3 = array("qset_id" => (int)$qset, "qid" => $qid, "grp_id" => $grp, "row_no"=>$rowno , "flag"=> $flag);
                  	 array_push($rule3,$r3);
               }
                $status = 1;
                $msg=$uid;
            }
                // for Quata type
                $qchk1="SELECT `id`, `qset_id`, `tab_id`, `qid`, `op_val`, `quota` FROM `question_rule_2` WHERE `qset_id`=$qsid";
                 $rchk1=mysqli_query($conn, $qchk1);

            if($rchk1->num_rows > 0)
            {    $uid='';
               while ($row1 = $rchk1->fetch_assoc()) 
               {
                  $qset = $row1["qset_id"];
                  $qid=$row1["qid"];
                  $tabid=$row1["tab_id"];
                  $opv=$row1["op_val"];
                  $quota=$row1["quota"];

                  $r2 = array("qset_id" => (int)$qset, "qid" => (int)$qid, "tabid" => $tabid, "opv" => $opv,"quota" => $quota);
                  	 array_push($rule2,$r2);        
               }  
                $status = 1;
                $msg=$uid;
            }
     		 
                // for PSM type
                $qchk="SELECT `id`, `qset_id`, `qid`, `sno`, `grp_code` FROM `question_rule_1` WHERE `qset_id`= $qsid";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {    $uid='';
               while ($row = $rchk->fetch_assoc()) 
               {
                  $qset = $row["qset_id"];
                  $qid=$row["qid"];
                  $sno=$row["sno"];
                  $grp=$row["grp_code"];

                  $r = array("qset_id" => (int)$qset, "qid" => (int)$qid, "sid" => $sno, "grp_code" => $grp);
                  	array_push($rule1,$r);
          
               }  
                
                $status = 1;
                $msg=$uid;
            }

                // for Rule-4 as RuleOpShow to show options only selected in mentioned questions
                $qchk4="SELECT `id`, `qset_id`, `cqid`, `qid` FROM `question_rule_show_op` WHERE `qset_id`=$qsid";              
                 $rchk4=mysqli_query($conn, $qchk4);
                 
            if($rchk4->num_rows > 0)
            {    $uid='';
               while ($row1 = $rchk4->fetch_assoc()) 
               {
                  $qset = $row1["qset_id"];
                  $qid=$row1["qid"];
                  $cqid=$row1["cqid"];

                  $r4 = array("qset_id" => (int)$qset, "p_qid" => (int)$qid, "c_qid" => $cqid);
                  	 array_push($rule4,$r4);        
               }  
                $status = 1;
                $msg=$uid;
            }

                // for Rule-5 as RuleOPHide to show options not selected in mentioned questions
                $qchk5="SELECT `id`, `qset_id`, `cqid`, `qid` FROM `question_rule_hide_op` WHERE `qset_id`=$qsid";              
                 $rchk5=mysqli_query($conn, $qchk5);
                 
            if($rchk5->num_rows > 0)
            {    $uid='';
               while ($row1 = $rchk5->fetch_assoc()) 
               {
                  $qset = $row1["qset_id"];
                  $qid=$row1["qid"];
                  $cqid=$row1["cqid"];

                  $r5 = array("qset_id" => (int)$qset, "p_qid" => (int)$qid, "c_qid" => $cqid);
                  	 array_push($rule5,$r5);        
               }  
                $status = 1;
                $msg=$uid;
            }

                // for Rule-6 as project survey questions recording to record of listed questions while survey
                $qchk6="SELECT `id`, `qset_id`, `qid` FROM `question_rule_recording` WHERE `qset_id`=$qsid";              
                $rchk6=mysqli_query($conn, $qchk6);
                 
            if($rchk6->num_rows > 0)
            {    $uid='';
               while ($row1 = $rchk6->fetch_assoc()) 
               {
                  $qset = $row1["qset_id"];
                  $qid=$row1["qid"];

                  $r6 = array("qset_id" => $qset, "qid" => $qid);
                  	 array_push($rule6,$r6);        
               }  
                $status = 1;
                $msg=$uid;
            }

            
            // for Rule-7 as find & replace str of a question & its option based on source qid selected op value
            $qchk7="SELECT `id`, `qset`, `cqid`, `op_val`, `fstr`, `rstr`, `rqid` FROM `question_word_findreplace` WHERE `qset`= $qsid";              
            $rchk7=mysqli_query($conn, $qchk7);
                 
            if($rchk7->num_rows > 0)
            {    $uid='';
               while ($row7 = $rchk7->fetch_assoc()) 
               {
                  $qset = $row7["qset"];
                  $cqid=$row7["cqid"]; $rqid=$row7["rqid"]; $opv=$row7["op_val"]; $fstr=$row7["fstr"]; $rstr=$row7["rstr"];$rqid=$row7["rqid"];

                  $r7 = array("qset_id" => $qset, "cqid" => $cqid,"op_val" => $opv, "rqid" => $rqid, "fstr" => $fstr,"rstr" => $rstr);
                  	 array_push($rule7,$r7);        
               }  
                $status = 1;
                $msg=$uid;
            }
            // for Rule-8 as autoselect radio question option based on source qid  value num range
            $qchk8="SELECT * FROM `question_rule_autoselect` WHERE `qset`= $qsid";
            $rchk8=mysqli_query($conn, $qchk8);

            if($rchk8->num_rows > 0)
            {    $uid='';
               while ($row8 = $rchk8->fetch_assoc())
               {
                  $qset = $row8["qset"];
                  $cqid=$row8["cqid"]; $opv=$row8["opv"]; $pqid=$row8["pqid"]; $sval=$row8["sval"]; $eval=$row8["eval"];

                  $r8 = array("qset" => $qset, "cqid" => $cqid,"op_val" => $opv, "pqid" => $pqid, "sval" => $sval,"eval" => $eval);
                  array_push($rule8,$r8);
               }
                $status = 1;
                $msg=$uid;
            }
            // for Rule-9 to restrict value for a qid  value num range
            $qk9="select * from `question_rule_numlimit` WHERE `qset`= $qsid";
            $rk9=mysqli_query($conn, $qk9);

            if($rk9->num_rows > 0)
            {    $uid='';
               while ($row9 = $rk9->fetch_assoc())
               {
                  $qset = $row9["qset"];
                  $cqid = $row9["cqid"]; $opc = $row9["opcode"]; $sval = $row9["sval"]; $eval=$row9["eval"];

                  $r9 = array("qset" => $qset, "cqid" => $cqid,"opcode" => $opc, "sval" => $sval,"eval" => $eval);
                  array_push($rule9,$r9);
               }
                $status = 1;
                $msg=$uid;
            }

            // for Rule-10 as auto fix code radio question option based on source qid  and pqid
            $qchk10="SELECT * FROM `question_rule_autofixcode` WHERE `qset`= $qsid";
            $rchk10=mysqli_query($conn, $qchk10);

            if($rchk10->num_rows > 0)
            {    $uid='';
               while ($row10 = $rchk10->fetch_assoc())
               {
                  $qset = $row10["qset"];
                  $cqid=$row10["cqid"]; $opv=$row10["cqid_opv"]; $pqid=$row10["pqid"]; $fval=$row10["val"];

                  $r10 = array("qset" => $qset, "cqid" => $cqid,"op_val" => $opv, "pqid" => $pqid, "val" => $fval);
                  array_push($rule10,$r10);
               }
                $status = 1;
                $msg=$uid;
            }
                // for rotaion type
                 $qchk11="SELECT `id`, `qid`, `qset_id`, `grp_id`,flag FROM `question_rule_3` WHERE `qset_id` = $qsid and flag > 4;";
                 $rchk11=mysqli_query($conn, $qchk11);

            if($rchk11->num_rows > 0)
            {    $uid='';
               while ($row11 = $rchk11->fetch_assoc())
               {
                  $qset = $row11["qset_id"];
                  $qid=$row11["qid"];
                  $grp=$row11["grp_id"];
                  $flag = $row11["flag"];
                  $r11 = array("qset_id" => (int)$qset, "qid" => (int)$qid, "grp_id" => $grp, "flag"=> $flag);
                         array_push($rule11,$r11);
               }
                $status = 1;
                $msg=$uid;
            }

            // for Rule-12 as find & replace str of a question & its option based on source qid selected op value
            $qchk12="SELECT * FROM `question_rule_oprange` WHERE `qset`= $qsid";
            $rchk12=mysqli_query($conn, $qchk12);

            if($rchk12->num_rows > 0)
            {    $uid='';
               while ($row12 = $rchk12->fetch_assoc())
               {
                  $qset = $row12["qset"];
                  $cqid=$row12["cqid"]; $cqfop=$row12["cqid_fr_op"]; $cqtop=$row12["cqid_to_op"]; $pqid=$row12["pqid"]; $pqop=$row12["pqid_op"];

                  $r12 = array("qset" => $qset, "cqid" => $cqid,"cqid_fr_op" => $cqfop, "cqid_to_op" => $cqtop, "pqid" => $pqid,"pqop" => $pqop);
                         array_push($rule12,$r12);
               }
                $status = 1;
                $msg=$uid;
            }

            // for Rule-13 as gris question option show hide
            $qchk13="SELECT * FROM `question_rule_gridqop_showhide` WHERE `qset`= $qsid and `group` > 0";
            $rchk13=mysqli_query($conn, $qchk13);

            if($rchk13->num_rows > 0)
            {    $uid='';
               while ($row13 = $rchk13->fetch_assoc())
               {
                  $qset = $row13["qset"];
                  $cqid = $row13["cqid"]; $pqid=$row13["pqid"]; $pqop=$row13["pqop"]; $grp=$row13["group"]; $flg=$row13["flag"];

                  $r13 = array("qset" => $qset, "cqid" => $cqid,"group" => $grp, "flag" => $flg, "pqid" => $pqid,"pqop" => $pqop);
                         array_push($rule13,$r13);
               }
                $status = 1;
                $msg=$uid;
            }

            // for Rule-14 as to show othsers question option show 
            $qchk14="SELECT * FROM `question_rule_gridqop_showhide` WHERE `qset`= $qsid AND `group` = 0";
            $rchk14=mysqli_query($conn, $qchk14);

            if($rchk14->num_rows > 0)
            {    $uid='';
               while ($row14 = $rchk14->fetch_assoc())
               {
                  $qset = $row14["qset"];
                  $cqid = $row14["cqid"]; $pqid=$row14["pqid"]; $pqop=$row14["pqop"]; $grp=$row14["group"]; $flg=$row14["flag"];

                  $r14 = array("qset" => $qset, "cqid" => $cqid,"group" => $grp, "flag" => $flg, "pqid" => $pqid,"pqop" => $pqop);
                         array_push($rule14,$r14);
               }
                $status = 1;
                $msg=$uid;
            }
                //end of rule
                $response=array('rankconsidration' => $rule0, 'rule1'=>$rule1, 'rule2'=>$rule2,'rule3'=>$rule3,'opshow'=>$rule4, 'ophide'=>$rule5,'qrecording'=>$rule6 ,'qstrfindreplace'=>$rule7,'autoselect'=>$rule8,'numlimit'=>$rule9, 'autofixcode'=>$rule10,'rotationqop'=>$rule11,'qoprange'=>$rule12 ,'gridqopshowhide'=>$rule13,'rule14'=>$rule14); 
        }
        $this->_returnResponse($conn, $instance, $status,$msg,$response);
    }


    //GPI login
    public
    function _gpiLogin(NewController $instance)
    {
        $tag = "**_gpiLogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Login";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
               $imei=$_REQUEST['imei']; $respid=$_REQUEST['gpi_resp_id'];
            $q1="SELECT imei FROM gpi_shopper_imei WHERE resp_id= '$respid' ";
            $rc=mysqli_query($conn, $q1);
            $rc->num_rows;
            $sh_imei=0;
            if($rc->num_rows > 0)
            {
                $status = 1; $msg="Exist in database";
                while ($row = $rc->fetch_assoc())
               {
                  $sh_imei = $row["imei"];
               }
            }
            if($rc->num_rows <= 0)
            {
                $qwe="INSERT INTO `gpi_shopper_imei`(`resp_id`, `imei`) VALUES ('$respid','$imei')";
               $rc2=mysqli_query($conn, $qwe);
               if($rc2)$sh_imei=$imei;
            }
            if ($imei!='' && $sh_imei!=0)
                $status = 2;
            if ($imei==$sh_imei)
            {

     	       $response=array(); $login_status=0;$qq='';
               $qq="SELECT distinct resp_id,r_name,mobile FROM bluto_96 WHERE resp_id= '$respid' and r_name!=''";
               $rchk=mysqli_query($conn, $qq);

               if($rchk->num_rows > 0)
               {
                  $status = 1; $msg="Exist in database";
                  while ($row = $rchk->fetch_assoc())
                  {
                     $rsp = $row["resp_id"];$rname = $row["r_name"];$mobile = $row["mobile"]; $arr=array('resp_id'=>$rsp, 'r_name'=>$rname, 'mobile'=>$mobile); array_push( $response,$arr);
                  }
               }
            } //end if if imei
         } //end of else

             $this->_returnResponse($conn, $instance, $status,$msg,$response);
    }
    //GPI login

    //GPI respondent details
    public
    function _gpiRDetail(NewController $instance)
    {
        $tag = "**_gpiRDetail**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get Respondent details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
           $respid=$_REQUEST['gpi_resp_id'];
           
            if ($respid!='')
            {
     		$response=array(); $login_status=0;$qq='';
     	    
              $qq="SELECT distinct resp_id,r_name,mobile, store_type, landmark, address FROM bluto_96 WHERE resp_id= '$respid' and r_name!=''";
               $rchk=mysqli_query($conn, $qq);
               
               if($rchk->num_rows > 0)
               { 
                  $status = 1; $msg="Exist in database";
                  while ($row = $rchk->fetch_assoc()) 
                  {
                     $rsp = $row["resp_id"];$rname = $row["r_name"]; $st = $row["store_type"]; $landm = $row["landmark"]; $addr = $row["address"];
                     $mobile = $row["mobile"]; $arr=array('resp_id'=>$rsp, 'r_name'=>$rname, 'mobile'=>$mobile, 'store_type'=>$st, 'landmark'=>$landm, 'address'=>$addr); array_push( $response,$arr);
                  }
               }
            } //end if if imei
         } //end of else 
         
             $this->_returnResponse($conn, $instance, $status,$msg,$response);
    }

    public
    function _gpiExport(NewController $instance)
    {
           $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        $table="gpi_scaned_data";
       
      

//        $first_id=0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['result']); $str='Attempting..';
            $result = json_decode($jsonPost);   
               //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/test.txt", $jsonPost,FILE_APPEND | LOCK_EX, null);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    if (!$isFirst) {
                        if($key == 'mq5pcode _32')
                           {$pp='mq5pcode_32'; $column = $pp;}
                       else
                           {$column = $key;}
                        $column = $key;
                        //$value = "'" . $val . "'";
                        $value = "'" . mysqli_real_escape_string($conn,$val) . "'";
                        $isFirst = true;
                    } else {
                       if($key == 'mq5pcode _32')
                           {$pp='mq5pcode_32'; $column = $column . ", " . $pp;}
                       else
                           {$column = $column . ", " . $key;}
                        //$value = $value . ", '" . $val . "'";
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
            }
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported in $table Successfully";
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }

    public
    function _gpibarcode(NewController $instance)
    {
        $tag = "**_gpibarcode**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get gpibarcode details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
     		 
                
                $qchk="SELECT `id`, `barcode`, `manufacturer`, `franchise`, `brand_name`, `segment`, `rsft_types`, `variant`, `variant_type`, `illicit_brand`, `mrp_10s`, `mrp_16s`, `mrp_20s` FROM `gpi_pack_list`";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {     
               while ($row = $rchk->fetch_assoc()) 
               {
                                 
                  //$qid=$row["qid"];
                  
                  $r = array("id" => $row["id"], "barcode" => $row["barcode"], "manufacturer" => $row["manufacturer"], "franchise" => $row["franchise"], "brand_name" => $row["brand_name"], "segment" => $row["segment"], "rsft_types" => $row["rft_types"], "variant" => $row["variant"], "variant_type" => $row["variant_type"], "illicit_brand" => $row["illicit_brand"], "mrp_10s" => $row["mrp_10s"], "mrp_16s" => $row["mrp_16s"], "mrp_20s" => $row["mrp_20s"]);
                  array_push($response,$r);
          
               }  
     
                $status = 1;
               
                $msg=$uid;
            }
            else
            {  $status=0; $msg='Not Valid';}
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    	//to export the app log details
    public
    function _appLogExport(NewController $instance)
    {
        $tag = "**_appLogExport**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get appLogExport details";
        $status = 0; $table="app_log";
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
               
              $jsonPost = stripslashes($_REQUEST['result']); $str='Attempting..';
            $result = json_decode($jsonPost);    
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;$flag=0;
				$respid=null;
				$qset=null;
                foreach ($json as $key => $val) {  
                    if (!$isFirst) {
                        if($key == 'resp_id')
							$respid=$val;
                        
                        $column = $key;
                        $value = "'" . mysqli_real_escape_string($conn,$val) . "'";
                        $isFirst = true;
                    } else {  
     
                        if($key == 'resp_id')
                        {$respid=$val; $isFirst = true;}

                        if($key == 'travel_status' && $val=='1')
                        {       //echo "calling... do_survey($project,$respid,$rpnt)<br>";
							$flag=1;	  //$rr=do_survey($project,$respid,$rpnt);
						}
                        $column = $column . ", " . $key;
                        //$value = $value . ", '" . $val . "'";
                       $value = $value . ", '" . mysqli_real_escape_string($conn,$val) . "'";
                    }
                }

						if($flag == 1)
                        {   $rpnt=0;$project=111;   
							$flag=1;		  $rr=do_survey($project,$respid,$rpnt);
						}

                if ($column != null && $value != null) {
                     $sql = "INSERT INTO $table (" . $column . ") VALUES (" . $value . ");\n";
                                //file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/query.txt", $sql,FILE_APPEND | LOCK_EX, null); 
                    if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
                }
               $msg= $result;
            }
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported in $table Successfully";
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
	//to get app version
    public
    function _getAppVersion(NewController $instance)
    {
        $tag = "**_getAppVersion**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get getAppVersion details";
        $status = 0;   $msg='Not Valid';
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
     		$response=array();  
     		 
                
                $qchk="SELECT `id`, `app`, `version`, `status` FROM `app_version` ";              
                $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {     
               while ($row = $rchk->fetch_assoc()) 
               {
                                 
                  //$qid=$row["qid"];
                  
                  $r = array("id" => $row["id"], "app" => $row["app"], "version" => $row["version"], "status" => $row["status"]);
                  array_push($response,$r);
          
               }  
     
                $status = 1;
               
                $msg=$uid;
            }
            
             
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

     public
    function _moUserLogin(NewController $instance)
    {
	date_default_timezone_set('asia/calcutta'); 
	$dt = date('Y-m-d H:i:s');
	$response=array();$uid='';
        $tag = "**_moUserLogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To moUserLogin";
	$ps1=0;$ps2=0;$ps3=0;$ref='';$tokenparta='';$userref='';
        $status = 0;$fbresponse=array(); $gresponse=array(); $gstatus = 0; $fbstatus = 0;

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
           
               $rmob=$_REQUEST['rmob']; 
	       $imei=$_REQUEST['imei']; $android_id=$_REQUEST['android_id'];$ref=$_REQUEST['refral'];
		$q1="SELECT `user_id`, `mobile`, `create_dt`, `status` FROM `mo_user` WHERE `mobile`= '$rmob' ";
            $rc=mysqli_query($conn, $q1);
            $rc->num_rows;
            $uid='';$ust=0;
            if($rc->num_rows > 0)
            { 
                $status = 1; $msg="Sucess";
                while ($row = $rc->fetch_assoc()) 
               {
                  $uid = $row["user_id"];
		  $ust= (int)$row["status"]; 
		  //for block user only
                   if($ust==0)
			{ $status=0;$msg='User blocked';} 
                       //$this->_returnResponse($conn, $instance, 0,'User restricted to access',$response);
  		  //$uid = $row["user_id"];
 
               }
            }
  		function generateRandomString($length = 6)
               {
                      //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                      $charactersLength = strlen($characters);
                      $randomString = '';
                      for ($i = 0; $i < $length; $i++) {
                      $randomString .= $characters[rand(0, $charactersLength - 1)];
                      }
                     return $randomString;
                }


            if($rc->num_rows <= 0)
            {   
		$status = 1; $msg="Success";
                $qwa="SELECT `user_id`, `user_name`, `user`, `mobil`, `create_date`, `last_login`, `status` FROM `app_user` WHERE `mobil`= '$rmob' ";
            $rex=mysqli_query($conn, $qwa);
            $rex->num_rows;
            $flag=0;
            if($rex->num_rows > 0)
            { 
                $flag = 1; $ddt='';
                while ($row = $rex->fetch_assoc()) 
               {
                  $uid = $row["user_id"];
		  $ddt = $row["create_date"];  
               }
		 $qwe="INSERT INTO `mo_user`(user_id,`mobile`, `imei`, `android_id`, `create_dt`,`status`) VALUES ('$uid','$rmob', '$imei', '$android_id','$ddt','1')";
               $rc2=mysqli_query($conn, $qwe);

            }
               if($flag==0)
               {
               $qwe="INSERT INTO `mo_user`(`mobile`, `imei`, `android_id`, `create_dt`,`status`) VALUES ('$rmob', '$imei', '$android_id','$dt','1')";
               $rc2=mysqli_query($conn, $qwe);
               $uid=mysqli_insert_id($conn);
		//below code for user refral code genration and perform action accordingly
               $tokenparta = generateRandomString(6);

               $qrr1="INSERT INTO `app_refralcode_detail`( `user_id`, `refcode`, `remarks`) VALUES ($uid,'$tokenparta','$dt')";
               $a2=mysqli_query($conn, $qrr1);
               $rfid=mysqli_insert_id($conn);
                if($rfid<1)
                {   $strt=$uid; $strt.=substr($rmob,0,3);
                    $qrr2="INSERT INTO `app_refralcode_detail`( `user_id`, `refcode`, `remarks`) VALUES ($uid,'$strt','$dt')";
                    $a3=mysqli_query($conn, $qrr2);      
                }

               if($ref!='')
               {   
                    
                   if(is_numeric($ref))
                   {
                         $irr="SELECT `intvr_id`, `remarks`, `centre`, `irefcode` FROM `mangop_interviewer_referral_detail` WHERE `irefcode`= $ref";
                         $irk=mysqli_query($conn, $irr);
                         if($irk->num_rows > 0)
                         {        $iruid='';$irmk='';
                            while ($ire = $irk->fetch_assoc()) 
            	            {
                  	        $iruid=$ire["intvr_id"];
                  	        $cen=$ire["centre"];
                            }
                            $iq3="INSERT INTO `mangop_interviewer_app_user_ref`(`user_id`, refcode, `intvr_id`, `dtime`,centre) VALUES ($uid,'$ref',$iruid,'$dt',$cen)";
                            mysqli_query($conn, $iq3); 
                         }
        
                   }
                   else if(!is_numeric($ref))
                   {
                     echo $rr="SELECT `id`, `user_id`, `refcode`, `remarks` FROM `app_refralcode_detail` WHERE `refcode`= '$ref'";
                      $rk=mysqli_query($conn, $rr);
                      if($rk->num_rows > 0)
                      {   $ruid='';$rmk='';
                          while ($re = $rk->fetch_assoc()) 
            	          {
                  	     $ruid=$re["user_id"];
                  	     $rmk=$re["remarks"];
                          }
              	          $q3="INSERT INTO `app_user_ref`(`to_user_id`, `ref_code`,fr_user_id,dtime) VALUES ($touser_id,'$ref',$ruid,'$dt')";
              	          mysqli_query($conn, $q3);

                           // $qw="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($uid,0,'$dt',0,'refered by his friend with userid: $ruid $rmk')";
                           // mysqli_query($conn, $qw);
                              $qw1="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, `remarks`) VALUES ($ruid,0,'$dt',0,'refered to his friend of userid: $uid')";
                             mysqli_query($conn, $qw1);
                       }
                    }//end of else
                  }//end of flag=0
		}
		//end of user ref details & generation
            }
		 //for facebook profile details
               $qq="SELECT `id`, `user_id`, `name`, `mobile`, `email`, `dob`, age,gender,locale, `img_url`, `pf_type`, `update_dt` FROM `mo_user_detail` WHERE `user_id`=$uid AND `pf_type`=1";
               $rchk=mysqli_query($conn, $qq);
               
               if($rchk->num_rows > 0)
               { 
                  $fbstatus = 1; 
                  while ($row = $rchk->fetch_assoc()) 
                  {
                     	$uid = $row["user_id"];$rname = $row["name"];$mobile = $row["mobile"];$gen=$row["gender"];$email = $row["email"];$dob = $row["dob"];$age = $row["age"];$loc=$row["locale"]; $img = $row["img_url"];$udt = $row["update_dt"];
			$fbarr=array('uid'=>$uid, 'name'=>$rname,'mobile'=>$mobile,'email'=>$email,'dob'=>$dob,'age'=>$age,'gender'=>$gen,'locale'=>$loc,'img'=>$img,'update_dt'=>$udt); array_push( $fbresponse,$fbarr);
                  }
               }
 
               //for google profile details
               $qq2="SELECT `id`, `user_id`, `name`, `mobile`, `email`, `dob`,age,gender, locale, `img_url`, `pf_type`, `update_dt` FROM `mo_user_detail` WHERE `user_id`=$uid AND `pf_type`=2";

               $rchk2=mysqli_query($conn, $qq2);
               
               if($rchk2->num_rows > 0)
               { 
                  $gstatus = 1; 
                  while ($row = $rchk2->fetch_assoc()) 
                  {
                     	$uid = $row["user_id"];$rname = $row["name"];$mobile = $row["mobile"];$email = $row["email"];$dob = $row["dob"];$gen=$row["gender"];$age = $row["age"];$loc=$row["locale"]; $img = $row["img_url"];$udt = $row["update_dt"];
			$garr=array('uid'=>$uid, 'name'=>$rname,'mobile'=>$mobile,'email'=>$email,'dob'=>$dob,'age'=>$age,'gender'=>$gen,'locale'=>$loc,'img'=>$img,'update_dt'=>$udt); array_push( $gresponse,$garr);
                  }
               }
	//to ger refal detail
	$qref="select user_id, refcode ,remarks from app_refralcode_detail WHERE user_id=$uid";
	$rsqr=mysqli_query($conn, $qref);
      	$rsqr->num_rows;
      	if($rsqr->num_rows>0)
      	{     
        	while ($row = $rsqr->fetch_assoc()) 
		{
			$userref = $row["refcode"];
		}
	}

	//end of refral
		$response=array("user_id"=>$uid,"refral_code"=>$userref,"fb_status"=>$fbstatus,"fb_response"=>$fbresponse,"g_status"=>$gstatus,"g_response"=>$gresponse);
    $this->_returnResponse($conn, $instance, $status,$msg,$response);
       
	} //end of else 
         
           //  $this->_returnResponse($conn, $instance, $status,$msg,$response);	
    } //end of function mouserlogin
   
	public
    function _moUserProject(NewController $instance)
    {
	date_default_timezone_set('asia/calcutta'); 
	$dt = date('Y-m-d H:i:s');
	$response=array();$uid='';
        $tag = "**_moUserLogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Got moUserProject";
	$ps1=0;$ps2=0;$ps3=0;$p1='100';$p2='74';$p3='122';
        $status = 0;$fbresponse=array(); $gresponse=array(); $gstatus = 0; $fbstatus = 0;

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } 
	else 
	{
		$uid=$_REQUEST['uid']; 

	 //for getting profile project status

	  $cq1="SELECT * FROM `appuser_project_map` WHERE `appuser_id`=$uid AND `project_id`=$p1";
          $cst=mysqli_query($conn, $cq1);

          if($cst->num_rows < 1)
          {
              $iq1="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`, `status`) VALUES ($p1,$uid,0)";
                mysqli_query($conn, $iq1);

              $uq1="UPDATE `appuser_project_map` SET  `cr_point`=5  WHERE `appuser_id`=$uid AND `project_id`=$p1 AND `status`=0";
                mysqli_query($conn, $uq1);
          }

           $cq2="SELECT * FROM `appuser_project_map` WHERE `appuser_id`=$uid AND `project_id`=$p2";
          $cst2=mysqli_query($conn, $cq2);

          if($cst2->num_rows < 1)
          {
              $iq2="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`, `status`) VALUES ($p2,$uid,0)";
                mysqli_query($conn, $iq2);

              $uq2="UPDATE `appuser_project_map` SET  `cr_point`=5  WHERE `appuser_id`=$uid AND `project_id`=$p2 AND `status`=0";
                mysqli_query($conn, $uq2);
          }

         $cq3="SELECT * FROM `appuser_project_map` WHERE `appuser_id`=$uid AND `project_id`=$p3";
          $cst3=mysqli_query($conn, $cq3);

          if($cst3->num_rows < 1)
          {
              $iq3="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`, `status`) VALUES ($p3,$uid,0)";
                mysqli_query($conn, $iq3);

              $uq3="UPDATE `appuser_project_map` SET  `cr_point`=5  WHERE `appuser_id`=$uid AND `project_id`=$p3 AND `status`=0";
                mysqli_query($conn, $uq3);
          }
		
          $pstq="SELECT `appuser_id`, (SELECT  `status` FROM `appuser_project_map` WHERE `appuser_id`=$uid AND `project_id`= $p1 limit 1) as ps1, ( SELECT  `status` FROM `appuser_project_map` WHERE `appuser_id`=$uid AND `project_id`= $p2 limit 1) as ps2,(SELECT  `status` FROM `appuser_project_map` WHERE `appuser_id`=$uid AND `project_id`= $p3 limit 1) as ps3 FROM `appuser_project_map` WHERE `appuser_id`=$uid limit 1";
 
          $pst=mysqli_query($conn,$pstq);
          if($pst->num_rows > 0)
          {
           	   while ($row = $pst->fetch_assoc()) 
                   {
                        $ps1 = $row["ps1"]; $ps2 = $row["ps2"];$ps3 = $row["ps3"];
                   }
          }

		$project_1=array("project_id"=>$p1,"project_name"=>"Mangoshake","project_status"=>$ps1,"project_point"=>"5");
                $project_2=array("project_id"=>$p2,"project_name"=>"Selfiesyndrome","project_status"=>$ps2,"project_point"=>"5");
            	$project_3=array("project_id"=>$p3,"project_name"=>"Profile","project_status"=>$ps3,"project_point"=>"5");
		$profile=array($project_1,$project_2,$project_3);

		$response=array("user_id"=>$uid,"project_profile"=>$profile);         
	} //end of else 
         
             $this->_returnResponse($conn, $instance, $status,$msg,$response);	
    } //end of function mouserproject
 
    function _moUserFBGLogin(NewController $instance)
    {
        $tag = "**_moUserFBGLogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To process";
        $status = 0;$respd='';
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $jsonPost = stripslashes($_REQUEST['fbglogin']);
            $uid='';$name='';$mobile='';$email='';$dob='';$gen='';$age='';$locale='';$img='';$pt='';$rpnt='';

            $result = json_decode($jsonPost);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                foreach ($json as $key => $val) {
                    	if($key == "uid")
                   		$uid=trim($val);
              		if($key == "name")
                   		$name=$val;
			if($key == "mobile")
                   		$mobile=$val;
			if($key == "email")
                   		$email=$val;
			if($key == "dob")
                   		$dob=$val;
			if($key == "age")
                   		$age=$val;
			if($key == "locale")
                   		$locale=$val;
			if($key == "img")
                   		$img=$val;
			if($key == "pf_type")
                   		$pt=$val;
			if($key == "rpnt")
                   		$rpnt=$val;
			if($key == "gender")
				$gen=$val;
                }                
            }
            //print_r($dlist);
     		$response=array();$userid='';$login_status=0;$qq='';
     	     
               $qchk="SELECT  `user_id`, `name`, `mobile`, `email`, `dob`, `age`, `locale`, `img_url`, `pf_type`, `update_dt` FROM `mo_user_detail` WHERE  `user_id`=$uid AND `pf_type`=$pt ";
                 $rchk=mysqli_query($conn, $qq);
                 $status = 0;
            if($rchk->num_rows < 1)
            {   
            	$dt = date('Y-m-d H:i:s');
                $ull="INSERT INTO `mo_user_detail`(`user_id`, `name`, `mobile`, `email`, `dob`, `age`,gender, `locale`, `img_url`, `pf_type`, `update_dt`) VALUES ('$uid','$name','$mobile','$email','$dob','$age','$gen','$locale','$img','$pt','$dt')";
                mysqli_query($conn, $ull);
                        
                $status = 1;
                $msg = "Inserted Successfully";

 
             	$qr="INSERT INTO `credit_store`(`user_id`, `qset_id`, `i_date`, `cr_point`, remarks) VALUES ($uid,0,'$dt',5,'credited for login as fbg=$pt')";
                mysqli_query($conn, $qr);

            }            
        }
        $this->_returnResponse($conn, $instance, $status, $respd, $response);
    }
   
    function _moMediaShare(NewController $instance)
    {
        $tag = "**_moImageShare**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                $image = $_POST['image'];
                $name = $_POST['name']; 
                $type = $_POST['type']; 
		$userid = $_POST['userid'];
		$rmk = $_POST['remarks'];
                $dt = date('Y-m-d H:i:s');        

                    if ($image!='')
                    {     
                        $path="/vcimsweb/uploads/image/";
                        if ($type=='image')
                        { 
			   $daycnt = 0;
			   $qrrr="SELECT count(`media_name`) as cnt FROM `mousermedia` WHERE `user_id`='$userid' and date(`upload_date`)=date('$dt')";
			   $rsq=mysqli_query($conn, $qrrr);
			   $rsq->num_rows;
			   if($rsq->num_rows>0)
			   {     
    				while ($row = $rsq->fetch_assoc()) 
    				{
					$daycnt = $row["cnt"];
    			        }
			   }
			   if($daycnt<4)
			   {
				$name.=".jpg";  
				file_put_contents($_SERVER['DOCUMENT_ROOT']."/vcimsweb/uploads/image/$name",base64_decode($image)); 
				$status = 1;
                                $msg="Image Successfully uploaded";
				if($userid!='')
				{
					$qr="INSERT INTO `mousermedia`(`user_id`, `media_name`, `url`, `type`, `remarks`, `upload_date`) VALUES ('$userid','$name','$path','$type','$rmk','$dt')";
					$rs = mysqli_query($conn, $qr);
				}
			    }
			}
                        if ($type=='audio')
                        {   
				file_put_contents($_SERVER['DOCUMENT_ROOT']."/vcimsweb/uploads/audio/$name".".mp3",base64_decode($image)); 
				$status = 1;
				$msg="Audio Successfully uploaded"; 
			}
                        if ($type=='video')
                        {   
			     //file_put_contents($_SERVER['DOCUMENT_ROOT']."/vcimsweb/uploads/video/$name".".mp4", $image);
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
		        
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $name);
    }
 
    private
    function _returnError($conn, $instance, $tag)
    {
        $instance->onError($tag . "->" . mysqli_error($conn));
        $conn->close();
        exit();
    }

   
  private  function _apireturnError($conn, $instance, $tag)
    {
        $instance->onError($tag . "->" . mysqli_error($conn));
        $conn->close();
        exit();
    }


    
    private  function _returnResponse($conn, $instance, $status, $msg, $response)
    {   //print_r($response);
        $conn->close();
        $instance->onSuccess($status, $msg, $response);
    }

    private
    function _returnResponseMobi($conn, $instance, $status, $msg, $response)
    {   //print_r($response);
        $conn->close();
        $instance->onSuccessMobi($status, $msg, $response);
    }

    private
    function apiReturnResponse($conn, $instance, $status, $msg, $userid, $data)
    {   
        $conn->close();
        $instance->apionSuccess($status, $msg, $userid, $data);
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
