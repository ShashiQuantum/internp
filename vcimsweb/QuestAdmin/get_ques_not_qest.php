<?php
include_once('../init.php');
include_once('../functions.php');

 $_GET['comp'];
$qset = $_GET['qset'];
$tt=$_GET['qc'];
$_SESSION['qset']=$qset;
//$tt=1;
if($tt==0)
$qry="SELECT * FROM `question_detail` where qset_id=$qset";
if($tt==1)
$qry="SELECT * FROM `question_detail`";



$q=DB::getInstance()->query($qry);
if($q->count()>0)
{     
   if($tt==0)
    echo "<option value='0'>First Question</option><option value='-1'>Last Question</option>";
 
  foreach($q->results() as $d)
  { 
    $qid=$d->q_id;
    $qq= $d->q_title;
    $l=substr($qq,0,80);
    echo "<option value=' $qid '>$qid - $l </option>" ;        
  }
} else echo '<option value=0>Error!!Question not available for selected project. Pls create questions for a project </option>';



?>
