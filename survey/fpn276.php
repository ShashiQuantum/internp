<?php
include_once('../vcimsweb/init.php');
include_once('survey-function.php');
//session_start();
//print_r($_SESSION);

//session_destroy();
if(!Session::exists('resp'))
{ 	
//echo "Hello";
	$_SESSION['resp']= $_GET['resp']; 
	$_SESSION['qset']= $_GET['qset']; 
	$_SESSION['lang']= $_GET['lang'];  
	$_SESSION['table']= $_GET['table']; 
	if(!Session::exists('sid')) $_SESSION['sid']= $_GET['sid']; 
 	$_SESSION['maxsid']= $_GET['maxsid'];  
	$_SESSION['pqstack']=array();
}
 
 $flag_other=0;
// print_r($_SESSION);
    $table='';$sid=''; $maxsid=0; $qset='';$resp_id='';$pqt='';$lang='none';
	$resp_id=0;$qset=0;$currq=0;$next_qstack=array();
	$qlist = array();
	if(Session::exists('resp'))
	{ 	$resp_id=$_SESSION['resp']; }
	if(Session::exists('qset'))
	{	 $qset=$_SESSION['qset'];}
	if(Session::exists('isdate'))
	{	$isdate=$_SESSION['isdate'];}

	//$_SESSION['lang']='none';
	//$lang='hindi';
	if(Session::exists('lang'))
	{	 $lang=$_SESSION['lang'];}	 
    	if(Session::exists('qstack'))
   	{	$next_qstack=$_SESSION['qstack']; }
	if(Session::exists('table'))
	{	 $table=$_SESSION['table'];}
	if(Session::exists('sid'))
    	{    $sid=$_SESSION['sid']; }         
    	if(Session::exists('pqstack'))
    	{	$tarr=$_SESSION['pqstack'];}
    	if(Session::exists('pqt'))
	{ $pqt=$_SESSION_['pqt'];   }
        if(Session::exists('maxsid'))
        { $maxsid=$_SESSION['maxsid'];   }

//echo "resp=".$_SESSION['resp'];

?>

	<!DOCTYPE html>
	<html lang="en-us">
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	body {background:#fff;font-size:14px;}

	.effect1{
	    -webkit-box-shadow: 0 10px 6px -6px #777;
	       -moz-box-shadow: 0 10px 6px -6px #777;
	            box-shadow: 0 0 5px #888;
	            margin: 5px; text-align:justify;
	            max-width: 1800px;
	            max-height: 270px;
	       //box-shadow: 0 10px 6px -8px #777;
	}
	        input:hover {
                           background-color: #ddd;
                           color: black;
		}
		.previous {
		    background-color: #f1f1f1;
		    color: black;
		}
		.next {
		    background-color: #4CAF50;
		    color: white;
		}
		.round {
		    border-radius: 50%;
		}
	
[class*="col-"] {
    // width: 100%;
   margin-left:0%;
}
@media only screen and (min-width: 768px) {
    /* For desktop: */
    .col-1 {width: 8.33%;}
    .col-2 {width: 16.66%;}
    .col-3 {width: 25%;}
    .col-4 {width: 33.33%;}
    .col-5 {width: 41.66%;}
    .col-6 {width: 50%;}
    .col-7 {width: 58.33%;}
    .col-8 {width: 66.66%;}
    .col-9 {width: 75%;}
    .col-10 {width: 83.33%;}
    .col-11 {width: 91.66%;}
    .col-12 {width: 100%;}
}
@media (min-width:768px)
 {body{background-color:#f2f2f2;font-size:50px;}}

	</style>

<style>
.mtbl{
	background-color:#f2f2f2;
	border:none;
	border-collapse:collapse;
	border-spacing:0;
	width:100%;

}
.tbl_1{
	border:none;
	border-collapse:collapse;
	border-spacing:0;
	max-width:700px;
	width:100%
}
.tbl_1_td{
	background-color: #094041;
	color: #fff;
	text-align: left;
	padding: 5px;

}
.tbl2_td{
	background-color: #094041;
	color: #fff;
	height: 30px;
	text-align: left;
	padding: 2px;
}
.tbl_dcolor{
	background-color: #094041;
	color: #fff; padding: 5px;
}
.tbl_lcolor{
	background-color: #e5e5e5;
	padding: 5px;
}
</style>
<style>
    tr:nth-child(even){background-color: #f2f2f2}</style>
	</head>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="mtbl" bgcolor="#f2f2f2"><tbody><tr><td align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tbl_1">

<tr><td class="tbl_1_td" align="center">

<table border="0" >
<tr>
<td class="tbl2_td" align="center">
<span style="padding: 10px;">
<!--<img src="https://vareniacims.com/siteadmin/public/img/logos/varenia_logo2.png" style="height:100px; width:160px;padding: 15px; ">-->
<img src="http://localhost/quantumdigiadmin/public/img/logos/quantum-logo-big.png" width="80px" height="80px">
</span>
</td>
<td class="tbl2_td" align="center">
<span style="padding: 5px;">
<p> </p>
</span>
</td>
</tr></table>

</td></tr>

<!-- <tr><td style="background-color: #fff; color: #094041; padding: 15px;" align="center"> </td></tr>
-->
<tr><td style="background-color: #fff; color: #094041; padding: 15px;" align="center">

	<body class="col-12">
<table border=0 class="col-12" style="height: 100%;">
<tr style="background-color:white;"><td style="height:3%;width:100%;">
     <div> <!--
                        <span style=float:right;color:#fff; font-size:50px;> <?php  ?> </span>
                        <span style=float:left;><img src='http://vareniacims.com/public/img/logos/varenia_logow.png' height=40px width=100px> </span>
	--> 
    </div>
</td></tr>


 	<form method="post" action="">
	<?php
	if(isset($_POST['submit']))
	{
                    date_default_timezone_set('asia/calcutta');
                    $dt = date('Y/m/d H:i:s');
                    $newURL='';
                    $qqq="UPDATE `respondent_web` SET `status`=2, endtime='$dt' WHERE resp_id = $resp_id AND qset = $qset";
                    DB::getInstance()->query($qqq);
                    $qqa="UPDATE $table SET `st`=2, timestamp='$dt' WHERE resp_id = $resp_id AND q_id = $qset AND r_name !=''";
                    DB::getInstance()->query($qqa);
                    session_destroy();

                    echo $newURL="http://www.vareniacims.com/survey/thanks.php";
                    header('Location: '.$newURL);

	}

	if(isset($_POST) || $sid==0)
	{
			date_default_timezone_set('asia/calcutta');
			$dt = date('Y/m/d H:i:s');
			$cq=0;
			//to next button
			if(isset($_POST['next']) && $sid > 0){
	//echo "<br>next..";
	//print_r($_SESSION['pqstack']);

	      		   if($sid > 0)
	      		   {
				$cq=$_POST['qid'];
				if($pqt != 'first'){
						save_result($_POST,$table,$qset,$resp_id);
				//		array_push($qlist,$qid);
				}
				      $psid = $_SESSION['sptr'];
					 //echo "Saving.. PSID: $psid";
                                    if(Session::exists('pqstack'))
                                    {
					$tarr=array();
                                        $tarr=$_SESSION['pqstack'];
					array_push($tarr,$psid);
					$tarr = array_unique($tarr);
					$_SESSION['pqstack'] = $tarr;
                                    }
				//print_r($_SESSION['pqstack']);
 // $sptr=$_SESSION['sptr'];
 // $ps=$_SESSION['sid'];
//echo "<br>n sid: $ps , sptr: $sptr";
			   } //end of sid > 0
			}
			if(isset($_POST['back'])){
//	echo "<br>back..";
//	print_r($_SESSION['pqstack']);
             	$pqstack=$_SESSION['pqstack']; 
		$sid = array_pop($pqstack);
		$_SESSION['sid']=$sid;
		//$_SESSION['sptr']=$sid+1;
		$_SESSION['pqstack']=$pqstack;
	      //print_r($_SESSION['pqstack']);
  		//$sptr=$_SESSION['sptr'];
  		//$ps=$_SESSION['sid'];
		//echo "<br>b sid: $ps , sptr: $sptr";
			} 

			//if(Session::exists('sid'))   $sid=$_SESSION['sid'];
				  //echo "<br>maxsid:".$maxsid;
			if($sid>$maxsid) $sid=0;

		if($sid>=0 && $sid<=$maxsid)
		{
			$sptr = 1; $nptr = 2;$cqid=0;$cqid_arr_cnt = 0;$eptr=$sptr+$nptr;
				if($sid==0)
				{
						$sptr = 1;
						$_SESSION['sptr']=$sptr;
						//$cqid=ptr_first_question($qset,$sptr,$nptr);
						$cqid_arr=ptr_first_question($qset,$sptr,$nptr);
						$cqid_arr_cnt = count($cqid_arr);
						//echo "cnt: $cqid_arr_cnt <br>";
						//print_r($cqid_arr);
						$_SESSION['cqid_cnt']=$cqid_arr_cnt;
				}
				else
				{
					 if(isset($_POST['next'])){
					 	$sptr = $_SESSION['sid'] + 1;
						
						$eptr=$sptr+$nptr;
						$_SESSION['sptr']=$_SESSION['sid'];
					 }
                                         if(isset($_POST['back'])){
                                                //$sptr = $sid +1;
                                                $sptr = 1 ;
                                                if(count($_SESSION['pqstack'])>0)
						$sptr = $sid +1;

						$eptr=$sptr+$nptr;
						$_SESSION['sptr']=$sid;
                                         }

					$cqid_arr=ptr_first_question($qset,$sptr,$eptr);
					$cqid_arr_cnt = count($cqid_arr);
					//echo " c before: sptr: $sptr, eptr: $eptr , cnt: $cqid_arr_cnt ;";
					if($cqid_arr_cnt == 1){
						//--$sid;
						$pcqid_cnt=$_SESSION['cqid_cnt'];
						if($cqid_arr_cnt > 1) --$sid;
						$_SESSION['sid'] = $sid;
						$cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);
						$cqid_arr = array($cqid);
						//print_r($cqid_arr);
					}
				}

			//for go to submit form
			if($cqid==-1)
			{
					//save_result($_POST,$table,$qset,$resp_id);
						//termination code
						echo "<tr><td><center><font size=5 color='red'>Thanks for your participation in the survey. <br>Please click on submit button to complete the survey.</font></center>";
						  echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center> </td></tr><tr><td>";
						//end termination
			}
			else
			{
	// --to display multiple questions in a page --loop for multiple questions
	if(is_array($cqid_arr))
        $cqid_arr = array_unique($cqid_arr);
//print_r($cqid_arr);
	if(!empty($cqid_arr))
	foreach($cqid_arr as $cqid){

					//$_SESSION['qstack']=$next_qstack;

	//--to check ques having grid rule-3 or not
	if(is_grid_question($cqid)){
		$grp = is_grid_question($cqid);
		$gqids=get_grid_question($qset,$grp);
		$gqids = array_unique($gqids);
		$nctr=0;
		foreach($gqids as $gq){
			if($nctr==0){$nctr++;  continue;}
			array_push($qlist,$gq);
			$nctr++;
		}
//echo "<br>grp: $grp <br>"; 
//print_r($gqids);
//echo $_SESSION['sid'];
		if($gqids != false && is_array($gqids) ){
			$count=count($gqids);
			$arr_temp=array(array());$arr_qt=array();
			$strq= implode(', ',$gqids);

                        $qu2=DB::getInstance()->query("SELECT distinct q_type FROM `question_detail` WHERE `q_id` in ( $strq );");
                        if($qu2->count()>0)
                        {
			    foreach($qu2->results() as $rs){
				$qtype=$rs->q_type;
				array_push($arr_qt,$qtype);
				$qu3=DB::getInstance()->query("SELECT `q_id`, q_title, q_type, qno FROM `question_detail` WHERE `q_id` in ( $strq ) AND q_type = '$qtype' order by q_id;");
                        	if($qu3->count()>0)
                        	{
				   foreach($qu3->results() as $rs2){
                           		$qid=$rs2->q_id; $qtitle=$rs2->q_title;$qtype=$rs2->q_type;$qno=$rs2->qno;
			   		$arr_temp[ $qid ]=array('q_type'=>$qtype,'q_title'=>$qtitle,'qno'=>$qno);
				   }
				}
			   } //END OF FOREACH
			}
//print_r($arr_temp);
			//to show grid questions
			if(count($arr_qt) == 2){
				$iqid = $gqids[0];
				$ititle = $arr_temp[ $iqid ]['q_title'];
				$dd=array();
								if($iqid ==12328) $dd = get_q_response($table,$resp_id,12322);
                                if($iqid ==12674) $dd = get_q_response($table,$resp_id,12670);
                                if($iqid ==12564) $dd = get_q_response($table,$resp_id,12560);
                                if($iqid ==12615) $dd = get_q_response($table,$resp_id,12611);
                                if($iqid ==12726) $dd = get_q_response($table,$resp_id,12722);
                                if($iqid ==12790) $dd = get_q_response($table,$resp_id,12786);
                                if($iqid ==12856) $dd = get_q_response($table,$resp_id,12844);
                                if($iqid ==12871) $dd = get_q_response($table,$resp_id,12855);
                                if($iqid ==12880) $dd = get_q_response($table,$resp_id,12863);
								
						// =================================== Question Title Show Hide ===================================================================================================================================//	
						if($iqid == 12564 || $iqid == 12674 || $iqid == 12564 || $iqid == 12615 || $iqid == 12726 || $iqid == 12790 || $iqid == 12856 || $iqid == 12871 || $iqid == 12880 || $iqid==12328 AND count($dd)>1)
						{
							echo "<tr><td style='padding:30px;'> $ititle </td></tr>";
						}
						
						if($iqid != 12564 AND $iqid != 12674 AND $iqid != 12564 AND $iqid != 12615 AND $iqid != 12726 AND $iqid != 12790 AND $iqid != 12856 AND $iqid != 12871 AND $iqid != 12880 AND $iqid!=12328)
						{
							echo "<tr><td style='padding:30px;'> $ititle </td></tr>";
						}
						// =============================== // ============================================================================================================================================================ //
						
				//echo "<tr><td style='padding:30px;'> $ititle </td></tr>";

				if($arr_qt[1] == 'dropdown'){
				    if($qset == 213)
				    {
					$dd = get_q_response($table,$resp_id,12322);
					//print_r($dd);
					$arr_pq=array();
					foreach($dd as $di){
					    if(count($dd)>1)
					    if($iqid == 12328){
						if( $di == 1){$q=12329; array_push($arr_pq,$q);}
						if( $di == 2){$q=12330; array_push($arr_pq,$q);}
						if( $di == 3){$q=12331; array_push($arr_pq,$q);}
						if( $di == 4){$q=12332; array_push($arr_pq,$q);}
					     }
					     if($iqid == 12448){
						$arr_pq=array(12449,12450,12451,12452); break;
					     }
					}
				     } //end of if qset

					//print_r($arr_pq);
					//$gqs = array_intersect($gqids,$arr_pq);
					echo "<table ID='myDiv'  style='padding-left:40px;  width:100%;'>";
				  for($i=0; $i < count($arr_pq); $i++){
					//$qid= $gqids[ $i ];
					$qid= $arr_pq[ $i ];
					$rspd = get_q_response($table,$resp_id,$qid);
					$str='';
                                                if(!empty($rspd)){
                                                   $str= $rspd[0];
                                                }
					$error=$qid.'e';
					$qtle=$arr_temp[ $qid ]['q_title'];
					//echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> </td><td><select class='big' name=q$qid id=q$qid><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select></td></tr>";
					echo "<tr>
                                                            <td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error' style='font-size: 12px;'></span></font></td>
                                                            <td>
                                                            <input type='text' name=text$qid id=op_$qid class='txtCalc' placeholder='0' value='$str' required>
                                                            </td>
                                                            </tr>
                                         ";
				  }

				  // ========================================================== Total Sum area show hide ================================================================================= //
				  if($iqid == 12564 || $iqid == 12674 || $iqid == 12564 || $iqid == 12615 || $iqid == 12726 || $iqid == 12790 || $iqid == 12856 || $iqid == 12871 || $iqid == 12880 || $iqid==12328 AND count($dd)>1)
				  {
                     			echo "<tr><td><font color=blue> Sum: <span id='total_sum_value'>0</span> </font><br><span id='msg'></span></td></tr>";
				  }
				  if($iqid != 12564 AND $iqid != 12674 AND $iqid != 12564 AND $iqid != 12615 AND $iqid != 12726 AND $iqid != 12790 AND $iqid != 12856 AND $iqid != 12871 AND $iqid != 12880 AND $iqid!=12328)
				  {
					 echo "<tr><td><font color=blue> Sum: <span id='total_sum_value'>0</span> </font><br><span id='msg'></span></td></tr>";
				  }
				  // ========================================= // ======================================================================================================================================================= //		  

				    echo "</table>";
			}

                    	      if($arr_qt[1] == 'radio'){
					$arr_qo=array(array());
					$qid= $gqids[ 1 ];
					$arr_qo = get_qop($qid,'opt_text_value');
					$arr_qo_val = get_qop($qid,'value');
					//print_r($arr_qo);
                                        echo "<table border='1' cellpadding=1 cellspacing=1 style='padding:10px;width:100%;'><tr><td style='background-color: gray; text-color: #fff;'> </td>";
					foreach($arr_qo as $qo){
						echo "<td style='background-color: gray; text-color: #fff; font-size: 12px;' align='center'> $qo  </td>";
					}
					echo "</tr>";
                                  for($i=1; $i < count($gqids); $i++){
                                        $qid= $gqids[ $i ];
					//to get REPONDENT qop detail

					$rspd = get_q_response($table,$resp_id,$qid);

					//if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
					$error=$qid.'e';
                                        echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error' style='font-size: 12px;'></span></font></td>";
					
					$r=0;
					foreach($arr_qo_val as $ov){
						$r++;
						$rd = '_'.$r;
						$str='';
						if(!empty($rspd)){
                                                	if(in_array($ov,$rspd)) $str=" checked='checked'";
	                                        }
						echo "<td style='background-color: #f2f2f2' align='center'><input type='radio' class='big r_$qid$rd' id=q$qid name=q$qid $str value=$ov></td>";
					}
					echo "</tr>";
                                  }
                                    echo "</table>";
                                } //end of radio type

                              if($arr_qt[1] == 'checkbox'){
                                        $arr_qo=array(array());
                                        $qid= $gqids[ 1 ];
                                        $arr_qo = get_qop($qid,'opt_text_value');
                                        $arr_qo_val = get_qop($qid,'value');
                                        //print_r($arr_qo);
                                        echo "<table border='1' cellpadding=0 cellspacing=0 style='padding:10px;width:100%;'><tr><td> </td>";
                                        foreach($arr_qo as $qo){
                                                echo "<td style='background-color: #f2f2f2'> $qo  </td>";
                                        }
                                        echo "</tr>";
                                  for($i=1; $i < count($gqids); $i++){
                                        $qid= $gqids[ $i ];
                                        //to get REPONDENT qop detail

                                        $rspd = get_q_response($table,$resp_id,$qid);

                                        //if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
                                        $error=$qid.'e';
                                        echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error' style='font-size: 12px;'></span></font></td>";

                                        foreach($arr_qo_val as $ov){
                                                $str='';
                                                if(!empty($rspd)){
                                                        if(in_array($ov,$rspd)) $str=" checked='checked'";
                                                }
						$aa='q'.$qid.'[]';
                                                echo "<td style='background-color: #f2f2f2' align='center'><input type='checkbox' class='big' id=q$qid name=$aa $str value=$ov></td>";
                                        }
                                        echo "</tr>";
                                  }
                                    echo "</table>";
                                } //end of checkbox type

                              if($arr_qt[1] == 'rating'){
                                        $arr_qo=array(array());
                                        $qid= $gqids[ 1 ];
                                        $arr_qo = get_qop($qid,'opt_text_value');
                                        $arr_qo_val = get_qop($qid,'value');
                                        //print_r($arr_qo);
                                        echo "<table border='1' cellpadding=0 cellspacing=0 style='padding:30px;width:100%;'><tr><td> </td>";
                                        foreach($arr_qo as $qo){
                                                echo "<td style='background-color:lightgray'> $qo  </td>";
                                        }
                                        echo "</tr>";
                                  for($i=1; $i < count($gqids); $i++){
                                        $qid= $gqids[ $i ];
                                        //to get REPONDENT qop detail

                                        $rspd = get_q_response($table,$resp_id,$qid);

                                        //if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
                                        $error=$qid.'e';
                                        echo "<tr><td style='font-size: 12px;'>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td>";

                                        foreach($arr_qo_val as $ov){
                                                $str='';
                                                if(!empty($rspd)){
                                                        if(in_array($ov,$rspd)) $str=" checked='checked'";
                                                }
                                                echo "<td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid $str value=$ov></td>";
                                        }
                                        echo "</tr>";
                                  }
                                    echo "</table>";
                                } //end of rating type


			} //end of qtype count 1
                        if(count($arr_qt) == 3){
                                        $arr_qo=array(array());
                                        $iqid= $gqids[ 0 ];
                                        $rqid= $gqids[ 2 ];
                                        $chqid= $gqids[ 1 ];
					$cerror=$chqid.'e';
					$rerror=$rqid.'e';
					$ititle=$arr_temp[ $iqid ]['q_title'];
                                        $arr_qo = get_qop($rqid,'opt_text_value');
                                        $arr_qo_val = get_qop($rqid,'value');
					
					$textA='SELECT ALL THAT APPLICABLE(A)';
                                        $textB='MOST PREFERED (B)';
					if($iqid == 12357){
						$textA='APPs OFFER VFM (A)';
						$textB='BEST VFM APP (B)';
					}
					if($qset == 219){
					    if($iqid == 12713){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
					}
                                        if($qset == 217){
                                            if($iqid == 12592){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }
                                        if($qset == 220){
                                            if($iqid == 13018){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }
                                        if($qset == 221){
                                            if($iqid == 13033){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }

                                        if($qset == 218){
                                            if($iqid == 12658){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }
                                        if($qset == 222){
                                            if($iqid == 12992){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }
                                        if($qset == 223){
                                            if($iqid == 12949){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }
                                        if($qset == 224){
                                            if($iqid == 12994){
                                                $textA='APPs OFFER VFM (A)';
                                                $textB='BEST VFM APP (B)';
                                            }
                                        }

					echo "<tr><td style='padding:30px;'> $ititle </td></tr>";
                                        echo "<table border='1' cellspacing=0 cellpadding=0 style='padding-left:20px;'style='padding:30px;width:100%''><tr><td></td><td style='background-color:lightgray; font-size: 12px;'> $textA <input type=hidden name='qid[]' value=$chqid ><font color=red><span id='$cerror'></span></font> </td> <td style='background-color:lightgray;font-size: 12px; '> $textB <input type=hidden name='qid[]' value=$rqid ><font color=red><span id='$rerror'></span></font> </td> </tr>";
										$i=0;
										$c=0;
										$r=0;
										$v=0;
					$rspd1 = get_q_response($table,$resp_id,$chqid);
					$rspd2 = get_q_response($table,$resp_id,$rqid);
                                        foreach($arr_qo as $qo)
					{
						$v++;
						$r++;
                                        	$val = $arr_qo_val[ $i ];
						$aa='q'.$chqid.'[]';
                                                $str1='';
                                                if(!empty($rspd1)){
                                                        if(in_array($val,$rspd1)) $str1=" checked='checked'";
                                                }

                                                $str2='';
                                                if(!empty($rspd2)){
                                                        if(in_array($val,$rspd2)) $str2=" checked='checked'";
                                                }

						echo "<tr><td> $qo </td><td style='background-color:lightgray'><input type='checkbox' class='big' id='c$v' name=$aa value=$val $str1 onchange='changeThis(this)'> </td> 
						<td style='background-color:lightgray'><input type='radio' class='big' id='r$r' name=q$rqid value=$val required $str2 disabled> </td><tr>";
						$i++; 
                        		}
	                                echo "</table>";

                        } //end of qtype count 3

		}

	} //end of grid questions to show else continue
	else{
				$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno,image FROM `question_detail` WHERE `q_id`=$cqid");
				if($ques->count()>0)
				{ 
					$qid=$ques->first()->q_id;
					$qtitle=$ques->first()->q_title;
					$qtype=$ques->first()->q_type;
					$qno=$ques->first()->qno;
					$qimg=$ques->first()->image;
							 $error=$qid.'e';
							 $_SESSION_['pqt']=$qtype;

							//to check find replace rule for question title
							$fcqid='';
							$fop='';
							$qqr="SELECT qset, cqid, op_val, fstr, rstr, rqid FROM vcims.question_word_findreplace where qset= $qset and rqid=$cqid limit 1";
							$qfd=DB::getInstance()->query($qqr);
							if($qfd->count()>0){
								$fcqid=$qfd->first()->cqid;
								$tt=$fcqid.'_'.$qset;
								$qqr2="select $tt as vv from $table WHERE resp_id = $resp_id AND $tt !='' limit 1;";
					                        $qfd2=DB::getInstance()->query($qqr2);
                                                        	if($qfd2->count()>0){
									 $fop=$qfd2->first()->vv;
									 $qqr3="SELECT * FROM vcims.question_word_findreplace where qset = $qset AND rqid=$cqid AND cqid=$fcqid AND op_val = $fop;";
									 $qfd3=DB::getInstance()->query($qqr3);
	                                                                if($qfd3->count()>0){
                                                                		$fw=$qfd3->first()->fstr;
                                                                		$rw=$qfd3->first()->rstr;
										$qtitle = str_replace($fw,$rw,$qtitle);
									}
								}
							}
							//end of find replace rule
						      echo "</td></tr><tr><td style='height:30%;background-color:white;width:100%;padding:30px;'>";
                                                      echo "<div class=effect16>";
						      if($lang == 'none'){
							 //echo "<p style='font-size:10px;'>$qid / $qno</p><p>$qtitle</p>";
							 echo "<p style='font-size:10px;'> $qno </p> <p>$qtitle</p> <font color=red><span id='$error' style='font-size: 12px;'></span></font></div>";
							if($qimg != '') echo "<img src='http://vareniacims.com/$qimg ' height=350 width=550>";
						      }
						      else if($lang == '1'){
                                            			$rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                            			if($rs22->count()>0)
                                            			{
                                                			$qtitle_1=$rs22->first()->q_title;
									echo "<p style='font-size:10px;'>$qid / $qno</p><p> $qtitle <br>[ $qtitle_1 ]</p><font color=red><span id='$error' style='font-size: 12px;'></span></font></div>";
						      		}
								else echo "<tr><td><p style='font-size:10px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error' style='font-size: 12px;'></span></font></div>";
						      }
						echo "</td></tr> <tr><td style='height:60%; background-color:lightgray;'>";
						if($qtype=='radio')
						{
							$qterm='';$strval=''; $show_qids=''; $flag_show = 0;
							//to check showop only rule
							//echo "is_show_rule($cqid)";
							$isshow=is_show_rule($cqid); //print_r($isshow);

							if($isshow != 0){
								$flag_show = 1;
								$show_resp = get_resp_pqid_value($resp_id, $table, trim($isshow) );
								$show_qids=implode(', ',$show_resp);
							}
							//end of showop rule
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$cqid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $strval=$rss2->first()->$qterm;}
							else $strval="";

							//for language options
							$lfag=0;$larr=array();
							$qlop=DB::getInstance()->query("select opt_text_value, code from hindi_question_option_detail where q_id=$cqid order by code;");
							if($qlop->count()>0)
							{
								$lflag=1;
								foreach($qlop->results() as $op){
									$code=$op->code; $opt=$op->opt_text_value;
									$larr["$code"]=$opt;
								}

							}
							// end for language option
							  $sq = "SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid";
							if($cqid == 12334 || $cqid == 12570 || $cqid == 12661 || $cqid == 12716 || $cqid == 12779 || $cqid == 12827 || $cqid == 12999 || $cqid == 12956 || $cqid == 12998)
							{
								$sq = "SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid order by rand();";
							}
							  if($flag_show == 1){
								$sq = "SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid AND value IN ( $show_qids );";
							  }
							  $flag_show = 0; $isshow=false;
							  $qop=DB::getInstance()->query($sq);
							  if($qop->count()>0)
							  {  echo "<table> <input type=hidden name='qid[]' value=$qid>";
								  foreach($qop->results() as $ov)
								  {   $str=''; 
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value;
									  if($strval==$value) $str=" checked='checked'";

									//for word find and replace rule
                                                                       /*  $qrq="SELECT * FROM vcims.question_word_findreplace where qset = $qset AND rqid=$cqid AND cqid=$fcqid AND op_val = $fop;";
                                                                         $qrfd=DB::getInstance()->query($qrq);
                                                                        if($qrfd->count()>0){
										foreach($qrfd->results() as $dr){
                                                                                	$fwop=$dr->fstr;
                                                                                	$rwop=$dr->rstr;
											if (strpos($opt, $fwop) !== false) {
                                                                                		$opt = str_replace($fwop,$rwop,$opt);
											}
										}
                                                                        }
									*/
									//end of rule
									if($lang == 'none'){
										echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt </td></tr>";

									}
									else if($lang == '1'){
										if (!empty($larr)) 
											echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt [ $larr[$value]  ]</td></tr>";
										else
											echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt </td></tr>";

									}
								  }
								 echo "</table>";
							  } 
					   }
					   
					    if($qtype=='checkbox')
						{    
							$qterm='';$arr_temp=array(); 
						/*	$show_qids=''; $flag_show = 0;
                                                        //to check showop only rule
                                                        $isshow=is_show_rule($cqid);
                                                        if(isshow != false){
                                                                $flag_show = 1;
                                                                $show_resp = get_resp_pqid_value($resp_id, $table, trim($isshow) );
                                                                $show_qids=implode(', ',$show_resp);
                                                        }
                                                        //end of showop rule
						*/
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{
								foreach($rss2->results() as $r)
								{
									$strval=$r->$qterm;
									array_push($arr_temp, $strval);
								}
							}

							//for language options
							$lfag=0;$larr=array();
							$qlop=DB::getInstance()->query("select opt_text_value, code from hindi_question_option_detail where q_id=$qid order by code;");
							if($qlop->count()>0)
							{
								$lflag=1;
								foreach($qlop->results() as $op){
									$code=$op->code; $opt=$op->opt_text_value;
									$larr["$code"]=$opt;
								}

							}
							// end for language option
							$flag_other=0;  $other_arr=array(array());
						       $sqop="SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid";
						       if($cqid == 12321 || $cqid == 12322 || $cqid == 12337 || $cqid == 12339 || $cqid == 12559 || $cqid == 12560 || $cqid == 12573 ||$cqid == 12574 || $cqid == 12610 || $cqid == 12611 || $cqid == 12628 || $cqid == 12630 || $cqid == 12666 || $cqid == 12670 || $cqid == 12687 || $cqid == 12689 || $cqid == 12718 || $cqid == 12722 || $cqid == 12742 || $cqid == 12744 || $cqid == 12782 || $cqid == 12786 || $cqid == 12803 || $cqid == 12805 || $cqid == 12840 || $cqid == 12844 || $cqid == 12891 || $cqid == 12900 || $cqid == 12847 || $cqid == 12855 || $cqid == 12896 || $cqid == 12899 || $cqid == 13003 || $cqid == 12863 || $cqid == 12915 || $cqid == 12924)
						       $sqop="SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid order by rand();";
							$qop=DB::getInstance()->query($sqop);
							if($qop->count()>0)
							{  	echo "<table><input type=hidden name='qid[]' value=$qid>";
								$i =0;
								foreach($qop->results() as $ov)
								{ 
									$i++;
									$j = '_'.$i;
									$str='';
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value;
									   if(in_array($value,$arr_temp)) $str=" checked ";

									   if($opt == 'Other Please Specify'){
										$flag_other=1;
										$other_arr=array($opt,$value);
										//continue;
									   }
									 // if(in_array($value,$arr_temp))
									  //{ 
										//	$str="checked='checked'";
									  //}
									if($lang == 'none'){
										
										// =========================== //
										$flag = is_opflag($qid, $value);
										// =========================== //
										
										$aa='q'.$qid.'[]'; //$aa='q'.$qid.'[]';
									 	//echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$aa' $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt <hr> </td></tr>";
										
																				
										echo "<tr height=40><td></td><td width=2%><input type='$qtype' data-id=q$qid$j class='q$qid$j big' id=q$qid name='$aa' $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt ";
										
										
										// show if click on other Invest option
										if($qid==17560 and $value==14)
										{
											$otvalue="";
											$sqlm="SELECT  17648_276 FROM $table WHERE resp_id=$resp_id AND 17648_276!= ''";
											$rss2m=DB::getInstance()->query($sqlm);
											if($rss2m->count()>0) 
											{
												$t = '17648_276';
												foreach($rss2m->results() as $r)
												{
													$otvalue = $r->$t;
												}
											}
											echo "<input type='text' id='other_14' name='q17648' class='sch' placeholder='Specify here' value='$otvalue' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
										}
										
										if($qid==17562 and $value==7)
										{
											$otvalue="";
											$sqlm="SELECT  17651_276 FROM $table WHERE resp_id=$resp_id AND 17651_276!= ''";
											$rss2m=DB::getInstance()->query($sqlm);
											if($rss2m->count()>0) 
											{
												$t = '17651_276';
												foreach($rss2m->results() as $r)
												{
													$otvalue = $r->$t;
												}
											}
											
											echo "<input type='text' id='other_7' name='q17651' class='sch' value='$otvalue' placeholder='Specify here' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
										}
										
										echo " </td></tr>";
									}
									else if($lang == '1'){
										$aa='q'.$qid.'[]';
										if (!empty($larr)){
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=$aa $str value='$value'></td><td> $opt [ $larr[$value]  ]</td></tr>";
										}
										else{
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=$aa $str value='$value'></td><td> $opt</td></tr>";
										}
									}
								}
								if($flag_other == 91){
									$str='';
									$tx=$other_arr[0];
									$tv=$other_arr[1];
                                                                          if(in_array($tv,$arr_temp))
                                                                          {
                                                                                        $str="checked='checked'";
                                                                          }
										$aa='q'.$qid.'[]'; //$aa='q'.$qid.'[]';
									 	echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$aa' $str value='$tv'></td><td style='border-bottom: 1px solid #ff;'> $tx  </td></tr>";

								}

								echo "</table>";
							} 
						}
					   
					   if($qtype=='rating')
						{    
								
							  $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
							  if($qop->count()>0)
							  {  echo "<table><input type=hidden name=qid value=$qid>";
								  foreach($qop->results() as $ov)
								  {
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $sv=$ov->scale_start_value; $ev=$ov->scale_end_value;
									  $arr_temp=array();$str='';$strval='';
								$strval = -1;
								$sql="SELECT  $term FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $term!=''";
								$rss2=DB::getInstance()->query($sql);
								if($rss2->count()>0) 
								{ $strval=$rss2->first()->$term;}
								else $strval=-1;
									/*
									  if($sv==0)
									{
										echo "<table style=border:none><tr><td> </td>";
										for($s=$sv+1;$s<=$ev;$s++)
										{
											echo "<td> $s </td>";
										}
										echo "<td> </td><td>NA</td></tr><tr><td> $sl </td>";
										for($s=$sv+1;$s<=$ev;$s++)
										{   
											if($strval==$s)
											{ 
												$str="checked='checked'";
											}else $str='';
											echo "<td><input type=radio name=r$qid $str value=$s> </td>";
										}
										echo "<td> $el </td><td><input type=radio class=big id=q$qid name=q$qid value=$s></td></tr></table>";                                
									}else if($sv==1)
									*/
									if(1)
									{	//$sv=0;
										echo "<table><tr><td> </td>";
										for($s=$sv;$s<=$ev;$s++)
										{
											echo "<td align='center'> $s </td>";
										}
										echo "<td> </td></tr><tr><td> $sl </td>";
										for($s=$sv;$s<=$ev;$s++)
										{   
											if($strval == $s)
											{ 
												$str="checked='checked'";
											}else $str='';
											echo "<td align='center'><input type=radio class=big id=q$qid name=q$qid $str value=$s> </td>";
										}
										echo "<td> $el </td></td></tr></table>"; 
										//$sv=1;
									}
									
								  }
								 echo "</table>";
							  } 
					   }
					   if($qtype=='text')
					   { 
							$qterm='';$str='';
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;
							}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $str=$rss2->first()->$qterm;}
							else $str='';

							echo "<input type=hidden name=qid[] value=$qid>";
							if($qid == '18055'){
                                                        	//echo "<input type=text size=20 maxlength=10 minlength=10 onkeypress='return isNumber(event)' style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
								echo "<input type=email style='background-color:lightgray;width:98%; height:40px;font-size:16px;padding:10px;' placeholder='Type your email id here' required  name=q$qid id=q$qid value='$str'>";

                                                        }
                                                       else{
								echo "<input type='text' style='background-color:lightgray;width:98%; height:40px;font-size:16px;padding:10px;' placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
							}
					   }
					   if($qtype=='textarea')
					   { 
							$qterm='';$str='';
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $str=$rss2->first()->$qterm;}
							else $str='';

							echo "<input type=hidden name=qid[] value=$qid>";
							echo "<div style='float:left; width:75%;'><textarea id=q$qid name=q$qid cols=150 rows=5 > </textarea></div>";
					   }
					   echo "</td></tr><tr><td>";
				}
				if($qtype=='text' || $qtype=='textarea' || $qtype=='radio' || $qtype=='checkbox' || $qtype=='rating' || $qtype=='dropdown') 
				{    
					  array_push($qlist,$qid);
					  //save_result($_POST,$table,$qset,$resp_id);
				}
	  } //end of ELSE for is grid rule
	 } //end of foreach
	}// end of else
       }
        else
        {
            //termination code
               //echo 'Last Question';              
                    echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br></font></center>";

                      echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center> </td></tr><tr><td>";

             //end termination
        }

	}

	if(isset($_POST['back']))
	{       
                   
	} //end of back button
	if($cqid!=-1){
?> 

	<br><font size=2 color=red><div id=err></div></font>       

       <?php if( count(@$_SESSION['pqstack']) > 0){  ?>
	  <input type='submit' name='back' value="&#8249;Back" onclick="myFunction()" class="previous round" onclick="backButton()" style="padding: 8px 16px;display: inline-block;" >
      <?php } ?>
	  
	  <?php
	  //if($arr_qt)
	  if(count(@$arr_qt) == 3)
	  {
	  ?>
	   <input type='submit' id='checkBtn' name='next' value="Next" class="next" onclick='return Validate();' style='background-color:#004c00;color:white;height:35px; margin-left:50%; float:center; padding: 8px 16px;display: inline-block;'><br><br>
	  <?php }?>
	   
	   <?php
	  //if($arr_qt)
	  if(count(@$arr_qt) != 3)
	  {
	  ?>
	  <input type='submit' id='btn' name='next' value="Next" class="next" onclick='return Validate();' style='background-color:#004c00;color:white;height:35px; margin-left:50%; float:center; padding: 8px 16px;display: inline-block;'><br><br> 
	  <?php } ?>
	  
	  <?php } ?>
	  </center>  
	                                
	  </div>
	        
	 <input type='hidden' id='temp'>
	</form>

</td></tr></table>
<!--<div class="copyright" style="font-size:11px;bottom:0;position:fixed;  background-color:gray;color:white;width:100%;"><p style="float:center;" &copy; 2018 VareniaCIMS Private Limited. All Rights Reserved.</p></div>
-->
<tr><td style="background-color: #e5e5e5; color: gray; padding: 15px;" align="center">
<span class="copyright" style="font-size:12px;"> &copy; 2019 VareniaCIMS Private Limited. All Rights Reserved.</span>
</td></tr></table>
</table>
    </body>
</html>

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<script type="text/javascript">
	
	function Validate() 
	{
	
	var jArray= <?php echo json_encode($qlist ); ?>;
	var error=0;
	    
	    for(var j=0;j<jArray.length;j++)
	    {   var flag=0;
	        var ctr=0;
	        var elm=jArray[j];
	        var qq='q'+elm;
			var nm='text'+elm;
	        var radios = document.getElementsByName(qq); 
	      
	        var et=document.getElementById(qq).type;
	        //alert(qq);
	        //alert(et);

	    if(et=='radio' )
	    {   //alert('len:'+radios.length);
	        //val=document.getElementById(qq).checked;
	        for (var i = 0; i < radios.length; i++) 
	        { 
	           if (radios[i].checked) 
	           { 
	                ctr++;  
	                elm+='e';       
	                document.getElementById(elm).innerHTML = '';         
	           }
	       }
	       if(ctr==0)
	       {
	       flag++;
	       elm+='e';
	       error++;
	       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]';
	       document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
	       }
	     }
	
		if(et=='checkbox')
	    	{   
		         //val=document.getElementById(qq).checked;
		        var oRadio = document.forms[0].elements[qq]; 
		        var nm=document.getElementById(qq).name; 
			var ln=nm.length;
 			//var res = nm.substring(0,ln-1);
			var res = nm.substring(0,ln-0);
		      for (var i = 0; i < oRadio.length; i++) 
		      {
				var vstr=res; 
				//	alert('i:'+i+' = '+oRadio[i].checked+'ctr: '+ctr);

		                if (oRadio[i].checked) 
		                { 
			                ctr++;
			                elm+='e';       
			                document.getElementById(elm).innerHTML = '';
					break;
		                }           

	       		} 
		       if(ctr==0)
		       {
		       flag++;
		       elm+='e';
		       error++;
		       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]'; 
		       document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
		       }
	     	}
	        if (et == 'text' || et=='textarea') 
	        {    
	              if(document.getElementById(qq).value=='')  
	              {
			//alert('text');
	              elm+='e';
	              error++; flag=1; 
	              document.getElementById(elm).innerHTML = ' [ Error! Please type your response!! ]';
	              document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';     
	              } 
	              else
	              {
	                elm+='e';       
	                document.getElementById(elm).innerHTML = '';
	              } 
	         }  
	    }
	   //alert('ctr:'+ctr+'- err:'+error+'-flag:'+flag);
	    if(error==0 && flag==0)
	     { return true;}
	    if(error>0 || flag>=1)
	      { flag=0; document.execCommand("Stop"); return false;}
	}
	
	</script>



<script>
////total sum calculation script //////////////////////////////////
$(document).ready(function()
{
$("#myDiv").on('input', '.txtCalc', function () {
       var calculated_total_sum = 0;
     
       $("#myDiv .txtCalc").each(function () {
           var get_textbox_value = $(this).val();
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseFloat(get_textbox_value);
              }                  
            });
              $("#total_sum_value").html(calculated_total_sum);
       });

});
/////////////////////////////////////////////////////////////////////
</script>
<script>
function ActionButton(qid)
{

	alert('Max 5:'+qid);
}
</script>

<script>


var acfs;

$(function() {
   //acfs = $('input[type=text][id^=op_]'); //getting all ids
   acfs = $('input[type=text][id^=op_]'); 
  acfs.on('input propertychange', checkSum);
});

var max = 5;

var checkSum = function(e) {
  this.value = this.value.replace(/\D/g, ''); //only digits
  var sum = 0;
  var fn = function() {
    sum += +this.value || 0; // parse individual text-box value to int
  };
  acfs.each(fn);
  if (max < sum)
  {           // above limit
    this.value = '0'; //erase input
            alert("Total sum can not be more than 5 .Please rate accordingly");
  }

  if(max==sum)
  {
	  document.getElementById('btn').disabled = false;
	 document.getElementById('msg').innerHTML="<span style='color:green'>Done! Click on next button</span>"; 
  }
  
  if(max > sum )
  {
	  document.getElementById('btn').disabled = true;
	  document.getElementById('msg').innerHTML="<span style='color:red'>SUM is not equal to 5. SUM should be 5 to continue.</span>";
  }

};
</script>


	<style>
	.big{ width: 2em; height: 2em; }
	
	    body {
	    font-family: 'Source Sans Pro', sans-serif;
	    height: 100%;
	    width: 100%;
	    margin: 0;
	    padding: 0;
	    text-align: justify;
	    text-justify: inter-word;
	    text-decoration: none;
	    font-size: 1.375em;
	    background-color: #F9FCF8; 
	    margin-top: opx;
	    margin-bottom: 0px;
	    margin-right: 75px;
	    margin-left: 75px;
	    }
	
	   div#header
	   {
	            height: 35px;
	            top:0px;
		    right:0px;
		    left:0px;
		    position:fixed;
		    //background: #00e500;
	            background: #fff;
		    border:1px solid #ccc;
		    padding: 0 10px 0 20px;
	   }
	
	   div#footer
	   {
	            height: 7%;
	            right:0px;
		    left:0px;
	            bottom:0px;
		    background: #1F5F04;
	            //background: #fff;
		    border:1px solid #ccc;
		    padding: 0 10px 0 20px;
	   }
	submit{line-height:25px;height:25px;}
	table{ border-style:hidden; border: none;}
	
</style>
</html>


<script>
// radio enable disabled scripting
function changeThis(sender) 
{
	<?php
	$i=0;
	 if(@$arr_qo)
	 foreach(@$arr_qo as $qo)
	 {
		 $i++;
	?>
  if(document.getElementById("c<?=$i?>").checked)
  {
    document.getElementById("r<?=$i?>").disabled=false;
  }
  
  else
  {
    document.getElementById("r<?=$i?>").disabled = true;
	document.getElementById("r<?=$i?>").checked = false;
  }
	 <?php }?>
  }
</script>

<script type="text/javascript">
// checkbox validation
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

    });
});

</script>


<script type="text/javascript">
// checkbox validation
$(document).ready(function () 
{
	
    $('#btn').click(function() 
	{
      checked = $("input[type=checkbox]:checked").length;
      rchecked = $("input[type=radio]:checked").length;

        var cid=null;
	var rid=null;
        var qset=<?=$qset?>;
        if(qset == 213){
          cid=document.getElementById('q12326');
          rid=document.getElementById('q12327');
	}
	if(qset == 217){
          cid=document.getElementById('q12562');
          rid=document.getElementById('q12563');
	}
	if(qset == 218){
          cid=document.getElementById('q12613');
          rid=document.getElementById('q12614');
	}
	if(qset == 219){
          cid=document.getElementById('q12672');
          rid=document.getElementById('q12673');
	}
        if(qset == 220){
          cid=document.getElementById('q12724');
          rid=document.getElementById('q12725');
	}
        if(qset == 221){
          cid=document.getElementById('q12788');
          rid=document.getElementById('q12789');
	}
        if(qset == 222){
          cid=document.getElementById('q12846');
          rid=document.getElementById('q12852');
	}
	if(qset == 223){
          cid=document.getElementById('q12861');
          rid=document.getElementById('q12865');
	}
        if(qset == 224){
          cid=document.getElementById('q12868');
          rid=document.getElementById('q12873');
	}
      if(cid.checked!=true && checked < 1 ) 
      {
        //alert("You must check at least one checkbox.");
        return false;
      }
	  
	  if(rid.checked!=true  && rchecked < 1)
	  {
		 // alert("You must check at least one radio option.");
			return false;
	  }

    });
});

</script>

<script>
// =========== SCRIPT FOR AUTO disabled enabled radio button on the basis of checkbox checked ================//
 window.onload=function()
  {
	  <?php
	 $k=0;
	 if(@$arr_qo)
	 foreach(@$arr_qo as $qot)
	 {
		$k++;
	?>
    if (document.getElementById('c<?=$k?>').checked)
    {
		document.getElementById("r<?=$k?>").disabled = false;
    }
	
	else
	{
		document.getElementById("r<?=$k?>").disabled = true;
	}
	
	<?php }?>
  }
  // =========== // ================
</script>

<script>
//show hide on radio button
$(document).ready(function() 
{
	// ==================== For 17560 ===================== //
    $("input[data-id$='q17560_14']").click(function()
	{
	     var checked_17560 = $("input[data-id=q17560_14]:checked").length;
		
		if(checked_17560>0)
		{
			document.getElementById("other_14").required=true;
			document.getElementById("other_14").style.display = 'block';
		}
		
		else
		{
			document.getElementById("other_14").required=false;
			document.getElementById("other_14").value='';
			document.getElementById("other_14").style.display = 'none';
		}
		
    });
	
	
	
	// ==================== For 17562 ===================== //
	 $("input[data-id$='q17562_7']").click(function()
	{
        var checked_17562 = $("input[data-id=q17562_7]:checked").length;
		
		if(checked_17562>0)
		{
			document.getElementById("other_7").required=true;
			document.getElementById("other_7").style.display = 'block';
		}
		
		else
		{
			document.getElementById("other_7").required=false;
			document.getElementById("other_7").value='';
			document.getElementById("other_7").style.display = 'none';
		}
		
    });
});

</script>
<!-- ========= // ========= -->

<script>
window.onload = onPageLoad();

function onPageLoad() 
{
	if($('.q17562_7').is(':checked'))
	{
		document.getElementById("other_7").style.display = 'block';
	}
	
	else
	{
		document.getElementById("other_7").style.display = 'none';
	}

}
</script>

<script>
window.onload = onPageLoad2();

function onPageLoad2() 
{
	
	if ($('.q17560_14').is(':checked')) 
	{
		document.getElementById("other_14").style.display = 'block';
	}
	
	else
	{
		document.getElementById("other_14").style.display = 'none';
	}

}
</script>

<script>

// ****************************** Enabled & Disabled Part ***************************************
$(document).on("click", ".r_17573_1", function () //17573_1
{
	//$(".r_17574_1, .r_17575_1, .r_17576_1").attr("disabled",true); // options disabled
	
	// $(".r_17574_2, .r_17575_2, .r_17576_2").attr("disabled",false); // options enabled
	// $(".r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",false); // options enabled
	// $(".r_17574_4, .r_17575_4, .r_17576_4").attr("disabled",false); // options enabled
	
	$(".r_17574_1, .r_17575_1, .r_17576_1").attr("checked",false); // other option checked false
});

$(document).on("click", ".r_17574_1", function () //17574_1
{
	//$(".r_17573_1, .r_17575_1, .r_17576_1").attr("disabled",true); // options disabled	
	$(".r_17573_1, .r_17575_1, .r_17576_1").attr("checked",false); // other option checked false
});


$(document).on("click", ".r_17573_2", function () //17573_2
{
	//$(".r_17574_2, .r_17575_2, .r_17576_2").attr("disabled",true); // options disabled
	//$(".r_17573_1, .r_17574_1, .r_17575_1, .r_17576_1").attr("disabled",false); // options enabled
	$(".r_17574_2, .r_17575_2, .r_17576_2").attr("checked",false); // other option checked false
});

$(document).on("click", ".r_17574_2", function () //17574_2
{
	//$(".r_17573_2, .r_17575_2, .r_17576_2").attr("disabled",true); // options disabled
	//$(".r_17573_1, .r_17574_1, .r_17575_1, .r_17576_1").attr("disabled",false); // options enabled
	$(".r_17573_2, .r_17575_2, .r_17576_2").attr("checked",false); // other option checked false
});

$(document).on("click", ".r_17573_3", function () //17573_3
{
	//$(".r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",true); // options disabled	
	//$(".r_17573_2, .r_17574_2, .r_17575_2, .r_17576_2").attr("disabled",false); // other option checked false
	$(".r_17574_3, .r_17575_3, .r_17576_3").attr("checked",false); // other option checked false
});

$(document).on("click", ".r_17574_3", function () //17574_3
{
	//$(".r_17573_3, .r_17575_3, .r_17576_3").attr("disabled",true); // options disabled	
	$(".r_17573_3, .r_17575_3, .r_17576_3").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17573_4", function () //17573_4
{
	//$(".r_17574_4, .r_17575_4, .r_17576_4").attr("disabled",true); // options disabled
	//$(".r_17573_3, .r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",false); // other option checked false
	$(".r_17574_4, .r_17575_4, .r_17576_4").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17574_4", function () //17574_4
{
	//$(".r_17573_4, .r_17575_4, .r_17576_4").attr("disabled",true); // options disabled
	//$(".r_17573_3, .r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",false); // other option checked false
	$(".r_17573_4, .r_17575_4, .r_17576_4").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17574_4", function () //17575_4
{
	//$(".r_17573_4, .r_17575_4, .r_17576_4").attr("disabled",true); // options disabled
	//$(".r_17573_3, .r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",false); // other option checked false
	$(".r_17573_4, .r_17575_4, .r_17576_4").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17575_4", function () //17575_4
{
	//$(".r_17573_4, .r_17575_4, .r_17576_4").attr("disabled",true); // options disabled
	//$(".r_17573_3, .r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",false); // other option checked false
	$(".r_17573_4, .r_17574_4, .r_17576_4").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17576_4", function () //17576_4
{
	//$(".r_17573_4, .r_17575_4, .r_17576_4").attr("disabled",true); // options disabled
	//$(".r_17573_3, .r_17574_3, .r_17575_3, .r_17576_3").attr("disabled",false); // other option checked false
	$(".r_17573_4, .r_17575_4, .r_17574_4").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17575_1", function () //17575_1
{
	//$(".r_17574_1, .r_17573_1, .r_17576_1").attr("disabled",true); // options disabled
	$(".r_17574_1, .r_17573_1, .r_17576_1").attr("checked",false); // options disabled
});


///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17576_1", function () //17575_1
{
	//$(".r_17574_1, .r_17573_1, .r_17575_1").attr("disabled",true); // options disabled
	$(".r_17574_1, .r_17573_1, .r_17575_1").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17576_2", function () //17575_2
{
	//$(".r_17574_2, .r_17573_2, .r_17575_2").attr("disabled",true); // options disabled
	$(".r_17574_2, .r_17573_2, .r_17575_2").attr("checked",false); // options disabled
});



///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17575_2", function () //17575_2
{
	//$(".r_17574_2, .r_17573_2, .r_17576_2").attr("disabled",true); // options disabled
	$(".r_17574_2, .r_17573_2, .r_17576_2").attr("checked",false); // options disabled
});


///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17575_3", function () //17575_3
{
	//$(".r_17574_3, .r_17573_3, .r_17576_3").attr("disabled",true); // options disabled
	$(".r_17574_3, .r_17573_3, .r_17576_3").attr("checked",false); // options disabled
});

///////////////////////////////////////////////////////////////////////////////////////
$(document).on("click", ".r_17576_3", function () //17576_3
{
	//$(".r_17574_3, .r_17573_3, .r_17575_3").attr("disabled",true); // options disabled
	$(".r_17574_3, .r_17573_3, .r_17575_3").attr("checked",false); // options disabled
});



///////////////////////////////////////////////////////////////////////////////////////

// ****************************** End of Enabled & Disabled Part ***************************************
  </script>

 
<script type="text/javascript">

   function isNumber(evt) 
   {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            //alert("Please enter only Numbers.");
            return false;
        }

        return true;
    }

   function isNotNumber(evt) 
   {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return true;
        }

        return false;
    }

</script>
