<?php
session_start();
include_once('../init.php');
include_once('../functions.php');

$qs = $_GET['qset'];

echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Current Question</td><td>Option Value</td><td>Compare With</td><td>Routine Flow</td><td>Next Question </td><td>Section ID</td> </tr>";
    
$qtd="SELECT  `q_id`, `next_qid`, `op_value`, `qsec`, `routine`, `compare_sign` FROM `question_routine_detail` WHERE `qset_id`=$qs";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{
    foreach($dd->results() as $d)
    {
        echo "<tr><td>$d->q_id</td><td>$d->op_value</td><td>$d->compare_sign</td><td>$d->routine</td><td>$d->next_qid </td><td>$d->qsec </td> </tr>";
    }
}
    
?>