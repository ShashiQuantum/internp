<?php
include_once('../vcimsweb/init.php');
include_once('survey-function.php');
 
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
    	{
		$tarr=$_SESSION['pqstack'];
	}
    	if(Session::exists('pqt'))
	{ $pqt=$_SESSION_['pqt'];   }
        if(Session::exists('maxsid'))
        { $maxsid=$_SESSION['maxsid'];   }
//echo $sid;
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
<!-- <tr style="background-color:green;"><td style="height:3%;width:100%;">
     <div>
                        <span style=float:right;color:#fff; font-size:50px;> <?php  ?> </span>
                        <span style=float:left;><img src='http://vareniacims.com/public/img/logos/varenia_logow.png' height=40px width=100px> </span>
     </div>
</td></tr>
-->

 	<form method="post" action="">
	<?php
	if(isset($_POST['submit']))
	{
                    date_default_timezone_set('asia/calcutta');
                    $dt = date('Y/m/d H:i:s');
                    $newURL='';
                    $qqq="UPDATE `respondent_web` SET `status`=2, endtime='$dt' WHERE resp_id = $resp_id AND qset = $qset";
                    DB::getInstance()->query($qqq);
                    $qqa="UPDATE $table SET `st`=2, timestamp='$dt' WHERE resp_id = $resp_id AND qset = $qset AND gender !=''";
                    DB::getInstance()->query($qqa);
                    //session_destroy();

                       echo $newURL="http://www.vareniacims.com/test/12.php?q=$qset";
                     header('Location: '.$newURL);

	}

	if(isset($_POST['next']) || $sid==0)
	{   
			date_default_timezone_set('asia/calcutta');
			$dt = date('Y/m/d H:i:s');
			$cq=0;
	      		if($sid > 0)
	      		{
				$cq=$_POST['qid'];
//echo "pqt: $pqt";
				if( $pqt != 'first'){
						save_result($_POST,$table,$qset,$resp_id);
				//		array_push($qlist,$qid);

				    //$psid=$_SESSION['sid'];
				      $psid = $_SESSION['sptr'];
					 //echo "Saving.. PSID: $psid";
                                    if(Session::exists('pqstack'))
                                    {
					$tarr=array();
                                        $tarr=$_SESSION['pqstack'];
					array_push($tarr,$psid);
					// print_r($tarr);
					$_SESSION['pqstack'] = $tarr;
//echo 'xx'; print_r($_SESSION['pqstack']);
                                    }
				   /*
				    else
				    {
					$arrr=array(1);
					array_push($arrr,$psid);
					$_SESSION['pqstack'] = $arrr;
				    }
				  */
				}
			}
	echo "<br>next..";
	print_r($_SESSION['pqstack']);
			/*	if(Session::exists('wqstack'))
             	               	{
                			$tarr=$_SESSION['wqstack'];array_push($tarr,$cq);$_SESSION['wqstack']=$tarr;
             				}else { $arrr=array();array_push($arrr,$cq);$_SESSION['wqstack']=$arrr;}
				}
			*/

			$qtype=''; 
			if(Session::exists('sid'))
				   $sid=$_SESSION['sid'];
//echo "<br>maxsid: $maxsid , sid: $sid";
			if($sid>$maxsid) $sid=0;

		if($sid>=0 && $sid<=$maxsid)
		{
			$sptr = 1; $nptr = 3;$cqid=0;$cqid_arr_cnt = 0;
				if($sid==0)
				{
						//$cqid=ptr_first_question($qset,$sptr,$nptr);
						$_SESSION['sptr']=$sptr;
						$cqid_arr=ptr_first_question($qset,$sptr,$nptr);
						$cqid_arr_cnt = count($cqid_arr);
						//echo "cnt: $cqid_arr_cnt <br>";
						//print_r($cqid_arr);
						$_SESSION['cqid_cnt']=$cqid_arr_cnt;
				}
				else
				{  
					$sptr = $_SESSION['sid'] + 1; $eptr=$sptr+$nptr;
					$_SESSION['sptr']=$_SESSION['sid'];
					$cqid_arr=ptr_first_question($qset,$sptr,$eptr);
					$cqid_arr_cnt = count($cqid_arr);
echo "before next: sptr: $sptr, eptr: $eptr , cnt: $cqid_arr_cnt ;";
					//echo " next_s_question($qset,$sid,$table,$resp_id,$maxsid)";
					if($cqid_arr_cnt == 1){
						//--$sid;
						$pcqid_cnt=$_SESSION['cqid_cnt'];
						if($cqid_arr_cnt > 1) --$sid;
						$_SESSION['sid'] = $sid;
						//echo "<br> next_s_question($qset,$sid,$table,$resp_id,$maxsid)";
						$cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);
						$cqid_arr = array($cqid);
						//print_r($cqid_arr);
					}
					//$cqid_arr=next_s_question($qset,$sid,$table,$resp_id,$maxsid,$sptr,$eptr);
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
        $cqid_arr = array_unique($cqid_arr);
	//print_r($cqid_arr);
	if(!empty($cqid_arr))
	foreach($cqid_arr as $cqid){

	//--to check ques having grid rule-3 or not
	if(is_grid_question($cqid)){
//echo $_SESSION['sid'];
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
			//to show grod questions
			if(count($arr_qt) == 2){
				$iqid = $gqids[0];
				$ititle = $arr_temp[ $iqid ]['q_title'];
				echo "<tr><td style='padding:30px;'> $ititle </td></tr>";

				if($arr_qt[1] == 'dropdown'){
				      if($qset == 213){
					$dd = get_q_response($table,$resp_id,12322);
					//print_r($dd);
					$arr_pq=array();
					foreach($dd as $di){
					    if($iqid == 12328){
						if( $di == 1){$q=12329; array_push($arr_pq,$q);}
						if( $di == 2){$q=12330; array_push($arr_pq,$q);}
						if( $di == 3){$q=12331; array_push($arr_pq,$q);}
						if( $di == 4){$q=12332; array_push($arr_pq,$q);}
					     }
					     if($iqid == 12448){
                                                if( $di == 1){$q=12449; array_push($arr_pq,$q);}
                                                if( $di == 2){$q=12450; array_push($arr_pq,$q);}
                                                if( $di == 3){$q=12451; array_push($arr_pq,$q);}
                                                if( $di == 4){$q=12452; array_push($arr_pq,$q);}
					     }
					}
				     }
                                     if($qset == 219){
                                        $dd = get_q_response($table,$resp_id,12670);
                                        //print_r($dd);
                                        $arr_pq=array();
                                        foreach($dd as $di){
                                            if($iqid == 12674){
                                                if( $di == 1){$q=12675; array_push($arr_pq,$q);}
                                                if( $di == 2){$q=12676; array_push($arr_pq,$q);}
                                                if( $di == 3){$q=12677; array_push($arr_pq,$q);}
                                                if( $di == 4){$q=12678; array_push($arr_pq,$q);}
                                             }
                                             if($iqid == 12679){
                                                if( $di == 1){$q=12680; array_push($arr_pq,$q);}
                                                if( $di == 2){$q=12681; array_push($arr_pq,$q);}
                                                if( $di == 3){$q=12682; array_push($arr_pq,$q);}
                                                if( $di == 4){$q=12683; array_push($arr_pq,$q);}
                                             }
                                        }
                                     } //end of if qset


					//print_r($arr_pq);
					//$gqs = array_intersect($gqids,$arr_pq);
					echo "<table ID='myDiv'  style='padding-left:40px;  width:100%;'>";
				  for($i=0; $i < count($arr_pq); $i++){
					//$qid= $gqids[ $i ];
					$qid= $arr_pq[ $i ];
					$error=$qid.'e';
					$qtle=$arr_temp[ $qid ]['q_title'];
					//echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> </td><td><select class='big' name=q$qid id=q$qid><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select></td></tr>";
					echo "<tr>
                                                            <td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td>
                                                            <td>
                                                            <input type='text' name=text$qid id=op_$qid class='txtCalc' placeholder='0' required>
                                                            </td>
                                                            </tr>
                                         ";
				  }
                                    ?>                        <tr><td><font color=blue> Sum: <span id='total_sum_value'>0</span> </font><br><span id="msg"></span></td></tr>
				<?php

				    echo "</table>";
					}

                                if($arr_qt[1] == 'radio'){
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
					//to get qop detail
					//if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
					$error=$qid.'e';
//echo "<br> $qid - $error";
                                        echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td>";

					foreach($arr_qo_val as $ov){
						echo "<td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid value=$ov></td>";
					}
					echo "</tr>";
                                  }
                                    echo "</table>";
                                }
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
					echo "<tr><td style='padding:30px;'> $ititle </td></tr>";
                                        echo "<table border='1' cellspacing=0 cellpadding=0 style='padding-left:20px;'style='padding:30px;width:100%''><tr><td></td><td style='background-color:lightgray'> $textA <input type=hidden name='qid[]' value=$chqid ><font color=red><span id='$cerror'></span></font> </td style='background-color:lightgray'> <td> $textB <input type=hidden name='qid[]' value=$rqid ><font color=red><span id='$rerror'></span></font> </td> </tr>";
					$i=0;
                                        foreach($arr_qo as $qo){
                                        	$val = $arr_qo_val[ $i ];
						$aa='q'.$chqid.'[]';
						echo "<tr><td> $qo </td><td style='background-color:lightgray'><input type='checkbox' class='big' id=q$chqid name=$aa value=$val > </td> <td style='background-color:lightgray'><input type='radio' class='big' id=q$rqid name=q$rqid value=$val > </td><tr>";
						$i++; 
                                       }
	                                echo "</table>";

                        } //end of qtype count 3

		}

	} //end of grid questions to show else continue
	else{
				$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
				if($ques->count()>0)
				{ 
							 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
							 $error=$qid.'e';
							 $_SESSION['pqt']=$qtype;

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
							 echo "<p style='font-size:10px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
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
							  if($flag_show == 1){
								$sq = "SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid AND value IN ( $show_qids );";
							  }
							  $flag_show = 0; $isshow=false;
							  $qop=DB::getInstance()->query($sq);
							  if($qop->count()>0)
							  {  echo "<table> <input type=hidden name='qid[]' value=$qid>";
								  foreach($qop->results() as $ov)
								  {   $str=''; 
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
									  if($strval==$value) $str=" checked='checked'";

									//for word find and replace rule
                                                                         $qrq="SELECT * FROM vcims.question_word_findreplace where qset = $qset AND rqid=$cqid AND cqid=$fcqid AND op_val = $fop;";
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
									//end of rule
									if($lang == 'none'){
										echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt <hr></td></tr>";
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

							$qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
							if($qop->count()>0)
							{  	echo "<table><input type=hidden name='qid[]' value=$qid>";
								//$qop=array_rand($qop);
								foreach($qop->results() as $ov)
								{     $str='';
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
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
							$qterm='';$str='';
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;
							}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $str=$rss2->first()->$qterm;}
							else $str="";

							echo "<input type=hidden name=qid value=$qid>";
							echo "<input type=text style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Type here'  name=text$qid id=q$qid value=$str >";
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
							else $str=".";

							echo "<input type=hidden name=qid value=$qid>";
							echo "<div style='float:left; width:75%;'><textarea id=q$qid name=text$qid cols=150 rows=5 >$str</textarea></div>";
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
		//begin of back button
echo "<br> Back.. pqstack=<br>";
print_r($_SESSION['pqstack']);

             	$pqstack=$_SESSION['pqstack']; 
		echo $sid = array_pop($pqstack);
		$_SESSION['pqstack']=$pqstack;
             	$maxsid=$_SESSION['maxsid'];

		if($sid>=0 && $sid<=$maxsid)
		{
			$sptr = $sid; $nptr = 3;$cqid=0;$cqid_arr_cnt = 0;
				if($sid > 0)
				{
					$sptr = $sid; $eptr=$sptr+$nptr;
					$cqid_arr=ptr_first_question($qset,$sptr,$eptr);
					$cqid_arr_cnt = count($cqid_arr);
echo "back before: sptr: $sptr, eptr: $eptr , cnt: $cqid_arr_cnt ;";
					//echo " next_s_question($qset,$sid,$table,$resp_id,$maxsid)";
					if($cqid_arr_cnt == 1){
						//--$sid;
						$pcqid_cnt=$_SESSION['cqid_cnt'];
						if($cqid_arr_cnt > 1) --$sid;
						$_SESSION['sid'] = $sid;
						//echo "<br> next_s_question($qset,$sid,$table,$resp_id,$maxsid)";
						$cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);
						$cqid_arr = array($cqid);
						//print_r($cqid_arr);
					}
					//$cqid_arr=next_s_question($qset,$sid,$table,$resp_id,$maxsid,$sptr,$eptr);
					
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
        $cqid_arr = array_unique($cqid_arr);
	//print_r($cqid_arr);
	if(!empty($cqid_arr))
	foreach($cqid_arr as $cqid){


	//--to check ques having grid rule-3 or not
	if(is_grid_question($cqid)){
//echo $_SESSION['sid'];
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
			//to show grod questions
			if(count($arr_qt) == 2){
				$iqid = $gqids[0];
				$ititle = $arr_temp[ $iqid ]['q_title'];
				echo "<tr><td style='padding:30px;'> $ititle </td></tr>";

				if($arr_qt[1] == 'dropdown'){
				      if($qset == 213){
					$dd = get_q_response($table,$resp_id,12322);
					//print_r($dd);
					$arr_pq=array();
					foreach($dd as $di){
					    if($iqid == 12328){
						if( $di == 1){$q=12329; array_push($arr_pq,$q);}
						if( $di == 2){$q=12330; array_push($arr_pq,$q);}
						if( $di == 3){$q=12331; array_push($arr_pq,$q);}
						if( $di == 4){$q=12332; array_push($arr_pq,$q);}
					     }
					     if($iqid == 12448){
                                                if( $di == 1){$q=12449; array_push($arr_pq,$q);}
                                                if( $di == 2){$q=12450; array_push($arr_pq,$q);}
                                                if( $di == 3){$q=12451; array_push($arr_pq,$q);}
                                                if( $di == 4){$q=12452; array_push($arr_pq,$q);}
					     }
					}
				     }
                                     if($qset == 219){
                                        $dd = get_q_response($table,$resp_id,12670);
                                        //print_r($dd);
                                        $arr_pq=array();
                                        foreach($dd as $di){
                                            if($iqid == 12674){
                                                if( $di == 1){$q=12675; array_push($arr_pq,$q);}
                                                if( $di == 2){$q=12676; array_push($arr_pq,$q);}
                                                if( $di == 3){$q=12677; array_push($arr_pq,$q);}
                                                if( $di == 4){$q=12678; array_push($arr_pq,$q);}
                                             }
                                             if($iqid == 12679){
                                                if( $di == 1){$q=12680; array_push($arr_pq,$q);}
                                                if( $di == 2){$q=12681; array_push($arr_pq,$q);}
                                                if( $di == 3){$q=12682; array_push($arr_pq,$q);}
                                                if( $di == 4){$q=12683; array_push($arr_pq,$q);}
                                             }
                                        }
                                     } //end of if qset


					//print_r($arr_pq);
					//$gqs = array_intersect($gqids,$arr_pq);
					echo "<table ID='myDiv'  style='padding-left:40px;  width:100%;'>";
				  for($i=0; $i < count($arr_pq); $i++){
					//$qid= $gqids[ $i ];
					$qid= $arr_pq[ $i ];
					$error=$qid.'e';
					$qtle=$arr_temp[ $qid ]['q_title'];
					//echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> </td><td><select class='big' name=q$qid id=q$qid><option value='0'>0</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select></td></tr>";
					echo "<tr>
                                                            <td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td>
                                                            <td>
                                                            <input type='text' name=text$qid id=op_$qid class='txtCalc' placeholder='0' required>
                                                            </td>
                                                            </tr>
                                         ";
				  }
                                    ?>                        <tr><td><font color=blue> Sum: <span id='total_sum_value'>0</span> </font><br><span id="msg"></span></td></tr>
				<?php

				    echo "</table>";
					}

                                if($arr_qt[1] == 'radio'){
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
					//to get qop detail
					//if($i == 1) $arr_qo = get_qop($qid);
                                        $qtle=$arr_temp[ $qid ]['q_title'];
					$error=$qid.'e';
//echo "<br> $qid - $error";
                                        echo "<tr><td>$qtle <input type=hidden name='qid[]' value=$qid> <font color=red><span id='$error'></span></font></td>";

					foreach($arr_qo_val as $ov){
						echo "<td style='background-color:lightgray'><input type='radio' class='big' id=q$qid name=q$qid value=$ov></td>";
					}
					echo "</tr>";
                                  }
                                    echo "</table>";
                                }
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
					echo "<tr><td style='padding:30px;'> $ititle </td></tr>";
                                        echo "<table border='1' cellspacing=0 cellpadding=0 style='padding-left:20px;'style='padding:30px;width:100%''><tr><td></td><td style='background-color:lightgray'> $textA <input type=hidden name='qid[]' value=$chqid ><font color=red><span id='$cerror'></span></font> </td style='background-color:lightgray'> <td> $textB <input type=hidden name='qid[]' value=$rqid ><font color=red><span id='$rerror'></span></font> </td> </tr>";
					$i=0;
                                        foreach($arr_qo as $qo){
                                        	$val = $arr_qo_val[ $i ];
						$aa='q'.$chqid.'[]';
						echo "<tr><td> $qo </td><td style='background-color:lightgray'><input type='checkbox' class='big' id=q$chqid name=$aa value=$val > </td> <td style='background-color:lightgray'><input type='radio' class='big' id=q$rqid name=q$rqid value=$val > </td><tr>";
						$i++; 
                                       }
	                                echo "</table>";

                        } //end of qtype count 3

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
							 echo "<p style='font-size:10px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
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
							  if($flag_show == 1){
								$sq = "SELECT `opt_text_value`,`term`,`value` FROM `question_option_detail` WHERE `q_id`=$cqid AND value IN ( $show_qids );";
							  }
							  $flag_show = 0; $isshow=false;
							  $qop=DB::getInstance()->query($sq);
							  if($qop->count()>0)
							  {  echo "<table> <input type=hidden name='qid[]' value=$qid>";
								  foreach($qop->results() as $ov)
								  {   $str=''; 
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
									  if($strval==$value) $str=" checked='checked'";

									//for word find and replace rule
                                                                         $qrq="SELECT * FROM vcims.question_word_findreplace where qset = $qset AND rqid=$cqid AND cqid=$fcqid AND op_val = $fop;";
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
									//end of rule
									if($lang == 'none'){
										echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td style='border-bottom: 1px solid #ff;'> $opt <hr></td></tr>";
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

							$qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
							if($qop->count()>0)
							{  	echo "<table><input type=hidden name='qid[]' value=$qid>";
								//$qop=array_rand($qop);
								foreach($qop->results() as $ov)
								{     $str='';
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
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
							$qterm='';$str='';
							$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;
							}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $str=$rss2->first()->$qterm;}
							else $str="";

							echo "<input type=hidden name=qid value=$qid>";
							echo "<input type=text style='background-color:lightgray;width:100%; height:40px;font-size:16px;padding:20px;' placeholder='Type here'  name=text$qid id=q$qid value=$str >";
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
							else $str=".";

							echo "<input type=hidden name=qid value=$qid>";
							echo "<div style='float:left; width:75%;'><textarea id=q$qid name=text$qid cols=150 rows=5 >$str</textarea></div>";
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

		//end of back button 
	} //end of back button
	if($cqid!=-1){
?> 

	<br><font size=2 color=red><div id=err></div></font>       

       <?php $arr=$_SESSION['qstack']; if( $arr[0]!=$qid){  ?>
	  <input type='submit' name='back' value="&#8249; Back" class="previous round" style="padding: 8px 16px;display: inline-block;" >
      <?php } ?>
	  <input type='submit' id='btn' name='next' value="Next" class="next" onclick='return Validate();' style='background-color:#004c00;color:white;height:35px; margin-left:50%; float:center; padding: 8px 16px;display: inline-block;'><br><br> 
	  <?php } ?>
	  </center>  
	                                
	  </div>
	        
	 <input type='hidden' id='temp'>
	</form>

</td></tr></table>
<div class="copyright" style="font-size:11px;bottom:0;position:fixed;  background-color:gray;color:white;width:100%;"><p style="float:center;" &copy; 2018 VareniaCIMS Private Limited. All Rights Reserved.</p></div>
	</body>
	  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
	        alert(qq);
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
		alert('qid:'+qq+' ctr:'+ctr+'- err:'+error+'-flag:'+flag);
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
	      { flag=0; window.stop();return false;}
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
  
  if(max > sum || max < sum)
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

