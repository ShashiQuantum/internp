<?php
include_once('../vcimsweb/init.php');
include_once('survey-function.php');

				$totrt=DB::getInstance()->query("SELECT q_id from question_detail where qset_id=234 and q_type='radio'");
				if($totrt->count()>0)
				foreach($totrt->results() as $rt)
				{
					$rqid=$rt->q_id;
					//echo "<script>alert($rqid)</script>";
				}

    //print_r($_SESSION);
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

//echo $sid;
		//$arr_radio=array();
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
	</head>
	<body class="col-12">
<table border=0 class="col-12" style="height: 100%;">
<tr style="background-color:green;"><td style="height:3%;width:100%;">
     <div> 
                        <span style=float:right;color:#fff; font-size:50px;> <?php  ?> </span>
                        <span style=float:left;><img src='https://vareniacims.com/public/img/logos/varenia_logow.png' height=50px width=120px> </span>
	 
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
                    $qqa="UPDATE $table SET `st`=2, timestamp='$dt' WHERE resp_id = $resp_id AND q_id = $qset AND gender !=''";
                    DB::getInstance()->query($qqa);
                    //session_destroy();
			//$newURL="https://www.vareniacims.com/survey/fp234.php?q=$qset";
                       echo $newURL="http://localhost/digiamin-web/survey/thanks.php";
                     header('Location: '.$newURL);

	}

	if(isset($_POST) || $sid==0)
	{
			date_default_timezone_set('asia/calcutta');
			$dt = date('Y/m/d H:i:s');
			$cq=0;
			//to next button
			if(isset($_POST['next']) && $sid > 0)
			{
				
				
	//echo "<br>next..";
	//print_r($_SESSION['pqstack']);

	      		   if($sid > 0)
	      		   {
				$cq=$_POST['qid'];
				
				if($pqt != 'first')
				{
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
			//if($nctr==0){$nctr++;  continue;}
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
			    foreach($qu2->results() as $rs)
				{
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
			//begin of grid questions based on qid for qset=324
			
				//$fgqid = $gqids[0];
				//$ititle = $arr_temp[ $fgqid ]['q_title'];
			if(in_array('14105',$gqids)){
					$arr_qo=array(array());
					//$qid= $gqids[ 0 ];
					$qid=14105;
					$arr_qo = get_qop($qid,'opt_text_value');
					$arr_qo_val = get_qop($qid,'value');
					//print_r($arr_qo);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
                                        echo "<table> <tr><td><p style='margin-left:25px;font-size:20px;'> $qtle</p></td></tr></table><font color=red><span id='$error'></span></font></div>";
                                        echo "<table border='1' cellpadding=0 cellspacing=0 style='padding:30px;width:100%;'>";
					$rspd = get_q_response($table,$resp_id,$qid);
					//if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
					$error=$qid.'e';
                                        //echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td><td></td></tr>";
					$i=0;
					$t=0;
					$qid1=14215;
					$qid2=14216;
					echo "<input type=hidden name='qid[]'  value= $qid1 ><input type=hidden name='qid[]' value= $qid2 >";
					array_push($qlist,$qid1);array_push($qlist,$qid2);
					foreach($arr_qo_val as $ov)
					{
						$t++;
						$str='';
						if(!empty($rspd)){
                                                	if(in_array($ov,$rspd)) $str=" checked='checked'";
	                                        }
						$opt=$arr_qo[ $i ];
						if($ov == 1) echo "<tr>
						<td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid $str value=$ov> $opt 
						<div id='course_opt1' class='course' style='display: none; margin-left:25px'>
						<input type='checkbox' class='big' value=1 id='subj1' name='q14215[]'>Math
						<input type='checkbox' class='big' value=2 id='subj2' name='q14215[]'>Computer
						<input type='checkbox' class='big' value=3 id='subj3' name='q14215[]'>Biology
						<input type='checkbox' class='big oth_sub' value=4 id='subj4' name='q14215[]'>Other
						</div>		

						<input type='text' id='os' class='os' name='q14216' placeholder='Specify here' style='display:none;height:40px;font-size:16px; margin-left:25px'>	
						</td>
						
						</tr>
						<tr><span style='color:red' id='14105e'></span></tr>
						";
						
						
						else{
							
							
								echo "<tr> <td style='background-color:lightgray'><input type='radio' class='big' id=q$ov name=q$qid $str value=$ov> $opt ";
							
							if($qid==14105 and $i==3)
							{
                               	echo "<input type=hidden name='qid[]'  value= 14106 >";
								echo "<input type='text' id='osubj' class='osubj' name='q14106' placeholder='Specify here' style='display:none;height:40px;font-size:16px; margin-left:25px;'>";
							}
							echo "</td>";
							echo "</tr>";
						}
						$i++;
					}
					//echo "</tr>";
                                  //}
                                    echo "</table>";
			} //end for qid=14105

			
					if(in_array('14109',$gqids)){
					//$ititle = $arr_temp[ '14105' ]['q_title'];
					$arr_qo=array(array());
					//$qid= $gqids[ 0 ];
					$qid=14109;
					$arr_qo = get_qop($qid,'opt_text_value');
					$arr_qo_val = get_qop($qid,'value');
					//print_r($arr_qo);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
                                        echo "<table><tr><td colspan=2 style='margin-left:25px;'> $qtle <font color=red><span id='$error'></span></font> </td></tr></table>";
                                        //echo "<table border='1' cellpadding=0 cellspacing=0 style='padding:30px;width:100%;'>";
					echo "<span style='color:red' id='14109e'></span>";

					$rspd = get_q_response($table,$resp_id,$qid);

					//if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
					$error=$qid.'e';
                   			// echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td><td></td></tr>";
					
					///////////////////////////Couses choices Option hide show/////////////////////
					
					// ************** 1st opt ****************//
					$i=0;
					foreach($arr_qo_val as $ov)
					{
						$t++;						
						$str='';
						if(!empty($rspd))
						{
							if(in_array($ov,$rspd)) $str=" checked='checked'";
	                    }
						$opt=$arr_qo[ $i ];
						
							echo "<tr><td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid $str value=$ov> $opt ";
					
						// **1st choice
						if($i == 0) 
						{	
						echo '<div id="course_choice1" class="choices" style="display:none;">';
						
                        echo "<input type=hidden name='qid[]' value='14134'>";
						echo "<select style='margin-left:25px;' id='sel1a' name='q14134' onchange='sel1_a(this.value)'>";
						echo "<option value='' disabled selected>Select 1st choice</option>";
						$subopt1_a = get_qop(14134, 'opt_text_value');
						$i1_a=0;
						foreach($subopt1_a as $so1_a)
						{
							$i1_a++;
							echo "<option value='$i1_a'>$so1_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14135'>";
						echo "<input type='text' id='1ao' name=q14135 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14136'>";
						echo "<select style='margin-left:25px;' id='sel1b' name=q14136 onchange='sel1_b(this.value)'>";
						echo "<option value='0'  selected>Select 2nd choice</option>";
						$subopt1_b = get_qop(14136, 'opt_text_value');
						$i1_b=0;
						foreach($subopt1_b as $so1_b)
						{
							$i1_b++;
							echo "<option value='$i1_b'>$so1_b</option>";
						}
						echo "</select>";
						
                                                echo "<input type=hidden name='qid[]' value='14137'>";
						echo "<input type='text' id='1bo' name=q14137  placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14138'>";
						echo "<select style='margin-left:25px;' id='sel1c' name=q14138 onchange='sel1_c(this.value)'>";
						echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt1_c = get_qop(14138, 'opt_text_value');
						$i1_c=0;
						foreach($subopt1_c as $so1_c)
						{
							$i1_c++;
							echo "<option value='$i1_c'>$so1_c</option>";
						}
						echo "</select>";
						
                                                echo "<input type=hidden name='qid[]' value='14139'>";
						echo "<input type='text' id='1co' name=q14139 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 1st opt ****************//
						
						// ************** 2nd opt ****************//
						if($i == 1) 
						{	
						echo '<div id="course_choice2" class="choices" style="display:none;">';
						echo "<input type=hidden name='qid[]' value='14140'>";
						echo "<select style='margin-left:25px;' id='sel2a' name='q14140' onchange='sel2_a(this.value)'>";
						echo "<option value='0' selected>Select 1st choice</option>";
						$subopt2_a = get_qop(14140, 'opt_text_value');
						$i2_a=0;
						foreach($subopt2_a as $so2_a)
						{
							$i2_a++;
							echo "<option value='$i2_a'>$so2_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14141'>";
						echo "<input type='text' id='2ao' name='q14141' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14142'>";
						echo "<select style='margin-left:25px;' id='sel2b' name=q14142 onchange='sel2_b(this.value)'>";
						echo "<option value='0' selected>Select 2nd choice</option>";
						$subopt2_b = get_qop(14142, 'opt_text_value');
						$i2_b=0;
						foreach($subopt2_b as $so2_b)
						{
							$i2_b++;
							echo "<option value='$i2_b'>$so2_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14143'>";
						echo "<input type='text' id='2bo' name='q14143' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14144'>";
						echo "<select style='margin-left:25px;' id='sel2c' name=q14144 onchange='sel2_c(this.value)'>";
                                                echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt2_c = get_qop(14144, 'opt_text_value');
						$i2_c=0;
						foreach($subopt2_c as $so2_c)
						{
							$i2_c++;
							echo "<option value='$i2_c'>$so2_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14145'>";
						echo "<input type='text' id='2co' name='q14145' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 2nd opt ****************//
						
						// ************** 4th opt ****************//
						if($i == 3) 
						{	
						echo '<div id="course_choice4" class="choices" style="display:none;">';

                                                echo "<input type=hidden name='qid[]' value='14146'>";
						echo "<select style='margin-left:25px;' id='sel4a' name=q14146 onchange='sel4_a(this.value)'>";
                                                echo "<option value='' disabled selected>Select 1st choice</option>";
						$subopt4_a = get_qop(14146, 'opt_text_value');
						$i4_a=0;
						foreach($subopt4_a as $so4_a)
						{
							$i4_a++;
							echo "<option value='$i4_a'>$so4_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14147'>";
						echo "<input type='text' id='4ao' name='q14147' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14148'>";
						echo "<select style='margin-left:25px;' id='sel4b' name='q14148' onchange='sel4_b(this.value)'>";
                                                echo "<option value='0' selected>Select 2nd choice</option>";
						$subopt4_b = get_qop(14148, 'opt_text_value');
						$i4_b=0;
						foreach($subopt4_b as $so4_b)
						{
							$i4_b++;
							echo "<option value='$i4_b'>$so4_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14149'>";
						echo "<input type='text' id='4bo' name='q14149' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14150'>";
      						echo "<select style='margin-left:25px;' id='sel4c' name='q14150' onchange='sel4_c(this.value)'>";
                                                echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt4_c = get_qop(14150, 'opt_text_value');
						$i4_c=0;
						foreach($subopt4_c as $so4_c)
						{
							$i4_c++;
							echo "<option value='$i4_c'>$so4_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14151'>";
						echo "<input type='text' id='4co' name='q14151' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 4th opt ****************//
						
						// ************** 9th opt ****************//
						if($i == 8) 
						{	
						echo '<div id="course_choice9" class="choices" style="display:none;">';
                                                echo "<input type=hidden name='qid[]' value='14152'>";
						echo "<select style='margin-left:25px;' id='sel9a' name='q14152' onchange='sel9_a(this.value)'>";
                                                echo "<option value='' disabled selected>Select 1st choice</option>";
						$subopt9_a = get_qop(14152, 'opt_text_value');
						$i9_a=0;
						foreach($subopt9_a as $so9_a)
						{
							$i9_a++;
							echo "<option value='$i9_a'>$so9_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14153'>";
						echo "<input type='text' id='9ao' name='q14153' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14154'>";
						echo "<select style='margin-left:25px;' id='sel9b' name='q14154' onchange='sel9_b(this.value)'>";
                                                echo "<option value='0' selected>Select 2nd choice</option>";
						$subopt9_b = get_qop(14154, 'opt_text_value');
						$i9_b=0;
						foreach($subopt9_b as $so9_b)
						{
							$i9_b++;
							echo "<option value='$i9_b'>$so9_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14155'>";
						echo "<input type='text' id='9bo' name='q14155' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14156'>";
						echo "<select style='margin-left:25px;' id='sel9c' name='q14156' onchange='sel9_c(this.value)'>";
                                                echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt9_c = get_qop(14156, 'opt_text_value');
						$i9_c=0;
						foreach($subopt9_c as $so9_c)
						{
							$i9_c++;
							echo "<option value='$i9_c'>$so9_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14157'>";
						echo "<input type='text' id='9co' name='q14157' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 9th opt ****************//
						
						
						// ************** 14th opt ****************//
						if($i == 13) 
						{	
						echo '<div id="course_choice14" class="choices" style="display:none;">';
                                                echo "<input type=hidden name='qid[]' value='14158'>";
						echo "<select style='margin-left:25px;'id='sel14a' name='q14158' onchange='sel14_a(this.value)'>";
                                                echo "<option value='' disabled selected>Select 1st choice</option>";
						$subopt14_a = get_qop(14158, 'opt_text_value');
						$i14_a=0;
						foreach($subopt14_a as $so14_a)
						{
							$i14_a++;
							echo "<option value='$i14_a'>$so14_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14159'>";
						echo "<input type='text' id='14ao' name='q14159' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14160'>";
						echo "<select style='margin-left:25px;' id='sel14b' name='q14160' onchange='sel14_b(this.value)'>";
                                                echo "<option value='0' selected>Select 2nd choice</option>";
						$subopt14_b = get_qop(14160, 'opt_text_value');
						$i14_b=0;
						foreach($subopt14_b as $so14_b)
						{
							$i14_b++;
							echo "<option value='$i14_b'>$so14_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14161'>";
						echo "<input type='text' id='14bo' name='q14161' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14162'>";
						echo "<select style='margin-left:25px;' id='sel14c' name='q14162' onchange='sel14_c(this.value)'>";
                                                echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt14_c = get_qop(14162, 'opt_text_value');
						$i14_c=0;
						foreach($subopt14_c as $so14_c)
						{
							$i14_c++;
							echo "<option value='$i14_c'>$so14_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14163'>";
						echo "<input type='text' id='14co' name='q14163' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 14th opt ****************//
						
						// ************** 15th opt ****************//
						if($i == 14) 
						{	
						echo '<div id="course_choice15" class="choices" style="display:none;">';
                                                echo "<input type=hidden name='qid[]' value='14164'>";
						echo "<select style='margin-left:25px;' id='sel15a' name='q14164' onchange='sel15_a(this.value)'>";
                                                echo "<option value='' disabled selected>Select 1st choice</option>";
						$subopt15_a = get_qop(14164, 'opt_text_value');
						$i15_a=0;
						foreach($subopt15_a as $so15_a)
						{
							$i15_a++;
							echo "<option value='$i15_a'>$so15_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14165'>";
						echo "<input type='text' id='15ao' name='q14165' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14166'>";
						echo "<select style='margin-left:25px;' id='sel15b' name='q14166' onchange='sel15_b(this.value)'>";
                                                echo "<option value='0' selected>Select 2nd choice</option>";
						$subopt15_b = get_qop(14166, 'opt_text_value');
						$i15_b=0;
						foreach($subopt15_b as $so15_b)
						{
							$i15_b++;
							echo "<option value='$i15_b'>$so15_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14167'>";
						echo "<input type='text' id='15bo' name='q14167' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14168'>";
						echo "<select style='margin-left:25px;' id='sel15c' name='q14168' onchange='sel15_c(this.value)'>";
                                                echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt15_c = get_qop(14168, 'opt_text_value');
						$i15_c=0;
						foreach($subopt15_c as $so15_c)
						{
							$i15_c++;
							echo "<option value='$i15_c'>$so15_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14169'>";
						echo "<input type='text' id='15co' name=14169 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 15th opt ****************//
						
						// ************** 16th opt ****************//
						if($i == 15) 
						{	
						echo '<div id="course_choice16" class="choices" style="display:none;">';
                                                echo "<input type=hidden name='qid[]' value='14170'>";
						echo "<select style='margin-left:25px;' id='sel16a' name=q14170 onchange='sel16_a(this.value)'>";
                                                echo "<option value='' disabled selected>Select 1st choice</option>";
						$subopt16_a = get_qop(14170, 'opt_text_value');
						$i16_a=0;
						foreach($subopt16_a as $so16_a)
						{
							$i16_a++;
							echo "<option value='$i16_a'>$so16_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14171'>";
						echo "<input type='text' id='16ao' name=q14171 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14172'>";
						echo "<select style='margin-left:25px;' id='sel16b' name=q14172 onchange='sel16_b(this.value)'>";
                                                echo "<option value='0' selected>Select 2nd choice</option>";
						$subopt16_b = get_qop(14172, 'opt_text_value');
						$i16_b=0;
						foreach($subopt16_b as $so16_b)
						{
							$i16_b++;
							echo "<option value='$i16_b'>$so16_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14173'>";
						echo "<input type='text' id='16bo' name=q14173 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14174'>";
						echo "<select style='margin-left:25px;' id='sel16c' name=q14174 onchange='sel16_c(this.value)'>";
                                                echo "<option value='0' selected>Select 3rd choice</option>";
						$subopt16_c = get_qop(14174, 'opt_text_value');
						$i16_c=0;
						foreach($subopt16_c as $so16_c)
						{
							$i16_c++;
							echo "<option value='$i16_c'>$so16_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14175'>";
						echo "<input type='text' id='16co' name=q14175 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 16th opt ****************//
												
						// ************** 17th opt ****************//
						if($i == 16) 
						{	
						echo '<div id="course_choice17" class="choices" style="display:none;">';
						
						// 1st option
                                                echo "<input type=hidden name='qid[]' value='14176'>";
						echo "<select style='margin-left:25px;' id='sel17a' name=q14176 onchange='sel17_a(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice for BBA</option>";
						$subopt17_a = get_qop(14176, 'opt_text_value');
						$i17_a=0;
						foreach($subopt17_a as $so17_a)
						{
							$i17_a++;
							echo "<option value='$i17_a'>$so17_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14177'>";
						echo "<input type='text' id='17ao' name=q14177 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14178'>";
						echo "<select style='margin-left:25px;' id='sel17b' name=q14178 onchange='sel17_b(this.value)'>";
						echo "<option value='0' selected >Select 2nd choice for BBA</option>";
						$subopt17_b = get_qop(14178, 'opt_text_value');
						$i17_b=0;
						foreach($subopt17_b as $so17_b)
						{
							$i17_b++;
							echo "<option value='$i17_b'>$so17_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14179'>";
						echo "<input type='text' id='17bo' name=q14179 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14180'>";
						echo "<select style='margin-left:25px;' id='sel17c' name=q14180 onchange='sel17_c(this.value)'>";
						echo "<option value='0' selected>Select 3rd choice for BBA</option>";
						$subopt17_c = get_qop(14180, 'opt_text_value');
						$i17_c=0;
						foreach($subopt17_c as $so17_c)
						{
							$i17_c++;
							echo "<option value='$i17_c'>$so17_c</option>";
						}
						echo "</select>";
						
                                                echo "<input type=hidden name='qid[]' value='14181'>";
						echo "<input type='text' id='17co' name=q14181 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "<br>";
						echo "<br>";
						
						//4th Option
                                                echo "<input type=hidden name='qid[]' value='14182'>";
						echo "<select style='margin-left:25px;' id='sel17d' name='q14182' onchange='sel17_d(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice for MBA</option>";
						$subopt17_d = get_qop(14182, 'opt_text_value');
						$i17_d=0;
						foreach($subopt17_d as $so17_d)
						{
							$i17_d++;
							echo "<option value='$i17_d'>$so17_d</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14183'>";
						echo "<input type='text' id='17do' name=q14183 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//5th choice
                                                echo "<input type=hidden name='qid[]' value='14184'>";
						echo "<select style='margin-left:25px;' id='sel17e' name=q14184 onchange='sel17_e(this.value)'>";
						echo "<option value='0' selected >Select 2nd choice for MBA</option>";
						$subopt17_e = get_qop(14184, 'opt_text_value');
						$i17_e=0;
						foreach($subopt17_e as $so17_e)
						{
							$i17_e++;
							echo "<option value='$i17_e'>$so17_e</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14185'>";
						echo "<input type='text' id='17eo' name=q14185 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 6th choice
                                                echo "<input type=hidden name='qid[]' value='14186'>";
						echo "<select style='margin-left:25px;' id='sel17f' name=q14186 onchange='sel17_f(this.value)'>";
						echo "<option value='0' selected >Select 3rd choice for MBA</option>";
						$subopt17_f = get_qop(14186, 'opt_text_value');
						$i17_f=0;
						foreach($subopt17_f as $so17_f)
						{
							$i17_f++;
							echo "<option value='$i17_f'>$so17_f</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14187'>";
						echo "<input type='text' id='17fo' name=q14187 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 17th opt ****************//
						
						// ************** 18th opt ****************//
						if($i == 17) 
						{	
						echo '<div id="course_choice18" class="choices" style="display:none;">';
                                                echo "<input type=hidden name='qid[]' value='14188'>";
						echo "<select style='margin-left:25px;' id='sel18a' name=q14188 onchange='sel18_a(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice for B.Tech</option>";
						$subopt18_a = get_qop(14188, 'opt_text_value');
						$i18_a=0;
						foreach($subopt18_a as $so18_a)
						{
							$i18_a++;
							echo "<option value='$i18_a'>$so18_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14189'>";
						echo "<input type='text' id='18ao' name=q14189 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14190'>";
						echo "<select style='margin-left:25px;' id='sel18b' name=q14190 onchange='sel18_b(this.value)'>";
						echo "<option value='0' selected >Select 2nd choice for B.Tech</option>";
						$subopt18_b = get_qop(14190, 'opt_text_value');
						$i18_b=0;
						foreach($subopt18_b as $so18_b)
						{
							$i18_b++;
							echo "<option value='$i18_b'>$so18_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14191'>";
						echo "<input type='text' id='18bo' name=q14191 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14192'>";
						echo "<select style='margin-left:25px;' id='sel18c' name=q14192 onchange='sel18_c(this.value)'>";
						echo "<option value='0' selected >Select 3rd choice for B.Tech</option>";
						$subopt18_c = get_qop(14192, 'opt_text_value');
						$i18_c=0;
						foreach($subopt18_c as $so18_c)
						{
							$i18_c++;
							echo "<option value='$i18_c'>$so18_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14193'>";
						echo "<input type='text' id='18co' name=q14193 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "<br>";
						echo "<br>";
						
						// 4th choice
                                                echo "<input type=hidden name='qid[]' value='14194'>";
						echo "<select style='margin-left:25px;' id='sel18d' name=q14194 onchange='sel18_d(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice for MBA</option>";
						$subopt18_d = get_qop(14194, 'opt_text_value');
						$i18_d=0;
						foreach($subopt18_d as $so18_d)
						{
							$i18_d++;
							echo "<option value='$i18_d'>$so18_d</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14195'>";
						echo "<input type='text' id='18do' name=q14195 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 5th choice
                                                echo "<input type=hidden name='qid[]' value='14196'>";
						echo "<select style='margin-left:25px;' id='sel18e' name=q14196 onchange='sel18_e(this.value)'>";
						echo "<option value='0' selected>Select 2nd choice for MBA</option>";
						$subopt18_e = get_qop(14196, 'opt_text_value');
						$i18_e=0;
						foreach($subopt18_e as $so18_e)
						{
							$i18_e++;
							echo "<option value='$i18_e'>$so18_e</option>";
						}
						echo "</select>";
						
                                                echo "<input type=hidden name='qid[]' value='14197'>";
						echo "<input type='text' id='18eo' name=q14197 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 6th choice
                                                echo "<input type=hidden name='qid[]' value='14198'>";
						echo "<select style='margin-left:25px;' id='sel18f' name=q14198 onchange='sel18_f(this.value)'>";
						echo "<option value='0' selected>Select 3rd choice for MBA</option>";
						$subopt18_f = get_qop(14198, 'opt_text_value');
						$i18_f=0;
						foreach($subopt18_f as $so18_f)
						{
							$i18_f++;
							echo "<option value='$i18_f'>$so18_f</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14199'>";
						echo "<input type='text' id='18fo' name=q14199 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 18th opt ****************//
						
						// ************** 19th opt ****************//
						if($i == 18) 
						{	
						echo '<div id="course_choice19" class="choices" style="display:none;">';
                                                echo "<input type=hidden name='qid[]' value='14200'>";
						echo "<select style='margin-left:25px;' id='sel19a' name=q14200 onchange='sel19_a(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice for B.Tech</option>";
						$subopt19_a = get_qop(14200, 'opt_text_value');
						$i19_a=0;
						foreach($subopt19_a as $so19_a)
						{
							$i19_a++;
							echo "<option value='$i19_a'>$so19_a</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14201'>";
						echo "<input type='text' id='19ao' name=q14201 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14202'>";
						echo "<select style='margin-left:25px;' id='sel19b' name=q14202 onchange='sel19_b(this.value)'>";
						echo "<option value='0' selected>Select 2nd choice for B.Tech</option>";
						$subopt19_b = get_qop(14202, 'opt_text_value');
						$i19_b=0;
						foreach($subopt19_b as $so19_b)
						{
							$i19_b++;
							echo "<option value='$i19_b'>$so19_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14203'>";
						echo "<input type='text' id='19bo' name=q14203 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14204'>";
						echo "<select style='margin-left:25px;' id='sel19c' name=q14204 onchange='sel19_c(this.value)'>";
						echo "<option value='0' selected >Select 3rd choice for B.Tech</option>";
						$subopt19_c = get_qop(14204, 'opt_text_value');
						$i19_c=0;
						foreach($subopt19_c as $so19_c)
						{
							$i19_c++;
							echo "<option value='$i19_c'>$so19_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14205'>";
						echo "<input type='text' id='19co' name=q14205 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "<br>";
						echo "<br>";
						
						// 4th choice
                                                echo "<input type=hidden name='qid[]' value='14206'>";
						echo "<select style='margin-left:25px;' id='sel19d' name=q14206 onchange='sel19_d(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice for M.Tech</option>";
						$subopt19_d = get_qop(14206, 'opt_text_value');
						$i19_d=0;
						foreach($subopt19_d as $so19_d)
						{
							$i19_d++;
							echo "<option value='$i19_d'>$so19_d</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14207'>";
						echo "<input type='text' id='19do' name=q14207 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 5th choice
                                                echo "<input type=hidden name='qid[]' value='14208'>";
						echo "<select style='margin-left:25px;' id='sel19e' name=q14208 onchange='sel19_e(this.value)'>";
						echo "<option value='0' selected>Select 2nd choice for M.Tech</option>";
						$subopt19_e = get_qop(14208, 'opt_text_value');
						$i19_e=0;
						foreach($subopt19_e as $so19_e)
						{
							$i19_e++;
							echo "<option value='$i19_e'>$so19_e</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14209'>";
						echo "<input type='text' id='19eo' name=q14209 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 6th choice
                                                echo "<input type=hidden name='qid[]' value='14210'>";
						echo "<select style='margin-left:25px;' id='sel19f' name=q14210 onchange='sel19_f(this.value)'>";
						echo "<option value='0' selected >Select 3rd choice for M.Tech</option>";
						$subopt19_f = get_qop(14210, 'opt_text_value');
						$i19_f=0;
						foreach($subopt19_f as $so19_f)
						{
							$i19_f++;
							echo "<option value='$i19_f'>$so19_f</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14211'>";
						echo "<input type='text' id='19fo' name=q14211 placeholder='Specify here' style='display:none; margin-left:10px;'>";						
						echo "</div>";
						echo "</td>";
						} // ************** end of 19th opt ****************//
						
							// ************** 20th opt ****************//
						if($i == 19) 
						{
						echo '<div id="course_choice20" class="choices" style="display:none;">';

						// 1st						
                                                echo "<input type=hidden name='qid[]' value='14212'>";
						echo "<input type='text' id='sel20a' name=q14212 placeholder='Specify course for 1st choice' style='margin-left:10px'>";
						
						// 2nd						
                                                echo "<input type=hidden name='qid[]' value='14213'>";
						echo "<input type='text' id='sel20b' name=q14213 placeholder='Specify course for 2nd choice' style='margin-left:10px'>";
						
						// 3rd
                                                echo "<input type=hidden name='qid[]' value='14214'>";
						echo "<input type='text' id='sel20c' name=q14214 placeholder='Specify course 3rd choice' style='margin-left:10px'>";		
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 20th opt ****************//
						
						///////////////////////////End of Couses choices Option hide show/////////////////////
						$i++;
					}
					//echo "</tr>";
                                  //}
                    echo "</table>";
					
					
							

			} //end for qid=14109
			
					
			// ************************ mq_8 *******************//			
			if(in_array('14114',$gqids))
			{
							// $var2 = get_data($resp_id);
							// echo $var2;
							
							$ds="SELECT 14109_234 as data from $table where resp_id = $resp_id and 14109_234!=''";
							$rr2=DB::getInstance()->query($ds);
							if($rr2->count()>0)
							{
								$get_d=$rr2->first()->data;
							}
							$str="";
							switch($get_d)
							{
								case 1: $str ="Bachelor of Arts";
								break;
								case 2: $str ="Bachelor of Business Administration/Studies";
								break;
								case 3: $str ="Bachelor of Business Economics";
								break;
								case 4: $str ="Bachelor of Commerce";
								break;
								case 5: $str ="Bachelor of Computer Applications";
								break;
								case 6: $str ="Bachelor of Dental Surgery";
								break;
								case 7: $str ="Bachelor of Design";
								break;
								case 8: $str ="Bachelor of Planning";
								break;
								case 9: $str ="Bachelor of Engineering / Technology";
								break;
								case 10: $str ="Bachelor of Hotel Management and Catering Technology";
								break;
								case 11: $str ="Bachelor of Law";
								break;
								case 12: $str ="Bachelor of Medicine and Bachelor of Surgery";
								break;
								case 13: $str ="Bachelor of Pharmacy";
								break;
								case 14: $str ="Bachelor of Science";
								break;
								case 15: $str ="Certificate course";
								break;
								case 16: $str ="Diploma";
								break;
								case 17: $str ="Integrated BBA and MBA";
								break;
								case 18: $str ="Integrated BTech and MBA";
								break;
								case 19: $str ="Integrated BTech and MTech";
								break;
								case 20: $str ="Other";
								break;
								
							}
							
							
							echo "<table style='width:100%'><td colspan=2> A. As you are interested in $str, please write down the name of the top 3 colleges in India you prefer to study in 
							<br>B. Select the college location as well. </td>";
							
							echo "<tr><td><span style='color:red' id='14114e'></span></td></tr><br>";
							
							echo "<tr><td style='background-color:lightgray'>Your 1st Choice</td>";
							echo "<td style='background-color:lightgray'>";
                            	echo "<input type=hidden name='qid[]' value='14113'>";
							echo "<input type='text' id=q14113 name=q14113 style='background-color:white;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Enter College Name 1' required>"; 
							
							echo "<br>";
							echo "<br>";
														
							echo "<span style='font-size:20px'>Location:</span>";
							
	                        echo "<input type=hidden name='qid[]' value='141114'>";
							$col_loc1 = get_qop(14114, 'opt_text_value');
							$c1=0;
							foreach($col_loc1 as $cl1)
							{
								$c1++;
								echo "<input type='radio' style='margin-left:25px' class='big' value='$c1' name='q14114' id='q14114'>$cl1";
							}
							
                            echo "<input type=hidden name='qid[]' value='14215'>";
							echo "<input type='text' name='q14115' class='collegeOtherCity1' id='collegeOtherCity1_6' style='margin-left:25px;height:40px; font-size:16px; display:none' placeholder='Specify Other City'>";
							
							echo "</td>";
							echo "</tr>";
							//End of 1st college details
							
							//2nd college details
							echo "<tr> <td style='background-color:lightgray'>Your 2nd Choice</td>";
							echo "<td style='background-color:lightgray'>";
	                        echo "<input type=hidden name='qid[]' value='14216'>";
							echo "<input type='text' id='q14216' style='background-color:white;width:100%; height:40px;font-size:16px;padding:20px;' name=q14216 placeholder='Enter College Name 2' required>"; 
							
							echo "<br>";
							echo "<br>";
							
							echo "<span style='font-size:20px'>Location:</span>";
							
	                        echo "<input type=hidden name='qid[]' value='14117'>";
							$col_loc2 = get_qop(14117, 'opt_text_value');
							$c2=0;
							foreach($col_loc2 as $cl2)
							{
								$c2++;
								echo "<input type='radio' style='margin-left:25px' class='big' name='q14117' id='14117' value='$c2'>$cl2";
							}
							
	                        echo "<input type=hidden name='qid[]' value='14118'>";
							echo "<input type='text' style='margin-left:25px;font-size:16px;height:40px; display:none' name='q14118' class='collegeOtherCity2' id='collegeOtherCity2_6' placeholder='Specify Other City'>";
							
							echo "</td>";
							echo "</tr>";
							//End of 2nd college details
							
							//3rd college details
							echo "<tr><td style='background-color:lightgray'>Your 3rd Choice</td>";
							echo "<td style='background-color:lightgray'>";
	                        echo "<input type=hidden name='qid[]' value='14119'>";
							echo "<input type='text' style='background-color:white;width:100%; height:40px;font-size:16px;padding:20px;' id=q14119 name=q14119 $str placeholder='Enter College Name 3' required>"; 
							
							echo "<br>";
							echo "<br>";
							
							echo "<span style='font-size:20px'>Location:</span>";
							
	                        echo "<input type=hidden name='qid[]' value='14120'>";
							$col_loc3 = get_qop(14120, 'opt_text_value');
							$c3=0;
							foreach($col_loc3 as $cl3)
							{
								$c3++;
								echo "<input type='radio' style='margin-left:25px' class='big' name='q14120' id='q14120' value='$c3'>$cl3";
							}
							echo "</select>";
							
                            echo "<input type=hidden name='qid[]' value='14121'>";
							echo "<input type='text' name='q14121' class='collegeOtherCity3' name='q14121' id='collegeOtherCity3_6' style='margin-left:25px;font-size:16px;height:40px; display:none' placeholder='Specify Other City'>";
							
							echo "</td>";
							echo "</tr>";
							//End of 3rd college details					
												
                         echo "</table>";
			} //end for qid=14114
			
		// ************************ residence cities *******************//
						if(in_array('14218',$gqids))
						{
							//current city
							echo "<table style='width:100%'><td colspan=2 style=''> <br> Kindly provide the address of your current residence. <br><br><span style='color:red; float:left' id='14219e'></span></td>";
							//echo "<tr><span style='color:red; float:left' id='14219e'></span></tr>";
							$ccity = get_qop(14219, 'opt_text_value');
							$c1=0;
							echo "<tr style='background-color:lightgray'>";
							echo "<input type=hidden name='qid[]' value='14218'>";
							
							echo "<td></td><td> <input type='text' name='q14218' placeholder='Enter Your Current Address' style='background-color:white;width:100%;height:40px; font-size:16px;' required>";

							echo "City:";
							echo "<input type=hidden name='qid[]' value='14219'>";
							foreach($ccity as $cl1)
							{
								$c1++;
								echo "<input type='radio' value='$c1' class='big' name='q14219'>$cl1";
							}
							
							echo "<input type=hidden name='qid[]' value='14220'>";
							echo "<input type='text' name='q14220' style='margin-left:25px;background-color:white;height:40px; font-size:16px; display:none' id='ocity4' class='ocity3' placeholder='Specify Other City' required>";
							
							echo "</td>";
							echo "</tr>";
																			
                         echo "</table>";
						 
					}
                                         if(in_array('14221',$gqids))
                                         {

						 //permanent city
							echo "<table style='width:100%'><td colspan=2 style=''> <br>Kindly provide the address of your Permanent residence.<br><br><span style='color:red' id='14222e'></span><br>  </td>";
							
							//echo "<br><span style='color:red' id='14222e'></span>";
							
							$ccity = get_qop(14222, 'opt_text_value');
							$c1=0;
							echo "<tr style='background-color:lightgray'>";
							echo "<input type=hidden name='qid[]' value='14221'>";
							echo "<td></td><td><input type='text' name='q14221' placeholder='Enter Your Permanent Address' style='background-color:white;width:100%;height:40px; font-size:16px; ' required>";

							
							echo "City:";
							foreach($ccity as $cl1)
							{
								$c1++;
								echo "<input type='radio' value='$c1' class='big' name='q14222'>$cl1";
							}
							
							echo "<input type=hidden name='qid[]' value='14223'>";
							echo "<input type='text' name='q14223' style='margin-left:25px;height:40px; font-size:16px; display:none' id='opcity4' class='opcity' placeholder='Specify Other City' required>";
							
							echo "</td>";
							echo "</tr>";
																			
                         echo "</table>";
		}
		// ************************ //end of residence cities *******************//

			//end of grid questions based on qid

			//end of grid questions based on qid
		}

	} //end of grid questions to show else continue
	else{
				$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
				if($ques->count()>0)
				{ 
							 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
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
							 echo "<p style='font-size:10px;'> </p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
								if($qtype == 'instruction') continue;
						      }
						      else if($lang == '1'){
                                            			$rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                            			if($rs22->count()>0)
                                            			{
                                                			$qtitle_1=$rs22->first()->q_title;
									echo "<p style='font-size:10px;'>$qid / $qno</p><p> $qtitle <br>[ $qtitle_1 ]</p><font color=red><span id='$error'></span></font></div>";
						      		}
								else echo "<tr><td><p style='font-size:10px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
						      }
						//echo "</td></tr> <tr><td style='height:60%; background-color:lightgray;'>";
						echo "</td></tr>";
						if($qtype=='radio')
						{
							echo "<tr><td style='height:60%; background-color:lightgray;'>";
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
						  
								$ci=0;	
									
								  foreach($qop->results() as $ov)
								  {  
									$ci++;	
									  $str=''; 
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value;
									  if($strval==$value) $str=" checked='checked'";

									
									if($lang == 'none'){
										//echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt <hr></td></tr>";
										
										echo "<tr height=40>";
										
											echo "<td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt ";
										// show if click on other school option
										if($qid==14103 and $value==8)
										{
											echo "<input type='text' id='sch_input8' name='q14104' class='sch' placeholder='Specify here' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
										}
										
										if($qid==14781 and $value==20)
										{
											echo "<input type='text' id='sch_input20' name='q14104' class='sch' placeholder='Specify here' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
										}
										
										//outside india textarea
										if($qid==14110 and $value==2)
										{
											echo "<input type='text' id='outInd2' name='q14111' class='outInd' onkeypress='return isNotNumber(event)'  placeholder='Specify country name' style='height:40px; font-size:16px; display:none; margin-left:25px'>";
										}
										
										//other residence textarea
										
										echo "<hr></td></tr>";

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
                                                        echo "<tr><td style='height:60%; background-color:lightgray;'>";
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
								foreach($qop->results() as $ov)
								{     $str='';
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value;
									   if($opt == 'Any other'){
										$flag_other=1;
										$other_arr=array($opt,$value);
										continue;
									   }
									  if(in_array($value,$arr_temp))
									  { 
											$str="checked='checked'";
									  }
									if($lang == 'none'){
										$aa='q'.$qid.'[]'; //$aa='q'.$qid.'[]';
									 	echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$aa' $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt <hr> </td></tr>";
									}
									else if($lang == '1'){
										if (!empty($larr)){
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt [ $larr[$value]  ]</td></tr>";
										}
										else{
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
										}
									}
								}
								if($flag_other == 1){
									$str='';
									$tx=$other_arr[0];
									$tv=$other_arr[1];
                                                                          if(in_array($tv,$arr_temp))
                                                                          {
                                                                                        $str="checked='checked'";
                                                                          }
										$aa='q'.$qid.'[]'; //$aa='q'.$qid.'[]';
									 	echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$aa' $str value='$tv'></td><td style='border-bottom: 1px solid #ff;'> $tx <hr> </td></tr>";

								}

								echo "</table>";
							} 
						}
					   
					   if($qtype=='rating')
						{    
                                                        echo "<tr><td style='height:60%; background-color:lightgray;'>";
							  $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
							  if($qop->count()>0)
							  {  echo "<table><input type=hidden name=qid value=$qid>";
								  foreach($qop->results() as $ov)
								  {
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $sv=$ov->scale_start_value; $ev=$ov->scale_end_value;
									  $arr_temp=array();$str='';$strval='';
									  
								$sql="SELECT  $term FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $term!=''";
								$rss2=DB::getInstance()->query($sql);
								if($rss2->count()>0) 
								{ $strval=$rss2->first()->$term;}
								else $strval="";
							
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
									{
										echo "<table><tr><td> </td>";
										for($s=$sv;$s<=$ev;$s++)
										{
											echo "<td> $s </td>";
										}
										echo "<td> </td></tr><tr><td> $sl </td>";
										for($s=$sv;$s<=$ev;$s++)
										{   
											if($strval==$s)
											{ 
												$str="checked='checked'";
											}else $str='';
											echo "<td><input type=radio class=big id=q$qid name=q$qid $str value=$s> </td>";
										}
										echo "<td> $el </td></td></tr></table>"; 
									}
									
								  }
								 echo "</table>";
							  } 
					   }
					   if($qtype=='text')
					   { 
                                                        echo "<tr><td style='height:60%; background-color:lightgray;'>";
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
							if($qid == '14126' || $qid == '14225'){
                                                        	echo "<input type=text size=20 maxlength=10 minlength=10 onkeypress='return isNumber(event)' style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;'
placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
                                                        }
                                                       else if($qid == '14125')
						       {
                                                            echo "<input type=text size=20 onkeypress='return isNotNumber(event)' style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;'
placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
                                                        }

							else if($qid == '14127' || $qid == '14226')
							{
								echo "<input type=email style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Type here' required  name=q$qid id=q$qid value='$str'>";
								echo "<br>";
								//echo "<span id='14127e'></span>";
								//echo "<span id='14226e'></span>";
								//echo "<span id='result'></span>";

							}
							else if($qid==14217)
							{
								//DD
								echo "<div style='margin-left:25px; height:40px;'><select name='dd' id='dd' style='height:40px;font-size:16px;' required>";
								echo "<option value='' required> DD </option>";
								for($d=1; $d < 32 ; $d++)
								{
									echo "<option> $d </option>";
								}
								echo "</select>";
								
								//MM
								echo "<select name='mm' id='mm' style='height:40px;font-size:16px;' required>";
								echo "<option value='' required> MM </option>";
								for($m=1; $m < 13 ; $m++)
								{
									echo "<option> $m </option>";
								}
								echo "</select>";
								
								//YY
								echo "<select name='yy' id='yy' style='height:40px;font-size:16px;' required>";
								echo "<option value='' required> YY </option>";
								for($y=1990; $y < 2019 ; $y++)
								{
									echo "<option> $y </option>";
								}
								echo "</select> <span id='age'  style='height:40px;font-size:18px;'></span> </div>";
								
							} //end of if
							else
							{
							echo "<input type=text style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
							}
					   }
					   if($qtype=='textarea')
					   { 
                                                        echo "<tr><td style='height:60%; background-color:lightgray;'>";
							$qterm='';$str='';
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $str=$rss2->first()->$qterm;}
							else $str=".";

							echo "<input type=hidden name=qid[] value=$qid>";
							echo "<div style='float:left; width:75%;'><textarea id=q$qid name=text$qid cols=150 rows=5 >'$str'</textarea></div>";
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
	<!--  <input type='submit' name='back' value="&#8249;Back" class="previous round" style="padding: 8px 16px;display: inline-block;" >
	--> 
     <?php } ?>
	  
	 <center><span style='color:red; font-size:16px;' id='showError'></span></center>
<!-- onclick='return Validate();' -->
	  <input type='submit' id='btn' name='next' value="Next" class="next" onclick='return  Validate();' style='background-color:#004c00;color:white;height:35px; margin-left:50%; float:center; padding: 8px 16px;display: inline-block;'><br><br> 
	    
	  <?php } ?>
	 
	                                
	  </div>
	        
	 <input type='hidden' id='temp'>
	</form>

</td></tr></table>
<div class="copyright" style="font-size:11px;bottom:0;position:fixed;  background-color:gray;color:white;width:100%;"><p style="float:center;" &copy; 2018 VareniaCIMS Private Limited. All Rights Reserved.</p></div>
	</body>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
	  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type = "text/javascript" >
history.pushState(null, null, 'http://localhost/digiamin-web/survey/fpn_234.php');
window.addEventListener('popstate', function(event) {
history.pushState(null, null, 'http://localhost/digiamin-web/survey/fpn_234.php');
});
</script>

	<script type="text/javascript">
	function Validate() 
	{
	
	var jArray= <?php echo json_encode($qlist); ?>;
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
	       //document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
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
		       //document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';
		       }
	     	}
	        if (et == 'text' || et=='textarea') 
	        {   
			//alert(qq); 
	              if(document.getElementById(qq).value=='')  
	              {
			//alert('text');
	              elm+='e';
	              error++; flag=1; 
	              document.getElementById(elm).innerHTML = ' [ Error! Please type your response!! ]';
	              //document.getElementById('err').innerHTML = 'Error! Please refill the above left blank responses to proceed...';     
	              } 
	              else
	              {
	                elm+='e';       
	                document.getElementById(elm).innerHTML = '';
	              } 
	         }  
	    }
	  //alert('ctr:'+ctr+'- err:'+error+'-flag:'+flag);
	    if(error == 0 && flag == 0)
	    { 
		return true;
	     }
	    if(error>0 || flag>=1)
	    { 
		flag=0; window.stop();
		return false;
	    }
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

</script>

<!-- ========= Get input field on other option(14114) college location1 ========= -->
<script>
$(document).ready(function() {
    $("input[name$='q14114']").click(function()
	{
        var test = $(this).val();

        $("input.collegeOtherCity1").hide();
		$("#collegeOtherCity1_" + test).show(); //show dynamic here
		
		if(test==6)
		{
			document.getElementById('collegeOtherCity1_6').required=true;
		}
		
		else
		{
			document.getElementById('collegeOtherCity1_6').required=false;
			document.getElementById('collegeOtherCity1_6').value='';
		}
	
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14117) college location2 ========= -->
<script>
$(document).ready(function() {
    $("input[name$='q14117']").click(function()
	{
        var test = $(this).val();

        $("input.collegeOtherCity2").hide();
		$("#collegeOtherCity2_" + test).show(); //show dynamic here
		
		if(test==6)
		{
			document.getElementById('collegeOtherCity2_6').required=true;
		}
		
		else
		{
			document.getElementById('collegeOtherCity2_6').required=false;
			document.getElementById('collegeOtherCity2_6').value='';
		}
	
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14120) college location2 ========= -->
<script>
$(document).ready(function() {
    $("input[name$='q14120']").click(function()
	{
        var test = $(this).val();

        $("input.collegeOtherCity3").hide();
		$("#collegeOtherCity3_" + test).show(); //show dynamic here
		
		if(test==6)
		{
			document.getElementById('collegeOtherCity3_6').required=true;
		}
		
		else
		{
			document.getElementById('collegeOtherCity3_6').required=false;
			document.getElementById('collegeOtherCity3_6').value='';
		}
	
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14103) other school ========= -->
<script>
//show hide on radio button
$(document).ready(function() {
    $("input[name$='q14103']").click(function()
	{
        var test = $(this).val();

        $("input.sch").hide();
        $("#sch_input").show(); //show static here
		$("#sch_input" + test).show(); //show dynamic here
		
		if(test==8)
		{
			document.getElementById("sch_input8").required=true;
		}
		
		else
		{
			document.getElementById("sch_input8").required=false;
			document.getElementById("sch_input8").value='';
		}
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(q14781) other school ========= -->
<script>
//show hide on radio button
$(document).ready(function() {
    $("input[name$='q14781']").click(function()
	{
        var test = $(this).val();

        $("input.sch").hide();
        $("#sch_input").show(); //show static here
		$("#sch_input" + test).show(); //show dynamic here
		
		if(test == 20)
		{
			document.getElementById("sch_input20").required=true;
		}
		
		else
		{
			document.getElementById("sch_input20").required=false;
			document.getElementById("sch_input20").value='';
		}
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14110) other school ========= -->
<script>
//show hide on radio button
$(document).ready(function() 
{
    $("input[name$='q14110']").click(function()
	{
        var test = $(this).val();

        $("input.outInd").hide();
		$("#outInd" + test).show(); //show dynamic here
		
		if(test==2)
		{
			document.getElementById("outInd2").required=true;
		}
		
		else
		{
			document.getElementById("outInd2").required=false;
			document.getElementById("outInd2").value='';
		}
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14219) other current city ========= -->
<script>
//show hide on radio button
$(document).ready(function() 
{
    $("input[name$='q14219']").click(function()
	{
        var test = $(this).val();

        $("input.ocity3").hide();
		$("#ocity" + test).show(); //show dynamic here
		
		if(test==4)
		{
			document.getElementById("ocity4").required=true;
		}
		
		else
		{
			document.getElementById("ocity4").required=false;
			document.getElementById("ocity4").value='';
		}
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14222) other permanent city ========= -->
<script>
//show hide on radio button
$(document).ready(function() 
{
    $("input[name$='q14222']").click(function()
	{
        var test = $(this).val();

        $("input.opcity").hide();
		$("#opcity" + test).show(); //show dynamic here
		
		if(test==4)
		{
			document.getElementById("opcity4").required=true;
		}
		
		else
		{
			document.getElementById("opcity4").required=false;
			document.getElementById("opcity4").value='';
		}
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other subject(1405) ========= -->
<script>
//show hide on radio button
$(document).ready(function() 
{
    $("input[name$='q14105']").click(function()
	{
        var test2 = $(this).val();
		

        $("div.course").hide();
		$("#course_opt" + test2).show(); //show dynamic here
		
		if(test2 == 4)
		{
			document.getElementById('osubj').style.display="inline-block";
			document.getElementById('osubj').required=true;
		}
		
		if(test2 != 4)
		{
			document.getElementById('osubj').style.display="none";
			document.getElementById('osubj').required=false;
			document.getElementById('osubj').value='';
		}
				
		if(test2!=1)
		{
			var s1 = document.getElementById('subj1').checked=false;
			var s2 = document.getElementById('subj2').checked=false;
			var s3 = document.getElementById('subj3').checked=false;
			var s4 = document.getElementById('subj4').checked=false;
			document.getElementById('os').style.display="none";
			document.getElementById("os").required=false;
			document.getElementById("os").value='';
		}
				
    });
});

</script>
<!-- ========= // ========= -->

<!-- ==If click on other subject checkbox ===-->
<script>
$(".oth_sub").click(function()
 {
    if($(this).is(":checked")) 
	{
        $(".os").show();
		document.getElementById("os").required=true;
    } 
	
	else 
	{
        $(".os").hide();
		document.getElementById("os").required=false;
		document.getElementById("os").value='';
    }
});
</script>
<!-- == End of If click on other subject checkbox ===-->


<!-- ========= Course Choices ========= -->
<script>
//show hide on radio button
$(document).ready(function() 
{
    $("input[name$='q14109']").click(function()
	{
        var test = $(this).val();
		

        $("div.choices").hide();
        $("#course_choice" + test).show();
		
		// ****** hide, none, required, reset values *******
		
		//////// // if radio value is 1 //////////
		if(test==1) 
		{
			document.getElementById("sel1a").required=true;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			
			// select dropdown required false
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 1 ////
		
		//////// // if radio value is 2 //////////
		if(test==2) 
		{
			document.getElementById("sel2a").required=true;
			document.getElementById("sel2b").required=true;
			document.getElementById("sel2c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 2 ////
		
		//////// // if radio value is 4 //////////
		if(test==4) 
		{
			document.getElementById("sel4a").required=true;
			document.getElementById("sel4b").required=true;
			document.getElementById("sel4c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			// document.getElementById("sel20b").value = '';
			// document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 4 ////
		
		//////// // if radio value is 9 //////////
		if(test==9) 
		{
			document.getElementById("sel9a").required=true;
			document.getElementById("sel9b").required=true;
			document.getElementById("sel9c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			document.getElementById("sel20b").required=false;
			document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 9 ////
		
		/////// // if radio value is 14 //////////
		if(test==14) 
		{
			document.getElementById("sel14a").required=true;
			document.getElementById("sel14b").required=true;
			document.getElementById("sel14c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 14 ////
		
		//////// // if radio value is 15 //////////
		if(test==15) 
		{
			document.getElementById("sel15a").required=true;
			document.getElementById("sel15b").required=true;
			document.getElementById("sel15c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 15 ////
		
		//////// // if radio value is 16 //////////
		if(test==16) 
		{
			document.getElementById("sel16a").required=true;
			document.getElementById("sel16b").required=true;
			document.getElementById("sel16c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 16 ////
		
		//////// // if radio value is 17 //////////
		if(test==17) 
		{
			document.getElementById("sel17a").required=true;
			document.getElementById("sel17b").required=true;
			document.getElementById("sel17c").required=true;
			document.getElementById("sel17d").required=true;
			document.getElementById("sel17e").required=true;
			document.getElementById("sel17f").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 17 ////
		
		//////// // if radio value is 18 //////////
		if(test==18) 
		{
			document.getElementById("sel18a").required=true;
			document.getElementById("sel18b").required=true;
			document.getElementById("sel18c").required=true;
			document.getElementById("sel18d").required=true;
			document.getElementById("sel18e").required=true;
			document.getElementById("sel18f").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 18 ////
		
		//////// // if radio value is 19 //////////
		if(test==19) 
		{
			document.getElementById("sel19a").required=true;
			document.getElementById("sel19b").required=true;
			document.getElementById("sel19c").required=true;
			document.getElementById("sel19d").required=true;
			document.getElementById("sel19e").required=true;
			document.getElementById("sel19f").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20b").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("sel20a").required=false;
			// document.getElementById("sel20b").required=false;
			// document.getElementById("sel20c").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
       
        }
		// end of if radio value is 19 ////
		
			//////// // if radio value is 20 //////////
		if(test==20) 
		{
			document.getElementById("sel20a").required=true;
			// document.getElementById("sel20b").required=true;
			// document.getElementById("sel20c").required=true;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';       
        }
		// end of if radio value is 20 ////
		
		// now else
			
		if(test==3 || test==5 || test==6 || test==7 || test==8 || test==10 || test==11 || test==12 || test==13)
		{
			document.getElementById("sel20a").required=false;
			document.getElementById("sel20b").required=false;
			document.getElementById("sel20c").required=false;
			
			// select dropdown required false
			document.getElementById("sel1a").required=false;
			document.getElementById("sel1b").required=false;
			document.getElementById("sel1c").required=false;
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			document.getElementById("sel4a").required=false;
			document.getElementById("sel4b").required=false;
			document.getElementById("sel4c").required=false;
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			document.getElementById("sel14a").required=false;
			document.getElementById("sel14b").required=false;
			document.getElementById("sel14c").required=false;
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			document.getElementById("sel16a").required=false;
			document.getElementById("sel16b").required=false;
			document.getElementById("sel16c").required=false;
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			document.getElementById("sel17d").required=false;
			document.getElementById("sel17e").required=false;
			document.getElementById("sel17f").required=false;
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			document.getElementById("sel18d").required=false;
			document.getElementById("sel18e").required=false;
			document.getElementById("sel18f").required=false;
			document.getElementById("sel19a").required=false;
			document.getElementById("sel19b").required=false;
			document.getElementById("sel19c").required=false;
			document.getElementById("sel19d").required=false;
			document.getElementById("sel19e").required=false;
			document.getElementById("sel19f").required=false;
			
			// other input required false
			document.getElementById("1ao").required=false;
			document.getElementById("1bo").required=false;
			document.getElementById("1co").required=false;
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			document.getElementById("4ao").required=false;
			document.getElementById("4bo").required=false;
			document.getElementById("4co").required=false;
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			document.getElementById("14ao").required=false;
			document.getElementById("14bo").required=false;
			document.getElementById("14co").required=false;
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			document.getElementById("16ao").required=false;
			document.getElementById("16bo").required=false;
			document.getElementById("16co").required=false;
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			document.getElementById("17do").required=false;
			document.getElementById("17eo").required=false;
			document.getElementById("17fo").required=false;
			document.getElementById("18ao").required=false;
			document.getElementById("18bo").required=false;
			document.getElementById("18co").required=false;
			document.getElementById("18do").required=false;
			document.getElementById("18eo").required=false;
			document.getElementById("18fo").required=false;
			document.getElementById("19ao").required=false;
			document.getElementById("19bo").required=false;
			document.getElementById("19co").required=false;
			document.getElementById("19do").required=false;
			document.getElementById("19eo").required=false;
			document.getElementById("19fo").required=false;
			
			// do select dropdown value blank
            document.getElementById("sel1a").selectedIndex = '';
            document.getElementById("sel1b").selectedIndex = '';
            document.getElementById("sel1c").selectedIndex = '';
			document.getElementById("sel2a").selectedIndex = '';
			document.getElementById("sel2b").selectedIndex = '';
			document.getElementById("sel2c").selectedIndex = '';
			document.getElementById("sel4a").selectedIndex = '';
			document.getElementById("sel4b").selectedIndex = '';
			document.getElementById("sel4c").selectedIndex = '';
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			document.getElementById("sel14a").selectedIndex = '';
			document.getElementById("sel14b").selectedIndex = '';
			document.getElementById("sel14c").selectedIndex = '';
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			document.getElementById("sel16a").selectedIndex = '';
			document.getElementById("sel16b").selectedIndex = '';
			document.getElementById("sel16c").selectedIndex = '';
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			document.getElementById("sel17d").selectedIndex = '';
			document.getElementById("sel17e").selectedIndex = '';
			document.getElementById("sel17f").selectedIndex = '';
			document.getElementById("sel18a").selectedIndex = '';
			document.getElementById("sel18b").selectedIndex = '';
			document.getElementById("sel18c").selectedIndex = '';
			document.getElementById("sel18d").selectedIndex = '';
			document.getElementById("sel18e").selectedIndex = '';
			document.getElementById("sel18f").selectedIndex = '';
			document.getElementById("sel19a").selectedIndex = '';
			document.getElementById("sel19b").selectedIndex = '';
			document.getElementById("sel19c").selectedIndex = '';
			document.getElementById("sel19d").selectedIndex = '';
			document.getElementById("sel19e").selectedIndex = '';
			document.getElementById("sel19f").selectedIndex = '';
			
			// do other input field value blank
			document.getElementById("1ao").style.display = "none";
			document.getElementById("1bo").style.display = "none";
			document.getElementById("1co").style.display = "none";
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			document.getElementById("4ao").style.display = "none";
			document.getElementById("4bo").style.display = "none";
			document.getElementById("4co").style.display = "none";
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			document.getElementById("14ao").style.display = "none";
			document.getElementById("14bo").style.display = "none";
			document.getElementById("14co").style.display = "none";
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			document.getElementById("16ao").style.display = "none";
			document.getElementById("16bo").style.display = "none";
			document.getElementById("16co").style.display = "none";
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			document.getElementById("17do").style.display = "none";
			document.getElementById("17eo").style.display = "none";
			document.getElementById("17fo").style.display = "none";
			document.getElementById("18ao").style.display = "none";
			document.getElementById("18bo").style.display = "none";
			document.getElementById("18co").style.display = "none";
			document.getElementById("18do").style.display = "none";
			document.getElementById("18eo").style.display = "none";
			document.getElementById("18fo").style.display = "none";
			document.getElementById("19ao").style.display = "none";
			document.getElementById("19bo").style.display = "none";
			document.getElementById("19co").style.display = "none";
			document.getElementById("19do").style.display = "none";
			document.getElementById("19eo").style.display = "none";
			document.getElementById("19fo").style.display = "none";
			
			
			// do other input values blank
			document.getElementById("1ao").value = '';
			document.getElementById("1bo").value = '';
			document.getElementById("1co").value = '';
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			document.getElementById("4ao").value = '';
			document.getElementById("4bo").value = '';
			document.getElementById("4co").value = '';
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			document.getElementById("14ao").value = '';
			document.getElementById("14bo").value = '';
			document.getElementById("14co").value = '';
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			document.getElementById("16ao").value = '';
			document.getElementById("16bo").value = '';
			document.getElementById("16co").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			document.getElementById("17do").value = '';
			document.getElementById("17eo").value = '';
			document.getElementById("17fo").value = '';
			document.getElementById("18ao").value = '';
			document.getElementById("18bo").value = '';
			document.getElementById("18co").value = '';
			document.getElementById("18do").value = '';
			document.getElementById("18eo").value = '';
			document.getElementById("18fo").value = '';
			document.getElementById("19ao").value = '';
			document.getElementById("19bo").value = '';
			document.getElementById("19co").value = '';
			document.getElementById("19do").value = '';
			document.getElementById("19eo").value = '';
			document.getElementById("19fo").value = '';  
			document.getElementById("sel20a").value = '';
			document.getElementById("sel20b").value = '';
			document.getElementById("sel20c").value = '';
		}
		
		// ****** //hide, none, required, reset values *******
		
    });
});
</script>

<!-- Couse Choices Select Hide Show -->
<script>
// ********** 1st choice input hide show **********//
// 1st
function sel1_a(s1_a)
{
	if(s1_a==10)
	{
		$('#1ao').show('fast');
		document.getElementById("1ao").required=true;
	}
	else
	{
		$('#1ao').hide('fast');
		document.getElementById("1ao").required=false;
	}
}

// 2nd
function sel1_b(s1_b)
{
	if(s1_b==10)
	{
		$('#1bo').show('fast');
		document.getElementById("1bo").required=true;
	}
	else
	{
		$('#1bo').hide('fast');
		document.getElementById("1bo").required=false;
	}
}

// 3rd
function sel1_c(s1_c)
{
	if(s1_c==10)
	{
		$('#1co').show('fast');
		document.getElementById("1co").required=true;
	}
	else
	{
		$('#1co').hide('fast');
		document.getElementById("1co").required=false;
	}
}
// ************ End of 1st choices options ****************//

// ********** 2nd choice input hide show **********//
// 1st
function sel2_a(s2_a)
{
	if(s2_a==3)
	{
		$('#2ao').show('fast');
		document.getElementById("2ao").required=true;
	}
	else
	{
		$('#2ao').hide('fast');
		document.getElementById("2ao").required=false;
	}
}

// 2nd
function sel2_b(s2_b)
{
	if(s2_b==3)
	{
		$('#2bo').show('fast');
		document.getElementById("2bo").required=true;
	}
	else
	{
		$('#2bo').hide('fast');
		document.getElementById("2bo").required=false;
	}
}

// 3rd
function sel2_c(s2_c)
{
	if(s2_c==3)
	{
		$('#2co').show('fast');
		document.getElementById("2co").required=true;
	}
	else
	{
		$('#2co').hide('fast');
		document.getElementById("2co").required=false;
	}
}
// ************ End of 2nd choices options ****************//

// ********** 4th choice input hide show **********//
// 1st
function sel4_a(s4_a)
{
	if(s4_a==3)
	{
		$('#4ao').show('fast');
		document.getElementById("4ao").required=true;
	}
	else
	{
		$('#4ao').hide('fast');
		document.getElementById("4ao").required=false;
	}
}

// 2nd
function sel4_b(s4_b)
{
	if(s4_b==3)
	{
		$('#4bo').show('fast');
		document.getElementById("4bo").required=true;
	}
	else
	{
		$('#4bo').hide('fast');
		document.getElementById("4bo").required=false;
	}
}

// 3rd
function sel4_c(s4_c)
{
	if(s4_c==3)
	{
		$('#4co').show('fast');
		document.getElementById("4co").required=true;
	}
	else
	{
		$('#4co').hide('fast');
		document.getElementById("4co").required=false;
	}
}
// ************ End of 4th choices options ****************//

// ********** 9th choice input hide show **********//
// 1st
function sel9_a(s9_a)
{
	if(s9_a==10)
	{
		$('#9ao').show('fast');
		document.getElementById("9ao").required=true;
	}
	else
	{
		$('#9ao').hide('fast');
		document.getElementById("9ao").required=false;
	}
}

// 2nd
function sel9_b(s9_b)
{
	if(s9_b==10)
	{
		$('#9bo').show('fast');
		document.getElementById("9bo").required=true;
	}
	else
	{
		$('#9bo').hide('fast');
		document.getElementById("9bo").required=false;
	}
}

// 3rd
function sel9_c(s9_c)
{
	if(s9_c==10)
	{
		$('#9co').show('fast');
		document.getElementById("9co").required=true;
	}
	else
	{
		$('#9co').hide('fast');
		document.getElementById("9co").required=false;
	}
}
// ************ End of 9th choices options ****************//

// ********** 14th choice input hide show **********//
// 1st
function sel14_a(s14_a)
{
	if(s14_a==14)
	{
		$('#14ao').show('fast');
		document.getElementById("14ao").required=true;
	}
	else
	{
		$('#14ao').hide('fast');
		document.getElementById("14ao").required=false;
	}
}

// 2nd
function sel14_b(s14_b)
{
	if(s14_b==14)
	{
		$('#14bo').show('fast');
		document.getElementById("14bo").required=true;
	}
	else
	{
		$('#14bo').hide('fast');
		document.getElementById("14bo").required=false;
	}
}

// 3rd
function sel14_c(s14_c)
{
	if(s14_c==14)
	{
		$('#14co').show('fast');
		document.getElementById("14co").required=true;
	}
	else
	{
		$('#14co').hide('fast');
		document.getElementById("14co").required=false;
	}
}
// ************ End of 14th choices options ****************//

// ********** 15th choice input hide show **********//
// 1st
function sel15_a(s15_a)
{
	if(s15_a==6)
	{
		$('#15ao').show('fast');
		document.getElementById("15ao").required=true;
	}
	else
	{
		$('#15ao').hide('fast');
		document.getElementById("15ao").required=false;
	}
}

// 2nd
function sel15_b(s15_b)
{
	if(s15_b==6)
	{
		$('#15bo').show('fast');
		document.getElementById("15bo").required=true;
	}
	else
	{
		$('#15bo').hide('fast');
		document.getElementById("15bo").required=false;
	}
}

// 3rd
function sel15_c(s15_c)
{
	if(s15_c==6)
	{
		$('#15co').show('fast');
		document.getElementById("15co").required=true;
	}
	else
	{
		$('#15co').hide('fast');
		document.getElementById("15co").required=false;
	}
}
// ************ End of 15th choices options ****************//

// ********** 16th choice input hide show **********//
// 1st
function sel16_a(s16_a)
{
	if(s16_a==10)
	{
		$('#16ao').show('fast');
		document.getElementById("16ao").required=true;
	}
	else
	{
		$('#16ao').hide('fast');
		document.getElementById("16ao").required=false;
	}
}

// 2nd
function sel16_b(s16_b)
{
	if(s16_b==10)
	{
		$('#16bo').show('fast');
		document.getElementById("16bo").required=true;
	}
	else
	{
		$('#16bo').hide('fast');
		document.getElementById("16bo").required=false;
	}
}

// 3rd
function sel16_c(s16_c)
{
	if(s16_c==10)
	{
		$('#16co').show('fast');
		document.getElementById("16co").required=true;
	}
	else
	{
		$('#16co').hide('fast');
		document.getElementById("16co").required=false;
	}
}
// ************ End of 16th choices options ****************//

// ********** 17th choice input hide show **********//
// 1st
function sel17_a(s17_a)
{
	if(s17_a==3)
	{
		$('#17ao').show('fast');
		document.getElementById("17ao").required=true;
	}
	else
	{
		$('#17ao').hide('fast');
		document.getElementById("17ao").required=false;
	}
}

// 2nd
function sel17_b(s17_b)
{
	if(s17_b==3)
	{
		$('#17bo').show('fast');
		document.getElementById("17bo").required=true;
	}
	else
	{
		$('#17bo').hide('fast');
		document.getElementById("17bo").required=false;
	}
}

// 3rd
function sel17_c(s17_c)
{
	if(s17_c==3)
	{
		$('#17co').show('fast');
		document.getElementById("17co").required=true;
	}
	else
	{
		$('#17co').hide('fast');
		document.getElementById("17co").required=false;
	}
}

// 4th
function sel17_d(s17_d)
{
	if(s17_d==5)
	{
		$('#17do').show('fast');
		document.getElementById("17do").required=true;
	}
	else
	{
		$('#17do').hide('fast');
		document.getElementById("17do").required=false;
	}
}

// 5th
function sel17_e(s17_e)
{
	if(s17_e==5)
	{
		$('#17eo').show('fast');
		document.getElementById("17eo").required=true;
	}
	else
	{
		$('#17eo').hide('fast');
		document.getElementById("17eo").required=false;
	}
}

function sel17_f(s17_f)
{
	if(s17_f==5)
	{
		$('#17fo').show('fast');
		document.getElementById("17fo").required=true;
	}
	else
	{
		$('#17fo').hide('fast');
		document.getElementById("17fo").required=false;
	}
}

// ************ End of 17th choices options ****************//

// ********** 18th choice input hide show **********//
// 1st
function sel18_a(s18_a)
{
	if(s18_a==10)
	{
		$('#18ao').show('fast');
		document.getElementById("18ao").required=true;
	}
	else
	{
		$('#18ao').hide('fast');
		document.getElementById("18ao").required=false;
	}
}

// 2nd
function sel18_b(s18_b)
{
	if(s18_b==10)
	{
		$('#18bo').show('fast');
		document.getElementById("18bo").required=true;
	}
	else
	{
		$('#18bo').hide('fast');
		document.getElementById("18bo").required=false;
	}
}

// 3rd
function sel18_c(s18_c)
{
	if(s18_c==10)
	{
		$('#18co').show('fast');
		document.getElementById("18co").required=true;
	}
	else
	{
		$('#18co').hide('fast');
		document.getElementById("18co").required=false;
	}
}

// 4th
function sel18_d(s18_d)
{
	if(s18_d==5)
	{
		$('#18do').show('fast');
		document.getElementById("18do").required=true;
	}
	else
	{
		$('#18do').hide('fast');
		document.getElementById("18do").required=false;
	}
}

// 5th
function sel18_e(s18_e)
{
	if(s18_e==5)
	{
		$('#18eo').show('fast');
		document.getElementById("18eo").required=true;
	}
	else
	{
		$('#18eo').hide('fast');
		document.getElementById("18eo").required=false;
	}
}

// 6th
function sel18_f(s18_f)
{
	if(s18_f==5)
	{
		$('#18fo').show('fast');
		document.getElementById("18fo").required=true;
	}
	else
	{
		$('#18fo').hide('fast');
		document.getElementById("18fo").required=false;
	}
}

// ************ End of 18th choices options ****************//

// ********** 19th choice input hide show **********//
// 1st
function sel19_a(s19_a)
{
	if(s19_a==10)
	{
		$('#19ao').show('fast');
		document.getElementById("19ao").required=true;
	}
	else
	{
		$('#19ao').hide('fast');
		document.getElementById("19ao").required=false;
	}
}

// 2nd
function sel19_b(s19_b)
{
	if(s19_b==10)
	{
		$('#19bo').show('fast');
		document.getElementById("19bo").required=true;
	}
	else
	{
		$('#19bo').hide('fast');
		document.getElementById("19bo").required=false;
	}
}

// 3rd
function sel19_c(s19_c)
{
	if(s19_c==10)
	{
		$('#19co').show('fast');
		document.getElementById("19co").required=true;
	}
	else
	{
		$('#19co').hide('fast');
		document.getElementById("19co").required=false;
	}
}

// 4th
function sel19_d(s19_d)
{
	if(s19_d==10)
	{
		$('#19do').show('fast');
		document.getElementById("19do").required=true;
	}
	else
	{
		$('#19do').hide('fast');
		document.getElementById("19do").required=false;
	}
}

// 5th
function sel19_e(s19_e)
{
	if(s19_e==10)
	{
		$('#19eo').show('fast');
		document.getElementById("19eo").required=true;
	}
	else
	{
		$('#19eo').hide('fast');
		document.getElementById("19eo").required=false;
	}
}

// 6th
function sel19_f(s19_f)
{
	if(s19_f==10)
	{
		$('#19fo').show('fast');
		document.getElementById("19fo").required=true;
	}
	else
	{
		$('#19fo').hide('fast');
		document.getElementById("19fo").required=false;
	}
}

// ************ End of 19th choices options ****************//
</script>
<!-- //Course Choices Select Hide Show -->
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
<!-- age calculation -->
<script type="text/javascript"> 
			$(document).ready(function() 
			{
					var age = document.getElementById('age');
					
					var yy = document.getElementById("yy");
					
					$('#yy').change(function()
					{
					 var birthdate = new Date(yy.value);
					 var cur = new Date();
					 var diff = cur-birthdate;
					 var yourAge = Math.floor(diff/31536000000);
					   age.innerHTML = 'Your Age is:' + yourAge;
					});
			 });
</script>

<script type="text/javascript">
 $(document).ready(function()
 {
    $('input.email').change(function(){
	
		//var er='';
    //var email = document.getElementById('q14127');
    //var emailv = document.getElementById('q14127').value;
	//var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	alert('Invalid email');

    });

 });
</script>

<script type="text/javascript">
// radio validation

    $('#btn').click(function() 
	{
	
	var qlist= <?php echo json_encode($qlist); ?>; //1st page array
	//alert('qlist=' + qlist);
	
	////////////////////////////////////// 14103 & 14105 ////////////////////////////////
	if(qlist.some(item => item == '14103') && qlist.some(item => item == '14105') && qlist.some(item => item != '14109'))
	{
	
		var checked_14103 = $("input[name=q14103]:checked").length;
		
		if(checked_14103>0)
		{
			return true;
		}
		
		else
		{
			return false;
		}
		
	}
	
	////////////////////////////////////// 14105 ////////////////////////////////
	if(qlist.some(item => item == '14215') && qlist.some(item => item == '14216') && qlist.some(item => item == '14106'))
	{
	
		var checked_14105 = $("input[name=q14105]:checked").length;
		
		var science = document.getElementById("q14105").value;
		 
		var count_checked = $("[name='q14215[]']:checked").length;
		
		if(document.getElementById("q14105").checked && count_checked==0)
		{
			document.getElementById('14105e').innerHTML='Kindly Select atleast one Checkbox!';
			return false;
		}		
			
		if(checked_14105>0)
		{
			return true;
		}
		
		else
		{
			return false;
		}
		
	}
	
	/////////////////////////////// 14108 && 14109 //////////////////////////
	if(qlist.some(item => item == '14108') && qlist.some(item => item == '14109') && qlist.some(item => item != '14103'))
	{
		var checked_14108 = $("input[name=q14108]:checked").length;	
		var checked_14109 = $("input[name=q14109]:checked").length;	
		
		if(checked_14108>0 && checked_14109>0)
		{
			document.getElementById('14109e').innerHTML='Error!! Kindly Select Option';
			return true;
		}
		
		else
		{
			return false;
		}
		
		
	}
	
	/////////////////////////////// 14108 && 14109 //////////////////////////
	if(qlist.some(item => item == '14110') && qlist.some(item => item != '14103'))
	{
		var checked_14110 = $("input[name=q14110]:checked").length;	
		
		if(checked_14110>0)
		{
			return true;
		}
		
		else
		{
			return false;
		}
	}
	
	/////////////////////////////// 14114 && 14117 && 14120 //////////////////////////
	if(qlist.some(item => item == '14114') && qlist.some(item => item == '14117') && qlist.some(item => item == '14120') && qlist.some(item => item != '14103'))
	{
		var checked_14114 = $("input[name=q14114]:checked").length;	
		var checked_14117 = $("input[name=q14117]:checked").length;	
		var checked_14120 = $("input[name=q14120]:checked").length;	
			
		
		if(checked_14114>0 && checked_14117>0 && checked_14120>0)
		{
			
			return true;
		}
		
		else
		{
			document.getElementById('14114e').innerHTML='Error! Enter college & select city';
			return false;
		}
	}
	
	/////////////////////////////// 14123 && 14125 //////////////////////////
	if(qlist.some(item => item == '14123') && qlist.some(item => item == '14125'))
	{
		var checked_14123 = $("input[name=q14123]:checked").length;	
		var text_14125 = document.getElementById('q14125').value;
		
		if(checked_14123>0 && text_14125!='')
		{
			return true;
		}
		
		else
		{
			return false;
		}
	}
	
	/////////////////////////////// 14131 && 14126 //////////////////////////
	if(qlist.some(item => item == '14126') && qlist.some(item => item == '14131'))
	{
		var checked_14131 = $("input[name=q14131]:checked").length;	
		var text_14126 = document.getElementById('q14126').value;
		var text_14127 = document.getElementById('q14127').value;
		
		
		if(checked_14131==0 && text_14126=='')
		{
			//document.getElementById('14127e').innerHTML='Error! Enter father email';
			return false;
		}
		
		if(text_14127=='')
		{
			document.getElementById("14127e").innerHTML="Error! Enter father's email";
			return false;
		}
		
		else
		{
			return true;
		}
	}
	
	/////////////////////////////// 14132 //////////////////////////
	if(qlist.some(item => item == '14132'))
	{
		var checked_14132 = $("input[name=q14132]:checked").length;	
		
		if(checked_14132==0)
		{
			return false;
		}
		
		else
		{
			return true;
		}
	}
	
	/////////////////////////////// 14219 //////////////////////////
	//if(qlist.some(item => item == '14218') && qlist.some(item => item == '14219'))
	if(qlist.some(item => item == '14219'))
	{
		//var checked_14218 = $("input[name=q14218]:checked").length;	
		var checked_14219 = $("input[name=q14219]:checked").length;	
		
		//if(checked_14218==0 && checked_14219==0)
		if(checked_14219==0)
		{
			document.getElementById('14219e').innerHTML='Error! Enter address & select city';
			return false;
		}
		
		else
		{
			document.getElementById('14219e').innerHTML='';
			return true;
		}
	}
	
	if(qlist.some(item => item == '14222'))
	{	
		var checked_14222 = $("input[name=q14222]:checked").length;	
		
		//if(checked_14218==0 && checked_14219==0)
		if(checked_14222==0)
		{
			document.getElementById('14222e').innerHTML='Error! Enter address & select city';
			return false;
		}
		
		else
		{
			document.getElementById('14222e').innerHTML='';
			return true;
		}
	}
	
	/////////////////////////////// 14775 //////////////////////////
	if(qlist.some(item => item == '14775'))
	{
		var checked_14775 = $("input[name=q14775]:checked").length;	
		
		if(checked_14775==0)
		{
			return false;
		}
		
		else
		{
			return true;
		}
	}
	
	/////////////////////////////// 14224 //////////////////////////
	if(qlist.some(item => item == '14224'))
	{
		var checked_14224 = $("input[name=q14224]:checked").length;	
		
		if(checked_14224==0)
		{
			return false;
		}
		
		else
		{
			return true;
		}
	}
	
	/////////////////////////////// 14224 //////////////////////////
	if(qlist.some(item => item == '14224'))
	{
		var checked_14224 = $("input[name=q14224]:checked").length;	
		
		if(checked_14224==0)
		{
			return false;
		}
		
		else
		{
			return true;
		}
	}
	
	/////////////////////////////// 14225, 14226, 14133 //////////////////////////
	if(qlist.some(item => item == '14133') && qlist.some(item => item == '14226') || qlist.some(item => item == '14225'))
	{
		var checked_14133 = $("input[name=q14133]:checked").length;	
		var text_14226 = document.getElementById('q14226').value;
		
		if(checked_14133==0 && text_14226=='')
		{
			document.getElementById('14226e').innerHTML='Error! Enter email id';
			return false;
		}
		
		// if(text_14226=='')
		// {
			// document.getElementById('14226e').innerHTML='Error! Enter email id';
			// return false;
		// }
		
		else
		{
			return true;
		}
	}
	
	});

</script>

