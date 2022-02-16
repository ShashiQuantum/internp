<?php
define("STATUS", "status");
define("MSG", "msg");
define("RESPONSE", "response");
define("DEFAULT_MSG", "Something Wrong! Please Try Later.");
define("DEFAULT_STATUS", "0");

class Api extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('MApi');
		date_default_timezone_set('Asia/Kolkata');
    }

    function index()
    {
		$this->load->model('MApi');
		//$this->load->view('v_test');
		echo 'Hello';
    }

    function hashMake($string, $salt = '')
    {
	return hash('sha256', $string.$salt);
    }
/*
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
*/

    function returnResponse($status, $msg, $response)
    {
        $jsonResponse = array(STATUS => $status, MSG => $msg, RESPONSE => $response);
        echo json_encode($jsonResponse);
    }

    function onError($error)
    {
        $this->returnResponse(DEFAULT_STATUS, $error, null);
    }

    function onSuccess($status, $msg, $response)
    {
        $this->returnResponse($status, $msg, $response);
    }

    //get routine details based on project ids
    function getRoutineDetails()
    {
        if (!isset($_REQUEST['pid']))
            $this->returnResponse(0, "Ids not Found", null);
        else
            $this->model->_getRoutineDetails($this);
    }

   //------------------------------- Start Api below -----------------------------------------------------------------------------------------

    function test()
    {
	$status=0; $msg='test'; $response='onSuccess';
	$this->onSuccess($status, $msg, $response);
    }

    //send vaarta Invite to Video call join by SMS OR EMAIL
    function vaarta_send_invite()
    {
        $response = array();
        $msg="Not a valid code!";
        $status=0;
        $msg = $_POST['msg'];
        $user_data = stripslashes($_POST['contacts']); //data to be inserted at registration time

        //$userdata=json_encode($user_data);
        $usrdata = json_decode($user_data);
        //$usrdata = json_encode($userdata);
        //echo " user: ";
                //print_r($usrdata); //return;
        $mobiles=''; $emails=''; $list='';
            foreach ($usrdata as $djson) {
                foreach ($djson as $key => $val) {
			//echo "$key , val: $val";
                       if($key == "mobile")
                                $mobiles .= $val.",";
                        if($key == "email")
                                $emails .= $val.",";
                }
            }
	$mobiles=substr($mobiles,0,-1);
        $emails=substr($emails,0,-1);
	//echo "List : $mobiles , $emails ";
        $dt = date('Y-m-d H:i:s');
	//echo "mob: $mobiles";
        if($mobiles != '')
        {
		$api_key = '45EECD10AED09D';
		//$contacts = '97656XXXXX,98012XXXXX';
		$contacts = $mobiles;
		$from = 'DMOSMS';
		//$from = 'MANGOP';
		$mesg = urlencode( $msg );
		$api_url = "https://sms.hitechsms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$mesg;
		//Submit to server
		$response = file_get_contents( $api_url);
			//echo $response;
		$status = 1;
	}
        if($emails != '')
        {
		/*
			$email = $emails;
			$remail="admin@vaartacall.com";
		  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: admin@vaartacall.com' . "\r\n" .'Reply-To: $remail';

			$s="VAARTACALL - Video Call Join Link";
			$fs= mail($email, $s, nl2br($msg), $headers);
		*/
			//echo "emails: $email , MSG: $msg";
			$this->load->library('email');
			$config = array();
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://smtpout.asia.secureserver.net';
			$config['smtp_user'] = 'piyush.ranjan@digiadmin.quantumcs.com';
			$config['smtp_pass'] = 'piyush';
			$config['smtp_port'] = 465;
			$this->email->initialize($config);

			$this->email->set_newline("\r\n");

			$this->email->from('admin@vaartacall.com', 'VaartaCall');
			$this->email->to("$emails");
			$this->email->subject('VaartaCall Invitation Link');
			$this->email->message("$msg");
			
			if ( $this->email->send() )
				$status = 1;

	}

	$this->onSuccess($status, $msg, $response);
    }

    //to check Vaarta meeting ID
    function vaarta_check_meeding_id()
    {
        $response = array();
	$msg="Not a valid code!";
	$status=0;
        //$uid = $_POST['uid'];
        $user_data = stripslashes($_POST['data']); //data to be inserted at registration time

        //$userdata=json_encode($user_data);
        $usrdata = json_decode($user_data);
        //$usrdata = json_encode($userdata);
        //echo " user: ";
                //print_r($usrdata); //return;
        $code=''; $token=''; $room_id='';
            foreach ($usrdata as $djson) {
                foreach ($djson as $key => $val) {

                        if($key == "code")
                                $code = $val;
                }
            }
        $dt = date('Y-m-d H:i:s');
        if($code != '')
        {
                $this->load->model('MApi');
                $sql = "select * from vcimsdev.vaarta_users where room_id = '$code';";
                $ds = $this->MApi->getDataBySql($sql);
                //$img_list=array();
                if($ds)
                {
                    foreach($ds as $d){
                        //$mobile = $d->login_mobile;
                        //array_push($response, $mobile);
                         $xx = array("room_id"=>$d->room_id);
                        array_push($response, $xx);
                    }
                        $msg="Code is found!";
                        $status=1;
                }
                else
                {
                        $msg="Code is not found!";
                        $status=0;

		}

	}
               $this->onSuccess($status, $msg, $response);
    }
    //to register / login vaarta user
    function vaarta_user_reg()
    {
        $response = array();
        //$uid = $_POST['uid'];
        $user_data = stripslashes($_POST['data']); //data to be inserted at registration time

	//$userdata=json_encode($user_data);
	$usrdata = json_decode($user_data);
	//$usrdata = json_encode($userdata);
	//echo " user: ";
		//print_r($usrdata); //return;
	$uid=''; $mobile=''; $fullmobile=''; $ccode='';$token='';$name='';$created_at='';$last_login='';$room_id='';
            foreach ($usrdata as $djson) {
                foreach ($djson as $key => $val) {
                    	if($key == "mobile")
                   		$fullmobile = $val;
              		if($key == "token")
                   		$token=$val;
                        if($key == "uid")
                                $uid=$val;
                        if($key == "created_at")
                                $created_at=$val;
                        if($key == "last_login")
                                $last_login=$val;
                        if($key == "name")
                                $name=$val;

		}
            }
	$dt = date('Y-m-d H:i:s');
	if($created_at == 'undefined' || $created_at == '') $created_at=$dt;
        if($last_login == 'undefined' || $last_login == '') $last_login=$dt;

        $mobile=substr($fullmobile, -10);
        $ccode=substr($fullmobile, 0,2);
        $room_id=$mobile;

       	//echo "uid: $uid , fullmobile: $fullmobile, ccode: $ccode, mobile: $mobile, name: $name, created_at: $created_at, last_login: $last_login";
        if($uid != '')
        {
                $this->load->model('MApi');
                $sql = "select * from vcimsdev.vaarta_users where uid='$uid';";
                $ds = $this->MApi->getDataBySql($sql);
                //$img_list=array();
                if($ds)
		{
                    foreach($ds as $d){
                        //$mobile = $d->login_mobile;
                        //array_push($response, $mobile);
			 $xx = array("room_id"=>$d->room_id);
			array_push($response, $xx);
                    }
			$msg="Users is already registered!";
			$status=2;
		}
		else
		{
		     //do the user registration here
			$sql="INSERT INTO vcimsdev.vaarta_users (uid,login_mobile,mobile,login_ccode,full_name,token,room_id,created_at,last_login) VALUES ('$uid','$fullmobile','$mobile','$ccode','$name','$token','$room_id','$created_at','$last_login')";
			$this->MApi->doSqlDML($sql);
                        $msg="User & Room is registered successfully.";
                        $status=1;
		     //end of user registration

		     //begin code for room creation with roomid as his mobile

			$maxp=8;
			$method="POST";
			$url="https://dev.kenante.com/api/janus_api/";
			$data=array("room_id"=> $room_id, "room_name"=> $room_id,"max_publisher"=>$maxp);
			$jsondata = json_encode($data);
			//echo "data : $data";
			$rdd=$this->CallAPI($method, $url, $data);
			//print_r($rdd);

                         $xx = array("room_id"=>$room_id);
                        array_push($response, $xx);

		    //end code for room creation
		}

                //$status=1; $msg='success'; //$response='onSuccess';
                $this->onSuccess($status, $msg, $response);
	}
    }
    //end of vaarta user reg

     function CallAPI($method, $url, $data = false)
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
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array('cache-control' => 'no-cache','content-type' => 'application/x-www-form-urlencoded','payloadtype' => 'json'));
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    	$result = curl_exec($curl);
    	curl_close($curl);

    	return $result;
    }

    //to get the FM Tracking image list based on didi and date of flag 0
    function getfmimglist()
    {
	$response = array();
	$did = $_POST['did'];
	$rdate = $_POST['date']; //date formate should be in YYYYMMDD
	//echo "did: $did , date: $rdate";
	if($did != '')
	{
		$this->load->model('MApi');
		$sql = "SELECT * FROM vcimsweb.camera_image where did=$did AND date(created_at)= date( '$rdate' );";
		$ds = $this->MApi->getDataBySql($sql);
		//$img_list=array();
		if($ds)
		foreach($ds as $d){
			$img = $d->image;
			array_push($response, $img);
		}
		//print_r($ds);

	        $status=1; $msg='success'; //$response='onSuccess';
        	$this->onSuccess($status, $msg, $response);
	}
    }

   //to save the OCR proceesd data of a FM tracking image 
    function savefmimgocrdata()
    {
        $image_name = $_POST['image_name'];

        echo "image : $image_name";
        if($image_name != '')
        {
                $status=0; $msg='test'; $response='onSuccess';
                $this->load->model('MApi');
                $sql = "SELECT * FROM vcimsweb.camera_image where image = '$image_name';";
                $ds = $this->MApi->getDataBySql($sql);
                //$img_list=array();
                if($ds)
                foreach($ds as $d){
                        $img = $d->image;
                        array_push($response, $img);
                }
                //print_r($ds);

                $this->onSuccess($status, $msg, $response);

        }
    }

    //video conferencing user login
    function vcuserlogindev()
    {
	$this->load->model('MApi');
        $tag = "**_vcuserlogindev**";
        $msg = "Unable To get vcuserlogin details";
        $status = 0;
        $cdate = date('Y-m-d H:i:s');
		
     	 $response=array();
         $mob=$_REQUEST['login'];
		 $pass=$_REQUEST['password'];
		 //$gcmid=$_REQUEST['gcmid'];
		 //$imei=$_REQUEST['imei'];
		 //echo "log: $mob , pass: $pass";
        if ($mob!='') {

                 $qchk="SELECT  uid as t, login, imei FROM vcimsdev.`vc_user` WHERE mobile='$mob' AND password='$pass'";
                 $rchk=$this->MApi->getDataBySql($qchk);

            if($rchk)
            {
		$status=1;
               foreach ($rchk as $row2)
               {
                   $userid=$row2->t;
                   $response["user_id"] = $userid;

					$login_status = $row2->login;
					$login_imei = $row2->imei;
                    $response["user_id"] = $userid;
                   //$status = 1;
                   $msg="Success";

                          /*  if($login_status==1 && ($login_imei == $imei)){
					$status=1;
			    }
                            if($login_status==1 && ($login_imei != $imei)){
					$status=2; 
					$msg="Already Signed in at diffrent device. Please logout and then signin again.";
			    }
                            if($login_status==0){
					$qq="UPDATE vcimsdev.`vc_user` SET `login`=0, imei='$imei',timestamp='$cdate' WHERE `uid`=$userid;";
                       			$this->MApi->doSqlDML($qq);
					$status=1;
			    //}

				//to start work for GCM
				//$cdate = date('Y-m-d H:i:s'); 
                   		$qchk="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM vcimsdev.`gcm_vcusers` WHERE `user_id`= $userid";
                 		$qqchk=$this->MApi->getDataBySql($qchk);
                 		if($qqchk->num_rows>0)
                 		{         
                       			$qq="UPDATE vcimsdev.`gcm_vcusers` SET `gcm_regid`='$gcmid', created_at='$cdate' WHERE `user_id`=$userid";
                       			$this->MApi->doSqlDML($qq);
                      			$status=1;
                 		}
                 		else
                 		{    
					if($type!=2)
		      			{ 
                 				$qa="SELECT `uid`, `name`, `mobile`, `email` FROM vcimsdev.vc_user_detail WHERE uid=$userid";
                 				$rsq=$this->MApi->getDataBySql($qqq); $qa);
                 				if($rsq->num_rows>0)
                 				{
                 					foreach ($rsq as $row) 
		                			{
		                        		$name = $row->name;
                                        $email = $row->email;
                                        $mob = $row->mobile;		                 
                 						$qqq="INSERT INTO vcimsdev.`gcm_vcusers`(`user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$name','$email','$mob','$cdate')";
                 	 					$this->MApi->doSqlDML($qqq);
                 	 				}
						}
		      			}
					if($type==2)
					{
						$qqq="INSERT INTO vcimsdev.`gcm_vcusers`(`user_id`, `gcm_regid`, `mob`, `created_at`) VALUES ($userid,'$gcmid','$mobile','$cdate')";
                         $this->MApi->doSqlDML($qqq);

					}
                		 	$status=1;
                        		//$msg = "GCM User Registered/updated sucessfully";
                 		}
				//end of GCM work
                             } //end of if of status=0
			*/
               }  
            }
            else
            {
                $status=0; 
                $msg='Incorrect Login/Password';
				$response = null;
	    }

        }
		$this->onSuccess($status, $msg, $response);

    } 
	//end of vcuserlogindev

    //for test vcusertaglistdev
     //video conferencing user list of same tag/room of a uid

    function vcusertaglistdev($uid)
    {
	$this->load->model('MApi');
        $tag = "**_vcusertaglistdev**";
        $msg = "Unable To get vcusertaglistdev details";
        $status = 1;
	$response=array();
        $dt = date('Y-m-d H:i:s');
		//$uid = $_POST['uid'];
        if ($uid) {
     		$response=array(); $model=array(); 

		 $qchk ="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email` FROM vcimsdev.vc_user as a JOIN vcimsdev.vc_rooMUser_map as b ON a.uid=b.uid AND b.uid= $uid AND a.cid=b.cid where b.room IN (SELECT room FROM vcimsdev.vc_room where date(substr(sch_end_time,1,10)) >= current_date() order by id desc);";
                 $rchk=$this->MApi->getDataBySql($qchk);
 
            if($rchk)
            {

              foreach($rchk as $row2) 
               {

			$display_list = array();
			//print_r($row2);
                       $urole = trim($row2->user_type);
			$qbid = trim($row2->uid);
                       //$qbid = trim($row2["qb_id"]);
                       $tag=trim($row2->tags);
			//$cid=trim($row2->cid);

			$tflag=0;
		  	$tqry="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_rooMUser_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=2 order by b.uid;";
                       $tfq=$this->MApi->getDataBySql($tqry);
                       if($tfq)
                       {
				$tflag=1;
				$cnt=0;
				foreach($tfq as $rr)
				{	$cnt++;
					 $uid= trim($rr->uid); //$qbid= trim($rr['qb_id']);
					$dn="M-$cnt";
					$display_list[$uid]=$dn;
				}
                       }
			$tqry="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_rooMUser_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=3 order by b.uid;";
                       $tfq=$this->MApi->getDataBySql($tqry);
                       if($tfq)
                       {
                                $tflag=1;
                                $cnt=0;
                                foreach($tfq as $rr)
                                {       $cnt++;
                                        $uid= trim($rr->uid); //$qbid= trim($rr['qb_id']);
                                        $dn="T-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
			$tqry="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_rooMUser_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=4 order by b.uid;";
                       $tfq=$this->MApi->getDataBySql($tqry);
                       if($tfq)
                       {
                                $tflag=1;
                                $cnt=0;
                                foreach($tfq as $rr)
                                {       $cnt++;
                                        $uid= trim($rr->uid); //$qbid= trim($rr['qb_id']);
                                        $dn="C-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=1 order by qb_id;";

			$tqry="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_rooMUser_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=1 order by b.uid;";
                       $tfq=$this->MApi->getDataBySql($tqry);
                       if($tfq)
                       {
                                $tflag=1;
                                $cnt=0;
                                foreach($tfq as $rr)
                                {       $cnt++;
                                        $uid= trim($rr->uid); //$qbid= trim($rr['qb_id']);
                                        $dn="R-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=0 order by qb_id;";
		       $tqry="select a.uid,a.user_type,b.qb_id from vcimsdev.vc_rooMUser_map as a JOIN vcimsdev.vc_user as b ON a.uid=b.uid WHERE a.room='$tag' AND a.user_type=0 order by b.uid;";
                       $tfq=$this->MApi->getDataBySql($tqry);
                       if($tfq)
                       {
                                $tflag=1;
                                $cnt=0;
                                foreach( $tfq as $rr)
                                {       $cnt++;
                                        $uid= trim($rr->uid); //$qbid= trim($rr['qb_id']);
                                        $dn="Admin-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }
                        //$tqry="select * from vc_user_detail WHERE tags='$tag' AND user_type=10 order by qb_id;";

			$tqry = "SELECT a.`uid`, b.room, b.user_type, a.qb_id, b.cid FROM vcimsdev.vc_user as a JOIN vcimsdev.vc_rooMUser_map as b ON a.uid=b.uid where b.room ='$tag' AND b.user_type=10 order by a.qb_id;";

                       $tfq=$this->MApi->getDataBySql($tqry);
                       if($tfq)
                       {
                                $tflag=1;
                                $cnt=0;
                                foreach($tfq as $rr)
                                {       $cnt++;
					$uid= trim($rr->$id);
                                        //$qbid= trim($rr['qb_id']);
                                        $dn="T-Adm-$cnt";
                                        $display_list[$uid]=$dn;
                                }
                       }

			//echo "tag: "; print_r($display_list);
                       $arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;

		       $qry="SELECT a.`uid`, b.room as tags, b.user_type, a.`qb_id`,a.`password` as qb_password,a.`name`,a.`mobile`,a.`email`, b.cid FROM vcimsdev.vc_user as a JOIN vcimsdev.vc_rooMUser_map as b ON a.uid=b.uid where b.room ='$tag' AND b.room!='' order by b.user_type;";
                       $rch=$this->MApi->getDataBySql($qry);
                       if($rch)
                       {
                          foreach ($rch as $row) 
                          {
				$utype = trim($row->user_type);
                              $qb_id = trim($row->qb_id);
                              $tag = trim($row->tags);
			      $cuid= trim($row->uid);
			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				//$qrr="select * from vc_room where id='$tag' OR room = '$tag'  AND date(substr(sch_end_time,1,10)) >= current_date();";
				$qrr="select * from vcimsdev.vc_room where id='$tag' OR room = '$tag';";
				$qdd=$this->MApi->getDataBySql($qrr);
				//echo $qdd->num_rows ;
				if($qdd){
				 foreach($qdd as $rw){
					$cnf_id= trim($rw->id);
					$cnf_st_dt = trim($rw->sch_start_dt);
					$cnf_st_tm = trim($rw->sch_start_time);
					$cnf_end_tm = trim($rw->sch_end_time);
					$cnf_tz = trim($rw->timezone);
					$cnf_room = trim($rw->room);
			                $cnf_gen = trim($rw->gender);
                    			$cnf_age = trim($rw->age);
                    			$cnf_sec = trim($rw->sec);
                    			$cnf_usrship = trim($rw->usership);
					$rt= trim($rw->room_type);
					$ssf= trim($rw->ss_flag);
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
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($cuid));
                                }
                                //chat
                                if($utype == 2 || $utype == 3){
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
                                if($utype == 3 || $utype == 2 || $utype == 1){
                                        array_push($arr_hear, trim($cuid));
                                }

                                //chat
                                if($utype == 2 || $utype == 3){
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
			$uid=$row->uid;

                  $r = array("uid" => trim($row->uid), "user_type" => trim($row->user_type),"lu_password" => trim($row->qb_password),"login" => trim($row->mobile), "name" => trim($row->name), "dname" => trim($display_list[$uid]), "email" => trim($row->email), "tags" => trim($row->tags), "created_at" => '', "last_sign_in" => 0,"audio_codec" => "opus", "video_code" => "vp8", "recording" => false,"recording_dir"=>"na","bitrate" => "128000");
                  array_push($response,$r);
                          } //end of FOREACH loop

				$arr_talk = array_unique($arr_talk);
				$m = array("see" => $arr_see, "hear" => $arr_hear, "talk" => $arr_talk, "chat" => $arr_chat,"self_video_off"=>$self_v_off,"self_audio_off"=>$self_a_off, "room_schedule"=>$room_arr );
				array_push($model,$m);
                       }

                   $status = 1;
                   $msg="Success";
               }
		//END OF TOP FOREACH
            }
            else
            {
		//$status=0; $msg='User ID is Not Valid';
		//$status=1; $model='Room details not found';

		//-------- begin of else for check use details -----
				$qchqq="select  distinct `uid`,`user_type`,`qb_id`,`qb_password`,`name`,`mobile`,`email`,`tags`  from vcimsdev.`vc_user_detail` WHERE `uid`=$uid  AND tags !='' limit 1";
				//$qchqq="SELECT a.uid,a.mobile,a.password as qb_password,a.name, a.qb_id,a.email, b.user_type, b.id, b.uid, b.room FROM vc_user as a JOIN  vc_rooMUser_map as b ON a.uid=b.uid AND b.room ='$tag'";
				$rchkd=$this->MApi->getDataBySql($qchqq);
            	if($rchkd)
            	{
				$arr_see=array(); $arr_hear=array(); $arr_talk=array(); $arr_chat=array();$self_v_off=0;$self_a_off=0;

               		foreach ($rchkd as $row) 
               		{
				$display_list = array();

	            		$urole = trim($row->user_type);
        	    		$qbid = trim($row->qb_id);
                		$tag=trim($row->tags);
				//$cid=trim($row->cid);

                  		$r = array("uid" => trim($row->id), "user_type" => trim($row->user_type), "qb_id" => trim($row->qb_id),"qb_password" => trim($row->qb_password),"login" => trim($row->mobile), "name" => trim($row->name), "dname" => trim('NA'), "email" => trim($row->email), "tags" => trim($row->tags), "created_at" => "", "last_sign_in" => 0,"audio_codec" => "opus", "video_code" => "vp8", "recording" => false,"recording_dir"=>"na","bitrate" => "128000" );
                  		array_push($response,$r);

			      $rt=1;
                              $room_arr=array('room'=>0,'timezone'=>0,'sch_start_date'=>0,'sch_start_time'=>0,'sch_end_time'=>0);
				$qrr="select * from vcimsdev.vc_room where id='$tag' OR room = '$tag';";
				$qdd=$this->MApi->getDataBySql($qrr);
				if($qdd){
				   foreach($qdd as $rw){
					$cnf_id= trim($rw->id);
					$cnf_st_dt = trim($rw->sch_start_dt);
					$cnf_st_tm = trim($rw->sch_start_time);
					$cnf_end_tm = trim($rw->sch_end_time);
					$cnf_tz = trim($rw->timezone);
					$cnf_room = trim($rw->room);
                    			$cnf_gen = trim($rw->gender);
                    			$cnf_age = trim($rw->age);
                    			$cnf_sec = trim($rw->sec);
                    			$cnf_usrship = trim($rw->usership);
					$rt= trim($rw->room_type);
					$ssf= trim($rw->ss_flag);
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
        $this->onSuccess($status, $msg, $response);
    }
	//END OF USERTAGLISTDEV




} //end of class Api
?>
