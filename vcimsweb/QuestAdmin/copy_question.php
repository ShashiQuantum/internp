<?php

include_once('../init.php');
include_once('../functions.php');

?>
<center>
<h2>Copy single Question with Options</h2>
<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>From Project </td><td> <select name="fpn" id="fpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
               <tr><td>To Project </td><td> <select name="tpn" id="tpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
               <tr><td>Q.Id to copy: </td><td> <input type=text name="ct" id="ct"></td></tr>
               <tr><td>Term for new Q.Id: </td><td> <input type=text name="nqt" id="nqt"></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="copy" value="Copy" onclick="return confirm('Are you sure?');"></center></td></tr>                
                </form>
        </table>
</center>


<?php

if(isset($_POST['copy']))
{
      $fm_pid=$_POST['fpn'];
      $to_pid=$_POST['tpn'];
      $ct=$_POST['ct'];
      $nqt=$_POST['nqt'];

      if($fm_pid=='')
      {
         echo '<font color=red>Error! Please select a project </font>';  
      }
      else 
      {
        
         $ptq="SELECT `data_table` FROM `project` WHERE `project_id` = $to_pid";
         $pqtr=DB::getInstance()->query($ptq);
            if($pqtr->count()>0)
               $ptable=$pqtr->first()->data_table;

         //find all questionsetIDs of a project and do work one by one qsetID
         $fpqset=DB::getInstance()->query("SELECT `qset_id` FROM `questionset` WHERE `project_id`=$to_pid");
         if($fpqset->count()>0)
         foreach($fpqset->results() as $qs1)
         {
             $qset=$qs1->qset_id;
             
              $nqno=$nqt.'_'.$qset;
            
            //find all questions of a questionset
            
            $pq1=DB::getInstance()->query("SELECT * FROM `question_detail` WHERE `q_id`=$ct and qset_id=$fm_pid");
            if($pq1->count()>0)
            {
               foreach($pq1->results() as $q1)
               {
                   $qid=$q1->q_id;
                   $qtype=$q1->q_type; $qno=$q1->qno; $qimg=$q1->image; $qaud=$q1->audio; $qvid=$q1->video; $qtitle=$q1->q_title;

                   //echo "<br><br> $qid / $qno -- $q1->q_title -- $qtype ";
                   $qd="INSERT INTO `question_detail`( `qset_id`, `q_title`, `q_type`, `qno`, `image`, `video`, `audio`) VALUES ($to_pid, '$qtitle','$qtype','$nqt','$qimg','$qvid','$qaud')";
                   $lq=DB::getInstance()->query($qd);
                   $nqid=$lq->last();

                   //finds the options details of a question
                   $pq2=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$qid AND (`qset_id`=0 OR `qset_id`=$qset )");
                   if($pq2->count()>0)
                   {
                      if($qtype=='radio' || $qtype=='checkbox')
                      {  $ttrm='';
                         foreach($pq2->results() as $qop)
                         {
                             $op_text=$qop->opt_text_value;
                             $op_value=$qop->value;
                             $term=$qop->term;$ttrm=$qno.'_'.$to_pid;
                             
                                    
                                     $wqr="INSERT INTO `question_option_detail`( `q_id`, `qset_id`, `opt_text_value`, `term`, `value`) VALUES ($nqid,$to_pid,'$op_text','$nqno',$op_value);";
                                     DB::getInstance()->query($wqr);
                                                 
                         }
                            $atq="ALTER TABLE $ptable ADD $nqno varchar(2) not null";
                            $ctb1=DB::getInstance()->query($atq);

                      } //end of checkbox type

                      if($qtype=='rating')
                      {  $ttrm='';
                         foreach($pq2->results() as $qop)
                         {
                             $sv=$qop->scale_start_value;$ev=$qop->scale_end_value;
                             $sl=$qop->scale_start_label;$el=$qop->scale_end_label;
                             $ttrm=$qno.'_'.$to_pid;
                             
                                   
                                   $qrq="INSERT INTO `question_option_detail`( `q_id`, `qset_id`,`term`,`scale_start_value`, `scale_end_value`, `scale_start_label`, `scale_end_label`) VALUES ($nqid,$to_pid,'$nqno',$sv,$ev,'$sl','$el');";
                                    DB::getInstance()->query($qrq);                 
                         }
                         $atq="ALTER TABLE $ptable ADD $nqno varchar(2) not null";
                          $ctb1=DB::getInstance()->query($atq);
                      } //end of rating type
                      
                      if($qtype=='text' || $qtype=='textarea' || $qtype=='dropdown')
                      {  
                         foreach($pq2->results() as $qop)
                         {
                             $ttrm=$qno.'_'.$to_pid;
                             $atq="ALTER TABLE $ptable ADD $nqno varchar(80) not null";
                              DB::getInstance()->query($atq);
                             $qrr="INSERT INTO `question_option_detail`( `q_id`, `qset_id`,`term`) VALUES ($nqid,$to_pid,'$nqno');";
                              DB::getInstance()->query($qrr);                
                         }
                      } //end of text/dropdown type
 
                   } //end if of question_options
 
                    
               } //end foreach of question_details 
            }//end if of question_details
            else echo "This qid : $ct does not exist";
            
             echo "<font color=red>$ct question and its options copied successfully as qid: $nqid</font>";
         }      
      }
      
}

?>

<script type="text/javascript">
  document.getElementById('fpn').value = "<?php echo $_POST['fpn'];?>";
  document.getElementById('tpn').value = "<?php echo $_POST['tpn'];?>";
  document.getElementById('ct').value = "<?php echo $_POST['ct'];?>";
  document.getElementById('nqt').value = "<?php echo $_POST['nqt'];?>";
   </script> 
