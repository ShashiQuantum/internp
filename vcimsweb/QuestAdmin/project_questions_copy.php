<?php

include_once('../init.php');
include_once('../functions.php');

?>
<center>
<h2>Copy All Question with Options</h2>

<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>From Project </td><td> <select name="fpn" id="fpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
               <tr><td>To Project </td><td> <select name="tpn" id="tpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
               <tr><td>Copy What </td><td> <select name="ct" id="ct"><option value=0>--Select--</option><option value=1>Questions Detail</option><option value=2>Sequence Details</option><option value=3>Routine Details</option></select></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="copy" value="Copy" onclick="return confirm('Are you sure?');"></center></td></tr>                
                </form>
        </table>
</center>


<?php

if(isset($_POST['copy']))
{
		//print_r($_POST);
      $fm_pid = $_POST['fpn'];
      $to_pid = $_POST['tpn'];
      $ct = $_POST['ct'];
      $qset2=0;
      $ptable='';
      if($fm_pid=='')
      {
         echo '<font color=red>Error! Please select a project </font>';  
      }
      else if($ct==1)
      {
         echo $ptq="SELECT `data_table` FROM `project` WHERE `project_id` = $to_pid ";
         $pqtr=DB::getInstance()->query($ptq);
            if($pqtr->count()>0)
           echo    $ptable=$pqtr->first()->data_table;

         $fpqset2=DB::getInstance()->query("SELECT `qset_id` FROM `questionset` WHERE `project_id`=$to_pid limit 1");
         if($fpqset2->count()>0)
         foreach($fpqset2->results() as $qs2)
         {
             $qset2=$qs2->qset_id;
	 }
         //find all questionsetIDs of a project and do work one by one qsetID
         $fpqset=DB::getInstance()->query("SELECT `qset_id` FROM `questionset` WHERE `project_id`=$fm_pid");
         if($fpqset->count()>0)
         foreach($fpqset->results() as $qs1)
         {
             $qset=$qs1->qset_id;
            //find all questions of a questionset
            $pq1=DB::getInstance()->query("SELECT * FROM `question_detail` WHERE `qset_id`=$qset ");
            if($pq1->count()>0)
            {
               foreach($pq1->results() as $q1)
               {
                   $qid=$q1->q_id;
                   $qtype=$q1->q_type; $qno=$q1->qno; $qimg=$q1->image; $qaud=$q1->audio; $qvid=$q1->video; $qtitle=$q1->q_title;

                   //echo "<br><br> $qid / $qno -- $q1->q_title -- $qtype ";
                   $qd="INSERT INTO `question_detail`( `qset_id`, `q_title`, `q_type`, `qno`, `image`, `video`, `audio`) VALUES ($qset2, '$qtitle','$qtype','$qno','$qimg','$qvid','$qaud')";
                   $lq=DB::getInstance()->query($qd);
                   $nqid=$lq->last();
                             $ttrm=$nqid.'_'.$qset2;
                             $ttrmt=$ttrm.'_t';

                   //finds the options details of a question
                   $pq2=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$qid");
                   if($pq2->count()>0)
                   {
                      if($qtype=='radio' || $qtype=='checkbox')
                      {  //$ttrm='';
                         foreach($pq2->results() as $qop)
                         {
                             $op_text=$qop->opt_text_value;
                             $op_value=$qop->value;
                             //$term=$qop->term;
			     //$ttrm=$nqid.'_'.$qset2;
			     //$ttrmt=$ttrm.'_t';
                                   //echo "<br>&nbsp;&nbsp;&nbsp; $op_value -- $op_text -- $term ";
                                    $wqr="INSERT INTO `question_option_detail`( `q_id`, `qset_id`, `opt_text_value`, `term`, `value`) VALUES ($nqid,$to_pid,'$op_text','$ttrm',$op_value);";
                                    DB::getInstance()->query($wqr);
                         }
                         echo  $atq="ALTER TABLE $ptable ADD $ttrm varchar(2), ADD $ttrmt varchar(20);";
                           $ctb1=DB::getInstance()->query($atq);

                      } //end of checkbox type

                      if($qtype=='rating')
                      {  //$ttrm='';
                         foreach($pq2->results() as $qop)
                         {
                             $sv=$qop->scale_start_value;$ev=$qop->scale_end_value;
                             $sl=$qop->scale_start_label;$el=$qop->scale_end_label;
                             //$ttrm=$qno.'_'.$to_pid;
                             
                                   //echo "<br>&nbsp;&nbsp;&nbsp; $term -- $sl -- $el -- $sv --$ev ";
                                   $qrq="INSERT INTO `question_option_detail`( `q_id`, `qset_id`,`term`,`scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label`) VALUES ($nqid,$to_pid,'$ttrm',$sv,$ev,'$sl','$el');";
                                   DB::getInstance()->query($qrq);                 
                         }
                        echo $atq="ALTER TABLE $ptable ADD $ttrm varchar(2) , ADD $ttrmt varchar(20);";
                         $ctb1=DB::getInstance()->query($atq);
                      } //end of rating type
                      
                      if($qtype=='text' || $qtype=='textarea' || $qtype=='dropdown')
                      {  
                         foreach($pq2->results() as $qop)
                         {
                             //$ttrm=$qno.'_'.$to_pid;
                            echo $atq="ALTER TABLE $ptable ADD $ttrm varchar(80), ADD $ttrmt varchar(20);";
                             DB::getInstance()->query($atq);
                             $qrr="INSERT INTO `question_option_detail`( `q_id`, `qset_id`,`term`) VALUES ($nqid,$to_pid,'$ttrm');";
                             DB::getInstance()->query($qrr);                
                         }
                      } //end of text/dropdown type
 
                   } //end if of question_options
 
                    
               } //end foreach of question_details 
            }//end if of question_details
             echo "<font color=red>All questions and its options copied successfully</font>";
         }

      
      }
      if($ct==2)
      {   
          
         
         $fpqset=DB::getInstance()->query("SELECT `qset_id` FROM `questionset` WHERE `project_id`=$fm_pid");
         if($fpqset->count()>0)
         foreach($fpqset->results() as $qs1)
         {
             $qset=$qs1->qset_id;
         
          $pq1=DB::getInstance()->query("SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset order by qid");
            if($pq1->count()>0)
            {
               foreach($pq1->results() as $q1)
               {
                   $qid=$q1->qid;
                   $sid=$q1->sid; $cf=$q1->chkflag; 

                   
                   echo "<br>".$qd="INSERT INTO `question_sequence`(`qset_id`, `qid`, `sid`, `chkflag`) VALUES ($to_pid, $qid, $sid, $chkflag)";
                    $lq=DB::getInstance()->query($qd);
               }
           }
          echo "Copy question sequence details";
         }
      }
      if($ct==3)
      {
           $fpqset=DB::getInstance()->query("SELECT `qset_id` FROM `questionset` WHERE `project_id`=$fm_pid");
         if($fpqset->count()>0)
         foreach($fpqset->results() as $qs1)
         {
             $qset=$qs1->qset_id;

          $pq1=DB::getInstance()->query("SELECT `id`, `qset_id`, `qid`, `pqid`, `opval`, `flow` FROM `question_routine_check` WHERE `qset_id`=$qset order by qid");
          if($pq1->count()>0)
          {
               foreach($pq1->results() as $q1)
               {
                   $qid=$q1->qid;
                   $pqid=$q1->pqid; $opval=$q1->opval; $flow=$q1->flow; 

                    
                   echo "<br>".$qd="INSERT INTO `question_routine_check`(`qset_id`, `qid`, `pqid`, `opval`, `flow`) VALUES ($to_pid, $qid, $pqid,$opval,$flow)";
                    $lq=DB::getInstance()->query($qd);
               }
          }
          echo "Copy routine details";
         }
      }

}

?>

<script type="text/javascript">
  document.getElementById('fpn').value = "<?php echo $_POST['fpn'];?>";
  document.getElementById('tpn').value = "<?php echo $_POST['tpn'];?>";
  document.getElementById('ct').value = "<?php echo $_POST['ct'];?>";
   </script> 
