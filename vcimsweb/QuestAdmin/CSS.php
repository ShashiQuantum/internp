<?php
session_start();
include_once('../init.php');
include_once('../functions.php');      

$resp_id=0;$qset=0;$currq=0;
$resp_id=$_GET['rsp'];
$qset=$_GET['qset'];
//session_destroy();      
//print_r($_GET);
?>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
<?php
//$resp_id=$_SESSION['respid'];

//https://digiadmin.quantumcs.com/QuestAdmin/DemoCSS.php?qset=1&next=-1&rsp=202


if(isset($_POST['reset_survey']))
{
        
        echo $qqq="DELETE FROM `demosurvey` WHERE `resp_id`=$resp_id ";
        DB::getInstance()->query($qqq);
        //session_destroy();
	echo '<br>Your Survey has reset, Pls fill the survey from begning';
        //sleep(50);
        $newURL="https://digiadmin.quantumcs.com/QuestAdmin/DemoCSS.php?qset=$qset&next=-1&rsp=$resp_id";
        header('Location: '.$newURL);        
}
if(isset($_POST['submit']))
{
        print_r($_POST);
        $resp_name=$_POST['rn'];
        $org_name=$_POST['ro'];
        $ca=$_POST['ca'];
        $is=$_POST['is'];
        $mob=$_POST['mob'];
        $email=$_POST['email'];
        
        echo $qqq="UPDATE `demo_respondent` SET `status`=1, email='$email', mobile='$mob', `full_name`= '$resp_name',`organization_name`='$org_name', `duration_with_company`='$ca', `prefrence`='$is' WHERE `respondent_id`=$resp_id ";
        DB::getInstance()->query($qqq);
        //session_destroy();
	echo '<br>Thank You! Submitted';
        //sleep(50);
        //$newURL='https://digiadmin.quantumcs.com/Demo/FirstPage.php';
       // header('Location: '.$newURL);        
}
else
{
    //echo $resp_id;
    $qset=$_GET['qset'];
    echo "<form action='' method='post'>";
	//if next is clicked
	
		
                //echo '<br>c:'.$_SESSION['nextq'];
	if($_GET['next']==-1)
	{
                $qset=$_GET['qset'];
                //$currq=$_SESSION['firstq'];
                session_destroy(); 
                session_start(); 
                //$_SESSION['psec']='0';
                
                $rspst=DB::getInstance()->query("SELECT  `status`, `status2`, `status3` FROM `demo_respondent` WHERE `respondent_id`=$resp_id");
                if($rspst->count()>0)
                {
                    $rp1=$rspst->first()->status;
                    //echo '<br>Your Status:'.$rp1=$rspst->first()->status;
                    if($rp1==1)
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
                        if($rs22)
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
                            echo "<p style=float:right><img src='/image/Digiadmin_logo.jpg' height=50 width=200> </p><br><br><br><br><br><br>";
                                echo '<br><center><p style=background-color:white><font color=blue size=4>'.$rs2->first()->q_title.'</font></p></center><br>';
                                $qt=$rs2->first()->q_type;
                                $ifvideo=$rs2->first()->video;
                                $ifaudio=$rs2->first()->audio;
                                $ifimage=$rs2->first()->image;

                                if($qt=='instruction')
                                {
                                    if($ifaudio!='')
                                    {
                                        echo "<center><audio controls autoplay>";
                                            echo "<source src=$ifaudio type='video/mp3'>";
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
                                        echo "<center><figure><img src=$ifimage height=150 width=200>";
                                        echo "<figcaption>Fig.1 - A view of the pulpit rock in Norway.</figcaption></figure></center>";
                                    }
                                }

                        } 
                        }
                        $_SESSION['psec']='0';
                        //if($_SESSION['firstq']==$currq)
                                echo "<center><a href='https://digiadmin.quantumcs.com/QuestAdmin/DemoCSS.php?qset=$qset&next=1&rsp=$resp_id'> <input type='button' name='next' value='Continue Survey' style=background-color:lightgreen></a></center>"; 
                }}
                else
                {
                    echo '<br>Respondent Id is not exist';
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
                                print_r($_POST);
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
                                               /* if($k=='rank1' || $k=='other1' )
                                                {
                                                    if($v!='')if($v!='others')
                                                }
                                                else if($k=='rank2'  || $k=='other2')
                                                {
                                                    if($v!='')if($v!='others')
                                                }
                                                else if($k=='rank3'  || $k=='other3')
                                                {
                                                    if($v!='')if($v!='others')
                                                }
                                                else if($k != 'save' || $v !='' || $k !='rank1' || $k != 'rank2' || $k != 'rank3' || $k != 'other1' || $k!='other2'|| $k!='other3')
                                                {   
                                                */ 
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
                                
                                $sql1="SELECT distinct q_id FROM `question_routine_detail` WHERE qsec in ($qsec)";
                                $df=DB::getInstance()->query($sql1);
                                if($df->count() > 0)
                                {
                                    foreach ($df->results() as  $val) 
                                    {
                                        $qctr++;
                                        $qid=$val->q_id;
                                        
                                        $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                        $qtd2=DB::getInstance()->query($qtd);
                                        echo $qqtype=$qtd2->first()->q_type;
                                        
                                        if($qqtype=='instruction' || $qqtype=='top3rankcompany')
                                            continue;
                                        else if($qqtype=='text' || $qqtype=='tetarea' || $qqtype=='radio'|| $qqtype =='rating')
                                        {   //echo $qtd1->first()->q_type;
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
                                            $vdata=$arr_post[$qctr];
                                            echo '<br>'.$stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            //print_r($r->results());
                                            if($r->count()>0)
                                            {
                                                //update code here
                                                echo '<br>'.$stat="UPDATE $arr_table[0] SET $arr_column[0]='$vdata' WHERE resp_id=$resp_id AND $arr_column[0]!=''";
                                                DB::getInstance()->query($stat);
                                            }
                                            else
                                            {
                                                //insert code here
                                                echo '<br>'.$stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$vdata')";
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
                                             echo $stat="DELETE FROM $arr_table[0]  WHERE resp_id=$resp_id AND $arr_column[0]!=''";
                                                $rs=DB::getInstance()->query($stat);
                                                             
                                                for($i=$qctr+1;$i<$qrv;$i++)
                                                {   $qctr++;
                                                    $vdata=$arr_post[$qctr];
                                                echo '<br>'.$stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$vdata')";
                                                DB::getInstance()->query($stat);
                                                
                                                }
                                            }
                                            else
                                            {
                                                //echo 'Hi'.$qrv;
                                                //insert code here
                                                for($i=$qctr+1;$i<$qrv;$i++)
                                                {
                                                    $qctr++;
                                                    $vdata=$arr_post[$qctr];
                                                echo '<br>'.$stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$vdata')";
                                                DB::getInstance()->query($stat);
                                                
                                                }
                                            }
                                        }
                                        else if($qqtype=='sec')
                                        {   
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
                                                echo $ss=$sec[$sec_occup-1][$sec_educ-1];
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
                                            echo '<br>'.$stat2="SELECT $arr_column[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column[0] !=''";
                                            $r=DB::getInstance()->query($stat2);
                                            if($r->count()>0)
                                            {
                                                //update code here
                                                echo '<br>'.$stat="UPDATE $arr_table[0] SET $arr_column[0]='$sd' WHERE resp_id=$resp_id AND $arr_column[0]!=''";
                                                DB::getInstance()->query($stat);
                                            }
                                            else
                                            {
                                                //insert code here
                                                echo '<br>'.$stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column[0]) VALUES($resp_id,$qset,'$sd')";
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
                                                          echo $stat="DELETE FROM $arr_table[0]  WHERE resp_id=$resp_id AND $arr_column1[0]!='' AND $arr_column2[0]!=''";
                                                           $rs=DB::getInstance()->query($stat);
                                                              
                                                              for($i=$qctr;$i<$qrv;$i+=2)
                                                              {   
                                                                      $ii=$i+1;  
                                                                      echo $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]')";
                                                                      $ii=0;
                                                                      $rs=DB::getInstance()->query($stat);
                                                              }
                                                       }
                                                      else
                                                      {    
                                                           for($i=$qctr;$i<$qrv;$i+=2)
                                                           {   
                                                                      $ii=$i+1;  
                                                                      echo $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]')";
                                                                      $ii=0;
                                                                      $rs=DB::getInstance()->query($stat);
                                                            }
                                                      }                                                      
                                        }//end if of qt textrating
                                        if($qqtype == 'title2rating')
                                        {
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
                                                        echo '<br>cnt:'.$qrv=$rd->first()->cnt;
                                                        array_push($arr_column1,$column1);
                                                        array_push($arr_column2,$column2);
                                                        array_push($arr_column3,$column3);

                                                       echo '<br>'.$tbf="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$column1','$column2','$column3') ";
                                                        $tbf1=DB::getInstance()->query($tbf);
                                                        if($tbf1)
                                                        {  $table=$tbf1->first()->TABLE_NAME;
                                                            array_push($arr_table,$table);}
                                                    }
                                                 // print_r($arr_post);
                                                    $c=count($arr_post);
                                                    if($qrv<$c)
                                                        $qrv=$c;
                                                    echo '<br>qrv:'.$qrv;
                                                    $stat2="SELECT $arr_column1[0],$arr_column2[0] FROM $arr_table[0] WHERE resp_id=$resp_id AND $arr_column1[0]!='' AND $arr_column2[0]!=''";
                                                    $rst=DB::getInstance()->query($stat2);
                                                    if($rst->count()>0)
                                                    {
                                                        $stat="DELETE FROM $arr_table[0]  WHERE resp_id=$resp_id AND $arr_column1[0]!='' AND $arr_column2[0]!='' AND $arr_column3[0]!=''";
                                                        //$rs=DB::getInstance()->query($stat);

                                                        $ii=0;$iii=0;$temp='';$temp2='';$arr=array();
                                                        for($i=$qctr;$i<$qrv;$i+=3)
                                                        {  
                                                            $ii=$i+1;$iii=$i+2;
                                                                echo $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0],$arr_column3[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]','$arr_post[$iii]')";
                                                                //$rs=DB::getInstance()->query($stat);
                                                            
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $ii=0;$temp='';$temp2='';$arr=array();
                                                        for($i=$qctr;$i<$qrv;$i+=3)
                                                        {  
                                                            $ii=$i+1;$iii=$i+2;
                                                                echo $stat="INSERT INTO $arr_table[0] (resp_id,q_id,$arr_column1[0],$arr_column2[0],$arr_column3[0]) VALUES($resp_id,$qset,'$arr_post[$i]','$arr_post[$ii]','$arr_post[$iii]')";
                                                                //$rs=DB::getInstance()->query($stat);
                                                        }
                                                    }
                                        } //end of q of title2rating
                                    } //foreach end for qt
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
                        //$qrd=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id=$p->q_id and qset_id=$qset");
                         //   if($qrd)
                         //   {
                                $qid=$p->q_id;
                                $opv=$p->op_value;
                                $nqid=$p->next_qid;
                                $rt=$p->routine;
                                //find the selected option by user from database
                                
                                        $qtd="SELECT  `q_type` FROM `question_detail` WHERE `q_id`=$qid";
                                        $qtd1=DB::getInstance()->query($qtd);
                                        if($qtd1->first()->q_type=='radio' || $qtd1->first()->q_type=='text' || $qtd1->first()->q_type=='textbox'|| $qtd1->first()->q_type=='textarea' || $qtd1->first()->q_type=='checkbox')
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
                                        $stat="SELECT $column FROM $table WHERE resp_id=$resp_id AND $column !=''";
                                        $r=DB::getInstance()->query($stat);
                                        if($r->count()>0)
                                        {
                                            //echo '<br>sopv::'.$opv;
                                            $getv=$r->first()->$column;   
                                            if($nqid==-1)
                                                continue;
                                            $rrss="select * FROM `question_routine_detail` WHERE q_id = $nqid and qset_id=$qset";
                                            $rss=DB::getInstance()->query($rrss);
                                            if($rss)
                                            $qsec=$rss->first()->qsec;
                                            //$opv=$rss->first()->op_value;
                                            //$qset=$rss->first()->qset_id;
                                            //echo '<br>opv='.$opv .' && getv='.$getv; 
                                            
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
                                        //else echo 'you must select the previous question option';
                                        }
                            //} //end if
                    } //foreach end
                } //if end          
                //print_r($arr_nsec);
                
                //check the stop condition of previous question and force to submit the form
                $sql1="select * FROM `question_routine_detail` WHERE q_id = $prev_c and qset_id=$qset";
                $rr=DB::getInstance()->query($sql1);
                if($rr->count()>0)
                    $prev_routine=$rr->first()->routine;
                    $prev_stop=$rr->first()->op_value;      
                    $qsec=$rr->first()->qsec;
                    $prev_opv=$_SESSION['cso'];
                    
                if($prev_routine=='terminate' || $currq==-1)
                {       //display tab               
                        $sh1=DB::getInstance()->query("SELECT `sec_title`,qsec_id FROM `question_sec` WHERE `qset_id`=$qset order by qsec_id asc");
                	if($sh1)
                        {
                            echo "<center><table borser=1 style='border: 1px solid black'><tr>";
                            foreach ($sh1->results() as $h)
                            {
                                if($h->qsec_id==$qsec)
                                echo "<td><a href=DemoCSS.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:#004c00;color:white;height:50px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";    
                                    else
                                echo "<td><a href=DemoCSS.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:green;color:white;height:50px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";
                            }
                            echo '</tr></table></center><br>';
                        }//end display tab
                        
                        echo "<center><table borser=1 style='border: 1px solid black'><tbody><b>Demographics</b></tbody><tr>";
                        echo "<tr><td>Name </td><td><input type=text name=rn placeholder='type your name'></td></tr>";
                        echo "<tr><td>Mobile </td><td><input type=text name=mob maxsize=10 placeholder='phone/mobile no'></td></tr>";
                        echo "<tr><td>Email </td><td><input type=email name=email placeholder='type your email'></td></tr>";
                        echo "<tr><td>Organization</td><td> <input type=text name=ro placeholder='type your company name'></td></tr>";
                        echo "<tr><td>How long you have been associated with company </td><td><select name=ca> <option value='No response'>No Response</option><option value='Below 1 year'>Below 1 year</option><option value='1 to 3 years'>1 to 3 year</option><option value='3 to 5 years'>3 to 5 year</option><option value='5 to 8 years'>5 to 8 year</option><option value='8 to 10 years'>8 to 10 year</option><option value='10 to 15 years'>10 to 15 year</option><option value='Above 15years'>Above 15 year</option></select></td></tr>";
                        echo "<tr><td>This survey can be kept anonymous if you prefer. Would you like to share your responses with Company X? </td><td><select name=is> <option value='Disclose my identity'>Disclose my identity</option><option value='Do not disclose my identity'>Do not disclose my identity</option></select></td></tr>";
                        
                        echo '</table></center><br>';
                        $_SESSION['prevq']=$prev_c;
                        echo "<br><center><font color='red'>Thank You. <br> Based on your selected response of just previous question you are not required to attened any more question.<br>You can review all previous questions before final submission of survey otherwise click on submit</font></center>";
                        echo "<br><br><center><input type='submit' name='submit' value='Submit Survey' style=background-color:#004c00;color:white;height:50px;></center>";
                }
               else 
                {
                    $ctr=0;
                    //echo 'hi'.$qset;
                    $qset=$_GET['qset'];
                  if($ctr==0)  
                  {  echo "<p style=float:right><img src='/image/Digiadmin_logo.jpg' height=50 width=200> </p><br><br><br><br><br>";
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
            //echo '<br>sec:'.$qsec;
                        //display tab
                        $sh=DB::getInstance()->query("SELECT `sec_title`,qsec_id FROM `question_sec` WHERE `qset_id`=$qset order by qsec_id asc");
                	if($sh)
                        {
                            echo "<center><table borser=1 style='border: 1px solid black'><tr>";
                            foreach ($sh->results() as $h)
                            {
                                if($h->qsec_id==$qsec)
                                    echo "<td><a href=DemoCSS.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:#00e500;color:white;height:50px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";    
                                else
                                    echo "<td><a href=DemoCSS.php?qset=$qset&next=1&rsp=$resp_id&sec=".$h->qsec_id."><input type=button style=background-color:green;color:white;height:50px; name=".$h->sec_title." value='".$h->sec_title."'> </a></td>";
                            }
                            echo '</tr></table></center><br>';
                        }//end display tab

                        //DISPLAY THE QUESTION
                        $rss=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id = $currq");
                        if($rss)
                        //$qsec=$rss->first()->qsec;$qset=$rss->first()->qset_id;
                        //print_r($rss);
                        
                        $arr_sec=array();
                        
                        $_SESSION['qsec']=$qsec;
                        if(isset($_GET['sec'])) {$qsec=$_GET['sec'];}
                        $_SESSION['psec']=$qsec;
                        
                        //query for getting distinct question from all questionSet
                        //$qq="SELECT distinct `q_id`,`qset_id`, `next_qid`, `op_value`, `qsec`, `routine`, `compare_sign` FROM `question_routine_detail` WHERE `qset_id` = 2 and `qsec` in (11) order by `q_id`"; 

                        $sql="select * FROM `question_routine_detail` WHERE qset_id = $qset and qsec in ($qsec) order by q_id";
                        $rss3=DB::getInstance()->query($sql);
                       
                        if($rss3)
                        {    $_SESSION['currq']=$rss3->first()->q_id;
                             //$_SESSION['nextq']=$rss3->first()->next_qid;
                             $ovp=$rs1->first()->op_value;
                             $_SESSION['currq']=$currq;
                             $_SESSION['nextq']=$rss3->first()->next_qid;
                             $_SESSION['prevq']=$rss3->first()->prev_qid;
                        } 
                        //print_r($rss);
                        $qq="SELECT distinct `q_id`,`qset_id` FROM `question_routine_detail` WHERE `qset_id` = $qset and `qsec` in ($qsec) order by `q_id`"; 
                        $rss333=DB::getInstance()->query($qq);
                        foreach($rss333->results() as $cq )
                        {
                            echo $cq->q_id;
                            //to find the routine details of current question
                            $qrd=DB::getInstance()->query("select * FROM `question_routine_detail` WHERE q_id=$cq->q_id");
                            if($qrd)
                            {
                                $opv=$qrd->first()->op_value;
                                $nqid=$qrd->first()->next_qid;
                                $rt=$qrd->first()->routine;
                            }
                            //$_SESSION['currq']=$cq->q_id;++
                            $rs2=DB::getInstance()->query("select * FROM `question_detail` WHERE q_id =$cq->q_id");
                            if($rs2)
                            {       
                                $qt=$rs2->first()->q_type;
                               $currq=$cq->q_id;
                                $_SESSION['currq']=$currq;
                                if(strlen(($_SESSION['qt']))<1)
                                    $_SESSION['qt'].=$qt;
                                else
                                    $_SESSION['qt'].=','.$qt;
                                
                                //start to find the question type and display its options
                                if($qt=='instruction')
                                {           echo '<p><b><font color=black size=3> '.$rs2->first()->q_title.'</font></b></p>';
                                            $ifvideo=$rs2->first()->video;
                                            $ifaudio=$rs2->first()->audio;
                                            $ifimage=$rs2->first()->image;
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
                                            echo "<center><figure><img src=$ifimage height=150 width=200>";
                                             echo "<figcaption>Fig.1 - A view of the pulpit rock in Norway.</figcaption></figure></center>";
                                        }
                                }
                                else
                                    echo '<p><font color=blue size=3> '.$rs2->first()->q_title.'</font></p>';   

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
                                {
                                    echo "<table style=border:none><tr><td> </td>";
                                    for($s=$sv+1;$s<=$ev;$s++)
                                    {
                                        echo "<td> $s </td>";
                                    }
                                    echo "<td> </td><td>NA</td></tr><tr><td> $sl </td>";
                                    for($s=$sv+1;$s<=$ev;$s++)
                                    {   
                                        if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';
                                        echo "<td><input type=radio name=r$currq $str value=$s> </td>";
                                    }
                                    echo "<td> $el </td><td><input type=radio name=r$currq value=$s></td></tr></table>";                                
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
                                        if(in_array($s,$arr_temp))
                                        { 
                                            $str="checked='checked'";
                                        }else $str='';
                                        echo "<td><input type=radio name=r$currq $str value=$s> </td>";
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
                            echo '<table><tr><td><font color=blue>Could you please tell me the occupation of the person who makes the highest contribution to your household expenditure?</font></td><td>';
                            echo "<select name=sec_occup><option value=1>Unskilled Workers</option><option value=2>Skilled Workers</option><option value=3>Petty traders</option><option value=4>Shop owners</option><option value=5>Businessman/Industrialists with no Employees</option><option value=6>Businessman/Industrialists with 1-9 no of Employees</option><option value=7>Businessman/Industrialists with 10+ Employees</option><option value=8>Self employed professionals</option><option value=9>Clerical/Salesman</option><option value=10>Supervisory level</option><option value=11>Officers/Executives – Junior</option><option value=12>Officers/Executives-Middle/Senior</option></select></td></tr>";
                            echo '<tr><td><font color=blue>Could you please tell me about the education of the person who makes the highest contribution to your household expenditure? </font></td><td>';
                            echo "<select name=sec_educ><option value=1>Illitrate</option><option value=2>Literate no formal education</option><option value=3>School upto 4 yrs</option><option value=4>School 5-9 yrs</option><option value=5>HSC/SSC</option><option value=6>Some college but not Grad</option><option value=7>Grad/Post Grad Gen</option><option value=8>Grad/Post Grad Prof</option></select></td></tr></table>";
                            //echo $sec[6][7];
                            
                        }
                        else if($qt=='textarea')
                        {
                            $ctr++;
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
                                }                                    
                                echo "<hr><center><textarea name=text$currq cols=180 rows=5 placeholder='type your response here'>$str</textarea></center>";                     
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
                                }
                            echo "<hr><input type=text name=text$currq size=139 placeholder='type your response here' value=$str>";                     
                        }else if($qt=='textrating')
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
                            echo "<table border=1 cellpadding=0 cellspacing=0> <tr style=background-color:lightgray> <td width=65%>$th</td><td colspan=$col>$rh</td> </tr><tr><td width=65%></td>";
                            foreach($rss->results() as $rr)
                            {
                                echo "<td><center><font color=blue size=2>$rr->rating1_title</font></center></td>";
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
                                    //echo "<tr><td><input type=text placeholder='type your top expectation here' name=t$ic size=139></td>";
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
                            $rating1_heading='Best Rating';$cc='';
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
                                    echo "<table border=1 cellpadding=0 cellspacing=0> <tr style=background-color:lightgray> <td width=60%>$rrr->txt_heading</td> <td colspan=$count_rating> $rrr->rating1_heading </td><td>~</td> <td colspan=$count_rating>$rating1_heading</td> </tr><tr><td width=60%></td>";
                                    foreach($count_rd2->results() as $rr)
                                    {
                                           echo "<td><center><font color=blue size=2>$rr->rating1_title </font></center></td>";
                                    }
                                    echo "</td><td>";
                                    foreach($count_rd2->results() as $rr1)
                                    {
                                           echo "<td><center><font color=blue size=2>$rr1->rating1_title</font></center></td>";
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
                            //$rss=DB::getInstance()->query("SELECT * FROM `demosurvey` WHERE `resp_id`=$resp_id ");
                            //if($rss)
                            $rs3=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rs3)
                            foreach($rs3->results() as $op)
                            {   
                                $t=$op->term;$tb='';$arr_temp=array();$str='';$v=$op->value;
                                //echo 'V:'.$v;
                                $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$op->term')");
                                if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $rss=DB::getInstance()->query("SELECT $t FROM $tb WHERE `resp_id`=$resp_id  AND $t IS NOT NULL");
                                if($rss->count()>0)
                                foreach($rss->results() as $r)    
                                {   //echo $r->$t; 
                                    $tv=$r->$t;    array_push($arr_temp, $tv);}
                                    //print_r($arr_temp);
                                    //echo '<br>count:'.count($arr_temp);
                                    if(in_array($v,$arr_temp))
                                    { 
                                        $str="checked='checked'";
                                    }
                                
                                echo "<input type='$qt' class='xa' name='$op->term' $str value='$op->value'> $op->opt_text_value <br>";
                            }
                        }
                        else if($qt=='checkbox')
                        {   $j=0;
                            $rs3=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$currq ");
                            if($rs3)
                            foreach($rs3->results() as $op)
                            {   $j++;
                                $t=$op->term;$tb='';$arr_temp=array();$str='';$v=$op->value;
                                //echo 'V:'.$v;
                                $tbf1=DB::getInstance()->query("SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$op->term')");
                                if($tbf1)
                                $tb=$tbf1->first()->TABLE_NAME;
                                $rss=DB::getInstance()->query("SELECT $t FROM $tb WHERE `resp_id`=$resp_id  AND $t IS NOT NULL");
                                if($rss->count()>0)
                                foreach($rss->results() as $r)    
                                {   //echo $r->$t; 
                                    $tv=$r->$t;    array_push($arr_temp, $tv);}
                                    //print_r($arr_temp);
                                    //echo '<br>count:'.count($arr_temp);
                                    if(in_array($v,$arr_temp))
                                    { 
                                        $str="checked='checked'";
                                    }
                                
                                echo "<input type='$qt' class='xa' name='$op->term$op->value' $str value='$op->value'> $op->opt_text_value <br>";
                            }
                        }
                        }   //end of question type
                    } // end foreach of ques
            	}
                echo "<br><br>";
                 
 
			echo "<center><a href='https://digiadmin.quantumcs.com/QuestAdmin/DemoCSS.php?qset=$qset&next=-1&rsp=$resp_id'><input type='submit' name='reset_survey' value='Reset Survey'></a> <a href='https://digiadmin.quantumcs.com/QuestAdmin/DemoCSS.php?qset=$qset&next=1&rsp=$resp_id#'><input type='submit' name='save' value='Save & Next'></a> &nbsp &nbsp <a href='https://digiadmin.quantumcs.com/QuestAdmin/DemoCSS.php?qset=$qset&next=1&rsp=$resp_id'><input type='button' name='next' value='Next'></a></center>"; 
	}//else end
        
        }
//$str="";
//if (!empty($_POST[$xa])) $str="checked='checked'";
//echo  "Count <input type='checkbox' id='xa' value='countx' name='countx' $str>";
//echo "<input type='text' id='temp'>";
echo "<input type='hidden' id='temp'>";
echo "</form>";

}
}
}
?>
<div id="d1"></div>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   
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

    table, td, th {
        border: 1px solid black;
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
    });
    </script>
