<?php
include_once dirname(__FILE__) . '/DBConnector.php';
include_once('functions.php');

include_once('survey-function.php');

date_default_timezone_set('asia/calcutta'); 
//ini_set('memory_limit', '-1');

class WSQ
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
            self::$instance = new WSQ();
        }

        return self::$instance;
    }

     /* query for upload/save image on server of camera capture for radio mrirchi */

    public
    function _uploadImageForCamera(WSC $instance)
    {
        $tag = "**_uploadImageForCamera**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
	$name='';
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                    	$dt = date('Y-m-d H:i:s');
                        $name = $_POST['name'];
			$image = $_POST['image'];
			$did = $_POST['did'];
			//$type = $_POST['type'];
                        //$name.="_$dt";
			$type = 'image';

                        $path="https://www.digiadmin.quantumcs.com/vcimsweb/uploads/image/camera/$name";
                        if ($type=='image')
                        {
				$name.=".jpg";  
				file_put_contents($_SERVER['DOCUMENT_ROOT']."/vcimsweb/uploads/image/camera/$name",base64_decode($image)); 
				$status = 1;
                                $msg="Image Successfully uploaded as path https://digiadmin.quantumcs.com/vcimsweb/uploads/image/camera/$name";

				//to save in database
				$sql = "INSERT INTO vcimsweb.camera_image (did, image, created_at) VALUES ($did, '$name','$dt')";
				mysqli_query($conn, $sql);
			}


        }
        $this->_returnResponse($conn, $instance, $status, $msg, $name);
    }

     /* query for upload/save image on server  */

    public
    function _uploadEmpImage(WSC $instance)
    {
        $tag = "**_uploadImage**";
       
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To upload";
	$path = null;
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                        $image = $_REQUEST['image'];
                        $name = $_POST['name'];
			$uid = $_POST['uid']; 
                       //$name.=".jpg";
		// 
                    if ($image!='')
                    {     
                        	$path="https://digiadmin.quantumcs.com/media/app/image/emp/$name";
				//$name.=".jpg";
				file_put_contents($_SERVER['DOCUMENT_ROOT']."/media/app/image/emp/$name",base64_decode($image));
				$status = 1;
				
				//code to get old image and delete it
				$sq = "SELECT img_url FROM vpms.vams_employee WHERE id=$uid ;";
				$rc=mysqli_query($conn, $sq);
            			$rc->num_rows;
		                if($rc->num_rows > 0)
            			{
                			$status = 1; $msg="Exist in database";
                			while ($row = $rc->fetch_assoc()) 
               				{
                  				$img_old = $row["img_url"];
						//delete img_old from server path
						 if($img_old != '0') unlink($img_old);
               				}
            			}
				// end of delete old img

				$sqle = "UPDATE vpms.vams_employee SET img_url='$path' WHERE id=$uid ; ";
		                $rc2=mysqli_query($conn, $sqle);
			
                                $msg="Image Successfully uploaded";

                    }
		//
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $path);
	//$this->_returnResponse($conn, $instance, $status,$msg,$response);
    } //end of emp image upload


        public function cryptGetToken($length)
	{
			    $token = "";
			    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
			    $codeAlphabet.= "0123456789";
			    for($i=0;$i<$length;$i++){
			        $token .= $codeAlphabet[self::crypto_rand_secure(0,strlen($codeAlphabet))];
			    }
			    return $token;
	}

        public function crypto_rand_secure($min, $max) 
	{
	        $range = $max - $min;
	        if ($range < 0) return $min; // not so random...
	        $log = log($range, 2);
	        $bytes = (int) ($log / 8) + 1; // length in bytes
	        $bits = (int) $log + 1; // length in bits
	        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	        do {
	            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	            $rnd = $rnd & $filter; // discard irrelevant bits
	        } while ($rnd >= $range);
	        return $min + $rnd;
	}

	//to rest/forget pass for vAttendace emp _vEmpForetPass(
    public
    function _vEmpForgetPass(WSC $instance)
    {
        $tag = "**_vEmpForgetPass**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get Forget Pass";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
		$loginid = $_POST['login'];

     		$response='';$uid='';$login_status=0;
                     $qchk="SELECT * FROM vpms.vams_employee WHERE  email='$loginid'; ";

     		if(is_numeric($loginid))
               	{
                   $qchk="SELECT * FROM vpms.vams_employee WHERE mobile = '$loginid'; ";
               	} 
                 $rqd = mysqli_query($conn, $qchk);

		if(!empty($rqd))
            if($rqd->num_rows > 0)
            {   $uid=0;
                while ($row = $rqd->fetch_assoc())
                {
                    $uname=$row["name"]; $email=$row["email"];
                    $pass = $row["salt"]; 
		    $uid = $row["id"];
			$response = $email;
                }
	        $token = $this->cryptGetToken(32);
				if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
				$dt = date('Y-m-d H:i:s');
				$edt=date("Y-m-d H:i:s", strtotime("+30 minutes"));
 
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: hr@digiadmin.quantumcs.com' . "\r\n" ;
                $m.= " Dear $uname , <br><br><br> We have received your password reset request. <br> Click here on <a href='https://www.digiadmin.quantumcs.com/siteadmin/siteadmin/reset_password/$token'> Reset Password </a>  link to reset your new password. This link is valid for 30 minutes only else get expired.<br><br> Thanks,<br>Team DigiadminCIMS <br>";
                $s="Digiadmin Attendance Forget Password Request";

		$fsql = "INSERT INTO admin_user_login (uid,token,start_time, end_time,type) VALUES ($uid,'$token','$dt','$edt',2);";
		$frchk = mysqli_query($conn, $fsql);

                $fs= mail($email, $s, nl2br($m), $headers);
                if($fs)
                {    $status = 1;
                    $msg = "Password Reset link sent to your registered email.";
                }
                else
                {
                     $status = 0;
                    $msg = "Error! email failed to send";
                }
            }
            else $status = 0;


	}
             $this->_returnResponse($conn, $instance, $status,$msg,$response);
    }
	//end of forget pass

    //GPI login 
    public
    function _gpiLogin(WSC $instance)
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
     	    
              $qq="SELECT distinct resp_id,r_name,i_name,r_add, mobile,centre_117,gender_117 FROM prathmesh_117 WHERE resp_id= '$respid' and r_name!=''";
               $rchk=mysqli_query($conn, $qq);
               
               if($rchk->num_rows > 0)
               { 
                  $status = 1; $msg="Exist in database";
                  while ($row = $rchk->fetch_assoc()) 
                  {
                     $rsp = $row["resp_id"];$rname = $row["r_name"];$rn=$row["r_add"];$in=$row["i_name"];$cn=$row["centre_117"];$gn=$row["gender_117"]; $mobile = $row["mobile"]; $arr=array('resp_id'=>$rsp, 'r_name'=>$rname,'i_name'=>$in,'r_add'=>$rn,'centre_117'=>$cn,'gender_117'=>$gn, 'mobile'=>$mobile); 
			array_push( $response,$arr);
                  }
               }
            } //end if if imei
         } //end of else 
         
             $this->_returnResponse($conn, $instance, $status,$msg,$response);
    }
    //GPI login
  //for interviewer gpi login 
public
    function _gpiLogin_i(WSC $instance)
    {
        $tag = "**_gpiLogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Login";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                $respid=$_REQUEST['gpi_resp_id'];
  
                 $msg="Not getting ...";

                $response=array(); $login_status=0;$qq='';


		$qq="SELECT distinct resp_id,r_name,r_add,i_name, mobile,centre_117,gender_117 FROM prathmesh_117 WHERE resp_id= '$respid' and r_name!=''";
               $rchk=mysqli_query($conn, $qq);

               if($rchk->num_rows > 0)
               {
                  $status = 1; $msg="Exist in database";
                  while ($row = $rchk->fetch_assoc())
                  {
                     $rsp = $row["resp_id"];$rname = $row["r_name"];$in=$row["i_name"];$rn=$row["r_add"];$cn=$row["centre_117"];$gn=$row["gender_117"]; $mobile = $row["mobile"]; $arr=array('resp_id'=>$rsp, 'r_name'=>$rname,'i_name'=>$in,'r_add'=>$rn,'centre_117'=>$cn,'gender_117'=>$gn, 'mobile'=>$mobile);
                        array_push( $response,$arr);
                  }
               }
            //} //end if if imei
         } //end of else

             $this->_returnResponse($conn, $instance, $status,$msg,$response);
    }
    //GPI login for interviewer
  
    //GPI respondent details
    public
    function _gpiRDetail(WSC $instance)
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
     	    
              $qq="SELECT distinct resp_id,r_name,mobile, store_type, landmark, address FROM prathmesh_117 WHERE resp_id= '$respid' and r_name!=''";
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
    function _gpiExport(WSC $instance)
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
    function _gpibarcode(WSC $instance)
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
    function _appLogExport(WSC $instance)
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
                        {   $rpnt=0;$project=107;   
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
	//end of function

    	//to export the app log details
    public
    function _kappLogExport(WSC $instance)
    {
        $tag = "**_kappLogExport**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get kappLogExport details";
        $status = 0; $table="kenante_app_log";
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
               
                 $uid = $_REQUEST['uid'];
		 $activity = $_REQUEST['activity'];
		 $pltf = $_REQUEST['platform'];
		 $klog = $_REQUEST['log'];
		 //$tms = $_REQUEST['timestamp'];
 		 $tm = date('Y-m-d H:i:s');
		//echo "$uid,  $activity,  $pltf , $klog ";
            if ($uid!='' && $activity!='' && $pltf!='' && $klog!='') {
                     $sql = "INSERT INTO $table (uid,platform,activity,log,timestamp ) VALUES ($uid,'$pltf', '$activity','$klog','$tm')";
                    if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }

                $status = 1;
                $msg = "Log exported in $table Sucessfully";
            }
	    else
	    {
		$status =0;
		$msg="Error! All inputs required, ";
	    }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
	//end of function 

    //to export data for day 1 & 8
    public
    function _exportMPResultOneResp(WSC $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        $table="";
          
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $respid=$_REQUEST['resp_id']; $qsetid=$_REQUEST["qset_id"];

            $sql = "SELECT `data_table` FROM `project` WHERE `project_id` = (SELECT distinct `project_id` FROM `questionset` WHERE `qset_id` IN(" . $_REQUEST["qset_id"] . "))";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $table = $row["data_table"];                        
                    }                    
                }
              }                      
                          
         
        $resp_flag=0; $st="st_$qsetid";$stt=$_REQUEST['st'];
      if($stt==1 || $stt==0)
      $sql2 = "SELECT distinct resp_id FROM $table WHERE `q_id` = $qsetid AND resp_id='$respid'";
          if($stt==8){ $table="prathmesh8_117"; $sql2="SELECT distinct resp_id FROM prathmesh8_117 WHERE q_id=$qsetid AND resp_id='$respid'";}
 
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
             
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported in $table Successfully";
            }
          } 
          }
          if($resp_flag==1)
          {
          	//start of duplicate entry for 114/rose1
          	
          	   $jsonPost = stripslashes($_REQUEST['result']); 
		               $result = json_decode($jsonPost);   
		                   file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/test.txt", $jsonPost,FILE_APPEND | LOCK_EX, null);
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
		                                  //  file_put_contents($_SERVER['DOCUMENT_ROOT']."/uploads/pdf/query.txt", $sql,FILE_APPEND | LOCK_EX, null); 
		                      /* if (!mysqli_query($conn, $sql)){
		                           $this->_returnError($conn, $instance, $sql);
		                        }
		                       */ 
		                   }
		                  $msg= $result;
		                
		               if ($isFirst) {
		                   $status = 1;
		                   $msg = "Result Exported in $table Successfully";
		               }
         		 } 
          	//end of duplicate entry for 114/rose1
             $status = 2;
                $msg = "Error! Result not Exported of resp_id: $respid";
          }
         
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }

    public
    function _gpibarcodecn(WSC $instance)
    {
        $tag = "**_gpibarcode**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get gpibarcodecn details";
        $status = 0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                $response=array();
                $cid=$_REQUEST['centre_id'];

                $qchk="SELECT `id`, `barcode`, `manufacturer`, `franchise`, `brand_name`, `segment`, `rsft_types`, `variant`, `variant_type`, `illicit_brand`, `mrp_10s`, `mrp_16s`, `mrp_20s`,centre_id FROM `gpi_pack_list` WHERE centre_id=$cid";
                 $rchk=mysqli_query($conn, $qchk);

            if($rchk->num_rows > 0)
            {
               while ($row = $rchk->fetch_assoc())
               {

                  //$qid=$row["qid"];

                  $r = array("id" => $row["id"], "barcode" => $row["barcode"], "manufacturer" => $row["manufacturer"], "franchise" => $row["franchise"], "brand_name" => $row["brand_name"], "segment" => $row["segment"], "rsft_types" => $row["rft_types"], "variant" => $row["variant"], "variant_type" => $row["variant_type"], "illicit_brand" => $row["illicit_brand"], "mrp_10s" => $row["mrp_10s"], "mrp_16s" => $row["mrp_16s"], "mrp_20s" => $row["mrp_20s"],"centre_id"=>$row["centre_id"]);
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

       public
    function _vccstToken(WSC $instance)
    {
        $tag = "**_vccstToken**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get gpibarcode details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {           
     		$response=array();
                $code=$_REQUEST['token'];       		                 
                 $qchk="SELECT  project_id as t FROM `vccst_token_detail` WHERE token='$code' AND date(end_date) >= date('$dt')";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {     
               while ($row2 = $rchk->fetch_assoc()) 
               {
                                 
                  $pid=$row2["t"];
                       $qry="SELECT `id`, `resp_id`, `fr_pid`, `to_pid`, `sdt`, `edt`, `status` FROM `vccst_deploy_detail` WHERE to_pid=$pid";
                       $rch=mysqli_query($conn, $qry);
                 
                       if($rch->num_rows > 0)
                       {     
                          while ($row = $rch->fetch_assoc()) 
                          {
                  $r = array("resp_id" => $row["resp_id"], "fr_pid" => $row["fr_pid"], "to_pid" => $row["to_pid"], "sdt" => $row["sdt"], "edt" => $row["edt"], "status" => $row["status"]);
                  array_push($response,$r);
                          }
                       }
                   $status = 1;
                   $msg="Success";
               }  
     
                
               
                
            }
            else
            {  $status=0; $msg='Token Code is Not Valid';}
            
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }

    //to export data in vpmt survey table 
    public
    function _vccstExport(WSC $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        $table="";
       
          
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

            $sql = "SELECT `data_table` FROM `project` WHERE `project_id` = (SELECT distinct `project_id` FROM `questionset` WHERE `qset_id` IN(" . $_REQUEST["qset_id"] . "))";
            $rs = mysqli_query($conn, $sql);
            if (!$rs) {
                $this->_returnError($conn, $instance, $tag);
            } else {
                if ($rs->num_rows > 0) {
                    // output data of each row
                    while ($row = $rs->fetch_assoc()) {
                        $table = $row["data_table"];                        
                    }                    
                }
            }
        }
        $table .='_cc'; 
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

    //to get any project details based on project id
        /* query for project detail*/
    public function _getProjectDescription(WSC $instance)
    {
        $tag = "**_getProjectDetails**";
        $conn = DBConnector::getDBInstance();
        $msg = null;
        $status = 0;
        $response = array();
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            
                if ($_REQUEST['project_id']) {
                    $project_ids = $_REQUEST['project_id'];
                    $isFirst = true;
                
                     $sql = "SELECT * from project where project_id IN(" . $project_ids . ") ";
                    $rs = mysqli_query($conn, $sql);
                    if (!$rs) {
                        $this->_returnError($conn, $instance, $tag);
                    } else {
                        if ($rs->num_rows > 0) {
                            // output data of each row
                            while ($row = $rs->fetch_assoc()) {
                                $dtable=$row["data_table"]; $pid=(int)$row["project_id"]; $rcont=0;
                                
                                          $p = array("project_id" => (int)$row["project_id"], "project_name" => $row["name"], "company_name" => $row["company_name"], "brand" => $row["brand"], "research_type" => $row["research_type"],"tot_visit" => (int)$row["tot_visit"], "data_table" => $row["data_table"], "resp_count" => $rcont);
                                array_push($response, $p);
                              
                            }
                            $status = 1;
                            $msg = "Project List is Here";
                        }
                    }
                } else {
                    $msg = "No Project ID";
                }
            }
        

        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
    //video conferencing user login
    public
    function _vcuserlogindev(WSC $instance)
    {
        $tag = "**_vcuserlogindev**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcuserlogin details";
        $status = 0;
        $cdate = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
     		 $response=array();
                 $mob=$_REQUEST['login'];
		 $pass=$_REQUEST['password'];
		 $gcmid=$_REQUEST['gcmid'];
		 $imei=$_REQUEST['imei'];

		 //$s3Client = "AmazonS3Client(BasicAWSCredentials('AKIA6A4HCVMZZNSXMCUK','tIZY2Zp3t1o2XQdhHznOzn+f5TsgOmNOR3ZX56EA'))";

		 //$API_DOMAIN = 'https://apikenante.quickblox.com';
		 //$CHAT_DOMAIN = 'chatkenante.quickblox.com';

                 $qchk="SELECT  uid as t, login, imei FROM vcimsdev.`vc_user` WHERE mobile='$mob' AND password='$pass'";
                 $rchk=mysqli_query($conn, $qchk);

            if($rchk->num_rows > 0)
            {
               while ($row2 = $rchk->fetch_assoc())
               {
                   $userid=$row2["t"];
                   $response["user_id"] = $userid;
		/*
		   $response["app_id"]=$APP_ID;
		   $response["auth_key"]=$AUTH_KEY;
		   $response["auth_secret"]=$AUTH_SECRET;
		   $response["account_key"]=$ACCOUNT_KEY;

		   $response["api_domain"] = $API_DOMAIN;
		   $response["chat_domain"] = $CHAT_DOMAIN;
		   $response["janu_server"] = $JANU_SRV;
		   $response["janu_protocol"] = $JANU_PROTCOL;
		   $response["janu_plugin"] = $JANU_PLUGIN;
		*/
		   $response["s3Client_key"] = "AKIA6A4HCVMZZNSXMCUK";
                   $response["s3Client_secretKey"] = "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";

		   $login_status = $row2["login"];
		   $login_imei = $row2["imei"];
                   $response["user_id"] = $userid;
                   //$status = 1;
                   $msg="Success";

                            if($login_status==1 && ($login_imei == $imei)){
					$status=1;
			    }
                            if($login_status==1 && ($login_imei != $imei)){
					$status=2; 
					$msg="Already Signed in at diffrent device. Please logout and then signin again.";
			    }
                            if($login_status==0){
					$qq="UPDATE vcimsdev.`vc_user` SET `login`=0, imei='$imei',timestamp='$cdate' WHERE `uid`=$userid";
                       			mysqli_query($conn, $qq);
					$status=1;
			    //}

				//to start work for GCM
				//$cdate = date('Y-m-d H:i:s'); 
                   		$qchk="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM vcimsdev.`gcm_vcusers` WHERE `user_id`= $userid";
                 		$qqchk=mysqli_query($conn, $qchk);
                 		if($qqchk->num_rows>0)
                 		{         
                       			$qq="UPDATE vcimsdev.`gcm_vcusers` SET `gcm_regid`='$gcmid', created_at='$cdate' WHERE `user_id`=$userid";
                       			mysqli_query($conn, $qq);
                      			$status=1;
                 		}
                 		else
                 		{    
					if($type!=2)
		      			{ 
                 				$qa="SELECT `uid`, `name`, `mobile`, `email` FROM vcimsdev.vc_user_detail WHERE uid=$userid";
                 				$rsq=mysqli_query($conn, $qa);
                 				if($rsq->num_rows>0)
                 				{
                 					while ($row = $rsq->fetch_assoc()) 
		                			{
		                        			$name = $row["name"];
                                        			$email = $row["email"];
                                        			$mob = $row["mobile"];		                 
                 						$qqq="INSERT INTO vcimsdev.`gcm_vcusers`(`user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$name','$email','$mob','$cdate')";
                 	 					mysqli_query($conn, $qqq);
                 	 				}
						}
		      			}
					if($type==2)
					{
						$qqq="INSERT INTO vcimsdev.`gcm_vcusers`(`user_id`, `gcm_regid`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$mobile','$cdate')";
                                		mysqli_query($conn, $qqq);

					}
                		 	//$status=1;
                        		//$msg = "GCM User Registered/updated sucessfully";
                 		}
				//end of GCM work
                             } //end of if of status=0
               }  
            }
            else
            {
                   $status=0; 
                   $msg='Incorrect Login/Password';
		   $response = null;
	    }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    } 
	//end of vcuserlogindev

    function _vcuserlogoutdev(WSC $instance)
    {
        $tag = "**_vcuserlogout**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcuserlogout details";
        $status = 0;
        $cdate = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {           
     		 $response=array();
                 $uid=$_REQUEST['userid'];
                 $qchk="SELECT  uid as t, login, imei FROM vcimsdev.`vc_user` WHERE uid='$uid'";
                 $rchk=mysqli_query($conn, $qchk);                 
                 if($rchk->num_rows > 0)
                 {     
               		while ($row2 = $rchk->fetch_assoc()) 
               		{            
                   		$userid = $row2["t"];
				$login_status = $row2["login"];
				$login_imei = $row2["imei"];
                   		$response["user_id"] = $userid;
                            if($login_status==1){
					$qq="UPDATE vcimsdev.`vc_user` SET `login`=0, imei='', timestamp='$cdate' WHERE `uid`=$userid";
                       			mysqli_query($conn, $qq);
					$status=1;
                   		        $msg="Successfully logout";
			    }
               		}
            	}
            	else
            	{
                   $status=0; 
                   $msg='Incorrect UserID';
                }
        	}
        	$this->_returnResponse($conn, $instance, $status, $msg, $response);
    } 

    //video test conferencing user login
    public
    function _vcuserlogintest(WSC $instance)
    {
        $tag = "**_vcuserlogintest**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcuserlogin details";
        $status = 0;
        $cdate = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
     		 $response=array();
                 $mob=$_REQUEST['login'];
		 $pass=$_REQUEST['password'];
		 $gcmid=$_REQUEST['gcmid'];
		 $imei=$_REQUEST['imei'];

		 //$API_DOMAIN = 'https://apikenante.quickblox.com';
		 //$CHAT_DOMAIN = 'chatkenante.quickblox.com';
		 $API_DOMAIN = 'https://api.quickblox.com';
                 $CHAT_DOMAIN = 'chat.quickblox.com';

		 //$JANU_SRV = 'wss://groupcallskenante.quickblox.com:8989';
		 $JANU_SRV = 'wss://janus.quickblox.com:8989';
		 		//$JANU_SRV = 'wss://janusdev.quickblox.com:8989';
		 $JANU_PROTCOL = 'janus-protocol';
		 $JANU_PLUGIN = 'janus.plugin.videoroom';
		// /*
		 $APP_ID = 4;
		 $AUTH_KEY = 'YZYp8CDgrFmH7Px';
		 $AUTH_SECRET = 'Ljnjw8ZRFMMwmLO';
		 $ACCOUNT_KEY = 'St5Fo9xbd2nzzCXqLsha';
		// */ 

		
		//jitesh qb account
                 $APP_ID = 66113;
                 $AUTH_KEY = '4XtCdEK8n22qnVY';
                 $AUTH_SECRET = 'GLmN2dy9LBZWGeD';
                 $ACCOUNT_KEY = 'rHtCZtii2h3S4fdNBx7o';
		//end od jitesh qb a/c
		

                 $qchk="SELECT  uid as t, login, imei FROM `vc_user` WHERE mobile='$mob' AND password='$pass'";
                 $rchk=mysqli_query($conn, $qchk);
            if($rchk->num_rows > 0)
            {
               while ($row2 = $rchk->fetch_assoc())
               {
                   $userid=$row2["t"];
                   $response["user_id"] = $userid;

		   $response["app_id"]=$APP_ID;
		   $response["auth_key"]=$AUTH_KEY;
		   $response["auth_secret"]=$AUTH_SECRET;
		   $response["account_key"]=$ACCOUNT_KEY;

		   $response["api_domain"] = $API_DOMAIN;
		   $response["chat_domain"] = $CHAT_DOMAIN;
		   $response["janu_server"] = $JANU_SRV;
		   $response["janu_protocol"] = $JANU_PROTCOL;
		   $response["janu_plugin"] = $JANU_PLUGIN;

		   $login_status = $row2["login"];
		   $login_imei = $row2["imei"];
                   $response["user_id"] = $userid;
                   //$status = 1;
                   $msg="Success";

                            if($login_status==1 && ($login_imei == $imei)){
					$status=1;
			    }
                            if($login_status==1 && ($login_imei != $imei)){
					$status=2; 
					$msg="Already Signed in at diffrent device. Please logout and then signin again.";
			    }
                            if($login_status==0){
					$qq="UPDATE `vc_user` SET `login`=0, imei='$imei',timestamp='$cdate' WHERE `uid`=$userid";
                       			mysqli_query($conn, $qq);
					$status=1;
			    //}

				//to start work for GCM
				//$cdate = date('Y-m-d H:i:s'); 
                   		$qchk="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM `gcm_vcusers` WHERE `user_id`= $userid";
                 		$qqchk=mysqli_query($conn, $qchk);
                 		if($qqchk->num_rows>0)
                 		{         
                       			$qq="UPDATE `gcm_vcusers` SET `gcm_regid`='$gcmid', created_at='$cdate' WHERE `user_id`=$userid";
                       			mysqli_query($conn, $qq);
                      			$status=1;
                 		}
                 		else
                 		{    
					if($type!=2)
		      			{ 
                 				$qa="SELECT `uid`, `name`, `mobile`, `email` FROM vc_user_detail WHERE uid=$userid";
                 				$rsq=mysqli_query($conn, $qa);
                 				if($rsq->num_rows>0)
                 				{
                 					while ($row = $rsq->fetch_assoc()) 
		                			{
		                        			$name = $row["name"];
                                        			$email = $row["email"];
                                        			$mob = $row["mobile"];		                 
                 						$qqq="INSERT INTO `gcm_vcusers`(`user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$name','$email','$mob','$cdate')";
                 	 					mysqli_query($conn, $qqq);
                 	 				}
						}
		      			}
					if($type==2)
					{
						$qqq="INSERT INTO `gcm_vcusers`(`user_id`, `gcm_regid`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$mobile','$cdate')";
                                		mysqli_query($conn, $qqq);

					}
                		 	//$status=1;
                        		//$msg = "GCM User Registered/updated sucessfully";
                 		}
				//end of GCM work
                             } //end of if of status=0
               }  
            }
            else
            {
                   $status=0; 
                   $msg='Incorrect Login/Password';
		   $response = null;
	    }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    } 
	//end of test login

    //video conferencing user login
    public
    function _vcuserlogin(WSC $instance)
    {
        $tag = "**_vcuserlogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcuserlogin details";
        $status = 0;
        $cdate = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
     		 $response=array();
                 $mob=$_REQUEST['login'];
		 $pass=$_REQUEST['password'];
		 $gcmid=$_REQUEST['gcmid'];
		 $imei=$_REQUEST['imei'];

		 //$API_DOMAIN = 'https://apikenante.quickblox.com';
		 //$CHAT_DOMAIN = 'chatkenante.quickblox.com';
			$API_DOMAIN = 'https://api.quickblox.com';
                 	$CHAT_DOMAIN = 'chat.quickblox.com';

		 //$JANU_SRV = 'wss://groupcallskenante.quickblox.com:8989';
		 	$JANU_SRV = 'wss://janus.quickblox.com:8989';
		 	//$JANU_SRV = 'wss://janusdev.quickblox.com:8989';
		 $JANU_PROTCOL = 'janus-protocol';
		 $JANU_PLUGIN = 'janus.plugin.videoroom';

		//
		 $APP_ID = 80510;
		 $AUTH_KEY = 'ssUZO4LUz8TfMfB';
		 $AUTH_SECRET = 'YTNAaa9cQrNJwfR';
		 $ACCOUNT_KEY = 'wxKzx9xuN4GN-qQiK1Xc';
		// 

		/*
		 $APP_ID = 4;
		 $AUTH_KEY = 'YZYp8CDgrFmH7Px';
		 $AUTH_SECRET = 'Ljnjw8ZRFMMwmLO';
		 $ACCOUNT_KEY = 'St5Fo9xbd2nzzCXqLsha';
		*/ 

		/*
		//jitesh qb account
                 $APP_ID = 66113;
                 $AUTH_KEY = '4XtCdEK8n22qnVY';
                 $AUTH_SECRET = 'GLmN2dy9LBZWGeD';
                 $ACCOUNT_KEY = 'rHtCZtii2h3S4fdNBx7o';
		//end od jitesh qb a/c
		*/

                 $qchk="SELECT  uid as t, login, imei FROM `vc_user` WHERE mobile='$mob' AND password='$pass'";
                 $rchk=mysqli_query($conn, $qchk);
            if($rchk->num_rows > 0)
            {
               while ($row2 = $rchk->fetch_assoc())
               {
                   $userid=$row2["t"];
                   $response["user_id"] = $userid;

		   $response["app_id"]=$APP_ID;
		   $response["auth_key"]=$AUTH_KEY;
		   $response["auth_secret"]=$AUTH_SECRET;
		   $response["account_key"]=$ACCOUNT_KEY;

		   $response["api_domain"] = $API_DOMAIN;
		   $response["chat_domain"] = $CHAT_DOMAIN;
		   $response["janu_server"] = $JANU_SRV;
		   $response["janu_protocol"] = $JANU_PROTCOL;
		   $response["janu_plugin"] = $JANU_PLUGIN;

		   $login_status = $row2["login"];
		   $login_imei = $row2["imei"];
                   $response["user_id"] = $userid;
                   //$status = 1;
                   $msg="Success";

                            if($login_status==1 && ($login_imei == $imei)){
					$status=1;
			    }
                            if($login_status==1 && ($login_imei != $imei)){
					$status=2; 
					$msg="Already Signed in at diffrent device. Please logout and then signin again.";
			    }
                            if($login_status==0){
					$qq="UPDATE `vc_user` SET `login`=0, imei='$imei',timestamp='$cdate' WHERE `uid`=$userid";
                       			mysqli_query($conn, $qq);
					$status=1;
			    //}

				//to start work for GCM
				//$cdate = date('Y-m-d H:i:s'); 
                   		$qchk="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM `gcm_vcusers` WHERE `user_id`= $userid";
                 		$qqchk=mysqli_query($conn, $qchk);
                 		if($qqchk->num_rows>0)
                 		{         
                       			$qq="UPDATE `gcm_vcusers` SET `gcm_regid`='$gcmid', created_at='$cdate' WHERE `user_id`=$userid";
                       			mysqli_query($conn, $qq);
                      			$status=1;
                 		}
                 		else
                 		{    
					if($type!=2)
		      			{ 
                 				$qa="SELECT `uid`, `name`, `mobile`, `email` FROM vc_user_detail WHERE uid=$userid";
                 				$rsq=mysqli_query($conn, $qa);
                 				if($rsq->num_rows>0)
                 				{
                 					while ($row = $rsq->fetch_assoc()) 
		                			{
		                        			$name = $row["name"];
                                        			$email = $row["email"];
                                        			$mob = $row["mobile"];		                 
                 						$qqq="INSERT INTO `gcm_vcusers`(`user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$name','$email','$mob','$cdate')";
                 	 					mysqli_query($conn, $qqq);
                 	 				}
						}
		      			}
					if($type==2)
					{
						$qqq="INSERT INTO `gcm_vcusers`(`user_id`, `gcm_regid`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$mobile','$cdate')";
                                		mysqli_query($conn, $qqq);

					}
                		 	//$status=1;
                        		//$msg = "GCM User Registered/updated sucessfully";
                 		}
				//end of GCM work
                             } //end of if of status=0
               }  
            }
            else
            {
                   $status=0; 
                   $msg='Incorrect Login/Password';
		   $response = null;
	    }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    } 

    function _vcuserlogout(WSC $instance)
    {
        $tag = "**_vcuserlogout**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcuserlogout details";
        $status = 0;
        $cdate = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {           
     		 $response=array();
                 $uid=$_REQUEST['userid'];
                 $qchk="SELECT  uid as t, login, imei FROM `vc_user` WHERE uid='$uid'";
                 $rchk=mysqli_query($conn, $qchk);                 
                 if($rchk->num_rows > 0)
                 {     
               		while ($row2 = $rchk->fetch_assoc()) 
               		{            
                   		$userid = $row2["t"];
				$login_status = $row2["login"];
				$login_imei = $row2["imei"];
                   		$response["user_id"] = $userid;
                            if($login_status==1){
					$qq="UPDATE `vc_user` SET `login`=0, imei='', timestamp='$cdate' WHERE `uid`=$userid";
                       			mysqli_query($conn, $qq);
					$status=1;
                   		        $msg="Successfully logout";
			    }
               		}
            	}
            	else
            	{
                   $status=0; 
                   $msg='Incorrect UserID';
                }
        	}
        	$this->_returnResponse($conn, $instance, $status, $msg, $response);
    } 

    //for test vcusertaglisttest
     //video conferencing user list of same tag/room of a uid
    public
    function _vcusertaglist(WSC $instance)
    {
        $tag = "**_vcusertaglist**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcusertaglist details";
        $status = 1;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
     		$response=array(); $model=array(); 
		//$display_list = array();
                $uid=$_REQUEST['uid'];
                 //$qchk="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from `vc_user_detail` WHERE `uid`=$uid  AND tags !=''";
		//$qchk="SELECT distinct a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid AND a.cid=b.cid where b.room IN (SELECT distinct room FROM vc_room where date(substr(sch_end_time,1,10)) <= current_date() order by id desc) AND b.cid = (select distinct cid FROM vc_user WHERE uid=$uid);";
		$qchk ="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email` FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid AND b.uid=$uid AND a.cid=b.cid where b.room IN (SELECT room FROM vc_room where date(substr(sch_end_time,1,10)) >= current_date() order by id desc);";
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {
               while ($row2 = $rchk->fetch_assoc()) 
               {
			$display_list = array();
			//print_r($row2);
                       $urole = trim($row2["user_type"]);
                       $qbid = trim($row2["qb_id"]);                                 
                       $tag=trim($row2["tags"]);
			$cid=trim($row2["cid"]);

			$tflag=0;
		       //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=2 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=2 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
				$tflag=1;
				$cnt=0;
				while( $rr = $tfq->fetch_assoc())
				{	$cnt++;
					 $qbid= trim($rr['qb_id']);
					$dn="M-$cnt";
					$display_list[$qbid]=$dn;
				}
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=3 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=3 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="T-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=4 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=4 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="C-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=1 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=1 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="R-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=0 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=0 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="Admin-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=10 order by qb_id;";
			$tqry = "SELECT a.`uid`, b.room, b.user_type, a.qb_id, b.cid FROM vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid where b.room ='$tag' AND b.user_type=10 order by a.qb_id;";

                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="T-Adm-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
			//echo "tag: "; print_r($display_list);
                       $arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;
                       
                      //$qry="SELECT `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags` FROM `vc_user_detail` WHERE tags='$tag' AND tags!='' order by user_type";
                      //$qry="SELECT a.`uid`,b.`user_type`,a.`qb_id`,a.`qb_password`,a.`name`,a.`mobile`,a.`email`,a.`tags` FROM `vc_user_detail` as a JOIN vc_room_user_map as b ON a.uid=b.uid WHERE a.tags='$tag' AND a.tags!='' order by a.user_type asc";
		       $qry="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid where b.room ='$tag' AND b.room!='' order by b.user_type;";
                       $rch=mysqli_query($conn, $qry);
                 
                       if($rch->num_rows > 0)
                       {
                          while ($row = $rch->fetch_assoc()) 
                          {
				$utype = trim($row["user_type"]);
                              $qb_id = trim($row["qb_id"]);
                              $tag = trim($row["tags"]);
			      $cuid= trim($row["uid"]);
			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				//$qrr="select * from vc_room where id='$tag' OR room = '$tag'  AND date(substr(sch_end_time,1,10)) >= current_date();";
				$qrr="select * from vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				//echo $qdd->num_rows ;
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

                         //get qbid for IDI model
			if($rt == 1){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
					$self_a_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
				//talk
				if($utype == 4 ){
					array_push($arr_talk, trim($qbid));
					$self_v_off=1;
					$self_a_off=1;
				}

                                //hear
				/*
				if($utype == 1 && $tflag == 0){
                                   	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
				*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype == 0){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==10 ){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }
                             }
			}  //end of rt == 1 IDI
                              //get qbid for FGD model
			if($rt == 2){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 4 ){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }

                                //hear
			/*
				if($utype == 1 && $tflag == 0){
                                  	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
			*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }

                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;
					$self_a_off=1;
                                }

                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
					$self_v_off=1;
					$self_a_off=1;
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }
                             }
			} //end of rt == 2 FGD

                              //get qbid for Brodcasting model
			if($rt == 3){

                                 // for Moderator OR Respondent
                             if($urole == 1 || $urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   //array_push($arr_chat, trim($qb_id));
                                }
                             }
                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 ){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }

                                //hear
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==4 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }

                                //chat
                                if( $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
		
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==10 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1; $self_a_off=1;
                                }
                             }
			} //end of rt == 3 Brodcasting
			$qbbid=$row["qb_id"];

                  $r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]), "qb_id" => trim($row["qb_id"]),"qb_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "dname" => trim($display_list[$qbbid]), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0);
                  array_push($response,$r);
                          } //end of while loop
				$arr_talk = array_unique($arr_talk);
				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
                       }
                   $status = 1;
                   $msg="Success";
               }
            }
            else
            {
		//$status=0; $msg='User ID is Not Valid';
		//$status=1; $model='Room details not found';

		//-------- begin of else for check use details -----
				$qchqq="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from `vc_user_detail` WHERE `uid`=$uid  AND tags !='' limit 1";
				$rchkd=mysqli_query($conn, $qchqq);
            	if($rchkd->num_rows > 0)
            	{
				$arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;
               		while ($row = $rchkd->fetch_assoc()) 
               		{
				$display_list = array();
	                       	$urole = trim($row["user_type"]);
        	               	$qbid = trim($row["qb_id"]);                                 
                	       	$tag=trim($row["tags"]);
				$cid=trim($row["cid"]);

                  		$r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]), "qb_id" => trim($row["qb_id"]),"qb_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "dname" => trim('NA'), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0);
                  		array_push($response,$r);

			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				$qrr="select * from vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
			} //end of while loop 

		} // end of if
		//-------- end for check user details ------

	    }
        }
        $this->_returnResponse($conn, $instance, $status, $model, $response);
    }

    //for test vcusertaglistdev
     //video conferencing user list of same tag/room of a uid
    public
    function _vcusertaglistdev(WSC $instance)
    {
        $tag = "**_vcusertaglistdev**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcusertaglistdev details";
        $status = 1;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
     		$response=array(); $model=array(); 
		$display_list = array();
                 $uid = $_REQUEST['uid'];

                 //$qchk="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from `vc_user_detail` WHERE `uid`=$uid  AND tags !=''";
		//$qchk="SELECT distinct a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid AND a.cid=b.cid where b.room IN (SELECT distinct room FROM vc_room where date(substr(sch_end_time,1,10)) <= current_date() order by id desc) AND b.cid = (select distinct cid FROM vc_user WHERE uid=$uid);";
		 $qchk ="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email` FROM vcimsdev.vc_user as a JOIN vcimsdev.vc_room_user_map as b ON a.uid=b.uid AND b.uid= $uid AND a.cid=b.cid where b.room IN (SELECT room FROM vcimsdev.vc_room where date(substr(sch_end_time,1,10)) >= current_date() order by id desc);";
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {
               while ($row2 = $rchk->fetch_assoc()) 
               {
			//$display_list = array();
			//print_r($row2);
                       $urole = trim($row2["user_type"]);
			$qbid = trim($row2["uid"]);
                       //$qbid = trim($row2["qb_id"]);                                 
                       $tag=trim($row2["tags"]);
			$cid=trim($row2["cid"]);
//print_r($display_list);
			$tflag=0;
		       //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=2 order by qb_id;";
		  	$tqry2="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_room_user_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=2 order by b.uid;";
                       $tfq2=mysqli_query($conn, $tqry2);
                       if($tfq2->num_rows > 0)
                       {
				$tflag=1;
				$cnt=0;
				while( $rr = $tfq2->fetch_assoc())
				{	$cnt++;
					 $uid= trim($rr['uid']); //$qbid= trim($rr['qb_id']);
					$dn="M-$cnt";
					$display_list[$uid]=$dn;
				}
                       }
			//print_r($display_list); 
                       //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=3 order by qb_id;";
			$tqry3="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_room_user_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=3 order by b.uid;";
                       $tfq3=mysqli_query($conn, $tqry3);
                       if($tfq3->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq3->fetch_assoc())
                                {       $cnt++;
                                        $uid= trim($rr['uid']); //$qbid= trim($rr['qb_id']);
                                        $dn="T-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
			//print_r($display_list);
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=4 order by qb_id;";
			$tqry4="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_room_user_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=4 order by b.uid;";
                       $tfq4=mysqli_query($conn, $tqry4);
                       if($tfq4->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq4->fetch_assoc())
                                {       $cnt++;
                                        $uid= trim($rr['uid']); //$qbid= trim($rr['qb_id']);
                                        $dn="C-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
			//print_r($display_list);
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=1 order by qb_id;";
			$tqry1="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_room_user_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=1 order by b.uid;";
                       $tfq1=mysqli_query($conn, $tqry1);
                       if($tfq1->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq1->fetch_assoc())
                                {       $cnt++;
                                        $uid= trim($rr['uid']); //$qbid= trim($rr['qb_id']);
                                        $dn="R-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
			//print_r($display_list);
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=0 order by qb_id;";
		       $tqry0="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_room_user_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=0 order by b.uid;";
                       $tfq0=mysqli_query($conn, $tqry0);
                       if($tfq0->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr0 = $tfq0->fetch_assoc())
                                {       $cnt++;
                                        $uid= trim($rr0['uid']); //$qbid= trim($rr['qb_id']);
                                        $dn="Admin-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
			//print_r($display_list);
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=10 order by qb_id;";
			$tqry10 = "SELECT a.`uid`, b.room, b.user_type, a.qb_id, b.cid FROM vcimsdev.vc_user as a JOIN vcimsdev.vc_room_user_map as b ON a.uid=b.uid where b.room ='$tag' AND b.user_type=10 order by a.qb_id;";

                       $tfq10 = mysqli_query($conn, $tqry10);
                       if($tfq10->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq10->fetch_assoc())
                                {       $cnt++;
					$uid= trim($rr['uid']);
                                        //$qbid= trim($rr['qb_id']);
                                        $dn="T-Rec-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
			//echo "tag: ";
			//print_r($display_list);

                       $arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;

                      //$qry="SELECT `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags` FROM `vc_user_detail` WHERE tags='$tag' AND tags!='' order by user_type";
                      //$qry="SELECT a.`uid`,b.`user_type`,a.`qb_id`,a.`qb_password`,a.`name`,a.`mobile`,a.`email`,a.`tags` FROM `vc_user_detail` as a JOIN vc_room_user_map as b ON a.uid=b.uid WHERE a.tags='$tag' AND a.tags!='' order by a.user_type asc";
		       $qry="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcimsdev.vc_user as a JOIN vcimsdev.vc_room_user_map as b ON a.uid=b.uid where b.room ='$tag' AND b.room!='' order by b.user_type;";
                       $rch=mysqli_query($conn, $qry);
                 
                       if($rch->num_rows > 0)
                       {
                          while ($row = $rch->fetch_assoc()) 
                          {
				$utype = trim($row["user_type"]);
                              $qb_id = trim($row["qb_id"]);
                              $tag = trim($row["tags"]);
			      $cuid= trim($row["uid"]);
			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				//$qrr="select * from vc_room where id='$tag' OR room = '$tag'  AND date(substr(sch_end_time,1,10)) >= current_date();";
				$qrr="select * from vcimsdev.vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				//echo $qdd->num_rows ;
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

                         //get qbid for IDI model
			if($rt == 1){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 ){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //chat
                                if($utype == 4 || $utype == 3){
                                   array_push($arr_chat, trim($cuid));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
					$self_a_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($cuid));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
				//talk
				if($utype == 4 ){
					array_push($arr_talk, trim($cuid));
					$self_v_off=1;
					$self_a_off=1;
				}

                                //hear
				/*
				if($utype == 1 && $tflag == 0){
                                   	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
				*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($cuid));
                                }
                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($cuid));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //talk
                                if($utype == 0){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //talk
                                if($utype==10 ){
                                   array_push($arr_talk, trim($cuid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }
                             }
			}  //end of rt == 1 IDI
                              //get qbid for FGD model
			if($rt == 2){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hearc
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($cuid));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($cuid));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 4 ){
                                   array_push($arr_talk, trim($cuid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }

                                //hear
			/*
				if($utype == 1 && $tflag == 0){
                                  	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
			*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($cuid));
                                }

                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($cuid));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($cuid));
					$self_v_off=1;
					$self_a_off=1;
                                }

                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($cuid));
					$self_v_off=1;
					$self_a_off=1;
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($cuid));
					$self_v_off=1;$self_a_off=1;
                                }
                             }
			} //end of rt == 2 FGD

                              //get qbid for Brodcasting model
			if($rt == 3){

                                 // for Moderator OR Respondent
                             if($urole == 1 || $urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   //array_push($arr_chat, trim($qb_id));
                                }
                             }
                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($cuid));
                                }  
                                //chat
                                if($utype == 4 ){
                                   array_push($arr_chat, trim($cuid));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }

                                //hear
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==4 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }

                                //chat
                                if( $utype == 3){
                                   array_push($arr_chat, trim($cuid));
                                }
		
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($cuid));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($cuid));
                                }
                                //talk
                                if($utype==10 ){
                                   array_push($arr_talk, trim($cuid));
					$self_v_off=1; $self_a_off=1;
                                }
                             }
			} //end of rt == 3 Brodcasting
			$uid=$row["uid"];

                  $r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]),"lu_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "dname" => trim($display_list[$uid]), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0,"audio_codec" => "opus", "video_code" => "vp8", "recording" => false,"recording_dir"=>"na","bitrate" => "128000");
                  array_push($response,$r);
                          } //end of while loop
				$arr_talk = array_unique($arr_talk);
				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
                       }
                   $status = 1;
                   $msg="Success";
               }
            }
            else
            {
		//$status=0; $msg='User ID is Not Valid';
		//$status=1; $model='Room details not found';

		//-------- begin of else for check use details -----
				$qchqq="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from vcimsdev.`vc_user_detail` WHERE `uid`=$uid  AND tags !='' limit 1";
				//$qchqq="SELECT a.uid,a.mobile,a.password as qb_password,a.name, a.qb_id,a.email, b.user_type, b.id, b.uid, b.room FROM vc_user as a JOIN  vc_room_user_map as b ON a.uid=b.uid AND b.room ='$tag'";
				$rchkd=mysqli_query($conn, $qchqq);
            	if($rchkd->num_rows > 0)
            	{
				$arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;
               		while ($row = $rchkd->fetch_assoc()) 
               		{
				$display_list = array();
	                       	$urole = trim($row["user_type"]);
        	               	$qbid = trim($row["qb_id"]);                                 
                	       	$tag=trim($row["tags"]);
				$cid=trim($row["cid"]);

                  		$r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]), "qb_id" => trim($row["qb_id"]),"qb_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "dname" => trim('NA'), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0,"audio_codec" => "opus", "video_code" => "vp8", "recording" => false,"recording_dir"=>"na","bitrate" => "128000" );
                  		array_push($response,$r);

			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				$qrr="select * from vcimsdev.vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
			} //end of while loop 

		} // end of if
		//-------- end for check user details ------

	    }
        }
        $this->_returnResponse($conn, $instance, $status, $model, $response);
    }


	//begin test for vcusertaglisttest
    public
    function _vcusertaglisttest(WSC $instance)
    {
        $tag = "**_vcusertaglisttest**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcusertaglisttest details";
        $status = 1;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
     		$response=array(); $model=array(); 
		//$display_list = array();
                $uid=$_REQUEST['uid'];
                 //$qchk="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from `vc_user_detail` WHERE `uid`=$uid  AND tags !=''";
		//$qchk="SELECT distinct a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid AND a.cid=b.cid where b.room IN (SELECT distinct room FROM vc_room where date(substr(sch_end_time,1,10)) <= current_date() order by id desc) AND b.cid = (select distinct cid FROM vc_user WHERE uid=$uid);";
		$qchk ="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email` FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid AND b.uid=$uid AND a.cid=b.cid where b.room IN (SELECT room FROM vc_room where date(substr(sch_end_time,1,10)) >= current_date() order by id desc);";
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {
               while ($row2 = $rchk->fetch_assoc()) 
               {
			$display_list = array();
			//print_r($row2);
                       $urole = trim($row2["user_type"]);
                       $qbid = trim($row2["qb_id"]);                                 
                       $tag=trim($row2["tags"]);
			$cid=trim($row2["cid"]);

			$tflag=0;
		       //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=2 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=2 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
				$tflag=1;
				$cnt=0;
				while( $rr = $tfq->fetch_assoc())
				{	$cnt++;
					 $qbid= trim($rr['qb_id']);
					$dn="M-$cnt";
					$display_list[$qbid]=$dn;
				}
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=3 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=3 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="T-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=4 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=4 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="C-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=1 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=1 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="R-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=0 order by qb_id;";
			$tqry="select a.uid,a.user_type,b.qb_id from vc_room_user_map as a JOIN vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=0 order by b.qb_id;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="Admin-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=10 order by qb_id;";
			$tqry = "SELECT a.`uid`, b.room, b.user_type, a.qb_id, b.cid FROM vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid where b.room ='$tag' AND b.user_type=10 order by a.qb_id;";

                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
                                $tflag=1;
                                $cnt=0;
                                while( $rr = $tfq->fetch_assoc())
                                {       $cnt++;
                                         $qbid= trim($rr['qb_id']);
                                        $dn="T-Adm-$cnt";
                                        $display_list[$qbid]=$dn;
                                }
                       }
			//echo "tag: "; print_r($display_list);
                       $arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;
                       
                      //$qry="SELECT `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags` FROM `vc_user_detail` WHERE tags='$tag' AND tags!='' order by user_type";
                      //$qry="SELECT a.`uid`,b.`user_type`,a.`qb_id`,a.`qb_password`,a.`name`,a.`mobile`,a.`email`,a.`tags` FROM `vc_user_detail` as a JOIN vc_room_user_map as b ON a.uid=b.uid WHERE a.tags='$tag' AND a.tags!='' order by a.user_type asc";
		       $qry="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcims.vc_user as a JOIN vc_room_user_map as b ON a.uid=b.uid where b.room ='$tag' AND b.room!='' order by b.user_type;";
                       $rch=mysqli_query($conn, $qry);
                 
                       if($rch->num_rows > 0)
                       {
                          while ($row = $rch->fetch_assoc()) 
                          {
				$utype = trim($row["user_type"]);
                              $qb_id = trim($row["qb_id"]);
                              $tag = trim($row["tags"]);
			      $cuid= trim($row["uid"]);
			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				//$qrr="select * from vc_room where id='$tag' OR room = '$tag'  AND date(substr(sch_end_time,1,10)) >= current_date();";
				$qrr="select * from vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				//echo $qdd->num_rows ;
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

                         //get qbid for IDI model
			if($rt == 1){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
					$self_a_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
				//talk
				if($utype == 4 ){
					array_push($arr_talk, trim($qbid));
					$self_v_off=1;
					$self_a_off=1;
				}

                                //hear
				/*
				if($utype == 1 && $tflag == 0){
                                   	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
				*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype == 0){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==10 ){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }
                             }
			}  //end of rt == 1 IDI
                              //get qbid for FGD model
			if($rt == 2){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 4 ){
                                   array_push($arr_talk, trim($qbid));
				   $self_v_off=1;
				   $self_a_off=1;
                                }

                                //hear
			/*
				if($utype == 1 && $tflag == 0){
                                  	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
			*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }

                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;
					$self_a_off=1;
                                }

                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
					$self_v_off=1;
					$self_a_off=1;
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }
                             }
			} //end of rt == 2 FGD

                              //get qbid for Brodcasting model
			if($rt == 3){

                                 // for Moderator OR Respondent
                             if($urole == 1 || $urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   //array_push($arr_chat, trim($qb_id));
                                }
                             }
                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
					$self_v_off=0;
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 ){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }

                                //hear
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==4 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }

                                //chat
                                if( $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
		
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==0 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1;$self_a_off=1;
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //talk
                                if($utype==10 ){
                                   array_push($arr_talk, trim($qbid));
					$self_v_off=1; $self_a_off=1;
                                }
                             }
			} //end of rt == 3 Brodcasting
			$qbbid=$row["qb_id"];

                  $r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]), "qb_id" => trim($row["qb_id"]),"qb_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "dname" => trim($display_list[$qbbid]), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0);
                  array_push($response,$r);
                          } //end of while loop
				$arr_talk = array_unique($arr_talk);
				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
                       }
                   $status = 1;
                   $msg="Success";
               }
            }
            else
            {
		//-------- begin of else for check use details -----
		$qchqq="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from `vc_user_detail` WHERE `uid`=$uid  AND tags !='' limit 1";
		$rchkd=mysqli_query($conn, $qchqq);
            	if($rchkd->num_rows > 0)
            	{
			$arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;
               		while ($row = $rchkd->fetch_assoc()) 
               		{
				$display_list = array();
	                       	$urole = trim($row["user_type"]);
        	               	$qbid = trim($row["qb_id"]);                                 
                	       	$tag=trim($row["tags"]);
				$cid=trim($row["cid"]);

                  		$r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]), "qb_id" => trim($row["qb_id"]),"qb_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "dname" => trim('NA'), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0);
                  		array_push($response,$r);

			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				$qrr="select * from vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
			} //end of while loop 

		} // end of if
		//-------- end for check user details ------
		//$status=0; $msg='User ID is Not Valid';
		$status=1; 
		//$model='Room details not found';
	    }
        }
        $this->_returnResponse($conn, $instance, $status, $model, $response);
     }
	//end test for vcusertaglist

     //video conferencing user list of same tag/room of a uid
    public
    function _vcusertaglisttestold(WSC $instance)
    {
        $tag = "**_vcusertaglist**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vcusertaglist details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {           
     		$response=array(); $model=array();
                $uid=$_REQUEST['uid'];       		                 
                 $qchk="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from `vc_user_detail` WHERE `uid`=$uid  AND tags!=''";              
                 $rchk=mysqli_query($conn, $qchk);
                 
            if($rchk->num_rows > 0)
            {     
               while ($row2 = $rchk->fetch_assoc()) 
               {
                       $urole = trim($row2["user_type"]);
                       $qbid = trim($row2["qb_id"]);                                 
                       $tag=trim($row2["tags"]);
			$tflag=0;
			$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=3;";
                       $tfq=mysqli_query($conn, $tqry);
                       if($tfq->num_rows > 0)
                       {
				$tflag=1;
                       }
                       $arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();
                       
                      $qry="SELECT a.`uid`,b.`user_type`,a.`qb_id`,a.`qb_password`,a.`name`,a.`mobile`,a.`email`,a.`tags` FROM `vc_user_detail` as a JOIN vc_room_user_map as b ON a.uid=b.uid WHERE a.tags='$tag' AND a.tags!='' order by a.user_type asc";
                       $rch=mysqli_query($conn, $qry);
                 
                       if($rch->num_rows > 0)
                       {
                          while ($row = $rch->fetch_assoc()) 
                          {
				$utype = trim($row["user_type"]);
                              $qb_id = trim($row["qb_id"]);
                              $tag = trim($row["tags"]);
			      $cuid= trim($row["uid"]);
			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				$qrr="select * from vc_room where id='$tag' OR room = '$tag';";
				$qdd=mysqli_query($conn, $qrr);
				//echo $qdd->num_rows ;
				if($qdd->num_rows > 0){
				   while($rw=$qdd->fetch_assoc()){
					$cnf_id= trim($rw['id']);
					$cnf_st_dt = trim($rw['sch_start_dt']);
					$cnf_st_tm = trim($rw['sch_start_time']);
					$cnf_end_tm = trim($rw['sch_end_time']);
					$cnf_tz = trim($rw['timezone']);
					$cnf_room = trim($rw['room']);
                                        $cnf_gen = trim($rw['gender']);
                                        $cnf_age = trim($rw['age']);
                                        $cnf_sec = trim($rw['sec']);
                                        $cnf_usrship = trim($rw['usership']);
					$rt= trim($rw['room_type']);
					$ssf= trim($rw['ss_flag']);
					$room_arr=array('id'=>$cnf_id,'room'=>$cnf_room,'room_type'=>$rt,'gender'=>$cnf_gen,'age'=>$cnf_age,'sec'=>$cnf_sec,'usership'=>$cnf_usrship,'timezone'=>$cnf_tz,'sch_start_date'=>$cnf_st_dt,'sch_start_time'=>$cnf_st_tm,'sch_end_time'=>$cnf_end_tm, 'secure_flag'=>$ssf);
				   }
				}

                         //get qbid for IDI model
			if($rt == 1){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
                                   array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
                                   array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }

                                //hear
				/*
				if($utype == 1 && $tflag == 0){
                                   	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
				*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                             }
			}  //end of rt == 1 IDI
                              //get qbid for FGD model
			if($rt == 2){
                                  //for Respondent
                             if($urole == 1 ){
                                //see
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
    				/*
                                if($utype == 2 ){
                                   array_push($arr_chat, $qb_id );
                                }                                
				*/
                             }
                                 // for Moderator
                             if($urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
                             }

                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
                                   array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 || $utype == 2){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }

                                //hear
			/*
				if($utype == 1 && $tflag == 0){
                                  	array_push($arr_hear, trim($qb_id));
				}
                                if($utype == 2 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 0){
                                        array_push($arr_hear, trim($qb_id));
                                }
                                if($utype == 3 && $tflag == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }
			*/
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }

                                //chat
                                if($utype == 2 || $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
				/*
                                if($utype == 3 && $tflag == 1){
                                   array_push($arr_chat, $qb_id);
                                }
				*/
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                             }
			} //end of rt == 2 FGD

                              //get qbid for Brodcasting model
			if($rt == 3){

                                 // for Moderator OR Respondent
                             if($urole == 1 || $urole == 2){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 || $utype == 1){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   //array_push($arr_hear, trim($qb_id));
                                }
                                //chat
                                if($utype == 4  || $utype == 2 || $utype == 3){
                                   //array_push($arr_chat, trim($qb_id));
                                }
                             }
                                // for Translator
                             if($urole == 3){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //talk
                                if($utype == 2 ){
                                   //array_push($arr_talk, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }  
                                //chat
                                if($utype == 4 ){
                                   array_push($arr_chat, trim($qb_id));
                                } 

                             }
                                //for Client
                             if($urole == 4){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }

                                //hear
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($qb_id));
                                }

                                //chat
                                if( $utype == 3){
                                   array_push($arr_chat, trim($qb_id));
                                }
		
                             } 
                                 // for Recorder/Admin for Moderator in general
                             if($urole == 0 ){
                                //see
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 1 || $utype == 2 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                             }
                                 // for Recorder for translator only
                             if($urole == 10 ){
                                //see
                                if($utype == 1 || $utype == 2  ){
                                   array_push($arr_see, trim($qb_id));
                                }
                                //hear
                                if($utype == 3 ){
                                   array_push($arr_hear, trim($qb_id));
                                }
                             }
			} //end of rt == 3 Brodcasting

                  $r = array("uid" => trim($row["uid"]), "user_type" => trim($row["user_type"]), "qb_id" => trim($row["qb_id"]),"qb_password" => trim($row["qb_password"]),"login" => trim($row["mobile"]), "name" => trim($row["name"]), "email" => trim($row["email"]), "tags" => trim($row["tags"]), "created_at" => '', "last_sign_in" => 0);
                  array_push($response,$r);
                          } //end of while loop
				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat, "room_schedule"=>$room_arr );
				array_push($model,$m);
                       }
                   $status = 1;
                   $msg="Success";
               }
            }
            else
            {  $status=0; $msg='User ID is Not Valid';}
        }
        $this->_returnResponse($conn, $instance, $status, $model, $response);
    }

// to mark attendance
   public
   function _vEmpAttendance(WSC $instance)
   {
        $tag = "**_vEmplogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vempattence details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
	$dt = strtotime( $dt ) * 1000;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $response=array();
            $uid = $_REQUEST['uid']; $req_type = $_REQUEST['req_type']; $att_date = $_REQUEST['att_date']; $in_time = $_REQUEST['in_time'];
		$out_time = $_REQUEST['out_time']; 
		$att_flag=$_REQUEST['att_flag'];$emp_remark =$_REQUEST['emp_remark'];

	    // for making attendance of office,field,wfh,meeting
            if($att_flag >= 1 && $att_flag <= 4){
		if($req_type == 1)
		{
 			$qchk="INSERT INTO `vpms`.`vams_attendance`( `uid`,`att_date`,`in_time`, in_timestamp, `att_type`,`emp_remarks`) VALUES ($uid, '$att_date', '$in_time', '$dt', '$att_flag','$emp_remark');";
                	$rchk=mysqli_query($conn, $qchk);
                   $status=1;
                   $msg='Successfully done!';
		}
                if($req_type == 2)
                {
			if($out_time !='' )
			{
				$sql="UPDATE `vpms`.`vams_attendance` SET `out_time` = '$out_time',`out_timestamp` = '$dt' WHERE uid = $uid AND  `att_date`= '$att_date' AND `in_time`='$in_time' ; ";
                        	$rchk=mysqli_query($conn, $sql);
			}
                   	$status=1;
                   	$msg='Successfully done!';
		}
	   }
	   if($att_flag >= 5)
	   {
		 $result = json_decode($att_date);
		 foreach($result as $res)
		 {

 $qchk="INSERT INTO `vpms`.`vams_attendance`( `uid`,`att_date`,`in_time`,`in_timestamp`,`out_time`,`att_type`,`emp_remarks`) VALUES ($uid, '$res', '$in_time','$dt' , '$out_time','$att_flag','$emp_remark');";
                        $rchk=mysqli_query($conn, $qchk);
			 $status=1;
                        $msg='Sucessfully done!';
                 }
		       // $status=0;
                       // $msg='Not yet processed done!';

	   } // end of if balnk value cond
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response);

   } //end of function

// to mark all attendance
   public
   function _vEmpViewAllAttendance(WSC $instance)
   {
        $tag = "**_vEmpViewAllAttendance**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vemplogin details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            	$response=array();
          	$uid = $_REQUEST['uid']; $attdate = $_REQUEST['att_date']; 
		$filter = $_REQUEST['flag'];
		$role = '0'; $empid = '0'; $empname='0'; $compid='0';
		//to get role of user
                 $qrr = "select * from vpms.vams_employee WHERE id = $uid and status = 1";
                 $qdd = mysqli_query($conn, $qrr);
                 if($qdd->num_rows > 0){
	                 while($rw=$qdd->fetch_assoc()){
                              	$role =  trim($rw['role']);
				$empid =  trim($rw['emp_id']);
				$empname =  trim($rw['name']);
				$compid = $rw['company_id'];
			}
		}

		//to get all list by HR
		if($role == 1)
		{
                 $qrr="select * from vpms.vams_employee WHERE  company_id = $compid AND status = 1;";
                 $qdd=mysqli_query($conn, $qrr);
                 if($qdd->num_rows > 0){
                         while($rw=$qdd->fetch_assoc()){
                                $emp_role =  trim($rw['role']);
                                $emp_id =  trim($rw['emp_id']);
				$img_url = trim($rw['img_url']);
                                $emp_name =  trim($rw['name']);
				$id = trim($rw['id']);


				$atd_arr=array();

        			$qrr2="select * from vpms.vams_attendance WHERE uid = '$id' and in_time IN (select distinct in_time from vpms.vams_attendance WHERE  att_date = '$attdate' );";
				if($filter == 2) $qrr2="select * from vpms.vams_attendance WHERE uid = '$id' and in_time IN (select distinct in_time from vpms.vams_attendance WHERE  att_date = '$attdate' ) AND att_type IN (4,5) AND (appr_status=0 AND manager_appr_status=0) ;";
				if($filter == 3) $qrr2="select * from vpms.vams_attendance WHERE uid = '$id' and in_time IN (select distinct in_time from vpms.vams_attendance WHERE  att_date = '$attdate' ) AND att_type IN (1,2,3) ;";
                  		$qdd2 = mysqli_query($conn, $qrr2);
                  		if($qdd2->num_rows > 0){
                         		while($rw = $qdd2->fetch_assoc()){
                              		$att_date =  trim($rw['att_date']);
					$in_time =  trim($rw['in_time']);
					$out_time =  trim($rw['out_time']);
					$att_type =  trim($rw['att_type']);
					$hr_appr =  trim($rw['appr_status']);
					$mgr_appr =  trim($rw['manager_appr_status']);
					$hr_remarks =  trim($rw['hr_remarks']);
					$mgr_remarks =  trim($rw['manager_remarks']);
					$emp_remarks =  trim($rw['emp_remarks']);
					$a_arr=array("att_date"=>$att_date,"in_time"=>$in_time,"out_time"=>$out_time,"att_type"=>$att_type,"hr_approval"=>$hr_appr,
"hr_remarks"=>$hr_remarks,"manager_approval"=>$mgr_appr,"manager_remarks"=>$mgr_remarks,"emp_remarks"=>$emp_remarks);
					array_push($atd_arr,$a_arr);
                        	  }
				   if($filter == 2 || $filter ==3)
				   {
                            		$emp_arr = array("uid"=>$id, "emp_id"=>$emp_id,"emp_name"=>$emp_name,"image_url"=>$img_url,"emp_role"=>$emp_role,"attendance"=>$atd_arr);
                                	array_push($response, $emp_arr);
				   }
                  		} //end of att if
				 if($filter == 1){
                                   $emp_arr = array("uid"=>$id, "emp_id"=>$emp_id,"emp_name"=>$emp_name,"image_url"=>$img_url,"emp_role"=>$emp_role,"attendance"=>$atd_arr);
                                   array_push($response, $emp_arr);
				}
			} //end of while for emp list

                         $status=1;
   			 $msg='Successfully done!';
		    } //end of emp list if

		} //end of HR role

                //to get all list by Manager
                if($role == 2)
                {

                 $qrr="select * from vpms.vams_employee WHERE id in (SELECT distinct emp_uid FROM vpms.vams_admin_emp WHERE uid= '$uid') AND company_id = $compid AND status = 1;";
                 $qdd=mysqli_query($conn, $qrr);
                 if($qdd->num_rows > 0){

                         while($rw=$qdd->fetch_assoc()){
                                $emp_role =  trim($rw['role']);
                                $emp_id =  trim($rw['emp_id']);
                                $emp_name =  trim($rw['name']);
				$img_url = trim($rw['img_url']);

				$id = trim($rw['id']);
                                $atd_arr=array();
          		$qrr2="select * from vpms.vams_attendance WHERE uid = $id and in_time IN (select distinct in_time from vpms.vams_attendance WHERE  att_date = '$attdate') ;";
			if($filter == 2) $qrr2="select * from vpms.vams_attendance WHERE uid = $id and in_time IN (select distinct in_time from vpms.vams_attendance WHERE  att_date = '$attdate' ) AND att_type IN (4,5)  and (appr_status=0 AND manager_appr_status=0);";
			if($filter == 3) $qrr2="select * from vpms.vams_attendance WHERE uid = $id and in_time IN (select distinct in_time from vpms.vams_attendance WHERE  att_date = '$attdate') AND att_type IN (1,2,3)  ;";
                                $qdd2 = mysqli_query($conn, $qrr2);
                                if($qdd2->num_rows > 0){
                                        while($rw = $qdd2->fetch_assoc()){
                                        $att_date =  trim($rw['att_date']);
                                        $in_time =  trim($rw['in_time']);
                                        $out_time =  trim($rw['out_time']);
                                        $att_type =  trim($rw['att_type']);
                                        $hr_appr =  trim($rw['appr_status']);
                                        $mgr_appr =  trim($rw['manager_appr_status']);
                                        $hr_remarks =  trim($rw['hr_remarks']);
                                        $mgr_remarks =  trim($rw['manager_remarks']);
                                        $emp_remarks =  trim($rw['emp_remarks']);

                                        $a_arr=array("att_date"=>$att_date,"in_time"=>$in_time,"out_time"=>$out_time,"att_type"=>$att_type,"hr_approval"=>$hr_appr,
"hr_remarks"=>$hr_remarks,"manager_approval"=>$mgr_appr,"manager_remarks"=>$mgr_remarks,"emp_remarks"=>$emp_remarks);
                                        array_push($atd_arr,$a_arr);
                                   }
                                        
                                   if($filter == 2 || $filter ==3)
                                   {
                                	$emp_arr = array("uid"=>$id, "emp_id"=>$emp_id,"emp_name"=>$emp_name,"image_url"=>$img_url,"emp_role"=>$emp_role,"attendance"=>$atd_arr);
                                	array_push($response, $emp_arr);
				   }
                                } //end of att if
                                 if($filter == 1){
                                   $emp_arr = array("uid"=>$id, "emp_id"=>$emp_id,"emp_name"=>$emp_name,"image_url"=>$img_url,"emp_role"=>$emp_role,"attendance"=>$atd_arr);
                                   array_push($response, $emp_arr);
                                }

                        } //end of while for emp list
                         $status=1;
                         $msg='Successfully done!';
                    } //end of emp list if

                } //end of MANAGER role

        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response);

   } //end of function

// to view single user attendance
   public
   function _vEmpViewOneAttendance(WSC $instance)
   {
        $tag = "**_vEmpViewOneAttendance**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vemplogin details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $response=array();
            $uid = $_REQUEST['uid']; $att_date = $_REQUEST['att_date'];

                //to get a emp attendance of a date
                if($uid >= 1)
                {

                $qrr="select a.role,a.name,a.emp_id,b.leave_alloted,b.date_from, b.date_to FROM vpms.vams_employee as a JOIN vpms.vams_leave as b ON a.id=b.uid WHERE a.id = '$uid' AND a.status = 1 ORDER BY b.id desc limit 1;";
                 $qdd=mysqli_query($conn, $qrr);
                 if($qdd->num_rows > 0){

                         while($rw=$qdd->fetch_assoc()){
                                $emp_role =  trim($rw['role']);
                                $emp_id =  trim($rw['emp_id']);
                                $emp_name =  trim($rw['name']);
				$leave_alloted = $rw['leave_alloted'];
				$date_fr = $rw['date_from'];
				$date_to = $rw['date_to'];
                                $atd_arr=array();
				$leave_taken=0;
                                $qrr3="select * from vpms.vams_attendance WHERE uid = '$uid' and att_type = 5 AND ( appr_status = 1 OR manager_appr_status = 1) AND att_date >= '$date_fr' AND att_date <= '$date_to';";
                                $qdd3 = mysqli_query($conn, $qrr3);
                                if($qdd3->num_rows > 0){
                                        while($rw = $qdd3->fetch_assoc()){
                                        	$leave_taken++;
					}
				}
				$leave_due = $leave_alloted - $leave_taken;
                                $qrr2="select * from vpms.vams_attendance WHERE uid = '$uid' and att_date = '$att_date' ;";
                                $qdd2 = mysqli_query($conn, $qrr2);
                                if($qdd2->num_rows > 0){
                                        while($rw = $qdd2->fetch_assoc()){
                                        $att_date =  trim($rw['att_date']);
                                        $in_time =  trim($rw['in_time']);
                                        $out_time =  trim($rw['out_time']);
                                        $att_type =  trim($rw['att_type']);
                                        $hr_appr =  trim($rw['appr_status']);
                                        $mgr_appr =  trim($rw['manager_appr_status']);
                                        $hr_remarks =  trim($rw['hr_remarks']);
                                        $mgr_remarks =  trim($rw['manager_remarks']);
                                        $emp_remarks =  trim($rw['emp_remarks']);
                                        $a_arr=array("att_date"=>$att_date,"in_time"=>$in_time,"out_time"=>$out_time,"att_type"=>$att_type,"hr_approval"=>$hr_appr,
"hr_remarks"=>$hr_remarks,"manager_approval"=>$mgr_appr,"manager_remarks"=>$mgr_remarks,"emp_remarks"=>$emp_remarks);
                                        array_push($atd_arr,$a_arr);
                                        }
                                } //end of att if
                                $emp_arr = array("emp_id"=>$emp_id,"emp_name"=>$emp_name,"emp_role"=>$emp_role,"leave_balance"=>$leave_due,"attendance"=>$atd_arr);
                                array_push($response, $emp_arr);
                        } //end of while for emp list
                         $status=1;
                         $msg='Successfully done!';

		}
	    } //end of if uid >0

        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response);

   } //end of function

// to mark approve
   public
   function _vEmpApprove(WSC $instance)
   {
        $tag = "**_vEmpApprove**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vempapprove details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $response=array();
            $uid = $_REQUEST['uid']; $admin_uid = $_REQUEST['admin_uid']; $att_date = $_REQUEST['att_date']; $appr_status = $_REQUEST['approve_flag'];
            $remarks =$_REQUEST['remarks']; $role='0';

                //to get role of user
                 $qrr = "select * from vpms.vams_employee WHERE id = $admin_uid and status = 1";
                 $qdd = mysqli_query($conn, $qrr);
                 if($qdd->num_rows > 0){
                         while($rw=$qdd->fetch_assoc()){
                                $role =  trim($rw['role']);
                                $empid =  trim($rw['emp_id']);
                                $empname =  trim($rw['name']);
                                $compid = $rw['company_id'];
                        }
                }

		if($role == '1' || $role == '2')
		{
			$result = json_decode($att_date);
			foreach($result as $atd)
			{
                                $qrr2="select * from vpms.vams_attendance WHERE uid = $uid and att_date = '$atd' ;";
                                $qdd2 = mysqli_query($conn, $qrr2);
                                if($qdd2->num_rows > 0){
                                        while($rw2 = $qdd2->fetch_assoc()){
                                        	$att_date =  trim($rw2['att_date']);
                                        	//$in_time =  trim($rw2['in_time']);
						$sql="UPDATE vpms.vams_attendance SET appr_status=$appr_status, hr_remarks='$remarks' WHERE uid= $uid and att_date='$atd';";
						if($role == '2') $sql="UPDATE vpms.vams_attendance SET manager_appr_status=$appr_status, manager_remarks='$remarks' WHERE uid= $uid and att_date='$atd';";
						//echo $sql;
						$qa = mysqli_query($conn, $sql);
					}
                                                $status = 1;
                                                $msg="Successfully done!";
				}
			} //end of foreach
		}
		else{
			 $status = 0;
                         $msg='Unautherised Role Attempt made!';
		}

        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response);

   } //end of function

       //attendance user login
    public
    function _vEmpLogin(WSC $instance)
    {
        $tag = "**_vEmplogin**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To get vemplogin details";
        $status = 0;
        $dt = date('Y-m-d H:i:s');
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
            $response=array();
            $login=$_REQUEST['login']; $pass=$_REQUEST['password']; $fcm_token = $_REQUEST['fcm_token'];$cdate=$_REQUEST['current_date'];
            if($login!='' && $pass !=''){
                $qchk="SELECT * FROM vpms.vams_employee WHERE mobile='$login' and status = 1; ";
                $rchk=mysqli_query($conn, $qchk);
                if($rchk->num_rows > 0){
                   while ($row = $rchk->fetch_assoc())
                   {
		     $uid = $row['id'];
                     $empid=$row['emp_id'];
                     $salt=$row['salt'];
                     $pwd=$row['password'];
                     $fname=$row['name'];
                     $mobile=$row['mobile'];
                     $pemail=$row['email'];
                     $ts=$row['timeslot_id'];
                     $dob=$row['dob'];
                     $comp =$row['company_id'];
                     $branch =$row['branch_id'];
                     $fcm=$row['fcm_token'];
                     $desg=$row['designation'];
                     $doj=$row['doj'];
		     $role = $row['role'];
			$img_url=$row['img_url'];
                     
		// getting branch details
                     	$badd = 'NA'; $cname='';$cadd=''; $latt ='0'; $lang='0'; $radius = '0'; $day1=0; $day2=0;
			$intime=0;$outtime=0; $att_flag=0; $leave_alloted=0; $leave_alloted_f=0; $leave_alloted_t=0;$gmt=5.3;
			$att_dt=array();
                     if($branch > 0)
                     {

                        $qchk1="SELECT * FROM vpms.vams_branch where branch_id = $branch; ";
                        $rchk1=mysqli_query($conn, $qchk1);
                        if($rchk1->num_rows > 0){
                                while ($row = $rchk1->fetch_assoc())
                                {
					$badd = $row['address'];
                                        $latt = $row['latt'];
                                        $lang = $row['lang'];
					$radius = $row['radius'];
					$day1 = $row['day1']; //value 0 means not applicable
					$day2 = $row['day2'];
					$gmt = $row['gmt'];
                                }
                        }
			//to get comapany name
                        $qchk2="SELECT * FROM vpms.vams_company where company_id = $comp; ";
                        $rchk2=mysqli_query($conn, $qchk2);
                        if($rchk2->num_rows > 0){
                                while ($row = $rchk2->fetch_assoc())
                                {
                                        $cname = $row['name'];
                                        $cadd = $row['address'];
                                }
                        }
			//to get leave alloted
                        $qchk3="SELECT * FROM vpms.vams_leave where uid = $uid AND (date_from <= $cdate AND date_to >= $cdate) ; ";
                        $rchk3=mysqli_query($conn, $qchk3);
                        if($rchk3->num_rows > 0){
                                while ($row = $rchk3->fetch_assoc())
                                {
                                        $leave_alloted = $row['leave_alloted'];
                                        $leave_alloted_f  = $row['date_from'];
					$leave_alloted_t  = $row['date_to'];
                                }
                        }

			// to get attendance of a date
                        $qchk2="SELECT * FROM vpms.vams_attendance where uid = $uid and att_date = '$cdate'; ";
                        $rchk2=mysqli_query($conn, $qchk2);
                        if($rchk2->num_rows > 0){
                                while ($row = $rchk2->fetch_assoc())
                                {
                                        $intime = $row['in_time'];
                                        $outtime = $row['out_time'];
					$att_flag=$row['att_type'];
					//array_push($att_dt,$row['att_date']);
                                }
                        }
                        $qchk2="SELECT * FROM vpms.vams_attendance where uid = $uid and att_date >= '$cdate'; ";
                        $rchk2=mysqli_query($conn, $qchk2);
                        if($rchk2->num_rows > 0){
                                while ($row = $rchk2->fetch_assoc())
                                {
                                        //$intime = $row['in_time'];
                                        //$outtime = $row['out_time'];
                                        //$att_flag=$row['att_type'];
                                        array_push($att_dt,$row['att_date']);
                                }
                        }

			//end of attendance of a day

                     } // end of branch details if

		     $ts_in=''; $ts_out=''; $tm_in='0'; $tm_out='0';
		     if($ts > 0 && $ts < 4)
		     {
			
                	$qchk="SELECT * FROM vpms.vamps_timeslot where timeslot_id= $ts; ";
                	$rchk=mysqli_query($conn, $qchk);
                	if($rchk->num_rows > 0){
                   		while ($row = $rchk->fetch_assoc())
                   		{
                     			$ts_in =$row['in_time'];
					$ts_out =$row['out_time'];
		   		}
			}
		     } // end of timeslot if

                     $check=$this->hashMake($pass,$salt);
                     if($pwd === $check){
                        $status = 1;
                        $msg="Success";
			$response = array("uid"=>$uid,"emp_id"=>$empid,"role"=>$role,"image_url"=>$img_url,"name"=>$fname,"mobile"=>$mobile,"email"=>$pemail,"dob"=>$dob, "doj"=>$doj,"designation"=>$desg,"fcm_token"=>$fcm_token,"in_timeslot"=>$ts_in,"out_timeslot"=>$ts_out,"branch_address"=>$badd,"comapany_name"=>$cname, "branch_id"=>$branch, "comp_id"=>$comp,"image_url"=>$img_url, "latt"=>$latt, "lang"=>$lang, "radius"=>$radius,"day1"=>$day1,"day2"=>$day2,"leave_alloted"=>$leave_alloted, "leave_alloted_from"=>$leave_alloted_f,"leave_alloted_till"=>$leave_alloted_t, "gmt"=>$gmt, "in_time"=>$intime, "out_time"=>$outtime,"att_flag"=>$att_flag,"att_dates"=>$att_dt);

                        $qchk2="UPDATE `vpms`.`vams_employee` SET `fcm_token` ='$fcm_token' WHERE `mobile` = '$mobile'; ";
                        $rchk2=mysqli_query($conn, $qchk2);
                     }
                     else{
                        $status = 0;
                        $msg='Incorrect Login/Password';
			$response = null;
                     }
                  }  
               }
               else{  
                   $status=0; 
                   $msg='Incorrect Login/Password';
		   $response = null;
               }
             }
             else{  
                   $status=0; 
                   $msg='Incorrect Login/Password or blank';
             }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    } 

    //begin of ctrdataexport of wifi based man entry pass counter
    public
    function _ctrDataExport(WSC $instance)
    {
           $tag = "**_ctrDataExport**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To ctrDataExport";
        $status = 0;
        $table="counter_detail";
//        $first_id=0;
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
	$time='';
	    $did=$_REQUEST['device_id'];
            $time=$_REQUEST['time'];
            $jsonPost = stripslashes($_REQUEST['data']); 
		$str='Attempting..';
            $result = json_decode($jsonPost);
            foreach ($result as $json) {
                $column = null;
                $isFirst = false;
                $value = null;
                //foreach ($json as $keyy){
//print_r($keyy);
                	foreach ($json as $ky){ 
                        	$rssi=$ky->rssi;
				$comp=$ky->company;
				$mac=$ky->mac;
        			$dt = date('Y-m-d H:i:s');
				$sql="INSERT INTO $table (device_id,rssi,company,mac,timestamp,rtime) VALUES ($did, abs($rssi),'$comp','$mac','$dt','$time');";
				if (!mysqli_query($conn, $sql)){$status=0;
                        		$this->_returnError($conn, $instance, $sql);
	                        }
				$status=1;
                	}
               // }

               $msg= 'Sucess';
            }
            if ($isFirst) {
                $status = 1;
                $msg = "Result Exported in $table Successfully";
            }
        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
   } //end of ctrdataexport


    //to export data of respondent location 
    public
    function _locationExport(WSC $instance)
    {
        $tag = "**_exportResult**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;
        $table="respondent_location";
	
	$respid=$_REQUEST['respid'];
	$latt=$_REQUEST['latt'];
	$langg=$_REQUEST['lang'];
	$tm=$_REQUEST['timestamp'];

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

       		if ($respid != '' && $latt != '') {
		     $dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (respid, latt, lang, at_time, timestamp) VALUES ('$respid', '$latt', '$langg', '$tm','$dt' );"; 
                     if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
		     $status = 1;
               	     $msg = "Result Exported in $table Successfully";
            	}

        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
	//end of export respondent location

    //to export data of apptrackermanual
    public
    function _appTrackerManual(WSC $instance)
    {
        $tag = "**_apptrackermanual**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;

        $table="app_tracker_manual";
        $respid=$_REQUEST['uid'];
        $app=$_REQUEST['app'];
        $et = $_REQUEST['end_time'];
        $st=$_REQUEST['start_time'];
        $dr=$_REQUEST['duration'];
        $latt=$_REQUEST['latt'];
        $langg=$_REQUEST['lang'];
        $tm=$_REQUEST['timestamp'];

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                if ($respid != '' && $app != '') {
                     $dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (uid, app, end_time, latt, lang, start_time, duration, timestamp) VALUES ('$respid', '$app','$et','$latt', '$langg', '$st', '$dr','$tm' );";
                     if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
                     $status = 1;
                     $msg = "Result Exported in $table Successfully";
                }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    // end of apptrackermanual

    //to export data of apptrackersystem
    public
    function _appTrackerSystem(WSC $instance)
    {
        $tag = "**_apptrackersystem**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;

        $table="app_tracker_system";
        $respid=$_REQUEST['uid'];
        $app=$_REQUEST['app'];
        $tt=$_REQUEST['total_time'];
        //$ts=$_REQUEST['time_spent'];
        $dt=$_REQUEST['duration_type'];
        $lut=$_REQUEST['last_used_time'];
        $tf=$_REQUEST['timestamp_first'];
	 $tl=$_REQUEST['timestamp_last'];
        $tm=$_REQUEST['timestamp'];

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                if ($respid != '' && $app != '') {
                     //$dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (uid, app, total_time,  duration_type,last_used_time,timestamp_first,timestamp_last, timestamp) VALUES ('$respid', '$app','$tt', '$dt', '$lut', '$tf', '$tl', '$tm' );";
                     if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
                     $status = 1;
                     $msg = "Result Exported in $table Successfully";
                }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    // end of apptrackersystem

    //to export data of apptrackerscreen
    public
    function _appTrackerScreen(WSC $instance)
    {
        $tag = "**_apptrackerscreen**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;

        $table="app_tracker_screen";
        $respid=$_REQUEST['uid'];
        $sid=$_REQUEST['sid'];
        $tt=$_REQUEST['text'];
        $o=$_REQUEST['object'];
        $tm=$_REQUEST['timestamp'];

        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                if ($respid != '' && $sid != '') {
                     $dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (uid, scid, text, object, timestamp) VALUES ('$respid', '$sid','$tt','$o','$tm' );";
                     $dd=mysqli_query($conn, $sql);

                     $status = 1;
                     $msg = "Result Exported in $table Successfully";
                }

        }
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    // end of apptrackerscreen


    //to export data of apptrackercamera
    public
    function _appTrackerCamera(WSC $instance)
    {
        $tag = "**_apptrackercamera**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;

        $table="app_tracker_camera";
        $uid=$_REQUEST['uid'];
        $sid=$_REQUEST['ccid'];
        $data=$_REQUEST['data'];
        $tm=$_REQUEST['timestamp'];
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                if ($uid != '') {
                     $dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (uid, ccid, data, timestamp) VALUES ('$uid', '$sid','$data','$tm' );";
                     if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
                     $status = 1;
                     $msg = "Result Exported in $table Successfully";
                }
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    // end of apptrackerscreen
    //start of APPTRACKERSETTING
    public
    function _appTrackerSetting(WSC $instance)
    {
        $tag = "**_apptrackercamera**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Find Data";
        $status = 0;
	$response=array();
        $table="app_tracker_setting";
        $app_type = $_REQUEST['app_type'];
        if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                if ($app_type != '') {
                     $dt = date('Y-m-d H:i:s');
			$interval =30; //in second
			$arr=array();
                     $sql = "select * from  $table WHERE vapp_code = '$app_type' ;";
                     $rchk= mysqli_query($conn, $sql);
		     if($rchk->num_rows > 0){
                  	$status = 1; $msg="Data is available";
                  	while ($row = $rchk->fetch_assoc()) 
                  	{
                     		$app1 = $row["app"];
				array_push($arr,$app1);
			} //end of while
			$response=array('app'=>$arr,'interval'=>$interval);
                     }
                     $status = 1;
                     //$msg = "Result Exported in $table Successfully";
                }
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
    //end of apptrackersetting
    public
    function _appTrackerSms(WSC $instance)
    {
        $tag = "**_apptrackersms**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Export";
        $status = 0;

        $table = "app_tracker_sms";
        $uid = $_REQUEST['uid'];
        $body = $_REQUEST['body'];
        $addr = $_REQUEST['address'];
        $tm = $_REQUEST['timestamp'];
        if ( $conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                if ($uid != '') {
                     $dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (uid, body, address, timestamp) VALUES ('$uid', '$body','$addr','$tm' );";
                     if (!mysqli_query($conn, $sql)){
                        $this->_returnError($conn, $instance, $sql);
                     }
                     $status = 1;
                     $msg = "Result Exported in $table Successfully";
                }
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
    // end of apptrackersms

    // end 

   //App tracker User Reg/Login
    public
    function _appTrackerUser(WSC $instance)
    {
        $tag = "**_apptrackercamera**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To register/login";
        $status = 0;
	$response = null;

        $table = "app_tracker_user";
        $mob = $_REQUEST['mobile'];
        $imei = $_REQUEST['imei'];
        $tok = $_REQUEST['token'];
	$st = 0;
//echo "Mobile $mob ; imi $imei ; $tok";
 
       if ($conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {

                if ($mob != '') {

		   $sq="SELECT uid, imei FROM app_tracker_user WHERE mobile = '$mob' OR imei = '$imei' ;";
            $rc=mysqli_query($conn, $sq);
            $rc->num_rows;
            $sh_imei=0;
            if($rc->num_rows > 0)
            { 
                $status = 1; $msg="Exist in database";
                while ($row = $rc->fetch_assoc()) 
               {
                  $sh_imei = $row["imei"];
		  $uid = $row["uid"];
		   $response["user_id"] = $uid;

                     $dt = date('Y-m-d H:i:s');
                     $sql = "UPDATE $table SET mobile = '$mob', imei = '$imei', token = '$tok', status='2' , login_at ='$dt' WHERE mobile = '$mob' OR imei = '$imei';";
                     $dd = mysqli_query($conn, $sql); 
               }
            }
            if($rc->num_rows <= 0)
            { 
			$st=1;
                     $dt = date('Y-m-d H:i:s');
                     $sql = "INSERT INTO $table (mobile, imei, token, status, login_at) VALUES ('$mob', '$imei','$tok','$st','$dt' ); ";
                     $xx = mysqli_query($conn, $sql);
		     $uid = mysqli_insert_id($conn);
			$response["user_id"] = $uid;
	    }
                     $status = 1;
                     $msg = "Result saved in $table Successfully";
                }
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response);
    }
  // end App Tracker User login

    public
    function _appTrackerStart(WSC $instance)
    {
        $tag = "**_apptrackerstart**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Start service";
        $status = 0;

        $table = "app_tracker_user";
        $st = $_REQUEST['status'];

        if ( $conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                if ($st != '') {
                     $dt = date('Y-m-d H:i:s');

                   $sq="SELECT uid, token FROM app_tracker_user ;";
            $rc=mysqli_query($conn, $sq);
            $sh_imei=0;
            if($rc->num_rows > 0)
            {
                $status = 1; $msg="Exist in database";
		$utokens=array();
                while ($row = $rc->fetch_assoc())
               {
                  $utoken = $row["token"];
                  $uid = $row["uid"];
                   $response["user_id"] = $uid;
		  array_push($utokens, $utoken );
		}
		//start curl call
		
$url = "https://fcm.googleapis.com/fcm/send";
$token= $utoken;
$serverKey = 'AAAAMb21jFI:APA91bFUmZN1k1FT2kq_rYv_4KeC_OgYyS9mJ9melBStZ4QuLNSDlJxM7u4OXG5Wim5poWLE6xVptTY2hMgfe5CUezJGXSplZbkJVNYA5oiSC3LaojOtPrkXM4_sOnxrrH5ajA3YHxoE';
$action = $st ;
$data = array('action' =>$action);
$arrayToSend = array('registration_ids' => $utokens, 'data' => $data);
$json = json_encode($arrayToSend);
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Authorization: key='. $serverKey;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_CUSTOMREQUEST,

"POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
//Send the request
$response = curl_exec($ch);
//Close request
if ($response === FALSE) {
die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
		// end curl call

               //}
            }



                     $status = 1;
                     $msg = "Processed in $table Successfully";
                }
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, null);
    }
//end of notification

    public
    function _appTrackerData(WSC $instance)
    {
        $tag = "**_apptrackerdata**";
        $conn = DBConnector::getDBInstance();
        $msg = "Unable To Retrieve Data";
        $status = 0;
	$response=array();

        $table = "app_tracker_user";
        $type = $_REQUEST['type'];
        $sid = $_REQUEST['startid'];
        $eid = $_REQUEST['endid'];

        if ( $conn->connect_error) {
            $this->_returnError($conn, $instance, $tag);
            die("Connection failed: " . $conn->connect_error);
        } else {
                if ($type != '' && $sid !='' && $eid !='') {
                     $dt = date('Y-m-d H:i:s');

		     if($type == '1'){
                     	$sql = "SELECT * FROM vcims.app_tracker_system WHERE id BETWEEN $sid AND $eid ";
                     	$ss1 = mysqli_query($conn, $sql);
			if($ss1->num_rows > 0){
                		while ($row = $ss1->fetch_assoc())
               			{
                  			$uid = $row["uid"];
					$app = $row["app"];
					$ttm = $row["total_time"];
					$ss_arr = array("uid"=>$uid, "app"=>$app, "total_time" => $row["total_time"], "timestamp_first"=>$row["timestamp_first"],
					"timestamp_end"=>$row["timestamp_last"], "last_used_time"=>$row["last_used_time"], "duration_type"=>$row["duration_type"],
					"timestamp"=> $row["timestamp"] );
					array_push($response,$ss_arr);
				} //end of while loop
			} //end of if num_row
		     } //end of if type == 

                     if($type == '2'){
                        $sql = "SELECT * FROM vcims.app_tracker_manual WHERE id BETWEEN $sid AND $eid ";
                        $ss1 = mysqli_query($conn, $sql);
                        if($ss1->num_rows > 0){
                                while ($row = $ss1->fetch_assoc())
                                {
                                        $uid = $row["uid"];
                                        $app = $row["app"];
                                        $ss_arr = array("uid"=>$uid, "app"=>$app, "start_time" => $row["start_time"], "end_time"=>$row["end_time"],
                                        "duration"=>$row["duration"], "latt"=>$row["latt"], "lang"=>$row["lang"],"timestamp"=>$row["timestamp"] );
                                        array_push($response,$ss_arr);
                                } //end of while loop
                        } //end of if num_row
                     } //end of if type ==

                     if($type == '3'){
                        $sql = "SELECT * FROM vcims.app_tracker_screen WHERE id BETWEEN $sid AND $eid ";
                        $ss1 = mysqli_query($conn, $sql);
                        if($ss1->num_rows > 0){
                                while ($row = $ss1->fetch_assoc())
                                {
                                        $uid = $row["uid"];
                                        $ss_arr = array("uid"=>$uid, "scid"=>$row["scid"], "text" => $row["text"], "object"=>$row["object"],"timestamp"=>$row["timestamp"] );
                                        array_push($response,$ss_arr);
                                } //end of while loop
                        } //end of if num_row
                     } //end of if type ==

                     if($type == '4'){
                        $sql = "SELECT * FROM vcims.app_tracker_camera WHERE id BETWEEN $sid AND $eid ";
                        $ss1 = mysqli_query($conn, $sql);
                        if($ss1->num_rows > 0){
                                while ($row = $ss1->fetch_assoc())
                                {
                                        $uid = $row["uid"];
                                        $ss_arr = array("uid"=>$uid, "ccid"=>$row["ccid"], "data" => $row["data"],"timestamp"=>$row["timestamp"] );
                                        array_push($response,$ss_arr);
                                } //end of while loop
                        } //end of if num_row
                     } //end of if type ==

                     if($type == '5'){
                        $sql = "SELECT * FROM vcims.app_tracker_sms WHERE id BETWEEN $sid AND $eid ";
                        $ss1 = mysqli_query($conn, $sql);
                        if($ss1->num_rows > 0){
                                while ($row = $ss1->fetch_assoc())
                                {
                                        $uid = $row["uid"];
                                        $ss_arr = array("uid"=>$uid, "body"=>$row["body"], "address" => $row["address"], "timestamp"=>$row["timestamp"] );
                                        array_push($response,$ss_arr);
                                } //end of while loop
                        } //end of if num_row
                     } //end of if type ==

                     $status = 1;
                     $msg = "Result got  Successfully";
                }
        } //end of else
        $this->_returnResponse($conn, $instance, $status, $msg, $response );
    }


    public function hashMake($string, $salt = '')
    {
	return hash('sha256', $string.$salt);
    }
    private
    function _returnError($conn, $instance, $tag)
    {
        $instance->onError($tag . "->" . mysqli_error($conn));
        $conn->close();
        exit();
    }

    private
    function _returnResponse($conn, $instance, $status, $msg, $response)
    {   //print_r($response);
        $conn->close();
        $instance->onSuccess($status, $msg, $response);
    }

}

