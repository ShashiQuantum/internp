<?php class MProject extends CI_Model {
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
	    public function get_project_name($pid=null)
	    {
	       		$this->db->select('name');
		        $query=$this->db->get_where('project',array('project_id' => $pid));
		        $result=$query->row();
		        if($result)
		        	return $result->name;
		        else
		        	return false;
	    }
            public function get_login_user_name($uid=null)
            {
                        $this->db->select('name');
                        $query=$this->db->get_where('admin_user_info',array('user_id' => $uid));
                        $result=$query->row();
                        if($result)
                                return $result->name;
                        else
                                return false;
            }
	    public function getProject($pid=null)
	    {
	       		$this->db->select('*');
		        $query=$this->db->get_where('project',array('project_id' => $pid));
		        $result=$query->result();
		        if($result)
		        	return $result;
		        else
		        	return false;
	    }
	    public function getProjects()
	    {
	        $query=$this->db->query('select * from project order by project_id desc');
	        return $query->result();
	    }
		public function getResearchTypes(){
			$query = $this->db->query('select * from survey_category');
            return $query->result();
		}
        //to get total survey response count of a project
            public function get_project_survey_data_count($tbl=null)
            {
		if($tbl != null)
		{
                        $query=$this->db->query("SELECT st, count(resp_id) as cnt FROM $tbl where st!='' group by st; ");
                        $results=$query->result();
                        if($results){
                                $str="<table class='table' style='font-size: 9px;'><tr><td> TYPE </td> <td>COUNT</td> </tr>";
                                foreach($results as $r)
                                {
					$qts = $r->st;
                                        if($qts == 0 || $qts == '0') $qt = 'Dummy';
					else $qt = 'Actual';

                                        $cnt = $r->cnt;
                                        $str.="<tr><td>$qt</td> <td>$cnt</td> </tr>";
                                }
                                $str.="</table>";
                                return $str;
                        }
                        else
                                return "<p style='color: red;'> Details Not Found </p>";
		}
		else
			return "Something unexpected happened!";
            }

        //to get total questions type count of a project
            public function get_project_ques_type_count($pid=null)
            {
                        $query=$this->db->query("SELECT q_type, count(q_type) as cnt FROM question_detail where qset_id=$pid group by q_type; ");
                        $results=$query->result();
                        if($results){
				$str="<table class='table' style='font-size: 9px;'><tr><td>Q.TYPE</td> <td>COUNT</td> </tr>";
				foreach($results as $r)
				{
					$qt = $r->q_type;
					$cnt = $r->cnt;
					$str.="<tr><td>$qt</td> <td>$cnt</td> </tr>";
				}
				$str.="</table>";
                                return $str;
			}
                        else
                                return "<p style='color: red;'>Pending </p>";
            }

	//to get total questions count of a project
            public function get_project_ques_count($pid=null)
            {
                        $query=$this->db->query("SELECT count(*) as cnt FROM vcims.question_detail where qset_id =$pid ");
                        $result=$query->row();
                        if($result){
                                $cnt=$result->cnt;
                                if( $cnt > 0)
                                        return $result->cnt;
                                else
                                        return "<span style='color: red;'> 0 </span>";
			}
                        else
                                return "<span style='color: red;'> 0 </span>";
            }

        //to get total questions  sequencing count of a project
            public function get_project_seq_count($pid=null)
            {
                        $query=$this->db->query("SELECT count(*) as cnt FROM vcims.question_sequence where qset_id =$pid ");
                        $result=$query->row();
                        if($result)
                        {        $cnt=$result->cnt;
                                if( $cnt > 0)
                                        return $result->cnt;
                                else
                                        return "<p style='color: red;font-size:9px;'>Pending</p>";
			}
                        else
                                return "<p style='color: red;font-size:9px;'>Pending</p>";
            }

        //to get total questions routing count of a project
            public function get_project_routing_count($pid=null)
            {
                        $query=$this->db->query("SELECT count(*) as cnt FROM vcims.question_routine_check where qset_id = $pid ");
                        $result=$query->row();
                        if($result)
			{	$cnt=$result->cnt;
				if( $cnt > 0)
                                	return $result->cnt;
				else
					return "<p style='color: red;font-size:9px;'>Pending</p>";
                        }
			else
                                return "<p style='color: red;font-size:9px;'>Pending</p>";
            }


	//to check term is already exist in table-project_term for crosstab
	function is_project_term_exist($term=null)
	{
   		if($term!=null)
    		{
                        $query=$this->db->get_where('project_term_map',array('term' => $term));
                        $result=$query->row();
                        if($result)
                                return true;
                        else
                                return false;
		}
		else return false;
	}
	    public function getCentres()
	    {
	        $query=$this->db->query('select * from centre order by cname');
	        return $query->result();
	    }
            public function getProjectFirstPageList()
            {
                $query=$this->db->query('select * from app_first_page order by title');
                return $query->result();
            }
	    public function getTab($tid)
	    {
	        $query=$this->db->get_where('vcims_tablets',array('tab_id' => $tid));
	        return $query->row();
	    }
	    public function getTabs()
	    {
	        $query=$this->db->get('vcims_tablets');
	        return $query->result();
	    }
	    public function isTab($email)
	    {
	        $query=$this->db->get_where('vcims_tablets',array('tab_email' => $email));
	        $res=$query->result();
	        if($res)
	          return true;
	        else
	          return false;
	    }
	    
	    public function addTab($tdata)
	    {
	        $res=$this->db->insert('vcims_tablets',$tdata);
	        
	        if($res)
	          return true;
	        else
	          return false;
	    }
	    public function updateIssueTab($tid,$uarr)
	    {
	        $this->db->set($uarr);
	        $this->db->where('tab_id', $tid);
	        $res = $this->db->update('tab_allocation');
	        if($res)
	          return true;
	        else
	          return false;
	    }
	    
	    
		public function updateData($pqid,$data){
				
			$this->db->set($uarr);
	     //   $this->db->where('tab_id', $tid);
	        $res = $this->db->update('tab_allocation');
	        if($res)
	          return true;
	        else
	          return false;
		}
        public function getuserrole($uid=null)
        {
                $this->db->select('role_id');
	        $query=$this->db->get_where('admin_user_role',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->role_id;
	        else
	        	return false;
        }
        public function getroles()
        {
                $this->db->select('*');
	        $query=$this->db->get('user_role_detail');
	        $results=$query->result();
	        if($results)
	        	return $results();
	        else
	        	return false;
        }
        public function adduserrole($udata)
        {
               $res=$this->db->insert('admin_user_role',$udata);
        
               if($res)
                   return true;
               else
                  return false;
        }
    	public function getUsers()
    	{
        	$query=$this->db->get('admin_user');
        	return $query->result();
    	}
        public function getpermissions()
        {
                $this->db->select('*');
	        $query=$this->db->get('user_permission');
	        $results=$query->result();
	        if($results)
	        	return $results;
	        else
	        	return false;
        }
        public function getpermissionname($prid=null)
        {
                $this->db->select('pname');
                $query=$this->db->get_where('user_permission',array('prm_id'=>$prid));
                $results=$query->row();
                if($results)
                        return $results->pname;
                else
                        return false;
        }
        public function getuserpermissionmap($uid=null)
        {
                $this->db->select('prm_id');
	        $query=$this->db->get_where('user_permission_map',array('user_id' => $uid, 'status' => 1 ));
	            
	        $results=$query->result();
	        if($results)
	        {    
	         	$out=array();
	        	foreach($results as $p)
                        {
                             array_push($out,$p->prm_id);
                        }
	        	return $out;
	        }
	        else
	        	return false;
        }

        public function getuserpermissionrolemap($uid=null)
        {
                $this->db->select('*');
	        $query=$this->db->get_where('user_permission_role_map',array('user_id' => $uid));
	        $results=$query->result();
	        if($results)
	        	return $results;
	        else
	        	return false;
        }

        public function addpermission($udata=null)
        {
                 $res=$this->db->insert('user_permission',$udata);
         
                 if($res)
                    return true;
                 else
                    return false;
        }
        public function adduserpermissionmap($udata=null)
        {
                 $res=$this->db->insert('user_permission_map',$udata);
         
                 if($res)
                    return true;
                 else
                    return false;
        }
        public function isuserpermissionmap($uid=null,$prm=null)
        {
                $this->db->select('*');
	        $query=$this->db->get_where('user_permission_map',array('user_id' => $uid,'prm_id' => $prm));
	        $results=$query->result();
	        if($results)
	        	return true;
	        else
	        	return false;
        }
        public function addgetuserpermisionrolemap()
        {
                 $res=$this->db->insert('user_permission_role_map',$udata);
         
                 if($res)
                    return true;
                 else
                    return false;
        }
        public function create_sauser($email,$pass,$name,$mobile,$r)
        {
                  if(!$this->isUser($email))
                  {
                        $timezone = "Asia/Calcutta";
			if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
	
		 	$salt = $this->cryptGetToken(32);
			$pwd = $this->hashMake($pass, $salt);
                        
			
                        $create = $this->db->insert('admin_user',array('user'=> $email,'pass'=> $pwd,'salt'=> $salt,'role'=> $r,'create_date'=> $date,'status'=> 1));
                        $userid=$this->getUserID($email);
                        if($userid)
                        {
                             $create1 = $this->db->insert('admin_user_info',array('user_id'=> $userid,'name'=> $name,'email'=> $email,'mobile1'=> $mobile)); 
                             $create2 = $this->db->insert('admin_user_role',array('user_id'=> $userid,'role_id'=> $r,'date'=> $date));
                             return true;
                        }
                       
                  } //end of isuserid
              return false;
                        
        }

	//---------------Core Functions ------------------------------------------------------------------------------------------------------
		public function getCentre($cid=null)
	    	{
	       		
	       		$this->db->select('cname');
		        $query=$this->db->get_where('centre',array('centre_id' => $cid));
		        $result=$query->row();
		        if($result)
		        	return $result->cname;
		        else
		        	return false;
	    	}
	        public function isCat($cname)
	        {
	        
	        $query=$this->db->get_where('category_detail',array('name' => $cname));
	        $res=$query->result();
	        if($res)
	          return true;
	        else
	          return false;
	        }
	        public function isTransQ($t=null,$qid=null)
	    	{
	       		
	       		$this->db->select('*');
		        $query=$this->db->get_where($t,array('q_id' => $qid));
		        $result=$query->row();
		        if($result)
		        	return true;
		        else
		        	return false;
	    	}
	        public function isTransQop($t=null,$qid=null,$v=null)
	    	{
	       		$this->db->select('*');
		        $query=$this->db->get_where($t,array('q_id' => $qid, 'code'=>$v));
		        $result=$query->row();
		        if($result)
		        	return true;
		        else
		        	return false;
	    	}
	        public function isQCat($cat,$qid)
	        {
	        $query=$this->db->get_where('question_category',array('cat_id' => $cat,'q_id'=>$qid));
	        $res=$query->result();
	        if($res)
	          return true;
	        else
	          return false;
	        }
	        public function isQOp($qid,$v)
	        {
	        $query=$this->db->get_where('question_option_detail',array('value' => $v,'q_id'=>$qid));
	        $res=$query->result();
	        if($res)
	          return true;
	        else
	          return false;
	        }
	        public function isQTerm($qid)
	        {
	        $this->db->select('term');
	        $query=$this->db->get_where('question_option_detail',array('q_id'=>$qid));
	        $res=$query->row();
	        if($res)
	          return $res->term;
	        else
	          return false;
	        }
	        public function getQopid($qid, $code)
	        {
	        $this->db->select('op_id');
	        $query=$this->db->get_where('question_option_detail',array('q_id'=>$qid, 'value'=>$code));
	        $res=$query->row();
	        if($res)
	          return $res->op_id;
	        else
	          return false;
	        }
	        public function getProjectTable($pid=null)
	    	{
	       		$this->db->select('*');
		        $query=$this->db->get_where('project',array('project_id' => $pid));
		        $result=$query->row();
		        if($result)
		        	return $result->data_table;
		        else
		        	return false;
	    	}
                public function getPTQs($qset=null,$lang=null)
                {
			$sql="select distinct q_id, qno,q_type from question_detail where qset_id=$qset";
			if($lang==1) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from hindi_question_option_detail 
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==2) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from kannar_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==3) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from malyalam_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==4) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from tammil_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==5) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from telgu_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==6) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from bengali_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==7) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from odia_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==8) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from gujrati_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==9) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from marathi_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";
                        if($lang==10) $sql="select distinct q_id, qno,q_type from question_detail where q_id in (select distinct q_id from asami_question_option_detail
where q_id in (select q_id from question_detail where qset_id=$qset))";

                        $query=$this->db->query($sql);
                        $result=$query->result();
                        if($result)
                                return $result;
                        else
                                return false;
                }

	        public function getPQs($qset=null)
	    	{
	       		$query=$this->db->query("select distinct q_id, qno,q_type from question_detail where qset_id=$qset");
		        $result=$query->result();
		        if($result)
		        	return $result;
		        else
		        	return false;
	    	}
                public function getPEQs($qset=null)
                {
                        $query=$this->db->query("select distinct q_id, qno,q_type from question_detail where qset_id=$qset AND q_type in ('radio', 'checkbox', 'rating' )");
                        $result=$query->result();
                        if($result)
                                return $result;
                        else
                                return false;
                }

                public function getPQsf($qset=null)
                {

                        $query=$this->db->query("select distinct q_id, qno,q_type from question_detail where q_id in (SELECT distinct `qid` FROM `question_sequence` WHERE `qset_id`=$qset AND `chkflag`=1)");
                        $result=$query->result();
                        if($result)
                                return $result;
                        else
                                return false;
                }

	        public function getPQop($qid=null)
	    	{
	       		
	       		$this->db->select('*');
		        $query=$this->db->get_where('question_option_detail', array('q_id'=>$qid));
		        $result=$query->result();
		        if($result)
		        	return $result;
		        else
		        	return false;
	    	}
	        public function getQType($qid=null)
	    	{
	       		
	       		$this->db->select('*');
		        $query=$this->db->get_where('question_detail',array('q_id' => $qid));
		        $result=$query->row();
		        if($result)
		        	return $result->q_type;
		        else
		        	return false;
	    	}
	//---------------Return to Controller as UI ------------------------------------------------------------------------------------------------------
		    public function getviewqnre()
        	{
              		$projects=$this->getProjects();
			//$str="<div class='container well '><div class='col-lg-9 col-xl-9 col-sm-6 col-md-9'>";
			$str="<div class='text-center'><label class='form-label'>VIEW QUESTIONNAIRE</label></div> <br>";
             		$str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
              		foreach($projects as $p)
              		{ $pid=$p->project_id; $pn=$p->name;
                     		$str.="<option value=$pid > $pn </option>";
              		}
              		$str.="</select><br> Question Set: <select  class='form-control' name=qset id=qset><option value=select>--Select--</option> </select><br>";
              		$str.=" Translated Language: <select  class='form-control' name=tl id=tl><option value=0> English </option> </select> <br><input  class='btn btn-primary' type=submit value=View> ";
			$str.="</div></div>";
              		return $str;
		
        	}
        public function getQnreDetail($qset,$tl)
        {
              $ppn = $this->get_project_name($qset);
              $sqle = "select a.q_id, a.q_title, a.q_type,a.qno, b.chkflag from question_detail as a LEFT JOIN question_sequence as b on a.q_id=b.qid where 
b.qset_id=$qset order by b.sid ";
              $qs = $this->getDataBySql($sqle);
            
              $str = "<div class='text-center'> PROJECT: <b>$ppn</b> </div> <table style='border-collapse: collapse;'><tr style='border-bottom: 1px solid #ddd;'><td colspan=3 align='center' style='color:green'> </td> </tr> 
<tr style='border-bottom: 1px solid #ddd;'><td>SN</td><td style='width:15%'>QNO/QID</td><td>DETAILS</td></tr>";
              $k=0;
			if($qs){
              foreach($qs as $p)
              { $k++;
                     $str1 = '';$str2='';$str3='';$str4='';
                     //$str1 ="<tr><td>SN</td><td>QNO/QID</td><td>DETAILS</td></tr>";
                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno; $chkflag = $p->chkflag;
                     $tqt='';
                     //start translated question details
                     $sql = "select q_title from question_detail where q_id=$qid";
                     if($tl==1) $sql = "select q_title from hindi_question_detail where q_id=$qid";
                     if($tl==2) $sql = "select q_title from kannar_question_detail where q_id=$qid";
                     if($tl==3) $sql = "select q_title from malyalam_question_detail where q_id=$qid";
                     if($tl==4) $sql = "select q_title from tammil_question_detail where q_id=$qid";
                     if($tl==5) $sql = "select q_title from telgu_question_detail where q_id=$qid";
                     if($tl==6) $sql = "select q_title from bengali_question_detail where q_id=$qid";
                     if($tl==7) $sql = "select q_title from odia_question_detail where q_id=$qid";
                     if($tl==8) $sql = "select q_title from gujrati_question_detail where q_id=$qid";
                     if($tl==9) $sql = "select q_title from marathi_question_detail where q_id=$qid";
                     if($tl==10) $sql = "select q_title from asami_question_detail where q_id=$qid";
                     $qsq=$this->getDataBySql($sql);
                     if($qsq )
                     foreach($qsq as $qs){
                         $tqtt=$qs->q_title; 
			 if($tl>=1)$tqt="<br><p style='font-family:mangal;'>[ $tqtt ]</p>";
                     }
                     //end trans question details
                     //To display routine details
                     if($chkflag == 1){
                        $pqid_arr = $this->getPQRoutine($qid); 
			foreach($pqid_arr as $pqida){
                          $clist='';$cqid='';$tlist='';$tqid='';
                           $arrr = $this->getQRoutine($qid,$pqida);
			    if(!empty($arrr)){ 
                          $clist=$arrr['c']; $cq=$arrr['cqid']; $tlist=$arrr['t']; $tq=$arrr['tqid'];
                          if($clist!='') $str1 .= "<tr style='border-bottom: 1px solid #ddd;'><td></td><td colspan=2 style='color:blue;'> <br>[CONTINUE to ask question $qn / $qid only if any options 
$clist is selected at QID $cq ELSE skip it ] </td></tr>";
                          if($tlist!='') $str1 .= "<tr style='border-bottom: 1px solid #ddd;'><td></td><td colspan=2 style='color:blue;'> [And TERMINATE question $qn / $qid if any options $tlist is 
selected at QID $tq ]</td></tr>";

			     } //end of if arrr	
			  } //end of foreach
                     } // end of if chkflag
                     //To display question details
                      $str1 .= "<tr style='border-bottom: 1px solid #ddd;'><td> $k </td><td style='color:red;'> $qn / $qid / $qt </td><td> $t $tqt </td></tr>";
                      $str .= $str1;
                      
                     if($qt == 'radio' || $qt == 'checkbox')
                     { $str2='';
                         
                         $rs1=$this->getPQop($qid);
                         if(is_array($rs1)){
                         foreach($rs1 as $qop)
                         {
                             $op_text=$qop->opt_text_value;
                             $op_value=$qop->value;
                             $term=$qop->term;
                             $f = $qop->flag;

                                  // $str2 .= "<tr><td></td><td style='color:lightgray;'>$op_value :: $term</td><td style='color:gray;'>  $op_text </td></tr>";
				$str2 .= "<tr ><td></td><td style='color:lightgray;'>$term</td><td style='color:gray;'> $op_value . $op_text --flag: $f </td></tr>";
                         }}
                         $str .= $str2;
                     }
                     //$str.="</li><br>";
                     if($qt=='rating')
                     { $str3='';
                         
                         $rs2=$this->getPQop($qid);
                         if(is_array($rs2))
                         foreach($rs2 as $qop2)
                         {
                             $ssv=$qop2->scale_start_value;
                             $sev=$qop2->scale_end_value;
                             $ssl=$qop2->scale_start_label;
                             $sel=$qop2->scale_end_label;
                             //$op_value=$qop2->value;
                             $term=$qop2->term;
                                   $str3.="<tr><td></td><td>$term</td><td style='color:gray;'> $ssl / $ssv <--------------------> $sev / $sel  </td></tr>";
                         }
                         $str .= $str3;
                     }
                     if($qt=='text' || $qt=='textarea')
                     { $str4='';

                         $rs3=$this->getPQop($qid);
                         if(is_array($rs3))
                         foreach($rs3 as $qop3)
                         {
                             $term=$qop3->term;
                                   $str4.="<tr><td></td><td style='color:lightgray;'>$term</td><td style='color:gray;'>  </td></tr>";
                         }
                         $str .= $str4;
                     }

                    // $str.="</li><br>";
              }
			} else $str.='Error! To View quesnnaire only after adding, Sequence & Routine';
               $str .= '</table>';
              return $str;
        }
        public function getPQRoutine($qid=null)
        {
                $arr=array();
                $result=$this->getDataBySql("select distinct pqid from question_routine_check where qid = $qid ;");
                //$result=$query->result();
                if($result){
                        foreach($result as $v1){
                          $q = $v1->pqid;
			  array_push($arr,$q);
			}
		}
		return $arr;
	}
        public function getQRoutine($qid=null, $pqid=null)
    	{
       		$arr=array(); $str1=''; $str2='';
       		$this->db->select('*');
                $query=$this->db->get_where('question_routine_check',array('qid' => $qid,'pqid' => $pqid, 'flow !=' => 0));
                //$this->db->where_not_in('question_routine_check',array('flow' => 0));
	        //$query=$this->db->get_where('question_routine_check',array('qid' => $qid, 'flow' => 0));
	        $result=$query->result();
	        if($result){
                        $i=0; $q1=0; $str1='';
			$arr['tqid']= $pqid;
	        	foreach($result as $v1){
                           $opv = $v1->opval;
                           if($i > 0) $str1.=",";
                           $str1 .= $opv;
                           $i++;
                        }
                       //$arr['tqid'] = $q1;
                       $arr['t'] = $str1;
                }
		
	        else{
                       $arr['tqid'] = '';
                       $arr['t'] = '';
                }
		
       		$this->db->select('*');
	        $query2=$this->db->get_where('question_routine_check',array('qid' => $qid, 'pqid' => $pqid, 'flow' => 0));
	        $result2=$query2->result();
	        if($result2){
                        $j=0; $q2=0; $str2='';
			$arr['cqid']= $pqid;
	        	foreach($result2 as $v2){
                           $opv2 = $v2->opval;
                           if($j > 0) $str2 .= ",";
                           $str2 .= $opv2;
                           $j++;
                        }
                       //$arr['cqid'] = $q2;
                       $arr['c'] = $str2;
                }
                else{
                       $arr['cqid'] = '';
                       $arr['c'] = '';
                }
		
                return $arr;
    	}
	        public function getviewproject()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project <select class='form-control' name='pid' id='pid' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> <br> <input class='btn btn-primary' type=submit value=View>";
	              return $str;
	        }   
	        public function getviewqb()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project <select class='form-control' name='pid' id='pid' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> <input class='btn btn-primary' type=submit value=View>";
	              return $str;
	        } 
	        public function getviewquestion()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> VIEW QUESTION DETAILS </label></div><br>";
	              $str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select name=qset class='form-control' id=qset required><option value=''>--Select--</option> </select><br> <input type=submit class='btn btn-primary'  value=View>";
	              return $str;
	        }
	        public function getviewquestionop()
	        {
	              $projects=$this->getProjects();
	              $str="<div class='well text-center'><label class='form-label'> VIEW QUESTION OPTION</label></div><br>";
	              $str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select name=qset class='form-control' id=qset required><option value=''>--Select--</option> </select><br> <input type=submit class='btn btn-primary' value=View>";
	              return $str;
	        }
	        public function getviewsequence()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> VIEW QUESTIONNAIRE SEQUENCE</label></div><br>";
	              $str.="Project: <select name='pn' id='pn' class='form-control' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> <br> Question Set: <select name=qset class='form-control' id=qset><option value=select>--Select--</option> </select><br> <input type=submit class='btn btn-primary' value=View>";
	              return $str;
	        }
	        public function getviewroutine()
	        {
	              $projects=$this->getProjects();
                      $str="<div class='text-center bg-primary'><label class='form-label'> VIEW QUESTIONNAIRE ROUTINE</label></div><br>";
	              $str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> <br> Question Set: <select name=qset class='form-control' id=qset required><option value=''>--Select--</option> </select><br> <input type=submit class='btn btn-primary' value=View>";
	               
	              return $str;
	        }
	        public function getviewpcentre()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> VIEW PROJECT CENTRE'S DETAILS</label></div><br>";
	              $str.="Project: <select name='pn' id='pn' class='form-control' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br>  Question Set: <select name=qset class='form-control' id=qset required><option value=''>--Select--</option> </select><br> <input type=radio name=rt class='form-control' value=1>Centre <input type=radio class='form-control' name=rt value=0 checked>Store <input type=radio class='form-control' name=rt value=2>Product <input type=radio class='form-control' name=rt value=3>SEC <input type=submit class='btn btn-primary' value=View>";
	              return $str;
	              
	        }
                public function getviewprule()
                {
                      $projects=$this->getProjects();
                      $str="<div class='text-center bg-primary'><label class='form-label'> VIEW PROJECT RULE DETAILS</label></div><br>";
                      $str.="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
                      foreach($projects as $p)
                      { $pid=$p->project_id; $pn=$p->name;
                             $str.="<option value=$pid > $pn </option>";
                      }
                      $str.="</select> Question Set: <select name=qset class='form-control' id=qset required><option value=''>--Select--</option> </select> <select name=rt class='form-control'>
<option value=1> 
Rule for PSM in Order </option><option value=2> Rule for Quata </option><option value=3> Rule for Grid </option><option value=4> Questions with AND 
</option><option value=5> Show Selected Op Only </option> <option value=6> Hide Selected Op Only </option><option value=7>Question word Find&Replace</option>
<option value=8>Q.Option autoselect based on entered number</option><option value=9>Dropdown Number limit</option><option value=10>Question Recording</option> </select> <input type=submit class='btn btn-primary' value=View>";
                      return $str;

                }

	        public function geteditproject()
	        {

	              $projects=$this->getProjects();
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT PROJECT DETAILS</label></div><br>";
	              $str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select> <br><br> <input class='btn btn-primary' type=submit value=View>";
	              return $str;
	        }

	        public function geteditquestion()
	        {
	              $projects=$this->getProjects();
	              $ss="<a href='https://digiadmin.quantumcs.com/vcimsweb/QuestAdmin/edit_question.php' target='_blank'>Edit Question</a><br><br>";
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT QUESTIONS</label></div><br>";
	              $str.="$ss Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select> <input type=submit class='btn btn-primary' value=View>";
	              return $str;
	        }
	        public function geteditquestionop()
	        {
	              $projects=$this->getProjects();
	              $ss1="<a href='https://digiadmin.quantumcs.com/vcimsweb/QuestAdmin/edit_question_option.php' target='_blank'>Edit Question Options</a><br><br>";
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT QUESTION OPTION</label></div><br>";
	              $str.="$ss1 Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              {
			     $pid=$p->project_id;
			     $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> <br>Question Set: <select class='form-control' name=qset id=qset onclick='getpeditqs();' required><option value=''>--Select--</option> </select> <br><select class='form-control' name=qs id=qs><option value=0>--Select--</option> </select><br> <input class='btn btn-primary' type=submit value=View>";
	              return $str;
	        }
	        public function geteditsequence()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT PROJECT SEQUENCING</label></div><br>";
	              $str.="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select> <input type=submit class='btn btn-primary' value=View><span id=msg></span>";
	              return $str;
	        }
	        public function getupdatesequence()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> UPDATE SEQUENCING </label></div><br>";
	              $str.="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset(); getmaxpsid();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              {
			     $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select> <br><br> From SID
<input class='form-control' type=number id=ssid name=ssid value='1' placeholder='start sid' required> <br>To SID <input class='form-control' type=number id=esid name=esid value=1 placeholder='end sid' required> <br> Step value:<input class='form-control' type=number id=num name=num value=1 placeholder='enter step value' required> <br><br><input class='btn btn-primary' type=submit value='Update-Increase' name='submit'> <input class='btn btn-primary' type=submit value='Update-Decrease' name='submit'>";
	              return $str;
	        }
	        public function geteditroutine()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT ROUTING</label></div><br>";
	              $str.="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset reqired><option value=''>--Select--</option> </select> <input type=submit class='btn btn-primary' value=View>";
	              return $str;
	        }
	        public function geteditpcentre()
	        {
	              $projects=$this->getProjects();
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT PROJECT CENTRE</label></div><br>";
	              $str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select> <input type=radio name=rt value=1>Centre <input type=radio name=rt value=0 checked>Store <input type=radio name=rt value=2>Product <input type=radio name=rt value=3>SEC <input type=radio name=rt value=4>Age <br> <input type=submit class='btn btn-primary' value=View>";
	              return $str;
	        }
                public function geteditpfp()
                {
                      $projects=$this->getProjects();
                      $str="<div class='text-center bg-primary'><label class='form-label'> EDIT PROJECT FIRST PAGE</label></div><br>";
                      $str.="Project: <select class='form-control' name='pn' id='pn' required> <option value=''>--Select--</option>";
                      foreach($projects as $p)
                      { $pid=$p->project_id; $pn=$p->name;
                             $str.="<option value=$pid > $pn </option>";
                      }
                      $str.="</select> <br> <input type=submit class='btn btn-primary' value=View First Page>";
                      return $str;
                }

	        public function getcreateproject()
	        {
	                $projects=$this->getProjects();
					$researchtype=$this->getResearchTypes();
					

					

	                $str="<table width='100%'>";
		
					$str.="<tr> <td colspan=2 style='height:50px;'> <div class='text-center bg-primary'> CREATE NEW PROJECT <div> </td> </tr>";
					$str.="<tr><td> App Types <span style='color: red'>*</span> </td><td><select name='select_project_types' id='select_project_types' class='form-control'onchange='createProjectTypes(this.value)' required>  <option value=''>--Select Project Types--</option> <option value='servegenix'>Surveygenics</option> <option value='insightfix'>InsightFix</option></select></td></tr>";
					$str.="<tr id='tr_proj_name' style='display: none'><td>Project Name <span style='color: red'>*</span></td> <td> <input type=text class='form-control' name=pname id=pname onkeypress='return IsAlphaNumber(event);' required  placeholder = 'Enter Project Name'>  <span id=error style='color: Red; display: none'> Space or any Special Characters does not allowed </span></td></tr>";
	                $str.="<tr id='tr_brand_name' style='display: none'><td>Brand <span style='color: red'>*</span> </td><td><input type=text class='form-control' name=brand id=brand  placeholder = 'Enter Brand Name'></td></tr>";
	                $str.="<tr id='tr_client_name' style='display: none'><td>Client Company Name <span style='color: red'>*</span> </td><td><input class='form-control' type=text name=ccn id=ccn placeholder = 'Enter Company Name' ></td></tr>";
					$str.="<tr id='tr_response_types' style='display: none'><td>Response Type <span style='color: red'>*</span> </td><td><select name='response_types' id='response_types' class='form-control' required>  <option value='0'>Survey</option> <option value='1'>Profiler</option> </select></td></tr>";
					
					
					
					$str.="<tr id='tr_research_name' style='display: none'><td>Research Type <span style='color: red'>*</span> </td><td> <select name='reserch_type' id='reserch_type' class='form-control' required > ";
						foreach($researchtype as $rtv)
						{ 
								$str.="<option value=$rtv->id > $rtv->survey_name</option>";
						}
	             
					
	                $str.="<tr id='tr_questionversion_name' style='display: none'><td>Questionnare Version  </td><td><input type=text class='form-control' name=bd id=bd placeholder='Enter questinnare version' ></td></tr>";
	                $str.="<tr id='tr_samplesize_name' style='display: none'><td>Survey Sample Size <span style='color: red'>*</span> </td><td><input type=text maxlength ='3' onkeypress='if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;' class='form-control' name=ss id=ss placeholder='Enter survey size' ></td></tr>";
	                $str.="<tr id='tr_rewardpoint_name' style='display: none'><td>Reward Point </td><td><input type=number name=rp class='form-control' id=rp placeholder='Enter reward point' ></td></tr>";
	                $str.="<tr id='tr_surveyround_name' style='display: none'><td>Total Survey Round  </td><td><input type=number class='form-control' name=visit id=visit placeholder='Enter survey round' ></td></tr>";
	                $str.="<tr id='tr_survestartdate' style='display: none'><td>Start Survey Date <span style='color: red'>*</span> </td><td><input type=date class='form-control' name=ssdt id=ssdt required ></td></tr>";
	                $str.="<tr id='tr_survenddate' style='display: none'><td>End Survey Date <span style='color: red'>*</span> </td><td><input type=date class='form-control' name=esdt id=esdt required ></td></tr>";
					
					$str.="<tr id='tr_surveytypes_name' style='display: none'><td> Survey types <span style='color: red'>*</span> </td><td><select name='survey_type' id='survey_type' class='form-control'onchange='surveyType(this.value)'> <option value='0'>Single survey</option>  <option value='1'>Multiple Survey</option> </select></td></tr>";
					$str.="<tr id='surve_occurance' style='display: none'><td> Survey Occurrence <span style='color: red'>*</span> </td><td><select name='survey_occurrence' id='survey_occurrence' class='form-control' style='display: none'> <option value='everyday'>Every Days</option>  <option value='weekly'>Weekly</option> <option value='monthly'>Monthly</option> </select></td></tr>";
					$str.="<tr id='surve_time' style='display: none'><td> Survey  Occurrence Times <span style='color: red'>*</span> </td><td><select name='survey_times' id='survey_times' class='form-control' style='display: none'> <option value='1'>Single Times</option>  <option value='2'>Two times</option> <option value='3'>Three times</option> </select></td></tr>";

					$str.="<tr id='occurance_time' style='display: none'><td>Enter Survey Time <span style='color: red'>*</span> </td><td><input class='form-control' type=text name=occurancetimes id=occurancetimes placeholder= 'Enter time like 8AM, 10PM'></td></tr>";
					$str.="<tr id='restrict_occurance' style='display: none'><td>Restrict occurance hours  </td><td><input type=number class='form-control' name=restictHour id=restictHour placeholder= 'Minimum Time Duration Between two Survey'></td></tr>";
 
					
					/* $str.="<tr><td>Project Category * </td><td><select name=pcat id=pcat><option value=0>--Select--</option><option value=1>HFD 
Consumer</option><option value=2>Milk Product Consumer</option><option value=3>Wine Consumer</option><option value=4>KFC Product Consumer</option><option 
value=5>Electronic Product Consumer</option><option value=6>Ola</option><option value=7>Others</option></select></td></tr>";
	                */
			$str.="<tr id='tr_firstpage_info' style='display: none'><td>App First Page Details <span class='text-danger'>*</span> </td><td><div class='multiselect'> <div class='selectBox' onclick='showCheckboxes()'> <select> 
<option>Select First Page options</option></select> <div class='overSelect'></div></div> <div id='fp'>";
             $fplist=$this->getProjectFirstPageList();
			foreach($fplist as $f)
			{
				$fpid=$f->id;
				$fptitle=$f->title;
				$fpterm=$f->term;
                            $str.="<label for='$fpterm'><input type='checkbox' name='fp[]' id='$fpterm' value='$fpid'> $fptitle </label>";
			}
			$str.=" </div> </div> </td></tr>";
			$str.="<tr><td colspan=2><center><input type=submit class='btn btn-primary' name='cp_submit' id='cp_submit' onclick='return(validateproject());' value='CreateProject'> 
</center></td></tr>";
			$str.="</div></div></div>";
	              return $str;
	              
	        }
	        public function getcreateqset()
	        {
	              $projects=$this->getProjects();
	              
                      //$str="<div class='container'><div class='row mx-5'><div class='col' >";
                      $str="<div class='text-center p-5 bg-primary'> CREATE PROJECT QUESTIONSET </div><br>";
	              $str.="<br> Project: <select name='pn' class='form-control' id='pn' required> ";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> <br>Visit: <select class='form-control' name=visit id=visit><option value=1>1</option></select> <br><input class='btn btn-primary' type=submit class='btn btn-primary' name=qs_submit onclick=return confirm('Are you sure?'); value='Submit'>";
		      $str.="</div></div></div>";
	              return $str;
	              
	        }
	        public function getcreatequestion()
	        {
	              $projects=$this->getProjects();

	              $str="<br><br><table width='100%'><tr> <td colspan=2 style='height:50px;'> <div class='text-center p-3 bg-primary'> CREATE NEW QUESTION <div> </td></tr><tr><td>Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid ";
			     if(isset($_SESSION['pid']) && $_SESSION['pid'] == $pid ) $str.= ' selected'; 
			     $str.= "> $pn </option>";
	              }
	              $str.="</select></td><td> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select Qset ID--</option>"; 

                 if( isset($_SESSION['qset']) ){
				$qset=$_SESSION['qset'];
				$str.= "<option value=$qset selected >$qset </option>";
			     }
		      $str.="</select></td></tr>";
	              $str.="<tr><td>Question Type * </td><td> <select class='form-control' name='qt' id='qt' onchange='getpqt();' required><option value=''>Select</option> <option 
value='text'>Open Ended [Text]</option><option value='textarea'>Open Ended MultipleLine [TextArea]</option><option value='radio'>Single Choice 
[Radio]</option><option value='checkbox'>Multiple Choice [CheckBox]</option><option value='instruction'>Instruction</option><option value='dropdown'>Num 
Dropdown List(0-30)</option><option value='rating'>Rating </option><option value='image'>Image Capture</option><option value='audio'>Audio 
Capture</option><option value='video'>Video Capture</option><option value='imaged'>Display Instruction with Image</option><option value='audiod'>Play Audio with 
Instruction</option> <option value='videod'>Play Video with Instruction</option><option value='old_sec'>Old SEC</option><option value='new_sec'>New SEC</option></select>
<div id=oplist style='display:none;'> Total Options<input type=number class='form-control' name=cnt id=cnt style='width:70px;' onchange='generate();'> </div> <a href='http://localhost/digiamin-web/siteadmin/user_action/createquestion'> RESET ALL</a> </td></tr>";
			$str.="<tr><td>Mark as SHOW CARD [optional]</td><td><select class='form-control' name=sc><option value='0'>No</option> <option value='1'>Yes</option> </select></td></tr>";
			$str.="<tr><td>Timestamp Capture Required </td><td><select class='form-control' name=ts><option value='0'>No</option> <option value='1'>Yes</option></select> </td></tr>";
	                $str.="<tr><td>Question S.No *</td><td> <input type='text' class='form-control' name='qno' id='qno' placeholder='question serial no' onkeypress='return 
IsAlphaNumber(event)' ondrop='return false;' onpaste='return false;' style='width:200px;' required> <span id='error' style='color: Red; display: none'>* Special 
Characters not allowed </td></tr>";
	                $str.="<tr><td>Question Title *</td><td> <textarea class='form-control' rows='5' cols='30' name='qtitle' id='qtitle' placeholder='type new question here' 
onpaste='return IsNotAlphaNumber(event)' required></textarea> <span id='qerror' style='color: Red; display: none'>* Special Characters not allowed , retype it 
again</td></tr>";

	                $str.="<tr><td></td><td><div id='pqid' style='display:none;'> </div></td></tr>";

	                $str.="<tr><td></td><td><div id='rat' style='display:none;'><hr> <p>Specify Rating Option's List</p>Scale : From <input type='number' 
name='froms' min='0' max='1' > To <input type='number' min='1' max='10' name='tos'><br>Start Rating :<input type='text' name='lfroms' placeholder='Rating Start 
Label'><br>End Rating : <input type='text' name='ltos' placeholder='Rating End Label'><br></div></td></tr>";
	                
	                $str.="<tr><td colspan='2'><center><input class='btn btn-primary' type='submit' name='nq_submit' value='Submit'></center></td></tr></table>";
			$str.="</div></div></div>";
	              return $str;
	              
	        }
	        public function getcreatesequence()
	        {
	              $projects=$this->getProjects();
	              
                      //$str="<div class='container'><div class='row mx-3'><div class='col' >";
                      $str="<div class='text-center p-5 bg-primary'> CREATE PROJECT QUESTION'S SEQUENCE </div><br>";
	              $str.="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select> <br><input type=submit class='btn btn-primary' value=View>";
			$str.="</div></div></div>";
	              return $str;
	        }
	        public function getcreateroutine()
	        {
	              $projects=$this->getProjects();
	              $str="<br><br><table width='100%'><tr> <td colspan=2 style='height:50px;'> <div class='text-center p-3 bg-primary'> CREATE PROJECT ROUTING <div> </td></tr><tr><td>Project: <select name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     //$str.="<option value=$pid > $pn </option>";
                             $str.="<option value=$pid ";
                             if(isset($_SESSION['pid']) && $_SESSION['pid'] == $pid ) $str.= ' selected';
                             $str.= "> $pn </option>";

	              }
	              $str.="</select></td><td> Question Set: <select class='form-control' name=qset id=qset onclick='getpqs();getpqsf();' required><option value=''>--Select--</option>";
 			     if( isset($_SESSION['qset']) ){
                                $qset=$_SESSION['qset'];
                                $str.= "<option value=$qset selected >$qset </option>";
                             }

			$str.="</select></td></tr>";
	              $str.="<tr><td>Question ID </td><td> <select name=qs[] class='form-control' id=qid multiple required> <option value=''>--Select--</option></select> </td></tr>";
	             $str.="<tr><td>Check for Question ID </td><td> <select name='pqid' id='pqid' ondblclick='getpqop();' onChange='getpqop();' required> <option value=''> --Select-- </option></select> </td></tr>";
	             $str.="<tr><td colspan=2><div id='oplist' style='color:blue;'></div></td></tr>";
	             $str.="<tr><td></td><td><input type=submit class='btn btn-primary' name=rsubmit value=Update></td></tr></table>";
	
	              return $str;
	              
	        }
	        public function getcreateqbcat()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Category Name: <input type=text name='catname' id='catname'>";
	             
	              $str.="<input type=button id=cnew value=Create onClick =cat('catn','');> <input type=button id=cview value=View onClick =cat('catv','');> 
<span id='msg'></span>";
	              return $str;
	              
	        }

	     	public function getProjectShowcards($pid)
		{
			$str = "<br><br><br> <div class='content' style='margin-left: 4%; font-size: 12px;'><div class='well col-lg-11'>";
                      $ppn=$this->get_project_name($pid);
                      $str.="<br> <center><h5>SHOWCARDS FOR PROJECT - $ppn </h5> </center><br><br>";

		   $ddd = $this->getDataBySql("SELECT * FROM project_showcard WHERE qset = $pid ");
		   if($ddd)
		   foreach($ddd as $d)
		   {
				$qid= $d->qid;
				//display below the question with options as showcards
				$str.="<br><br> <hr> ";
		      $qs=$this->getDataBySql("Select * from question_detail where q_id = $qid order by q_id");
	              foreach($qs as $p)
	              {
			     $str1='';
	                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno;
	                     $str1.="<li> <font color=red> $qn  </font> <br><b> $t </b>";
	                     $str.=$str1;
	                     if($qt=='radio' || $qt=='checkbox')
	                     {
			 	 $str2='';
	                         $rs1=$this->getPQop($qid); //print_r($rs1);
	                         if(is_array($rs1))
	                         foreach($rs1 as $qop)
	                         {
	                             $op_text=$qop->opt_text_value;
	                             $op_value=$qop->value;
	                             $term=$qop->term;
				     $f = $qop->flag; 
	                                   $str2.="<br>&nbsp;&nbsp;&nbsp; $op_value. $op_text ";
	                         }
	                         $str.=$str2;
	                     }
	                     $str.="</li><br>";
	              }
				//end of display question option details
		   } //end of foreach for question list
			echo $str;
		}

  		public function getProjectDetail($pid)
	        {
	              $projects=$this->getProject($pid);
			$qtc = $this->get_project_ques_type_count($pid);
			$qcnt = $this->get_project_ques_count($pid);
			$qscnt = $this->get_project_seq_count($pid);
			$qrcnt = $this->get_project_routing_count($pid);
			$login=$this->session->userdata('sauserid');

			$login_user='NA';

			$qtc.="<br>Total: $qcnt";

	              $str = "<br><br><br> <div class='content' style='margin-left: 2%; font-size: 12px;'><div class='well col-lg-12'>";
	              $str.=" <b>Project Details</b> <br><table border='1' class='table' style='font-size: 12px;'><tr><td>Project ID</td><td>Name</td><td> Field Start Date</td><td>Field End Date</td><td>Client Company</td><td>Brand</td><td>Qnr. Ver. No </td><td>Sample Size</td><td>Research Type</td><td>Visit</td><td>Reward 
Points</td><td>Table</td><td>Created By</td><td>Created At</td><td>Updated At</td> <td>Total Questions </td><td> Sequencing Status</td> <td>Routing Status</td> <td>Status</td></tr>";
	              foreach($projects as $p)
	              {
				$pid=$p->project_id; $pn=$p->name; $cn=$p->company_name; $b=$p->brand; $bk=$p->background; $ss=$p->sample_size; $rt=$p->research_type; 
				$v=$p->tot_visit;
	                     $sdt=$p->survey_start_date;$edt=$p->survey_end_date; $rp=$p->reward_point; $dt=$p->data_table;$st=$p->status;
				$cdt=$p->created_at; $udt=$p->updated_at; $uid=$p->uid;
				
				if($uid !='' || $uid != null ) $login_user = $this->get_login_user_name($uid);

	                     if($st==1) $stt="Active";if($st==0) $stt="Not Active";

			     //to get the project achieved data count
				$pdc = $this->get_project_survey_data_count($dt);
				//append achieved data to the sample size
				$ss.="<br><br> Achieved SS:<br> $pdc ";
	                     $str.="<tr><td>$pid </td><td> $pn 
</td><td>$sdt</td><td>$edt</td><td>$cn</td><td>$b</td><td>$bk</td><td>$ss</td><td>$rt</td><td>$v</td><td>$rp</td><td>$dt</td><td>$login_user</td> <td> $cdt </td><td> $udt </td> <td> $qtc </td><td> $qscnt </td><td> $qrcnt </td>  <td>$stt</td></tr>";
	              }
	              $str.="</table> </div>";
	              return $str;
	        }
	        public function getQuestionDetail($qset)
	        {
	              $ppn=$this->get_project_name($qset);
	              $qs=$this->getDataBySql("Select * from question_detail where qset_id=$qset order by q_id");
	              $str=" <h5>QUESTION DETAILS - Project- $ppn </h5> <br><table border=1 style='font-size: 9px;'> <tr bgcolor=lightgray><td>Q_ID</td><td>Q_NO</td><td>Title</td><td>Type</td><td>Image</td><td>Audio</td><td>Video</td> <td>User</td> <td> Created At</td> <td> Updated At</td> </tr>";
	              foreach($qs as $p)
	              {
	                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno;$qi=$p->image; $qa=$p->audio; $qv= $p->video;
				$c_dt=$p->created_at; $u_dt=$p->updated_at; $cr_uid=$p->uid;
                                if($c_dt == '' || $c_dt == null ) $c_dt='NA';
                                if($u_dt == '' || $u_dt == null ) $u_dt='NA';
                                $cr_nm='NA';
                                if($cr_uid !='' || $cr_uid != null) $cr_nm= $this->get_login_user_name($cr_uid);

	                     $str.="<tr><td>$qid </td><td>$qn</td><td> $t </td><td>$qt</td><td> $qi </td><td>$qa </td><td>$qv </td> <td> $cr_nm </td> <td> $c_dt </td> <td> $u_dt </td> </tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function getQuestionOpDetail($qset)
	        {
	              $ppn=$this->get_project_name($qset);
	              $qs=$this->getDataBySql("Select * from question_detail where qset_id=$qset order by q_id");
	              $str='';
	              $str="<center><h5>Project- $ppn :: Question Options Details</h5> </center><br><br>";
	              foreach($qs as $p)
	              { $str1='';
	                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno;
				$c_dt=$p->created_at; $u_dt=$p->updated_at; $cr_uid=$p->uid;
                                if($c_dt == '' || $c_dt == null ) $c_dt='NA';
                                if($u_dt == '' || $u_dt == null ) $u_dt='NA';
                                $cr_nm='NA';
                                if($cr_uid !='' || $cr_uid != null) $cr_nm= $this->get_login_user_name($cr_uid);

	                     $str1.="<li> <font color=red> $qn / $qid = $qt </font> <br> [ <font color=blue size='1px'> User Name: $cr_nm , Created At: $c_dt, Updated At: $u_dt </font> ]<br> <b> $t </b>";
	                      $str.=$str1;
	                     if($qt=='radio' || $qt=='checkbox')
	                     {
			 	 $str2='';
	                         $rs1=$this->getPQop($qid); //print_r($rs1);
	                         if(is_array($rs1))
	                         foreach($rs1 as $qop)
	                         {
	                             $op_text=$qop->opt_text_value;
	                             $op_value=$qop->value;
	                             $term=$qop->term;
				     $f = $qop->flag; 
	                                   $str2.="<br>&nbsp;&nbsp;&nbsp; $op_value -- $op_text -- $term -- flag: $f ";
	                         }
	                         $str.=$str2;
	                     }
	                     $str.="</li><br>";
	              }
	              return $str;
	        }
	        public function getSequenceDetail($qset)
	        {
	              $ppn=$this->get_project_name($qset);
	              $qs=$this->getDataBySql("SELECT * FROM `question_sequence` WHERE `qset_id`=$qset order by sid");
	              
	              $str="Project- $ppn Sequence Details</h5> <br><br><table border=1> <tr 
bgcolor=lightgray><td>QSET_ID</td><td>Q_ID</td><td>SID</td><td>ROUTINE FLAG</td> <td>User Name </td> <td> Created At</td> <td> Updated At</td> </tr>";
			if($qs)
	              foreach($qs as $p)
	              {
	                     $qid=$p->qid; $sid=$p->sid; $f=$p->chkflag;
				$c_dt=$p->created_at; $u_dt=$p->updated_at; $cr_uid=$p->uid;
                                if($c_dt == '' || $c_dt == null ) $c_dt='NA';
                                if($u_dt == '' || $u_dt == null ) $u_dt='NA';
                                $cr_nm='NA';
                                if($cr_uid !='' || $cr_uid != null) $cr_nm= $this->get_login_user_name($cr_uid);

	                     $str.="<tr><td>$qset </td><td>$qid</td><td> $sid </td><td>$f</td><td> $cr_nm </td> <td> $c_dt </td> <td> $u_dt </td> </tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function getRoutineDetail($qset)
	        {
	              $ppn=$this->get_project_name($qset);
	              $qs=$this->getDataBySql("SELECT * FROM `question_routine_check` WHERE `qset_id`=$qset order 
by qid, opval");
	              
	              $str="Project- $ppn Routine Details</h5> <br><br><table border=1> <tr 
bgcolor=lightgray><td>QSET_ID</td><td>Q_ID</td><td>PQ_ID</td><td>OP_VALUE</td><td>FLAG</td> <td>User Name </td> <td> Created At</td> <td> Updated At</td> </tr>";
	              foreach($qs as $p)
	              {
	                     $qid=$p->qid; $pqid=$p->pqid; $ov=$p->opval; $f=$p->flow;
				$c_dt=$p->created_at; $u_dt=$p->updated_at; $cr_uid=$p->uid;
				if($c_dt == '' || $c_dt == null ) $c_dt='NA';
                                if($u_dt == '' || $u_dt == null ) $u_dt='NA';

				$cr_nm='NA';
				if($cr_uid !='' || $cr_uid != null) $cr_nm= $this->get_login_user_name($cr_uid);

	                     $str.="<tr><td>$qset </td><td>$qid</td><td> $pqid </td><td>$ov</td><td>$f</td> <td> $cr_nm </td> <td> $c_dt </td> <td> $u_dt </td> </tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function getPCentreDetail($qset,$rt)
	        { $str='';
	              $ppn=$this->get_project_name($qset);
	              //for store
	              if($rt==0)
		      {
		              $qs=$this->getDataBySql("SELECT `id`, `qset_id`, `store`, `valuee` FROM `project_store_loc_map` WHERE `qset_id`=$qset order by 
valuee");
		              
		              $str="Project- $ppn :: Store Details</h5> <br><br><table border=1> <tr 
bgcolor=lightgray><td>QSET_ID</td><td>STORE</td><td>CODE</td></tr>";
		              foreach($qs as $p)
		              {
		                     $s=$p->store; $t=$p->valuee;
		                     $str.="<tr><td>$qset </td><td>$s</td><td> $t </td></tr>";
		              }
		              $str.="</table>";
	              }
	              //for centre
	               if($rt==1)
		      {
		              $qs=$this->getDataBySql("SELECT `id`, `centre_id`, `project_id`, `q_id` FROM `centre_project_details` WHERE `project_id`=$qset 
order by id");
		              
		              $str="Project- $ppn :: Centre Details</h5> <br><br><table border=1> <tr 
bgcolor=lightgray><td>QSET_ID</td><td>CENTRE</td><td>CODE</td></tr>";
		              foreach($qs as $p)
		              {
		                     $c=$p->centre_id; $cn=$this->getCentre($c);
		                     $str.="<tr><td>$qset </td><td>$cn</td><td> $c </td></tr>";
		              }
		              $str.="</table>";
	              }
	              //for product
	               if($rt==2)
		      {
		              $qs=$this->getDataBySql("SELECT `id`, `qset_id`, `product`, `valuee` FROM `project_product_map` WHERE `qset_id`=$qset order by 
valuee");
		              
		              $str="Project- $ppn ::Product Details</h5> <br><br><table border=1> <tr 
bgcolor=lightgray><td>QSET_ID</td><td>PRODUCT</td><td>CODE</td></tr>";
		              foreach($qs as $p)
		              {
		                     $s=$p->product; $t=$p->valuee;
		                     $str.="<tr><td>$qset </td><td>$s</td><td> $t </td></tr>";
		              }
		              $str.="</table>";
	              }
	              //for sec
	               if($rt==3)
		      {
		              $qs=$this->getDataBySql("SELECT `id`, `qset`, `sec`, `valuee` FROM `project_sec_map` WHERE `qset`=$qset order by valuee");
		              
		              $str="Project- $ppn :: SEC Details</h5> <br><br><table border=1> <tr 
bgcolor=lightgray><td>QSET_ID</td><td>SEC</td><td>CODE</td></tr>";
		              foreach($qs as $p)
		              {
		                     $s=$p->sec; $t=$p->valuee;
		                     $str.="<tr><td>$qset </td><td>$s</td><td> $t </td></tr>";
		              }
		              $str.="</table>";
	              }
	              return $str;
	        }
                public function getPRuleDetail($qset,$rt)
                { $str='';
                      $ppn=$this->get_project_name($qset);

                      if($rt==1)
                      {
                              $qs=$this->getDataBySql("SELECT qid, sno,grp_code FROM vcims.question_rule_1 where qset_id=$qset order by qid,grp_code");

                              $str="Project- $ppn :: Rule for PSM</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>QID</td><td>CODE</td><td>GROUP</td></tr>";
				if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid; $sno=$p->sno;$grp=$p->grp_code;
                                     $str.="<tr><td>$qset </td><td>$qid</td><td> $sno </td><td>$grp</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==2)
                      {
                              $qs=$this->getDataBySql("SELECT tab_id,qid,op_val,quota FROM vcims.question_rule_2 where qset_id=$qset order by qid");

                              $str="Project- $ppn :: Rule for QUOTA</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>QID</td><td>CODE</td><td>QUOTA</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid; $sno=$p->op_val;$qq=$p->quota;
                                     $str.="<tr><td>$qset </td><td>$qid</td><td> $sno </td><td>$qq</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==3)
                      {
                              $qs=$this->getDataBySql("SELECT qid, grp_id FROM vcims.question_rule_3 where qset_id=$qset order by qid");

                              $str="Project- $ppn :: Rule for Grid</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>QID</td><td>GROUP</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid; $grp=$p->grp_id;
                                     $str.="<tr><td>$qset </td><td>$qid</td><td>$grp</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==4)
                      {
                              $qs=$this->getDataBySql("SELECT qid,cqid FROM vcims.question_routine_and where qset_id=$qset order by cqid");

                              $str="Project- $ppn :: Rule AND</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>QID</td><td>CQID</td><td>FLAG</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid; $cqid=$p->cqid;$flg=$p->flag;
                                     $str.="<tr><td>$qset </td><td>$qid</td><td>$cqid</td><td>$flg</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==5)
                      {
                              $qs=$this->getDataBySql("SELECT qid,cqid FROM vcims.question_rule_show_op where qset_id=$qset order by cqid");

                              $str="Project- $ppn :: Rule QOP Show Only</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>QID</td><td>CQID</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid; $cqid=$p->cqid;
                                     $str.="<tr><td>$qset </td><td>$qid</td><td>$cqid</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==6)
                      {
                              $qs=$this->getDataBySql("SELECT qid,cqid FROM vcims.question_rule_hide_op where qset_id=$qset order by cqid");

                              $str="Project- $ppn :: Rule QOP Hide Only</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>QID</td><td>CQID</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid; $cqid=$p->cqid;
                                     $str.="<tr><td>$qset </td><td>$qid</td><td>$cqid</td></tr>";
                              }
                              $str.="</table>";
                      }

                      if($rt==7)
                      {
                              $qs=$this->getDataBySql("SELECT cqid,rqid,op_val,fstr,rstr  FROM vcims.question_word_findreplace where qset=$qset order by cqid");
                              $str="Project- $ppn :: Rule Word Find Replace</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>CQID</td><td>RQID</td><td>CODE</td><td>FIND</td><td>REPLACE</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $cqid=$p->cqid; $rqid=$p->rqid; $sno=$p->op_val; $fstr=$p->fstr;$rstr=$p->rstr;
                                     $str.="<tr><td>$qset </td><td>$cqid</td><td>$rqid</td><td> $sno </td><td>$fstr</td><td>$rstr</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==8)
                      {
                              $qs=$this->getDataBySql("SELECT cqid,pqid,opv,sval,eval  FROM vcims.question_rule_autoselect where qset=$qset order by cqid");
                              $str="Project- $ppn :: Rule: Autoselect</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>CQID</td><td>PQID</td><td>CODE</td><td>START VALUE</td><td>END VALUE</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $cqid=$p->cqid; $pqid=$p->pqid; $sno=$p->opv; $sval=$p->sval;$eval=$p->eval;
                                     $str.="<tr><td>$qset </td><td>$cqid</td><td>$pqid</td><td> $sno </td><td>$sval</td><td>$eval</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt==9)
                      {
                              $qs=$this->getDataBySql("SELECT cqid,opv,sval,eval  FROM vcims.question_rule_numlimit where qset=$qset order by cqid");
                              $str="Project- $ppn :: Rule : Number limit</h5> <br><br><table border=1> <tr
bgcolor=lightgray><td>QSET_ID</td><td>CQID</td><td>CODE</td><td>START VALUE</td><td>END VALUE</td></tr>";
                                if($qs)
                              foreach($qs as $p)
                              {
                                     $cqid=$p->cqid; $rqid=$p->rqid; $sno=$p->opv; $sval=$p->sval;$eval=$p->eval;
                                     $str.="<tr><td>$qset </td><td>$cqid</td><td> $sno </td><td>$sval</td><td>$eval</td></tr>";
                              }
                              $str.="</table>";
                      }
                      if($rt == 10)
                      {
                              $qs=$this->getDataBySql("SELECT qset_id, qid FROM vcims.question_rule_recording where qset_id=$qset order by qid");
                              $str="Project- $ppn :: Rule for PSM</h5> <br><br><table border=1> <tr bgcolor=lightgray><td>QSET_ID</td><td>QID</td></tr>";
                               if($qs)
                              foreach($qs as $p)
                              {
                                     $qid=$p->qid;
                                     $str.="<tr><td>$qset </td><td>$qid</td></tr>";
                              }
                              $str.="</table>";
                      }

			return $str;
		}
	        public function getEditProjectDetail($pid)
	        {
	              $projects=$this->getProject($pid);
	              
	              $str="Edit Project Details</h5> <br><br><table border=1>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name; $cn=$p->company_name; $b=$p->brand; $bk=$p->background; $ss=$p->sample_size; $rt=$p->research_type; 
$v=$p->tot_visit;
	                     $sdt=$p->survey_start_date;$edt=$p->survey_end_date; $rp=$p->reward_point; $dt=$p->data_table;$st=$p->status;
	                     if($st==1) $stt="Active";if($st==0) $stt="Not Active";
	                     $str.="<tr><td>Project ID</td><td>$pid <input type=hidden id=pn value=$pid> </td></tr><tr><td>Project Name</td><td><input type=text 
id=pnn value=$pn > </td></tr><tr><td>Start Date</td><td><input type=date id=sdt value=$sdt></td></tr><tr><td>End Date</td><td><input type=date id=edt 
value=$edt></td></tr> <tr><td>Company</td><td><input type=text id=cn value=$cn></td></tr><tr><td>Brand</td><td><input type=text id=b 
value=$b></td></tr><tr><td>Qnr Ver No</td><td><input type=text id=bk value=$bk></td></tr><tr><td>Sample Size</td><td><input type=text id=ss 
value=$ss></td></tr><tr><td>Research Type</td><td><input type=text id=rt value=$rt></td></tr><tr><td>Visit</td><td><input type=text id=v 
value=$v></td></tr><tr><td>Reward Points for Surveygenics</td><td><input type=text id=rp 
value=$rp></td></tr><tr><td>Table</td><td>$dt</td></tr><tr><td>Status</td><td><input type=text id=st value=$st></td></tr><tr><td colspan=2><input type=submit 
value=Save onClick =update('project');> <font color=red><span id=$pid> </span></font></td></tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
			
	        public function getEditQuestionDetail($qset)
	        {
	              $str="<div class='text-center' style='color: red;'>Note: Never change Q_TYPE of Instruction or Rating to any other type. This will give error and survey data will get lost.</div> <div>Edit Question Details</div> <div><table border=0 class='table'><tr><td style='width:5%'>QID</td><td style='width:7%'>QNO</td><td style='width:58%'>TITLE</td><td  style='width:25%'>TYPE</td><td style='width:5%'>ACTION</td></tr>";
	              $sql="select * from question_detail where qset_id=$qset";
	              $qs=$this->getDataBySql($sql);
		      if($qs){
	              foreach($qs as $q)
	              {
	                    $qid=$q->q_id; $title=$q->q_title; $qt=$q->q_type; $qn=$q->qno;
				$qstr1 = '';$qstr2 = '';$qstr3 = '';$qstr4 = ''; $qstr5='';
                                $qstr6 = '';$qstr7 = '';$qstr8 = '';$qstr9 = ''; $qstr10='';
                                $qstr11 = '';$qstr12 = '';$qstr13 = '';$qstr14 = ''; $qstr15='';
				if($qt == 'text')$qstr1=' selected';
                                if($qt == 'textarea')$qstr2=' selected';
                                if($qt == 'checkbox')$qstr3=' selected';
                                if($qt == 'radio')$qstr4=' selected';
                                if($qt == 'rating')$qstr5=' selected';
                                if($qt == 'instruction')$qstr6=' selected';
                                if($qt == 'imaged')$qstr7=' selected';
                                if($qt == 'videod')$qstr8=' selected';
                                if($qt == 'audiod')$qstr9=' selected';
                                if($qt == 'image')$qstr10=' selected';
                                if($qt == 'video')$qstr11=' selected';
                                if($qt == 'audio')$qstr12=' selected';
                                if($qt == 'dropdown')$qstr13=' selected';
                                if($qt == 'old_sec')$qstr14=' selected';
                                if($qt == 'new_sec')$qstr15=' selected';

	                    $str.="<tr><td style='width:5%;'>$qid <input type=hidden id=qid$qid value=$qid></td><td style='width:5%;'><input class='form-control' type=text id=qno$qid value=$qn></td><td 
style='width:80%;'><input class='form-control' type=text id=title$qid value='$title'></td><td><select class='form-control' id=qt$qid> <option value='radio' $qstr4>Single Choice</option> <option value='checkbox' $qstr3>Multiple Choice</option><option value='text' $qstr1>Open Ended-- Single Line</option><option value='textarea'  $qstr2>Open Ended-- Multiple Line</option> <option value='rating' $qstr5 disabled> Rating</option><option value='instruction' $qstr6 disabled> Instruction Only</option><option value='image' $qstr10>Capture Image</option><option value='audio' $qstr12>Capture Audio</option><option value='video' $qstr11>Capture Video</option><option value='imaged' $qstr7>Display Instruction with Image</option><option value='audiod' $qstr9>Play Audio with Instruction</option> <option value='videod' $qstr8>Play Video with Instruction</option><option value='old_sec' $qstr14>Old SEC</option><option value='new_sec' $qstr15>New SEC</option> </select> </td><td style='width:5%;'><input class='btn btn-primary' type=submit value=Save onClick 
=update('question',$qid);> <span id=$qid> </span> </td></tr>";
	              }
	              $str.="</table></div>";
	              return $str;
		     }
		    else
			return 'Not data is available';
	        }
	        public function getEditQuestionOPDetail($qqid)
	        {
	              $str="<br><br><br><div class='contener' style='margin-left: 10%;'><div class='well col-lg-11'> <b> Edit Question Options Details</b> <br><br><table border=1 class='table table-striped'><tr><td style='width:5%;'>QID</td><td style='width:70%;'>OPTION NAME</td><td style='width:5%;'>CODE</td><td style='width:10%;'>TERM</td><td style='width:5%;'>FLAG</td><td  style='width:5%;'>ACTION</td></tr>";
	              $sql="select * from question_option_detail where q_id=$qqid";
	              $qs=$this->getDataBySql($sql);
                      if($qs)
	              foreach($qs as $q)
	              {
	                    $id=$q->op_id;$qid=$q->q_id; $txt=$q->opt_text_value; $t=$q->term; $v=$q->value; $fg = $q->flag;
	                    $str.="<tr><td><input type=hidden id=id$id name=id$id value=$id> $qid <input type=hidden id=qid$id name=qid$id value=$qid></td><td style='width:70%;'><input class='form-control' type=text id=txt$id name=txt$id value='$txt'></td><td style='width:5%;'><input class='form-control' type=text id=value$id name=value$id value=$v></td><td  style='width:5%;'><input type=text class='form-control' id=term$id name=term$id value=$t></td> <td style='width:5%;'><input class='form-control' type=text id=flag$id name=flag$id value=$fg ></td> <td style='width:5%;'><input class='btn btn-primary' type=submit value=Save onClick =update('questionop',$id);> <span class='text-primary' id=$id> </span></td></tr>";
	              }
	              $str.="</table> </div></div>";
	              return $str;
	        }
	        public function getEditSequenceDetail($qset)
	        {
	              $str="Edit Sequence Details</h5> <br><br><table border=1><tr><td>QSET</td><td>QID</td><td>SID</td><td>CHECK 
FLAG</td><td>ACTION</td></tr>";
	              $sql="select * from question_sequence where qset_id=$qset order by sid";
	              $qs=$this->getDataBySql($sql);
                      if($qs)
	              foreach($qs as $q)
	              {
	                    $id=$q->id;$qid=$q->qid; $sid=$q->sid; $flag=$q->chkflag;
	                    $str.="<tr><td>$qset <input type=hidden id=qset$id value=$qset><input type=hidden id=id$id value=$id></td><td><input class='form-control' type=text 
id=qid$id value=$qid></td><td><input class='form-control' type=text id=sid$id value='$sid'></td><td><input class='form-control' type=text id=flag$id value=$flag></td><td><input class='btn btn-primary' type=submit value=UPDATE 
onClick =update('sequence',$id);><input class='btn btn-danger' type=submit value=DELETE onClick =update('sequenced',$id);>  <font color=red><span id=$id> </span></font> </td></tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function getEditRoutineDetail($qset)
	        {
	              $str="<div class='contener'> <br><b>Edit Routine Details</b> <br><br><table border=1 class='table'><tr style='background:gray;'><td>QSET</td><td>QID</td><td>PQID</td><td>OPTION 
VALUE</td><td>FLOW</td><td>ACTION</td></tr>";
	              $sql="select * from question_routine_check where qset_id=$qset order by qid,opval";
	              $qs=$this->getDataBySql($sql);
                      if($qs)
	              foreach($qs as $q)
	              {
	                     $id=$q->id; $qid=$q->qid; $pqid=$q->pqid; $opv=$q->opval; 
			     $flow=$q->flow;
				$fstr1=''; $fstr2=''; $fstr3='';
			     if($flow==0)$fstr1=' selected';
			     if($flow==1)$fstr2=' selected';
			     if($flow==2)$fstr3=' selected';
	                    $str.="<tr><td>$qset</td><td><input class='form-control' type=hidden id=id$id value=$id> <input class='form-control' type=text id=qid$id value=$qid></td><td><input type=text class='form-control' 
id=pqid$id value=$pqid></td><td><input class='form-control' type=text id=opval$id value='$opv'></td><td><select class='form-control' id=flow$id ><option value='0' $fstr1> Continue </option> <option value='1' $fstr2> Terminate</option> <option value='2' $fstr3> Terminate Anyway </option> </select> </td><td><input type=submit class='btn btn-primary' value=UPDATE onClick =update('routine',$id);> &nbsp; <input type=submit class='btn btn-danger' value=DELETE onClick =update('routined',$id);> <font color=red><span id=$id> </span></font> </td></tr>";
	              }
	              $str.="</table> </div>";
	              return $str;
	        }
	        public function getEditCentreDetail($qset)
	        {
			$str='Not available';
		      $rt=$this->input->post('rt');
                      //$pid=$this->input->post('pn');
		      if($rt==1){
	              	$str="Centre Edit Details</h5> <br><br><table border=1><tr><td>ID</td><td>CENTRE ID</td><td>ACTION</td></tr>";
	              	$sql="select * from centre_project_details where q_id=$qset order by id";
	              	$qs=$this->getDataBySql($sql);
                        if($qs)
	              	foreach($qs as $q)
	              	{
	                    $id=$q->id; $cid=$q->centre_id; $qset=$q->q_id; 
	                    $str.="<tr><td>$id <input type=hidden id=id$id value=$id> <input type=hidden id=pid$id value=$qset></td><td><input type=text id=c$id value=$cid></td><td><input type=submit value=Save onClick =update('centre',$id);> 
<font color=red><span id=$id> </span></font> </td></tr>";
	              	}
                      	$str.="</table>";
		      } //end of if rt
                      if($rt==0){
                        $str="Store Edit Details</h5> <br><br><table border=1><tr><td>ID</td><td>CODE</td><td>NAME</td><td>ACTION</td></tr>";
                        $sql="select * from project_store_loc_map where qset_id=$qset order by id";
                        $qs=$this->getDataBySql($sql);
                        if($qs)
                        foreach($qs as $q)
                        {
                            $id=$q->id; $cid=$q->valuee; $nm=$q->store; $qset=$q->qset_id;
                            $str.="<tr><td>$id <input type=hidden id=id$id value=$id> <input type=hidden id=pid$id value=$qset></td><td><input type=text id=c$id value=$cid></td><td><input type=text id=s$id value='$nm'>
</td><td><input type=submit value=Save onClick =update('store',$id);><input type=submit value=Delete onClick =update('stored',$id);>
<font color=red><span id=$id> </span></font> </td></tr>";
                        }
                        $str.="</table>";
                      } //end of if rt 0
                      if($rt==2){
                        $str="Product Edit Details</h5> <br><br><table border=1><tr><td>ID</td><td>CODE</td><td>NAME</td><td>ACTION</td></tr>";
                        $sql="select * from project_product_map where qset_id=$qset order by id";
                        $qs=$this->getDataBySql($sql);
                        if($qs)
                        foreach($qs as $q)
                        {
                            $id=$q->id; $cid=$q->valuee; $nm=$q->product;$qset=$q->qset_id;
                            $str.="<tr><td>$id <input type=hidden id=id$id value=$id> <input type=hidden id=pid$id value=$qset></td><td><input type=text id=c$id value=$cid></td><td><input type=text id=s$id value='$nm'>
</td><td><input type=submit value=Save onClick =update('product',$id);><input type=submit value=Delete onClick =update('productd',$id);>
<font color=red><span id=$id> </span></font> </td></tr>";
                        }
                        $str.="</table>";
                      } //end of if rt 0
                      if($rt==3){
                        $str="SEC Edit Details</h5> <br><br><table border=1><tr><td>ID</td><td>CODE</td><td>NAME</td><td>ACTION</td></tr>";
                        $sql="select * from project_sec_map where qset=$qset order by id";
                        $qs=$this->getDataBySql($sql);
			if($qs)
                        foreach($qs as $q)
                        {
                            $id=$q->id; $cid=$q->valuee; $nm=$q->sec;$qset=$q->qset;
                            $str.="<tr><td>$id <input type=hidden id=id$id value=$id> <input type=hidden id=pid$id value=$qset></td><td><input type=text id=c$id value=$cid></td><td><input type=text id=s$id value='$nm'>
</td><td><input type=submit value=Save onClick =update('sec',$id);><input type=submit value=Delete onClick =update('secd',$id);>
<font color=red><span id=$id> </span></font> </td></tr>";
                        }
                        $str.="</table>";
                      } //end of if rt 3
                      if($rt==4){
                        $str="Edit Project Age</h5> <br><br><table border=1><tr><td>ID</td><td>CODE</td><td>NAME</td><td>ACTION</td></tr>";
                        $sql="select * from project_age_map where qset=$qset order by valuee";
                        $qs=$this->getDataBySql($sql);
                        if($qs)
                        foreach($qs as $q)
                        {
                            $id=$q->id; $cid=$q->valuee; $age=$q->age;$qset=$q->qset;
                            $str.="<tr><td>$id <input type=hidden id=id$id value=$id> <input type=hidden id=pid$id value=$qset></td>
<td><input type=text id=c$id value=$cid></td><td><input type=text id=a$id value='$age' >
</td><td><input type=submit value=Save onClick =update('age',$id);><input type=submit value=Delete onClick =update('aged',$id);>
<font color=red><span id=$id> </span></font> </td></tr>";
                        }
                        $str.="</table>";
                      }

	              return $str;
	        }
                public function getEditFPDetail($qset)
                {
                        $str='Not available';
			$farr=array();
                       $pid=$this->input->post('pn');
                      if($pid!=0){
                        $str="First Page Edit Details</h5> <br><br><table border=1><tr><td>ID</td><td>PROJECT ID</td><td>NAME</td><td>ACTION</td></tr>";
                        $fsql="select distinct fpid from project_fp_map where pid=$qset order by id";
                        $fqs=$this->getDataBySql($fsql);
                        if($fqs)
                        foreach($fqs as $fq)
                        {
                            $fid=$fq->fpid; array_push($farr,$fid);
			}

                        $sql="select * from app_first_page order by title,id";
                        $qs=$this->getDataBySql($sql);
                        if($qs)
                        foreach($qs as $q)
                        {
                            $id=$q->id; $tt=$q->title; 
                            $str.="<tr><td>$id <input type=hidden id=id$id value=$id> <input type=hidden id=pid$id value=$qset></td><td>$qset</td><td> $tt </td><td>";
				$str.="<font color=red><span id=$id>";
			    if(in_array($id,$farr)){
				$str.="<input type=submit value=Remove onClick =update('deletefp',$id);>";
			    }
			    else
				$str.="<input type=submit value=Add onClick =update('addfp',$id);>";
				$str.="</span></font> </td></tr>";
				//$str.="<font color=red><span id=$id> </span></font> </td></tr>";
                        }
                        $str.="</table>";
			}
			return $str;
		}
	        public function getUpdateSequenceDetail($qset)
	        {
	              $str="Update Sequence Details</h5> <br><br><table border=1><tr><td>QID</td><td>QNO</td><td>TITLE</td><td>TYPE</td><td>ACTION</td></tr>";
	              $sql="select * from question_routine_check where qset_id=$qset order by qid";
	              $qs=$this->getDataBySql($sql);
                      if($qs)
	              foreach($qs as $q)
	              {
	                    $qid=$q->q_id; $title=$q->q_title; $qt=$q->q_type; $qn=$q->qno;
	                    $str.="<tr><td>$qid <input type=hidden id=qid$qid value=$qid></td><td><input type=text id=qno$qid value=$qn></td><td><input 
type=text id=title$qid value='$title'></td><td><input type=text id=qt$qid value=$qt></td><td><input type=submit value=Save onClick =update('routine',$qid);> 
<font color=red><span id=$qid> </span></font> </td></tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function doRuleUpdate($rt,$id,$arr)
	        {
	             $this->db->set($arr);
	             $this->db->where('id', $id);
	             $res = $this->db->update($rt);
	             if($res)
	                return true;
	             else
	                return false;
	        }
	        public function doProjectUpdate($pid,$arr)
	        {
	             $this->db->set($arr);
	             $this->db->where('project_id', $pid);
	             $res = $this->db->update('project');
	             if($res)
	                return true;
	             else
	                return false;
	        }
	        public function doQuestionUpdate($qid,$arr)
	        {
	             $this->db->set($arr);
	             $this->db->where('q_id', $qid);
	             $res = $this->db->update('question_detail');
	             if($res)
	                return true;
	             else
	                return false;
	        }
	        public function doQuestionOPUpdate($id,$arr)
	        {
	             $this->db->set($arr);
	             $this->db->where('op_id', $id);
	             $res = $this->db->update('question_option_detail');
	             if($res)
	                return true;
	             else
	                return false;
	        }
	        public function doSequenceUpdate($id,$arr)
	        {
	             $this->db->set($arr);
	             $this->db->where('id', $id);
	             $res = $this->db->update('question_sequence');
	             if($res)
	                return true;
	             else
	                return false;
	        }
	        public function doRoutineUpdate($id,$arr)
	        {
	             $this->db->set($arr);
	             $this->db->where('id', $id);
	             $res = $this->db->update('question_routine_check');
	             if($res)
	                return true;
	             else
	                return false;
	        }
	        public function doUpdateSequence($qset,$ssid,$esid,$num)
	        { $str=''; $a1=0;$a2=0;
	             $sql1="SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset AND `sid` in ($ssid)";
	             $rds1=$this->getDataBySql($sql1);
	             if($rds1)
	             {
	                $a1=1;
	             }
	             $sql2="SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset AND `sid` in ($esid)";
	             $rds2=$this->getDataBySql($sql2);
	             if($rds2)
	             { $str1='';
	                 $sql21="SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset AND `sid` between $ssid AND $esid";
	                 $rds21=$this->getDataBySql($sql21);
	                 if($rds21)
	                 {
	                      foreach($rds21 as $ds)
	                      { $s=$ds->sid; $q=$ds->qid; $s2=$s+1;
	                          $arup=array('sid'=>($s+$num));
	                          $this->db->set($arup);
	                          $this->db->where('qid', $q);
	                          $res = $this->db->update('question_sequence');
	                          $str.="<br> $ds->qid => $ds->sid To ($s + $num =$s2)";
	                      }
	                      $str.="<br> Sequence Update Sucessful";
	                 }
	                 $a2=1;
	             }
	             else
	             {
	                  if($a1==0) $str="SID lower range is not valid";
	                  if($a2==0) $str="SID upper range is not valid";
	             }
	             return $str;
	        }
                public function doUpdateSequencedesc($qset,$ssid,$esid,$num)
                { $str=''; $a1=0;$a2=0;
                     $sql1="SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset AND `sid` in ($ssid)";
                     $rds1=$this->getDataBySql($sql1);
                     if($rds1)
                     {
                        $a1=1;
                     }
                     $sql2="SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset AND `sid` in ($esid)";
                     $rds2=$this->getDataBySql($sql2);
                     if($rds2)
                     { $str1='';
                         $sql21="SELECT `id`, `qset_id`, `qid`, `sid`, `chkflag` FROM `question_sequence` WHERE `qset_id`=$qset AND `sid` between $ssid AND $esid";
                         $rds21=$this->getDataBySql($sql21);
                         if($rds21)
                         {
                              foreach($rds21 as $ds)
                              { $s=$ds->sid; $q=$ds->qid; $s2=$s-1;
                                  $arup=array('sid'=>($s - $num));
                                  $this->db->set($arup);
                                  $this->db->where('qid', $q);
                                  $res = $this->db->update('question_sequence');
                                  $str.="<br> $ds->qid => $ds->sid To ($s - $num =$s2)";
                              }
                              $str.="<br> Sequence Update Sucessful";
                         }
                         $a2=1;
                     }
                     else
                     {
                          if($a1==0) $str="SID lower range is not valid";
                          if($a2==0) $str="SID upper range is not valid";
                     }
                     return $str;
                }

		// to create the sequencing dragable
                public function viewCreateSequenceDraggable($qset)
                {
			$sqq = "SELECT * from `question_sequence` WHERE qset_id = $qset";
			$dr = $this->getDataBySql($sqq);
			if( $dr )
				return 'Already created';
                        $str='No Record Found';
                        $sd=$this->getDataBySql("SELECT q_id, `qset_id`, `q_title`, `q_type`, `qno` FROM `question_detail` WHERE `qset_id`=$qset");
                        if($sd)
                        { $ctr=0;
                             $str="<form method=post action='docreatesequence'><table id='seqtable'><thead> <tr><td>QNO<input type=hidden name=qset id=qset
value=$qset></td><td>QID</td><td>TITLE</td><td></td><td> ROUT FLAG</td></tr></thead> <tbody>";
                             foreach($sd as $d)
                             {
                                 $ctr++;
                                 $qn=$d->qno; $qid=$d->q_id; $q=$d->q_title;
                                 $str.="<tr id = $ctr > <td>$qn</td><td>$qid</td><td>$q</td><td><input type=hidden class='form-control' name=$qid id=seq_val_$ctr value=$ctr ></td><td>
<input type=checkbox class='form-control' name=flag$qid name=flag$qid value=$qid></td></tr>";
                             }
                              $str.="<tr><td colspan=3><input type=submit class='btn btn-primary' name='ssubmit'</td></tr> </tbody> </table></form>";
                        }
                        return $str;
                }

	        public function viewCreateSequence($qset)
	        {
	                $str='No Record Found';
	                $sd=$this->getDataBySql("SELECT q_id, `qset_id`, `q_title`, `q_type`, `qno` FROM `question_detail` WHERE `qset_id`=$qset");
	                if($sd)
	                { $ctr=0;
	                     $str="<form method=post action='docreatesequence'><table><tr><td>QNO<input type=hidden name=qset id=qset 
value=$qset></td><td>QID</td><td>TITLE</td><td>SEQUENCE VALUE</td><td>CHECK FLAG</td></tr>";
	                     foreach($sd as $d)
	                     {
	                         $ctr++;
	                         $qn=$d->qno; $qid=$d->q_id; $q=$d->q_title;
	                         $str.="<tr><td>$qn</td><td>$qid</td><td>$q</td><td><input type=number class='form-control' name=$qid id=$qid value=$ctr></td><td><input type=checkbox class='form-control' name=flag$qid name=flag$qid value=$qid></td></tr>";
	                     }
	                      $str.="<tr><td colspan=3><input type=submit class='btn btn-primary' name='ssubmit'</td></tr></table></form>";
	                }
	                return $str;
	        }
	        public function doCUpdateSequence($arr,$qset)
	        {
                        $dt = date('Y-m-d H:i:s');
                        $login=$this->session->userdata('sauserid');
			$str=false;
	         foreach($_POST as $key=>$val)
	         {
	           if($key!='ssubmit')if($key!='qset')
	           { $f=0;
	              //echo "$key => $val <br>";
	             $ff="flag$val";
	              if($key==$ff)
	              { $str=true;
	                  $str.=$qu= "UPDATE `question_sequence` SET `chkflag`=1, updated_at ='$dt' WHERE `qset_id`=$qset AND `qid`=$val";
	                  $r1=$this->doSqlDML($qu);
	              }
	              else
	              {
	                  $str.= $qi="INSERT INTO `question_sequence`(`qset_id`, `qid`, `sid`, `chkflag`,created_at,updated_at) VALUES ($qset,$key,$val,$f,'$dt','$dt')";
	                  $r2=$this->doSqlDML($qi);
	                  $str=true;
	              }
	            }
	           } // end foreach
	           return $str;
	        }
	        public function viewCreateRoutine($qset)
	        {
	                $str='No Record Found';
	                $sd=$this->getDataBySql("SELECT q_id, `qset_id`, `q_title`, `q_type`, `qno` FROM `question_detail` WHERE `qset_id`=$qset");
	              
	        }
	        public function editProjectDetail($qset)
	        {
	              $ppn=$this->get_project_name($qset);
	              $qs=$this->getDataBySql("SELECT `id`, `qset_id`, `product`, `valuee` FROM `project_product_map` WHERE `qset_id`=$qset order by valuee");
	              
	              $str="Project- $ppn Question Details</h5> <br><table border=1> <tr 
bgcolor=lightgray><td>Q_ID</td><td>Q_NO</td><td>Title</td><td>Type</td></tr>";
	              foreach($qs as $p)
	              {
	                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno;
	                     $str.="<tr><td>$qid </td><td>$qn</td><td> $t </td><td>$qt</td></tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function editQuestionDetail($qset)
	        {
	              $ppn=$this->get_project_name($qset);
	              $qs=$this->getDataBySql("SELECT `id`, `qset`, `sec`, `valuee` FROM `project_sec_map` WHERE `qset`=$qset order by valuee");
	              
	              $str="Project- $ppn Question Details</h5> <br><table border=1> <tr 
bgcolor=lightgray><td>Q_ID</td><td>Q_NO</td><td>Title</td><td>Type</td></tr>";
	              foreach($qs as $p)
	              {
	                     $qid=$p->q_id; $t=$p->q_title; $qt=$p->q_type; $qn=$p->qno;
	                     $str.="<tr><td>$qid </td><td>$qn</td><td> $t </td><td>$qt</td></tr>";
	              }
	              $str.="</table>";
	              return $str;
	        }
	        public function docreatequestion($arr)
	        {
	        $pid=$arr['pn'];
		    $qset=$arr['qset'];
		    $qno=$arr['qno'];
		    $q=$arr['qtitle'];
		    $qt=$arr['qt'];
		    $sc = $arr['sc'];
		    $ts = $arr['ts'];
		//echo "qset= $qset , qtitle= $q, qt= $qt, sc= $sc, ts= $ts";
                        $dt = date('Y-m-d H:i:s');
                        $login=$this->session->userdata('sauserid');

		    $qn = strtolower($qno);
                    $sc=0;
                       if(isset($arr['sc'])) $sc=1;
		    //$trm2=$qn.'_'.$pid;
		    //$trm3=$trm2.'_t';
	            $qno = strtoupper($qn);
		    $ptable=$this->getProjectTable($pid);
	            if($q!='' && $pid!=0 && $qset!=0 && $qn!='' && $qt!='')
		    { $rr='';
		        $str=$pid.' title: '.$q.' qtype: '.$qt;
	                if($qt=='radio' || $qt=='checkbox')
		        {
		            $cnt=$arr['cnt']; $flag=0;
		            //echo '<br>'.$sq1="INSERT INTO `question_detail`(qset_id, `q_title`, `q_type`,qno) VALUES ($qset,'$q','$qt','$qno')";
		            $tdata=array('qset_id'=>$qset,'q_title'=>$q,'q_type'=>$qt,'qno'=>$qno,'timestamp_flag'=>$ts,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login);
		            $qid=$this->insertIntoTable('question_detail',$tdata);
					$trm2=$qid.'_'.$qset;
					$trm3='';
					//$trm3=$trm2.'_t';
				if($ts == '1'){
					$t3=$trm2.'_t';
					$trm3 = " , ADD column $t3 varchar(20)";
				}
		            $atq="ALTER TABLE $ptable ADD column $trm2 varchar(3) not null $trm3 ;";
		            $ctb1=$this->doSqlDML($atq);
		            for($i=1;$i<=$cnt;$i++)
		            { $a='stb'.$i; $b='tb'.$i;$c = 'flag'.$i;
	                         $a1=$arr[$a]; $b1=$arr[$b]; $c1=$arr[$c]; $flag=1;
		                 //echo '<br>'.$sq2="INSERT INTO `question_option_detail`( `q_id`, `opt_text_value`, `value`, `term`) VALUES ($qid,'$a1','$b1','$trm2')";
		                 $tdata2=array('q_id'=>$qid,'term'=>$trm2,'opt_text_value'=>$b1,'value'=>$a1,'flag' => $c1 ,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login);
		                 $insd=$this->insertIntoTable('question_option_detail',$tdata2);

				//to add columns for flag others
				// cl ==1 for string types of others 
				if( $c1 == 1 || $c1 == 3 || $c1 == 4){
				 $optrm2 = $trm2.'_'.$a1.'_o';
				 $atq2="ALTER TABLE $ptable ADD column $optrm2 varchar(380) null;";
                            	 $ctb2=$this->doSqlDML($atq2);
				}
				// cl ==2 for numbers types of others
                                if( $c1 == 2 ){
                                 $optrm2=$trm2.'_'.$a1.'_o';
                                 $atq2="ALTER TABLE $ptable ADD column $optrm2 varchar(150) null";
                                 $ctb2=$this->doSqlDML($atq2);
                                }
				//end of add column others
	 	            }
			    if($sc =='1'){
            		    $ssql="INSERT INTO project_showcard (qset,qid ) VALUES ($qset,$qid);";
			    $this->doSqlDML($ssql);
			    }
		            if($flag==1) return '<br>Successfully created with Question Id:<font color=red> '.$qid .'--'. $qn;
		        }
	                if($qt=='text' || $qt=='textarea' || $qt == 'dropdown' || $qt=='instruction' || $qt=='image' || $qt=='imaged' || $qt=='audio' || $qt=='audiod' || $qt=='video' || $qt=='videod')
		        {
		               
	                      $tdata=array('qset_id'=>$qset,'q_title'=>$q,'q_type'=>$qt,'qno'=>$qno,'timestamp_flag'=>$ts,'created_at' => $dt, 'updated_at' => $dt,'uid'=>$login);
		              $qid=$this->insertIntoTable('question_detail',$tdata);
		              $trm2=$qid.'_'.$qset;
                                        $trm3='';
                                        //$trm3=$trm2.'_t';
                                if($ts == '1'){
                                        $t3=$trm2.'_t';
                                        $trm3 = " , ADD column $t3 varchar(20)";
                                }

		              if($qt=='dropdown'){
		                  $atq="ALTER TABLE $ptable ADD $trm2 int(8) not null $trm3 ";
		                  $ctb1=$this->doSqlDML($atq);
		              }
		              else if($qt == 'text' || $qt == 'textarea' || $qt == 'instruction'  || $qt=='image'  || $qt=='audio'  || $qt=='video' ){
		                      $atq="ALTER TABLE $ptable ADD $trm2 varchar(960) not null $trm3 ";
			              $ctb1=$this->doSqlDML($atq);
		              }
	                      $tdata2=array('q_id'=>$qid,'term'=>$trm2);
				if($qt == 'instruction' || $qt=='imaged' || $qt=='audiod' || $qt=='videod'){
					//do nothing
					$insd=1;
				}
				else{
		              		$insd=$this->insertIntoTable('question_option_detail',$tdata2);
				}

                            if($sc =='1'){ 
                              $ssql="INSERT INTO project_showcard (qset,qid ) VALUES ($qset,$qid);";
                               $this->doSqlDML($ssql);
			    }
		              if($insd) return '<br>Successfully created with Question Id:<font color=red> '.$qid .'--'. $qn;
		            
		        } 
	                if($qt=='rating' )
		        {
		            $ssv=$arr['froms'];
		            $esv=$arr['tos'];
		            $lforms=$arr['lfroms'];
		            $ltos=$arr['ltos'];
		            
		            $tdata=array('qset_id'=>$qset,'q_title'=>$q,'q_type'=>$qt,'qno'=>$qno,'timestamp_flag'=>$ts,'created_at' => $dt, 'updated_at'=>$dt,'uid'=>$login);
		            $qid=$this->insertIntoTable('question_detail',$tdata);
			    $trm2=$qid.'_'.$qset;
                                        $trm3='';
                                        //$trm3=$trm2.'_t';
                                if($ts == '1'){
                                        $t3=$trm2.'_t';
                                        $trm3 = " , ADD column $t3 varchar(20)";
                                }

		            $atq="ALTER TABLE $ptable ADD $trm2 int(2) not null $trm3 ";
		            $ctb1=$this->doSqlDML($atq);
		
		            $sq2="INSERT INTO `question_option_detail`( `q_id`,`term`,scale_start_value,scale_end_value,scale_start_label,scale_end_label) VALUES ($qid,'$trm2','$ssv','$esv','$lforms','$ltos')";
		        $tdata2=array('q_id'=>$qid,'term'=>$trm2,'scale_start_value'=>$ssv,'scale_end_value'=>$esv,'scale_start_label'=>$lforms,'scale_end_label'=>$ltos,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login);
		            $insd=$this->insertIntoTable('question_option_detail',$tdata2);
                            if($sc =='1'){
 				$ssql="INSERT INTO project_showcard (qset,qid ) VALUES ($qset,$qid);";
                            	$this->doSqlDML($ssql);
			    }
		             if($insd) return '<br>Successfully created with Question Id:<font color=red> '.$qid .'--'. $qn;
		        }

	                //return $str.$rr;
	            }
	
	        }
	        public function getaddqbquest()
	        {
	              $str="<br><br>ADD QUESTION INTO CATEGORY:<br><br>Add To Category: <select name='cat' id='cat'> <option value='0'>--Select--</option>";
	              $sql="SELECT `catid`, `name`, `remarks` FROM `category_detail` order by name";
	              $sdata=$this->getDataBySql($sql);
	              if($sdata)
	              foreach($sdata as $d)
	              {
	                 $id=$d->catid; $n=$d->name;
	                 //echo "<li> $id -- $n";
	                 $str.="<option value=$id > $n </option>";
	              }
	              $projects=$this->getProjects();
	              $str.="</select><br>Project: <select name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select name=qset id=qset onclick='getpqs();'><option value=select>--Select--</option> </select><br>";
	              $str.="<br>Question ID <select name=qs id=qs> <option value=0>--Select--</option></select> <br>";
	              $str.=" <br><br><input type=submit value=Submit>";
	              return $str;
	        }
	        public function getaddqop()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select></td><td> Question Set: <select name=qset id=qset onclick='getpqs();' required><option value=''>--Select--</option> 
</select></td></tr>";
	              $str.="<br>Question ID: <select name=qs id=qs> <option value=0>--Select--</option></select> <br>";
	              $str.="<div id='msg'></div><br><br><input type='text' name='code' id='code' placeholder='code...'><br><input type='text' name='opt' id='opt' placeholder='option title ...'> <br><br><input type=submit value='Add QOption'>";
	              return $str;
	        }
	        public function getaddrgtrresp()
	        {
	              $projects=$this->getProjects();
	              
                      $str="<div class='text-center bg-primary'><label class='form-label'> ADD PEMISSION TO MOBILE </label></div><br>";
	              $str.="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset required><option value=''>--Select--</option> </select>";
	              $str.="<br>Enter 10 digit Mobile No : <input class='form-control' name=mob minlength=10 maxlength=10 onkeypress='return isNumber(event);' placeholder='Enter 10 digit mobile no' required> <br>";
                      $str.="How many : <input class='form-control'  name=cnt placeholder='Enter count' required> ";
	              $str.="<div id='msg'></div><br><br><input class='btn btn-primary' type=submit name=pr_mob value='Submit'>";
	              return $str;
	        }
	        public function getdeletequestionop()
	        {
	              $projects=$this->getProjects();
	              //$str="<div class='container'><div class='row'><div class='col' >";
		      $str="<div class='text-center p-5 bg-primary'> <br> DELETE QUESTION'S OPTION(S) <br></div><br>";
	              $str.="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> Question Set: <select class='form-control' name=qset id=qset onclick='getpeditqs();'><option value=select>--Select Qset ID--</option> </select><br>";
	              $str.="Question ID: <select class='form-control' name=qs id=qs onchange='getqop();' required> <option value=''>--Select Question--</option></select> <br>";
	              //$str.="<div id='msg'></div><br><br><input type='text' name='code' id='code' placeholder='code...'><br>";
		      $str.="<div id='msg'></div>Select Option :<select name='code[]' id='oplist' class='form-control' multiple required> <option value=''>--Select Multiple Options--</option> </select><br>";
		      $str.="<br><div class='text-center'> <input class='btn btn-primary' type=submit value='Delete Q. Option'  onclick='return(validate());' > </div>";
		      $str.="</div></div></div>";
	              return $str;
	        }
	        public function getdeletequestion()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();' required> <option value=''>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select></td><td> Question Set: <select class='form-control' name=qset id=qset onclick='getpqs();'><option value=select>--Select--</option> 
</select></td></tr>";
	              $str.="<br>Question ID: <select name=qs[] id='qs' class='form-control' multiple required> <option value=''>--Select--</option></select> <br>";
	              $str.="<div id='msg'></div><br><br><input type=submit class='btn btn-primary' value='Delete Question'  onclick='return(validate());' >";
	              return $str;
	        }
	        public function getaddsequence()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset onclick='getpqs();' required><option value=''>--Select--</option> </select><br>";
		 	//$str.="QID:<input type='text' name='qid' id='qid' placeholder='qid..'>";
			$str.="QID:<select name='qid' class='form-control' id='pqid' required> <option value=''>--Select QID--</option></select><br>"; 
			$str.="<input type='text' class='form-control' name='sid' id='sid' placeholder='sequence id ...'><br> <input type=submit class='btn btn-primary' value='Add Sequence'>";
	              return $str;
	        }
	        public function getaddpcentre()
	        {
	              $projects=$this->getProjects();
	              $centres=$this->getCentres();
	              $str="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option> </select>";
	              $str.="<br>Select Centres: <select class='form-control selectpicker' name='cn[]' id='select-country' multiple='multiple'  data-live-search='true'>";
	              foreach($centres as $p)
	              { $cid=$p->centre_id; $cn=$p->cname;$stt=$p->state;$ct=$p->country;
	                     $str.="<option value=$cid > $cn [ $stt , $ct]</option>";
	              }
	              $str.="</select> <br><font color=red> Note: Multiple centres selection is possible .</font><br> <input type=submit class='btn btn-primary' value='Add Centre'>";
	              return $str;
	        }
                public function getcopytqop()
                {
                      $projects=$this->getProjects();
                      $centres=$this->getCentres();
                      $str="Project: <select name='pn' id='pn' class='form-control' onchange='getpqset();'> <option value='0'>--Select--</option>";
                      foreach($projects as $p)
                      { $pid=$p->project_id; $pn=$p->name;
                             $str.="<option value=$pid > $pn </option>";
                      }
                      $str.="</select> <br> Question Set: <select class='form-control' name=qset id=qset></select>";
		      $str.="<br> Language : <select name='lang' id='lang'><option value=0>--Select--</option><option value=1>Hindi</option><option
value=2>Kannada</option><option value=3>Malyalam</option><option value=4>Tammil</option><option value=5>Telgu</option><option value=6>Bangla</option>
<option value=7>Odia</option><option value=8>Gujrati</option><option value=9>Marathi</option><option value=10>Asami</option></select>";
                      $str.="<br><br> <input class='form-control' type=submit value='Continue'>";
                      return $str;
                }

	        public function getaddrule()
	        {
	              $projects=$this->getProjects();
	               
	              $str="<div class='text-center'>Add Rule</div><br> <table width='100%'><tr><td>Project:</td><td> <select class='form-control' name='pn' id='pn' onchange='getpqset();' required> <option value=''>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     //$str.="<option value=$pid > $pn </option>";
                             $str.="<option value=$pid ";
                             if(isset($_SESSION['pid']) && $_SESSION['pid'] == $pid ) $str.= ' selected';
                             $str.= "> $pn </option>";
	              }
	              $str.="</select></td></tr><tr><td> Question Set:</td><td> <select class='form-control' name=qset id=qset required><option value=''>--Select QSet--</option>";
                             if( isset($_SESSION['qset']) ){
                                $qset=$_SESSION['qset'];
                                $str.= "<option value=$qset selected >$qset </option>";
                             }

		      $str.="</select></td></tr>";
	              $str.="<tr><td> Rule Type:</td><td> <select class='form-control' name='rt' id='rt' onchange='getrule();'> <option value='0'>--Select--</option>
<option value=1>Asc order PSM Rule</option><option value=2>Project Tab Quota Rule</option><option value=3>Question Grid Rule</option><option value=4>Questiion AND Rule 
</option><option value=5> Show Selected Options Only </option> <option value=6> Hide Selected Options Only </option><option value=7>Find & Replace Rule</option>
<option value=8>Q.Option autoselect Rule</option><option value=9>Dropdown Number limit </option><option value=10>Questions Recording Rule </option> 
<option value=11>AutoFixCode Rule </option>
<option value=12>Q. Option Range Rule </option> <option value=13>Grid QOP ShowHide Rule </option><option value=14>Grid Rank Considration Rule </option>
</select> <div id=oplist style='display:none;'>Total Value:<input type=number name=cnt id=cnt style='width:70px;' onchange='generaterule();'></div></td></tr>";
	
		$str.="<tr><td><button class='btn btn-primary' id='btn7' onclick='return copyrulefindreplacefirst();' style='display:none;'> Fill as FNR First Row </button> </td><td> <button class='btn btn-primary' id='btn3' onclick='return copyrulegridfirst();' style='display:none;'> Fill as  GRID First Row </button> <button class='btn btn-primary' id='btn13' onclick='return copyruleshowhidefirst();' style='display:none;'> Copy Show/Hide Top Row to All </button> </td></tr>";

	             $str.="<tr><td></td><td><div id='list' style='display:inline;'> </div></td></tr>";
	
	              $str.="<tr><td colspan='2'><hr> <input class='btn btn-primary' type=submit value='Add Rule'></td></tr>";
	              return $str;
	        }
	        public function geteditrule()
	        {
	              $projects=$this->getProjects();
	               
	              $str="<h5>Edit Rule</h5> <table width='100%'><tr><td>Project:</td><td> <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option 
value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select></td></tr><tr><td> Question Set:</td><td> <select class='form-control' name=qset id=qset><option value=select>--Select--</option> 
</select></td></tr>";
	              $str.="<tr><td> Rule Type:</td><td> <select class='form-control' name='rt' id='rt' onchange='editrule();'> <option value='0'>--Select--</option>
<option value=1>Asc order PSM Rule</option><option value=2>Project Tab Quota Rule</option><option value=3>Question Grid Rule</option><option value=4>Questiion AND Rule
</option><option value=5> Show Selected Options Only </option> <option value=6> Hide Selected Options Only </option><option value=7>Find & Replace Rule</option>
<option value=8>Q.Option autoselect Rule</option><option value=9>Dropdown Number limit </option><option value=10>Questions Recording Rule </option>
<option value=11>AutoFixCode Rule </option>
<option value=12>Q. Option Range Rule </option> <option value=13>Grid QOP ShowHide Rule </option><option value=14>Grid Rank Considration Rule </option>
</select> <div id=oplist style='display:none;'>Total 
Value:<input class='form-control' type=number name=cnt id=cnt style='width:70px;'></div></td></tr>";
	
	             $str.="<tr><td></td><td><div id='list' style='display:inline;'> </div></td></tr>";
	
	              //$str.="<tr><td></td><td> <input type=submit value='View'></td></tr>";
	              return $str;
	        }
	        public function getdeleterule()
	        {
	              $projects=$this->getProjects();
	               
	              $str="<h5>Delete Rule</h5><br> <table><tr><td>Project:</td><td> <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option 
value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select></td></tr><tr><td> Question Set:</td><td> <select class='form-control' name=qset id=qset><option value=select>--Select--</option> 
</select></td></tr>";
	              $str.="<tr><td> Rule Type:</td><td> <select class='form-control' name='rt' id='rt' onchange='getrule();'> <option value='0'>--Select--</option>
<option value=1>Asc order PSM Rule</option><option value=2>Project Tab Quota Rule</option><option value=3>Question Grid Rule</option><option value=4>Questiion AND Rule
</option><option value=5> Show Selected Options Only </option> <option value=6> Hide Selected Options Only </option><option value=7>Find & Replace Rule</option>
<option value=8>Q.Option autoselect Rule</option><option value=9>Dropdown Number limit </option><option value=10>Questions Recording Rule </option>
<option value=11>AutoFixCode Rule </option>

</select> <div id=oplist 
style='display:none;'>Total Value:<input class='form-control' type=number name=cnt id=cnt style='width:70px;' onkeyup='generaterule();'></div></td></tr>";
	
	             $str.="<tr><td></td><td><div id='list' style='display:inline;'> </div></td></tr>";
	
	              $str.="<tr><td></td><td> <input class='btn btn-primary' type=submit value='Delete Rule'  onclick='return(validate());' ></td></tr>";
	              return $str;
	        }
        public function getAddMedia()
        {
              $projects=$this->getProjects();
              $str="<h5>Add Rule</h5><br><br> Project:<br> <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option 
value='0'>--Select--</option>";
              foreach($projects as $p)
              { $pid=$p->project_id; $pn=$p->name;
                     $str.="<option value=$pid > $pn </option>";
              }
              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset onclick='getpqs();'><option value=select>--Select--</option> 
</select>";
              $str.="Question ID <br> <select class='form-control' name=qs id=qs> <option value=0>--Select--</option></select>";
              $str.="Media Type: <br> <select class='form-control' name=mt> <option value=0> --Select-- </option> <option value=1> Image </option> <option value=2> 
Audio</option><option value=3>Video</option></select>";
             $str.="Select File<br> <input class='form-control' type=file name=mediaf id=mediaf>";
              $str.="<br><input class='btn btn-primary' type=submit value=Upload  onclick='return(validate());' >";
              return $str;
        }
	        public function getaddcentre()
	        {
	              $projects=$this->getProjects();
	              
	              $str="New Centre Name: <input type='text' name='cn' id='cn'> <input type=submit value='Add New Centre'>";
	               
	              return $str;
	        }
	        public function getaddpproduct()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select QSet--</option> </select> <br> CODE:<input type='text' class='form-control' name='code' id='code'> <br>Product:<input class='form-control' type='text' name='prdn' id='prdn'> <input class='btn btn-primary' type=submit value='Add Product'>";
	              return $str;
	        }
	        public function getaddpstore()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();'> <option value='0'>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select Qset--</option> </select> <br> CODE:<input type='text' class='form-control' name='code' id='code'> <br>Store:<input class='form-control' type='text' name='sn' id='sn'> <input class='btn btn-primary' type=submit value='Add Store'>";
	              return $str;
	        }
	        public function getaddpsec()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();'> <option value='0'>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select Qset--</option> </select> ";
		      $str.="<br> CODE:<input class='form-control' type='text' name='code' id='code'> <br>SEC:<input class='form-control' type='text' name='sec' id='sec'> <br> <input class='btn btn-primary' type=submit value='Add SEC'>";
	              return $str;
	        }
		public function getaddarea()
                {
                      $projects=$this->getProjects();
		      $centres=$this->getCentres();
                      $str="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
                      foreach($projects as $p)
                      { $pid=$p->project_id; $pn=$p->name;
                             $str.="<option value=$pid > $pn </option>";
                      }
		      $str.="</select> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option> </select> ";
		      $str.="<br>Centre <select class='form-control' name='center' >";
		      foreach($centres as $c){
				$cid=$c->centre_id;$cn=$c->cname;
				$str.="<option value=$cid > $cn </option>";
		      }
		      $str.="</select> <br> CODE:<input class='form-control' type='text' name='code' id='code' placeholder='Enter Code'> <br>Area <input class='form-control' type='text' name='area' code='area' placeholder='Area Name'> <br><input class='btn btn-primary' type=submit value='Add Area'>";
                      return $str;
                }
		public function getaddsubarea()
                {
                      $projects=$this->getProjects();
		      $centres=$this->getCentres();
                      $str="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
                      foreach($projects as $p)
                      { $pid=$p->project_id; $pn=$p->name;
                             $str.="<option value=$pid > $pn </option>";
                      }
                      $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option> </select>";
		      $str.="<br>Centre <select class='form-control' name='center' >";
                      foreach($centres as $c){
                                $cid=$c->centre_id;$cn=$c->cname;
                                $str.="<option value=$cid > $cn </option>";
                      }
		      $str.="</select> <br> CODE:<input class='form-control' type='text' name='code' id='code' placeholer='Enter Code'> <br>Sub-Area <input class='form-control' type=text name='subarea' id='subarea' placeholder='Sub-Area Name'> <br> <input class='btn btn-primary' type=submit value='Add Sub-Area'>";
                      return $str;
                }
	        public function getaddpage()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option> </select> <br>CODE:<input type='text'  class='form-control' name='code' id='code'> <br>Age:<input class='form-control' type='text' name='age' id='age'><br> <input class='btn btn-primary' type=submit value='Add Age'>";
	              return $str;
	        }
 		
	        public function getaddtransq()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> Question Set: <select name=qset id=qset onclick='getpqs();'><option value=select>--Select--</option> </select><br>";
	              $str.="<br>Question ID : <select name=qs id=qs> <option value=0>--Select--</option></select> ";
	
	              $str.="Language: <select name='lang' id='lang'><option value=0>--Select--</option><option value=1>Hindi</option><option 
value=2>Kannada</option><option value=3>Malyalam</option><option value=4>Tammil</option><option value=5>Telgu</option><option value=6>Bangla</option></select>";
	              $str.="<br><br><textarea rows=4 cols=50 name=tv id=tv placeholder='Translated Question here...'></textarea><br><br><input type=submit 
value='Add Q. Translation'>";
	              return $str;
	        }
	        public function getaddtransqop()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> Question Set: <select name=qset id=qset onclick='getpqs();'><option value=select>--Select--</option> </select><br>";
	              $str.="<br>Question ID : <select name='qs' id='qs' onchange='gettqop();'> <option value=0>--Select--</option></select> ";
	
	              $str.="Language: <select name='lang' id='lang'><option value=0>--Select--</option><option value=1>Hindi</option><option 
value=2>Kannada</option><option value=3>Malyalam</option><option value=4>Tammil</option><option value=5>Telgu</option><option value=6>Bangla</option></select>";
	              $str.="<br><br><div id='qop'></div><br><br><input type=submit value='Add Q.Op. Translation'>";
	              return $str;
	        }
	        public function getaddpcrosstab()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option> </select> <input class='btn btn-primary' type=submit value='Add Crosstab'>";
	              return $str;
	        }
	
	        public function getcopyqbquest()
	        { $projects=$this->getProjects();
	              $str="Copy to Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option></select>";
	              $str.=" QNO: <input class='form-control' type=text id=qno name=qno style='width:120px;'><br><hr>SEARCH QUESTION:<br><br>Category: <select class='form-control' name='cat' id='cat' 
onChange =qcat('qbycat','');> <option value='0'>--Select--</option>";
	              $sql="SELECT `catid`, `name`, `remarks` FROM `category_detail` order by name";
	              $sdata=$this->getDataBySql($sql);
	              if($sdata)
	              foreach($sdata as $d)
	              {
	                 $id=$d->catid; $n=$d->name;
	                 //echo "<li> $id -- $n";
	                 $str.="<option value=$id > $n </option>";
	              }
	              $str.="</select> <br><br> <input class='form-control' type=text name='skey' id='skey' onKeyup =qcat('qbykey',''); placeholder='type keyword to search question from all category....' > <br><div id='qlist'></div><br><input class='btn btn-primary' type=submit value=Submit>";
	              return $str;
	        }
	        public function copyquestioninproject($pid,$qset,$qids,$qn)
	        {
			print_r($qids);
//return "bye";
			//$trm2=$qid.'_'.$qset; $trm3=$trm2.'_t';
	               $qn=strtoupper($qn);
	               $ptable=$this->getProjectTable($pid);
		     foreach($qids as $qid){
	               $sql="SELECT * FROM `question_detail` WHERE `q_id`=$qid;";
	               $qq=$this->getDataBySql($sql);
	               if($qq)
	               foreach($qq as $q)
	               {
                            //return " hello  ";
	                    $qtype=$q->q_type; $qimg=$q->image; $qaud=$q->audio; $qvid=$q->video; $qtitle=$q->q_title;
	                    $qarr=array('qset_id'=>$qset,'q_title'=>$qtitle,'q_type'=>$qtype,'qno'=>$qn,'image'=>$qimg,'video'=>$qvid,'audio'=>$qaud);
	                    $nqid=$this->insertIntoTable('question_detail',$qarr);
			    $trm2=$nqid.'_'.$qset; $trm3=$trm2.'_t';
	                    $qd2="SELECT * FROM `question_option_detail` WHERE `q_id`=$qid;";
	                    $qops=$this->getDataBySql($qd2);
	                    if($qtype=='radio' || $qtype=='checkbox')
	                    { $flag=0;
	                       foreach($qops as $qp)
	                       {
	                             $op_text=$qp->opt_text_value;
	                             $op_value=$qp->value;
				     $op_flag = $qp->flag;
	                             $oparr=array('q_id'=>$nqid,'opt_text_value'=>$op_text,'term'=>$trm2,'value'=>$op_value,'flag'=>$op_flag);
					$nqid1=$this->insertIntoTable('question_option_detail',$oparr); $flag=1;

				     	if($op_flag > 0){
					     $trmo=$trm2.'_'.$op_value.'_o';
	                                     $atq="ALTER TABLE $ptable ADD $trmo varchar(170) null;";
        	                             $ee=$this->doSqlDML($atq);
					}
	                       }
	                       if($flag>0)
	                       {
				     //$atq="ALTER TABLE $ptable ADD $trm2 varchar(2) not null, ADD $trm3 varchar(20);";
	                             $atq="ALTER TABLE $ptable ADD $trm2 varchar(2) not null;";
	                             $ee=$this->doSqlDML($atq);
	                             //return "Successfully copied qid: $qid to new qid: $nqid";
	                       }
	                    }
	                    if($qtype=='rating' )
	                    { $flag=0;
	                       foreach($qops as $qop)
	                       {
	                             $sv=$qop->scale_start_value;$ev=$qop->scale_end_value;
	                             $sl=$qop->scale_start_label;$el=$qop->scale_end_label;
	                             
	                             $oparr=array('q_id'=>$nqid,'scale_start_value'=>$sv,'scale_end_value'=>$ev,'scale_start_label`'=>$sl,'scale_end_label`'=>$el,'term'=>$trm2);
	                             $nqid1=$this->insertIntoTable('question_option_detail',$oparr); $flag=1;
	                       } 
	                       if($flag>0)
	                       {
				     //$atq="ALTER TABLE $ptable ADD $trm2 varchar(2) not null, ADD $trm3 varchar(20);";
	                             $atq="ALTER TABLE $ptable ADD $trm2 varchar(2) not null;";
	                             $ee=$this->doSqlDML($atq);
	                             //return "Successfully copied qid: $qid to new qid: $nqid";
	                       }
	                    }
	                    if($qtype=='text' || $qtype=='textarea' || $qtype=='dropdown')
	                    { $flag=0;
	                       foreach($qops as $qp)
	                       {
	                             $oparr=array('q_id'=>$nqid,'term'=>$trm2);
	                             $nqid1=$this->insertIntoTable('question_option_detail',$oparr); $flag=1;
	                       } 
	                       if($flag>0)
	                       {
				     //$atq="ALTER TABLE $ptable ADD $trm2 varchar(2) not null, ADD $trm3 varchar(20);";
	                             $atq="ALTER TABLE $ptable ADD $trm2 varchar(110) not null;";
	                             $ee=$this->doSqlDML($atq);
	                             //return "Successfully copied qid: $qid to new qid: $nqid";
	                       }
	                    }
			} //end of foreach for qids
	               }
			return "Successfully copied qids";
	        } //end of copy fuction

	        public function getcopypquest()
	        { $projects=$this->getProjects();
	              $str="Copy to Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select--</option></select>";
	              $str.=" QNO: <input class='form-control' type=text id=qno name=qno style='width:120px;'><br><hr>SEARCH QUESTION:<br><br>";
	              $str.="Search Questions By Project: <select class='form-control' name='fpn' id='fpn' onChange =qcat('qbyp','');> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select> <br> <input class='form-control' type=text name='skey' id='skey' onKeyup =qcat('qbykeyp',''); placeholder='type keyword to search question 
from all category....' > <br><div id='qlist'></div><br><input class='btn btn-primary' type=submit value=Submit>";
	              return $str;
	        }
			
	        public function getdeletesequence()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select name='pn' class='form-control' id='pn' onchange='getpqset();'> <option value='0'>--Select Project--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control' name=qset id=qset><option value=select>--Select QSet --</option> </select><br><div class='text-center'> <input type=submit class='btn btn-primary' value=Delete onclick='return(validate());' > </div>";
	              return $str;
	        }
	        public function getdeleteroutine()
	        {
	              $projects=$this->getProjects();
	              
	              $str="Project: <select class='form-control' name='pn' id='pn' onchange='getpqset();'> <option value='0'>--Select--</option>";
	              foreach($projects as $p)
	              { $pid=$p->project_id; $pn=$p->name;
	                     $str.="<option value=$pid > $pn </option>";
	              }
	              $str.="</select><br> Question Set: <select class='form-control'  name=qset id=qset><option value=select>--Select--</option> </select><br> <input type=submit class='btn btn-primary' value=Delete onclick='return(validate());' >";
	              return $str;
	        }
	        public function doaddrule($arr)
	        {
	              $rt=$arr['rt'];
	              $qset=$arr['qset'];
	              $cnt=$arr['cnt'];
			$flag = 0;
	              if($rt==1)
	              {
	                    for($i=1;$i<=$cnt;$i++)
		            { $a='stb'.$i; $b='tb'.$i;$c='grp'.$i;
	                         $a1=$arr[$a]; $b1=$arr[$b];$c1=$arr[$c];
                                 if($a1 != '' && $b1 != '' ){ $flag=1;
		                 	$tdata2=array('qset_id'=>$qset,'qid'=>$b1,'sno'=>$a1,'grp_code'=>$c1);
		                 	$insd=$this->insertIntoTable('question_rule_1',$tdata2);
	 	            	 }
			    }
		            if($flag==1) return $flag;
				return '<br>Successfully added rule for PSM';
	             }
	              if($rt==2)
	              {
	                    for($i=1;$i<=$cnt;$i++)
		            { $a='stb'.$i; $b='qid'.$i;$c='op'.$i; $d='q'.$i;
	                         $a1=$arr[$a]; $b1=$arr[$b];$c1=$arr[$c]; $d1=$arr[$d];
                                 if($a1 != '' && $b1 != '' ){ $flag=1;
		                 	$tdata2=array('qset_id'=>$qset,'tab_id'=>$a1,'qid'=>$b1,'op_val'=>$c1,'quota'=>$d1);
		                 	$insd=$this->insertIntoTable('question_rule_2',$tdata2);
	 	            	 }
			    }
		            if($flag==1) return $flag;
				return '<br>Successfully added rule for Quata<font color=red> ';
	             }
	              if($rt==3)
	              {
	                    for($i=1;$i<=$cnt;$i++)
		            {
				 $a='stb'.$i; $b='tb'.$i; $c='flag'.$i; $d = 'rw'.$i;
	                         $a1=$arr[$a]; $b1=$arr[$b]; $c1=$arr[$c]; $d1=$arr[$d];
                                 if($a1 != '' && $b1 != '' ){ $flag=1;
		                 	$tdata2=array('qid'=>$a1,'qset_id'=>$qset,'grp_id'=>$b1, 'row_no'=>$d1, 'flag'=>$c1);
		                  	$insd=$this->insertIntoTable('question_rule_3',$tdata2);
	 	            	}
			    }
		            return $flag;
	             }
             if($rt==4)
             {
                    for($i=1;$i<=$cnt;$i++)
	            { $a='stb'.$i; $b='tb'.$i;$c='flag'.$i;
                          $a1=$arr[$a]; $b1=$arr[$b]; $c1=$arr[$c];
                          if($a1 != '' && $b1 != '' ){ $flag=1;
	                  	$tdata4=array('qid'=>$a1,'qset_id'=>$qset,'cqid'=>$b1, 'flag'=>$c1);
	                  	$insd=$this->insertIntoTable('question_routine_and', $tdata4);
 	            	  }
		    }
	            return $flag;
             }
             if($rt==5)
             {
                    for($i=1;$i<=$cnt;$i++)
	            { $a='stb'.$i; $b='tb'.$i;
                          $a1=$arr[$a]; $b1=$arr[$b];
                          if($a1 != '' && $b1 != '' ){ $flag=1;
	                  	$tdata5=array('qid'=>$a1,'qset_id'=>$qset,'cqid'=>$b1);
	                  	$insd=$this->insertIntoTable('question_rule_show_op', $tdata5);
			 }
 	            }
	            return $flag;
             }
             if($rt==6)
             {
                    for($i=1;$i<=$cnt;$i++)
	            { $a='stb'.$i; $b='tb'.$i;
                          $a1=$arr[$a]; $b1=$arr[$b];
                         if($a1 != '' && $b1 != '' ){ $flag=1;
	                  	$tdata6=array('qid'=>$a1,'qset_id'=>$qset,'cqid'=>$b1);
	                  	$insd=$this->insertIntoTable('question_rule_hide_op', $tdata6);
			 }
 	            }
	            return $flag;
             }
             if($rt==7)
             {
                            for($i=1;$i<=$cnt;$i++)
                            {
				 $a='cqid'.$i; $b='rqid'.$i;$c='op'.$i; $d='fwd'.$i;$e='rwd'.$i;
                                 	$a1=$arr[$a]; $b1=$arr[$b];$c1=$arr[$c]; $d1=$arr[$d]; $e1=$arr[$e];
                                 if($a1 != '' && $b1 != '' ){ $flag=1;
                                 	$tdata7 = array('qset'=>$qset,'cqid'=>$a1,'rqid'=>$b1,'op_val'=>$c1,'fstr'=>$d1, 'rstr'=>$e1);
                                 	$insd=$this->insertIntoTable('question_word_findreplace',$tdata7);
				 }
                            }
                 if($flag==1) return $flag;
			//return '<br>Successfully added rule Wordreplace Quata';
             }
             if($rt==8)
             {
                            for($i=1;$i<=$cnt;$i++)
                            {
                                 $a='cqid'.$i; $b='pqid'.$i;$c='opv'.$i; $d='sval'.$i;$e='eval'.$i;
                                 $a1=$arr[$a]; $b1=$arr[$b];$c1=$arr[$c]; $d1=$arr[$d]; $e1=$arr[$e];
                                 if($a1 != '' && $b1 != '' ){ $flag=1;
				 	$tdata8=array('qset'=>$qset,'cqid'=>$a1,'opv'=>$c1,'pqid'=>$b1,'sval'=>$d1,'eval'=>$e1);
                                 	$insd=$this->insertIntoTable('question_rule_autoselect',$tdata8);
				}
                            }
                 if($flag==1) return $flag;
			//return '<br>Successfully added rule for autoselect';
             }
             if($rt==9)
             {
                            for($i=1;$i<=$cnt;$i++)
                            {
                                 $a='cqid'.$i; $b='opcode'.$i; $d='sval'.$i;$e='eval'.$i;
                                 $a1=$arr[$a]; $b1=$arr[$b]; $d1=$arr[$d]; $e1=$arr[$e];
                                 if($a1 != '' && $d != '' ){ $flag=1;
                               	 	$tdata9=array('qset'=>$qset,'cqid'=>$a1,'sval'=>$d1,'eval'=>$e1, 'opcode' => $b1);
                                 	$insd=$this->insertIntoTable('question_rule_numlimit',$tdata9);
				}
                            }
                 if($flag==1) return $flag;
			//return '<br>Successfully added rule for autoselect';
             }
             if($rt == 10)
             {
                    for($i=1;$i<=$cnt;$i++)
                    { 	  $a='qid'.$i;
                          $a1=$arr[$a];
                          if($a1 != ''){ $flag=1;
                          	$tdata10 = array('qid'=>$a1,'qset_id'=>$qset);
                          	$insd=$this->insertIntoTable('question_rule_recording', $tdata10);
			 }
                    }
                  if($flag==1) return $flag;
			//return '<br>Successfully added rule for Recording ';
             }
             if($rt==11)
             {
                 for($i=1;$i<=$cnt;$i++)
                 {
                                 $a='cqid'.$i;$b='pqid'.$i;  $c='copv'.$i;$d='val'.$i;
                                 $a1=$arr[$a]; $b1=$arr[$b]; $c1=$arr[$c];$d1=$arr[$d];
                                 if($a1 != '' && $d != '' ){ $flag=1;
                                        $tdata9=array('qset'=>$qset,'cqid'=>$a1,'pqid'=>$b1,'cqid_opv'=>$c1,'val'=>$d1);
                                        $insd=$this->insertIntoTable('question_rule_autofixcode',$tdata9);
                 		}
                 }
                 if($flag==1) return $flag; 
             }
             if($rt == 12)
             {
                    for($i=1;$i<=$cnt;$i++)
                    {     //$a='qid'.$i;
                          //$a1=$arr[$a];
                                 $a='cqid'.$i; $b='cqopfr'.$i; $c='cqopto'.$i; $d='pqid'.$i; $e='pqop'.$i;
                                 $a1=$arr[$a]; $b1=$arr[$b];$c1=$arr[$c]; $d1=$arr[$d]; $e1=$arr[$e];

                          if($a1 != ''){ $flag=1;
                                $tdata12 = array('cqid'=>$a1,'qset'=>$qset,'cqid_fr_op'=>$b1, 'cqid_to_op'=> $c1 , 'pqid'=> $d1, 'pqid_op'=>$e1);
                                $insd=$this->insertIntoTable('question_rule_oprange', $tdata12);
                         }
                    }
                  if($flag==1) return $flag;
                        //return '<br>Successfully added rule for Recording ';
             }
             if($rt==13)
             {
                            for($i=1;$i<=$cnt;$i++)
                            {
                                 $a='cqid'.$i; $b='pqid'.$i;  $c='pqop'.$i; $d='group'.$i;$e='flag'.$i;
                                 $a1=$arr[$a]; $b1=$arr[$b]; $c1=$arr[$c]; $d1=$arr[$d]; $e1=$arr[$e];
                                 if($a1 != '' && $d != '' ){ $flag=1;
                                        $tdata13=array('qset'=>$qset,'cqid'=>$a1,'pqid'=>$b1,'pqop'=>$c1,'group'=>$d1, 'flag' => $e1);
                                        $insd=$this->insertIntoTable('question_rule_gridqop_showhide',$tdata13);
                                }
                            }
                 if($flag==1) return $flag;
                        //return '<br>Successfully added rule for autoselect';
             }
             if($rt==14)
             {
                            for($i=1;$i<=$cnt;$i++)
                            {
                                 $a='consider'.$i; $b='group'.$i;  $c='rank'.$i;
                                 $a1=$arr[$a]; $b1=$arr[$b]; $c1=$arr[$c];
                                 if($a1 != '' && $b1 != '' ){ $flag=1;
                                        $tdata14=array('qset'=>$qset,'consider'=>$a1,'group'=>$b1,'rank'=>$c1);
                                        $insd=$this->insertIntoTable('question_rule_3_ext',$tdata14);
                                }
                            }
                 if($flag==1) return $flag;
                        //return '<br>Successfully added rule for autoselect';
             }

	 }

	public function doeditrule($qset,$rt)
	{
	              //$rt=$arr['rt'];
	              //$qset=$arr['qset'];
	              $str='';
	              if($rt==1)
	              {
		             $sql="SELECT `id`, `qset_id`, `qid`, `sno`, `grp_code` FROM `question_rule_1` WHERE qset_id=$qset";
	                     $rs=$this->getDataBySql($sql);
	                     if($rs)
	                     {
	                          $str="<table border=1><tr><td>QID</td><td>SNO</td><td>GROUP CODE</td><td colspan=2>Action</td></tr>";
	                          foreach($rs as $r)
	                          {
	                              $id=$r->id;$qid=$r->qid;$sn=$r->sno; $gc=$r->grp_code;
	                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=qid$id id=qid$id value=$qid></td><td><input type=text name=sn$id id=sn$id value=$sn></td><td><input type=text name=gc$id id=gc$id value=$gc></td><td><input type=button name=save$id value='Save' onClick=update('rule1',$id);><span id=$id></span></td><td><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rule1d',$id);></td></tr>";
	                          }
	                          $str.="</table>";
	
	                     }else $str= "No data available";
	                     return $str;
	              }
	              if($rt==2)
	              {
		             $sql="SELECT `id`, `qset_id`, `tab_id`, `qid`, `op_val`, `quota` FROM `question_rule_2` WHERE qset_id=$qset";
	                     $rs=$this->getDataBySql($sql);
	                     if($rs)
	                     {
	                           $str="<table border=1><tr><td>TAB ID</td><td>QID</td><td>OP VALUE</td><td>QUOTA LIMIT</td><td colspan=2>Action</td></tr>";
	                          
	                          foreach($rs as $r)
	                          {
	                              $id=$r->id;$qid=$r->qid;$tab=$r->tab_id;$op=$r->op_val; $q=$r->quota;
	                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id> <input type=text name=tab$id id=tab$id 
value=$tab></td><td><input type=text name=qid$id id=qid$id value=$qid></td><td><input type=text name=op$id id=op$id value=$op></td><td><input type=text 
name=q$id id=q$id value=$q></td><td><input type=button name=save$id value='Save' onClick=update('rule2',$id);> <input type=button 
name=delete$id value='Delete' style='background-color:red;' onClick=update('rule2d',$id);> <span id=$id></span> </td></tr>";
	                          } $str.="</table>";
	                     }else $str= "No data available";
	                     return $str;
	              }
	              if($rt==3)
	              {
		             $sql="SELECT `id`, `qid`, `qset_id`, `grp_id`, row_no, flag FROM `question_rule_3` WHERE qset_id=$qset";
	                     $rs=$this->getDataBySql($sql);
	                     if($rs)
	                     {
	                           $str="<table border=1><tr><td>QID</td><td>GROUP CODE</td><td>ROW</td><td>FLAG</td><td colspan=2>Action</td></tr>";
	                          foreach($rs as $r)
	                          {
	                              $id=$r->id;$qid=$r->qid; $gc=$r->grp_id; $flag=$r->flag; $rw=$r->row_no;
	                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=qid$id id=qid$id 
value=$qid></td><td><input type=text name=gc$id id=gc$id value=$gc></td><td><input type=text name=rw$id id=rw$id value=$rw></td>
<td><input type=text name=flag$id id=flag$id value=$flag></td>
<td><input type=button name=save$id value='Save' onClick=update('rule3',$id);> <input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rule3d',$id);> <span id=$id></span> </td></tr>";
	                          }$str.="</table>";
	                     }else $str= "No data available";
	                     return $str;
	              }
	      if($rt==4)
              {
	             $sql="SELECT * FROM `question_routine_and` WHERE qset_id=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>QID</td><td>CQID</td><td>FLAG</td><td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$qid=$r->qid; $cqid=$r->cqid; $flg=$r->flag;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=qid$id id=qid$id value=$qid></td><td><input 
type=text name=gc$id id=gc$id value=$cqid></td>
<td><input type=text name=flag$id id=flag$id value=$flg></td>
<td><input type=button name=save$id value='Save' onClick=update('ruleand',$id);> <input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('ruleandd',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
              if($rt==5)
              {
	             $sql="SELECT * FROM `question_rule_show_op` WHERE qset_id=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>QID</td><td>CQID</td><td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$qid=$r->qid; $cqid=$r->cqid;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=qid$id id=qid$id value=$qid></td><td><input 
type=text name=gc$id id=gc$id value=$cqid></td><td><input type=button name=save$id value='Save' onClick=update('ruleshow',$id);> <input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('ruleshowd',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
              if($rt==6)
              {
	             $sql="SELECT * FROM `question_rule_hide_op` WHERE qset_id=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>QID</td><td>CQID</td><td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$qid=$r->qid; $cqid=$r->cqid;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=qid$id id=qid$id value=$qid></td><td><input 
type=text name=gc$id id=gc$id value=$cqid></td><td><input type=button name=save$id value='Save' onClick=update('rulehide',$id);> <input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rulehided',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
	      //for question_word_findreplace
              if($rt==7)
              {
                     $sql="SELECT * FROM `question_word_findreplace` WHERE qset = $qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>PQID</td><td>CQID</td><td>CODE</td><td>Find String</td><td>Replace With String</td> <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$pqid=$r->rqid; $cqid=$r->cqid;$opv=$r->op_val; $fstr = $r->fstr; $rstr = $r->rstr;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=pqid$id id=pqid$id value=$pqid></td> 
                <td><input type=text name=cqid$id id=cqid$id value=$cqid></td>
                <td><input type=text name=opv$id id=opv$id value=$opv></td>
		<td><input type=text name=fstr$id id=fstr$id value='$fstr'></td>
                <td><input type=text name=rstr$id id=rstr$id value='$rstr'></td>
		<td><input type=button name=save$id value='Save' onClick=update('rulefindreplace',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rulefindreplaced',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
              //for question_rule_autoselect
              if($rt==8)
              {
                     $sql="SELECT * FROM `question_rule_autoselect` WHERE qset=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>PQID</td><td>CQID</td><td>OPV</td><td>Start Value</td><td>End Value</td> <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$pqid=$r->pqid; $cqid=$r->cqid;$opv=$r->opv; $fstr = $r->sval; $rstr = $r->eval;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=pqid$id id=pqid$id value=$pqid></td>
                <td><input type=text name=cqid$id id=cqid$id value=$cqid></td>
                <td><input type=text name=opv$id id=opv$id value=$opv></td>
                <td><input type=text name=fstr$id id=fstr$id value=$fstr></td>
                <td><input type=text name=rstr$id id=rstr$id value=$rstr></td>
                <td><input type=button name=save$id value='Save' onClick=update('ruleautoselect',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('ruleautoselectd',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
              //for question_rule_numlimit
              if($rt==9)
              {
                     $sql="SELECT * FROM `question_rule_numlimit` WHERE qset=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>CQID</td><td>OP Code</td><td>Start Value</td><td>End Value</td> <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id; $cqid=$r->cqid; $fstr = $r->sval; $rstr = $r->eval;$opv=$r->opcode;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=cqid$id id=cqid$id value=$cqid></td>
                <td><input type=text name=opcode$id id=opcode$id value=$opv></td>
                <td><input type=text name=fstr$id id=fstr$id value=$fstr></td>
                <td><input type=text name=rstr$id id=rstr$id value=$rstr></td>
                <td><input type=button name=save$id value='Save' onClick=update('rulenumlimit',$id);> <input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rulenumlimitd',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
              //for question_rule_recording
              if($rt==10)
              {
                     $sql="SELECT * FROM `question_rule_recording` WHERE qset_id=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>QID</td> <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$qid=$r->qid;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=qid$id id=qid$id value=$qid></td>
                <td><input type=button name=save$id value='Save' onClick=update('rulerecording',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rulerecordingd',$id);> <span id=$id></span></td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
              //for question_rule_autofixcode
              if($rt==11)
              {
                     $sql="SELECT * FROM `question_rule_autofixcode` WHERE qset=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>CQID</td><td>PQID</td><td>CQID OPTION VALUE</td><td>FIX VALUE</td> <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id;$pqid=$r->pqid;$cqid=$r->cqid;$copv=$r->cqid_opv;$val=$r->val;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id> 
			<input type=text name=pqid$id id=cqid$id value=$cqid></td><td>
                        <input type=text name=cqid$id id=pqid$id value=$pqid> </td><td>
                        <input type=text name=copv$id id=copv$id value=$copv> </td><td>
                        <input type=text name=val$id id=val$id value=$val>

		</td>
                <td><input type=button name=save$id value='Save' onClick=update('ruleautofixcode',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('ruleautofixcoded',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }

              //for question options range based on pqid option
              if($rt==12)
              {
                     $sql="SELECT * FROM `question_rule_oprange` WHERE qset=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>CQID</td><td>CQID OP FR</td><td>CQID OP TO</td><td>PQID</td> <td>PQID OP</td>  <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id; $cqid=$r->cqid; $cqopfr = $r->cqid_fr_op; $cqopto = $r->cqid_to_op; $pqid = $r->pqid;$pqop = $r->pqid_op;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=cqid$id id=cqid$id value=$cqid></td>
                <td><input type=text name=cqopfr$id id=cqopfr$id value=$cqopfr></td>
                <td><input type=text name=cqopto$id id=cqopto$id value=$cqopto></td>
                <td><input type=text name=pqid$id id=pqid$id value=$pqid></td>
                <td><input type=text name=pqop$id id=pqop$id value=$pqop></td>
                <td><input type=button name=save$id value='Save' onClick=update('ruleqoprange',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('ruleqopranged',$id);> <span id=$id></span> </td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
	     //for grid qop show/hide
              if($rt==13)
              {
                     $sql="SELECT * FROM `question_rule_gridqop_showhide` WHERE qset=$qset";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>CQID</td><td>PQID</td><td>PQID OP</td><td>GROUP</td><td>FLAG</td> <td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id; $cqid=$r->cqid; $pqid = $r->pqid; $pqop = $r->pqop;$grp = $r->group;$fg = $r->flag;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id><input type=text name=cqid$id id=cqid$id value=$cqid></td>
                <td><input type=text name=pqid$id id=pqid$id value=$pqid></td>
                <td><input type=text name=pqop$id id=pqop$id value=$pqop></td>
                <td><input type=text name=group$id id=group$id value=$grp></td>
                <td><input type=text name=flag$id id=flag$id value=$fg></td>
                <td><input type=button name=save$id value='Save' onClick=update('rulegridqopshowhide',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rulegridqopshowhided',$id);> <span id=$id></span></td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }
             //for grid rank consideration
              if($rt==14)
              {
                     $sql="SELECT * FROM `question_rule_3_ext` WHERE qset=$qset ;";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                           $str="<table border=1><tr><td>GROUP</td><td>OP CONSIDERATION</td><td>RANK</td><td colspan=2>Action</td></tr>";
                          foreach($rs as $r)
                          {
                              $id=$r->id; $consd = $r->consider;$grp = $r->group;$fg = $r->rank;
                              $str.="<tr><td><input type=hidden name=id$id id=id$id value=$id>
                		<input type=text name=group$id id=group$id value=$grp></td>
				<td><input type=text name=consider$id id=consider$id value=$consd></td>
                		<td><input type=text name=rank$id id=rank$id value=$fg></td>
                		<td><input type=button name=save$id value='Save' onClick=update('rulegridrankc',$id);><input type=button name=delete$id value='Delete' style='background-color:red;' onClick=update('rulegridrankcd',$id);> <span id=$id></span></td></tr>";
                          }$str.="</table>";
                     }else $str= "No data available";
                     return $str;
              }

       }
        public function getuserlist()
        {
                     $str='';
	             $sql="SELECT `user_id`, `user`, `role`, `create_date`, `last_login`, `status` FROM `admin_user` order by user_id desc";
                     $rs=$this->getDataBySql($sql);
                     if($rs)
                     {
                          $str="<table width=100% class='table table-striped'><tr><td>UserID</td><td>Login</td><td>Role</td><td>Created On</td> <td>Status</td></tr>";
                          foreach($rs as $r)
                          {
                              $uid=$r->user_id;$user=$r->user; $role=$r->role; $cdt=$r->create_date; $st=$r->status;
				$rr='';
				switch($role){
					case 1:
						$rr='Super Admin';break;
                                        case 2:
                                                $rr='Sub Admin';break;
                                        case 3:
                                                $rr='Team User';break;
                                        case 4:
                                                $rr='Client User';break;
					default:
						$rr='Not Known'; break;

				}
				$stt=$st==1?'Active':'Not Active';
                              $str.="<tr><td> $uid </td><td> $user </td><td> $rr </td><td> $cdt </td> <td> $stt </td></tr>";
                          }
                          $str.="</table>";
                     }
                     else $str= "No data available";
                     return $str;
         }
        public function displayUserPermission($data)
        {

              $str="";
              foreach($projects as $p)
              { $pid=$p->project_id; $pn=$p->name;
                     $str.="<option value=$pid > $pn </option>";
              }
              $str.="</select> Question Set: <select name=qset id=qset><option value=select>--Select--</option> </select> <input type=submit value=View>"; 
              return $str;
        }

    //to display project all data row wise per respondent--first call function
    public function getCustomData($pid,$qset=null,$isd=null,$sdt=null,$edt=null, $sl, $el, $cols)
    {
//print_r($cols);
//exit;
                       date_default_timezone_set("Asia/Kolkata");
                       $d=date("d-m-Y H:i:s");
 
                       //if($isd)
                      // {
                            $sm=(int)date("m",strtotime($sdt));
                            $yrs=(int)date("Y",strtotime($sdt));
                            $em=(int)date("m",strtotime($edt));
                      // } ?> <a href="<?php echo base_url(); ?>siteadmin/salogout"><i class="fa fa-user"></i> Sign Out</a> <?php
         if($qset!=0)
         {
                            echo "<br><center><font color=red>Survey Data of Project ID: $pid </font></center><br><br><br>";
                            $sql1="SELECT `data_table` FROM `project` WHERE `project_id`=$pid";
                            $rs1=$this->getDataBySql($sql1);
                            if($rs1)
                            {
                                    foreach($rs1 as $r1)
                                    {
                                       $dtable=$r1->data_table;
                                    }  
                                    //echo $dtable;
                            }
                 $colmsqno=array();$colms=array();$rdata=array();$mcolms=array();$mcolms2=array();
                 //$sql2="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'vcims' AND TABLE_NAME = '$dtable'";
                 //$rs2=$this->getDataBySql($sql2);
                 //if($rs2)
		if(!empty($cols))
                 {
                     //foreach($rs2 as $r2)
		     foreach($cols as $r2)
                     {
                         //$cn=$r2->COLUMN_NAME;
			 $cn = $r2;
                         $qt=$this->getPQType($cn);
                         $qtype=$qt['q_type']; $qt_id=$qt['q_id']; $qno=$qt['qno'];
			$arrc=array('id','resp_id','q_id','r_name','mobile','timestamp','centre','c_area','c_sub_area','i_name','i_mobile','i_date','e_date','address','o_sec','n_sec','gender','week_day','age','st','age_yrs','store','product','ref_no','latt','lang');

                       //if($qtype || in_array($cn,$arrc)){
                         if($qtype=='checkbox')
                         {
                               array_push($mcolms,$cn);
				//array_push($mcolms,$cnt);
                               $opc=$this->get_qop_count($qt_id);
					if($opc >= 5){ $opc=3;}
                                    for($i=1;$i<=$opc;$i++)
                                    {
                                        $cn1=$cn.'_'.$i; $dd=substr($cn1, strrpos($cn1, '_') + 1); //echo "<br> $dd=".strlen($dd);
                                        array_push($colms,$cn1);

					$qqnn=$qno.'-'.$i;
					array_push($colmsqno,$qqnn);
                                    }
                         }
                         else
			 {	//echo "<br> cn : $cn";
				array_push($colms,$cn); 
                                	//array_push($colms,$cnt);
				//if($qno!=''){
                 
					if($qno=='' || $qno==null){ 
						$qno='-';
						$str2 = substr( $cn, 0, -2 );
						$str3=substr($cn,-2);
						if($str3=='_t'){
                         			  $qt2=$this->getPQType($str2);
                         			  if($qt2){
							$qt2=$qt2['q_type']; 
							//$qno2=$qt2['qno'];
							//if($qt2) $qno=$qno2;
						  }
						}
					}
				if(!in_array($cn,$arrc)){ //echo " cnn : $qno";

					 array_push($colmsqno,$qno);
					 //array_push($colmsqno,$qno);
				}
				//}
			 }
		      // } //end of if qtype
                     }
                 }
      
                 $colm=array_shift($colms);array_shift($colms);array_shift($colms);
		 //print_r($mcolms);
		
	//print_r($colms); print_r($colmsqno);
		//to display data heading
		$strh= "<style>tr:nth-child(even){background-color: #f2f2f2}</style> <center><table border=1 cellpadding='0' cellspacing='0'><tr align=center bgcolor=lightgray><td>S.NO.</td><td>Resp_id</td><td>qset</td>";
		foreach($colms as $cn)
	        {
			 //if($cn == 'i_date' || $cn == 'e_date')$strh.="<td width='150px'>$cn</td>";
	                $strh.="<td>$cn</td>";
	        }
		$strh.="</tr>";
		echo $strh;

                $strhqno= "<tr align=center bgcolor=lightgray><td colspan=26></td>";
                foreach($colmsqno as $cqno)
                {
                       $strhqno.="<td>$cqno</td>";
                       //$strhqno.="<td>$cqno</td>";
                }
                $strhqno.="</tr>";
                echo $strhqno;
	        if($sl >= 0 && $el > 0) $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset order by resp_id, timestamp limit $sl,$el;";
		 else $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset  AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by resp_id, timestamp;";
		if($isd=='on')
		{
			/*
                    if($yrs==2016)
                    {
			if($qset==20)
				
                                $qr="SELECT distinct resp_id FROM $dtable WHERE month(visit_month_$qset)=$sm AND year(visit_month_$qset)=$yrs and resp_id > 727 
order by resp_id";
                        if($qset==40)
				$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset and month(visit_month_$qset)=$sm AND year(visit_month_$qset)=$yrs 
order by resp_id";
                                
			else
				$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset and month(i_date_$qset)=$sm AND year(visit_month_$qset)=$yrs order by 
resp_id";
                    }
			*/
                    if($yrs>2016)
                    {
                          //$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(i_date_$qset)=$sm AND year(i_date_$qset)=$yrs order by resp_id";
			 $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by timestamp,resp_id;";
                          if($sl >= 0 && $el > 0) 
				//$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(i_date)=$sm AND year(i_date)=$yrs order 
				//by resp_id limit $sl,$el";
			$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by timestamp, resp_id limit $sl,$el";
                          // if($qset==40)
                                //$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(visit_month_$qset)=$sm AND year(visit_month_$qset)=$yrs order by resp_id";
                    }
			
		}
	
	//echo $qr;
                 $rs3=$this->getDataBySql($qr);
                 if($rs3)
                 { $cnt=0; //print_r($rs3);
                     foreach($rs3 as $rp)
                     {
                          $cnt++;
                          $rsp=$rp->resp_id;
                          //to display one respondent's data details
				$rdata=array();$strr='';
				
				$rdata= $this->get_r_detailm($rsp,$qset,$dtable,$colms,$isd,$sm,$em,$yrs,$mcolms);
				//print_r($rdata);
				$strr= "<tr align=center><td>$cnt</td><td>$rsp</td><td>$qset</td>";
				foreach($rdata as $rd)
			        {
			               $strr.="<td>$rd</td>";
			        }
				$strr.="</tr>";
				echo $strr;
                     }
                 }
         }// end of qset check
    }


    //to display project all data row wise per respondent--first call function
    public function getProjectData($pid,$qset=null,$isd=null,$sdt=null,$edt=null, $sl, $el)
    {
                       date_default_timezone_set("Asia/Kolkata");
                       $d=date("d-m-Y H:i:s");
 
                       //if($isd)
                      // {
                            $sm=(int)date("m",strtotime($sdt));
                            $yrs=(int)date("Y",strtotime($sdt));
                            $em=(int)date("m",strtotime($edt));
                      // } ?> <a href="<?php echo base_url(); ?>siteadmin/salogout"><i class="fa fa-user"></i> Sign Out</a> <?php
         if($qset!=0)
         {
                            echo "<br><center><font color=red>Survey Data of Project ID: $pid </font></center><br><br><br>";
                            $sql1="SELECT `data_table` FROM `project` WHERE `project_id`=$pid";
                            $rs1=$this->getDataBySql($sql1);
                            if($rs1)
                            {
                                    foreach($rs1 as $r1)
                                    {
                                       $dtable=$r1->data_table;
                                    }  
                                    //echo $dtable;
                            }
                 $colmsqno=array();$colms=array();$rdata=array();$mcolms=array();$mcolms2=array();
                 //$sql2="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'vcims' AND TABLE_NAME = '$dtable'";
		$sql2="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'vcims' AND TABLE_NAME = '$dtable' AND COLUMN_NAME NOT IN (SELECT distinct(term) FROM vcims.question_option_detail WHERE q_id IN (SELECT qid FROM vcims.question_sequence where qset_id= $qset order by sid  asc) )";

                 $rs2=$this->getDataBySql($sql2);
                 if($rs2)
                 {
                     foreach($rs2 as $r2)
                     {
                         $cn=$r2->COLUMN_NAME;
			 //$cnt=$cn.'_t';
                         $qt=$this->getPQType($cn);
                         $qtype=$qt['q_type']; $qt_id=$qt['q_id']; $qno=$qt['qno'];
			$arrc=array('id','resp_id','q_id','r_name','mobile','timestamp','centre','c_area','c_sub_area','i_name','i_mobile','i_date','e_date','address','o_sec','n_sec','gender','week_day','age','st','age_yrs','store','product','ref_no','latt','lang');

                       //if($qtype || in_array($cn,$arrc)){
                         if($qtype=='checkbox')
                         {
                               array_push($mcolms,$cn);
				//array_push($mcolms,$cnt);
                               $opc=$this->get_qop_count($qt_id);
                                    for($i=1;$i<=$opc;$i++)
                                    {
                                        $cn1=$cn.'_'.$i; $dd=substr($cn1, strrpos($cn1, '_') + 1); //echo "<br> $dd=".strlen($dd);
                                        array_push($colms,$cn1);

					$qqnn=$qno.'-'.$i;
					array_push($colmsqno,$qqnn);
                                    }
                         }
                         else
			 {	//echo "<br> cn : $cn";
				array_push($colms,$cn); 
                                	//array_push($colms,$cnt);
				//if($qno!=''){
                 
					if($qno=='' || $qno==null){ 
						$qno='-';
						$str2 = substr( $cn, 0, -2 );
						$str3=substr($cn,-2);
						if($str3=='_t'){
                         			  $qt2=$this->getPQType($str2);
                         			  if($qt2){
							$qt2=$qt2['q_type']; 
							//$qno2=$qt2['qno'];
							//if($qt2) $qno=$qno2;
						  }
						}
					}
				if(!in_array($cn,$arrc)){ //echo " cnn : $qno";

					 array_push($colmsqno,$qno);
					 //array_push($colmsqno,$qno);
				}
				//}
			 }
		      // } //end of if qtype
                     }
                 }
      
		
		//bigin of tern for project based on sid
		 $sql3="SELECT distinct term FROM vcims.question_option_detail WHERE q_id IN (SELECT qid FROM vcims.question_sequence where qset_id=$qset order by sid ) AND q_id NOT IN(select q_id FROM vcims.question_detail where qset_id=342 AND q_type='imaged')";
                 $rs2=$this->getDataBySql($sql3);
                 if($rs2)
                 {
                     foreach($rs2 as $r2)
                     {
                         //$cn=$r2->COLUMN_NAME;
			 $cn=$r2->term;
			 //$cnt=$cn.'_t';
                         $qt=$this->getPQType($cn);
                         $qtype=$qt['q_type']; $qt_id=$qt['q_id']; $qno=$qt['qno'];
			$arrc=array('id','resp_id','q_id','r_name','mobile','timestamp','centre','c_area','c_sub_area','i_name','i_mobile','i_date','e_date','address','o_sec','n_sec','gender','week_day','age','st','age_yrs','store','product','ref_no','latt','lang');

                       //if($qtype || in_array($cn,$arrc)){
                         if($qtype=='checkbox')
                         {
                               array_push($mcolms,$cn);
				//array_push($mcolms,$cnt);
                               $opc=$this->get_qop_count($qt_id);
                                    for($i=1;$i<=$opc;$i++)
                                    {
                                        $cn1=$cn.'_'.$i; $dd=substr($cn1, strrpos($cn1, '_') + 1); //echo "<br> $dd=".strlen($dd);
                                        array_push($colms,$cn1);

					$qqnn=$qno.'-'.$i;
					array_push($colmsqno,$qqnn);
                                    }
                         }
                         else
			 {	//echo "<br> cn : $cn";
				array_push($colms,$cn); 
                                	//array_push($colms,$cnt);
				//if($qno!=''){
                 
					if($qno=='' || $qno==null){ 
						$qno='-';
						$str2 = substr( $cn, 0, -2 );
						$str3=substr($cn,-2);
						if($str3=='_t'){
                         			  $qt2=$this->getPQType($str2);
                         			  if($qt2){
							$qt2=$qt2['q_type']; 
							//$qno2=$qt2['qno'];
							//if($qt2) $qno=$qno2;
						  }
						}
					}
				if(!in_array($cn,$arrc)){ //echo " cnn : $qno";

					 array_push($colmsqno,$qno);
					 //array_push($colmsqno,$qno);
				}
				//}
			 }
		      // } //end of if qtype
                     }
                 }

		//end of term based on sid

                 $colm=array_shift($colms);array_shift($colms);array_shift($colms);
		// print_r($mcolms);
		
	//print_r($colms); print_r($colmsqno);
		//to display data heading
		$strh= "<style>tr:nth-child(even){background-color: #f2f2f2}</style> <center><table border=1 cellpadding='0' cellspacing='0'><tr align=center bgcolor=lightgray><td>S.NO.</td><td>Resp_id</td><td>qset</td>";
		foreach($colms as $cn)
	        {
			 //if($cn == 'i_date' || $cn == 'e_date')$strh.="<td width='150px'>$cn</td>";
	                $strh.="<td>$cn</td>";
	        }
		$strh.="</tr>";
		echo $strh;

                $strhqno= "<tr align=center bgcolor=lightgray><td colspan=26></td>";
                foreach($colmsqno as $cqno)
                {
                       $strhqno.="<td>$cqno</td>";
                       //$strhqno.="<td>$cqno</td>";
                }
                $strhqno.="</tr>";
                echo $strhqno;
	        if($sl >= 0 && $el > 0) $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset order by resp_id, timestamp limit $sl,$el;";
		 else $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset  AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by resp_id, timestamp;";
		if($isd=='on')
		{
			/*
                    if($yrs==2016)
                    {
			if($qset==20)
				
                                $qr="SELECT distinct resp_id FROM $dtable WHERE month(visit_month_$qset)=$sm AND year(visit_month_$qset)=$yrs and resp_id > 727 
order by resp_id";
                        if($qset==40)
				$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset and month(visit_month_$qset)=$sm AND year(visit_month_$qset)=$yrs 
order by resp_id";
                                
			else
				$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset and month(i_date_$qset)=$sm AND year(visit_month_$qset)=$yrs order by 
resp_id";
                    }
			
                    if($yrs>2016)
                    { */
                          //$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(i_date_$qset)=$sm AND year(i_date_$qset)=$yrs order by resp_id";
//// OLD CODE  $qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by timestamp,resp_id;";
$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by resp_id desc;";
                          if($sl >= 0 && $el > 0) 
				//$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(i_date)=$sm AND year(i_date)=$yrs order 
				//by resp_id limit $sl,$el";
			$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND date(timestamp) >= '$sdt' AND date(timestamp) <= '$edt' order by resp_id desc limit $sl,$el";
                          // if($qset==40)
                                //$qr="SELECT distinct resp_id FROM $dtable WHERE q_id=$qset AND month(visit_month_$qset)=$sm AND year(visit_month_$qset)=$yrs order by resp_id";
                    //}
			
		}
	
	//echo $qr;
                 $rs3=$this->getDataBySql($qr);
                 if($rs3)
                 { 
		     $cnt=0; 
		//print_r($rs3);
                     foreach($rs3 as $rp)
                     {
                          $cnt++;
                          $rsp=$rp->resp_id;
                          //to display one respondent's data details
				$rdata=array();$strr='';
				
				$rdata= $this->get_r_detailm($rsp,$qset,$dtable,$colms,$isd,$sm,$em,$yrs,$mcolms);
				//print_r($rdata);
				$strr= "<tr align=center><td>$cnt</td><td>$rsp</td><td>$qset</td>";
				foreach($rdata as $rd)
			        {
			               $strr.="<td>$rd</td>";
			        }
				$strr.="</tr>";
				echo $strr;
                     }
                 }
         }// end of qset check
    }
    public function getPQType($cn=null)
    {
	        $query=$this->db->query("SELECT q_id,q_type, qno FROM question_detail where q_id in (SELECT distinct `q_id` FROM `question_option_detail` WHERE 
`term` = '$cn')");
	        $results=$query->row();
	        if($results)
	        {
	        	$qt=$results->q_type; $qn=$results->q_id; $qno=$results->qno; $arr=array("q_id"=>$qn,"q_type"=>$qt,"qno"=>$qno);
	        	return $arr;
	        	
	        }
	        else
	        	return false;
    }
    public function get_qop_count($qid=null)
    {
              if($qid!=null)
              {
                $this->db->select('count(*) as cnt');
	        $query=$this->db->get_where('question_option_detail',array('q_id' => $qid));
	        $result=$query->row();
	        if($result)
	        	return $result->cnt;
	        else
	        	return false;
             } else return false;
    }

	
    public function get_r_detailm($resp=null,$qset=null,$dtable=null,$colmn,$isd=null,$sm=null,$em=null,$yrs=null,$mcolmn)
    {
	        $rrdata=array(); $tmpdata=array();
		//print_r($colmn);
		//print_r($mcolmn);

	                foreach($colmn as $cn)
	                {
			     	$dd='';
                             	$dnm = substr($cn, strrpos($cn, '_') + 1);
				$dlen = strlen($dnm);
				$dlen = $dlen+1;
				$dtlen = strlen($cn);
                             	$difflen = $dtlen-$dlen;
				$cnn = substr($cn,0,$difflen);

				//echo "<br> cn: $cn, dnm: $dnm, cnn: $cnn <br>";

	                     //if($isd==0)
	                     //{
				/*  $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''; ";
                                 if(in_array($cnn,$mcolmn))
                                 {
	                           $qrr="SELECT $cnn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm'; ";
                                 }
				*/
                             //}
                            // if($isd==1)
                             //{
				//$qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!='' and month(timestamp) between $sm and $em";
                               // $qrr="SELECT $cn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cn!=''; ";
                             //}
			//echo "<br> $qrr ";


                                if(in_array($cnn,$mcolmn))
                                {
                                   //$qrr=" SELECT $cnn as cc FROM $dtable WHERE q_id=$qset AND resp_id =$resp and $cnn!='' AND $cnn='$dnm'; ";
					if($dnm == 1){
						$tmpdata=array();
					     	$qrr1 = " SELECT $cnn as cc FROM $dtable WHERE  resp_id =$resp and $cnn!=''; ";
					//echo "<br> m: $qrr1 ";
                             	    		$rs1=$this->getDataBySql($qrr1);
                             	    		if($rs1)
                             	    		{
                                 		  foreach($rs1 as $r1)
                                 		  {
                                    			$ds=$r1->cc;
							array_push($tmpdata,$ds);
                                 		  }
                             	    		}
						$nm=1;
                                                if(in_array($nm,$tmpdata)){
                                                        $dd=$nm;
                                                }
                                                array_push($rrdata,$dd);

					}
					else if($dnm > 1){
						if(in_array($dnm,$tmpdata)){
							$dd=$dnm;
						}
						array_push($rrdata,$dd);
					}
                                	else if($dnm == 't'){
                                        $qrr="SELECT $cn as cc FROM $dtable WHERE  resp_id =$resp and $cn!=''; ";
                                        //echo "<br> $qrr";
                                        $rs1=$this->getDataBySql($qrr);
                                        if($rs1)
                                        {
                                                foreach($rs1 as $r1)
                                                {
                                                        $dd=$r1->cc;
                                                }
                                        }
                                                array_push($rrdata,$dd);
                                   } //end of if == t 
                                }
			        else{
			     		$qrr="SELECT $cn as cc FROM $dtable WHERE resp_id =$resp and $cn!=''; ";
					//echo "<br> $qrr";
                             		$rs1=$this->getDataBySql($qrr);
                             		if($rs1)
                             		{
                                 		foreach($rs1 as $r1)
                                 		{
	                            			$dd=$r1->cc;
                                 		}
			     		}
	                     			array_push($rrdata,$dd);
	                	} //end of else
			} //end of foreach
	                return $rrdata;

    }
}
