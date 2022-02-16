<?php
session_start();
include_once('../init.php');
include_once('../functions.php');

$qs = $_GET['qsec'];

//echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Current Question</td><td>Option Value</td><td>Compare With</td><td>Routine Flow</td><td>Next Question </td><td>Section ID</td> </tr>";
    
echo "<option value='0'> --Select-- </option>";

$qtd="SELECT distinct `q_id` FROM `question_routine_detail` WHERE `qsec`=$qs and q_id!=0 and q_id!=-1";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{
    foreach($dd->results() as $d)
    {
        echo "<option value=$d->q_id>$d->q_id</option>";
    }
}
    
?>