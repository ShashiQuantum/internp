<?php
//session_start();
include_once('../init.php');
//include_once('../functions.php');

$qset = $_GET['qset'];

echo "<option value='0'> --Select here-- </option>";

$qtd="Select q_id,qno,q_title,q_type from question_detail WHERE `qset_id`=$qset order by q_id";
$dd=DB::getInstance()->query($qtd);
if($dd->count()>0)
{
    foreach($dd->results() as $d)
    {   $qid=$d->q_id; $qn=$d->qno; $qt=$d->q_type;$qtitle=$d->q_title;
        echo "<option value=$qid>$qid -- $qn -- $qt --> $qtitle </option>";
    }
}else echo "<option value='0'> --Not Available-- </option>";

?>

