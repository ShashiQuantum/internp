<?php
ob_start();
include_once('../init.php');
include_once('../survey-function.php');      
 
   // print_r($_SESSION);
    $table='';$sid='';$qset='';$resp_id='';
	$resp_id=0;$qset=0;$currq=0;$next_qstack=array();

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
    {	$tarr=$_SESSION['pqstack'];
                //print_r($tarr);
    }
?>

	<!DOCTYPE html>
	<html lang="en-us">
	<head>
        
	<style>
	.w3-light-grey,.w3-hover-light-grey:hover,.w3-light-gray,.w3-hover-light-gray:hover{color:#000!important;background-color:#f1f1f1!important}
	.w3-green,.w3-hover-green:hover{color:#fff!important;background-color:#4CAF50!important}
	.w3-center .w3-bar-item{text-align:center}.w3-block{display:block;width:100%}
	.w3-center .w3-bar{display:inline-block;width:auto}
	.w3-center{text-align:center!important}
	.city {
	   float: left;
	   margin: 30px;
	   padding: 50px;
	   max-width: 1200px;
	   height: 300px;
	   border: 1px solid black;
	}
	body {background:#fff}
	
	.effect1{
	    -webkit-box-shadow: 0 10px 6px -6px #777;
	       -moz-box-shadow: 0 10px 6px -6px #777;
	            box-shadow: 0 0 5px #888;
	            margin: 5px; text-align:justify;
	            max-width: 1800px;
	            max-height: 250px;
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
	
	</style>
	</head>
	<body>


 	<form method="post" action=""> 
	<?php 
	if(isset($_POST['submit']))
	{ 
                    date_default_timezone_set('asia/calcutta');
                    $date = date('Y/m/d H:i:s');
                    $newURL='';
                    $qqq="UPDATE `respondent_link_map` SET `status`=2, `end_time`='$date' WHERE resp_id=$resp_id AND qset_id=$qset";
                    DB::getInstance()->query($qqq);
                    //session_destroy();
                    //echo '<br>Thank You! Submitted';
                    if($qset>=97)
                    {  
                       echo $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/fp.php?qset=$qset";                        
                    }         
                     header('Location: '.$newURL);
    
	}
 
	if(isset($_POST['next']) || $sid==0)
	{   
        //print_r($_POST); 

			date_default_timezone_set('asia/calcutta');        
			$date = date('Y/m/d H:i:s');
			$cq=0;
			if($sid > 0)
			{
				$cq=$_POST['qid'];
                              
                                    if($cq==5526) 
						save_result($_POST,$table,$qset,$resp_id); 
				if(Session::exists('wqstack'))
             	{	
                	$tarr=$_SESSION['wqstack'];array_push($tarr,$cq);$_SESSION['wqstack']=$tarr;
             	}else { $arrr=array();array_push($arrr,$cq);$_SESSION['wqstack']=$arrr;}
			}
 
			$maxsid=0;$qtype='';
        
			$qa=DB::getInstance()->query("SELECT max(sid) as ms FROM `question_sequence` WHERE `qset_id`=$qset");
			if($qa->count()>0)
			{
				 $_SESSION['maxsid']=$maxsid=$qa->first()->ms;             
			}        
			if(Session::exists('sid'))
				   $sid=$_SESSION['sid'];
				  //echo "<br>maxsid:".$maxsid;
			if($sid>$maxsid) $sid=0;$qlist=array();
			//continue if sid >=0 and sid<=maxsid else terminate
			//echo "<br>SID:$sid mx:$maxsid <br>";
			//echo "$prc=($sid * 100)/$maxsid ";
			$prc=($sid * 100)/$maxsid ;
			$prc=round($prc);
			echo "<div class='w3-light-grey'> <div class='w3-container w3-green w3-center' style=width:$prc%>$prc %</div></div><br>";
		if($sid>=0 && $sid<=$maxsid)
		{
                                
			   
				if($sid==0)
				{
						$cqid=first_question($qset);
				}
				else
				{  
					$cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);
					if(Session::exists('pqstack'))
					{	$tarr=$_SESSION['pqstack']; 
						   $pqid=end($tarr);
					   if($cqid!=$pqid)
					   { $arr=$_SESSION['qstack'];$end=end($arr); array_push($arr, $end);  $_SESSION['pqstack']=$arr;}
					}
				}
				//for go to submit form
			if($cqid==-1)
			{  save_result($_POST,$table,$qset,$resp_id);
						//termination code
									  
						echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br>Please click on submit button to complete the survey.</font></center>";
						  
						  echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
		
						//end termination
			}
			else
			{
					$sid=$_SESSION['sid'];
					$next_qstack=array();  $arr=array();
					if($sid==1){ $arr1=array();$_SESSION['qstack']=$arr1;array_push($arr1, $cqid);$_SESSION['pqstack']='';$_SESSION['pqstack']=$arr1; }
					if(Session::exists('qstack'))
					$next_qstack=$_SESSION['qstack'];
					array_push($next_qstack, $cqid); 
					$_SESSION['qstack']=$next_qstack;
					
					//to save the 
					//echo "cq= $cq ,cqid= $cqid";
					if($cqid==5386) 
						save_result($_POST,$table,$qset,$resp_id); 
			   
				$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
				if($ques->count()>0)
				{ 
							 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
							 $error=$qid.'e';

							 echo "<div class=effect1>";  
							 echo "<p style='font-size:12px;'>$qid / $qno</p><p>$qtitle</p><font color=red><span id='$error'></span></font></div>";
								
								if($qtype=='radio')
								{     
									$qterm='';$strval='';
									$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
							if($qrs->count()>0)
							{      $qterm=$qrs->first()->term;}
							$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
							$rss2=DB::getInstance()->query($sql);
							if($rss2->count()>0) 
							{ $strval=$rss2->first()->$qterm;}
							else $strval="";
							
							  $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
							  if($qop->count()>0)
							  {  echo "<table> <input type=hidden name='qid' value=$qid>";
								  foreach($qop->results() as $ov)
								  {   $str=''; 
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
									  if($strval==$value) $str=" checked='checked'";
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt</td></tr>";
								  }
								 echo "</table>";
							  } 
					   }
					   
					    if($qtype=='checkbox')
						{    
							$qterm='';$arr_temp=array();
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
							
							//print_r($_SESSION);
							//echo "<br>SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid";

							$qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
							if($qop->count()>0)
							{  	echo "<table><input type=hidden name=qid value=$qid>";
								foreach($qop->results() as $ov)
								{     $str='';
									  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
									  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
									  if(in_array($value,$arr_temp))
									  { 
											$str="checked='checked'";
									  }
									  if($cqid==5386 || $cqid==5387 || $cqid==5388) 
									  {   
											$qp=DB::getInstance()->query("SELECT  q1_97  FROM `irc_97` WHERE `resp_id`=$resp_id");
											if($qp->count()>0)
											{
												 foreach($qp->results() as $pp)
												 {   $pqv=$pp->q1_97;
		   
													if($value==$pqv)
												echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";         
												 }
											}
									  }
									  else
									  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
									  
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
							else $str="..";

							echo "<table><input type=hidden name=qid value=$qid>";
							echo "<tr><td><input type=text name=text$qid id=q$qid value=$str> </td></tr></table>";
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
							else $str="..";

							echo "<table><input type=hidden name=qid value=$qid>";
							echo "<tr><td><textarea id=q$qid name=text$qid cols=150 rows=5 >$str</textarea>  </td></tr></table>";
					   }
					   
				}
				if($qtype=='text' || $qtype=='textarea' || $qtype=='radio' || $qtype=='checkbox' || $qtype=='rating' || $qtype=='dropdown') 
				{    
					  array_push($qlist,$qid);
					  if($cqid!=5386) 
					  save_result($_POST,$table,$qset,$resp_id);
				}
			}// end of else
        }
        else
        {
            //termination code
               echo 'Last Question';              
                    echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br>You can review your responses to all previous questions before final submission of the survey otherwise click on submit button to complete survey</font></center>";
                      
                      echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
    
             //end termination
        }
	}

	if(isset($_POST['back']))
	{       

             	$pqstack=$_SESSION['wqstack']; 
		$cqid = array_pop($pqstack);
             	$_SESSION['wqstack']=$pqstack;
             	$maxsid=$_SESSION['maxsid'];
				 /*            	
				echo " $prc=($sid * 100)/$maxsid";            	
				$prc=($sid * 100)/$maxsid ;
				echo '<br>'.$prc=round($prc);

				echo "<div class='w3-light-grey'> <div class='w3-container w3-green w3-center' style=width:$prc%>$prc %</div></div><br>";
				*/
				//print_r($_SESSION);
				//echo "<br>SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid";

		$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
        if($ques->count()>0)
        { 
                 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
                 echo "<div class=effect1>";  
                 echo "<p style='font-size:12px;'>$qid / $qno</p><p>$qtitle</p></div>";
                    
            if($qtype=='radio')
			{     
                        $qterm='';$strval='';
                        $qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
					    if($qrs->count()>0)
					    {   $qterm=$qrs->first()->term; }
                        $sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
                        $rss2=DB::getInstance()->query($sql);
                        if($rss2->count()>0) 
                        { $strval=$rss2->first()->$qterm;}
                        else $strval="";
                        
                        $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
                        if($qop->count()>0)
                        {  	echo "<table> <input type=hidden name=qid value=$qid>";
                            foreach($qop->results() as $ov)
                            {     $str=''; 
                                  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
                                  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
                                  if($strval==$value) $str=" checked='checked'";
                                  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='xa' id=q$qid name=q$qid $str value='$value'></td><td> $opt</td></tr>";
                            }
                             echo "</table>";
                        } 
			}
                   
            if($qtype=='checkbox')
            {    
                    	$qterm='';$arr_temp=array();
                       	$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
						if($qrs->count()>0)
						{  $qterm=$qrs->first()->term; }
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
                        
                        
                        $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
                        if($qop->count()>0)
                        {  	
							echo "<table><input type=hidden name=qid value=$qid>";
                            foreach($qop->results() as $ov)
                            {   $str='';
                                  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
                                  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
                                  if(in_array($value,$arr_temp))
                                  { 
                                      	$str="checked='checked'";
                                  }
                                  if($cqid==5386 || $cqid==5387 || $cqid==5388) 
                                  {
                                        $qp=DB::getInstance()->query("SELECT  q1_97  FROM `irc_97` WHERE `resp_id`=$resp_id");
                                        if($qp->count()>0)
                                        {
                                             foreach($qp->results() as $pp)
                                             {  $pqv=$pp->q1_97;
                                                if($value==$pqv)
                                            echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
                                             }
                                        }
                                  }
                                  else
                                  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='xa' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
                                  
                            }
                            echo "</table>";
                        } //end of if
            }
                   
            if($qtype=='rating')
            {    
                        $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
                        if($qop->count()>0)
                        {  	
							echo "<table><input type=hidden name=qid value=$qid>";
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
										echo "<td> $el </td><td><input type=radio name=r$qid value=$s></td></tr></table>";                                
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
											echo "<td><input type=radio name=r$qid $str value=$s> </td>";
										}
										echo "<td> $el </td></td></tr></table>"; 
									}
                                
                            } //end of foreach
                            echo "</table>";
                        } 
            }
            if($qtype=='text')
            { 
                        $qterm='';$str='';
                       	$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
			if($qrs->count()>0)
			{  $qterm=$qrs->first()->term;}
                       	$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
                        $rss2=DB::getInstance()->query($sql);
                        if($rss2->count()>0) 
                        { $str=$rss2->first()->$qterm;}
                        else $str="..";
                       	echo "<table><input type=hidden name=qid value=$qid>";
                       	echo "<tr><td><input type=text name=txt$qid  value=$str> </td></tr></table>";
            }
            if($qtype=='textarea')
            { 
                        $qterm='';$str='';
                       	$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
			if($qrs->count()>0)
				{  $qterm=$qrs->first()->term; }
			$sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
                        $rss2=DB::getInstance()->query($sql);
                        if($rss2->count()>0) 
                        { $str=$rss2->first()->$qterm;}
                        else $str="..";
                       	echo "<table><input type=hidden name=qid value=$qid>";
                       	echo "<tr><td><textarea id=q$qid name=text$qid cols=150 rows=5 >$str</textarea>  </td></tr></table>";
            }
                   
        }
            $ww="SELECT `qid`,sid,chkflag FROM `question_sequence` WHERE `qset_id`=$qset and `qid`=$qid";
    		$q=DB::getInstance()->query($ww);
    		if($q->count()>0)
    		{ 
          		 $sid=$q->first()->sid;
          		 $_SESSION['sid']=$sid;
          	}
          
	} //end of back button
	if($cqid!=-1){
?> 

	<br><br><font size=2 color=red><div id=err></div></font>       

       <?php $arr=$_SESSION['qstack']; if( $arr[0]!=$qid){  ?>
	  <input type='submit' name='back' value="&#8249; Back" class="previous round" style="padding: 8px 16px;display: inline-block;" >
      <?php } ?>
	  <input type='submit' name='next' value="Next &#8250;" class="next" onclick='return Validate();' style='background-color:#004c00;color:white;height:35px;position:absolute; left:50%; float:right; padding: 8px 16px;display: inline-block;'> 
	  <?php } ?>
	  </center>  
	                                
	  <br><br><br>
	  </div>
	        
	 <input type='hidden' id='temp'>
	</form>
	
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
	        var qq='q'+elm; var nm='text'+elm;
	        var radios = document.getElementsByName(qq); 
	      
	        var et=document.getElementById(qq).type;
	        // alert(qq);
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
		         var nm=document.getElementById(qq).name; var ln=nm.length; var res = nm.substring(0,ln-1);
		
		        for (var i = 1; i <= oRadio.length; i++) 
		        {  
		                var vstr=res+i; 
		                //alert(vstr);
		                 var radi = document.getElementsByName(vstr);
		                if (radi[0].checked) 
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
	        if (et == 'text' || et=='textarea') 
	        {    
	              if(document.getElementById(qq).value=='')  
	              {
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
	    
	    if(error==0 && flag==0)
	      { return true;}
	    if(error>0 || flag>=1)
	      { flag=0; window.stop();return false;}
	}
	
	</script>

	<style>
	.big{ width: 2em; height: 2em; }
	
	    body {
	    font-family: 'Source Sans Pro', sans-serif;
	    margin: 0;
	    padding: 0;
	    text-align: justify;
	    text-justify: inter-word;
	    text-decoration: none;
	    font-size: 150%;
	    background-color: #F9FCF8; 
	    margin-top: 95px;
	    margin-bottom: 5px;
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