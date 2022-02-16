<?php

include_once  'DBConnector.php';
include_once 'Question.php';
include_once 'Option.php';
include_once 'Routine.php';


  function _getRoutine($q_id, $qset_id,$values) 
  {
        $next_qid = array();
         
        if ($values != null)
            $sql = "select distinct  next_qid from question_routine_detail where q_id=$q_id AND  op_value in($values)";
        else
            $sql = "select distinct  next_qid from question_routine_detail where q_id=$q_id AND  qset_id  =$qset_id " ;

        $conn = DBConnector::getDBInstance();
        $rs = mysqli_query($conn, $sql);
     
        if ($rs->num_rows > 0) 
        {
                     
                    while ($row = $rs->fetch_assoc()) {
                     $robj=new Routine();
                     
                        $q = (int)$row["next_qid"];
                        $robj->set_nextqid($q);
                        array_push($next_qid, $robj);
                    }      
        }

        
        return $next_qid;
        
   }
  function _getQuestion($q_id) 
  {
        $question = array();
        $qobj = new Question(); 

        if ($q_id != null)
            $sql = "select * from question_detail where q_id=$q_id ";
        else
            $sql = "select * from question_detail where q_id=$q_id AND  qset_id  =$qset_id " ;

        $conn = DBConnector::getDBInstance();
        $rs = mysqli_query($conn, $sql);
     
        if ($rs->num_rows > 0) 
        {
                     
                    while ($row = $rs->fetch_assoc()) {
                       $q = array("q_id" => (int)$row["q_id"], "q_title" => $row["q_title"], "q_type" => $row["q_type"],"qno" => $row["qno"],
                            "image" => $row["image"], "video" => $row["video"],
                            "audio" => $row["audio"]);
                            
                            $qobj->set_qid($row["q_id"]);
                            $qobj->set_qtitle($row["q_title"]);
                            $qobj->set_qtype($row["q_type"]);
                            $qobj->set_qno($row["qno"]);
                            $qobj->set_image($row["image"]);
                            $qobj->set_audio($row["audio"]);
                            $qobj->set_video($row["video"]);
                                                
                            
                        array_push($question, $q);
                    }      
        }
 
         
        //return $question;
        return $qobj;
   }
  
   function _getOption($q_id) 
   {
        $opd = array();
        //$oobj=new Option();
        
        if ($q_id != null)
            $sql = "select * from question_option_detail where q_id=$q_id ";
        

        $conn = DBConnector::getDBInstance();
        $rs = mysqli_query($conn, $sql);
     
        if ($rs->num_rows > 0) 
        {
                     
                    while ($row = $rs->fetch_assoc()) {
                        $q = array("op_id" => (int)$row["op_id"], "q_id" => (int)$row["q_id"], "opt_text_value" => $row["opt_text_value"],
                            "term" => $row["term"], "value" => (int)$row["value"], "column_value" => (int)$row["column_value"],"scale_start_value" => (int)$row["scale_start_value"],"scale_end_value" => (int)$row["scale_end_value"],"scale_start_label" => $row["scale_start_label"],"scale_end_label" => $row["scale_end_label"]);
                            
                            $obj=new Option();
                            
                            $obj->set_qid($row["q_id"]);
                            $obj->set_optextvalue($row["opt_text_value"]);
                            $obj->set_term($row["term"]);
                            $obj->set_value($row["value"]);
                            $obj->set_columnvalue($row["column_value"]);
                            $obj->set_scalestartvalue($row["scale_start_value"]);
                            $obj->set_scaleendvalue($row["scale_end_value"]);
                            $obj->set_scalestartlabel($row["scale_start_label"]);
                            $obj->set_scaleendlabel($row["scale_end_label"]);
                             
                            array_push($opd, $obj); 
                             
                        //array_push($opd, $q);
                        
                    }      
        }

         
        return $opd;
        //return $oobj;
    }
  
?>