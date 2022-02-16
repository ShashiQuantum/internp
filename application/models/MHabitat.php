<?php

class MHabitat extends CI_Model
{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
            public function getDataBySql($sql)
            {
                $query=$this->db->query($sql);
                $result= $query->result();
                if($result)
                    return $result;
                else
                    return false;
            }
            public function doSqlDML($sql)
            {
                $query=$this->db->query($sql);
                return $query;
            }
            public function insertIntoTable($table,$tdata)
            {
                if($this->db->insert($table,$tdata))
                {
                        $last_id = $this->db->insert_id();
                        if($last_id)
                                return $last_id;
                        else
                                return false;
                }else return false;
            }
	function validate_qset($pid,$sid) //checking wheather qset_id does exist or wrong
	{
	    if($pid!=''){
        	return $this->db->query("select * from question_sequence where qset_id=$pid AND sid=$sid;")->row();
	    } else return false;
	}
	function validate_mkey($pid,$mkey) //checking wheather qset_id does exist or wrong
	{
	    if($pid!=''){
        	$dd=$this->db->query("select * from tab_project_map where project_id=$pid AND mobile = '$mkey' ;")->row();
		if($dd) return true;
		else	return false;
	    } else return false;
	}
        function getPTable($pid)
        {
	    if($pid!=''){
                $query=$this->db->query("select data_table from project where project_id = $pid ;");
                $row=$query->row();
                if($row)
                        return $row->data_table;
                else
                        return false;
	   }else return false;
        }
        function isProject($pid)
        {
	    if($pid!=''){
                       date_default_timezone_set("Asia/Kolkata");
                       $dt=date("Y-m-d");
                $query=$this->db->query("select survey_start_date,survey_end_date from project where project_id=$pid AND date(survey_end_date) >= date(now()) limit 1");
                $row=$query->row();
                if($row){
                        $std=$row->survey_start_date;$edt=$row->survey_end_date;
			if($dt <= $edt) return true;
			else return false;
		}
                else
                        return false;
	   } else return false;
        }

	///////////// getting current qid
	function get_cqid($cqset, $csid)
	{
	     if($cqset!='' && $csid!=''){
		$query=$this->db->query("select qid from question_sequence WHERE sid = $csid AND qset_id = $cqset limit 1;");
		$row=$query->row();
		if($row)
			return $row->qid;
		else
			return 0;
	     }else return 0;
	}

        function get_qsid($cqset, $qid)
        {
             if($cqset!='' && $qid!=''){
                $query=$this->db->query("select sid from question_sequence WHERE qid = $qid AND qset_id = $cqset limit 1;");
                $row=$query->row();
                if($row)
                        return $row->sid;
                else
                        return 0;
             }else return 0;
        }

	//to get sid of a qset of only qtype of radio or checkbox type
	function get_sidonly($qset)
	{	$arr=array();
		$ctr=0;$max=0;
		//array_push($arr,0);
		$sql="SELECT a1.qid, a1.sid, a2.q_type FROM vcims.question_sequence as a1 JOIN question_detail as a2 ON a1.qid=a2.q_id where a1.qset_id=$qset AND a2.q_type IN ('radio','checkbox') order by a1.sid";
		$query=$this->db->query($sql);
		$results=$query->result();
		if($results)
		foreach($results as $r)
		{
			$ctr=$ctr+1;
			$sid=$r->sid;
			$arr["$ctr"]=$sid;
			$max=$sid;
		}
		$_SESSION['mxsid']=$max;
		return $arr;
	}
	///////////// getting current term id
	function get_ctermid($cqid)
	{
		$query=$this->db->query("select term from question_option_detail where q_id=$cqid");
		$row=$query->row();
		if($row)
			return $row->term;
		else
			return 0;
	}
	
	///////////// getting current question title
	function get_cqt($cqid)
	{
		$query=$this->db->query("select q_title from question_detail where q_id=$cqid");
		$row=$query->row();
		if($row)
			return $row->q_title;
		else
			return false;
	}
        function get_qtype($cqid)
        {
                $query=$this->db->query("select q_type from question_detail where q_id=$cqid");
                $row=$query->row();
                if($row)
                        return $row->q_type;
                else
                        return false;
        }
        function get_qno($cqid)
        {
                $query=$this->db->query("select qno from question_detail where q_id=$cqid");
                $row=$query->row();
                if($row)
                        return $row->qno;
                else
                        return false;
        }

	/////// getting option text value of current term
	function get_optxt($cqid)
	{
		$query=$this->db->query("select * from question_option_detail where q_id='$cqid'");
		return $query->result();
	}
	// get total respondent counting of term/question term based on filter with op_value and centre code
	function get_cod_filter($dtable, $cterm, $value,$filter)
	{
		$query=$this->db->query("select count( $cterm ) as cnt from $dtable where $cterm!=0 AND $cterm=$value $filter ;");
		$row=$query->row();
		if($row)
			return $row->cnt;
		else
			return 0;
	}

	// get total respondent counting of term/question term based on filter with centre code only
	function get_cod_ov_filter($dtable, $cterm, $filter)
	{
		$query=$this->db->query("select count($cterm) as cnt from $dtable where $cterm!=0 $filter");
		$row=$query->row();
		if($row)
			return $row->cnt;
		else
			return 0;
	}

	///////////// counting options details as per term and qid
	function get_cod($dtable, $cterm, $value)
	{
		$query=$this->db->query("select count($cterm) as cnt from $dtable where $cterm!=0 AND $cterm=$value");
		$row=$query->row();
		if($row)
			return $row->cnt;
		else
			return 0;
	}

	///////// Counting options for one term (overall)
	function get_cod_ov($dtable, $cterm, $f)
	{
		$query=$this->db->query("select count($cterm) as cnt from $dtable where $cterm!=0 $f ;");
		$row=$query->row();
		if($row)
			return $row->cnt;
		else
			return 0;
	}

	function get_mxsid($pid)
	{
		$query=$this->db->query("select max(sid) as sid from question_sequence where qset_id = $pid;");
		$row=$query->row();
		if($row)
			return $row->sid;
		else
			return 0;
	}

}
