<?php

include_once('../init.php');
include_once('../functions.php');

?>
<center>
<h2>View Question's Options Detail</h2>
<table cellpadding="2" cellspacing="1" border="1" style="font-size:12px;">
		<form action="" method="post">
                <tr><td>Project </td><td> <select name="fpn" id="fpn"><option value="select">--Select--</option><?php $pj=get_projects_details();foreach($pj as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select></td></tr>
                <tr><td colspan="2"><center><input type="submit" name="view" value="View"></center></td></tr>                
                </form>
        </table>
</center>


<?php

if(isset($_POST['view']))
{
      $fm_pid=$_POST['fpn'];
       
      if($fm_pid=='')
      {
         echo '<font color=red>Error! Please select a project </font>';  
      }
      else
      {
        

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
                   $qtype=$q1->q_type; $qno=$q1->qno;
                   echo "<br><br> $qid / $qno -- $q1->q_title -- $qtype ";
                  
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
                   
                   
                    
               } //end foreach of question_details 
            }//end if of question_details
         }

      
      }
}

?>