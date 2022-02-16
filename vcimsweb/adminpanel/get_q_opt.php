<?php
  include_once('../init.php');
  include_once('../functions.php');

  $lang = '0';
  $qid=$_GET['qid'];
  if(isset($_GET['lang']))
     $lang = $_GET['lang'];

if($qid == '' || $lang ==''){
	echo "Please select question and language.";
}else

  $dd=DB::getInstance()->query("select q_type from question_detail WHERE q_id=$qid");
  if($dd->count()>0)
  {
     $qt=$dd->first()->q_type;

  if($qt=='radio' || $qt=='checkbox')
  {
     if($lang == '0')
     {
      	$dd2=DB::getInstance()->query("SELECT op_id, `q_id`, `opt_text_value`, `term`, `value` FROM `question_option_detail` WHERE `q_id`=$qid");
      	echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
      	if($dd2->count()>0)
      	foreach($dd2->results() as $d)
       	{ 
        	$qtv=$d->opt_text_value;
        	$v=$d->value;
        	echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id placeholder='Enter your translated option value' size=60 ></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";    
       	}
      }

      if($lang=='english')
      {
        $dd2=DB::getInstance()->query("SELECT op_id, `q_id`, `opt_text_value`, `term`, `value` FROM `question_option_detail` WHERE `q_id`=$qid");
      	echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
      	if($dd2->count()>0)
      	foreach($dd2->results() as $d)
       	{ 
        	$qtv=$d->opt_text_value;
        	$v=$d->value;
        	echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$qtv' size=60></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
       }
      }

      if($lang=='1')
      {
//echo "SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
//FROM `hindi_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid";

          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value` 
FROM `hindi_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
          echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
          if($dd2->count()>0)
       		foreach($dd2->results() as $d)
       		{ 
        		$qtv=$d->engval;
        		$hqtv=$d->hval;
        		$v=$d->value;
        		echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv' size=60></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>"; 
       		}
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='2')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `kannar_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value;");
          echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
          if($dd2->count()>0)
                foreach($dd2->results() as $d)
                {
                        $qtv=$d->engval;
                        $hqtv=$d->hval;
                        $v=$d->value;
                        echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
                }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='3')
      {
          $dd3 = DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `malyalam_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
          echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
          if($dd3->count() > 0){
                foreach($dd3->results() as $d)
                {
                        $qtv=$d->engval;
                        $hqtv=$d->hval;
                        $v=$d->value;
                        echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
                }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php
	  }
      }
      if($lang=='4')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `tammil_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
          echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
          if($dd2->count()>0)
                foreach($dd2->results() as $d)
                {
                        $qtv=$d->engval;
                        $hqtv=$d->hval;
                        $v=$d->value;
                        echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
                }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='5')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `telgu_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
          echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
          if($dd2->count()>0)
                foreach($dd2->results() as $d)
                {
                        $qtv=$d->engval;
                        $hqtv=$d->hval;
                        $v=$d->value;
                        echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
                }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='6')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `bengali_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
          echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
          if($dd2->count()>0)
                foreach($dd2->results() as $d)
                {
                        $qtv=$d->engval;
                        $hqtv=$d->hval;
                        $v=$d->value;
                        echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
                }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='7')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM odia_question_option_detail as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
         echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
         if($dd2->count()>0)
           foreach($dd2->results() as $d)
           { 
              $qtv=$d->engval;
              $hqtv=$d->hval;
              $v=$d->value;
              echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
           }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='8')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `gujrati_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
         echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
         if($dd2->count()>0)
           foreach($dd2->results() as $d)
           { 
              $qtv=$d->engval;
              $hqtv=$d->hval;
              $v=$d->value;
              echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
           }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
      if($lang=='9')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `marathi_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
         echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
         if($dd2->count()>0)
           foreach($dd2->results() as $d)
           { 
              $qtv=$d->engval;
              $hqtv=$d->hval;
              $v=$d->value;
              echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
           }
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php
      }
      if($lang=='10')
      {
          $dd2=DB::getInstance()->query("SELECT a1.id as op_id, a1.`q_id` as qid, a1.`opt_text_value` as hval,a2.`opt_text_value` as engval, a2.`term`, a2.`value`
FROM `asami_question_option_detail` as a1 JOIN  question_option_detail as a2 ON a1.q_id=a2.q_id AND a1.code=a2.value WHERE a1.`q_id`=$qid order by a2.value");
         echo "<table><tr bgcolor=lightgrey><td>OPID</td><td>Title</td><td>Value </td><td> Title </td></tr>";
         if($dd2->count()>0)
           foreach($dd2->results() as $d)
           { 
              $qtv=$d->engval;
              $hqtv=$d->hval;
              $v=$d->value;
              echo "<tr><td>$d->op_id<input type=hidden name=op$d->op_id value=$d->op_id></td><td>$qtv</td><td>$v</td><td><input type=text name=t$d->op_id value='$hqtv'></td><td><input type=hidden name=v$d->op_id value='$v'></td></tr>";
           }   
?>
		<tr><td></td><td><input type="submit" name="dqop_submit" value="Delete All Translation Options" onclick="return confirm('Are you sure to delete translated option?');">
		</td></tr>
<?php

      }
//echo "<tr><td></td><td><input type='submit' name='dqop_submit' value='Delete All Translation Options' onclick='return confirm('Are you sure to delete translated options?');'></td></tr>";
  }
  }

?>

