<?php
  include_once('../init.php');
  include_once('../functions.php');

  $qid=$_GET['qid'];
  $lang=$_GET['lang'];

   if($lang=='english')
  {
     $dd=DB::getInstance()->query("select q_title from question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }
  if($lang=='hindi')
  {
     $dd=DB::getInstance()->query("select q_title from hindi_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }

  if($lang=='bengali')
  {
     $dd=DB::getInstance()->query("select q_title from bengali_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }

  if($lang=='telgu')
  {
     $dd=DB::getInstance()->query("select q_title from telgu_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }
  if($lang=='tammil')
  {
     $dd=DB::getInstance()->query("select q_title from tammil_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }
  if($lang=='malyalam')
  {
     $dd=DB::getInstance()->query("select q_title from malyalam_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }
  if($lang=='kannar')
  {
     $dd=DB::getInstance()->query("select q_title from kannar_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }
  if($lang=='odia')
  {
     $dd=DB::getInstance()->query("select q_title from odia_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';

  }
  if($lang=='gujrati')
  {
     $dd=DB::getInstance()->query("select q_title from gujrati_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }
  if($lang=='marathi')
  {
     $dd=DB::getInstance()->query("select q_title from marathi_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';

  }
  if($lang=='asami')
  {
     $dd=DB::getInstance()->query("select q_title from asami_question_detail WHERE q_id=$qid");
     if($dd->count()>0)
     {
        echo $qt=$dd->first()->q_title;
     }
     else echo 'not available';
  }


?>
