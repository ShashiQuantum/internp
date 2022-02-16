<?php
//session_start();
include_once('../init.php');
//include_once('../functions.php');

$qset = $_GET['qset'];
 
echo "<option value='0'> --Select-- </option>";

$qtd="Select * from question_detail where qset_id =$qset";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{
    foreach($dd->results() as $d)
    {   $qid=$d->q_id; $qn=$d->qno;
        echo "<option value=$qid>$qid -- $qn</option>";
    }
}else echo "<option value='0'> --Not Available-- </option>";
    
?>