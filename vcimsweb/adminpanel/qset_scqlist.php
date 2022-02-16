<?php
//session_start();
include_once('../init.php');
//include_once('../functions.php');

$qset = $_GET['qset'];
 
echo "<option value='0'> --Select-- </option>";

$qtd="Select q_id,q_type,qno from question_detail where q_id in (SELECT distinct `qid` FROM project_showcard WHERE `qset`=$qset)";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{
    foreach($dd->results() as $d)
    {   $qid=$d->q_id; $qn=$d->qno;$qt=$d->q_type;
        echo "<option value=$qid>$qid -- $qn -- $qt</option>";
    }
}else echo "<option value='0'> --Not Available-- </option>";
    
?>
