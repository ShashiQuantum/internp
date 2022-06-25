<?php
include_once('init.php');
//include_once('functions.php');


//to get qtype based on term
function get_qtype($trm)
{
    $q=DB::getInstance()->query("SELECT q_id,q_type,qno FROM question_detail where q_id=(SELECT distinct `q_id`  FROM  `question_option_detail` WHERE  `term` =  '$trm')");
    if($q)
        return $q->results();
    else
        return false;
}
//to get qtype based on term
function get_qop_count($qid)
{
    $q=DB::getInstance()->query("SELECT count(term) as cnt  FROM  `question_option_detail` WHERE  `q_id` =  $qid");
    if($q)
        return $q->first()->cnt;
    else
        return false;
}

//to get all project details from vcimstest
function get_projects_details_test()
{
    $q=DB::getInstance()->query("select * from vcimstest.project");
    if($q)
        return $q->results();
    else
        return false;
}

//to get all project details
function get_projects_details()
{
    $q=DB::getInstance()->query("select * from project WHERE project_type ='servegenix' ORDER BY project_id desc;");
    if($q)
        return $q->results();
    else
        return false;
}
function get_deploy_details()
{
    $q=DB::getInstance()->query("SELECT DISTINCT(appuser_project_map.project_id),project.name from appuser_project_map inner join project on project.project_id = appuser_project_map.project_id;");
    if($q)
        return $q->results();
    else
        return false;
}
function del_deploy_project($pid)
{
    $q=DB::getInstance()->query("DELETE from appuser_project_map where project_id = $pid;");
    if($q)
        return true;
    else
        return false;
}


function get_projects_details_serveygenics()
{
    $q=DB::getInstance()->query("select * from project WHERE project_type ='servegenix' ORDER BY project_id desc;");
    if($q)
        return $q->results();
    else
        return false;
}

//function get_project_endDate($projectId)
//{
 //   $q=DB::getInstance()->query("select survey_end_date,survey_start_date from project WHERE  project_id  ='$projectId';");
 //   if($q)
  //      return $q->results();
  //  else
   //     return false;
//}
function get_project_infoforDepy($projectId)
{
    $q=DB::getInstance()->query("select survey_types,survey_occurance,survey_frequency,survey_end_date,survey_start_date from project WHERE  project_id  ='$projectId';");
    if($q)
        return $q->results();
    else
        return false;
}





//to get all project list based on userid
function get_project_list($uid=null)
{   $p="";$ctr=0;

    //$qq=DB::getInstance()->query("SELECT `project_id` FROM `project_client_map` WHERE `client_id`=(SELECT distinct `cid` FROM `user_client_map` WHERE `uid`=$uid)");
    $qq=DB::getInstance()->query("SELECT `project_id` FROM `project_user_map` WHERE `uid`=$uid ");
    if($qq->count()>0)
    foreach($qq->results() as $r)
    {  $ctr++;
       if($ctr>1)
        { $p.=','; $p.=$r->project_id; }
       if($ctr==1) $p=$r->project_id;
    }  
    $q=DB::getInstance()->query("select * from project where project_id in ($p)");
    if($q->count()>0)
        return $q->results();
    else
        return false;
}
//to get specific project details based on project name
function get_project_id($pname)
{
    if($pname)
    {
    $q=DB::getInstance()->query("select project_id  from project where name='$pname'");
    if($q)
        return $q->first()->project_id;
    else 
        return false;
    }else echo 'Pls input the project name';
}
//to get specific project details based on project id
function get_project_name($pid)
{
    if($pid)
    {
    $q=DB::getInstance()->query("select name from project where project_id=$pid");
    if($q)
        return $q->first()->name;
    else
        return false;
    }else echo 'Pls input the project id';
}

//to get specific tablet interviwer details for table receiving
function get_tablet_receiver($i_id)
{    
    if($i_id)
    {
    $q=DB::getInstance()->query("select i_name from `interviewer_detail` where i_id=$i_id");
    if($q)
        return $q->first()->i_name;
    else
        return false;
    }else echo 'Pls input the  i_id';
}
//to get specific project name based on qsetid
function get_qset_project_name($qsetid)
{
    if($qsetid)
    {
    $q=DB::getInstance()->query("select name from project where project_id=(SELECT `project_id` FROM `questionset` WHERE `qset_id`=$qsetid)");
    if($q)
        return $q->first()->name;
    else
        return false;
    }
}
//to get all centres details 
function get_centres()
{
    
    $q=DB::getInstance()->query("select centre_id, cname from centre");
    if($q)
        return $q->results();
    else
        return false;
   
}
//to get all Key and Value of a specific term or all values if no parameter supplied
function get_dictionary($term=null,$pid=null)
{
    if($term)
    {
       
           $q=DB::getInstance()->query("SELECT title, `keyy`, `value` FROM `dictionary` WHERE `term`='$term'");
           if($q->count()>0)
           {
              if($term=='centr_id')
              {
                    $q1=DB::getInstance()->query("SELECT title, `keyy`, `value` FROM `dictionary` WHERE `term`='$term' AND value in (SELECT `centre_id` FROM `centre_project_details` WHERE `project_id`=$pid)");
                    if($q1->count()>0)
                    {
                        return $q1->results();
                    }
              }
              else {
              return $q->results();}
           }
           else
              return false;
       
    }
    else
    {
            $q=DB::getInstance()->query("SELECT * FROM `dictionary`");
        if($q)
            return $q->results();
        else
            return false;
    }    
}

function get_dictionary_titles()
{
    $q=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary`");
        if($q)
            return $q->results();
        else
            return false;
    
}
//get specific title

function get_dictionary_title_only($term=null)
{
    if($term)
    {
     
    $q=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` WHERE `term`='$term'");
        if($q)
            return $q->first()->title;
        else
            return false;
    }
}

function get_project_term($pid)
{
    if($pid)
    {
    $q=DB::getInstance()->query("SELECT distinct title,term FROM `dictionary` where term in (select term from project_term_map where project_id=$pid)");
        if($q)
            return $q->results();
        else
            return false;
    } else return false;
}
//to get project fp details for crosstab
function get_project_fp($pid)
{

    if($pid)
    {
	$temp_arr=array();

                        //for survey status value
                        
                                $arr1=array();
                                $arr1[0]=array('opt_text_value'=>'Incomplete','value'=>'0','term'=>'st');
                                $arr1[1]=array('opt_text_value'=>'Completed 4 App','value'=>'1','term'=>'st');
                                $arr1[2]=array('opt_text_value'=>'Completed 4 Web','value'=>'2','term'=>'st');
                                $fpiid=0;
                                $temp_arr[ 0 ] = array('fpid'=>$fpiid,'q_type'=>'radio','q_title'=>'Survey Complete Status','qno'=>'survey status','term'=>'st', 'qop'=>$arr1);
                        


    	$qrr=DB::getInstance()->query("SELECT a.pid,a.fpid, b.term,b.title FROM vcims.project_fp_map as a JOIN vcims.app_first_page as b ON a.fpid=b.id where 
a.pid=$pid AND a.fpid IN (SELECT id FROM vcims.app_first_page WHERE type IN ('radio','dropdown','checkbox')); ");
        if($qrr->count()>0){ 
		$i = 0;
		foreach($qrr->results() as $r){
			$fpid = $r->fpid;
			$term = $r->term;
			$title = $r->title;
			//for survey status value
			/* if($i == 0){
                                $arr1=array();
                                $arr1[0]=array('opt_text_value'=>'Incomplete','value'=>'0','term'=>'st');
                                $arr1[1]=array('opt_text_value'=>'Completed 4 App','value'=>'1','term'=>'st');
                                $arr1[2]=array('opt_text_value'=>'Completed 4 Web','value'=>'2','term'=>'st');
				$fpiid=0;
                                $temp_arr[ 0 ] = array('fpid'=>$fpiid,'q_type'=>'radio','q_title'=>'Survey Complete Status','qno'=>'survey status','term'=>'st', 'qop'=>$arr1);
			}
			//end of survey status type
			*/
			//for gender
			if($fpid == '6'){
				$arr=array();
				$arr[0]=array('opt_text_value'=>'Male','value'=>'1','term'=>$term);
				$arr[1]=array('opt_text_value'=>'Female','value'=>'2','term'=>$term);
				$arr[2]=array('opt_text_value'=>'Not to say','value'=>'3','term'=>$term);

				$temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
			}
			//for age
                        if($fpid == '7'){
				$arr=array();
				$sql7="SELECT * from project_age_map WHERE qset=$pid ;";
				$dq7=DB::getInstance()->query($sql7);
				if($dq7->count()>0)
				foreach($dq7->results() as $r7){
					$at=$r7->age;
					$av=$r7->valuee;
					$arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
				}
				$temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for old SEC
                        if($fpid == '9' || $fpid == '10'){
                                $arr=array();
                                $sql7="SELECT * from project_sec_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->sec;
                                        $av=$r7->valuee;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for store
                        if($fpid == '11'){
                                $arr=array();
                                $sql7="SELECT * from project_store_loc_map WHERE qset_id=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->store;
                                        $av=$r7->valuee;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for product
                        if($fpid == '12'){
                                $arr=array();
                                $sql7="SELECT * from project_product_map WHERE qset_id=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->product;
                                        $av=$r7->valuee;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for centre
                        if($fpid == '13'){
                                $arr=array();
                                $sql13="SELECT * from centre_project_details WHERE project_id=$pid ;";
                                $dq13=DB::getInstance()->query($sql13);
                                if($dq13->count()>0)
                                foreach($dq13->results() as $r13){
                                        $at='';
                                        $cid=$r13->centre_id;
					$at=get_centre_name($cid);
                                        $arr[ $cid ] = array('opt_text_value'=>$at,'value'=>$cid,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for area of a centre
                        if($fpid == '14'){
                                $arr=array();
                                $sql7="SELECT * from project_centre_area_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->area;
                                        $av=$r7->value;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for sub-area a centre area
                        if($fpid == 15){
                                $arr=array();
                                $sql7="SELECT * from project_centre_subarea_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->suarea;
                                        $av=$r7->value;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			$i++;
		}
            return $temp_arr;
	}
        else
            return $temp_arr;
    } else return false;

}
//to get project question with term of a project for crosstab
function get_project_question_term($pid)
{
    if($pid!='')
    {
	$temp_arr=array();
    	$sql="SELECT distinct a.`q_id`, a.`q_title`, a.`q_type`, a.qno , b.term FROM `question_detail` as a LEFT JOIN question_option_detail as b ON a.q_id = b.q_id WHERE a.q_type IN('radio','checkbox','rating') AND a.q_id IN (select qid from question_sequence WHERE `qset_id`= $pid order by sid) ;";
	$qt=DB::getInstance()->query($sql);
        if($qt->count()>0){
		foreach($qt->results() as $rr){
			$qid =$rr->q_id;
			$qtt =$rr->q_title;
			$qt =$rr->q_type;
			$qno =$rr->qno;
			$term =$rr->term;
			$qo_arr = array();
			$sqq="select op_id, q_id, opt_text_value, value, term from question_option_detail WHERE q_id=$qid ;";
		        $qod=DB::getInstance()->query($sqq);
        		if($qod->count()>0)
                	foreach($qod->results() as $qo){
				$opt=$qo->opt_text_value;
				$val=$qo->value;
				$opid = $qo->op_id;
				$qo_arr[ $opid ] = array('opt_text_value' => $opt,'value' => $val);
			}
			$temp_arr[ $qid ]= array('q_id'=>$qid, 'q_type'=>$qt, 'q_title'=>$qtt,'qno'=>$qno, 'term'=>$term ,'qop'=>$qo_arr);
			//array_push($temp_arr,$qid, $qt, $qtt,$qno,$term);
		}
            return $temp_arr;
	}
        else
            return false;
    } else return false;
}

//to get project survey fps
function get_survey_fp($pid)
{

    if($pid)
    {
	$temp_arr=array();
    	$q=DB::getInstance()->query("SELECT a.pid,a.fpid, b.term,b.title FROM vcims.project_fp_map as a JOIN vcims.app_first_page as b ON a.fpid=b.id where 
a.pid=$pid AND a.fpid IN (SELECT id FROM vcims.app_first_page) order by a.fpid;");
        if($q->count()>0){ 
		$i = 0;
		foreach($q->results() as $r){
			$fpid=$r->fpid;
			$term=$r->term;
			$title=$r->title;

                        //for REspondent Name
                        if($fpid == 1 ){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for Resp Address
                        if($fpid == 2){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for Resp Mobile
                        if($fpid == 3){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for Interviewer Name
                        if($fpid == 4){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for Interviewer Mobile
                        if($fpid == 5){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for Age in yrs
                        if($fpid == 8){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for form number
                        if($fpid == 17){
                                $arr=array();
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'text','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }

			//for gender
			if($fpid == 6){
				$arr=array();
				$arr[0]=array('opt_text_value'=>'Male','value'=>'1','term'=>$term);
				$arr[1]=array('opt_text_value'=>'Female','value'=>'2','term'=>$term);
				$arr[2]=array('opt_text_value'=>'Not to say','value'=>'3','term'=>$term);

				$temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
			}
			//for age
                        if($fpid == 7){
				$arr=array();
				$sql7="SELECT * from project_age_map WHERE qset=$pid ;";
				$dq7=DB::getInstance()->query($sql7);
				if($dq7->count()>0)
				foreach($dq7->results() as $r7){
					$at=$r7->age;
					$av=$r7->valuee;
					$arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
				}
				$temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for old SEC
                        if($fpid == 9 || $fpid == 10){
                                $arr=array();
                                $sql7="SELECT * from project_sec_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->sec;
                                        $av=$r7->valuee;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for store
                        if($fpid == 11){
                                $arr=array();
                                $sql7="SELECT * from project_store_loc_map WHERE qset_id=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->store;
                                        $av=$r7->valuee;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for product
                        if($fpid == 12){
                                $arr=array();
                                $sql7="SELECT * from project_product_map WHERE qset_id=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->product;
                                        $av=$r7->valuee;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for centre
                        if($fpid == 13){
                                $arr=array();
                                $sql13="SELECT * from centre_project_details WHERE project_id=$pid ;";
                                $dq13=DB::getInstance()->query($sql13);
                                if($dq13->count()>0)
                                foreach($dq13->results() as $r13){
                                        $at='';
                                        $cid=$r13->centre_id;
					$at=get_centre_name($cid);
                                        $arr[ $cid ] = array('opt_text_value'=>$at,'value'=>$cid,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for area of a centre
                        if($fpid == 14){
                                $arr=array();
                                $sql7="SELECT * from project_centre_area_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->area;
                                        $av=$r7->value;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			//for sub-area a centre area
                        if($fpid == 15){
                                $arr=array();
                                $sql7="SELECT * from project_centre_subarea_map WHERE qset=$pid ;";
                                $dq7=DB::getInstance()->query($sql7);
                                if($dq7->count()>0)
                                foreach($dq7->results() as $r7){
                                        $at=$r7->suarea;
                                        $av=$r7->value;
                                        $arr[ $av ] = array('opt_text_value'=>$at,'value'=>$av,'term'=>$term);
                                }
                                $temp_arr[ $fpid ] = array('fpid'=>$fpid,'q_type'=>'radio','q_title'=>$title,'qno'=>$term,'term'=>$term, 'qop'=>$arr);
                        }
			$i++;
		}
            return $temp_arr;
	}
        else
            return false;
    } else return false;

}

//to get Key of Value of a specific term
function get_dictionary_value($term,$val)
{
    if($term)
    { 
    //echo "SELECT  `keyy` FROM `dictionary` WHERE `term`='$term' and `value`=$val";
    $q=DB::getInstance()->query("SELECT  `keyy` FROM `dictionary` WHERE `term`='$term' and `value`=$val");
    if($q)
        return $q->first()->keyy;
    else
        return false;
    }
}

function get_dictionary_title($term,$val)
{
    if($term && $val)
    {
    $q=DB::getInstance()->query("SELECT  title FROM `dictionary` WHERE `term`='$term' and `value`=$val");
    if($q)
        return $q->first()->title;
    else
        return false;
    }
}
//to get value of a specific keyy
function get_dictionary_keyy($keyy)
{
    if($keyy)
    {
    $q=DB::getInstance()->query("SELECT  value FROM `dictionary` WHERE `keyy` = '$keyy'");
    if($q)
        return $q->first()->value;
    else
        return false;
    }else echo 'Pls input the term value';
}

//to get all Key and Value of a specific term which is like as parameter passed
function get_dictionary_like($term)
{
    if($term)
    {
    $q=DB::getInstance()->query("SELECT  `keyy`, `value` FROM `dictionary` WHERE `term` like '$term%'");
    if($q)
        return $q->results();
    else
        return false;
    }else echo 'Pls input the term value';
}
//to get table name and field name of given term
function get_table_field($term)
{
    if($term)
    {
    $q=DB::getInstance()->query("SELECT `table`, `field` FROM `table_field_mapping` WHERE `term`='$term'");
    if($q)
        return $q->results();
    else
        return false;
    }else echo 'Pls input the term value';
}
//to find and get the table name and its column name
function get_table_column($str)
{
    $t=array();$f=array();
    $qqq="SELECT DISTINCT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME IN ('$str') ";
    $qfind=DB::getInstance()->query($qqq);
    if($qfind->count())
    {
    foreach($qfind->results() as $q)
    {
    array_push($t,$q->TABLE_NAME);
    array_push($f,$q->COLUMN_NAME);
    }
    return [$t , $f];
    }
 else {
        return false;
    }
}
//to get question details based on qid
function get_question($qid=null)
{
    if($qid)
    {
    $q=DB::getInstance()->query("SELECT `q_id`, `q_title`, `q_type` FROM `question_detail` WHERE `q_id`='$qid'");
    if($q)
        return $q->results();
    else
        return false;
    }else echo 'Pls input the term value';
}
function get_project_questions($pid=null)
{
    if($pid)
    {
    $q=DB::getInstance()->query("SELECT a.`q_id`, a.`q_title`, a.`q_type`, a.qno FROM `question_detail` as a WHERE a.q_type IN ('radio','checkbox','dropdown','rating') AND a.q_id IN (select qid from question_sequence WHERE `qset_id`= $pid order by sid)");
    if($q)
        return $q->results();
    else
        return false;
    }else echo 'Pls input the qset value';
}

//to get question details 
function get_questions()
{
    $q=DB::getInstance()->query("SELECT `q_id`, `q_title`, `q_type` FROM `question_detail`");
    
    if($q)
         return $q->results();
    else
        return false;
}

//to get all questions ID based of a questionset
function get_qset_questions($qsid=null)
{
    if($qsid)
    {
    $q=DB::getInstance()->query("SELECT `qset_id`, `q_id` FROM `question_set` WHERE `qset_id`='$qsid'");
    if($q)
        return $q->results();
    else
        return false;
    }else echo 'Pls input the term value';
}

//to get all questionsets details 
function get_questionsets()
{
    $q=DB::getInstance()->query("SELECT * FROM `questionset`");
    
    if($q)
         return $q->results();
    else
        return false;
}

//to get all project details from vcimstest datbase
function get_questionset_test($pid=null)
{
    $q=DB::getInstance()->query("SELECT distinct `qset_id` FROM vcimstest.questionset WHERE project_id='$pid'");
    if($q)
        return $q->results();
    else
        return false;
}
//to get all project details
function get_questionset($pid=null)
{
    $q=DB::getInstance()->query("SELECT distinct `qset_id` FROM `questionset` WHERE project_id='$pid'");
    if($q)
        return $q->results();
    else
        return false;
}
//to get all column list from tables where repondent response will be stored
function get_terms()
{
    $q=DB::getInstance()->query("SELECT  COLUMN_NAME,TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS  where table_name not in ( 'TABLES','TRIGGERS', 'USER_PRIVILEGES','VIEWS','CHARACTER_SETS','COLLATIONS','admin_user','COLUMNS','COLLATION_CHARACTER_SET_APPLICABILITY','centre','centre_project_details','client_info','COLUMN_PRIVILEGES','company_list','demo_respondent', 'ENGINES','EVENTS','FILES','INNODB_BUFFER_PAGE','INNODB_BUFFER_PAGE_LRU','INNODB_BUFFER_POOL_STATS','INNODB_TRX','KEY_COLUMN_USAGE','PARAMETERS','PARTITIONS','INNODB_CMP','INNODB_CMPMEM','INNODB_CMPMEM_RESET','INNODB_CMP_RESET','INNODB_LOCKS','INNODB_LOCK_WAITS','PLUGINS','PROCESSLIST','PROFILING','ROUTINES','REFERENTIAL_CONSTRAINTS','SCHEMATA','SCHEMA_PRIVILEGES','SESSION_STATUS','SESSION_VARIABLES','STATISTICS','TABLESPACES','TABLE_CONSTRAINTS','TABLE_PRIVILEGES','GLOBAL_STATUS','GLOBAL_VARIABLES','user_client_map','question_detail','question_option_detail','project_term_map','ques_brand','ques_prod_consume','ques_prod_post_consume','ques_prod_uses','ques_respondent','quota','respondent','respondent_centre_map','respondent_link_map','rfid_info','rfid_installed_info','hindi_question_detail','hindi_question_option_detail','questionare_info','questionset','question_routine_detail','question_sec','question_set','ques_prod_pre_consume','respondent_ques_details','rfid_info_backup','session','project_user_map','project_client_map','project') order by table_name");
    if($q)
        return $q->results();
    else
        return false;
}
//get all sections
function get_sections()
{
    $q=DB::getInstance()->query("SELECT * FROM `question_sec`");
    if($q)
        return $q->results();
    else
        return false;
}

//to get the client list
function get_clients()
{
    $qq=DB::getInstance()->query("SELECT `cid`, `cname`, `address`, `phone` FROM `client_info`");
    if($qq)
       return $qq->results();
    else
       return false;
}
//to get the client user list
function get_client_users()
{
    $qq=DB::getInstance()->query("SELECT `user_id`, `user` FROM `admin_user` WHERE `role` in (3,4)");
    if($qq)
       return $qq->results();
    else
       return false;
}

//to get tablist
function get_tabs()
{
    $qq=DB::getInstance()->query("SELECT `tab_id`, `tab_name`, `tab_company`, `tab_imei_1`, `tab_imei_2`, `tab_email`, `sim_sp`, `tab_sim_no`, `tab_mobile`, `tab_charger`, `tab_charger_status`, `tab_status` FROM `vcims_tablets`");
    if($qq)
       return $qq->results();
    else
       return false;
}
function get_project_table($pid)
{
    $qqq="SELECT data_table FROM project WHERE project_id = $pid";
    $q=DB::getInstance()->query($qqq);
    if($q->count()>0){
    	$pn=$q->first()->data_table;
	return $pn;
    }
    else  return false;
}
//----------------------------------------------
             //to get one respondent details in a row
                function r_detail($resp=null,$qset=null,$dtable=null,$colmn,$isd=null,$sm=null,$em=null,$yrs=null)
                {
                 	$rrdata=array();
	                foreach($colmn as $cn)
	                {    $dd='';
	                     if($isd==0)
	                        $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''";
                             if($isd==1)
                             {
                                    
				
                                   if($qset==20 || $qset==40)
                                   {   
                                      if($yrs==2016)
		                      {
                                      	if($sm > 4)
                                         	$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset)=$yrs ";
                                    	else
                                    		$qrr="SELECT $cn as cc FROM vcimstest.$dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset)=$yrs ";
                                      }
                                      if($yrs>2016)
                                      {
                                      		$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs ";
                                      }
                                 }
                                 if( $qset==50)
                                {$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(i_date_50) = $sm AND year(i_date_50)=$yrs ";}
                                 else
                                      $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!='' and month(i_date_$qset) between $sm and $em";
                             }
  //echo "<br>".$qrr;
	                     $dtr=DB::getInstance()->query($qrr);		
			     if($dtr->count()>0)
			     {
	                            $dd=$dtr->first()->cc;
			     }
	                     array_push($rrdata,$dd);
	                }
	                return $rrdata;
			
		}  //end of function
//----------------------------------------------
             //to get one respondent details in a row with multicode
                function r_detailm($resp=null,$qset=null,$dtable=null,$colmn,$isd=null,$sm=null,$em=null,$yrs=null,$mcolmn)
                {        
                          
                 	$rrdata=array();
	                foreach($colmn as $cn)
	                {    $dd='';
                             $dnm=substr($cn, strrpos($cn, '_') + 1); $dlen=strlen($dnm);$dlen=$dlen+1; $dtlen=strlen($cn); 
                             $difflen=$dtlen-$dlen; $cnn=substr($cn,0,$difflen);
                           //echo '<br>'.$cnn;                              
                           //echo $cnn ,print_r($mcolmn), $ss=in_array($cnn,$mcolmn)?1:0;
	                     if($isd==0)
	                     {   $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''";
                                 if(in_array($cnn,$mcolmn)) 
                                 {
	                           $qrr="SELECT $cnn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm'";
                                 }
                             }
                             if($isd==1)
                             {
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!='' and month(i_date_$qset) between $sm and $em";
                                      if($qset!=20 || $qset!=40)
                                      {
                                           if(in_array($cnn,$mcolmn)) 
                                            {
	                                       $qrr="SELECT $cnn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs";
                                            }
                                      }
                                   if($qset==20 || $qset==40)
                                   {   
                                      if($yrs==2016)
		                      {
                                      	if($sm > 4)
                                        { 	$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset)=$yrs ";
                                        }
                                    	else
                                    	{	$qrr="SELECT $cn as cc FROM vcimstest.$dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset)=$yrs ";
                                        }
                                      }
                                      if($yrs>2016)
                                      {
                                      		$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs ";
                                            
                                            if(in_array($cnn,$mcolmn)) 
                                            {
	                                       $qrr="SELECT $cnn as cc FROM $dtable WHERE resp_id =$resp and $cnn!='' AND $cnn='$dnm' and month(visit_month_40) = $sm AND year(visit_month_40)=$yrs";
                                            }

                                      }
                                 }
                                 if( $qset==50)
                                 {  $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(i_date_50) = $sm AND year(i_date_50)=$yrs ";
                                     if(in_array($cnn,$mcolmn)) 
                                            {
	                                       $qrr="SELECT $cnn as cc FROM $dtable WHERE resp_id =$resp and $cnn!='' AND $cnn='$dnm' and month(i_date_50) = $sm AND year(i_date_50)=$yrs";
                                            }
                                 }
                                   
                                 
                             }

                           /*  if(in_array($cnn,$mcolmn)) 
                             {
                                //if($isd==0)
	                           $qrr="SELECT $cnn as cc5 FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm'";
                                    //echo "<br>".$qrr;
                             }
                          */

  //echo "<br>".$qrr;
	                     $dtr=DB::getInstance()->query($qrr);		
			     if($dtr->count()>0)
			     {
	                            $dd=$dtr->first()->cc;
			     }
	                     array_push($rrdata,$dd);
	                }
	                return $rrdata;
			
		}  //end of function

     //to get one respondent score details in a row
                function rscore_detail($resp=null,$qset=null,$dtable=null,$colmn,$isd=null,$sm=null,$yrs=null)
                {
                 	$rrdata=array(); $r=0; $r2=0; $ascore32=0; $ascore33=0; $ascore31a=0; $ascore31b=0; $ascore31c=0; $ascore17=0;
	                foreach($colmn as $cn)
	                {    $dd='';$ascore=0;
                           
                             //if($cn=='aq31a_40' || $cn=='aq31b_40' || $cn=='aq32_40' || $cn=='aq33_40' )
                                    //continue;
	                     if($isd==0)
	                        $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''";
                             if($isd==1)
                             {
                               if($yrs==2016)
                               {
                                  if($qset==20)
                                  {  if($sm > 4)
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs";
                                    else
                                    $qrr="SELECT $cn as cc FROM vcimstest.$dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs";                                    
                                  }
                                 
                                 if($qset==40)
                                 {  if($sm > 7)
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs"; 
                                 }
                               }
                               if($yrs>2016)
                               {
                                    $qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!='' and month(visit_month_$qset) = $sm AND year(visit_month_$qset) = $yrs";
                               }
                             }
    // echo "<br>".$qrr;
	                     $dtr=DB::getInstance()->query($qrr);		
			     if($dtr->count()>0)
			     {
	                            $dd=$dtr->first()->cc;
			     }
				  $gp=null;$gw=null;$aw=null;$opr=null;$ascore=0;
				  if($qset==40)
				  {
				     //$rq="SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed2_attribute` WHERE op=$dd AND q_term='$cn' ";
				     $rq="SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$cn' AND b1.month=$sm AND b1.yrs=$yrs AND a1.op=$dd";
				  }
				  else $rq="SELECT `id`, `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$dd AND q_term='$cn' ";
			  	$r3=DB::getInstance()->query($rq);
		  		if($r3->count()>0)
		  		{
		       			$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
		  		} 
		           
		  		$ascore=$opr*$aw;

                          // echo '<br>pushed booth: '.$resp .' term:'.$cn.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;    
	                        
                                
                               array_push($rrdata,$ascore); 
	                        if($dd==2 && $cn=='aq31_40')
                                 {        $r=1;   }
                                if($dd==2 && $cn=='aq26_40')
                                 {        $r2=1;   }
                                                 //($cn=='aq32_40' || $cn=='aq33_40' || $cn=='aq31a_40' || $cn=='aq31b_40' || $cn=='aq31c_40')

                                 if($r==1 && ( $cn=='aq32_40' || $cn=='aq33_40' || $cn=='aq31a_40' || $cn=='aq31b_40' || $cn=='aq31c_40' || $cn=='aq17_40'))
                                 {  array_pop($rrdata);
                                    //echo "<br>poped cn: $cn: $ascore ";
                                 } 
                                 if($r2==1 && ( $cn=='aq27_40' || $cn=='aq28_40' || $cn=='aq29_40' || $cn=='aq30_40'))
                                 {  array_pop($rrdata);
                                    //echo "<br>poped cn: $cn: $ascore ";
                                 } 

                               //echo "<br>r==: $r dd==: $dd";
                                 if($r==1 )
                                 { //echo "<br>in.. cnd: $cn: $ascore ";   
                                      
                                     if($cn=='aq31a_40')
                                     {    array_push($rrdata,$ascore31b);  }
                                     if($cn=='aq31b_40')
                                     {    array_push($rrdata,$ascore31b);  }
                                     if($cn=='aq31c_40')
                                      {   array_push($rrdata,$ascore31c);  }
                                     if($cn=='aq17_40')
                                     {    array_push($rrdata,$ascore17);  }
                                 }

	                     if($dd==2)
		             {  
		                if($cn=='aq9_40' ||  $cn=='aq11_40' || $cn=='aq26_40' || $cn == 'aq31_40' || $cn == 'aq16_40' || $cn == 'aq22_40' || $cn == 'aq34_40')
		                {   $arr=  array();
		                    $arr1=  array('aq27_40','aq28_40','aq29_40','aq30_40');     
		                    $arr2=  array('aq32_40','aq33_40','aq31a_40','aq31b_40','aq31c_40');     
		                    $arr3=  array('aq34a_40','aq34b_40');
		                     
		                    if($cn=='aq26_40')
		                        $arr=$arr1;
		                    if($cn=='aq31_40')
		                        $arr=$arr2;
		                    if($cn=='aq34_40')
		                        $arr=$arr3;
		                    if($cn=='aq9_40')
		                        $arr=array('aq10_40');
		                    if($cn=='aq11_40')
		                        $arr=array('aq12_40');
		                    if($cn=='aq16_40')
		                        $arr=array('aq17_40');
		                      
		
		                    foreach($arr as $key=>$val)
		                    { $ascore=0;
		                       
		                        $r3=DB::getInstance()->query("SELECT a1.`q_term`, a1.`group_id`,a1.`op`, a1.`op_rate`, b1.`grp_wt`, b1.`attr_wt`, b1.`month` FROM `md_umeed2_attribute` as a1 JOIN `monthly_umeed2_attribute` as b1 on a1.q_term=b1.q_term WHERE a1.q_term='$val' AND b1.month=$sm AND b1.yrs=$yrs AND a1.op=$dd ");
		                        if($r3->count()>0)
		                        {
		                                $gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=''; $opr=1;
		                        
		
		                          $ascore=$opr*$aw;
                                          if($val=='aq17_40' || $val=='aq32_40' ||  $val=='aq33_40' || $val=='aq31a_40' || $val == 'aq34b_40' || $val == 'aq31c_40' || $val == 'aq31b_40')
                                          {    //echo "<br>found resp:$resp , $val = $ascore";
                                             
		                                if($val=='aq32_40')
                                                 {    $ascore32=$ascore; array_push($rrdata,$ascore32); }
                                                if($val=='aq33_40')
                                                 {    $ascore33=$ascore; array_push($rrdata,$ascore33); }
                                                if($val=='aq31a_40')
                                                {     $ascore31a==$ascore; }
                                                if($val=='aq31b_40')
                                                 {    $ascore31b=$ascore; }
                                                if($val=='aq31c_40')
                                                 {    $ascore31c=$ascore; }
                                                if($val=='aq17_40')
                                                {     $ascore17=$ascore;  }

                                             //echo '<br>rbooth: '.$resp .' term:'.$val.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
	                    
                                          }
                                          else if($cn!='aq16_40' || $cn!='aq31_40')
                                          { array_push($rrdata,$ascore); 
                                             //echo '<br>pushed erbooth: '.$resp .' term:'.$val.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;
                                          }

		                         }
		                    } //enf foreach  
		                }
		                }
                            /*  if($cn!='aq32_40') if($cn!='aq33_40') if($cn!='aq17_40')
                              {
                              //echo "<br>nresp:$resp , $cn = $ascore";
                              
                              array_push($rrdata,$ascore);
                              //echo '<br>e booth: '.$resp .' term:'.$cn.',resp val:'.$op.' , a rate:'.$aw  .' , attr op rate :'.$opr.' , attr score='.$ascore;    
	                    
                              }
                            */

	                } //end of foreach
	                return $rrdata;
			
		}  //end of function
//-----------------------------------------------------------------
//get booth score for umeed project
function get_booth_score($r=0,$b=0,$s=0,$g=0)
{

		$booth_score=0;$sum=0;$avg=0.0;$cnt=0;$m=1;$g=0;

     	//echo "<table border=1> <tr><td>BOOTH_ID</td><td>BOOTH SCORE</td> </tr>";
     	$b_all=DB::getInstance()->query("select distinct resp_id from UMEED_20 WHERE MONTH(`visit_month_20`) =$m order by resp_id"); 
     	foreach($b_all->results() as $ba)
     	{   
     	
   		 $booth_score=0;
   		$b_id=$ba->resp_id;$stra=''; $strb='';$ascore='';
   		if($g==0) {$stra=''; $strb='';}
        	if($g>0){ $stra=" WHERE group_id=$g "; $strb=" AND group_id=$g";}
        
		  $r1=DB::getInstance()->query("SELECT distinct `q_term` FROM `md_umeed_attribute` $stra ");
		  if($r1->count()>0)
		  {
		     foreach($r1->results() as $ra)
		     {    
		       	$t=$ra->q_term;$aw='';$opr='';
		       
		       	$r2=DB::getInstance()->query("SELECT distinct $t FROM  `UMEED_20` WHERE MONTH(`visit_month_20`) =$m AND  $t !='' and resp_id=$b_id");
		       	if($r2->count()>0)
		       	{ 
		       		$rdata=$r2->first()->$t;
		                $qqr1="SELECT  `q_term`, `group_id`, `grp_wt`, `attr_wt`, `op`, `op_rate` FROM `md_umeed_attribute` WHERE op=$rdata AND q_term='$t' $strb ";
		       		$r3=DB::getInstance()->query($qqr1);
		  		if($r3->count()>0)
		  		{
		       			$gp=$r3->first()->group_id; $gw=$r3->first()->grp_wt; $aw=$r3->first()->attr_wt; $op=$r3->first()->op; $opr=$r3->first()->op_rate;
		  		} 
		  	
		  		$ascore=$opr*$aw;
		  	 	$booth_score=$ascore+$booth_score;
		  	  	
		  	}
		     }  //end of foreach
		
			//echo '<br>booth score:'.$booth_score;
			
		  } //end of r2
                  $sum=$sum+$booth_score;
		  $cnt++;
		//echo "<tr><td>$b_id</td><td>$booth_score</td></tr>";
     	} //end of foreach
     	 
           $avg=$sum/$cnt;

		$data = array(array('Month', 'MeanScore') );
                array_push($data, array('JAN', $avg));
             	return $data;

}

//to check term is already exist in table-project_term for crosstab
function is_project_term_exist($term=null)
{
    if($term!=null)
    {
    $q=DB::getInstance()->query("select *  from project_term_map where term='$term'");
    if($q->count()>0)
        return true;
    else 
        return false;
    }else echo 'Pls input the term name';
}
//get survey end date of a project
function get_peoject_edt($pid=null)
{
    if($pid!=null)
    {
    $q=DB::getInstance()->query("select survey_end_date  from project where project_id=$pid");
    if($q->count()>0)
    {    $dt=$q->first()->survey_end_date; return $dt;}
    else 
        return 0;
    }else echo 'Pls input the valid pid';
}

//get mangopinion project survey attend date 
function get_mangopinion_dt($rid=null)
{
    if($rid!=null)
    {
    $q=DB::getInstance()->query("select i_date_57  from mangopinion_57 where resp_id=$rid and i_date_57!='' limit 1");
    if($q->count()>0)
    {    $dt=$q->first()->i_date_57; return $dt;}
    else 
        return 0;
    }else echo 'Pls input the valid pid';
}
function get_centre_name($cid=null)
{
    if($cid!=null)
    {
    $q=DB::getInstance()->query("SELECT `centre_id`, `cname`  FROM `centre` WHERE `centre_id`=$cid ");
    if($q->count()>0)
    {    $cn=$q->first()->cname; return $cn;}
    else 
        return 0;
    }else echo 'Pls input the valid cid';
}
?>
