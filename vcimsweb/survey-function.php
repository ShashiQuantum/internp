<?php
include_once('../vcimsweb/init.php');

//for notification only
include_once('gcm/send_message.php');
include_once('gcm/GCM.php');
include_once('gcm/config.php');


//to save respondent sected values
function first_question($p)
{
    $q=DB::getInstance()->query("SELECT `qid` FROM `question_sequence` WHERE `qset_id`=$p and `sid`=1");
    if($q)
      { $_SESSION['sid']=1; return $q->first()->qid;}
     else
        return 0;
}
//to save respondent selected values
function save_result($post,$table,$qset,$resp)
{
    $sp=count($post);
    $arr_post=array(); 
    if($sp>1)
    { 
    $qid=$post['qid'];
    $qterm='';$qtype="";
      
    foreach($post as $k=>$v)
    {          
        if($k!='next')
        {
            if($k != 'qid')
            {
                if($v!='')if($v!='others')
                        array_push($arr_post,$v);
            }
        }
    }
    $empty=count($arr_post);
  if($empty!=0)
  {
    $qtf="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
    $qtdd=DB::getInstance()->query($qtf);
    if($qtdd->count()>0){  $qtype=$qtdd->first()->q_type;}
     
//for textrating
	if($qtype=='titlewithonerating')
        {      
                                             
                   $arrq=array();$arr_column1=array();$arr_column2=array();$arr_table=array();
                           //$qid==2390
	                   if( $qid==2000)
	                   {$arr_post=array(); $arr_postt=array();$arr_postr=array(); $bctr=0;
	                       foreach($post as $k=>$v)
	                       { 
	                               if($k != 'qid')
	                               {  
	                                   $bctr++; //echo "<br>bctr:$bctr k: $k v:$v";
	                               
	                                  if ( $k!='t0')if ( $k!='t1')if ( $k!='t2')if ( $k!='t3')if ( $k!='t4')if ( $k!='t5')if ( $k!='t6')if ( $k!='t7')
	                                  if ( $k!='t8')if ( $k!='t9')if ( $k!='t10')if ( $k!='t11')
	                                  if($v!='') 
	                                  {     $tvall='';
	                                  	if($bctr==2)
	                                      	{ $tvall =1; }
	                                      	if($bctr==4)
	                                      	{ $tvall =2; }
	                                      	if($bctr==6)	
	                                      	{ $tvall =3; }
	                                      	if($bctr==8)
	                                      	{ $tvall =4; }
	                                      	if($bctr==10)
	                                      	{ $tvall =5; }
	                                      	if($bctr==12)
	                                      	{ $tvall =6; }
	                                      	if($bctr==14)
	                                      	{ $tvall =7; }
	                                      	if($bctr==16)
	                                      	{ $tvall =8; }
	                                      	if($bctr==18)
	                                      	{ $tvall =9; }
	                                      	if($bctr==20)
	                                      	{ $tvall =10; }
	                                      	if($bctr==22)
	                                      	{ $tvall =11; }
	                                      	
	                                      	if($k != 'next')
	                                      	{
	                                      		//echo "<br>tvall:$tvall v: $v";
	                                      		array_push($arr_post,$tvall);
	                                      		array_push($arr_post,$v);
	                                     	}
	                                  }
	                               }
	                            
	                        } //print_r($arr_post);
	                        
	                     
	                   }// end of qid 2390
                 // print_r($arr_post);
              
                   //to find table and its column search
                   $column1='';$column2='';$qrv=0;
                   $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term, textbox_count FROM `question_option_detail` WHERE `q_id`=$qid ");
                   if($rd)
                   {
                          $tb_count=$rd->first()->textbox_count;
                          $qrv=$tb_count;
                          $column1=$rd->first()->text_term;
                          $column2=$rd->first()->rating_term;
                   }
                                                                         
                     $stat2="SELECT $column1,$column2 FROM $table WHERE resp_id=$resp AND $column1!=0 AND $column2!='0'";
                     $rst=DB::getInstance()->query($stat2);
                     if($rst->count()>0)
                     {
                           $stat="DELETE FROM $table  WHERE resp_id=$resp AND q_id=$qset AND $column1!=0 AND $column2!='0'";
                           $rs=DB::getInstance()->query($stat);
                           $tqrv=$qrv*2;                                   
                           for($i=0;$i<$tqrv;$i+=2)
                           {   
                               $ii=$i+1;
                               if($arr_post[$i]!='')
                               {  //echo "<br>".
                                $stat="INSERT INTO $table (resp_id,q_id,$column1,$column2) VALUES($resp,$qset,'$arr_post[$i]','$arr_post[$ii]')";
                               $ii=0;
                               $rs=DB::getInstance()->query($stat);
                               }
                           }
                      }
                      else
                      {    //print_r($arr_post); echo "qrv:$qrv";
                           $tqrv=$qrv*2;
                          for($i=0;$i<$tqrv;$i+=2)
                          {   
                               $ii=$i+1;  
                               if($arr_post[$i]!='')
                               {
                              echo  $stat="INSERT INTO $table (resp_id,q_id,$column1,$column2) VALUES($resp,$qset,'$arr_post[$i]','$arr_post[$ii]');";
                               $ii=0;
                               $rs=DB::getInstance()->query($stat);
                               }
                          }
                       }  
                                                                     
      }//end if of qt titlewithonerating
      else
      {

	    //echo "<br>Save called for qid:$qid";                                            
	    //to get the question term
	    $ss="SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid";
	    $qq=DB::getInstance()->query($ss);
	    if($qq->count()>0)
	    {   $f=0;
	               $qterm=$qq->first()->term;
	    }                                     
//echo "<br>te=$qterm Tab= $table resp=$resp qset= $qset" ;
	    if($qterm!='' && $table!='' && $resp!='' && $qset!='')
	    {   //echo "<br>SELECT count($qterm) as vv FROM $table WHERE q_id=$qset AND resp_id=$resp AND $qterm!=''";
	       	$qrs=DB::getInstance()->query("SELECT count($qterm) as vv FROM $table WHERE q_id=$qset AND resp_id=$resp AND $qterm!=''");
	       	if($qrs->count()>0)
	       	{       $cnt=$qrs->first()->vv;
	       		if($cnt==1)
	       		{
			        foreach($arr_post as $k=>$val)
			        {
			           $qry="UPDATE $table SET $qterm='$val' WHERE resp_id=$resp AND q_id=$qset AND $qterm!=''";
			           DB::getInstance()->query($qry);
			        }
			}
			else 
			{
			     $qry2="DELETE FROM $table WHERE resp_id=$resp AND q_id=$qset AND $qterm!=''";
			     DB::getInstance()->query($qry2);
			     
				foreach($arr_post as $k=>$val)
			        {
			           $qry="INSERT INTO $table (resp_id, q_id, $qterm) VALUES ($resp, $qset,'$val');";
			           DB::getInstance()->query($qry);
			        }
			}
	     	}
	     	else 
	     	{
	     		foreach($arr_post as $k=>$val)
		        {
		            echo "<br>". $qry="INSERT INTO $table (resp_id, q_id, $qterm) VALUES ($resp, $qset,'$val');";
		             DB::getInstance()->query($qry);
		        }
	     	}
	     	
	     	
	      }     
	    }//end of qt else
        }//end of empty
        else
        {
            echo "Please select options";
        }
    }// end of if count size                  
}

//to get next question sequence 
function next_s_question($p,$sq,$t,$r,$maxsid)
{ 
 
  while(1)
  {  
    //echo "<br>$maxsid nsq sid:$sq";
    if($sq==$maxsid)
    { return -1;}
    $sq++; $_SESSION['sid']=$sq; 
    //echo "<br>SELECT `qid`,sid,chkflag FROM `question_sequence` WHERE `qset_id`=$p and `sid`=$sq;";
    $q=DB::getInstance()->query("SELECT `qid`,sid,chkflag FROM `question_sequence` WHERE `qset_id`=$p and `sid`=$sq");
    if($q->count()>0)
    { 
          $_SESSION['sid']=$sq; $qid=$q->first()->qid; $sid=$q->first()->sid; $flag=$q->first()->chkflag; 
 
           //to check routine condition   
           if($flag==1)
           {
                $rtnv=routine_check($p,$qid,$t,$r);
                    //echo "<br>r ch: $rtnv <br>";
                if($rtnv>0)
                {
                     //to continue with qid
                      if($rtnv==1 )
                      { $_SESSION['sid']=$sq++;  return $qid;}
                     //to terminate
                      if($rtnv==3 || $rtnv==2)
                      { $_SESSION['sid']=-1;   return -1; } 
                }
                else 
                {
                      //skip the current sid qid and find the next
                      //$_SESSION['sid']=$sq++; 
			//if($rtnv == 0) return $qid;
                      continue;
                }
           }
           else
           {
                return $qid;
           }
    }
    else
        return 0;
   }
}

//to check question routine
function routine_check($p,$qd,$t,$r)
{ 
 //echo "<br>rc qid:$qd";
               //sec routine
    if($qd==2369)
     {
         $count=0;$edu='';
/*
         $q1="SELECT count(q4_49) as cnt FROM Dipstick_49 WHERE q4_49!='' and resp_id=$r";
         $qu1=DB::getInstance()->query($q1);
         { if($qu1->count()>0){ $count=$qu1->first()->cnt; }}
         $q2="SELECT q5_49 FROM Dipstick_49 WHERE q5_49!='' and resp_id=$r";
         $qu2=DB::getInstance()->query($q2);
         {if($qu2->count()>0){   $edu=$qu2->first()->q5_49;}  }
         
         $sec=array(
                                                   array('E3','E2','E2','E2','E2','E1','D2'),
                                                   array('E2','E1','E1','E1','D2','D2','D2'),
                                                   array('E1','E1','D2','D2','C2','C2','C2'),
                                                   array('D2','D2','D1','D1','C2','C2','C2'),
                                                   array('D1','C2','C2','C1','C1','B2','B2'),
                                                   array('C2','C1','C1','B2','B1','B1','B1'),
                                                   array('C1','B2','B2','B1','A3','A3','A3'),
                                                   array('C1','B1','B1','A3','A3','A2','A2'),
                                                   array('B1','A3','A3','A3','A2','A2','A2'),
                                                   array('B1','A3','A3','A2','A2','A1','A1'),
                                                   array('B1','A3','A3','A2','A2','A1','A1'),
                                                   array('B1','A3','A3','A2','A2','A1','A1')
                                                   
                                               ); // echo "<br>ss:[$count][$edu-1];";
                                              $ss=$sec[$count][$edu-1];
                                               $sd=6;
                                               if($ss=='A1')
                                               {     $sd=1; }
                                               if($ss=='A2')
                                               {    $sd=2;}
                                               

                                                    //echo "<br>sec:".$sd;
                                                   
                                                if($sd==1 || $sd==2)
                                               	{ 
                                               	  	DB::getInstance()->query("INSERT INTO `Dipstick_49`( `resp_id`, `q_id`,`sec_49`) VALUES ($r,49,$sd)");
                                               	  		
                                               	 	 return 1;
                                               	}
                                               else {  $_SESSION['sid']=-1; return 3;}
*/
     } //end sec routine
 else
{

     //echo "<br>SELECT `qid`, `pqid`, `opval`, `flow` FROM `question_routine_check` WHERE qset_id=$p and qid=$qd order by flow desc";

     $qs=DB::getInstance()->query("SELECT `qid`, `pqid`, `opval`, `flow` FROM `question_routine_check` WHERE qset_id=$p and qid=$qd order by flow desc");
     if($qs->count()>0)
     {   $flag=0;
            $qtype=''; $fflag=0;
     	$flow0flag=0;
     	$flow1flag=0;
     	$flow2flag=0;
         //$qid=$q->first()->qid; $pqid=$q->first()->pqid; $op=$q->first()->opval; $flow=$q->first()->flow;
         //echo "<br>Tot:".$qs->count();
             
           foreach($qs->results() as $w)
           {   $f=0;   
               $qid=$w->qid; $pqid=$w->pqid; $op=$w->opval; $flow=$w->flow;
               
               $term='';
           $ss="SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$pqid";
           $qq=DB::getInstance()->query($ss);
           if($qq->count()>0)
           {   $f=0;
               $term=$qq->first()->term;
           }

              
      	$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$pqid");
     	if($ques->count()>0)
     	{ 
          $qtype=$ques->first()->q_type;
     	}
         
                $vfound=get_opvalue($term,$t,$op,$r);
               //echo "<br>f:".$vfound
		//echo "<br> op:$op , $qtype $flow vf:$vfound";
               if($vfound > 0 && $flow==0)
               { $flag=1; $flow0flag=1; //return 1;
               }
               if($vfound > 0 && $flow==1)
               {   
                  $flag=1; $flow1flag=1;
                  if($qtype=='checkbox')
                  {
                      //return 1; 
                  }
                  else
                  { 
                       //return 2;
                  }

               }
               if($vfound > 0 && $flow==2)
               {   $flag=1;$flow2flag=1; //return 2; 
               }
                  // echo "<br>vf: $vfound  , FL:$flow ,f0:$flow0flag , f1= $flow2flag ";
           } //end of foreach

           //continue anyway routine
            //  echo "<br>fnd:$vfound ,f0:$flow0flag , f1= $flow1flag , f2= $flow2flag";
            if($qtype=='checkbox')
            {
               if($flow0flag==1 && $flow1flag==1 && $flow2flag==0)
               { $flag=1;  return 1; //for anyway continue
               }
               else if($flow2flag==1)
               { $flag=1;  return 2;  //for anyway terminate
               }
               else if($flow0flag==1 && $flow1flag==0 && $flow2flag==0)
               { $flag=1;  return 1;
               }
               else if($flow0flag==0 && ($flow1flag==1 || $flow2flag==1))
               { $flag=1;  return 2; //for anyway terminate if perticular option is not selected to continue
               }
                
               else if($flow0flag==0 && $flow1flag==0 && $flow2flag==0){ return 0;}

               else if($flow0flag==1 || $flow1flag==0)
               { $flag=1; return 1;
               }

             }
             else
             { 
               if($flow0flag==1)
               { $flag=1;  return 1;
               }
               else if($flow1flag==1 || $flow2flag==1)
               { $flag=1; return 2;
               }
                

             }

               if($vfound > 0 && $flow==1)
               {   
                  $flag=1; $flow1flag=1;
                  if($qtype=='checkbox')
                  {
                      return 1; 
                  }
                  else
                  { 
                       return 2;
                  }

               }
               if($vfound > 0 && $flow==2)
               {   $flag=1;$flow2flag=1; return 2; }

           //end of continue anyway
             if($flag==0)
               {   return 0; }  
     }
     else
        return 0;
 }//end else       
    
}

//to get options value;
function get_opvalue($term,$t,$op,$r)
{
     //echo "<br>SELECT $term FROM $t WHERE $term='$op' and resp_id=$r";
     $dd="SELECT $term FROM $t WHERE $term='$op' and resp_id=$r";
               $qqq=DB::getInstance()->query($dd);
              //echo "<br>cnt:".$qqq->count();
               if($qqq->count()>0)
               {
                      return 1;
               }
               else if($qqq->count()<=0){ return 0; }
}

//for sending project survey request mangopinion resp_id
function do_survey($qset,$resp,$rpnt)
{           //echo "<br>qs=$qset , r=$resp, p=$rpnt";
		if($qset!='' || $resp!='')
		{
					
			        $pnn='';$ped='';
					
					$ddd1=DB::getInstance()->query("SELECT name, `survey_end_date` FROM project WHERE  `project_id`=$qset");
					if($ddd1->count()>0)
					{$pnn=$ddd1->first()->name;$ped=$ddd1->first()->survey_end_date; }
			                $qr="select * from `appuser_project_map`  WHERE `appuser_id`=$resp AND `project_id`=$qset AND `status`=0";
					$dsa=DB::getInstance()->query($qr);
						
					if($dsa->count()<1)
					{   
						
						$qrr="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`,  `status`) VALUES ($qset,$resp,0)";
						DB::getInstance()->query($qrr);
						 
						DB::getInstance()->query("UPDATE `appuser_project_map` SET  `cr_point`=$rpnt ,`exp_date`=''  WHERE `appuser_id`=$resp AND `project_id`=$qset AND `status`=0");
	  
						$rq2="SELECT a.user_id, a.user_name as name, a.user as user  FROM app_user as a join  `mangopinion_57` as b on a.user_id=b.resp_id WHERE a.user_id=$resp  and b.email!=''";
						$rr2=DB::getInstance()->query($rq2);
						if($rr2->count()>0)
						{       $cuid=$rr2->first()->user_id;
							$usern=$rr2->first()->name;
							 $user=$rr2->first()->user;
							
							//code for send GCM Notification to user
										$msg="Hi $usern , A new contest named : $pnn , is added for you in your Mangopinion App";
										
										$rq2="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM `gcm_users` WHERE `user_id`=$cuid";
							$rr2=DB::getInstance()->query($rq2);
							if($rr2->count()>0)
							{ 
												//$nctr++;
								 $usern=$rr2->first()->name;
								$user_id=$rr2->first()->user_id; 
												$gcmid=$rr2->first()->gcm_regid;		    			
								notifymp($gcmid, $msg);  
							}
		
							/*				//code for send email
												$to=$user;
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Mangopinion<contact@mangopinion.com>'. "\r\n" .'Reply-To: contact@mangopinion.com' ;
							$m='Dear '.$usern.', <br><br><br> Thanks for using Mangopinion App! One more contest is added for you. <br> Please go to Mangopinion App to share your valuable opinion.  <br><br><br> Thanks,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
							$s="A Contest is added to your Mangopinion account ";
							$fs= mail($to, $s, nl2br($m), $headers);
					              */
						}
					}
                                        if($dsa->count()>0)
					{   
						
						$qrr="INSERT INTO `appuser_project_map`(`project_id`,`appuser_id`,  `status`) VALUES ($qset,$resp,0)";
						//DB::getInstance()->query($qrr);
						 
						//DB::getInstance()->query("UPDATE `appuser_project_map` SET  `cr_point`=$rpnt ,`exp_date`=''  WHERE `appuser_id`=$resp AND `project_id`=$qset AND `status`=0");
	  
						$rq2="SELECT a.user_id, a.user_name as name, a.user as user  FROM app_user as a join  `mangopinion_57` as b on a.user_id=b.resp_id WHERE a.user_id=$resp  and b.email!=''";
						$rr2=DB::getInstance()->query($rq2);
						if($rr2->count()>0)
						{       $cuid=$rr2->first()->user_id;
							$usern=$rr2->first()->name;
							 $user=$rr2->first()->user;
							
							//code for send GCM Notification to user
										$msg="Hi $usern , A new contest named : $pnn , is added for you in your Mangopinion App";
										
										$rq2="SELECT `user_id`, `gcm_regid`, `name`, `email`, `mob`, `created_at` FROM `gcm_users` WHERE `user_id`=$cuid";
							$rr2=DB::getInstance()->query($rq2);
							if($rr2->count()>0)
							{ 
												//$nctr++;
								 $usern=$rr2->first()->name;
								$user_id=$rr2->first()->user_id; 
												$gcmid=$rr2->first()->gcm_regid;		    			
								notifymp($gcmid, $msg);  
							}
		
							/*				//code for send email
												$to=$user;
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Mangopinion<contact@mangopinion.com>'. "\r\n" .'Reply-To: contact@mangopinion.com' ;
							$m='Dear '.$usern.', <br><br><br> Thanks for using Mangopinion App! One more contest is added for you. <br> Please go to Mangopinion App to share your valuable opinion.  <br><br><br> Thanks,<br>Admin<br><img  src=www.digiadmin.quantumcs.com/images/mangopinion_full_logo.png height=50 width=100><br>';
							$s="A Contest is added to your Mangopinion account ";
							$fs= mail($to, $s, nl2br($m), $headers);
					              */
						}
					}
					
		}
}


?>
