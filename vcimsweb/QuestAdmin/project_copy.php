<?php

include_once('../init.php');
include_once('../functions.php');

?>
<center>
<h2>Copy Project</h2>
<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>Copy from Project </td><td> <select name="fpn" id="fpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td>Copy To Project </td><td> <select name="tpn" id="tpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                
                <tr><td colspan="2"><center><input type="submit" name="cpp_submit" onclick="return confirm('Are you sure?');" value="Copy Project"></center></td></tr>                
                </form>
        </table>
</center>


<?php

if(isset($_POST['cpp_submit']))
{
      $fm_pid=$_POST['fpn'];
      $to_pid=$_POST['tpn'];

      if($fm_pid==$to_pid)
      {
         echo '<font color=red>Error! Both project cannot be same for copy.</font>';  
      }
      else
      {
         echo "<font color=green>Project copy in progress. Pls wait...</font>"; 

         //find all questionsetIDs of a project and do work one by one qsetID
         $fpqset=DB::getInstance()->query("SELECT `qset_id` FROM `questionset` WHERE `project_id`=$fm_pid");
         if($fpqset->count()>0)
         foreach($fpqset->results() as $qs1)
         {
            echo '<br>qset_id='.$qset=$qs1->qset_id;
            
            //find all questions of a questionset
            echo "<br>Question List<br>";
            $pq1=DB::getInstance()->query("SELECT * FROM `question_detail` WHERE `qset_id`=$qset ");
            if($pq1->count()>0)
            {
               foreach($pq1->results() as $q1)
               {
                   $qid=$q1->q_id; $pno=$q1->qno; $qimg=$q1->image; $qaud=$q1->audio; $qvid=$q1->video; $qtitle=$q1->q_title;
                   $qtype=$q1->q_type;

                   echo "<br> $qid / $qno -- $q1->q_title -- $qtype ";
                   echo "<br> INSERT INTO `question_detail`( `qset_id`, `q_title`, `q_type`, `qno`, `image`, `video`, `audio`) VALUES ($to_pid, '$qtitle','$qtype','$qno','$qimg','$qvid','$qaud')";
                   
                   //finds the options details of a question
                   $pq2=DB::getInstance()->query("SELECT * FROM `question_option_detail` WHERE `q_id`=$qid AND (`qset_id`=0 OR `qset_id`=$qset )");
                   if($pq2->count()>0)
                   {
                      if($qtype=='radio' || $qtype=='checkbox')
                      {  
                         foreach($pq2->results() as $qop)
                         {
                             $op_text=$qop->opt_text_value;
                             $op_value=$qop->value;
                             $term=$qop->term;
                             
                                   echo "<br>&nbsp;&nbsp;&nbsp; $op_value -- $op_text -- $term ";                 
                         }
                      }
                      //else echo $qtype;
                   } //end if of question_options
                   
                   //find all the routine of a question
                   echo "<br><br>&nbsp;&nbsp;&nbsp; qid  -- qopv -- qsec  -- nextq ";
                   $pr1=DB::getInstance()->query("SELECT * FROM `question_routine_detail` WHERE qset_id=$qset and q_id=$qid ");
                   if($pr1->count()>0)
                   {
                       
                   
                       foreach($pr1->results() as $qr)
                       {
                            	$nq=$qr->next_qid;
                         	$qopv=$qr->op_value;
                       		$qsec1=$qr->qsec;
                       
                            	echo "<br>&nbsp;&nbsp;&nbsp; $qid  -- $qopv -- $qsec1  -- $nq ";
                       }
                   }
                    
               } //end foreach of question_details 
            }//end if of question_details
         }

      
      }
}

?>