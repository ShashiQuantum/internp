<?php
include_once('../vcimsweb/init.php');
include_once('survey-function.php');
 
				$totrt=DB::getInstance()->query("SELECT q_id from question_detail where qset_id=237 and q_type='radio'");
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
                                        echo "<p style='margin-left:25px;font-size:16px;'> $qtle</p><font color=red><span id='$error'></span></font></div>";
                                        echo "<table border='1' cellpadding=0 cellspacing=0 style='padding:30px;width:100%;'>";
					$rspd = get_q_response($table,$resp_id,$qid);
					//if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
					$error=$qid.'e';
                                        //echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td><td></td></tr>";
					$i=0;
					$qid1=14215;$qid2=14216;
					echo "<input type=hidden name='qid[]'  value= $qid1 ><input type=hidden name='qid[]' value= $qid2 >";
					array_push($qlist,$qid1);array_push($qlist,$qid2);
					foreach($arr_qo_val as $ov){
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
						</tr>";
						else{
							echo "<tr> <td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid $str value=$ov> $opt ";
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

			
				//if(in_array('14230',$gqids)){

				//} // end of 14230

					if(in_array('14234',$gqids))
					{
					//$ititle = $arr_temp[ '14105' ]['q_title'];
					$arr_qo=array(array());
					//$qid= $gqids[ 0 ];
					$qid=14234;
					$arr_qo = get_qop($qid,'opt_text_value');
					$arr_qo_val = get_qop($qid,'value');
					//print_r($arr_qo);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
                                        echo "<tr><td colspan=2><p style='margin-left:25px;'> $qtle</p><font color=red><span id='14234e'></span></font> </td></tr>";
                                        echo "<table border='1' cellpadding=0 cellspacing=0 style='padding:30px;width:100%;'>";
					/* echo "<tr><td> </td>";
					foreach($arr_qo as $qo){
						echo "<td style='background-color:lightgray'> $qo  </td>";
					}
					echo "</tr>";
					*/
                                  //for($i=1; $i < count($arr_qo_val); $i++){
                                    //    $qid= $gqids[ $i ];
					//to get REPONDENT qop detail

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
												
						$str='';
						if(!empty($rspd))
						{
							if(in_array($ov,$rspd)) $str=" checked='checked'";
	                    }
						$opt=$arr_qo[ $i ];
						
						echo "<tr><td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid $str value=$ov> $opt ";
						
						// **2nd Options
						if($i == 1) 
						{	
						echo '<div id="course_choice2" class="choices" style="display:none;">';
						
                        echo "<input type=hidden name='qid[]' value='14235'>";
						echo "<select style='margin-left:25px;' id='sel2a' name='q14235' onchange='sel2_a(this.value)'>";
						echo "<option value='' selected>Select 1st choice</option>";
						$subopt2_a = get_qop(14235, 'opt_text_value');
						$i2_a=0;
						foreach($subopt2_a as $so2_a)
						{
							$i2_a++;
							echo "<option value='$i2_a'>$so2_a</option>";
						}
						echo "</select>";
						echo "<input type=hidden name='qid[]' value='14236'>";
						echo "<input type='text' id='2ao' name=q14235 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                        echo "<input type=hidden name='qid[]' value='14237'>";
						echo "<select style='margin-left:25px;' id='sel2b' name=q14237 onchange='sel2_b(this.value)'>";
						echo "<option value='' selected>Select 2nd choice</option>";
						$subopt2_b = get_qop(14237, 'opt_text_value');
						$i2_b=0;
						foreach($subopt2_b as $so2_b)
						{
							$i2_b++;
							echo "<option value='$i2_b'>$so2_b</option>";
						}
						echo "</select>";
						
                        echo "<input type=hidden name='qid[]' value='14238'>";
						echo "<input type='text' id='2bo' name=q14238  placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14139'>";
						echo "<select style='margin-left:25px;' id='sel2c' name=q14239 onchange='sel2_c(this.value)'>";
						echo "<option value='' selected>Select 3rd choice</option>";
						$subopt2_c = get_qop(14239, 'opt_text_value');
						$i2_c=0;
						foreach($subopt2_c as $so2_c)
						{
							$i2_c++;
							echo "<option value='$i2_c'>$so2_c</option>";
						}
						echo "</select>";
						
                                                echo "<input type=hidden name='qid[]' value='14140'>";
						echo "<input type='text' id='2co' name=q14240 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} 
						// ************** end of 1st opt ****************//
						
						// ************** 3rd opt ****************//
						if($i == 2) 
						{	
						echo '<div id="course_choice3" class="choices" style="display:none;">';
						echo "<input type=hidden name='qid[]' value='14241'>";
						echo "<select style='margin-left:25px;' id='sel3a' name='q14241' onchange='sel3_a(this.value)'>";
						echo "<option value='' selected>Select 1st choice</option>";
						$subopt3_a = get_qop(14241, 'opt_text_value');
						$i3_a=0;
						foreach($subopt3_a as $so3_a)
						{
							$i3_a++;
							echo "<option value='$i3_a'>$so3_a</option>";
						}
						echo "</select>";
                         echo "<input type=hidden name='qid[]' value='14242'>";
						echo "<input type='text' id='3ao' name='q14242' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14244'>";
						echo "<select style='margin-left:25px;' id='sel3b' name=q14244 onchange='sel3_b(this.value)'>";
						echo "<option value='' selected>Select 2nd choice</option>";
						$subopt3_b = get_qop(14244, 'opt_text_value');
						$i3_b=0;
						foreach($subopt3_b as $so3_b)
						{
							$i3_b++;
							echo "<option value='$i3_b'>$so3_b</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14245'>";
						echo "<input type='text' id='3bo' name='q1245' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                        echo "<input type=hidden name='qid[]' value='14246'>";
						echo "<select style='margin-left:25px;' id='sel3c' name=q14246 onchange='sel3_c(this.value)'>";
                        echo "<option value='' selected>Select 3rd choice</option>";
						$subopt3_c = get_qop(14246, 'opt_text_value');
						$i3_c=0;
						foreach($subopt3_c as $so3_c)
						{
							$i3_c++;
							echo "<option value='$i3_c'>$so3_c</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14247'>";
						echo "<input type='text' id='3co' name='q14247' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 2nd opt ****************//
												
						// ************** 9th opt ****************//
						if($i == 8) 
						{	
						echo '<div id="course_choice9" class="choices" style="display:none;">';
                        echo "<input type=hidden name='qid[]' value='14248'>";
						echo "<select style='margin-left:25px;' id='sel9a' name='q14248' onchange='sel9_a(this.value)'>";
                        echo "<option value='' selected>Select 1st choice</option>";
						$subopt9_a = get_qop(14248, 'opt_text_value');
						$i9_a=0;
						foreach($subopt9_a as $so9_a)
						{
							$i9_a++;
							echo "<option value='$i9_a'>$so9_a</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14249'>";
						echo "<input type='text' id='9ao' name='q14249' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                        echo "<input type=hidden name='qid[]' value='14250'>";
						echo "<select style='margin-left:25px;' id='sel9b' name='q14250' onchange='sel9_b(this.value)'>";
                       echo "<option value='' selected>Select 2nd choice</option>";
						$subopt9_b = get_qop(14250, 'opt_text_value');
						$i9_b=0;
						foreach($subopt9_b as $so9_b)
						{
							$i9_b++;
							echo "<option value='$i9_b'>$so9_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14251'>";
						echo "<input type='text' id='9bo' name='q14251' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                                                echo "<input type=hidden name='qid[]' value='14252'>";
						echo "<select style='margin-left:25px;' id='sel9c' name='q14252' onchange='sel9_c(this.value)'>";
                                                echo "<option value='' selected>Select 3rd choice</option>";
						$subopt9_c = get_qop(14252, 'opt_text_value');
						$i9_c=0;
						foreach($subopt9_c as $so9_c)
						{
							$i9_c++;
							echo "<option value='$i9_c'>$so9_c</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14253'>";
						echo "<input type='text' id='9co' name='q14253' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 9th opt ****************//
						
							// ************** 11th opt ****************//
						if($i == 10) 
						{	
						echo '<div id="course_choice11" class="choices" style="display:none;">';
                        echo "<input type=hidden name='qid[]' value='14255'>";
						echo "<select style='margin-left:25px;' id='sel11a' name='q14248' onchange='sel11_a(this.value)'>";
                        echo "<option value='' selected>Select 1st choice</option>";
						$subopt11_a = get_qop(14255, 'opt_text_value');
						$i11_a=0;
						foreach($subopt11_a as $so11_a)
						{
							$i11_a++;
							echo "<option value='$i11_a'>$so11_a</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14256'>";
						echo "<input type='text' id='11ao' name='q14256' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                        echo "<input type=hidden name='qid[]' value='14250'>";
						echo "<select style='margin-left:25px;' id='sel11b' name='q14250' onchange='sel11_b(this.value)'>";
                        echo "<option value='' selected>Select 2nd choice</option>";
						$subopt11_b = get_qop(14257, 'opt_text_value');
						$i11_b=0;
						foreach($subopt11_b as $so11_b)
						{
							$i11_b++;
							echo "<option value='$i11_b'>$so11_b</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14258'>";
						echo "<input type='text' id='11bo' name='q14258' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                        echo "<input type=hidden name='qid[]' value='14259'>";
						echo "<select style='margin-left:25px;' id='sel11c' name='q14252' onchange='sel11_c(this.value)'>";
                        echo "<option value='' selected>Select 3rd choice</option>";
						$subopt11_c = get_qop(14259, 'opt_text_value');
						$i11_c=0;
						foreach($subopt11_c as $so11_c)
						{
							$i11_c++;
							echo "<option value='$i11_c'>$so11_c</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14260'>";
						echo "<input type='text' id='11co' name='q14260' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 11th opt ****************//
					
						// ************** 15th opt ****************//
						if($i == 14) 
						{	
						echo '<div id="course_choice15" class="choices" style="display:none;">';
                        echo "<input type=hidden name='qid[]' value='14261'>";
						echo "<select style='margin-left:25px;' id='sel15a' name='q14261' onchange='sel15_a(this.value)'>";
                                                echo "<option value='' selected>Select 1st choice</option>";
						$subopt15_a = get_qop(14261, 'opt_text_value');
						$i15_a=0;
						foreach($subopt15_a as $so15_a)
						{
							$i15_a++;
							echo "<option value='$i15_a'>$so15_a</option>";
						}
						echo "</select>";
                       echo "<input type=hidden name='qid[]' value='14262'>";
						echo "<input type='text' id='15ao' name='q14262' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                        echo "<input type=hidden name='qid[]' value='14263'>";
						echo "<select style='margin-left:25px;' id='sel15b' name='q14263' onchange='sel15_b(this.value)'>";
                        echo "<option value='' selected>Select 2nd choice</option>";
						$subopt15_b = get_qop(14263, 'opt_text_value');
						$i15_b=0;
						foreach($subopt15_b as $so15_b)
						{
							$i15_b++;
							echo "<option value='$i15_b'>$so15_b</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14264'>";
						echo "<input type='text' id='15bo' name='q14264' placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                        echo "<input type=hidden name='qid[]' value='14265'>";
						echo "<select style='margin-left:25px;' id='sel15c' name='q14265' onchange='sel15_c(this.value)'>";
                        echo "<option value='' selected>Select 3rd choice</option>";
						$subopt15_c = get_qop(14265, 'opt_text_value');
						$i15_c=0;
						foreach($subopt15_c as $so15_c)
						{
							$i15_c++;
							echo "<option value='$i15_c'>$so15_c</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14266'>";
						echo "<input type='text' id='15co' name=14266 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 15th opt ****************//
						

						// ************** 17th opt ****************//
						if($i == 16) 
						{	
						echo '<div id="course_choice17" class="choices" style="display:none;">';
						
						// 1st option
                        echo "<input type=hidden name='qid[]' value='14267'>";
						echo "<select style='margin-left:25px;' id='sel17a' name=q14267 onchange='sel17_a(this.value)'>";
						echo "<option value='' selected disabled>Select 1st choice</option>";
						$subopt17_a = get_qop(14267, 'opt_text_value');
						$i17_a=0;
						foreach($subopt17_a as $so17_a)
						{
							$i17_a++;
							echo "<option value='$i17_a'>$so17_a</option>";
						}
						echo "</select>";
                        echo "<input type=hidden name='qid[]' value='14268'>";
						echo "<input type='text' id='17ao' name=q14268 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						//2nd choice
                                                echo "<input type=hidden name='qid[]' value='14269'>";
						echo "<select style='margin-left:25px;' id='sel17b' name=q14269 onchange='sel17_b(this.value)'>";
						echo "<option value='' selected disabled>Select 2nd choice</option>";
						$subopt17_b = get_qop(14269, 'opt_text_value');
						$i17_b=0;
						foreach($subopt17_b as $so17_b)
						{
							$i17_b++;
							echo "<option value='$i17_b'>$so17_b</option>";
						}
						echo "</select>";
                                                echo "<input type=hidden name='qid[]' value='14270'>";
						echo "<input type='text' id='17bo' name=q14270 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						// 3rd choice
                         echo "<input type=hidden name='qid[]' value='14271'>";
						echo "<select style='margin-left:25px;' id='sel17c' name=q14271 onchange='sel17_c(this.value)'>";
						echo "<option value='' selected disabled>Select 3rd choice</option>";
						$subopt17_c = get_qop(14271, 'opt_text_value');
						$i17_c=0;
						foreach($subopt17_c as $so17_c)
						{
							$i17_c++;
							echo "<option value='$i17_c'>$so17_c</option>";
						}
						echo "</select>";
						
                                                echo "<input type=hidden name='qid[]' value='14272'>";
						echo "<input type='text' id='17co' name=q14272 placeholder='Specify here' style='display:none; margin-left:10px'>";
						
						echo "<br>";
						echo "<br>";
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 17th opt ****************//
						
						// ************** 18th opt ****************//
						if($i == 17) 
						{
						echo '<div id="course_choice18" class="choices" style="display:none;">';

						// 1st						
                        echo "<input type=hidden name='qid[]' value='14273'>";
						echo "<input type='text' id='sel18a' name=q14273 placeholder='Specify course for 1st choice' style='margin-left:10px'>";
						
						// 2nd						
                        echo "<input type=hidden name='qid[]' value='14274'>";
						echo "<input type='text' id='sel18b' name=q14274 placeholder='Specify course for 2nd choice' style='margin-left:10px'>";
						
						// 3rd
                        echo "<input type=hidden name='qid[]' value='14275'>";
						echo "<input type='text' id='sel18c' name=q14276 placeholder='Specify course 3rd choice' style='margin-left:10px'>";		
						
						echo "</div>";
						
						echo "</td>";
						} // ************** end of 18th opt ****************//
						
						///////////////////////////End of Couses choices Option hide show/////////////////////
						$i++;
					}
					//echo "</tr>";
                                  //}
                    echo "</table>";

			} //end for qid=14234

			// ************************ mq_8 *******************//
			if(in_array('14280',$gqids))
			{
				$ds="SELECT 14234_237 as data from $table where resp_id = $resp_id and 14234_237!=''";
							$rr2=DB::getInstance()->query($ds);
							if($rr2->count()>0)
							{
								$get_d=$rr2->first()->data;
							}
							$str="";
							switch($get_d)
							{
								case 1: $str ="Bachelor of Education/Elementary Education";
								break;
								case 2: $str ="Master of Arts";
								break;
								case 3: $str ="Masters of Business Administration";
								break;
								case 4: $str ="Master of Commerce";
								break;
								case 5: $str ="Master of Computer Application";
								break;
								case 6: $str ="Master of Dental Surgery";
								break;
								case 7: $str ="Master of Design";
								break;
								case 8: $str ="Master of Hotel Management";
								break;
								case 9: $str ="Doctor of Medicine (MD)";
								break;
								case 10: $str ="Master of Education";
								break;
								case 11: $str ="Master of Engineering / Technology";
								break;
								case 12: $str ="Master of Law";
								break;
								case 13: $str ="Master of Library and Information Science";
								break;
								case 14: $str ="Master of Philosophy";
								break;
								case 15: $str ="Master Of Science";
								break;
								case 16: $str ="Master of Tourism & Travel Management";
								break;
								case 17: $str ="Post Graduate Diploma";
								break;
								case 18: $str ="Others";
								break;
																
							}
							//1st college details
							echo "<table style='width:100%'><td colspan=2>A. As you are interested in $str, please write down the name of the top 3 colleges in India you prefer to study in <br>B. Select the college location as well. <br><br><span style='color:red' id='14280e'></span><br><br></td>";
							
							echo "<tr><td style='background-color:lightgray'>Your 1st Choice</td>";
							echo "<td style='background-color:lightgray'>";
                            	echo "<input type=hidden name='qid[]' value='14279'>";
							echo "<input type='text' id=q14279 name=q14279 style='background-color:white;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Enter College Name 1' required>"; 
							
							echo "<span style='font-size:20px'>Location:</span>";
							
	                        echo "<input type=hidden name='qid[]' value='14280'>";
							$col_loc1 = get_qop(14280, 'opt_text_value');
							$c1=0;
							foreach($col_loc1 as $cl1)
							{
								$c1++;
								echo "<input type='radio' style='margin-left:25px' class='big' value='$c1' name='q14280' id='q14280'>$cl1";
							}
							
                            echo "<input type=hidden name='qid[]' value='14281'>";
							echo "<input type='text' name='q14281' class='collegeOtherCity1' id='collegeOtherCity1_6' style='margin-left:25px;height:40px; font-size:16px; display:none' placeholder='Specify Other City'>";
							
							echo "</td>";
							echo "</tr>";
							//End of 1st college details
							
							//2nd college details
							echo "<tr> <td style='background-color:lightgray'>Your 2nd Choice</td>";
							echo "<td style='background-color:lightgray'>";
	                        echo "<input type=hidden name='qid[]' value='14282'>";
							echo "<input type='text' id='q14282' style='background-color:white;width:100%; height:40px;font-size:16px;padding:20px;' name=q14282 placeholder='Enter College Name 2' required>"; 
							
														
							echo "<span style='font-size:20px'>Location:</span>";
							
	                        echo "<input type=hidden name='qid[]' value='14283'>";
							$col_loc2 = get_qop(14283, 'opt_text_value');
							$c2=0;
							foreach($col_loc2 as $cl2)
							{
								$c2++;
								echo "<input type='radio' style='margin-left:25px' class='big' name='q14283' id='q14283' value='$c2'>$cl2";
							}
							
	                        echo "<input type=hidden name='qid[]' value='14284'>";
							echo "<input type='text' style='margin-left:25px;font-size:16px;height:40px; display:none' name='q14284' class='collegeOtherCity2' id='collegeOtherCity2_6' placeholder='Specify Other City'>";
							
							echo "</td>";
							echo "</tr>";
							//End of 2nd college details
							
							//3rd college details
							echo "<tr><td style='background-color:lightgray'>Your 3rd Choice</td>";
							echo "<td style='background-color:lightgray'>";
	                        echo "<input type=hidden name='qid[]' value='14285'>";
							echo "<input type='text' style='background-color:white;width:100%; height:40px;font-size:16px;padding:20px;' id=q14119 name=q14119 $str placeholder='Enter College Name 3' required>"; 
							
							echo "<span style='font-size:20px'>Location:</span>";
							
	                        echo "<input type=hidden name='qid[]' value='14286'>";
							$col_loc3 = get_qop(14286, 'opt_text_value');
							$c3=0;
							foreach($col_loc3 as $cl3)
							{
								$c3++;
								echo "<input type='radio' style='margin-left:25px' class='big' name='q14286' id='q14286' value='$c3'>$cl3";
							}
							echo "</select>";
							
                            echo "<input type=hidden name='qid[]' value='141287'>";
							echo "<input type='text' name='q14287' class='collegeOtherCity3' name='q14287' id='collegeOtherCity3_6' style='margin-left:25px;font-size:16px;height:40px; display:none' placeholder='Specify Other City'>";
							
							echo "</td>";
							echo "</tr>";
							//End of 3rd college details					
												
                         echo "</table>";
			} //end for qid=14114
			
		// ************************ residence cities *******************//
						if(in_array('14298',$gqids))
						{
							//current city
							echo "<table style='width:100%'><td colspan=2 style=''> <br> Kindly provide the address of your current residence. <br><br><span style='color:red' id='14299e'></span><br></td>";
									
							$ccity = get_qop(14299, 'opt_text_value');
							$c1=0;
							echo "<tr style='background-color:lightgray'>";
							echo "<input type=hidden name='qid[]' value='14298'>";
							echo "<td></td><td> <input type='text' name='q14298' placeholder='Enter Your Current Address' style='background-color:white;width:100%;height:40px; font-size:16px;' required>";
							
							echo "City:";
							
							
							echo "<input type=hidden name='qid[]' value='14299'>";
							foreach($ccity as $cl1)
							{
								$c1++;
								echo "<input type='radio' value='$c1' class='big' name='q14299'> $cl1 ";
							}
							
							echo "<input type=hidden name='qid[]' value='14300'>";
							echo "<input type='text' name='q14300' style='margin-left:25px;background-color:white;height:40px; font-size:16px; display:none' id='ocity4' class='ocity3' placeholder='Specify Other City' >";
							
							echo "</td>";
							echo "</tr>";
																			
                         echo "</table>";
						 
						 echo "<br>";
						 echo "<br>";
					}
                    if(in_array('14301',$gqids))
                    {

						 //permanent city
							echo "<table style='width:100%'><td colspan=2 style=''> <br> Kindly provide the address of your Permanent residence. <br><br> <span style='color:red' id='14302e'></span><br></td>";
									
							$ccity = get_qop(14302, 'opt_text_value');
							$c1=0;
							echo "<tr style='background-color:lightgray'>";
							echo "<input type=hidden name='qid[]' value='14301'>";
							echo "<td></td><td><input type='text' name='q14301' placeholder='Enter Your Permanent Address' style='background-color:white;width:100%;height:40px; font-size:16px; ' required>";
														
							echo "City:";
							foreach($ccity as $cl1)
							{
								$c1++;
								echo "<input type='radio' value='$c1' class='big' name='q14302'>$cl1";
							}
							
							echo "<input type=hidden name='qid[]' value='14303'>";
							echo "<input type='text' name='q14303' style='margin-left:25px;height:40px; font-size:16px; display:none' id='opcity4' class='opcity' placeholder='Specify Other City' required>";
							
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
						      if($lang == 'none')
							  {
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
										//echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt <hr></td></tr>";
										
										echo "<tr height=40>";
										echo "<td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt ";
										// show if click on other school option
										if($qid==14228 and $value==15)
										{
											echo "<input type='text' id='sch_input15' name='q14229' class='sch' placeholder='Specify here' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
										}
										
                                if($qid==14230 and $value==20)
								{
									echo "<input type='text' id='sch_input20' name='q14231' class='sch' placeholder='Specify here' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
                                }
								
								 if($qid==14783 and $value==31)
								{
									echo "<input type='text' id='sch_input31' name='q14229' class='sch' placeholder='Specify here' style='height:40px;font-size:16px;display:none; margin-left:25px'>";
                                }

										//outside india textarea
										if($qid==14276 and $value==2)
										{
											echo "<input type='text' id='outInd2' name='q14277' class='outInd' onkeypress='return isNotNumber(event)'  placeholder='Specify country name' style='height:40px; font-size:16px; display:none; margin-left:25px'>";
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
							if($qid == '14292' || $qid == '14305'){
                                                        	echo "<input type=text size=20 maxlength=10 minlength=10 onkeypress='return isNumber(event)' style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;'
placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
                                                        }
                                                       else if($qid == '14291')
						       {
                                                            echo "<input type=text size=20 onkeypress='return isNotNumber(event)' style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;'
placeholder='Type here'  name=q$qid id=q$qid value='$str' >";
                                                        }

							else if($qid == '14293' || $qid == '14306')
							{
								echo "<input type=email style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Type here'  name=q$qid id=q$qid value='$str'>";
								//echo "<span id='result'></span>";
								echo "<span id='14293e'></span>";
								echo "<span id='14306e'></span>";

							}
							else if($qid==14297)
							{
								//DD
								echo "<div style='margin-left:25px; height:40px;'><select name='dd' id='dd' style='height:40px;font-size:16px;' required>";
								echo "<option value=''> DD </option>";
								for($d=1; $d < 32 ; $d++)
								{
									echo "<option> $d </option>";
								}
								echo "</select>";
								
								//MM
								echo "<select name='mm' id='mm' style='height:40px;font-size:16px;' required>";
								echo "<option value=''> MM </option>";
								for($m=1; $m < 13 ; $m++)
								{
									echo "<option> $m </option>";
								}
								echo "</select>";
								
								//YY
								echo "<select name='yy' id='yy' style='height:40px;font-size:16px;' required>";
								echo "<option value=''> YY </option>";
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
	 <!--input type='submit' name='back' value="&#8249;Back" class="previous round" style="padding: 8px 16px;display: inline-block;" -->
	 
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
history.pushState(null, null, 'http://localhost/digiamin-web/survey/fpn_237.php');
window.addEventListener('popstate', function(event) {
history.pushState(null, null, 'http://localhost/digiamin-web/survey/fpn_237.php');
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
    $("input[name$='q14280']").click(function()
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
    $("input[name$='q14283']").click(function()
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
    $("input[name$='q14286']").click(function()
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
    $("input[name$='q14228']").click(function()
	{
        var test = $(this).val();
        $("input.sch").hide();
        $("#sch_input").show(); //show static here
		$("#sch_input" + test).show(); //show dynamic here
		if(test==15)
		{
			document.getElementById("sch_input15").required=true;
		}
		else
		{
			document.getElementById("sch_input15").required=false;
			document.getElementById("sch_input15").value='';
		}
    });
});
</script>

<script>
//show hide on radio button
$(document).ready(function() {
    $("input[name$='q14783']").click(function()
	{
        var test = $(this).val();
        $("input.sch").hide();
        $("#sch_input").show(); //show static here
		$("#sch_input" + test).show(); //show dynamic here
		if(test==31)
		{
			document.getElementById("sch_input31").required=true;
		}
		else
		{
			document.getElementById("sch_input31").required=false;
			document.getElementById("sch_input31").value='';
		}
    });
});
</script>

<script>
//show hide on radio button
$(document).ready(function() {
    $("input[name$='q14230']").click(function()
        {
        var test = $(this).val();
        $("input.sch").hide();
        $("#sch_input").show(); //show static here
                $("#sch_input" + test).show(); //show dynamic here
                if(test==20)
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
    $("input[name$='q14276']").click(function()
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
    $("input[name$='q14299']").click(function()
	{
        var test = $(this).val();

        $("input.ocity4").hide();
		$("#ocity" + test).show(); //show dynamic here
		
		if(test==4)
		{
			document.getElementById("ocity4").required=true;
		}
		
		else
		{
			document.getElementById("ocity4").required=false;
			document.getElementById("ocity4").value='';
			document.getElementById("ocity4").style.display='none';
		}
		
    });
});
</script>
<!-- ========= // ========= -->

<!-- ========= Get input field on other option(14302) other permanent city ========= -->
<script>
//show hide on radio button
$(document).ready(function() 
{
    $("input[name$='q14302']").click(function()
	{
        var test = $(this).val();

        $("input.opcity4").hide();
		$("#opcity" + test).show(); //show dynamic here
		
		if(test==4)
		{
			document.getElementById("opcity4").required=true;
		}
		
		else
		{
			document.getElementById("opcity4").required=false;
			document.getElementById("opcity4").value='';
			document.getElementById("opcity4").style.display='none';
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
		
		if(test==3)
		{
			document.getElementById("opcity3").required=true;
		}
		
		else
		{
			document.getElementById("opcity3").required=false;
			document.getElementById("opcity3").value='';
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
$(document).ready(function() {
    $("input[name$='q14234']").click(function()
	{
        var test = $(this).val();

        $("div.choices").hide();
        $("#course_choice" + test).show();
		
		//alert(test);
		
		// ****** hide, none, required, reset values *******
		
		//////// // if radio value is 2 //////////
		if(test==2) 
		{
			document.getElementById("sel2a").required=true;
			// document.getElementById("sel2b").required=true;
			// document.getElementById("sel2c").required=true;
			
			// other input required false
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			document.getElementById("sel18a").required=false;
			// document.getElementById("sel18b").required=false;
			// document.getElementById("sel18c").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel3a").selectedIndex = '';
            document.getElementById("sel3b").selectedIndex = '';
            document.getElementById("sel3c").selectedIndex = '';

			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
			
			// do other input values blank
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
       
        }
		// end of if radio value is 2 ////
		
		//////// // if radio value is 3 //////////
		if(test==3) 
		{
			document.getElementById("sel3a").required=true;
			// document.getElementById("sel3b").required=true;
			// document.getElementById("sel3c").required=true;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel9a").required=false;
			document.getElementById("sel9b").required=false;
			document.getElementById("sel9c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
			
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
       
        }
		// end of if radio value is 3 ////
		
		//////// // if radio value is 9 //////////
		if(test==9) 
		{
			document.getElementById("sel9a").required=true;
			// document.getElementById("sel3b").required=true;
			// document.getElementById("sel3c").required=true;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel3a").selectedIndex = '';
			document.getElementById("sel3b").selectedIndex = '';
			document.getElementById("sel3c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
			
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
       
        }
		// end of if radio value is 9 ////
		
		//////// // if radio value is 11 //////////
		if(test==11) 
		{
			document.getElementById("sel11a").required=true;
			// document.getElementById("sel3b").required=true;
			// document.getElementById("sel3c").required=true;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel3a").selectedIndex = '';
			document.getElementById("sel3b").selectedIndex = '';
			document.getElementById("sel3c").selectedIndex = '';
			
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
			
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
       
        }
		// end of if radio value is 11 ////
		
		//////// // if radio value is 15 //////////
		if(test==15) 
		{
			document.getElementById("sel15a").required=true;
			// document.getElementById("sel3b").required=true;
			// document.getElementById("sel3c").required=true;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel3a").selectedIndex = '';
			document.getElementById("sel3b").selectedIndex = '';
			document.getElementById("sel3c").selectedIndex = '';
			
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
			
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
       
        }
		// end of if radio value is 15 ////
		
		//////// // if radio value is 17 //////////
		if(test==17) 
		{
			document.getElementById("sel17a").required=true;
			// document.getElementById("sel3b").required=true;
			// document.getElementById("sel3c").required=true;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel3a").selectedIndex = '';
			document.getElementById("sel3b").selectedIndex = '';
			document.getElementById("sel3c").selectedIndex = '';
			
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
			
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
       
        }
		// end of if radio value is 17 ////
		
		//////// // if radio value is 18 //////////
		if(test==18) 
		{
			document.getElementById("sel18a").required=true;
			// document.getElementById("sel3b").required=true;
			// document.getElementById("sel3c").required=true;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel3a").selectedIndex = '';
			document.getElementById("sel3b").selectedIndex = '';
			document.getElementById("sel3c").selectedIndex = '';
			
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
						
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "block";
			document.getElementById("sel18b").style.display = "block";
			document.getElementById("sel18c").style.display = "block";
						
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17ao").value = '';
			document.getElementById("17ao").value = '';
        }
		// end of if radio value is 18 ////
		
			//////// // if radio is clicked on other rest values //////////
		if(test==1 || test==4 || test==5 || test==6 || test==7 || test==8 || test==10 || test==12 || test==13 || test==14 || test==16)  
		{
			document.getElementById("sel18a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			// other input required false
			document.getElementById("2ao").required=false;
			document.getElementById("2bo").required=false;
			document.getElementById("2co").required=false;
			
			document.getElementById("3ao").required=false;
			document.getElementById("3bo").required=false;
			document.getElementById("3co").required=false;
			
			document.getElementById("9ao").required=false;
			document.getElementById("9bo").required=false;
			document.getElementById("9co").required=false;
			
			document.getElementById("11ao").required=false;
			document.getElementById("11bo").required=false;
			document.getElementById("11co").required=false;
			
			document.getElementById("15ao").required=false;
			document.getElementById("15bo").required=false;
			document.getElementById("15co").required=false;
			
			document.getElementById("17ao").required=false;
			document.getElementById("17bo").required=false;
			document.getElementById("17co").required=false;
			
			// select dropdown required false
			
			document.getElementById("sel2a").required=false;
			document.getElementById("sel2b").required=false;
			document.getElementById("sel2c").required=false;
			
			document.getElementById("sel3a").required=false;
			document.getElementById("sel3b").required=false;
			document.getElementById("sel3c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel11a").required=false;
			document.getElementById("sel11b").required=false;
			document.getElementById("sel11c").required=false;
			
			document.getElementById("sel15a").required=false;
			document.getElementById("sel15b").required=false;
			document.getElementById("sel15c").required=false;
			
			document.getElementById("sel17a").required=false;
			document.getElementById("sel17b").required=false;
			document.getElementById("sel17c").required=false;
			
			document.getElementById("sel18a").required=false;
			document.getElementById("sel18b").required=false;
			document.getElementById("sel18c").required=false;
			
			// do select dropdown value blank
                       
            document.getElementById("sel2a").selectedIndex = '';
            document.getElementById("sel2b").selectedIndex = '';
            document.getElementById("sel2c").selectedIndex = '';

			document.getElementById("sel3a").selectedIndex = '';
			document.getElementById("sel3b").selectedIndex = '';
			document.getElementById("sel3c").selectedIndex = '';
			
			document.getElementById("sel9a").selectedIndex = '';
			document.getElementById("sel9b").selectedIndex = '';
			document.getElementById("sel9c").selectedIndex = '';
			
			document.getElementById("sel11a").selectedIndex = '';
			document.getElementById("sel11b").selectedIndex = '';
			document.getElementById("sel11c").selectedIndex = '';
			
			document.getElementById("sel15a").selectedIndex = '';
			document.getElementById("sel15b").selectedIndex = '';
			document.getElementById("sel15c").selectedIndex = '';
			
			document.getElementById("sel17a").selectedIndex = '';
			document.getElementById("sel17b").selectedIndex = '';
			document.getElementById("sel17c").selectedIndex = '';
			
			// do other input field value blank
			
			document.getElementById("2ao").style.display = "none";
			document.getElementById("2bo").style.display = "none";
			document.getElementById("2co").style.display = "none";
			
			document.getElementById("3ao").style.display = "none";
			document.getElementById("3bo").style.display = "none";
			document.getElementById("3co").style.display = "none";
			
			document.getElementById("9ao").style.display = "none";
			document.getElementById("9bo").style.display = "none";
			document.getElementById("9co").style.display = "none";
			
			document.getElementById("11ao").style.display = "none";
			document.getElementById("11bo").style.display = "none";
			document.getElementById("11co").style.display = "none";
			
			document.getElementById("15ao").style.display = "none";
			document.getElementById("15bo").style.display = "none";
			document.getElementById("15co").style.display = "none";
						
			document.getElementById("17ao").style.display = "none";
			document.getElementById("17bo").style.display = "none";
			document.getElementById("17co").style.display = "none";
			
			document.getElementById("sel18a").style.display = "none";
			document.getElementById("sel18b").style.display = "none";
			document.getElementById("sel18c").style.display = "none";
						
			// do other input values blank
			
			document.getElementById("2ao").value = '';
			document.getElementById("2bo").value = '';
			document.getElementById("2co").value = '';
			
			document.getElementById("3ao").value = '';
			document.getElementById("3bo").value = '';
			document.getElementById("3co").value = '';
			
			document.getElementById("9ao").value = '';
			document.getElementById("9bo").value = '';
			document.getElementById("9co").value = '';
			
			document.getElementById("11ao").value = '';
			document.getElementById("11bo").value = '';
			document.getElementById("11co").value = '';
			
			document.getElementById("15ao").value = '';
			document.getElementById("15bo").value = '';
			document.getElementById("15co").value = '';
			
			document.getElementById("17ao").value = '';
			document.getElementById("17bo").value = '';
			document.getElementById("17co").value = '';
			
			document.getElementById("sel18a").value = '';
			document.getElementById("sel18b").value = '';
			document.getElementById("sel18c").value = '';
        }
		// end of other rest radio click part ////
				
		// ****** //hide, none, required, reset values *******
		
    });
});
</script>

<!-- Couse Choices Select Hide Show -->
<script>

// ********** 2nd choice input hide show **********//
// 1st
function sel2_a(s2_a)
{
	if(s2_a==7)
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
	if(s2_b==7)
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
	if(s2_c==7)
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
function sel3_a(s3_a)
{
	if(s3_a==5)
	{
		$('#3ao').show('fast');
		document.getElementById("3ao").required=true;
	}
	else
	{
		$('#3ao').hide('fast');
		document.getElementById("3ao").required=false;
	}
}

// 2nd
function sel3_b(s3_b)
{
	if(s3_b==5)
	{
		$('#3bo').show('fast');
		document.getElementById("3bo").required=true;
	}
	else
	{
		$('#3bo').hide('fast');
		document.getElementById("3bo").required=false;
	}
}

// 3rd
function sel3_c(s3_c)
{
	if(s3_c==5)
	{
		$('#3co').show('fast');
		document.getElementById("3co").required=true;
	}
	else
	{
		$('#3co').hide('fast');
		document.getElementById("3co").required=false;
	}
}
// ************ End of 4th choices options ****************//

// ********** 9th choice input hide show **********//
// 1st
function sel9_a(s9_a)
{
	if(s9_a==14)
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
	if(s9_b==14)
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
	if(s9_c==14)
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

// ********** 9th choice input hide show **********//
// 1st
function sel11_a(s11_a)
{
	if(s11_a==10)
	{
		$('#11ao').show('fast');
		document.getElementById("11ao").required=true;
	}
	else
	{
		$('#11ao').hide('fast');
		document.getElementById("11ao").required=false;
	}
}

// 2nd
function sel11_b(s11_b)
{
	if(s11_b==10)
	{
		$('#11bo').show('fast');
		document.getElementById("11bo").required=true;
	}
	else
	{
		$('#11bo').hide('fast');
		document.getElementById("11bo").required=false;
	}
}

// 3rd
function sel11_c(s11_c)
{
	if(s11_c==10)
	{
		$('#11co').show('fast');
		document.getElementById("11co").required=true;
	}
	else
	{
		$('#11co').hide('fast');
		document.getElementById("11co").required=false;
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
	if(s15_a==11)
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
	if(s15_b==11)
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
	if(s15_c==11)
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

// ********** 17th choice input hide show **********//
// 1st
function sel17_a(s17_a)
{
	if(s17_a==12)
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
	if(s17_b==12)
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
	if(s17_c==12)
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
// radio validation

    $('#btn').click(function() 
	{
	
	var qlist= <?php echo json_encode($qlist); ?>; //1st page array
	//alert('qlist=' + qlist);
	
	////////////////////////////////////// 14234 ////////////////////////////////
	if(qlist.some(item => item == '14234'))
	{
	
		var checked_14234 = $("input[name=q14234]:checked").length;
		
		if(checked_14234>0)
		{
			document.getElementById('14234e').innerHTML='';
			return true;
		}
		
		else
		{
			document.getElementById('14234e').innerHTML='Error! Select course choice';
			return false;
		}
		
	}
	
		//////////////////////////////////////////////////////////////////////////////	
		if(qlist.some(item => item == '14293'))
		{
			var text_14293 = document.getElementById('q14293').value;
 	
			if(text_14293 == '')
			{ 	
				document.getElementById("14293e").innerHTML = "Error! Enter father's email";
				return false;
			}
			else
			{

				document.getElementById('14293e').innerHTML='';
				return true;
			}
		}
		
		if(qlist.some(item => item == '14306'))
		{
			var text_14306 = document.getElementById('q14306').value;
 	
			if(text_14306 == '')
			{ 	
				document.getElementById("14306e").innerHTML = "Error! Enter email Id";
				return false;
			}
			else
			{

				document.getElementById('14306e').innerHTML='';
				return true;
			}
		}
		
		////////////////////////////////////////////////////////////////
		
		//////////////////////////////////////////////////////////////////////////////	
		if(qlist.some(item => item == '14299'))
		{
			var checked_14299 = $("input[name=q14299]:checked").length;	
 	
			if(checked_14299 == 0)
			{ 	
				document.getElementById('14299e').innerHTML = 'Error! Enter address & select city';
				return false;
			}
			else
			{

				document.getElementById('14299e').innerHTML='';
				return true;
			}
		}
		
		////////////////////////////////////////////////////////////////
		
		if(qlist.some(item => item == '14302'))
		{
			var checked_14302 = $("input[name=q14302]:checked").length;	
			
			if(checked_14302==0)
			{
					
				document.getElementById('14302e').innerHTML = 'Error! Enter address & select city';
				return false;
			}
			
			else
			{
					
				document.getElementById('14302e').innerHTML = '';
				return true;
			}
		}
		
	////////////////////////////////////// 14103 & 14105 ////////////////////////////////
	if(qlist.some(item => item == '14280') && qlist.some(item => item == '14283') && qlist.some(item => item == '14286'))
	{
	
		var checked_14280 = $("input[name=q14280]:checked").length;
		var checked_14283 = $("input[name=q14283]:checked").length;
		var checked_14286 = $("input[name=q14286]:checked").length;		
		

		if(checked_14280 > 0 && checked_14283 >0 && checked_14286 > 0 )
		{
			document.getElementById('14280e').innerHTML='';
			return true;
		}
		
		else
		{
			document.getElementById('14280e').innerHTML='Error! Enter College & Select City';
			// document.getElementById('14283e').innerHTML='Error! Select City 2';
			// document.getElementById('14286e').innerHTML='Error! Select City 3';
			return false;
		}
					
	}
	
	});
	</script>