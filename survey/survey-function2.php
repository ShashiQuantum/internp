<?php
include_once('../vcimsweb/init.php');


//to save respondent sected values
function first_question($p)
{
    $q=DB::getInstance()->query("SELECT `qid` FROM `question_sequence` WHERE `qset_id`=$p and `sid`=1");
    if($q)
      { $_SESSION['sid']=1; return $q->first()->qid;}
     else
        return 0;
}
function get_q_response($t,$r,$qid)
{
		   $ss="SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid limit 1;";
		   $qq=DB::getInstance()->query($ss);
           	   if($qq->count()>0)
           	   {   $f=0;
               		$term=$qq->first()->term;
			   $resp_values=array();
	                   $sqq = "SELECT distinct $term as xx FROM $t WHERE resp_id=$r and $term !='';";
        	           $qqs=DB::getInstance()->query($sqq);
                	   if($qqs->count()>0){
				foreach($qqs->results() as $qr){
					$vv = $qr->xx;
					array_push($resp_values,$vv);
				}
				return $resp_values;
			   }
		    }
}
function get_qop($q,$col)
{
    $qod=DB::getInstance()->query("SELECT distinct $col as xx FROM `question_option_detail` WHERE `q_id`=$q and $col!='' order by value;");
    if($qod->count()>0)
    {	$arr_temp=array();
	foreach($qod->results() as $qo){
		//$ot=$qo->opt_text_value;
		//$ov=$qo->value;
		//$otm=$qo->term;
		$xx=$qo->xx;
		array_push($arr_temp,$xx);
	}
	return $arr_temp;
    }
    else
        return false;
}

function is_show_rule($cqid)
{
    $gq=DB::getInstance()->query("SELECT distinct qid FROM vcims.question_rule_show_op where cqid=$cqid ;");
    if($gq->count()>0)
    {
        $q=$gq->first()->qid;
        return $q;
    }
    else
        return 0;
}

function is_and_rule($cqid)
{
    $gq=DB::getInstance()->query("SELECT distinct qid FROM vcims.question_routine_and where cqid=$cqid ;");
    if($gq->count()>0)
    {
                $arr_temp=array();
                foreach($gq->results() as $qo){
                        $xx=$qo->qid;
                        array_push($arr_temp,$xx);
                }
                return $arr_temp;
    }
    else
        return false;
}

//to get previous selected values by user
function get_resp_pqid_value($resp, $table, $qid)
{
	$term_arr = get_qop($qid,'term');
	$qterm = $term_arr[0];
	//echo "SELECT  $qterm as xx FROM $table WHERE AND resp_id=$resp AND $qterm!=''";
	$qod=DB::getInstance()->query("SELECT  $qterm as xx FROM $table WHERE resp_id=$resp AND $qterm!='';");
    	if($qod->count()>0)
    	{	
		$arr_temp=array();
		foreach($qod->results() as $qo){
			$xx=$qo->xx;
			array_push($arr_temp,$xx);
		}
		return $arr_temp;
    	}
    	else
        	return false;
}

//to save respondent selected values
function save_result($post,$table,$qset,$resp)
{   
           //print_r($post);
    $sp=count($post);
    $arr_post=array(); 
    if($sp>1)
    { 
    $qidarr=$post['qid'];
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
//echo "<br> SAVE ..";
//print_r($qidarr);
//print_r($arr_post);

    $empty=count($arr_post);
  if($empty!=0)
  {

	    //echo "<br>Save called for qid:$qid";                                            
	    //to get the question term
	$ctr=0;
	//to array question
      if(is_array($qidarr)){
	foreach($qidarr as $qid){
		//echo "<br> qid: $qid ; qid_op: ";
		$qid_op=$arr_post[ $ctr ];
		$qtype='';$qterm='';
//print_r($qid_op);
	    $ss="SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid";
	    $qq=DB::getInstance()->query($ss);
	    if($qq->count()>0)
	    {   $f=0;
	               $qterm=$qq->first()->term;
	    }                                     
              	$qtf="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
    		$qtdd=DB::getInstance()->query($qtf);
    		if($qtdd->count()>0){  $qtype=$qtdd->first()->q_type;}

          //echo "<br>te=$qterm && Table= $table &&,resp=$resp &&,qset= $qset" ;
	    if($qterm!='' && $table!='' && $resp!='' && $qset!='')
	    {   

	//echo "<br>SELECT count($qterm) as vv FROM $table WHERE q_id=$qset AND resp_id=$resp AND $qterm!='';";
	       	$qrs=DB::getInstance()->query("SELECT count($qterm) as vv FROM $table WHERE q_id=$qset AND resp_id=$resp AND $qterm!=''");
	       	if($qrs->count()>0 && count($qid_op) > 0)
	       	{       $cnt=$qrs->first()->vv;
	       		if($cnt==1 && count($qid_op) == 1)
	       		{  
				//echo 'IN:';	print_r($qid_op);
			      if( is_array($qid_op)){
			        foreach($arr_post[ $ctr ] as $k=>$val)
			        {
			           $qry="UPDATE $table SET $qterm='$val' WHERE resp_id=$resp AND q_id=$qset AND $qterm!='';";
			           DB::getInstance()->query($qry);
				   //echo "<br>cnt:1, foreeach : $qry";
			        }
			      }
			      else{
				   $qry="UPDATE $table SET $qterm='$qid_op' WHERE resp_id=$resp AND q_id=$qset AND $qterm!='';";
                                   DB::getInstance()->query($qry);
				   //echo "<br> f else : $qry";
			      }
			}
			else 
			{
			     $qry2="DELETE FROM $table WHERE resp_id=$resp AND q_id=$qset AND $qterm!='';";
			     //echo "<br> qry2: $qry2";
			     DB::getInstance()->query($qry2);
			     if( is_array($qid_op)){
				foreach($arr_post[ $ctr ] as $k=>$val)
			        {
			           $qry="INSERT INTO $table (resp_id, q_id, $qterm) VALUES ($resp, $qset,'$val');";
			           DB::getInstance()->query($qry);
			        }
			    }
			    else{
                                   $qry="INSERT INTO $table (resp_id, q_id, $qterm) VALUES ($resp, $qset,'$qid_op');";
                                   DB::getInstance()->query($qry);
			    }
			}
	     	}
	     	else 
	     	{
		     if( is_array($qid_op)){ echo "<br> A";
	     		foreach($qid_op as $val)
		        { 
		             $qry="INSERT INTO $table (resp_id, q_id, $qterm) VALUES ($resp, $qset,'$val');";
		             DB::getInstance()->query($qry);
		        }
		     }
		     else{
                                   $qry="INSERT INTO $table (resp_id, q_id, $qterm) VALUES ($resp, $qset,'$qid_op');";
                                   DB::getInstance()->query($qry);
		     }
	     	}
	     	
	     	
	      }
		$ctr++;
	     } //end of foreach qid
	   } //end of is_array
	   else
	  {
		//echo "Mil Gava: $qidarr";
	  }
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
	           //to loop to check for and rule
	     $isand =  is_and_rule($qid);
	     if($isand != false){
		$arr=array();
		foreach($isand as $andqid){
		   $term='';
			//$rtnv=routine_check($p,$andqid,$t,$r);
		   $ss="SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$andqid";
		   $qq=DB::getInstance()->query($ss);
           	   if($qq->count()>0)
           	   {   $f=0;
               		$term=$qq->first()->term;
			   $resp_values=array();
	                   $sqq = "SELECT distinct $term as xx FROM $t WHERE resp_id=$r and $term !='';";
        	           $qqs=DB::getInstance()->query($sqq);
                	   if($qqs->count()>0){
				foreach($qqs->results() as $qr){
					$vv = $qr->xx;
					array_push($resp_values,$vv);
				}
				$rvalues = implode(', ',$resp_values);
				$ss2="SELECT distinct flow as xx FROM question_routine_check WHERE qset_id=$p and pqid=$andqid AND qid= $qid AND opval IN ( $rvalues );";
                           	$qq2=DB::getInstance()->query($ss2);
                           	if($qq2->count()>0){
					$vc = 1;
					array_push($arr,$vc);
				}
				else{ array_push($arr,$b); }
			   }

           	   }
		   

			//echo "<br> $andqid , $rtnv ";
			//array_push($arr, $rtnv);
		}
	//print_r($arr);
		if(($arr[0] == 1 ) && ($arr[1] == 1)){
			return $qid;
		}
		else continue;
	     }
	     else{
	  
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
	     } //end of else of and rule
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
	//	 echo "<br> op:$op , $qtype $flow vf:$vfound";
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


//========================functions for multiple question per screen

function ptr_first_question($qset,$sptr,$eptr)
{
    $arr=array();
    $qs=DB::getInstance()->query("SELECT * FROM `question_sequence` WHERE `qset_id` = $qset and `sid` BETWEEN $sptr AND $eptr order by sid;");
    if($qs->count()>0)
    {
	$ctr=0;
	foreach($qs->results() as $q){
		$ctr++;
		$qid=$q->qid;
		$sid=$q->sid;
		$cf=$q->chkflag;

		if($cf == 1){
		     if($ctr == 1){
			$_SESSION['sid']=$sid;
			array_push($arr,$qid);
			return $arr;
		    }
		    return $arr;
		}
		if($cf == 0){
                        $_SESSION['sid']=$sid;
                        array_push($arr,$qid);
			$flag = is_grid_question($qid);
			if($flag > 0 ) return $arr;
		}
	}
	return $arr;
     }
     else
        return false;
}


function is_grid_question($q)
{
    $gq=DB::getInstance()->query("SELECT qid,grp_id FROM vcims.question_rule_3 where qid=$q ;");
    if($gq->count()>0)
    {
        $grp=$gq->first()->grp_id;
        return $grp;
    }
    else
        return false;
}
function get_grid_question($qset,$grp)
{
    $arr=array();
    $gq=DB::getInstance()->query("SELECT qid,grp_id FROM vcims.question_rule_3 where qset_id=$qset and grp_id=$grp order by qid;");
    if($gq->count()>0)
    {
        foreach($gq->results() as $g){
                $qid=$g->qid;
                array_push($arr,$qid);
        }
	$qidss = implode(', ',$arr);
	$gq2=DB::getInstance()->query("SELECT max(sid) as mx FROM vcims.question_sequence where qset_id=$qset and qid in ( $qidss )");
	if($gq2->count()>0)
    	{
        	$smx=$gq2->first()->mx;
		$sptr=$_SESSION['sid'];
		if($sptr < $smx) $_SESSION['sid']=$smx;
	}
	return $arr;
    }
    else
        return false;
}

//to check ia show only rule 
function is_opshowrule($q)
{
    $gq=DB::getInstance()->query("SELECT distinct qid FROM vcims.question_rule_show_op where cqid=$q ;");
    if($gq->count()>0)
    {
        $q=$gq->first()->qid;
        return $q;
    }
    else
        return false;
}


?>


