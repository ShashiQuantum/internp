<?php

include_once('../init.php');
include_once('../survey-function.php');      

//print_r($_SESSION);
        $table='';

	$resp_id=0;$qset=0;$currq=0;$next_qstack=array();

	if(Session::exists('resp'))
	{	  
                 $resp_id=$_SESSION['resp'];
        }
	if(Session::exists('qset'))
	{	 
                $qset=$_SESSION['qset'];
        }
	if(Session::exists('isdate'))
	{	$isdate=$_SESSION['isdate'];
        }
	//$_SESSION['lang']='none';
	//$lang='hindi';
	if(Session::exists('lang'))
	{	 
            $lang=$_SESSION['lang'];
        }
	 
        if(Session::exists('qstack'))
   	{	
            $next_qstack=$_SESSION['qstack'];
        }

	 

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
	            margin: 50px; text-align:justify;
	            max-width: 1800px;
	            max-height: 300px;
	       //box-shadow: 0 10px 6px -8px #777;
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
                    echo '<br>Thank You! Submitted';
                    if($qset==49)
                    {  
                        $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/iiii49.php";                        
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
        	if(Session::exists('wqstack'))
             	{	$tarr=$_SESSION['wqstack'];array_push($tarr,$cq);$_SESSION['wqstack']=$tarr;
                	 
             	}else { $arrr=array();array_push($arrr,$cq);$_SESSION['wqstack']=$arrr;}
	}
             
        //$sid=0;
        $maxsid=0;$qtype='';
        if(!Session::exists('maxsid'))
        {
        $qa=DB::getInstance()->query("SELECT max(sid) as ms FROM `question_sequence` WHERE `qset_id`=$qset");
        if($qa->count()>0)
        {
             $_SESSION['maxsid']=$maxsid=$qa->first()->ms;             
        }  
        }
        $maxsid=$_SESSION['maxsid'];
      
        if(Session::exists('sid'))
            $sid=$_SESSION['sid'];
              //echo "<br>maxsid:".$maxsid;
        if($sid>$maxsid) $sid=-1;
        $qlist=array();
         //continue if sid >=0 and sid<=maxsid else terminate
         
        if($sid>=0 && $sid<=$maxsid)
        {
             if($sid==0)
             {
                   $cqid=first_question($qset);
             }
             else
             {   //echo "<br>bf sid:$sid";

                 if($sid!=3 || $sid!=4 || $sid==5 || $sid==6 || $sid==7 || $sid==8 || $sid==9 || $sid==10 || $sid==11 || $sid==12 || $sid==13 || $sid==14 || $sid==15 || $sid==16 || $sid==17 || $sid==18  || $sid==19 || $sid==20 || $sid==21 || $sid==22   )
                 {
                    //array_push($qlist,$qid);
                    save_result($_POST,$table,$qset,$resp_id);
                 $cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);
                 }
                 else $cqid=next_s_question($qset,$sid,$table,$resp_id,$maxsid);

                 if(Session::exists('pqstack'))
                {	$tarr=$_SESSION['pqstack']; 
             	       $pqid=end($tarr);
             	   if($cqid!=$pqid)
             	   { $arr=$_SESSION['qstack'];$end=end($arr); array_push($arr, $end);  $_SESSION['pqstack']=$arr;}
                }
             }

               $sid=$_SESSION['sid'];
         
             $next_qstack=array();  $arr=array();
                        
            
             
             if($sid==1){ $arr1=array();$_SESSION['qstack']=$arr1;array_push($arr1, $cqid);$_SESSION['pqstack']='';$_SESSION['pqstack']=$arr1; }
             if(Session::exists('qstack'))
             	$next_qstack=$_SESSION['qstack'];
             array_push($next_qstack, $cqid); 
             $_SESSION['qstack']=$next_qstack;

     if($cqid!=-1)
     {       
             $ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
             if($ques->count()>0)
             { 
                 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
                 $error=$qid.'e';
                 array_push($qlist,$qid);

                 echo "<div class=effect1>";  
                 echo "<p><font face=tahoma color=red size=2>$qid/$qno</font></p><p><font face=tahoma color=blue size=5>$qtitle</font></p><font color=red><span id='$error'></span></font></div>";
                    
                    if($qtype=='radio')
                    {     
                     	$qterm='';$strval='';
                       	$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
		       	if($qrs->count()>0)
		       	{      $qterm=$qrs->first()->term;
		       	}
                        $sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
                        $rss2=DB::getInstance()->query($sql);
                        if($rss2->count()>0) 
                        { $strval=$rss2->first()->$qterm;}
                        else $strval="";
                        
                          $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
                          if($qop->count()>0)
                          {  echo "<table style='text-indent: 50px;'> <input type=hidden name='qid' value=$qid>";
                              foreach($qop->results() as $ov)
                              {   $str=''; 
                                  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
                                  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
                                  if($strval==$value) $str=" checked='checked'";
                                  echo "<tr height=40 ><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name=q$qid $str value='$value'></td><td> $opt</td></tr>";
                              }
                             echo "</table>";
                          } 
                   }
                   
                   if($qtype=='checkbox')
                    {    
                    	$qterm='';$arr_temp=array();
                       	$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
		       	if($qrs->count()>0)
		       	{      $qterm=$qrs->first()->term;
		       	}
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
                          {  echo "<table style='text-indent:  50px;'><input type=hidden name=qid value=$qid>";
                              foreach($qop->results() as $ov)
                              {   $str='';
                                  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
                                  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
                                  if(in_array($value,$arr_temp))
                                  { 
                                      	$str="checked='checked'";
                                  }

                                  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='big' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
                                  
                              }
                             echo "</table>";
                          } 
                   }
                   
                   if($qtype=='rating')
                    {    
                    		
                          $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
                          if($qop->count()>0)
                          {  echo "<table style='text-indent: 50px;'><input type=hidden name=qid value=$qid>";
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

                       	echo "<table style='text-indent: 50px;'><input type=hidden name=qid value=$qid>";
                       	echo "<tr><td><input type=text name=text$qid id=q$qid value=$str> </td></tr></table>";
                   }
                   if($qtype=='textarea')
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

                       	echo "<table style='text-indent: 50px;'><input type=hidden name=qid value=$qid>";
                       	echo "<tr><td><textarea id=q$qid name=text$qid cols=150 rows=5 >$str</textarea>  </td></tr></table>";
                   }
                   if($qtype=='titlewithonerating')
                   {
                   	    $text_t=''; $rating_t='';
                            
                            //to display rating heading and its values
                            $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$qid ");
                            if($rss)
                            {   
                                $text_t=$rss->first()->text_term;
                                $rating_t=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;
                            }
                            $col=count($rss->results());
                            if($qid==2390)
                            {   $col=6; }
                            if($qid==2391 || $qid==2393 || $qid==2394)
                            { $col=4; }
                              
 
                            echo "<table border=1 style='text-indent: 50px;border: 1px solid black;border-spacing: 0;'><input type=hidden name=qid value=$qid> <tr style=background-color:lightgray> <td><font face=tahoma color=red size=5>$th</font></td><td colspan=$col><center><font face=tahoma color=red size=5>$rh</font></center></td> </tr><tr><td></td>";
                            $ii=0; $opt_arr=array();
                            foreach($rss->results() as $rr)
                            {   
                                $opt=$rr->opt_text_value;
                                array_push($opt_arr,$opt);
                                $ii++;
                                if($ii<=$col)
                                {echo "<td><center><font face=tahoma color=blue size=4>$rr->rating1_title</font></center></td>";}
                            }
                            echo "</tr> ";      
        //print_r($opt_arr);                     
                            $tb='';$arr_temp=array();$arr_temp2=array();
                            //$v=$op->value;
                            //echo 'V:'.$v;
                             
                                 $sql="SELECT $text_t , $rating_t FROM $table WHERE `resp_id`=$resp_id  AND $text_t !=0  AND $rating_t !='0' order by $text_t";
                                $rss2=DB::getInstance()->query($sql);
                                if($rss2->count()>0)
                                    foreach($rss2->results() as $r)    
                                    {   //echo $r->$t; 
                                        $rv=$r->$rating_t;    
                                        $tv=$r->$text_t; 
                                        array_push($arr_temp, $tv);
                                        array_push($arr_temp2, $rv);
                                    }
                                     // print_r($arr_temp2);
				 
                                for($ic=0;$ic<$tbc;$ic++)
                                {   $strt='';$icc=$ic+1;
                                    
                                    if(count($arr_temp)>0){$strt=$arr_temp[$ic];}
                                    echo "<tr><td><input type=text name=t$ic style='border: none; width: 4%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;' value=$icc readonly><font face=tahoma color=blue size=4>$opt_arr[$ic]</font></td>";

                                    $rss1=DB::getInstance()->query("SELECT distinct rating1_value FROM `question_option_detail` WHERE `q_id`=$qid ");
                                    if($rss1)
                                    {  $ii=0;
                                    
                                       if($qid==2390 )
                                       {   
                                          foreach($rss1->results() as $rr)
                                          {  
                                            $ii++; $rt1=$rr->rating1_value; $rt1v=$rt1-1;
                                            if($ii<=$col)
                                            {
                                               $str=''; $shd='';
                                              if(count($arr_temp2)>0)
                                              { 
                                                  $shd="<td><center> <input type=radio  class='cnt5' name=rank$ic value=$rt1v >  </center></td>";
                                                if($rt1v==0)  
                                                $shd="<td><center> <input type=radio checked='checked' class='cnt5' name=rank$ic value=$rt1v >  </center></td>"; 
                                               if($rt1v==$arr_temp[$ic])
                                               {   $crv=$arr_temp2[$ic]; $crv--;
                                                    //echo "<br>str: $rt1v==$arr_temp[$ic] => $crv";
                                                  $str="checked='checked'";
                                                  if($rt1v!=0)
                                                  $shd="<td><center><input type=radio $str class='cnt5' name=rank$ic value=$crv >  </center></td>";
                                               }
                                                 
                                               echo $shd;
                                              }
                                              else  
                                              {     $zz="<td><center><input type=radio  class='cnt5' name=rank$ic value=$rt1v >  </center></td>";
                                                   if($rt1v==0)
                                                      $zz="<td><center><input type=radio checked='checked' class='cnt5' name=rank$ic value=0 >  </center></td>";
                                                    echo $zz;
                                                   

                                               }
                                            }
                                          }

                                       }
                                       else
                                       {
                                          foreach($rss1->results() as $rr)
                                          {  
                                            $ii++;
                                            if($ii<=$col)
                                            {
                                               $str='';
                                              if(count($arr_temp2)>0)
                                              if($rr->rating1_value==$arr_temp2[$ic])
                                              { 
                                                $str="checked='checked'";
                                              }
                                               //echo $str
                                              echo "<td><center><input type=radio $str name=rank$ic class=cnt26 value=$rr->rating1_value >  </center></td>";
                                            }
                                          }

                                       }
                                      
                                        
                                    
                                    }
                                    echo "</tr>";
                                }                    
                                echo "</table>";                   
                        }//end of qt textrating
                   
             }
             if($qtype=='text' || $qtype=='textarea' || $qtype=='radio' || $qtype=='checkbox' || $qtype=='rating' || $qtype=='dropdown' || $qtype=='titlewithonerating') 
             {   
                  //echo "<br>afr sid:$sid , $qid";
                if($sid!=4 || $sid!=5 ||$sid!=6 || $sid!=7 || $sid!=8 || $sid!=9 || $sid!=10 || $sid!=11 || $sid!=12 || $sid!=13 || $sid!=14 || $sid!=15 || $sid!=16 || $sid!=17 || $sid!=18 || $sid!=19 || $sid!=20 || $sid!=21 || $sid!=22 || $sid!=23)
                {
                  //array_push($qlist,$qid);
              	  save_result($_POST,$table,$qset,$resp_id);
                   
                }
             }
             
             
          }//end of qid -1 check
          else
          {  
            //array_push($qlist,$qid);
              	  save_result($_POST,$table,$qset,$resp_id);
          }
        }
        
}

	if(isset($_POST['back']))
	{       

             	$pqstack=$_SESSION['wqstack']; 
		$cqid = array_pop($pqstack);
             	$_SESSION['wqstack']=$pqstack;
             	
		
		$ques=DB::getInstance()->query("SELECT `q_id`,q_title,q_type,qno FROM `question_detail` WHERE `q_id`=$cqid");
             if($ques->count()>0)
             { 
                 $qid=$ques->first()->q_id; $qtitle=$ques->first()->q_title;$qtype=$ques->first()->q_type;$qno=$ques->first()->qno;
                 echo "<div class=effect1>";  
                 echo "<p>$qid/$qno</p><p>$qtitle</p></div>";
                    
                    if($qtype=='radio')
                    {     
                     	$qterm='';$strval='';
                       	$qrs=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE q_id=$qid");
		       	if($qrs->count()>0)
		       	{      $qterm=$qrs->first()->term; }
                        $sql="SELECT  $qterm FROM $table WHERE q_id=$qset AND resp_id=$resp_id AND $qterm!=''";
                        $rss2=DB::getInstance()->query($sql);
                        if($rss2->count()>0) 
                        { $strval=$rss2->first()->$qterm;}
                        else $strval="";
                        
                          $qop=DB::getInstance()->query("SELECT `opt_text_value`,`term`,`value`,`scale_start_label`,`scale_end_label`, `scale_start_value`,`scale_end_value` FROM `question_option_detail` WHERE `q_id`=$cqid");
                          if($qop->count()>0)
                          {  echo "<table> <input type=hidden name=qid value=$qid>";
                              foreach($qop->results() as $ov)
                              {   $str=''; 
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
		       	{      $qterm=$qrs->first()->term;
		       	}
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
                          {  echo "<table><input type=hidden name=qid value=$qid>";
                              foreach($qop->results() as $ov)
                              {   $str='';
                                  $opt=$ov->opt_text_value; $term=$ov->term; $value=$ov->value; $sl=$ov->scale_start_label;$el=$ov->scale_end_label;
                                  $slv=$ov->scale_start_value; $elv=$ov->scale_end_value;
                                  if(in_array($value,$arr_temp))
                                  { 
                                      	$str="checked='checked'";
                                  }

                                  echo "<tr height=40><td></td><td width=2%><input type='$qtype' class='xa' id=q$qid name='$value' $str value='$value'></td><td> $opt</td></tr>";
                                  
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
                       	echo "<tr><td><input type=text name=txt$qid  value=$str> </td></tr></table>";
                   }
                   if($qtype=='textarea')
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
                       	echo "<tr><td><textarea id=q$qid name=text$qid cols=150 rows=5 >$str</textarea>  </td></tr></table>";
                   }
                   if($qtype=='titlewithonerating')
                   {
                   	    $text_t=''; $rating_t='';
                            
                            //to display rating heading and its values
                            $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$qid ");
                            if($rss)
                            {   
                                $text_t=$rss->first()->text_term;
                                $rating_t=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;
                            }
                            $col=count($rss->results());
                            if($qid==2390)
                            {   $col=5; }
                            if($qid==2391)
                            { $col=4; }
                              
 
                            echo "<table border=1 cellpadding=0 cellspacing=0 style='text-indent: 50px;'><input type=hidden name=qid value=$qid> <tr style=background-color:lightgray> <td width=5%><font face=tahoma color=red size=4>$th</font></td><td colspan=$col><center><font face=tahoma color=red size=4>$rh</font></center></td> </tr><tr><td width=15%></td>";
                            $ii=0; $opt_arr=array();
                            foreach($rss->results() as $rr)
                            {   
                                $opt=$rr->opt_text_value;
                                array_push($opt_arr,$opt);
                                $ii++;
                                if($ii<=$col)
                                {echo "<td><center><font face=tahoma color=blue size=2>$rr->rating1_title</font></center></td>";}
                            }
                            echo "</tr> ";      
        //print_r($opt_arr);                     
                            $tb='';$arr_temp=array();$arr_temp2=array();
                            //$v=$op->value;
                            //echo 'V:'.$v;
                             
                                $sql="SELECT $text_t , $rating_t FROM $table WHERE `resp_id`=$resp_id  AND $text_t !=''  AND $rating_t !='' order by $text_t";
                                $rss2=DB::getInstance()->query($sql);
                                if($rss2->count()>0)
                                    foreach($rss2->results() as $r)    
                                    {   //echo $r->$t; 
                                        $rv=$r->$rating_t;    
                                        $tv=$r->$text_t; 
                                        array_push($arr_temp, $tv);
                                        array_push($arr_temp2, $rv);
                                    }
                                     //print_r($arr_temp2);
				 
                                for($ic=0;$ic<$tbc;$ic++)
                                {   $strt='';$icc=$ic+1;
                                    
                                    if(count($arr_temp)>0){$strt=$arr_temp[$ic];}
                                    echo "<tr><td><input type=text name=t$ic style='border: none; width: 8%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;' value=$icc readonly><font face=tahoma color=blue size=2>$opt_arr[$ic]</font></td>";
                                    $rss1=DB::getInstance()->query("SELECT distinct rating1_value FROM `question_option_detail` WHERE `q_id`=$qid ");
                                    if($rss1)
                                    {  $ii=0;
                                    foreach($rss1->results() as $rr)
                                    {  
                                       $ii++;
                                       if($ii<=$col)
                                       {
                                         $str='';
                                         if(count($arr_temp2)>0)
                                         if($rr->rating1_value==$arr_temp2[$ic])
                                             { 
                                                $str="checked='checked'";
                                            }
                                            //echo $str
                                         echo "<td><center><input type=radio $str name=rank$ic value=$rr->rating1_value >  </center></td>";
                                       }
                                    }
                                    }
                                    echo "</tr>";
                                }                    
                                echo "</table>";                   
                        }//end of qt textrating

                   
             }
             	$ww="SELECT `qid`,sid,chkflag FROM `question_sequence` WHERE `qset_id`=$qset and `qid`=$qid";
    		$q=DB::getInstance()->query($ww);
    		if($q->count()>0)
    		{ 
          		 $sid=$q->first()->sid;
          		 $_SESSION['sid']=$sid;
          	}
          
	}
	
?> 

	<br><br><font size=2 color=red><div id=err></div></font>       

         <?php
        // echo "<br>sid:$sid cqid: $cqid";
            if($sid >= 0 && $cqid >= 1)
            {    
         ?>
	 <!-- <input type='submit' name='back' value='Back' style="background-color:#004c00;color:white;height:35px; text-indent:50px"> -->

	  <input type='submit' name='next' value='Next' onclick='return Validate();' style='background-color:#004c00;color:white;height:35px;position:absolute; left:50%;'> 
	  <?php
            }
            if($sid == -1 || $cqid == -1)
            {    
               ///session_destroy();
                //termination code
                             
                    echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br>You can review your responses to all previous questions before final submission of the survey otherwise click on submit button to complete survey</font></center>";
                    
                    //echo "<br><input type='submit' name='back' value='Back' style='background-color:#004c00;color:white;height:35px; text-indent:50px'>";  
                      
                    echo "<br><br><center> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
    
             //end termination
           
            }   
         ?>
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
	var error=0;var qid=jArray[0];
	     //alert(qid);
        

            if (qid==2390)
            {
                      
                     var ff=qid+'e';
	               var countVal = 5; var vcount=0;

                       $("input:radio[class=cnt5]").each(function(){
                           if($(this).is(":checked"))
                           {   var x=parseInt($(this).val());
                               vcount=vcount + x;
                           } 
                       });    alert('Total times selected : '+vcount);

                    if(vcount!=countVal)
                    {
	              document.getElementById(ff).innerHTML = ' [ Error! Please ensure exactly 5-times count !! ]';
                      window.stop();return false;
                    }
            }
            if (qid==2391 || qid==2393 || qid==2394)
            {
                     //alert('Hi'+qid);
                     var ff=qid+'e'; var tcnt=0
	              var selectedVal=6;
                      if (qid==2393)
                          selectedVal=7;
                      if (qid==2394)
                         selectedVal=15;
                      
                      

                      $("input:radio[class=cnt26]").each(function(){
                    
                           if($(this).is(":checked"))
                           {    
                               tcnt++;
                           } 
                       });
                       alert('Total attempted statement count : '+tcnt +' out of '+selectedVal);

                    if(tcnt != selectedVal)
                    { 
	              document.getElementById(ff).innerHTML = ' [ Error! Please response each statements!! ]';
                      window.stop();return false;
                    }
            }

	    for(var j=0;j<jArray.length;j++)
	    {   var flag=0;
	        var ctr=0;
	        var elm=jArray[j];
	        var qq='q'+elm; var nm='text'+elm;
	        var radios = document.getElementsByName(qq); 
	      
	        var et=document.getElementById(qq).type;
	        // alert(qq);
	       // alert(et);

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

<script>
            
            var vcount = 0;
            
   $(document).ready(function(){
        
        $(".cnt5").click(function () 
        { 
            if(this.checked)
            {   var x=0;
                x=parseInt($(this).val());
                vcount=vcount+ x;  //alert(vcount);
            }
            else 
            {
                var x=0;
                x=parseInt($(this).val());
                vcount=vcount- x; //alert(vcount);
            }
            //alert(vcount);
        });
            //alert(vcount);
   });
</script>

	
	</html>
