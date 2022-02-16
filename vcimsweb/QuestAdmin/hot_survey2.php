<?php

include_once('../init.php');
include_once('../functions.php');      

$resp_id=0;$qset=0;$currq=0;
$resp_id=$_GET['rsp'];
$qset=$_GET['qset'];

//$lang='hindi';
if(Session::exists('lang'))
 $lang=$_SESSION['lang'];



//echo '<br>lang:'.$lang;

$_SESSION['qset']=$qset;

?>
<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Vcims Online Survey</title>
  <style type='text/css'>
    ul { list-style: none; }
    #recordingslist audio { display: block; margin-bottom: 10px; }
  </style>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
<?php
//$resp_id=$_SESSION['respid'];

//https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/DemoCSS.php?qset=1&next=-1&rsp=202


if($_GET['next']==3)
{
        
       echo $qqq="DELETE FROM  `pilot` WHERE  `resp_id` =$resp_id AND  `r_age` ='' ";
        DB::getInstance()->query($qqq);
        //session_destroy();
	echo '<br>Your Survey has reset, Pls fill the survey from begning';
        //sleep(50);
        $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=-1&rsp=$resp_id";
        header('Location: '.$newURL);        
}
if(isset($_POST['submit']))
{
        //print_r($_POST);
        date_default_timezone_set('asia/calcutta');
        
        $date = date('Y/m/d H:i:s');

        $qqq="UPDATE `respondent_link_map` SET `status`=2, `end_time`='$date' WHERE resp_id=$resp_id AND qset_id=$qset";
        DB::getInstance()->query($qqq);
        //session_destroy();
	echo '<br>Thank You! Submitted';
        //sleep(50);
        $newURL="https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/fp_7.php?qset=$qset&yn=0";
        header('Location: '.$newURL);        
}
else    
{
    if(isset($_POST['save']))
    {
        $_GET['next']=1;
       // echo 'next';
    }
    //echo $resp_id;
    $qset=$_GET['qset'];
    echo "<form action='' method='post'>";
	//if next is clicked

	//echo "<div id=header>";
                           // echo "<p style=float:right><img src='../../images/Digiadmin_logo.jpg' height=50 width=150> </p><br><br>";
//echo "</div>";

//start previous button==============================
                 $dxx=DB::getInstance()->query("select status  FROM `respondent_link_map` WHERE qset_id=$qset and resp_id=$resp_id)");

                	//echo 'Previous button clicked';
                	
                		//echo '<br>sec:'.$_GET['sec'];
            if($_SESSION['resp']!=$resp_id)
            {
                echo 'You have entered wrong URL, pls use your correct URL';
            }
            else if($dxx->count()>0 && $dxx->first()->status==2)
            {
                echo "You have completed your survey, thank you!";
            }
            else
                if($_GET['next']==2)
                {
                	//echo 'Previous button clicked';
                	
                		//echo '<br>sec:'.$_GET['sec'];
            if($_SESSION['resp']!=$resp_id)
            {
                echo 'You have entered wrong URL, pls use your correct URL';
            }
            else{
                
                            
                          $psec=$_SESSION['psec'];
                           if($psec==0)
                               header('Location: '."https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=-1&rsp=$resp_id");
                  $qqr="select * FROM `question_routine_detail` WHERE qset_id = $qset and next_qid in ( select q_id FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($psec) order by q_id)";         
                $db=DB::getInstance()->query($qqr);
                if($db->count()>0)
                {
                    $psec=$db->first()->qsec;
                    $_SESSION['psec']=$psec;
                }
                
                $arr_nsec=array();
                $qsecs=0;$_SESSION['qt']='';
                $prev_c=$_SESSION['currq']; 
                $psec=$_SESSION['psec'];  
                $qsec=$_SESSION['qsec'];
                
                $currq=$_SESSION['nextq'];
                
                //echo 'strting...';
                if(isset($_GET['sec'])) 
                {   
                    $qsec=$_GET['sec'];
                    $rw=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE qset_id = $qset and qsec=$qsec order by q_id");
                        if($rw){
                        $_SESSION['currq']=$rw->first()->q_id;
                        $currq=$rw->first()->q_id;$prev_c=$rw->first()->q_id;}
                }
                //to find the routine details of current question
                 $aaa="select * FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($psec) order by q_id";
                $psd=DB::getInstance()->query($aaa);
                if($psd->count()>0)
                {    
                    foreach ($psd->results() as $p)
                    {   //echo $p->q_id;    
                        
                                $qid=$p->q_id;
                                if($qid==0)
                                    continue;
                                $opv=$p->op_value;
                                $nqid=$p->next_qid;
                                $rt=$p->routine;
                                $comps=$p->compare_sign;
                                $join=$p->join_with;
                                //find the selected option by user from database
                                
                                        $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                        $qtd1=DB::getInstance()->query($qtd);
                                        if($qtd1->first()->q_type=='radio' || $qtd1->first()->q_type=='text' || $qtd1->first()->q_type=='textbox'|| $qtd1->first()->q_type=='textarea' || $qtd1->first()->q_type=='checkbox' || $qtd1->first()->q_type=='calculated' || $qtd1->first()->q_type=='dropdown' || $qtd1->first()->q_type=='sec')
                                        if($qtd1->first()->q_type!='instruction' || $qtd1->first()->q_type!='top3rankcompany')
                                        {  
                                                //to find table and its column search
                                                $column='';$table='';
                                                $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$qid ";
                                                $rd=DB::getInstance()->query($sq);
                                                if($rd)
                                                {
                                                    $column=$rd->first()->term;
                                                    //array_push($arr_column,$column);
                                                    $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                    $tbf1=DB::getInstance()->query($tbf);
                                                    if($tbf1)
                                                        $table=$tbf1->first()->TABLE_NAME;
                                                    //array_push($arr_table,$table);
                                                }
                                               $stat="SELECT $column FROM $table WHERE resp_id=$resp_id AND q_id=$qset AND $column !=''";
                                                $r=DB::getInstance()->query($stat);
                                                if($r->count()>0)
                                                {
                                                    //echo '<br>sopv::'.$opv;
                                                    $getv=$r->first()->$column; 
                                                    //echo '<br>opv::'.$opv.'getv:'.$getv;
                                                    if($nqid==-1)
                                                    { 
                                                                if($comps=='<')
                                                                {
                                                                        if($getv < $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='<=')
                                                                {
                                                                        if($getv <= $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='>')
                                                                {
                                                                        if($getv > $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='>=')
                                                                {
                                                                        if($getv >= $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='==')
                                                                {
                                                                        if($getv == $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='!=')
                                                                {
                                                                        if($getv != $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='range')
                                                                {
                                                                        if($getv >= $ar[0] && $getv <=$ar[1])
                                                                        {   
                                                                            $ar=  explode(',', $opv);
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='not range')
                                                                { 
                                                                        if(!$getv <= $ar[0] && !$getv >=$ar[1])
                                                                        {   
                                                                            $ar=  explode(',', $opv);
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                
                                                                if($opv==$getv)
                                                                {
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                }
                                                        continue;
                                                    }
                                                    $rrss="select * FROM `question_routine_detail` WHERE q_id = $nqid and qset_id=$qset";
                                                    $rss=DB::getInstance()->query($rrss);
                                                    if($rss)
                                                    $qsec=$rss->first()->qsec;
                                                    //$opv=$rss->first()->op_value;
                                                    //$qset=$rss->first()->qset_id;
                                                    //echo '<br>opv='.$opv .' && getv='.$getv; 
                                                    //echo "<br>$opv hh".$rr=  stristr($opv, ',');
                                                    if (strpos($opv,',') !== false) 
                                                    {
                                                                //echo '<br>'.$join;
                                                                if($opv!='0' || $opv!='')
                                                                {   
                                                                    $ar=  explode(',', $opv);
                                                                    if($comps =='range')
                                                                    {   //echo 'gg2='.$ar[0].'-'.$ar[1].'='.$getv; 
                                                                        if($getv >= $ar[0] && $getv <=$ar[1] )
                                                                        {   
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                    }
                                                                else if($comps=='not range')
                                                                { //echo 'hello';
                                                                        if($getv <= $ar[0] || $getv >=$ar[1])
                                                                        {   //echo 'hello';
                                                                            $ar=  explode(',', $opv);
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                }
                                                                else
                                                                {   //echo '<br>f:'.$qsec;    
                                                                    array_push($arr_nsec, $qsec);
                                                                }
                                                    }
                                                    else if( $comps!='')
                                                    { //echo 'A'.$comps;
                                                                if($comps=='>')
                                                                {
                                                                        if($getv > $opv)
                                                                        {   
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='>=')
                                                                {
                                                                        if($getv >= $opv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='<')
                                                                {
                                                                        if($getv < $opv)
                                                                        {   
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='<=')
                                                                {
                                                                        if($getv <= $opv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='==')
                                                                {
                                                                        if($opv == $getv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps !='>')
                                                                {
                                                                        if($opv > $getv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                
                                                                else
                                                                {   //echo '<br>f:'.$qsec;    
                                                                    //array_push($arr_nsec, $qsec);
                                                                }
                                                    }
                                                    else
                                                    {
                                                        if($opv!='0' || $opv!='')
                                                        {   
                                                            if($opv == $getv)
                                                            {    
                                                                //echo '<br>qqsec:'.$qsec;
                                                                $_SESSION['currq']=$qid;
                                                                $currq=$qid;   
                                                                array_push($arr_nsec, $qsec);
                                                            }   
                                                        }
                                                        else
                                                        {   //echo '<br>f:'.$qsec;    
                                                            array_push($arr_nsec, $qsec);
                                                        }
                                                    //print_r($arr_nsec);
                                                    }
                                                }
                                                //else echo 'you must select the previous question option';
                                        }
                            //} //end if
                    } //foreach end
                } //if end          
                //print_r($arr_nsec);
                //echo $currq;
                //check the stop condition of previous question and force to submit the form
    /*            $sql1="select * FROM `question_routine_detail` WHERE q_id = $prev_c and qset_id=$qset";
                $rr=DB::getInstance()->query($sql1);
                if($rr->count()>0)
                    $prev_routine=$rr->first()->routine;
                    $prev_stop=$rr->first()->op_value;      
                    $qsec=$rr->first()->qsec;
                    $prev_opv=$_SESSION['cso'];
    */                
                //if 
               if($currq!=0 ) 
                {
                    $ctr=0;
                    //echo 'hi'.$qset;
                    $qset=$_GET['qset'];
                  if($ctr==0)  
                  {  echo "<div id=header>";
                            echo "<div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div>";
            
          
                        //display tab
                        $sh=DB::getInstance()->query("SELECT `sec_title`,qsec_id FROM `question_sec` WHERE `qset_id`=$qset order by qsec_id asc");
                	if($sh)
                        {
                            echo "<center><table><tr>";
                            foreach ($sh->results() as $h)
                            {
                                if($h->qsec_id==$psec)
                                    echo "<td><a href=https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:#00e500;color:white;height:30px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";    
                                else
                                    echo "<td><a href=https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:green;color:white;height:30px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";
                            }
                            echo '</tr></table></center><br>';
                        }//end display tab
echo "</div>";
                        //DISPLAY THE QUESTION
                    /*
                        $rss=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id = $currq");
                        if($rss)
                        //$qsec=$rss->first()->qsec;$qset=$rss->first()->qset_id;
                        //print_r($rss);
                        
                        $arr_sec=array();
                    */    
                     //echo '<br>qsec:'.$qsec;
                        $_SESSION['qsec']=$qsec;
                        if(isset($_GET['sec'])) {$qsec=$_GET['sec'];}

       /*        $db=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE qset_id = $qset and next_qid in ( select q_id FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($psec) order by q_id)");
                if($db->count()>0)
                {
                   echo '<br>pp:'. $psec=$db->first()->qsec;
                    $_SESSION['psec']=$psec;
                }                
        */                
                        $_SESSION['psec']=$psec;
                        //echo '<br>qsec:'.$qsec;
                        //query for getting distinct question from all questionSet
                        //$qq="SELECT distinct `q_id`,`qset_id`, `next_qid`, `op_value`, `qsec`, `routine`, `compare_sign` FROM `question_routine_detail` WHERE `qset_id` = 2 and `qsec` in (11) order by `q_id`"; 

                        $sql="select * FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($psec) order by q_id";
                        $rss3=DB::getInstance()->query($sql);
                       
                        if($rss3)
                        {    $currq=$rss3->first()->q_id;
                             $_SESSION['currq']=$currq;
                             $_SESSION['nextq']=$rss3->first()->next_qid;
                             
                        } 
                        //print_r($rss);
                        $qq="SELECT distinct `q_id`,`qset_id` FROM `question_routine_detail` WHERE `qset_id` = $qset and `qsec` in ($psec) order by `q_id`"; 
                        $rss333=DB::getInstance()->query($qq);
                        foreach($rss333->results() as $cq )
                        {
                            //echo '<br>qid'.$cq->q_id;
                            //to find the routine details of current question
                            $qrd=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id=$cq->q_id");
                            if($qrd)
                            {
                                $opv=$qrd->first()->op_value;
                                $nqid=$qrd->first()->next_qid;
                                $rt=$qrd->first()->routine;
                            }
                            //$_SESSION['currq']=$cq->q_id;
                            $rs2=DB::getInstance()->query("select * FROM `question_detail` WHERE q_id =$cq->q_id");
                            if($rs2->count()>0)
                            {       $eng_qtitle=$rs2->first()->q_title;
                               $qt=$rs2->first()->q_type;
                               $qc=$rs2->first()->condition;
                               $currq=$cq->q_id;
                                $_SESSION['currq']=$currq;
                                if(strlen(($_SESSION['qt']))<1)
                                    $_SESSION['qt'].=$qt;
                                else
                                    $_SESSION['qt'].=','.$qt;
                                $error=$currq.'e';
                                //start to find the question type and display its options
                                if($qt=='instruction')
                                {           //echo '<table><tr><td><b><font color=black> '.$eng_qtitle.'</font></b></td></tr></table><br>';
                                            if($lang==''|| $lang=='none')
                                       {
                                            echo '<table><tr><td><b><font color=black> '.$rs2->first()->q_title.'</font></b></td></tr></table><br>';
                                       }
                                       else if($lang=='hindi')
                                       {
                                            $rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                            if($rs22->count()>0)
                                            {       
                                                $hindi_qtitle=$rs22->first()->q_title;
                                                echo '<table><tr><td width=4%></td><td colspan=2><font color=black> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>';
                                                echo '<tr><td width=4%></td><td colspan=2><font color=black> ['.$hindi_qtitle.']</font><font color=red><span id='.$error.'></span></font></td></tr></table>';
                                            }
                                            else 
                                               echo '<table><tr><td width=4%></td><td colspan=2><font color=black> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr></table>'; 
                                        } 
                                            $ifvideo='';$ifaudio='';$ifimage='';


                                            //$ifvideo=$rs2->first()->video;
                                            //$ifaudio=$rs2->first()->audio;
                                            //$ifimage=$rs2->first()->image;
                                        if($ifaudio!='')
                                        {
                                            
                                            echo "<center><audio controls autoplay>";
                                                echo "<source src=$ifaudio type='audio/mp3'>";
                                            echo "</audio></center><br><br>";
                                        }
                                        if($ifvideo!='')
                                        {
                                            echo "<center>";
                                            echo "<video id=myVideo width=320 height=176 controls autoplay>";
                                            echo "<source src=$ifvideo type='video/mp4'>";
                                            echo "  Your browser does not support HTML5 video.";
                                           echo "</video></center><br><br>";
                                        }
                                        if($ifimage!='')
                                        {
                                            echo "<center><figure><img src=$ifimage height=250 width=300>";
                                             echo "<figcaption>Fig.1 - A view of the pulpit rock in Norway.</figcaption></figure></center>";
                                        }
                                }
                                else if($lang==''||$lang=='none')
                                {   
                                    echo '<table><tr><td width=4%>'.$currq.'</td><td colspan=2><font color=blue> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>';   

                                }
                                else if($lang=='hindi')
                                {
                                     $rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                     if($rs22->count()>0)
                                     {       
                                          $hindi_qtitle=$rs22->first()->q_title;
                                          echo '<table><tr><td width=4%>'.$currq.'</td><td colspan=2><font color=blue> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>';
                                          echo '<tr><td width=4%></td><td colspan=2><font color=blue>  ['.$hindi_qtitle.']</font><font color=red><span id='.$error.'></span></font></td></tr>';
                                     }
                                     else 
                                         echo '<table><tr><td width=4%>'.$currq.'</td><td colspan=2><font color=blue> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>'; 
                                }

   

                        if($qt=='rating')
                        {
                           
                            
                            $sql="SELECT  `scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label` FROM `question_option_detail` WHERE `q_id`=$currq";
                            $da=DB::getInstance()->query($sql);
                            if($da->count()>0)
                            {
                                $sv=$da->first()->scale_start_value;
                                $ev=$da->first()->scale_end_value;
                                $sl=$da->first()->scale_start_label;
                                $el=$da->first()->scale_end_label;
                                
                                $arr_temp=array();$str='';
                            }
                            
                                            $column='';$table='';$arr_column=array();$arr_table=array();$vv='';
                                            $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ";
                                            $rd=DB::getInstance()->query($sq);
                                            if($rd)
                                            {
                                                $column=$rd->first()->term;
                                                array_push($arr_column,$column);
                                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                $tbf1=DB::getInstance()->query($tbf);
                                                if($tbf1)
                                                    $table=$tbf1->first()->TABLE_NAME;array_push($arr_table,$table);
                                            }
                                          
                                            $stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            if($r->count()>0)
                                            {
                                                $vv=$r->first()->$arr_column[0];
                                                array_push($arr_temp, $vv);
                                            }
                                            //print_r($arr_temp);
                                if($sv==0)
                                {   $str='';
                                    echo "<table border=1><tr><td> </td>";
                                    for($s=$sv+1;$s<=$ev;$s++)
                                    {
                                        echo "<td width=45> $s </td>";
                                    }
                                    echo "<td> </td><td>NA/Not Show</td></tr><tr><td> $sl </td>";
                                    for($s=$sv+1;$s<=$ev;$s++)
                                    {   
                                        if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';
                                        echo "<td widh=45><input type=radio class=big name=r$currq $str value=$s> </td>";
                                    }
                                    if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';

                                    echo "<td> $el </td><td><input type=radio class=big  name=r$currq $str value=$s></td></tr></table>";                                
                                }else if($sv==1)
                                {
                                    echo "<table><tr><td> </td>";
                                    for($s=$sv;$s<=$ev;$s++)
                                    {
                                        echo "<td width=45> $s </td>";
                                    }
                                    echo "<td> </td></tr><tr><td> $sl </td>";
                                    for($s=$sv;$s<=$ev;$s++)
                                    {   
                                        if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';
                                        echo "<td width=45><input type=radio class=big name=r$currq $str value=$s> </td>";
                                    }
                                    echo "<td> $el </td></td></tr></table>"; 
                                }
                        }        
                        if($qt=='top3rankcompany')
                        {
                                $sql="SELECT `id`, `cname` FROM `company_list`";
                                for($i=1;$i<=3;$i++)
                                {
                                    $da=DB::getInstance()->query($sql);
                                    echo "<br>Rank $i: <select id=rank$i name=rank$i> <option>--Select--</option>";
                                    if($da->count()>0)
                                    foreach($da->results() as $d)
                                    {
                                    echo "<option>$d->cname</option>";
                                    }    
                                    echo "<option>others</option>";
                                    echo "</select> <input type=text name=other$i id=other$i placeholder='Specify here' style=display:none>";
                                }
                        }
                        if($qt=='calculated')
                        {
                                $column='';$table='';$str1='';$str2='';$str3='';
                                $rd1=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd1->count()>0)
                                {
                                        $column=$rd1->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                            $table=$tbf1->first()->TABLE_NAME;
                                         $sql="SELECT no_of_pack, pack_size, $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql); 
                                        if($rss2->count()>0) 
                                        {  $str1=$rss2->first()->no_of_pack;
                                            $str2=$rss2->first()->pack_size;
                                            $str3=$rss2->first()->$column;
                                        }
                                }               
                                echo "<tr><td></td><td>How many number of pack do you consume in a year?</td></tr>";
                                echo "<tr><td></td><td><input type=number min=0 name=tp id=tp value=$str1 placeholder='enter total pack in a year'></td></tr>";
                                echo "<tr><td></td><td>What is the average pack weight/size?";
                                echo "<tr><td></td><td><input type=number min=0 name=ps id=ps value=$str2 placeholder='enter a pack size'></td></tr>";

                                echo "<input type=hidden name=tw id=tw value='$str3'><br><br>";
                                
                           
                        }
                        if($qt=='sec')
                        {
                            /*
                            for($i=0;$i<12;$i++)
                            {
                                for($j=0;$j< 8;$j++)
                                {
                                    echo $sec[$i][$j];echo ' , ';
                                }
                                echo '<br>';
                            }
                            */
                            $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                            $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id AND q_id=$qset AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                           $str=$rss2->first()->$column;
                                } 
                               /*
                                $sd=''; $ss=$str; $p='';$e='';
                                                if($ss=='1')
                                                {$sd=A1; $p='';$e='';}
                                                else if($ss=='2')
                                                    $sd=A2;
                                                else if($ss=='3')
                                                    $sd=B1;
                                                else if($ss=='4')
                                                    $sd=B2;
                                                else if($ss=='5')
                                                    $sd=C;
                                                else if($ss=='6')
                                                    $sd=D;
                                                else if($ss=='7')
                                                    $sd=E1;
                                                else if($ss=='8')
                                                    $sd=E2;
                                                else
                                                    $sd=9;
                                                */
                            echo '<table><tr><td><font color=blue>Please select the occupation of the person who makes the highest contribution to your household expenditure?</font></td><td>';
                            echo "<select name=sec_occup><option value=0>--Select--</option><option value=1>Unskilled Workers</option><option value=2>Skilled Workers</option><option value=3>Petty traders</option><option value=4>Shop owners</option><option value=5>Businessman/Industrialists with no Employees</option><option value=6>Businessman/Industrialists with 1-9 no of Employees</option><option value=7>Businessman/Industrialists with 10+ Employees</option><option value=8>Self employed professionals</option><option value=9>Clerical/Salesman</option><option value=10>Supervisory level</option><option value=11>Officers/Executives – Junior</option><option value=12>Officers/Executives-Middle/Senior</option></select></td></tr>";
                            echo '<tr><td><font color=blue>Please select the education of the person who makes the highest contribution to your household expenditure? </font></td><td>';
                            echo "<select name=sec_educ><option value=0>--Select--</option><option value=1>Illitrate</option><option value=2>Literate no formal education</option><option value=3>School upto 4 yrs</option><option value=4>School 5-9 yrs</option><option value=5>HSC/SSC</option><option value=6>Some college but not Grad</option><option value=7>Grad/Post Grad Gen</option><option value=8>Grad/Post Grad Prof</option></select></td></tr></table>";
                            //echo $sec[6][7];
                            
                        }
                        else if($qt=='textarea')
                        {
                            //$ctr++;
                            //$rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            //if($rss)
                            //to find table and its column search
                                $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                            $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                            $str=$rss2->first()->$column;
                                        else $str="type your response here";
                                }                                    
                                echo "<tr height=80><td></td><td colspan=2><textarea name=text$currq cols=150 rows=5 >$str</textarea> </td></tr>";                     
                        }else if($qt=='text')
                        {
                                $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rss)
                                $tt=$rss->first()->text_term;
                                $rt=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;                            
                                //to find table and its column search
                                $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                        $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                          $str=$rss2->first()->$column;
                                        else $str="type your response here";
                                }
                            echo "<tr height=80><td></td><td colspan=2><input type=text name=text$currq size=80  value=$str> </td></tr>";                     
                        }
                            else if($qt=='dropdown')
                        {    
                                $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rss)
                                $tt=$rss->first()->term;
                                $rt=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;                            
                                //to find table and its column search
                                $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                        $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                         { $str=$rss2->first()->$column;
                                            echo "<tr height=40><td></td><td>&nbsp;&nbsp;&nbsp;<select  name=text$currq style='font-size:1.2em;'><option>$str</option> <option >0</option><option >1</option><option>2</option><option >3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option >11</option><option >12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option >19</option><option >20</option><option >>=21</option> </select></td></tr>"; 
                                         }
                                         else
                                         {
 echo "<tr height=40><td></td><td>&nbsp;&nbsp;&nbsp;<select name=text$currq style='font-size:1.2em;'> <option >0</option><option >1</option><option>2</option><option >3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option >11</option><option >12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option >19</option><option >20</option><option >>=21</option> </select></td></tr>";
                                         }
                                }
                                          
                                                
                        }
                              else if($qt=='textrating')
                        {
                            $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term FROM `question_option_detail` WHERE `q_id`=$currq");
                            if($rd)
                            { $text_t=$rd->first()->text_term;
                                $rating_t=$rd->first()->rating_term;
                            }
                            //to display rating heading and its values
                            $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rss)
                            { 
                                $tt=$rss->first()->text_term;
                                $rt=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;
                            }
                            $col=count($rss->results()); 
                            echo "<table  cellpadding=0 cellspacing=0> <tr style=background-color:lightgray> <td width=65%>$th</td><td colspan=$col>$rh</td> </tr><tr><td width=65%></td>";
                            foreach($rss->results() as $rr)
                            {
                                echo "<td><center><font face=tahoma color=blue size=2>$rr->rating1_title</font></center></td>";
                            }
                            echo "</tr> ";      
                            //$rd=DB::getInstance()->query("SELECT distinct text_term, rating_term FROM `question_option_detail` WHERE `q_id`=$currq ");
                            //if($rd)//print_r($rd);
                            $tb='';$arr_temp=array();$arr_temp2=array();
                            //$v=$op->value;
                            //echo 'V:'.$v;
                            $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$text_t','$rating_t')");
                            if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $sql="SELECT $text_t , $rating_t FROM $tb WHERE `resp_id`=$resp_id  AND $text_t !=''  AND $rating_t !=''";
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
                                {   $strt='';
                                    //echo "<tr><td><input type=text placeholder='type your top expectation here' name=t$ic size=60></td>";
                                    if(count($arr_temp)>0){$strt=$arr_temp[$ic];}
                                    echo "<tr><td><textarea placeholder='type your top expectation here' name=t$ic style='border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'>$strt</textarea></td>";
                                    $rss1=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                                    if($rss1)
                                    foreach($rss1->results() as $rr)
                                    { //echo $rr->rating1_valuel;
                                        $str='';
                                        if(count($arr_temp2)>0)
                                        if($rr->rating1_value==$arr_temp2[$ic])
                                             { 
                                                $str="checked='checked'";
                                            }
                                            //echo $str
                                        echo "<td><center><input type=radio $str name=rank$ic value=$rr->rating1_value ><br>$rr->rating1_value</center></td>";
                                    }
                                    echo "</tr>";
                                }                    
                                echo "</table>";                   
                        }else if($qt=="title2rating")
                        {           
                            $ctr=0;$ic=0;$acnt=0;
                            //echo '<br>cqq:'.$currq;
                            //to find table and its column search
                            $column1='';$column2='';$column3='';$table='';$arr_temp=array();$arr_temp1=array();$arr_temp2=array();
                            $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term, rating2_term FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rd)
                            {
                                $column1=$rd->first()->text_term;
                                $column2=$rd->first()->rating_term;
                                $column3=$rd->first()->rating2_term;
                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column1','$column2','$column3') ";
                                $tbf1=DB::getInstance()->query($tbf);
                                if($tbf1)
                                {  
                                    $table=$tbf1->first()->TABLE_NAME;}
                                }
                                        $sql="SELECT $column1,$column2,$column3 FROM $table WHERE resp_id=$resp_id AND ($column2 !='' OR $column3 !='')";
                                        $rs=DB::getInstance()->query($sql);
                                        if($rs->count()>0)
                                        foreach($rs->results() as $r)    
                                        {   //echo $r->$t; 
                                            $rv=$r->$column1; 
                                            $rv1=$r->$column2;    
                                            $rv2=$r->$column3; 
                                            array_push($arr_temp, $rv);
                                            array_push($arr_temp1, $rv1);
                                            array_push($arr_temp2, $rv2);
                                        }
                                //print_r($arr_temp);
                            $count_rd=DB::getInstance()->query("SELECT distinct rating1_value, rating1_title FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($count_rd)
                                $count_rating=count($count_rd->results());
                            
                            //get top rank company other tan clent
                            $rating1_heading='Best Rating';$cc='';$rank1c='';
                            $r1=DB::getInstance()->query("SELECT `project_id`, `name`, `company_name`, `brand`, `background`, `tot_visit`, `research_type` FROM `project` WHERE `project_id`=3");
                            if($r1->count()>0)
                            {
                                $cc=$r1->first()->company_name;
                                $rdd=DB::getInstance()->query("SELECT c_rank1 FROM `demosurvey` WHERE `resp_id`=$resp_id AND c_rank1 !=''");
                                if($rdd->count()>0)
                                {    
                                    $rank1c=$rdd->first()->c_rank1;
                                }
                                    if($cc!=$rank1c)
                                    {    $rating1_heading=$rdd->first()->c_rank1;
                                        $rating1_heading.=' Rating';
                                    }else
                                    {
                                        $rdd=DB::getInstance()->query("SELECT c_rank2 FROM `demosurvey` WHERE `resp_id`=$resp_id AND c_rank2 !=''");
                                        if($rdd->count()>0)
                                        {    
                                            $rating1_heading=$rdd->first()->c_rank2;
                                            $rating1_heading.=' Rating';
                                        }
                                    }
                            }
                            //display text heading by options       
                            $rg=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq group by `txt_heading`");
                            if($rg)
                            foreach($rg->results() as $rrr)
                            {       $ctr++;
                                    $count_rd2=DB::getInstance()->query("SELECT distinct rating1_value, rating1_title FROM `question_option_detail` WHERE `q_id`=$currq ");
                                    $tth=$rrr->txt_heading; 
                                    echo "<table cellpadding=0 cellspacing=0> <tr style=background-color:lightgray> <td width=60%>$rrr->txt_heading</td> <td colspan=$count_rating> $rrr->rating1_heading </td><td>~</td> <td colspan=$count_rating>$rating1_heading</td> </tr><tr><td width=60%></td>";
                                    foreach($count_rd2->results() as $rr)
                                    {
                                           echo "<td><center><font face=tahoma color=blue size=2>$rr->rating1_title </font></center></td>";
                                    }
                                    echo "</td><td>";
                                    foreach($count_rd2->results() as $rr1)
                                    {
                                           echo "<td><center><font face=tahoma color=blue size=2>$rr1->rating1_title</font></center></td>";
                                    }
                                    echo "</tr> ";                  
                                    $rg111=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq AND `txt_heading`='$tth'");
                                    if($rg111)
                                        foreach($rg111->results() as $rr22)
                                        {   $ic++;$ch='n';
                                            //if($arr_temp[$acnt]==$rr22->opt_text_value)
                                            //{ $ch='y';}
                                            echo "<tr><td><textarea name=$rr22->op_id readonly style='border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'>$rr22->opt_text_value</textarea> </td>";
                                            $rss2=DB::getInstance()->query("SELECT distinct rating1_value, rating1_title FROM `question_option_detail` WHERE `q_id`=$currq ");
                                            if($rss2)
                                            foreach($rss2->results() as $rr1)
                                            {
                                                $str1='';
                                                if(count($arr_temp1)>0)
                                                if($arr_temp1[$acnt]==$rr1->rating1_value ){$str1="checked='checked'";}
                                                echo "<td><center><input type=radio name=rank_1_$ctr$ic $str1 value=$rr1->rating1_value><br> $rr1->rating1_value </center></td>";    
                                            }
                                            //echo "<td><select name=rank2$ic><option  value=0>--Select Rating--</option>";
                                            echo "</td><td>";
                                            foreach($rss2->results() as $r1)
                                            {
                                                $str1='';//echo $arr_temp[$acnt];
                                                if(count($arr_temp2)>0)
                                                if($arr_temp2[$acnt]==$r1->rating1_value ){$str1="checked='checked'";}
                                                echo "<td><center><input type=radio name=rank_2_$ctr$ic $str1 value=$r1->rating1_value><br> $r1->rating1_value </center></td>"; 
                                                //echo "<option  value=$rr2->rating1_value>$rr2->rating1_value - $rr2->rating1_title</option>";
                                            }
                                                $acnt++;
                                                //echo "</select></td>";
                                        }
                                    echo "</tr></table><br>";
                            }
                        }
                        else if($qt=='radio')
                        {
                            //display the options as radio
                            $isval=0;$arr_dis=array();

                            $dis=DB::getInstance()->query("SELECT fst_prod_expo, scd_prod_expo, all_prod_exposed
FROM pilot
WHERE q_id =$qset
AND resp_id=$resp_id and (fst_prod_expo !=  ''
OR  scd_prod_expo !=  ''
OR all_prod_exposed !=  '')");
                            if($dis->count()>0)
                            foreach($dis->results() as $d){$a=$d->fst_prod_expo;$b=$d->scd_prod_expo;$c=$d->all_prod_exposed; if($a!='')array_push($arr_dis,$a);if($b!='')array_push($arr_dis,$b);if($c!='')array_push($arr_dis,$c);}

                            
                            $rs3=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rs3->count()>0)
                            foreach($rs3->results() as $op)
                            {   
                                $eng_text=$op->opt_text_value; $opid=$op->op_id; $t=$op->term;$tb='';$arr_temp=array();$str='';$v=$op->value;
                                //echo 'V: '.$v;
                                $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$op->term')");
                                if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $sqtb="SELECT $t FROM $tb WHERE `resp_id`=$resp_id  AND $t IS NOT NULL";
                                  
                                $rss=DB::getInstance()->query($sqtb);$arr_temp=array();
                                if($rss->count()>0)
                                foreach($rss->results() as $r)    
                                {   //echo $r->$t; 
                                   $tv=$r->$t;  if($tv!='')  array_push($arr_temp, $tv);}
                                    if($qc=='disable')
                                    {   //echo 'cnt:'.count($arr_temp); echo '<br>'.$v; print_r($arr_temp);
                                        if(!empty($arr_temp)) $isval=1; else $isval=0;
                                        if(in_array($v,$arr_temp))
                                        { 
                                          $str="checked='checked'";
                                        }
                                       else if(in_array($v,$arr_dis))$str=" disabled";
                                    }
                                    else
                                    {
                                        if(in_array($v,$arr_temp))
                                        { 
                                          $str="checked='checked'";
                                        }
                                    }
                                      

                                if($lang==''||$lang=='none')
                                {
                                echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name=q$currq $str value='$op->value'></td><td> $op->opt_text_value</td></tr>";
                                }
                                else if($lang=='hindi')
                                {
                                     $rs33=DB::getInstance()->query("SELECT * FROM `hindi_question_option_detail` WHERE `op_id`=$opid ");
                                     if($rs33->count()>0)                            
                                     {   
                                          $h_text=$rs33->first()->opt_text_value;
                                          echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name=q$currq $str value='$v'></td><td>$eng_text  [ $h_text ]</td></tr>";
                                     }
                                      else  
                                      {
                                         echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name=q$currq $str value='$op->value'></td><td> $op->opt_text_value</td></tr>";
                                      }
                                 }
                                
                            }
                        }
                        else if($qt=='checkbox')
                        {   $j=0;
                            $rs3=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rs3)
                            foreach($rs3->results() as $op)
                            {   $j++;
                                $eng_text=$op->opt_text_value; $opid=$op->op_id;$t=$op->term;$tb='';$arr_temp=array();$str='';$v=$op->value;
                                
                                $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$op->term')");
                                if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $rss=DB::getInstance()->query("SELECT $t FROM $tb WHERE `resp_id`=$resp_id  AND $t IS NOT NULL");
                                if($rss->count()>0)
                                foreach($rss->results() as $r)    
                                {   
                                    $tv=$r->$t;    array_push($arr_temp, $tv);}
        
                                    if(in_array($v,$arr_temp))
                                    { 
                                        $str="checked='checked'";
                                    }
                                
                                if($lang==''||$lang=='none')
                                {
                                echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big'  name='$op->term$op->value' $str value='$op->value'></td><td> $op->opt_text_value </td></tr>";
                                }
                                else if($lang=='hindi')
                                {
                                     $rs33=DB::getInstance()->query("SELECT * FROM `hindi_question_option_detail` WHERE `op_id`=$opid ");
                                     if($rs33->count()>0)                            
                                     {   
                                          $h_text=$rs33->first()->opt_text_value;
                                          echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big'  name='$op->term$op->value' $str value='$v'></td><td>$eng_text  [ $h_text ]</td></tr>";
                                     }
                                     else  
                                {
                                echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' name='$op->term$op->value' $str value='$op->value'></td><td> $op->opt_text_value </td></tr>";
                                }
                                 }
                            }
                        }
                 echo "</table><br>";       }   //end of question type
                    } // end foreach of ques
   //         	}
                               echo '<br><br><br>';
		  echo "<div id=footer>";
					//echo "<center><a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=3&rsp=$resp_id'><input type='button' name='reset_survey' value='Reset Survey' style=background-color:#004c00;color:white;height:35px;></a> <a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=2&rsp=$resp_id'><input type='button' name='prev' value='Previous' style=background-color:#004c00;color:white;height:35px;></a> <a href='?qset=$qset&next=1&rsp=$resp_id'><input type='submit' name='save' value='Save & Next' style=background-color:#004c00;color:white;height:35px;></a>";

echo "<a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=2&rsp=$resp_id'><input type='button' name='prev' value='Previous' style=background-color:#004c00;color:white;height:35px;></a>";

echo "<a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id#'> <input type='submit' name='save' value='Save & Next' onclick='return Validate();' style='background-color:#004c00;color:white;height:35px;position:absolute; left:50%;'></a> </center> ";
                                
                         echo "<br><br><br>";
		   echo "</div>";
			}//else end
		        
		        }
		
		echo "</form>";
 }

            }	
  // end previous button========================================================================
  
	if($_GET['next']==-1)
	{
                $qset=$_GET['qset'];
                //$currq=$_SESSION['firstq'];
                //session_destroy(); 
                //session_start(); 
                //$_SESSION['psec']='0';
                
                $rspst=DB::getInstance()->query("SELECT  `status` FROM `respondent_link_map` WHERE `resp_id`=$resp_id");
                if($rspst->count()>0)
                {
                    $rp1=$rspst->first()->status;
                    //echo '<br>Your Status:'.$rp1=$rspst->first()->status;
                    if($rp1==2)
                    {
                        echo '<br>You cannot start the test';
                    }
                    else{
                            $_SESSION['currq']='0';
                            $_SESSION['resp']=$resp_id;
                            
                            if($_SESSION['currq']=='0')
                            {
                            $rs1=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE qset_id = $qset and q_id=0");
                            if($rs1)
                            {
                            $_SESSION['firstq']=$rs1->first()->next_qid;
                            $_SESSION['currq']=$rs1->first()->next_qid;
                            $_SESSION['nextq']=$rs1->first()->next_qid;			
                            }
                        }
                        $rs1=DB::getInstance()->query("SELECT * FROM `question_routine_detail` WHERE `qset_id`=$qset and q_id = $currq");
                        if($rs1)
                        {    
                        $qn=$rs1->first()->q_id;
                        $currq=$qn;
                        $nq=$rs1->first()->next_qid;
                        $_SESSION['currq']=$nq;
                        $rs22=DB::getInstance()->query("SELECT * FROM `question_routine_detail` WHERE `qset_id`=$qset and q_id = $nq");
                        if($rs22->count()>0)
                        {
                        $nq2=$rs22->first()->next_qid;
                        $_SESSION['nextq']=$nq2;
                        //$_SESSION['psec']='';
                        }
                        //$_SESSION['prevq']=$currq;
                        $_SESSION['cso']=0;
                     
                        //DISPLAY THE QUESTION
                    
                        $rs2=DB::getInstance()->query("select * FROM `question_detail` WHERE q_id =$nq");
                        if($rs2)
                        {
echo "<div id=header>";
                            echo "<div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div>";
echo "</div>"; 
                                
                                $eng_qtitle=$rs2->first()->q_title;
                                $qt=$rs2->first()->q_type;
                                $ifvideo=$rs2->first()->video;
                                $ifaudio=$rs2->first()->audio;
                                $ifimage=$rs2->first()->image;

                                if($lang==''||$lang=='none')
                                {
                                     echo '<p><font color=blue>'.$eng_qtitle.'</font></p>';
                                }
                                else if($lang=='hindi')
                                {
                                        $rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$nq");
                                        if($rs22->count()>0)
                                        {    $h_qtitle=$rs22->first()->q_title;
                                             echo "<table><tr><td><font color=blue>$eng_qtitle </font</td></tr><tr><td><font color=blue>[ $h_qtitle ]</font></td></table>";
                                        }
                                        else
                                              echo '<p><font color=blue>'.$eng_qtitle.'</font></p>';
                                }

                                if($qt=='instruction')
                                {
                                    if($ifaudio!='')
                                    {
                                        echo "<center><audio controls >";
                                            echo "<source src=$ifaudio type='video/mp3'>";
                                        echo "</audio></center><br>";
                                    }
                                    if($ifvideo!='')
                                    {
                                        echo "<center>";
                                        echo "<video id=myVideo width=320 height=176 controls>";
                                        echo "<source src=$ifvideo type='video/mp4'>";
                                        echo "  Your browser does not support HTML5 video.";
                                       echo "</video></center><br>";
                                    }
                                    if($ifimage!='')
                                    {
                                        echo "<center><figure><img src=$ifimage height=250 width=300>";
                                        echo "<figcaption>Fig.1 - Baba Baidhyanath, Deoghar, Sringarpuja</figcaption></figure></center><br>";
                                    }
                                }

                           } 
                          
                          


                        
                        $_SESSION['psec']='0';
            echo "<br><br>";
                        //if($_SESSION['firstq']==$currq)
                        echo "<div id=footer>";
                                echo "<center><a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id'> <input type='button' name='next' value='Continue Survey' style=background-color:#004c00;color:white;height:35px;></a></center>"; 
                        echo "</div>";
                }}}
                else
                {
                    echo '<br>Respondent Id does not exist';
                }
        }
	if($_GET['next']==1)
	{ //echo '<br>sec:'.$_GET['sec'];
            if($_SESSION['resp']!=$resp_id)
            {
                echo 'You have entered wrong URL, pls use your correct URL';
            }
            else{
                
                            if(isset($_POST['save']))
                            {
                                //print_r($_POST);
                                //echo '<br>';
                                if(!isset($_SESSION['resp']))
                                {
                                    echo '<br>session not set<br>';
                                }    
                                $qt=$_SESSION['qt'];
                                $qid=$_SESSION['currq'];
                                $qsec=$_SESSION['qsec'];
                                $qsec=$_SESSION['psec'];
                                
                                $ar=  explode(',', $qt);
                                $noq=count($ar);
                                if($noq==1)
                                    $qt=$ar[0];
                                else if($noq==2)
                                {
                                    if($ar[0]==$ar[1])
                                        $qt=$ar[0];
                                }
                                else if($noq==3)
                                {
                                    if($ar[0]==$ar[1] && $ar[1]==$ar[2])
                                        $qt=$ar[0];
                                    
                                }else if($noq==4)
                                {
                                    if($ar[0]==$ar[1] && $ar[1]==$ar[2] && $ar[2]==$ar[3])
                                        $qt=$ar[0];
                                }else if($noq==5)
                                {
                                    if($ar[0]==$ar[1] && $ar[1]==$ar[2] && $ar[2]==$ar[3] && $ar[3]==$ar[4])
                                        $qt=$ar[0];
                                }
                        //start===================================================================================================================================
                                //to store all values
                                $arr_post=array();
                                            foreach($_POST as $k=>$v)
                                            {  
        
                                                    if($k!='save')
                                                    {
                                                        if($k != 'other1')
                                                        {
                                                            if($v!='')if($v!='others')
                                                                array_push($arr_post,$v);
                                                        }
                                                    }
                                                }
                                            
                                //to get the question type
                                $arrr=array();$dist=0;$qctr=-1;$qrv=0;$arrctr=0;$qqtype='';
                                $arr=explode(',', $qsec);
                                //print_r($arr_post);
                                $sql1="SELECT distinct q_id FROM `question_routine_detail` WHERE qsec in ($qsec) AND qset_id=$qset ";
                                $d1=DB::getInstance()->query($sql1);
                                if($d1->count() > 0)
                                {   
                                     $q=0;
                                    foreach ($d1->results() as  $v) 
                                    {   $q++;
                                       //echo '<br>ctr:'. $qctr;
                                        $qid=$v->q_id;
                                        
                                        $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                        $qtd2=DB::getInstance()->query($qtd);
                                        $qqtype=$qtd2->first()->q_type;
                                        
                                        if($qqtype=='instruction' || $qqtype=='top3rankcompany')
                                        {$q--; continue;}
                                    
                                    
                                    } 
                                    //if(count($arr_post)< $q || $q==0)
                                    if(count($arr_post)< $q || $q==0)
                                    {
                                        echo "<font color=red>Please fill all the questions of previous and current section to be proceed...</font>";
                                    }
                                    else
                                    {
                                    $sql1="SELECT distinct q_id FROM `question_routine_detail` WHERE qsec in ($qsec) AND qset_id=$qset order by q_id";
                                $df=DB::getInstance()->query($sql1);
                                
                                if($df->count() > 0)   

                                    
                                    foreach ($df->results() as  $val) 
                                    {    $qctr++;
                                       //echo '<br>ctr:'. $qctr;
                                        $qid=$val->q_id;
                                        
                                       $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                        $qtd2=DB::getInstance()->query($qtd);
                                        $qqtype=$qtd2->first()->q_type;
                                         
                                        if($qqtype=='instruction' || $qqtype=='top3rankcompany')
                                            {$qctr--;continue;}
                                        else if($qqtype=='text' || $qqtype=='textarea' || $qqtype=='radio'|| $qqtype =='rating' || $qqtype=='calculated' || $qqtype =='dropdown')
                                        {  
                                            //to find table and its column search
                                            $column='';$table='';$arr_column=array();$arr_table=array();
                                           $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$qid ";
                                            $rd=DB::getInstance()->query($sq);
                                            if($rd)
                                            {
                                                $column=$rd->first()->term;
                                                array_push($arr_column,$column);
                                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                $tbf1=DB::getInstance()->query($tbf);
                                                if($tbf1)
                                                    $table=$tbf1->first()->TABLE_NAME;array_push($arr_table,$table);
                                            }
                                            //end of table ans its column search
                                            //print_r($arr_post); 
                                             $vdata=$arr_post[$qctr];
                                            $stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            //print_r($r->results());
                                            //echo $qqtype;
                                            if($r->count()>0 && $qqtype!='calculated')
                                            {
                                                //update code here
                                             $stat="UPDATE $arr_table[0] SET $arr_column[0]='$vdata' WHERE resp_id=$resp_id AND q_id=$qset AND $arr_column[0]!=''";
                                                DB::getInstance()->query($stat);
                                            }
                                            else if($r->count()>0 && $qqtype=='calculated')
                                            { //echo $r->count();
                                                $qctr++;
                                                $vdata2=$arr_post[$qctr];
                                                $qctr++;
                                                $vdata3=$arr_post[$qctr];
                                                $stat="UPDATE $arr_table[0] SET no_of_pack='$vdata', pack_size='$vdata2',$arr_column[0]='$vdata3'  WHERE resp_id=$resp_id AND q_id=$qset AND no_of_pack !='' AND pack_size !='' AND $arr_column[0] !='' ";
                                                DB::getInstance()->query($stat);
                                                
                                            }
                                               
                                            else if($r->count()<=0 && $qqtype!='calculated')
                                            {
                                                //insert code here
                                             $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$vdata')";
                                                DB::getInstance()->query($stat);
                                            }
                                            else if($r->count()<=0 && $qqtype=='calculated')
                                            {
                                                $qctr++;
                                                $vdata2=$arr_post[$qctr];
                                                $qctr++;
                                                $vdata3=$arr_post[$qctr];
                                                $stat="INSERT INTO $arr_table[0] (resp_id,q_id,no_of_pack, pack_size, $arr_column[0]) VALUES($resp_id,$qset,'$vdata','$vdata2','$vdata3')";
                                                DB::getInstance()->query($stat);
                                            }
                                        }//end if of qt text
                                      
                                        else if($qqtype=='checkbox')
                                        { 
                                                $column='';$table='';$arr_column=array();$arr_table=array();
                                            $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$qid ";
                                            $rd=DB::getInstance()->query($sq);
                                            if($rd)
                                            {
                                                $column=$rd->first()->term;
                                                array_push($arr_column,$column);
                                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                $tbf1=DB::getInstance()->query($tbf);
                                                if($tbf1)
                                                    $table=$tbf1->first()->TABLE_NAME;array_push($arr_table,$table);
                                            }
                                            //end of table ans its column search
                                            //$vdata=$arr_post[$qctr];
                                           $stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            //print_r($r->results());
                                                $cnt=$r->count();
                                                    //print_r($arr_post);
                                                    $c=count($arr_post);
                                                   // if($qrv<$c)
                                                        $qrv=$c;
                                                    //echo '<br>qrv:'.$qrv;
                                                    $qctr--;
                                            if($cnt > 0)
                                            { 
                                                //update code here
                                                //echo '<br>'.$stat="UPDATE $arr_table[0] SET $arr_column[0]='$vdata' WHERE resp_id=$resp_id AND $arr_column[0]!=''";
                                                //DB::getInstance()->query($stat);
                                                 $stat="DELETE FROM $arr_table[0]  WHERE resp_id=$resp_id AND q_id=$qset AND $arr_column[0]!=''";
                                                $rs=DB::getInstance()->query($stat);
                                                             
                                                for($i=$qctr+1;$i<$qrv;$i++)
                                                //for($i=0;$i<$cnt;$i++)
                                                {   $qctr++;
                                                    $vdata=$arr_post[$qctr];
                                                  $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$vdata')";
                                                DB::getInstance()->query($stat);
                                                
                                                }
                                            }
                                            else
                                            {
                                                
                                                //insert code here
                                                for($i=$qctr+1;$i<$qrv;$i++)
                                                //for($i=0;$i<$cnt;$i++)
                                                {
                                                    $qctr++;
                                                    $vdata=$arr_post[$qctr];
                                                   $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$vdata')";
                                                DB::getInstance()->query($stat);
                                                
                                                }
                                            }
                                        }
                                        else if($qqtype=='sec')
                                        {   
                                            echo $qqtype;
                                            $sec_occup=$_POST['sec_occup'];
                                            $sec_educ=$_POST['sec_educ'];
                                            
                                                $sec=array(
                                                    array('E2','E2','E2','E1','D','D','D','D'),
                                                    array('E2','E1','E1','D','C','C','B2','B2'),
                                                    array('E2','D','D','D','C','C','B2','B2'),
                                                    array('D','D','D','C','B2','B1','A2','A2'),
                                                    array('D','C','C','B2','B1','A2','A2','A1'),
                                                    array('D','C','C','B2','B1','A2','A1','A1'),
                                                    array('B1','B1','B1','A2','A2','A1','A1','A1'),
                                                    array('D','D','D','D','B2','B1','A2','A1'),
                                                    array('D','D','D','D','C','B2','B1','B1'),
                                                    array('D','D','D','C','C','B2','B1','A2'),
                                                    array('C','C','C','C','B2','B1','A1','A1'),
                                                    array('B1','B1','B1','B1','B1','A2','A1','A1')
                                                );
                                                $ss=$sec[$sec_occup-1][$sec_educ-1];
                                                $sd='';
                                                if($ss=='A1')
                                                    $sd=1;
                                                else if($ss=='A2')
                                                    $sd=2;
                                                else if($ss=='B1')
                                                    $sd=3;
                                                else if($ss=='B2')
                                                    $sd=4;
                                                else if($ss=='C')
                                                    $sd=5;
                                                else if($ss=='D')
                                                    $sd=6;
                                                else if($ss=='E1')
                                                    $sd=7;
                                                else if($ss=='E2')
                                                    $sd=8;
                                                else
                                                    $sd=9;
                                                
                                            //to find table and its column search
                                            $column='';$table='';$arr_column=array();$arr_table=array();
                                            $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$qid ";
                                            $rd=DB::getInstance()->query($sq);
                                            if($rd)
                                            {
                                                $column=$rd->first()->term;
                                                array_push($arr_column,$column);
                                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                $tbf1=DB::getInstance()->query($tbf);
                                                if($tbf1)
                                                    $table=$tbf1->first()->TABLE_NAME;array_push($arr_table,$table);
                                            }
                                            //end of table ans its column search
                                            //$vdata=$arr_post[$qctr];
                                            $stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND q_id=$qset AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            if($r->count()>0)
                                            {
                                                //update code here
                                                $stat="UPDATE $arr_table[0] SET $arr_column[0]='$sd' WHERE resp_id=$resp_id AND q_id=$qset AND q_id=$qset AND $arr_column[0]!=''";
                                                DB::getInstance()->query($stat);
                                            }
                                            else
                                            {
                                                //insert code here
                                                $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$sd')";
                                                DB::getInstance()->query($stat);
                                            }
                                            
                                        }
                                        else if($qqtype=='textrating')
                                        {   
                                            
                                                    $arrq=  array();$arr_column1=array();$arr_column2=array();$arr_table=array();
                                                       
                                                      $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                                      $qtd1=DB::getInstance()->query($qtd);
                                                      if($qtd1->first()->q_type!='instruction' || $qtd1->first()->q_type!='top3rankcompany')
                                                      {  
                                                      //to find table and its column search
                                                      $column1='';$column2='';$table='';
                                                      $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term, textbox_count FROM `question_option_detail` WHERE `q_id`=$val->q_id ");
                                                      if($rd)
                                                      {
                                                          $tb_count=$rd->first()->textbox_count;
                                                          $qrv=$tb_count;
                                                          $column1=$rd->first()->text_term;
                                                          $column2=$rd->first()->rating_term;
                                                          array_push($arr_column1,$column1);
                                                          array_push($arr_column2,$column2);
                                                          $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column1','$column2') ";
                                                          $tbf1=DB::getInstance()->query($tbf);
                                                          if($tbf1)
                                                          {  $table=$tbf1->first()->TABLE_NAME;array_push($arr_table,$table);}
                                                      }
                                                      }
                                                    
                                                      $stat2="SELECT $arr_column1[0],$arr_column2[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column1[0]!='' AND $arr_column2[0]!=''";
                                                      $rst=DB::getInstance()->query($stat2);
                                                      if($rst->count()>0)
                                                      {
                                                           $stat="DELETE FROM $arr_table[0]  WHERE resp_id=$resp_id AND q_id=$qset AND $arr_column1[0]!='' AND $arr_column2[0]!=''";
                                                           $rs=DB::getInstance()->query($stat);
                                                              
                                                              for($i=$qctr;$i<$qrv;$i+=2)
                                                              {   
                                                                      $ii=$i+1;  
                                                                      $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]')";
                                                                      $ii=0;
                                                                      $rs=DB::getInstance()->query($stat);
                                                              }
                                                       }
                                                      else
                                                      {    
                                                           for($i=$qctr;$i<$qrv;$i+=2)
                                                           {   
                                                                      $ii=$i+1;  
                                                                      $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]')";
                                                                      $ii=0;
                                                                      $rs=DB::getInstance()->query($stat);
                                                            }
                                                      }                                                      
                                        }//end if of qt textrating
                                        if($qqtype == 'title2rating')
                                        {
                                                //echo $qqtype;
                                                $arr_post=array();
                                                foreach($_POST as $k=>$v)
                                                {   
                                                    if($k!='save')
                                                    {
                                                        if($k != 'other1')
                                                        {
                                                            if($v!='')
                                                                array_push($arr_post,$v);
                                                        }
                                                    }
                                                }
                                            
                                                 $arrq=array();$arr_column1=array();$arr_column2=array(); $arr_column3=array();$arr_table=array();
                                                  
                                                    //echo '<br>'.$val->q_id.' qt:'.$_SESSION['qt'];
                                                     array_push($arrq, $val->q_id);   
                                                        
                                                    //to find table and its column search
                                                    $column1='';$column2='';$column3='';$table='';
                                                    $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term, rating2_term, count(*) as cnt FROM `question_option_detail` WHERE `q_id`=$val->q_id ");
                                                    if($rd)
                                                    {
                                                        $column1=$rd->first()->text_term;
                                                        $column2=$rd->first()->rating_term;
                                                        $column3=$rd->first()->rating2_term;
                                                        $qrv=$rd->first()->cnt;
                                                        array_push($arr_column1,$column1);
                                                        array_push($arr_column2,$column2);
                                                        array_push($arr_column3,$column3);

                                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column1','$column2','$column3') ";
                                                        $tbf1=DB::getInstance()->query($tbf);
                                                        if($tbf1)
                                                        {  $table=$tbf1->first()->TABLE_NAME;
                                                            array_push($arr_table,$table);}
                                                    }
                                                 // print_r($arr_post);
                                                    $c=count($arr_post);
                                                    if($qrv<$c)
                                                        $qrv=$c;
                                                    //echo '<br>qrv:'.$qrv;
                                                    $stat2="SELECT $arr_column1[0],$arr_column2[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND q_id$=$qset AND $arr_column1[0]!='' AND $arr_column2[0]!=''";
                                                    $rst=DB::getInstance()->query($stat2);
                                                    if($rst->count()>0)
                                                    {
                                                        $stat="DELETE FROM $arr_table[0]  WHERE resp_id=$resp_id AND q_id=$qset AND $arr_column1[0]!='' AND $arr_column2[0]!='' AND $arr_column3[0]!=''";
                                                        //$rs=DB::getInstance()->query($stat);

                                                        $ii=0;$iii=0;$temp='';$temp2='';$arr=array();
                                                        for($i=$qctr;$i<$qrv;$i+=3)
                                                        {  
                                                            $ii=$i+1;$iii=$i+2;
                                                                $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0],$arr_column3[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]','$arr_post[$iii]')";
                                                                $rs=DB::getInstance()->query($stat);
                                                            
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $ii=0;$temp='';$temp2='';$arr=array();
                                                        for($i=$qctr;$i<$qrv;$i+=3)
                                                        {  
                                                            $ii=$i+1;$iii=$i+2;
                                                                $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0],$arr_column3[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]','$arr_post[$iii]')";
                                                                $rs=DB::getInstance()->query($stat);
                                                        }
                                                    }
                                        } //end of q of title2rating
                                    } //foreach end for qt
                                  } //else ended
                                }
                        
                        //end====================================================================================================================================        
                                
       }//save button end
                           
                $arr_nsec=array();
                $qsecs=0;$_SESSION['qt']='';
                $prev_c=$_SESSION['currq'];
                $psec=$_SESSION['psec'];                
                $currq=$_SESSION['nextq'];
                
                
                //echo 'strting...';
                if(isset($_GET['sec'])) 
                {   
                   //$qsec=$_GET['sec'];
                   //$psec=$qsec; $_SESSION['psec']=$qsec; 
              
                }
                //to find the routine details of current question
                $aaa="select * FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($psec) order by q_id";
                $psd=DB::getInstance()->query($aaa);
                
                if($psd->count()>0)
                {    
                    foreach ($psd->results() as $p)
                    {   //echo '<br>qid: '.$p->q_id;    
                        
                                $qid=$p->q_id;
                                if($qid==0)
                                    continue;
                                $opv=$p->op_value;
                                $nqid=$p->next_qid;
                                $rt=$p->routine;
                                $comps=$p->compare_sign;
                                $join=$p->join_with;
                                //find the selected option by user from database
                                
                                        $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                        $qtd1=DB::getInstance()->query($qtd);
                                        $qtt=$qtd1->first()->q_type;
                                        if($qtd1->first()->q_type=='radio' || $qtd1->first()->q_type=='text' || $qtd1->first()->q_type=='rating' || $qtd1->first()->q_type=='checkbox'|| $qtd1->first()->q_type=='textarea' || $qtd1->first()->q_type=='checkbox' || $qtd1->first()->q_type=='calculated' || $qtd1->first()->q_type=='sec')
                                        if($qtd1->first()->q_type!='instruction' || $qtd1->first()->q_type!='top3rankcompany')
                                        {  
                                                //to find table and its column search
                                                $column='';$table='';
                                               $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$qid ";
                                                $rd=DB::getInstance()->query($sq);
                                                if($rd)
                                                {
                                                    $column=$rd->first()->term;
                                                    //array_push($arr_column,$column);
                                                    $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                    $tbf1=DB::getInstance()->query($tbf);
                                                    if($tbf1)
                                                        $table=$tbf1->first()->TABLE_NAME;
                                                    //array_push($arr_table,$table);
                                                }
                                                $stat="SELECT $column FROM $table WHERE resp_id=$resp_id AND q_id=$qset AND $column !=''";
                                                $r=DB::getInstance()->query($stat);
                                                if($r->count()>0)
                                                {   
                                                    
                                                    //echo '<br>sopv::'.$opv;
                                                    $getv=$r->first()->$column; 
                                                    //echo '<br>opv::'.$opv.'getv:'.$getv;
                                                    if($nqid==-1)
                                                    { 
                                                                if($comps=='<')
                                                                {
                                                                        if($getv < $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='<=')
                                                                {
                                                                        if($getv <= $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='>')
                                                                {
                                                                        if($getv > $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='>=')
                                                                {
                                                                        if($getv >= $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='==')
                                                                {
                                                                        if($getv == $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='!=')
                                                                {
                                                                        if($getv != $opv)
                                                                        {   
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='range')
                                                                {
                                                                        if($getv >= $ar[0] && $getv <=$ar[1])
                                                                        {   
                                                                            $ar=  explode(',', $opv);
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='not range')
                                                                { 
                                                                        if(!$getv <= $ar[0] && !$getv >=$ar[1])
                                                                        {   
                                                                            $ar=  explode(',', $opv);
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                
                                                                if($opv==$getv)
                                                                {
                                                                            $_SESSION['currq']='-1';
                                                                            $currq='-1';   
                                                                            array_push($arr_nsec, $qsec);
                                                                }
                                                        continue;
                                                    }
                                                   $rrss="select * FROM `question_routine_detail` WHERE q_id = $nqid and qset_id=$qset";
                                                    $rss=DB::getInstance()->query($rrss);
                                                    if($rss)
                                                    $qsec=$rss->first()->qsec;
                                                    $ssarr=explode(",",$psec);
                                                    if($qtt=='textarea' || $qtt=='text' )
                                                    {
                                                        array_push($arr_nsec, $qsec);
                                                    }
                                                    if(in_array($qsec, $ssarr))
                                                            continue;
                                                    //$opv=$rss->first()->op_value;
                                                    //$qset=$rss->first()->qset_id;
                                                    //echo '<br>opv='.$opv .' && getv='.$getv; 
                                                    //echo "<br>$opv hh".$rr=  stristr($opv, ',');
                                                    if (strpos($opv,',') !== false) 
                                                    {
                                                                //echo '<br>'.$join;
                                                                if($opv!='0' || $opv!='')
                                                                {   
                                                                    $ar=  explode(',', $opv);
                                                                    if($comps =='range')
                                                                    {   //echo 'gg2='.$ar[0].'-'.$ar[1].'='.$getv; 
                                                                        if($getv >= $ar[0] && $getv <=$ar[1] )
                                                                        {   
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                    }
                                                                else if($comps=='not range')
                                                                { //echo 'hello';
                                                                        if($getv <= $ar[0] || $getv >=$ar[1])
                                                                        {   //echo 'hello';
                                                                            $ar=  explode(',', $opv);
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                }
                                                                else
                                                                {   //echo '<br>f:'.$qsec;    
                                                                    array_push($arr_nsec, $qsec);
                                                                }
                                                    }
                                                    else if( $comps!='')
                                                    { //echo 'A'.$comps;
                                                                if($comps=='>')
                                                                {
                                                                        if($getv > $opv)
                                                                        {   
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='>=')
                                                                {
                                                                        if($getv >= $opv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='<')
                                                                {
                                                                        if($getv < $opv)
                                                                        {   
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='<=')
                                                                {
                                                                        if($getv <= $opv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps=='==')
                                                                {
                                                                        if($opv == $getv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                else if($comps !='>')
                                                                {
                                                                        if($opv > $getv)
                                                                        {    
                                                                            $_SESSION['currq']=$qid;
                                                                            $currq=$qid;   
                                                                            array_push($arr_nsec, $qsec);
                                                                        } 
                                                                }
                                                                
                                                                else
                                                                {   //echo '<br>f:'.$qsec;    
                                                                    //array_push($arr_nsec, $qsec);
                                                                }
                                                    }
                                                    else
                                                    {
                                                        if($opv!='0' || $opv!='')
                                                        {   
                                                            if($opv == $getv)
                                                            {    
                                                                //echo '<br>qqsec:'.$qsec;
                                                                $_SESSION['currq']=$qid;
                                                                $currq=$qid;   
                                                                array_push($arr_nsec, $qsec);
                                                            }   
                                                        }
                                                        else
                                                        {   //echo '<br>f:'.$qsec;    
                                                            array_push($arr_nsec, $qsec);
                                                        }
                                                    
                                                    }
                                                    //echo '<br>qs: '.$qsec;    
                                                    //print_r($arr_nsec);
                                                }
                                                //else echo 'you must select the previous question option';
                                        }
                            //} //end if
                    } //foreach end
                } //if end      
                //echo '<br>final sec: ';
                //print_r($arr_nsec);
                //echo '<br>cq:'.$currq;
                //check the stop condition of previous question and force to submit the form
                $sql1="select * FROM `question_routine_detail` WHERE q_id = $prev_c and qset_id=$qset";
                $rr=DB::getInstance()->query($sql1);
                if($rr->count()>0)
                    $prev_routine=$rr->first()->routine;
                    //$prev_stop=$rr->first()->op_value;      
                    //$qsec=$rr->first()->qsec;
                    $prev_opv=$_SESSION['cso'];
                  //echo $currq;  
                    //if($prev_routine=='terminate' || $currq==-1)
                if( $currq==-1)
                {       
                       // if(isset($_GET['sec'])) { if($_SESSION['s']!=$_GET['sec']){$qsec=$_GET['sec']; $_SESSION['s']=$qsec;}}
                        //display tab               
                   /*     $sh1=DB::getInstance()->query("SELECT `sec_title`,qsec_id FROM `question_sec` WHERE `qset_id`=$qset order by qsec_id asc");   
                	if($sh1->count()>0)
                        {
                            echo "<center><table><tr>";
                            foreach ($sh1->results() as $h)
                            {
                                if($h->qsec_id==$qsec)
                                echo "<td><a href=https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:#004c00;color:white;height:50px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";    
                                    else
                                echo "<td><a href=https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:green;color:white;height:50px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";
                            }
                            echo '</tr></table></center><br>';
                        }//end display tab
               */
                        //echo 'pbc:'.$_SESSION['psec'];
                        //echo '<br>pac:'.$_SESSION['psec']=$qsec;
                        
                        
                        echo "<br><center><font size=5 color='red'>Thanks for your participation in the survey. <br>You can review your responses to all previous questions before final submission of the survey otherwise click on submit button to complete survey</font></center>";
                        echo "<br><br><center><a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=-1&rsp=$resp_id'><input type='button' name='next' value='Recheck' style=background-color:#004c00;color:white;height:50px;></a> <input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
                }
               else 
                {
                    $ctr=0;
                    //echo 'hi'.$qset;
                     
                    $qset=$_GET['qset'];
                  if($ctr==0)  
                  {  
 echo "<div id=header>";
                            echo "<div style=float:right><img src='../../images/Digiadmin_logo.jpg' height=30 width=130> </div>";

                    //display next question of prev ques
                    $qqqq="select * FROM `question_routine_detail` WHERE qset_id=$qset AND q_id = $currq";
                    $rs1=DB::getInstance()->query($qqqq);
                    if($rs1->count()>0)
                    {    
                       $qn=$rs1->first()->q_id;
                       $qsec=$rs1->first()->qsec;
                        //$currq=$qn;
                        //echo '<br>opvv:'.$opv=$rs1->first()->op_value;                        
                        $arr_nsec=array_unique($arr_nsec);
                        //echo '<br>count sec:'.count($arr_nsec);
                        if(count($arr_nsec)==1)
                        $qsec=implode("", $arr_nsec);
                        if(count($arr_nsec)>1)
                        {
                            $qsec=implode(",", $arr_nsec); 
                        }
                     
                $pqsec=$qsec;  
              
                    if(isset($_GET['sec'])) { if($_SESSION['s']!=$_GET['sec']){$qsec=$_GET['sec']; $_SESSION['s']=$qsec;}}
                        //display tab
                        $sh=DB::getInstance()->query("SELECT `sec_title`,qsec_id FROM `question_sec` WHERE `qset_id`=$qset order by qsec_id asc");  
                	if($sh)
                        { 
                            echo "<center><table><tr>";
                            foreach ($sh->results() as $h)
                            {
                                if($h->qsec_id==$qsec)
                                    echo "<td><a href=https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:#00e500;color:white;height:30px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";    
                                else
                                    echo "<td><a href=https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:green;color:white;height:30px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";
                            }
                            echo '</tr></table></center><br>';
                        }//end display tab
echo "</div>";
                        //DISPLAY THE QUESTION
                        $rss=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id = $currq");
                        if($rss)
                        //$qsec=$rss->first()->qsec;$qset=$rss->first()->qset_id;
                        //print_r($rss);
                //echo '<br>a qsec:'.$qsec;        
                        $arr_sec=array();
                        
                        $_SESSION['qsec']=$qsec;
                        //if(isset($_GET['sec'])) {$_SESSION['psec']=$_GET['sec'];}
                        $_SESSION['psec']=$qsec;
                        
                        //query for getting distinct question from all questionSet
                        //$qq="SELECT distinct `q_id`,`qset_id`, `next_qid`, `op_value`, `qsec`, `routine`, `compare_sign` FROM `question_routine_detail` WHERE `qset_id` = 2 and `qsec` in (11) order by `q_id`"; 
                   /*   
                       $sql="select * FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($qsec) order by q_id";
                        $rss3=DB::getInstance()->query($sql);
                       
                        if($rss3)
                        {    $_SESSION['currq']=$rss3->first()->q_id;
                             //$_SESSION['nextq']=$rss3->first()->next_qid;
                             $ovp=$rs1->first()->op_value;
                             $_SESSION['currq']=$currq;
                             $_SESSION['nextq']=$rss3->first()->next_qid;
                             
                        } 
                     */   
                        //print_r($rss);
                       $qlist=array();$qid=0;
                        $qq="SELECT distinct `q_id`,`qset_id` FROM `question_routine_detail` WHERE `qset_id` = $qset and `qsec` in ($qsec) order by `q_id`"; 
                        $rss333=DB::getInstance()->query($qq);
                        foreach($rss333->results() as $cq )
                        {  
                            
                            $qid=$cq->q_id;
                            //to find the routine details of current question
                            $qrd=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id=$qid");
                            if($qrd->count()>0)
                            {
                                $opv=$qrd->first()->op_value;
                                $nqid=$qrd->first()->next_qid;
                                $rt=$qrd->first()->routine;
                            }
                            //$_SESSION['currq']=$cq->q_id;
                            $rs2=DB::getInstance()->query("select * FROM `question_detail` WHERE q_id =$qid");
                            if($rs2->count()>0)
                            {       
                               $eng_qtitle=$rs2->first()->q_title;
                               $hindi_qtitle='';
                               $qc=$rs2->first()->condition;
                               $qt=$rs2->first()->q_type;
                               $currq=$cq->q_id;
                               if($qt!='instruction')
                               array_push($qlist,$currq); 
                                $_SESSION['currq']=$currq;
                                if(strlen(($_SESSION['qt']))<1)
                                    $_SESSION['qt'].=$qt;
                                else
                                    $_SESSION['qt'].=','.$qt;
                                $error=$currq.'e';
                                //start to find the question type and display its options
                                if($qt=='instruction')
                                {           
                                       if($lang==''|| $lang=='none')
                                       {
                                            echo '<table><tr><td><b><font color=black> '.$rs2->first()->q_title.'</font></b></td></tr></table><br>';
                                       }
                                       else if($lang=='hindi')
                                       {
                                            $rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                            if($rs22->count()>0)
                                            {       
                                                $hindi_qtitle=$rs22->first()->q_title;
                                                echo '<table><tr><td width=4%></td><td colspan=2><font color=black> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>';
                                                echo '<tr><td width=4%></td><td colspan=2><font color=black> ['.$hindi_qtitle.']</font><font color=red><span id='.$error.'></span></font></td></tr></table>';
                                            }
                                            else 
                                               echo '<table><tr><td width=4%></td><td colspan=2><font color=black> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr></table>'; 
                                        } $ifvideo='';$ifaudio='';$ifimage='';
                                            //$ifvideo=$rs2->first()->video;
                                            //$ifaudio=$rs2->first()->audio;
                                            //$ifimage=$rs2->first()->image;
                                        if($ifaudio!='')
                                        {
                                            
                                            echo "<center><audio controls autoplay>";
                                                echo "<source src=$ifaudio type='audio/mp3'>";
                                            echo "</audio></center><br><br>";
                                        }
                                        if($ifvideo!='')
                                        {
                                            echo "<center>";
                                            echo "<video id=myVideo width=320 height=176 controls>";
                                            echo "<source src=$ifvideo type='video/mp4'>";
                                            echo "  Your browser does not support HTML5 video.";
                                           echo "</video></center><br><br>";
                                        }
                                        if($ifimage!='')
                                        {
                                            echo "<center><figure><img src=$ifimage height=250 width=300>";
                                             echo "<figcaption>Fig.1 - A view of the pulpit rock in Norway.</figcaption></figure></center>";
                                        }
                                }
                                else if($lang==''||$lang=='none')
                                {   
                                    echo '<table><tr><td width=4%>'.$currq.'</td><td colspan=2><font color=blue> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>';   

                                }
                                else if($lang=='hindi')
                                {
                                     $rs22=DB::getInstance()->query("select * FROM `hindi_question_detail` WHERE q_id =$qid");
                                     if($rs22->count()>0)
                                     {       
                                          $hindi_qtitle=$rs22->first()->q_title;
                                          echo '<table><tr><td width=4%>'.$currq.'</td><td colspan=2><font color=blue> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>';
                                          echo '<tr><td width=4%></td><td colspan=2><font color=blue>  ['.$hindi_qtitle.']</font><font color=red><span id='.$error.'></span></font></td></tr>';
                                     }
                                     else 
                                         echo '<table><tr><td width=4%>'.$currq.'</td><td colspan=2><font color=blue> '.$eng_qtitle.'</font><font color=red><span id='.$error.'></span></font></td></tr>'; 
                                }

                        if($qt=='rating')
                        {
                           
                            
                            $sql="SELECT  `scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label` FROM `question_option_detail` WHERE `q_id`=$currq";
                            $da=DB::getInstance()->query($sql);
                            if($da->count()>0)
                            {
                                $sv=$da->first()->scale_start_value;
                                $ev=$da->first()->scale_end_value;
                                $sl=$da->first()->scale_start_label;
                                $el=$da->first()->scale_end_label;
                                
                                $arr_temp=array();$str='';
                            }
                            
                                            $column='';$table='';$arr_column=array();$arr_table=array();$vv='';
                                            $sq="SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ";
                                            $rd=DB::getInstance()->query($sq);
                                            if($rd)
                                            {
                                                $column=$rd->first()->term;
                                                array_push($arr_column,$column);
                                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                                $tbf1=DB::getInstance()->query($tbf);
                                                if($tbf1)
                                                    $table=$tbf1->first()->TABLE_NAME;array_push($arr_table,$table);
                                            }
                                          
                                            $stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            if($r->count()>0)
                                            {
                                                $vv=$r->first()->$arr_column[0];
                                                array_push($arr_temp, $vv);
                                            }
                                            //print_r($arr_temp);
                                if($sv==0)
                                {   $str='';
                                    echo "<table border=1><tr><td height=50> </td>";
                                    for($s=$sv+1;$s<=$ev;$s++)
                                    {
                                        echo "<td width=45> $s </td>";
                                    }
                                    echo "<td> </td><td>NA/Not Show</td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $sl </td>";
                                    for($s=$sv+1;$s<=$ev;$s++)
                                    {   
                                        if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';
                                        echo "<td width=45><input type=radio class=big  name=r$currq $str value=$s> </td>";
                                    }
                                     if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';

 
                                    echo "<td> $el &nbsp;&nbsp; </td><td ><input type=radio class=big  name=r$currq $str value=$s></td></tr></table>";                                
                                }else if($sv==1)
                                {
                                    echo "<table border=1><tr height=50><td> </td>";
                                    for($s=$sv;$s<=$ev;$s++)
                                    {
                                        echo "<td width=45> $s </td>";
                                    }
                                    echo "<td> </td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $sl </td>";
                                    for($s=$sv;$s<=$ev;$s++)
                                    {   
                                        if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';
                                        echo "<td width=45><input type=radio class=big name=r$currq $str value=$s> </td>";
                                    }
                                    echo "<td> $el </td></td></tr></table>"; 
                                }
                        }        
                        if($qt=='top3rankcompany')
                        {
                                $sql="SELECT `id`, `cname` FROM `company_list`";
                                for($i=1;$i<=3;$i++)
                                {
                                    $da=DB::getInstance()->query($sql);
                                    echo "<br>Rank $i: <select id=rank$i name=rank$i> <option>--Select--</option>";
                                    if($da->count()>0)
                                    foreach($da->results() as $d)
                                    {
                                    echo "<option>$d->cname</option>";
                                    }    
                                    echo "<option>others</option>";
                                    echo "</select> <input type=text name=other$i id=other$i placeholder='Specify here' style=display:none>";
                                }
                        }
                        if($qt=='calculated')
                        {
                                $column='';$table='';$str1='';$str2='';$str3='';
                                $rd1=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd1->count()>0)
                                {
                                        $column=$rd1->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                         $table=$tbf1->first()->TABLE_NAME;
                                         $sql="SELECT no_of_pack, pack_size, $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql); 
                                        if($rss2->count()>0) 
                                        {  $str1=$rss2->first()->no_of_pack;
                                            $str2=$rss2->first()->pack_size;
                                            $str3=$rss2->first()->$column;
                                        }
                                }               
                                echo "<tr><td></td><td>How many number of pack do you consume in a year?</td></tr>";
                                echo "<tr><td></td><td><input type=number min=0 name=tp id=tp value=$str1 placeholder='enter total pack in a year'> </td></tr>";
                                echo "<tr><td></td><td>What is the average pack weight/size?</td></tr>";
                                echo "<tr><td></td><td><input type=number min=0 name=ps id=ps value=$str2 placeholder='enter a pack size'></td></tr>";

                                echo "<input type=hidden name=tw id=tw value='$str3'><br><br>";
                                
                           
                        }
                        if($qt=='sec')
                        {
                            /*
                            for($i=0;$i<12;$i++)
                            {
                                for($j=0;$j< 8;$j++)
                                {
                                    echo $sec[$i][$j];echo ' , ';
                                }
                                echo '<br>';
                            }
                            */
                            $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                            $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id AND q_id=$qset AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                           $str=$rss2->first()->$column;
                                } 
                               /*
                                $sd=''; $ss=$str; $p='';$e='';
                                                if($ss=='1')
                                                {$sd=A1; $p='';$e='';}
                                                else if($ss=='2')
                                                    $sd=A2;
                                                else if($ss=='3')
                                                    $sd=B1;
                                                else if($ss=='4')
                                                    $sd=B2;
                                                else if($ss=='5')
                                                    $sd=C;
                                                else if($ss=='6')
                                                    $sd=D;
                                                else if($ss=='7')
                                                    $sd=E1;
                                                else if($ss=='8')
                                                    $sd=E2;
                                                else
                                                    $sd=9;
                                                */
                            echo '<table><tr><td></td><td><font  color=blue>Please select the occupation of the person who makes the highest contribution to your household expenditure?</font></td></tr>';
                            echo "<br><td></td><td><select name=sec_occup><option value=0>--Select--</option><option value=1>Unskilled Workers</option><option value=2>Skilled Workers</option><option value=3>Petty traders</option><option value=4>Shop owners</option><option value=5>Businessman/Industrialists with no Employees</option><option value=6>Businessman/Industrialists with 1-9 no of Employees</option><option value=7>Businessman/Industrialists with 10+ Employees</option><option value=8>Self employed professionals</option><option value=9>Clerical/Salesman</option><option value=10>Supervisory level</option><option value=11>Officers/Executives – Junior</option><option value=12>Officers/Executives-Middle/Senior</option></select></td></tr>";
                            echo '<tr><td></td><td><font color=blue>Please select the education of the person who makes the highest contribution to your household expenditure? </font></td></tr>';
                            echo "<tr><td></td><td><select name=sec_educ><option value=0>--Select--</option><option value=1>Illitrate</option><option value=2>Literate no formal education</option><option value=3>School upto 4 yrs</option><option value=4>School 5-9 yrs</option><option value=5>HSC/SSC</option><option value=6>Some college but not Grad</option><option value=7>Grad/Post Grad Gen</option><option value=8>Grad/Post Grad Prof</option></select></td></tr></table>";
                            //echo $sec[6][7];
                            
                        }
                        else if($qt=='textarea')
                        {
                            //$ctr++;
                            //$rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            //if($rss)
                            //to find table and its column search
                                $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                            $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                            $str=$rss2->first()->$column;
                                        else $str="type your response here";
                                }                                    
                                echo "<tr height=80><td></td><td><textarea id=q$currq name=text$currq cols=150 rows=5 >$str</textarea> </td> </tr>";
                                
                                                    
                        }else if($qt=='text')
                        {
                                $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rss)
                                $tt=$rss->first()->text_term;
                                $rt=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;                            
                                //to find table and its column search
                                $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                        $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                          $str=$rss2->first()->$column;
                                        else $str="type your response here";
                                }
                            echo "<tr height=80><td></td><td><input type=text id=q$currq name=text$currq size=80   value=$str ></td></tr>";                     
                        }
                            else if($qt=='dropdown')
                        {    
                                $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rss)
                                $tt=$rss->first()->term;
                                $rt=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;                            
                                //to find table and its column search
                                $column='';$table='';$str='';
                                $rd=DB::getInstance()->query("SELECT distinct `term` FROM `question_option_detail` WHERE `q_id`=$currq ");
                                if($rd)
                                {
                                        $column=$rd->first()->term;                                        
                                        $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column') ";
                                        $tbf1=DB::getInstance()->query($tbf);
                                        if($tbf1)
                                        $table=$tbf1->first()->TABLE_NAME;
                                        $sql="SELECT $column FROM $table WHERE `resp_id`=$resp_id  AND $column !=''";
                                        $rss2=DB::getInstance()->query($sql);
                                        if($rss2->count()>0) 
                                         { $str=$rss2->first()->$column;
                                            echo "<tr height=40><td></td><td>&nbsp;&nbsp;<select  name=text$currq style='font-size:1.2em;'><option>$str</option> <option >0</option><option >1</option><option>2</option><option >3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option >11</option><option >12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option >19</option><option >20</option><option >>=21</option> </select></td></tr>"; 
                                         }
                                         else
                                         {
 echo "<tr height=40><td></td><td>&nbsp;&nbsp;&nbsp;<select  name=text$currq style='font-size:1.2em;'> <option >0</option><option >1</option><option>2</option><option >3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option >11</option><option >12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option >19</option><option >20</option><option >>=21</option> </select></td></tr>";
                                         }
                                }
                                          
                                                
                        }
                                  else if($qt=='textrating')
                        {
                            $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term FROM `question_option_detail` WHERE `q_id`=$currq");
                            if($rd)
                            { $text_t=$rd->first()->text_term;
                                $rating_t=$rd->first()->rating_term;
                            }
                            //to display rating heading and its values
                            $rss=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rss)
                            { 
                                $tt=$rss->first()->text_term;
                                $rt=$rss->first()->rating_term;
                                $th=$rss->first()->txt_heading;
                                $rh=$rss->first()->rating1_heading;
                                $tbc=$rss->first()->textbox_count;
                            }
                            $col=count($rss->results()); 
                            echo "<table  cellpadding=0 cellspacing=0> <tr style=background-color:lightgray> <td width=65%>$th</td><td colspan=$col>$rh</td> </tr><tr><td width=65%></td>";
                            foreach($rss->results() as $rr)
                            {
                                echo "<td><center><font face=tahoma color=blue size=2>$rr->rating1_title</font></center></td>";
                            }
                            echo "</tr> ";      
                            //$rd=DB::getInstance()->query("SELECT distinct text_term, rating_term FROM `question_option_detail` WHERE `q_id`=$currq ");
                            //if($rd)//print_r($rd);
                            $tb='';$arr_temp=array();$arr_temp2=array();
                            //$v=$op->value;
                            //echo 'V:'.$v;
                            $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$text_t','$rating_t')");
                            if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $sql="SELECT $text_t , $rating_t FROM $tb WHERE `resp_id`=$resp_id  AND $text_t !=''  AND $rating_t !=''";
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
                                {   $strt='';
                                    //echo "<tr><td><input type=text placeholder='type your top expectation here' name=t$ic size=60></td>";
                                    if(count($arr_temp)>0){$strt=$arr_temp[$ic];}
                                    echo "<tr><td><textarea placeholder='type your top expectation here' name=t$ic style='border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'>$strt</textarea></td>";
                                    $rss1=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                                    if($rss1)
                                    foreach($rss1->results() as $rr)
                                    { //echo $rr->rating1_valuel;
                                        $str='';
                                        if(count($arr_temp2)>0)
                                        if($rr->rating1_value==$arr_temp2[$ic])
                                             { 
                                                $str="checked='checked'";
                                            }
                                            //echo $str
                                        echo "<td><center><input type=radio $str name=rank$ic value=$rr->rating1_value ><br>$rr->rating1_value</center></td>";
                                    }
                                    echo "</tr>";
                                }                    
                                echo "</table>";                   
                        }else if($qt=="title2rating")
                        {           
                            $ctr=0;$ic=0;$acnt=0;
                            //echo '<br>cqq:'.$currq;
                            //to find table and its column search
                            $column1='';$column2='';$column3='';$table='';$arr_temp=array();$arr_temp1=array();$arr_temp2=array();
                            $rd=DB::getInstance()->query("SELECT distinct text_term, rating_term, rating2_term FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rd)
                            {
                                $column1=$rd->first()->text_term;
                                $column2=$rd->first()->rating_term;
                                $column3=$rd->first()->rating2_term;
                                $tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column1','$column2','$column3') ";
                                $tbf1=DB::getInstance()->query($tbf);
                                if($tbf1)
                                {  
                                    $table=$tbf1->first()->TABLE_NAME;}
                                }
                                        $sql="SELECT $column1,$column2,$column3 FROM $table WHERE resp_id=$resp_id AND ($column2 !='' OR $column3 !='')";
                                        $rs=DB::getInstance()->query($sql);
                                        if($rs->count()>0)
                                        foreach($rs->results() as $r)    
                                        {   //echo $r->$t; 
                                            $rv=$r->$column1; 
                                            $rv1=$r->$column2;    
                                            $rv2=$r->$column3; 
                                            array_push($arr_temp, $rv);
                                            array_push($arr_temp1, $rv1);
                                            array_push($arr_temp2, $rv2);
                                        }
                                //print_r($arr_temp);
                            $count_rd=DB::getInstance()->query("SELECT distinct rating1_value, rating1_title FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($count_rd)
                                $count_rating=count($count_rd->results());
                            
                            //get top rank company other tan clent
                            $rating1_heading='Best Rating';$cc='';$rank1c='';
                            $r1=DB::getInstance()->query("SELECT `project_id`, `name`, `company_name`, `brand`, `background`, `tot_visit`, `research_type` FROM `project` WHERE `project_id`=3");
                            if($r1->count()>0)
                            {
                                $cc=$r1->first()->company_name;
                                $rdd=DB::getInstance()->query("SELECT c_rank1 FROM `demosurvey` WHERE `resp_id`=$resp_id AND c_rank1 !=''");
                                if($rdd->count()>0)
                                {    
                                    $rank1c=$rdd->first()->c_rank1;
                                }
                                    if($cc!=$rank1c)
                                    {    $rating1_heading=$rdd->first()->c_rank1;
                                        $rating1_heading.=' Rating';
                                    }else
                                    {
                                        $rdd=DB::getInstance()->query("SELECT c_rank2 FROM `demosurvey` WHERE `resp_id`=$resp_id AND c_rank2 !=''");
                                        if($rdd->count()>0)
                                        {    
                                            $rating1_heading=$rdd->first()->c_rank2;
                                            $rating1_heading.=' Rating';
                                        }
                                    }
                            }
                            //display text heading by options       
                            $rg=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq group by `txt_heading`");
                            if($rg)
                            foreach($rg->results() as $rrr)
                            {       $ctr++;
                                    $count_rd2=DB::getInstance()->query("SELECT distinct rating1_value, rating1_title FROM `question_option_detail` WHERE `q_id`=$currq ");
                                    $tth=$rrr->txt_heading; 
                                    echo "<table cellpadding=0 cellspacing=0> <tr style=background-color:lightgray> <td width=60%>$rrr->txt_heading</td> <td colspan=$count_rating> $rrr->rating1_heading </td><td>~</td> <td colspan=$count_rating>$rating1_heading</td> </tr><tr><td width=60%></td>";
                                    foreach($count_rd2->results() as $rr)
                                    {
                                           echo "<td><center><font face=tahoma color=blue size=2>$rr->rating1_title </font></center></td>";
                                    }
                                    echo "</td><td>";
                                    foreach($count_rd2->results() as $rr1)
                                    {
                                           echo "<td><center><font face=tahoma color=blue size=2>$rr1->rating1_title</font></center></td>";
                                    }
                                    echo "</tr> ";                  
                                    $rg111=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq AND `txt_heading`='$tth'");
                                    if($rg111)
                                        foreach($rg111->results() as $rr22)
                                        {   $ic++;$ch='n';
                                            //if($arr_temp[$acnt]==$rr22->opt_text_value)
                                            //{ $ch='y';}
                                            echo "<tr><td><textarea name=$rr22->op_id readonly style='border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;'>$rr22->opt_text_value</textarea> </td>";
                                            $rss2=DB::getInstance()->query("SELECT distinct rating1_value, rating1_title FROM `question_option_detail` WHERE `q_id`=$currq ");
                                            if($rss2)
                                            foreach($rss2->results() as $rr1)
                                            {
                                                $str1='';
                                                if(count($arr_temp1)>0)
                                                if($arr_temp1[$acnt]==$rr1->rating1_value ){$str1="checked='checked'";}
                                                echo "<td><center><input type=radio name=rank_1_$ctr$ic $str1 value=$rr1->rating1_value><br> $rr1->rating1_value </center></td>";    
                                            }
                                            //echo "<td><select name=rank2$ic><option  value=0>--Select Rating--</option>";
                                            echo "</td><td>";
                                            foreach($rss2->results() as $r1)
                                            {
                                                $str1='';//echo $arr_temp[$acnt];
                                                if(count($arr_temp2)>0)
                                                if($arr_temp2[$acnt]==$r1->rating1_value ){$str1="checked='checked'";}
                                                echo "<td><center><input type=radio name=rank_2_$ctr$ic $str1 value=$r1->rating1_value><br> $r1->rating1_value </center></td>"; 
                                                //echo "<option  value=$rr2->rating1_value>$rr2->rating1_value - $rr2->rating1_title</option>";
                                            }
                                                $acnt++;
                                                //echo "</select></td>";
                                        }
                                    echo "</tr></table><br>";
                            }
                        }
                        else if($qt=='radio')
                        { 
                            $isval=0;$arr_dis=array();

                            $dis=DB::getInstance()->query("SELECT fst_prod_expo, scd_prod_expo, all_prod_exposed
FROM pilot
WHERE q_id =$qset
AND resp_id=$resp_id and (fst_prod_expo !=  ''
OR  scd_prod_expo !=  ''
OR all_prod_exposed !=  '')");
                            if($dis->count()>0)
                            foreach($dis->results() as $d){$a=$d->fst_prod_expo;$b=$d->scd_prod_expo;$c=$d->all_prod_exposed; if($a!='')array_push($arr_dis,$a);if($b!='')array_push($arr_dis,$b);if($c!='')array_push($arr_dis,$c);}

                            
                            $rs3=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rs3->count()>0)
                            foreach($rs3->results() as $op)
                            {   
                                $eng_text=$op->opt_text_value; $opid=$op->op_id; $t=$op->term;$tb='';$arr_temp=array();$str='';$v=$op->value;
                                //echo 'V: '.$v;
                                $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$op->term')");
                                if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $sqtb="SELECT $t FROM $tb WHERE `resp_id`=$resp_id  AND $t IS NOT NULL";
                                  
                                $rss=DB::getInstance()->query($sqtb);$arr_temp=array();
                                if($rss->count()>0)
                                foreach($rss->results() as $r)    
                                {   //echo $r->$t; 
                                   $tv=$r->$t;  if($tv!='')  array_push($arr_temp, $tv);}
                                    if($qc=='disable')
                                    {   //echo 'cnt:'.count($arr_temp); echo '<br>'.$v; print_r($arr_temp);
                                        if(!empty($arr_temp)) $isval=1; else $isval=0;
                                        if(in_array($v,$arr_temp))
                                        { 
                                          $str="checked='checked'";
                                        }
                                       else if(in_array($v,$arr_dis))$str=" disabled";
                                    }
                                    else
                                    {
                                        if(in_array($v,$arr_temp))
                                        { 
                                          $str="checked='checked'";
                                        }
                                    }
                                      

                                if($lang==''||$lang=='none')
                                {
                                echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name=q$currq $str value='$op->value'></td><td> $op->opt_text_value</td></tr>";
                                }
                                else if($lang=='hindi')
                                {
                                     $rs33=DB::getInstance()->query("SELECT * FROM `hindi_question_option_detail` WHERE `op_id`=$opid ");
                                     if($rs33->count()>0)                            
                                     {   
                                          $h_text=$rs33->first()->opt_text_value;
                                          echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name=q$currq $str value='$v'></td><td>$eng_text  [ $h_text ]</td></tr>";
                                     }
                                      else  
                                      {
                                         echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name=q$currq $str value='$op->value'></td><td> $op->opt_text_value</td></tr>";
                                      }
                                 }
                                
                            }
                        }
                        else if($qt=='checkbox')
                        {   $j=0;
                            $rs3=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rs3)
                            foreach($rs3->results() as $op)
                            {   $j++;
                                $eng_text=$op->opt_text_value; $opid=$op->op_id; $t=$op->term;$tb='';$arr_temp=array();$str='';$v=$op->value;
                                
                                $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$op->term')");
                                if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $rss=DB::getInstance()->query("SELECT $t FROM $tb WHERE `resp_id`=$resp_id  AND $t IS NOT NULL");
                                if($rss->count()>0)
                                foreach($rss->results() as $r)    
                                {   
                                    $tv=$r->$t;    array_push($arr_temp, $tv);}
        
                                    if(in_array($v,$arr_temp))
                                    { 
                                        $str="checked='checked'";
                                    }
                                 if($lang==''||$lang=='none')
                                {
                                echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name='$op->term$op->value' $str value='$op->value'></td><td> $op->opt_text_value </td></tr>";
                                }
                                else if($lang=='hindi')
                                {
                                     $rs33=DB::getInstance()->query("SELECT * FROM `hindi_question_option_detail` WHERE `op_id`=$opid ");
                                     if($rs33->count()>0)                            
                                     {   
                                          $h_text=$rs33->first()->opt_text_value;
                                          echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name='$op->term$op->value' $str value='$v'></td><td>$eng_text  [ $h_text ]</td></tr>";
                                     }
                                     else  
                                {
                                echo "<tr height=40><td></td><td width=2%><input type='$qt' class='big' id=q$currq name='$op->term$op->value' $str value='$op->value'></td><td> $op->opt_text_value </td></tr>";
                                }
                                 }
                                 
                            }
                       }
                   echo "</table><br>";     }   //end of question type
                    } // end foreach of ques
            	}
                      echo '<br><br><br><br>';           
                                 
  echo "<div id=footer>";
			//echo "<center><a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=3&rsp=$resp_id'><input type='button' name='reset_survey' value='Reset Survey' style=background-color:#004c00;color:white;height:35px;></a>";

 echo "<a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=2&rsp=$resp_id'><input type='button' name='prev' value='Previous' style=background-color:#004c00;color:white;height:35px;></a>";

echo "<a href='https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/hot_survey2.php?qset=$qset&next=1&rsp=$resp_id#'> <input type='submit' name='save' value='Save & Next' onclick='return Validate();' style='background-color:#004c00;color:white;height:35px;position:absolute; left:50%;'></a> </center> ";
                                
                         echo "<br><br><br>";
   echo "</div>";
	}//else end
        
        }
        
echo "<input type='hidden' id='temp'>";
echo "</form>";

}
}
}
?>
<div id="d1"></div>
</body>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script>
            var arr1 = [];
            var temp = '';
            $(".xa").click(function () {
                 if(this.checked)
                 {     //alert(this.type);
                     if(this.type=='checkbox')
                     arr1.push($(this).val());
                     else temp=$(this).val();
                 }
                 else 
                 {if(this.type=='checkbox')arr1.splice($.inArray($(this).val(), arr1),1); else $(this).val();}
            if(this.type=='checkbox')
            $("#temp").val(arr1.join(","));
            //alert(temp);
            else if(this.type=='radio'){$("#temp").val(temp); }
            displib();
            });
            //$("#temp").change(function () { alert("Hi value change"); });
            $("#temp").change(function() { 
                alert('Demo: '+$(this).val());  
            }); 
    </script>

    

    <script type="text/javascript">
        $(function(){
           $("#temp").on('change', function(){

                        alert('Ajax Error !');

           }); 
        });
    </script>
    <style>
    table {
        border-collapse: collapse;
    }

    
    </style>

    <!-- Script by hscripts.com -->
    <script type="text/javascript">
    window.history.forward(1);
    function noBack(){
    window.history.forward();
    }
    </script>
    <!-- Script by hscripts.com -->

    <script>
        var a=0; var b=1; var c=0;
      $(document).ready(function() {
          
           $('#rank1').click(function() {
               if($(this).val()=='others') $('#other1').show();
               else $('#other1').hide();
           });
           $('#rank2').click(function() {
               if($(this).val()=='others') $('#other2').show();
               else $('#other2').hide();
           });
           $('#rank3').click(function() {
               if($(this).val()=='others') $('#other3').show();
               else $('#other3').hide();
           });
           $('#tp').change(function() {
               a=$(this).val();b=$("#ps").val();
               c=a*b;
               $("#tw").val(c);
               //alert("Hi"+c);    
           });
           $('#ps').change(function() {
               b=$(this).val();a=$("#tp").val();
               c=a*b;
               $("#tw").val(c);
               //alert("Hi"+c);.big{ width: 20em; height: 20em; }
           });
    });
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

<script type="text/javascript">

function Validate() {


var jArray= <?php echo json_encode($qlist ); ?>;
var error=0;
    for(var j=0;j<jArray.length;j++)
    {  
        var ctr=0;
        var elm=jArray[j];
        var qq='q'+elm; var nm='text'+elm;
        var radios = document.getElementsByName(qq); 
       
        var et=document.getElementById(qq).type;
        alert(et);
         alert(document.getElementById(qq).checked);          

    if(et=='radio' )
    {   
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
       
       elm+='e';
       error++;
       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]';
       }
     }

if(et=='checkbox')
    {   
        //val=document.getElementById(qq).checked;
        
        for (var i = 0; i < radios.length; i++) 
        {   alert(radios[i]);
           if (radios[i].checked) 
           {    
                ctr++;  
                elm+='e';       
                document.getElementById(elm).innerHTML = '';         
           }
       }
         if(document.getElementById(qq).checked)
             ctr=1;

       if(ctr==0)
       {
       alert('Hi');
       elm+='e';
       error++;
       document.getElementById(elm).innerHTML = ' [ Error! Please select options below to proceed!! ]';
       }
     }
        if (et == 'text' || et=='textarea') 
         {    
              if(document.getElementById(qq).value=='')  
              {
              elm+='e';
              error++;
              document.getElementById(elm).innerHTML = ' [ Error! Please specify below to proceed!! ]';
                   
              } 
              else
              {
                elm+='e';       
                document.getElementById(elm).innerHTML = '';
              } 
         }
 
 
    }
    if(error==0)
      { return true;}
    if(error>0)
      { return false;}
    
}

</script>


<script>


$( ".opener" ).click(function() {  
    var page = "https://www.digiadmin.quantumcs.com/vcims/QuestAdmin/audio_recording.html";

var $dialog = $('<div></div>')
               .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
               .dialog({
                   autoOpen: false,
                   modal: true,
                   height: '320',
                   width: '420',
                   resizable: true,
                   title: "Voice Recording"
               });
    $dialog.dialog('open');
  
});
</script>