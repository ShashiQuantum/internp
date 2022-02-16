<?php
//session_start();
include_once('../init.php');
//include_once('../functions.php');

$qset = $_GET['qset'];
 
echo "<option value='0'> --Select-- </option>";

$qtd="Select q_id,qno from question_detail where q_id in (SELECT distinct `qid` FROM `question_sequence` WHERE `qset_id`=$qset AND `chkflag`=1)";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{
    foreach($dd->results() as $d)
    {   $qid=$d->q_id; $qn=$d->qno;
        echo "<option value=$qid>$qid -- $qn</option>";
    }
}else echo "<option value='0'> --Not Available-- </option>";
    
?>