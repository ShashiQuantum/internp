<?php
//session_start();
include_once('../init.php');
//include_once('../functions.php');
 
 $qid = $_GET['qid'];

//echo "<table cellpadding=0 cellspacing=0 border=1 style=font-size:12px;><tr bgcolor=lightgray><td>Current Question</td><td>Option Value</td><td>Compare With</td><td>Routine Flow</td><td>Next Question </td><td>Section ID</td> </tr>";

//$dd=DB::getInstance()->query("");    

$qtd="SELECT  op_id, `q_id`,  `opt_text_value`, `opt_column_value`, `opt_image_value`, `opt_video_value`, `opt_audio_value`, `term`, `value`, `column_value`, `grid_value`, `txt_heading`, `rating1_heading`, `rating2_heading`, `rating1_value`, `rating2_value`, `rating1_title`, `rating2_title`, `textbox_count`, `text_term`, `rating_term`, `rating2_term`, `scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label` FROM `question_option_detail` WHERE `q_id`=$qid";

$dd=DB::getInstance()->query($qtd);
if($dd->count() > 0)
{   echo "<table border=2>";
    echo "<tr bgcolor=lightgray><td>SN</td><td>OPTION</td><td>CODE</td><td>CHECK</td><td>FLOW</td></tr>";
    $nctr=0;
    foreach($dd->results() as $d)
    {   $nctr++;
        $qid=$d->q_id;
        $opid=$d->op_id; 
        $text=$d->opt_text_value; 
        $v=$d->value;
        $ssv=$d->scale_start_value;
        $esv=$d->scale_end_value;
        
        echo "<tr><td>$nctr</td><td>$text</td><td><input type=text name=v$v value=$v readonly></td><td><input type=checkbox name=chk$v value=$v></td><td><select name=f$v ><option value=0>Continue </option><option value=1>Terminate</option><option value=2>Terminate Anyway</option></select></td></tr>";       
        
    }
   echo "</table>";
}else echo "--Options Not Available--";
    
?>