<?php 
include_once('../init.php');


$qid=$_GET['qid'];

  $dd=DB::getInstance()->query("select q_type from question_detail WHERE q_id=$qid");
  if($dd->count()>0)
  {
     $qt=$dd->first()->q_type;

  if($qt=='radio' || $qt=='checkbox' || $qt=='text' || $qt=='textarea')
  {
      echo "<input type=text name=qterm placeholder='Enter the term'>";
  }
  }
?>