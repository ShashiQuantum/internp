<?php
header('Access-Control-Allow-Origin: *');
class Message extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('MApi');
        $this->load->library('session');
                date_default_timezone_set('Asia/Kolkata');
    }

    function index()
    {
                $this->load->model('MApi');
                $this->load->view('v_test');
                //echo 'Hello';
    }

    function privacypolicy()
    {
        $this->load->view('termpolicy');
    }

    function dashboard()
    {
                $this->load->model('MApi');
                $this->load->view('v_msgdashboard');
    }
    function dashboard_create()
    {
                $this->load->model('MApi');
                $this->load->view('v_msgdashboard_create');
    }
    function dashboard_edit()
    {
                $this->load->model('MApi');
        	$qsql= "select * from `vcimsdev`.`autoreply_questionset` order by pid desc";
        	$ds = $this->MApi->getDataBySql($qsql);
		$data['projects']=$ds;
                $this->load->view('v_msgdashboard_edit',$data);
    }
    function dashboard_report()
    {
                $this->load->model('MApi');
                $qsql= "select * from `vcimsdev`.`autoreply_questionset` order by pid desc";
                $ds = $this->MApi->getDataBySql($qsql);
                $data['projects']=$ds;
                $this->load->view('v_msgdashboard_report',$data);
    }
    function automsgreport()
    {
	$this->load->model('MApi');
	$pid = $_POST['pid'];
        $qsql= "select * from `vcimsdev`.`msglog` where pid = $pid order by sender,sid asc";
        $ds = $this->MApi->getDataBySql($qsql);
	if($ds)
	{
		$strd = '<table border=1 cellspacing=0 cellpadding=0><thead><tr><td>PID</td><td>SENDER</td> <td>SID</td> <td>MESSAGE RECEIVED</td><td>DATETIME</td> </tr> </thead><tbody>';
		foreach($ds as $d){
			$strd .="<tr><td> $d->pid </td><td> $d->sender </td> <td> $d->sid </td> <td> $d->msg </td><td> $d->send_date </td> </tr>";
		}
		$strd.='</tbody></table>';
		echo $strd;
	}
	else
	{
		echo "No data found!";
	}
    }
    function savemsgupdate()
    {
        $flag =0;
        $cnt =  $_POST['qcnt'];
        $pid = strtolower($_POST['pid']);
        //var_dump( $_POST['data'] );
        //$jdata =  stripslashes( $_POST['data'] ) ;
        $jdata = json_decode( $_POST['data'] )  ;
        $jedata = json_encode($jdata);
        $jedata = stripslashes($jedata);
        //print_r( $jedata);
        //echo $jdata;
        $dt = date('Y-m-d H:i:s');

        //TO check project name existence
        $qsql= "select * from `vcimsdev`.`autoreply_questionset` WHERE pid= $pid ;";
        $ds = $this->MApi->getDataBySql($qsql);
        if($ds){
                $flag=1;
                //echo $flag; die();
                $surl = "https://digiadmin.quantumcs.com/digiamin-web/message/arq/$pid";
                $usql ="UPDATE `vcimsdev`.`autoreply_questionset` SET qcnt=$cnt, data='$jedata', server_url= '$surl', updated_at='$dt' WHERE pid='$pid'";
                $id = $this->MApi->doSqlDML($usql);
                $flag = 1;
                echo $flag;

        }
        else
        {
                $flag = 0;
                echo $flag;
	}

    }

    function savemsg()
    {
            
	$flag =0;
	$cnt =  $_POST['qcount'];
        $prj = strtolower($_POST['prj']);
	$jdata = json_decode( $_POST['data'] );

        $arr_asso_data = json_decode( $_POST['data'],true);
        $totl_row =count($arr_asso_data);
       
       
	$jedata = json_encode($jdata);
	$jedata = stripslashes($jedata);
	
	$dt = date('Y-m-d H:i:s');

	//TO check project name existence
	$qsql= "select * from `vcimsdev`.`autoreply_questionset` WHERE title = '$prj';";
        $ds = $this->MApi->getDataBySql($qsql);
	if($ds){
		$flag=0;
		echo $flag; die();
	}
	else
	{
	$st=1;
		//to inser data in table
        $isql = "INSERT INTO `vcimsdev`.`autoreply_questionset` (`title`,`qcnt`,`data`,`created_at`,`status`) VALUES ('$prj',$cnt,'$jedata','$dt',1);";
        $idd = $this->MApi->doSqlDML($isql);
		//end of insert

        // $sqlmaxid = "select max(pid) from `vcimsdev`.`autoreply_questionset`";
        // $pid = $this->MApi->getDataBySql($sqlmaxid);  
        // if($pid){
        //         foreach($pid as $dp){
        //                 $pid=$dp->pid;
        //         }
        // }

        $qsql2= "select * from `vcimsdev`.`autoreply_questionset` WHERE title = '$prj';";
        $ds2 = $this->MApi->getDataBySql($qsql);
        if($ds2){
                foreach($ds2 as $dp){
                        $pid=$dp->pid;
                }
        }
        
        for($i=0;$i<$totl_row; $i++)
{      
	$pqid=  $arr_asso_data[$i]['pqid'];
	$tv=  $arr_asso_data[$i]['tv'];
	$qid=  $arr_asso_data[$i]['sq'];
	$mt=  $arr_asso_data[$i]['mt'];
	$ov=  $arr_asso_data[$i]['op'];
	$qst=  $arr_asso_data[$i]['msg'];
	
        if($pqid=='')$pqid=0;
                $isql = "INSERT INTO `vcimsdev`.`pro_ques_set` (`pid`,`pqid`,`tv`,`qsid`,`mt`,`opval`,`question`) VALUES ('$pid','$pqid','$tv','$qid','$mt','$ov','$qst');";
                $this->MApi->doSqlDML($isql);
}

	       

		$surl = "https://digiadmin.quantumcs.com/digiamin-web/message/arq/$pid";
		$usql ="UPDATE `vcimsdev`.`autoreply_questionset` SET server_url= '$surl' WHERE pid=$pid";
		$id = $this->MApi->doSqlDML($usql);
		$flag = 1;
		echo $flag;
	}
	//end of check project name exist
    }

    function whatsapp()
    {
	$html ="<h3> Demo : to send message using whatsapp!</h3>";
	$html .= "<form action='sendwhsmsg' method=post>";
	$html .= "<input type=text name=to placeholder='Enter mobile without + and start with 91'> <br><textarea name=text placeholder='Enter message here'></textarea>";
	$html .= "<br><input type=submit value=Send>";
	$html .= "<br> <a href='https://api.whatsapp.com/send?phone=918178738251&text=Hi_from_test'> Test</a>";
	echo $html;
    }
    function sendwhsmsg()
    {
	$to=$_POST['to'];
	$msg=$_POST['text'];
	$url = "https://api.whatsapp.com/send?phone=$to&text=$msg";
	redirect($url);
	print_r($_POST);
    }

    function autoreplya()
    {
        $msg = strtolower($_POST['message']);
        $app = strtolower($_POST['app']);
        $sender = strtolower($_POST['sender']);

        $sql = "select * from vcimsdev.msglog where sender = '$sender' AND msg = '$msg';";
        $ds = $this->MApi->getDataBySql($sql);
                //$img_list=array();
        if($ds)
        {
              $reply = array("reply"=>"It seems you have replied already this message. Thank you!");
              echo json_encode($reply);
        }
        else
        {
                $dt = date('Y-m-d H:i:s');
                if( $msg == 'yes' ){
                        $reply = array("reply"=>"Where do you live currently? Reply with AP for Arunachal Pradesh, OS for Others");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }

                else if( $msg == 'ap' || $msg == 'os' ){
                        $reply = array("reply"=>"What is your Gender? Reply with M for male and F for female");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }

                else if($msg == 'm'  || $msg == 'f' ){
                        $reply = array("reply"=>"Choose your age group. Reply with A1 if less than 18 years, A2 if 18-24 years, A3 if 25-45 years, A4 if more than 45 years");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'a1' || $msg == 'a2' || $msg == 'a3' || $msg == 'a4'){
                        $reply = array("reply"=>"Did you drink any Cold Drinks, i.e. Pepsi, Thums Up, Coca Cola, Sprite, Mirinda, etc. in the last 3 months? Please reply with Y for Yes and N for No");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }

                else if( $msg == 'y' ){
                        $reply = array("reply"=>"Which Cold Drinks did you have in the last 3 months? Reply with PE for Pepsi, CO for coca cola, TU for Thums Up, SP for Sprite, MD for Mountain Dew, MI for Mirinda, OT for other brands. You can reply with multiple brands by putting a comma between brand names");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'pe' || $msg == 'dw' || $msg == 'md' || $msg == 'co' || $msg == 'tu' || $msg == 'sp' || $msg == 'mi' || $msg == 'ot' || strstr($msg,'dw')  || strstr($msg,'pe')  || strstr($msg,'md')  || strstr($msg,'co') || strstr($msg,'tu') || strstr($msg,'sp') || strstr($msg,'mi') || strstr($msg,'ot') ){
                        $reply = array("reply"=>"What is your favourite Cold drinks? Reply with PS for Pepsi, CL for coca cola, UP for Thums Up, ST for Sprite, MD for Mountain Dew, MI for Mirinda, OTS for other brands");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'ps' ){
                        $reply = array("reply"=>"How Often Do you drink Pepsi? Reply with F1 for Everyday, F2 for 3-6 times a week, F3 for 1-2 times a week, F4 for Once in 2-3 Weeks, F5 for Once a month, F6 for less often");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'cl' ){
                        $reply = array("reply"=>"How Often Do you drink Coca Cola? Reply with F1 for Everyday, F2 for 3-6 times a week, F3 for 1-2 times a week, F4 for Once in 2-3 Weeks, F5 for Once a month, F6 for less often");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'up' ){
                        $reply = array("reply"=>"How Often Do you drink Coca Cola? Reply with F1 for Everyday, F2 for 3-6 times a week, F3 for 1-2 times a week, F4 for Once in 2-3 Weeks, F5 for Once a month, F6 for less often");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'f1' || $msg == 'f2' || $msg == 'f3' || $msg == 'f4' || $msg == 'f5' || $msg == 'f6' || $msg == 'st' || $msg == 'md'){
                        $reply = array("reply"=>"Where All do you Drink this Cold Drinks? You can reply with multiple replies separated by a comma (,). Reply with C for College/ School Canteen, O for Office canteen, D for drinking at the Shop, H for drinking at Home, O for drinking at other places");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'c' || $msg == 'o' || $msg == 'd' || $msg =='h' || $msg =='n' ){
                        $reply = array("reply"=>"Thanks for you response. Would you like to participate in future surveys? For the next surveys you will get assured gifts like Talktime, Paytm Recharges, Amazon/ Flipkart Coupons, etc. Please reply with OK if you would like to participate or NI for Not INterested");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'ok' ){
                        $reply = array("reply"=>"Thanks for your interest. Please save this Number in your Contact as MP1. This will allow us to send you WhatsApp surveys to you on the future.");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else if( $msg == 'ni' ){
                        $reply = array("reply"=>"Thanks for replying. Have a pleasant day ahead");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }
                else {
                        $reply = array("reply"=>"Invalid Response, Please check and send the correct reply.");
                        echo json_encode($reply);

                        $sql = "insert into vcimsdev.msglog (msg, app, sender, at) VALUES ('$msg', '$app', '$sender', '')";
                        $this->MApi->doSqlDML($sql);
                }


	}
    }

    function autoreply($pid=null)
    {
	if($pid == 'null' || $pid == ''){
		echo 'Error! Invalid URL attempted!'; return;
	}
        $msg = trim(strtolower($_POST['message']));
        $app = strtolower($_POST['app']);
        $sender = strtolower($_POST['sender']);
	//$msg="yes";
	//$sender='demo1';
	$msg =sprintf($msg);

	//echo "PID : $pid <br>"; //die();
	$qcount=0;
	$qdata='';
        //TO check project name existence
        $qsql= "select * from `vcimsdev`.`autoreply_questionset` WHERE pid = $pid;";
        $ds = $this->MApi->getDataBySql($qsql);
        if($ds){
		foreach($ds as $d){
                        $qdata = $d->data;
                        $qcount = $d->qcnt;
		}
                //echo "cnt: $qcount, qdata: $qdata";
		$qarr = json_decode($qdata);

		//to check the last response of a sender for this project and return the max sequence id
		$max_sq = 0;
		$qdsql = "select max(sid) as mx from vcimsdev.msglog where sender = '$sender' AND pid = $pid";
		$qds = $this->MApi->getDataBySql($qdsql);
		if($qds)
		{
	                foreach($qds as $qd){
        	                $max_sq = $qd->mx != ''?$qd->mx: 0;
                	}

		}
		$nsq = $max_sq + 1;
		if($nsq > $qcount)
		{
			//echo "No more questions to reply. Thanks!";
              		$reply = array("reply"=>"It seems you have replied already this message. Thank you!");
              		echo json_encode($reply);
			return;
		}
		//echo "<br> max sq: $max_sq <br>";
		//get question/message details
		foreach($qarr as $ar){
			$qsq = $ar->sq;
			$qmt = $ar->mt;
			$qop = strtolower($ar->op);
			$qmsg = $ar->msg;

			//echo "<br> sq: $qsq, mt: $qmt, OP: $qop, MSG: $qmsg";
			$arr_op = explode(",",$qop);
			//print_r($arr_op);
			//set option flag 0 for not matched else 1
			$op_flag =0;
                        if( $qsq == $nsq && $qmt == '1' )
                        {
			    foreach($arr_op as $op){
				$op = trim(sprintf($op));
				//echo "<br> OP is : $op , MSG : $msg <br> cpm: ";
				//echo strcmp($op,$msg) ;
				if( strcmp($msg,$op) == 0){
					$op_flag=1;
                                	//echo "<br> $msg , MT: $qmt";
              				$reply = array("reply"=>$qmsg );
              				echo json_encode($reply);
					// do msg insert in msglog table here
                        		$sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $qsq)";
                        		$this->MApi->doSqlDML($sql);
                                	break;
				}
			    }
			    if($op_flag == 0){
                                 $reply = array("reply"=>"Invalid Response, Please check and send the correct reply." );
                                 echo json_encode($reply);
				 //echo "Incorrect response!";
				 return;
			    }
                        }
			if( $qsq == $nsq && $qmt == '2' )
			{
                            foreach($arr_op as $op){
                                $op = trim(sprintf($op));
                                //echo "<br> OP is : $op , MSG : $msg";
                                if(strstr($msg, $op)){
                                        $op_flag=1;
                                        //echo "<br> $qmsg , MT: $qmt";
                                        $reply = array("reply"=>$qmsg );
                                        echo json_encode($reply);
                                        // do msg insert in msglog table here
                                        $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $qsq)";
                                        $this->MApi->doSqlDML($sql);
                                        break;
                                }
                            }
                            if($op_flag == 0){
                                 $reply = array("reply"=>"Invalid Response, Please check and send the correct reply." );
                                 echo json_encode($reply);
                                 //echo "Incorrect response!";
                                 return;
                            }

			}
		}

        }
        else
        {
                $reply = array("reply"=>"Invalid pid is requested in URL." );
                echo json_encode($reply);
		//echo "Invalid id is passed in URL!"; 
		return;
	}

    }

    function arq($pid) {
       
        // CHECKING VALID URL PARAMETER
       if($pid == 'null' || $pid == ''){
            echo 'Error! Invalid URL attempted!'; return;
        }

        // CHECKING THE QUESTION SET EXIST OR NOT IN DATABASE.
        $qsql= "select max(id) as mxval from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid';";
        $ds = $this->MApi->getDataBySql($qsql);
       if($ds['0']->mxval < 1) {
            echo 'Error! Invalid URL attempted !!!!'; return;
       }
      
       // TAKING INPUT FROM THE USERS
        $msg = trim(strtolower($this->input->post('message')));
        $app = $this->input->post('app');
        $sender = $this->input->post('sender');
        $currTime = time();
        $todayDate = date("Y-m-d");

        $qsql= "select * from `vcimsdev`.`msglog` WHERE sender = '$sender' AND send_date = '$todayDate' AND at <= '$currTime' AND id =(select max(id) from `vcimsdev`.`msglog` WHERE sender = '$sender' AND send_date = '$todayDate' AND at <= '$currTime' )  ";
      
        $ds1 = $this->MApi->getDataBySql($qsql);
        if($ds1)
        {
               
                $pqid = $ds1['0']->pqid; 
                $opval =$ds1['0']->opval; 
               

                                if($opval == ''){
                                        $reply = array("reply"=>'Thanks for your valuable feedback!');
                                        echo json_encode($reply);
                                } else{
                                 
                $sequsql= "select * from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid' AND pqid ='$pqid' AND  LOWER(tv) = '$msg' ";
                $qds = $this->MApi->getDataBySql($sequsql);
               

                if($qds){
                $question = $qds['0']->question;
                $pqid     = $qds['0']->qsid;
                $opVal    = $qds['0']->opval; 
                $currTime = time();
                $todayDate = date("Y-m-d");
                $insql = "insert into `vcimsdev`.`msglog` (pid,sid,pqid,app,sender,questions,msg,at,send_date,opval) VALUES ('$pid','0','$pqid','$app','$sender','$question','$msg','$currTime','$todayDate','$opVal')";
                $this->MApi->doSqlDML($insql);
                       
                        $reply = array("reply"=>$question);
                        echo json_encode($reply);

                }else{
                        $reply = array("reply"=>'We not recognise your message ! Please enter correct Message!');
                        echo json_encode($reply);

                }

                                   }
               

        }
        //SELECTING FIRST QUESTION 
        else{
               
               $seqsql= "select * from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid' and pqid = '0' and (tv like '%hi' or tv like '%hello' or tv like '%hello')";
               $ds1 = $this->MApi->getDataBySql($seqsql);  
               if($ds1){
               $firstQest = $ds1['0']->question;
               $pqid = $ds1['0']->qsid;
               $opVal = $ds1['0']->opval;
               $expTime = time() + 900;
               $todayDate = date("Y-m-d");
               $insql = "insert into `vcimsdev`.`msglog` (pid,sid,pqid,app,sender,questions,msg,at,send_date,opval) VALUES ('$pid','0','$pqid','$app','$sender','$firstQest','$msg','$currTime','$todayDate','$opVal')";
               $this->MApi->doSqlDML($insql);
               $reply = array("reply"=>$firstQest);
               echo json_encode($reply);
               }

        }
        
} //END THE API 




////////////////////////////////////////////////////////////////////////////////////////////

//  ***************************************//
// NEW API DEVELOPED BY SHASHI SESSION BASED
// function arq($pid) {
       
//             // CHECKING VALID URL PARAMETER
//            if($pid == 'null' || $pid == ''){
//                 echo 'Error! Invalid URL attempted!'; return;
//             }

//             // CHECKING THE QUESTION SET EXIST OR NOT IN DATABASE.
//             $qsql= "select max(id) as mxval from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid';";
//             $ds = $this->MApi->getDataBySql($qsql);
//            if($ds['0']->mxval < 1) {
//                 echo 'Error! Invalid URL attempted !!!!'; return;
//            }
//            // TAKING INPUT FROM THE USERS
//             $msg = trim(strtolower($this->input->post('message')));
//             $app = $this->input->post('app');
//             $sender = $this->input->post('sender');
//             $this->session->unset_userdata('ENdQ');
//           // $this->session->unset_userdata('sessUserId');
//  if(!$this->session->userdata('sessUserId')) {
        
        
//                 $qsql= "select max(id) as mx from`vcimsdev`.`user_session_tab`";
//                 $maxId = $this->MApi->getDataBySql($qsql);
//         $maxSessId =  $maxId['0']->mx; 
//         $maxSessId++;
//         $this->session->set_userdata('sessUserId', $maxSessId); 
//         $userSesId =$this->session->userdata('sessUserId');
//                 $sql = "insert into `vcimsdev`.`user_session_tab` (qset_no) VALUES ('$pid')";
//                 $sessds= $this->MApi->doSqlDML($sql);
                             

//             // PREPARE FOR FIRST QUESTION SETTING AND ASKING
//             $qsql= "select * from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid' AND pqid ='0' AND  tv like '%$msg%'";
//             $ds1 = $this->MApi->getDataBySql($qsql);
            
//             if($ds1){
                    
//             $firstQest = $ds1['0']->question;
//             $pqid = $ds1['0']->qsid;
//             $this->session->set_userdata('pqId', $pqid);
             
//             //PRINT FIRST QUESTION FOR THE USER AFTER CHEKING THE FIRST TRIGGER VALUES 
//                 $reply = array("reply"=>$firstQest );
//                 echo json_encode($reply);
//                  $this->session->set_userdata('ENdQ', 'NOTEND');   
        
//             // INSERT THE USER DATA INTO THE TABLE FOR THE REPORT GENRATION 
//         $sql = "insert into `vcimsdev`.`msglog` (pid,sid,app,user_session_id,sender,qid,tv,questions,msg) VALUES ('$pid','0','$app','$userSesId','$sender','$pqid','$msg','$firstQest','')";
//         $this->MApi->doSqlDML($sql);
            
//                 $qCount =1;  

//                  //FIND THE TOTAL NUMBER OF QUESTION IN THE QUESTION SET
//                         $qsql= "select count(*) as totalQest from`vcimsdev`.`pro_ques_set` WHERE pid ='$pid'";
//                         $totQ = $this->MApi->getDataBySql($qsql);
//                         $totalQest = $totQ['0']->totalQest; 
//                         $this->session->set_userdata('totalQset', $totalQest);                   
//             } 
        
//  }  // PRINT FIRST QUESTION SECTION IF IS ENDED HERE. 

//  //FIND THE SECOUND OR NEXT QUESTION 
//         elseif($this->session->userdata('sessUserId')) {
//           $pqId =$this->session->userdata('pqId');
//           $userSesId =$this->session->userdata('sessUserId');
          

//           $updsql = "update `vcimsdev`.`msglog` set msg = '$msg' where qid='$pqId' and user_session_id =$userSesId";
//           $this->MApi->doSqlDML($updsql);

//             //$qsql= "select * from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid' AND pqid ='$pqId' AND  tv like '$msg' ";
//             $qsql= "select * from `vcimsdev`.`pro_ques_set` WHERE pid = '$pid' AND pqid ='$pqId' AND  LOWER(tv) = '$msg' ";
//             $ds2 = $this->MApi->getDataBySql($qsql);
//             if($ds2){
                
//              $pqid =  $ds2['0']->qsid;
//              $this->session->set_userdata('pqId', $pqid); 
//              $nQuestion  =$ds2['0']->question;
//              $reply = array("reply"=>$nQuestion );
//              echo json_encode($reply);
//              $this->session->set_userdata('ENdQ', 'NOTEND'); 
//              $qCount++;

//           $sql = "insert into `vcimsdev`.`msglog` (pid,sid,app,user_session_id,sender,qid,tv,questions,msg) VALUES ('$pid','0','$app','$userSesId','$sender','$pqid','$msg','$nQuestion','')";
//           $this->MApi->doSqlDML($sql);
             
//             }
        
//  }
//         //IF THE MESSAGE IS NOT MATCH THEN SHOW ERROR OR TERMINATE THE AUTO REPLY BY THANK YOU MESSAGE.
      
//         if($this->session->userdata('ENdQ') !='NOTEND' ){
                
//                 if($msg === 'end'){
//                 $replymsg = 'Thanks for your valuable reply!!';
//                 $reply = array("reply"=>$replymsg );
//                 echo json_encode($reply);
//                 $this->session->unset_userdata('sessUserId'); 
//                 }
//                 else {
//                 $replymsg = 'The message which you have type is incorrect please type the correct answer or type the END to terminate';
//                 $reply = array("reply"=>$replymsg );
//                 echo json_encode($reply); 
//                 }
//         }


//         }
           
// *********************************************//

    //for autoreply on whatsapp working with routes condition
  
  
  function arq_old_api($pid){
        if($pid == 'null' || $pid == ''){
            echo 'Error! Invalid URL attempted!'; return;
        }
        $msg = trim(strtolower($_POST['message']));
        $app = strtolower($_POST['app']);
        $sender = strtolower($_POST['sender']);
        $msg =sprintf($msg);
        $qcount=0;
        $qdata='';
        $qsql= "select * from `vcimsdev`.`autoreply_questionset` WHERE pid = $pid;";
        $ds = $this->MApi->getDataBySql($qsql);
        if($ds){
                foreach($ds as $d){
                        $qdata = $d->data;
                        $qcount = $d->qcnt;
                }
                $qarr = json_decode($qdata);
                //to check the last response of a sender for this project and return the max sequence id
                $max_sq = 0; $max_qid=0;
                $qdsql = "select max(sid) as mx, max(qid) as qid from vcimsdev.msglog where sender = '$sender' AND pid = $pid";
                $qds = $this->MApi->getDataBySql($qdsql);
                if($qds)
                {
                        foreach($qds as $qd){
                                $max_sq = $qd->mx != '' ? $qd->mx : 0;
                                $max_qid = $qd->qid != '' ? $qd->qid : -1;
                        }
                }
                $nsq = (int) $max_qid + 1;
                $nnsq = (int) $nsq+1;

                if($max_sq >= $nnsq ){ $nsq = $max_sq; }
                if($nsq > $qcount)
                {
                        $reply = array("reply"=>"It seems you have replied already all messages. Thank you!");
                        echo json_encode($reply);
                        return;
                }
                $q_mt_arr=array();
                $op_nsq_arr = array();
                $q_op_arr = array(); //to store qid as key and its options as value
                //get question/message details
                foreach($qarr as $ar){
                        $pqid = $ar->pqid;
                        $qsq = $ar->sq;
                        $qmt = $ar->mt;
                        $tv = $ar->tv;
                        $qop = strtolower($ar->op);
                        $qmsg = $ar->msg;

                        $arr_tv = explode(",",$tv);
                        $arr_op = explode(",",$qop); 

                        //to store op of nsq+1 question if skiped question to check options 
                        if($qsq == $nsq){
                                $op_nsq_arr=$arr_op;
                        }
                        $rsq=$qsq-1;
                        $arr_pqid = array();
                        if( $pqid != 'undefined' || $pqid != '' ){
                                if( $pqid != '') $arr_pqid = explode(",",$pqid);
                        }
                        $q_op_arr[ $qsq ] = $arr_op;
                        $q_mt_arr[ $qsq ] = $qmt;
                        $pcnt = count($arr_pqid);
                        
                        if($nsq == 0 && $qsq == 1 ){ 	//echo "<br>IN tv: $tv, msg: $msg";
                                if(strstr($tv,$msg)){ //echo "<br> GO $qsq ....";
                                        $reply = array("reply"=>$qmsg );
                                        echo json_encode($reply);
                                        $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq)";
                                        $this->MApi->doSqlDML($sql);
                                        return;
                                }
                        }

                        if($qsq == 1 ) continue;
                        $pval_arr =array();
                        $all_pop = array();
                        if(!empty($arr_pqid) && $qsq > 1){
                                //to get all options of all prev qids for current sid
                                foreach($arr_pqid as $pq){
                                        $pq = trim(sprintf($pq));
                                        $top = $q_op_arr[$pq];
                                        $all_pop = array_merge($all_pop,$top);
                                }
                                //end of pid op find

                                //to find all response values of previous qids of current qsq question for routing match                               
                                $qs = "select msg  from vcimsdev.msglog where sender = '$sender' AND pid = $pid AND qid IN ( $pqid )";
                                $pqs = $this->MApi->getDataBySql($qs);
                                if($pqs)
                                {
                                        foreach($pqs as $q){
                                                $pms = $q->msg;
                                                $ar = explode(',',$pms);
                                                foreach($ar as $a){
                                                        array_push($pval_arr,$a);
                                                }
                                        }
                                        $pval_arr = array_unique($pval_arr);
                                }
                                
                                $pval_arr = array_unique($pval_arr);
                                $pval_str = implode(" ",$pval_arr);
                               
                        } 
                        $all_pop = array_unique($all_pop);
                        $pval_arr = array_unique($pval_arr);        

                        if( $qsq > $nsq )
                        {
                            
                          if( count($arr_pqid) > 0 && $qsq >= $nsq+1 ){
                            if(! empty($arr_tv))
                            foreach($arr_tv as $op){
                                $op = trim(sprintf($op));
                                $pq1 = substr($pqid,0,1);
                                $pqid_mt = $q_mt_arr[$pq1];
                                if($pqid_mt == 1 ){  
                                        if( in_array($op,$pval_arr) || $qsq == $qcount){
                                                $reply = array("reply"=>$qmsg );
                                                echo json_encode($reply);
                                                $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, qid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq,$qsq)";
                                                $this->MApi->doSqlDML($sql);
                                                return;
                                        }
                                }
                                if($pqid_mt == 2 ){  
                                        if( strstr($pval_str,$op) || $qsq == $qcount){
                                                $reply = array("reply"=>$qmsg );
                                                echo json_encode($reply);
                                                $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, qid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq,$qsq)";
                                                $this->MApi->doSqlDML($sql);
                                                return;
                                        }
                                }                                
                            }
                          }
                          else{
                                if( ! in_array($msg,$arr_op)){
                                        $reply = array("reply"=>"Invalid Response, Please check and send the correct reply." );
                                        echo json_encode($reply);
                                        //echo "Incorrect response!";
                                        return;
                                    }
                                    foreach($arr_tv as $op){
                                        $op = trim(sprintf($op));
                                        //chech trigger value among response values of pids
                                        if($qmt == 1 ){        
                                                if( in_array($op,$arr_op)  || $qsq == $qcount ){             
                                                        $reply = array("reply"=>$qmsg );
                                                        echo json_encode($reply);
                                                        // do msg insert in msglog table here
                                                        $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, qid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq, $qsq)";
                                                        $this->MApi->doSqlDML($sql);
                                                        return;
                                                }
                                        }
                                        if($qmt == 2 ){        
                                                if( strstr($qop,$op)  || $qsq == $qcount ){             
                                                        $reply = array("reply"=>$qmsg );
                                                        echo json_encode($reply);
                                                        // do msg insert in msglog table here
                                                        $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, qid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq, $qsq)";
                                                        $this->MApi->doSqlDML($sql);
                                                        return;
                                                }
                                        }
                                    }
                          }
                        }

                } //end of foreach for question arr
        } //end of if pid checking
        else
        {
                $reply = array("reply"=>"Invalid pid is requested in URL." );
                echo json_encode($reply);
                return;
        }
    } //end of function arq method
    

    //for autoreply from whatsauto of whatsapp messages
    function ar($pid)
    {
        if($pid == 'null' || $pid == ''){
                echo 'Error! Invalid URL attempted!'; return;
        }
        //$msg = trim(strtolower($_POST['message']));
        //$app = strtolower($_POST['app']);
        //$sender = strtolower($_POST['sender']);
        $msg="3";
        $sender='1';
	$app='test';

        $msg =sprintf($msg);

        //echo "PID : $pid <br>"; //die();
        $qcount=0;
        $qdata='';
        //TO check project name existence
        $qsql= "select * from `vcimsdev`.`autoreply_questionset` WHERE pid = $pid;";
        $ds = $this->MApi->getDataBySql($qsql);
        if($ds){
                foreach($ds as $d){
                        $qdata = $d->data;
                        $qcount = $d->qcnt;
                }
                //echo "cnt: $qcount, qdata: $qdata";
                $qarr = json_decode($qdata);

                //to check the last response of a sender for this project and return the max sequence id
                $max_sq = 0;
                $qdsql = "select max(sid) as mx from vcimsdev.msglog where sender = '$sender' AND pid = $pid";
                $qds = $this->MApi->getDataBySql($qdsql);
                if($qds)
                {
                        foreach($qds as $qd){
                                $max_sq = $qd->mx != ''?$qd->mx: -1;
                        }
                }
                echo $nsq = $max_sq + 1;
                if($nsq > $qcount)
                {
                        //echo "No more questions to reply. Thanks!";
                        $reply = array("reply"=>"It seems you have replied already all messages. Thank you!");
                        echo json_encode($reply);
                        return;
                }
                //echo "<br> max sq: $max_sq <br>";
		$q_op_arr = array(); //to store qid as key and its options as value
                //get question/message details
                foreach($qarr as $ar){
                        $pqid = $ar->pqid;
                        $qsq = $ar->sq;
                        $qmt = $ar->mt;
                        $tv = $ar->tv;
                        $qop = strtolower($ar->op);
                        $qmsg = $ar->msg;

                        $arr_tv = explode(",",$tv);
                        $arr_op = explode(",",$qop);

			$rsq=$qsq-1;
			$arr_pqid=array();
                        if($pqid != 'undefined' && $qsq > 1){
				$arr_pqid = explode(",",$pqid);
			}
			$q_op_arr[ $qsq ] = $arr_op;
			$pcnt = count($arr_pqid);
			//print_r($q_op_arr);
			//print_r($arr_pqid);

                        //trigger to the start question
                        //echo "<br> START qsq: $qsq , nsq: $nsq ";
                        if($nsq == 0 && $qsq == 1 ){ 	//echo "<br>IN tv: $tv, msg: $msg";
                                if(strstr($tv,$msg)){ //echo "<br> GO $qsq ....";
                                        $reply = array("reply"=>$qmsg );
                                        echo json_encode($reply);
                                        echo $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq)";
                                        $this->MApi->doSqlDML($sql);
                                        return;
                                }
                        }
                        if($nsq == 1 && $qsq == 2 ){    //echo "<br>IN tv: $tv, msg: $msg";
                                if(strstr( $tv, $msg)){  //echo "<br> went $qsq ";
                                        $reply = array("reply"=>$qmsg );
                                        echo json_encode($reply);
                                        echo $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $nsq)";
                                        $this->MApi->doSqlDML($sql);
                                        return;
                                }
                        }
			if($qsq == 1 ) continue;
			else
			{
			//echo "<br> pqid= $pqid , pid cnt : $pcnt "; print_r($q_op_arr);
			 //to get all options of all prev qids for current sid
			 $all_pop = array();
			 if(count($arr_pqid)>0 && $qsq > 1){
				//echo "<br>Begin";
                            	foreach($arr_pqid as $pq){
                              		$pq = trim(sprintf($pq));
					$top = $q_op_arr[$pq];
			      		$all_pop = array_merge($all_pop,$top);
			    	}
				//echo "End<br>";
				//to find all response values of previous qids of current qsq question for routing match
				$pval_arr =array();
		                echo $qs = "select msg  from vcimsdev.msglog where sender = '$sender' AND pid = $pid AND sid IN ( $pqid )";
                		$pqs = $this->MApi->getDataBySql($qs);
                		if($pqs)
                		{
                        		foreach($pqs as $q){
                                		$pms = $q->msg;
						array_push($pval_arr,$pms);
                        		}
					$pval_arr = array_unique($pval_arr);
                		}
				echo "<br> pms: "; print_r($pval_arr);
				//if(empty($pval_arr)) continue;
			 } //end of if
				//print_r($all_pop);

			 //to check for first qid and set op as tv
			 if($qsq == 1 || $pqid == '') array_push($all_pop,$tv);

			 $all_pops = array_unique($all_pop);
                                
                        //print_r($arr_op);
                        //set option flag 0 for not matched else 1
                        $op_flag =0;
                        if( $qsq >= $nsq && $qmt == '1' )
                        {
echo "<br> pqid= $pqid , sq:$qsq, msg: $msg <br> "; print_r($all_pop);

                            if( ! in_array($msg,$all_pop)){
                                 $reply = array("reply"=>"Invalid Response, Please check and send the correct reply." );
                                 echo json_encode($reply);
                                 //echo "Incorrect response!";
                                 return;
                            }
//print_r($arr_tv);
                            foreach($arr_tv as $op){
                            //foreach($pval_arr as $op){
                                $op = trim(sprintf($op));
                               echo "<br> OP is : $op , MSG : $msg <br>";
				print_r($pval_arr);
                               //echo strcmp($msg,$op) ; return;

                                //if( strcmp($msg,$op) == 0){
				//if( $msg == $op){
                                if( in_array($op,$pval_arr) ){
                                        $op_flag=1;
                                        echo "<br> $msg , MT: $qmt";
                                        $reply = array("reply"=>$qmsg );
                                        echo json_encode($reply);
                                        // do msg insert in msglog table here
                                        echo $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $qsq)";
                                        $this->MApi->doSqlDML($sql);
                                        return;
                                }
                            }
			    //continue;
                        }
                        if( $qsq >= $nsq && $qmt == '2' )
                        {
                            if( ! in_array($msg,$all_pop)){
                                 $reply = array("reply"=>"Invalid Response, Please check and send the correct reply." );
                                 echo json_encode($reply);
                                 //echo "Incorrect response!";
                                 return;
                            }

                            foreach($arr_tv as $op){
                            //foreach($pval_arr as $op){
                                $op = trim(sprintf($op));
                                //echo "<br> OP is : $op , MSG : $msg";
                                //if(strstr($msg, $op)){
                                if( in_array($op,$pval_arr) ){
                                        $op_flag=1;
                                        //echo "<br> $qmsg , MT: $qmt";
                                        $reply = array("reply"=>$qmsg );
                                        echo json_encode($reply);
                                        // do msg insert in msglog table here
                                        echo $sql = "insert into vcimsdev.msglog (msg, app, sender, pid, sid) VALUES ('$msg', '', '$sender', $pid, $qsq)";
                                        $this->MApi->doSqlDML($sql);
                                        return;
                                }
                            }
			    
                        }
                }
		}

        }
        else
        {
                $reply = array("reply"=>"Invalid pid is requested in URL." );
                echo json_encode($reply);
                //echo "Invalid id is passed in URL!";
                return;
        }

    }


}
?>
