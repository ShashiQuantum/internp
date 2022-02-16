<?php
class MApplog extends CI_Model
{
	public function getDataBySql($sql)
	{ 
	        $query=$this->db->query($sql);
	        $result= $query->result();
	        if($result)
		    return $result;
		else
		    return false;
    	}
    
    	function get_posts($number = 10, $start = 0)
        {
            $this->db->select();
            $this->db->from('posts');
            $this->db->where('active',1);
            $this->db->order_by('date_added','desc');
            $this->db->limit($number, $start);
            $query = $this->db->get();
            return $query->result_array();
        }
    	function search_applog($query,$query2)
    	{
    		/* $this->db->select();
    		$this->db->from('app_log');
    		$this->db->like("start_time", $query, 'both');
    		$this->db->or_like("resp_id", $query, 'both');
    		$this->db->order_by('resp_id', 'asc');
    		$this->db->order_by('start_time', 'desc');
    		$query = $this->db->get();
    		*/
    		$this->db->from('app_log');
    		$this->db->where("date(`start_time`) BETWEEN '$query' AND '$query2'  group by resp_id, date(start_time) ");
    		$this->db->order_by('resp_id', 'asc');
    		$this->db->order_by('start_time', 'desc');
    		$query = $this->db->get();
    		return $query->result_array();
    	}
    	
        function get_post_count()
        {
            //$this->db->select()->from('posts')->where('active',1);
            $this->db->select()->from('app_log')->where( 'resp_id in (select distinct resp_id from app_log)');
            $query = $this->db->get();
            return $query->num_rows;
        }
        function get_post($post_id)
        {
            $this->db->select();
            $this->db->from('posts');
            $this->db->where(array('active'=>1,'post_id'=>$post_id));
            $this->db->order_by('date_added','desc');
            $query = $this->db->get();
            return $query->first_row('array');
    	}
    	public function getProjects()
	{ 
	        $query=$this->db->query('select * from project order by project_id desc');
	        return $query->result();
    	}
    	function get_respdetail($mob)
	{
	        $query=$this->db->query("SELECT  `resp_id`,  `r_name`, `mobile`, `centre_110` FROM `zinnia_110` where mobile = '$mob'");
	        $results=$query->result();
	        if($results) return $results;
		else return 0;
    	}
	function get_morespdetail($resp)
	{
	        $query=$this->db->query("SELECT `r_name`,  `mobile`, `centre_57`, `i_date_57`, `gender_57`,  `nresp_educ`, `age_yrs`, `state` FROM `mangopinion_57` WHERE resp_id = '$resp' AND email!=''");
	        $results=$query->result();
	        if($results) return $results;
		else return 0;
    	}
    	function get_user_mob($resp_id)
	{
		$query=$this->db->query("SELECT mobil FROM `app_user` WHERE user_id=$resp_id");
		$result=$query->row();
		if($result) return $result->mobil;
		else return 0;
    	}
	function get_resp($resp_id)
        {
                $query=$this->db->query("SELECT  `resp_id`,  `r_name`, `mobile`, `centre_110` FROM `zinnia_110` where mobile = (SELECT mobil FROM `app_user` WHERE user_id=$resp_id )");
                return $query->result();
        }
    	function get_respnitem($resp_id)
	{
		        $query=$this->db->query("SELECT count(`q1_57`) as cnt   FROM `mangopinion_57` WHERE resp_id=$resp_id AND q1_57!=''");
		        $result=$query->row();
			if($result) return $result->cnt;
			else return 0;
    	}
    	function get_respedu($resp_id)
	{
			$query=$this->db->query("SELECT  `q3_57` as edu FROM `mangopinion_57` WHERE resp_id=$resp_id and q3_57!=''");
			$result=$query->row();
			if($result) return $result->edu;
			else return 0;
    	}
    	function get_inst_app($resp_id,$st,$app)
	{
			$query=$this->db->query("SELECT  * FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND app='$app' AND app_status in (1,3)");
			$result=$query->row();
			if($result) return 'Yes';
			else return 'No';
    	}
    	function get_nevent($resp_id,$st)
	{
			$query=$this->db->query("SELECT  count(distinct day_event) as cntr FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND app_status=3");
			$result=$query->row();
			if($result) return $result->cntr;
			else return 0;
    	}
    	function get_travelstatus($resp_id,$st,$evt)
	{
			$query=$this->db->query("SELECT  * FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND travel_status=1 AND day_event=$evt");
			$result=$query->row();
			if($result) return 1;
			else return 0;
    	}
    	function get_travelstatustime($resp_id,$st,$evt)
	{
		//if($resp_id ==225) return  "SELECT start_time as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND travel_status=1 AND day_event=$evt";

			$query=$this->db->query("SELECT start_time as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND travel_status=1 AND day_event=$evt");
			$result=$query->row();
			if($result) return $result->t;
			else return 0;
    	}
    	function get_appname($resp_id,$st,$evt,$n)
	{
		$qr="SELECT  app FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 0,1";
		if($n=='2') $qr="SELECT  app FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 1,1";
		if($n=='3') $qr="SELECT  app FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1";
		if($n=='4') $qr="SELECT  app FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1";
		
		$query=$this->db->query($qr);
		$result=$query->row();
		if($result) return $result->app;
		else return 0;
    	}
    	function get_appduration($resp_id,$st,$evt,$n)
	{
		$qr="SELECT  duration as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 0,1";
		if($n=='2') $qr="SELECT  duration as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 1,1";
		if($n=='3') $qr="SELECT  duration as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1";
		if($n=='4') $qr="SELECT  sum(duration) as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt order by start_time desc ";
		
		$query=$this->db->query($qr);
		$result=$query->row();
		if($result) return $result->t;
		else return 0;
    	}
    	function get_nappswitch($resp_id,$st,$evt)
	{
		$query=$this->db->query("SELECT  count(start_time) as t FROM `app_log` WHERE resp_id=$resp_id and date(start_time)=date('$st') AND day_event=$evt");
		$result=$query->row();
		if($result) return $result->t;
		else return 0;
    	}
    	function get_resptravel($resp_id,$st,$evt)
	{
		$query=$this->db->query("SELECT  a1_111 as t FROM `jasmine_111` WHERE resp_id=$resp_id and  i_date_111 ='$st'  and a1_111!=''");
		$result=$query->row();
		if($result) return $result->t;
		else return 0;
    	}
    	function get_travelou($resp_id,$st,$evt)
	{
			$query=$this->db->query("SELECT  a2_111 as t FROM `jasmine_111` WHERE resp_id=$resp_id and  i_date_111 ='$st'  and a2_111!=''");
			$result=$query->row();
			if($result){ $d=$result->t; $dd=''; if($d>0 && $d<14) $dd='Ola';if($d>13 && $d<21) $dd='Uber';  return $dd;}
			else return 0;
    	}
    	function get_resptravelmode($resp_id,$st,$evt)
	{
		$query=$this->db->query("SELECT  a2_111 as t FROM `jasmine_111` WHERE resp_id=$resp_id and i_date_111='$st'  and a2_111!=''");
		$result=$query->row();
			if($result) return $result->t;
			else return 0;
    	}
	function get_respola($resp_id,$st,$evt)
	{
		$query=$this->db->query("SELECT  a4_111 as t FROM `jasmine_111` WHERE resp_id=$resp_id and  i_date_111 = '$st'  and a4_111!=''");
		$result=$query->row();
		if($result) return $result->t;
		else return 0;
			
    	}
    	function get_respola2($resp,$st,$evt)
	{
			$qq="SELECT  a4_111 as t FROM `jasmine_111` WHERE resp_id=$resp and  i_date_111 ='$st'  and a4_111!=''";
			
			$qs=$this->getDataBySql($qq);
			 //$re=$query->result();
			 
			$arr=array();
			if($qs)
			foreach($qs as $r)
			{
				$aa=$r->t; array_push($arr,$aa);
				 
			}
			 
			return $arr;		
    	}
    	function get_respuber2($resp,$st,$evt)
	{
				$qq="SELECT  a5_111 as t FROM `jasmine_111` WHERE resp_id=$resp and  i_date_111 = '$st'  and a5_111!=''";
				
		//if($resp=='3') $qq="SELECT  a5_111 as t FROM `jasmine_111` WHERE resp_id='3' and  i_date_111 = '2017-09-05 01:58:12'  and a5_111!=''";  //to check for demo purpose
		
				$qs=$this->getDataBySql($qq);
				 //$re=$query->result();
				 
				$arr=array();
				if($qs)
				foreach($qs as $r)
				{
					$aa=$r->t; array_push($arr,$aa);
					 
				}
				 
				return $arr;		
    	}
    	function get_respuber($resp_id,$st)
	{
			$query=$this->db->query("SELECT  a4_111 as t FROM `jasmine_111` WHERE resp_id=$resp_id and  i_date_111 = '$st'  and a4_111!=''");
			$result=$query->row();
			if($result) return $result->t;
			else return 0;
    	}
    	function get_respocas($resp_id,$st)
	{
				$query=$this->db->query("SELECT  a3_111 as t FROM `jasmine_111` WHERE resp_id=$resp_id and  i_date_111 = '$st'  and a3_111!=''");
				$result=$query->row();
				if($result) return $result->t;
				else return 0;
    	
	}
	function get_gen($resp_id)
        {
                $query=$this->db->query("SELECT rq2_110 as t FROM zinnia_110 WHERE resp_id='$resp_id' AND rq2_110!=''");
                $result=$query->row();
                        if($result) return $result->t;
                        else return 0;
        }
	function get_age($resp_id)
        {
                $query=$this->db->query("SELECT rq8_110 as t FROM zinnia_110 WHERE resp_id='$resp_id' AND rq8_110!=''");
                $result=$query->row();
                        if($result) return $result->t;
                        else return 0;
        }
	function get_sec($resp_id)
        {
                $query=$this->db->query("SELECT sec_110 as t FROM zinnia_110 WHERE resp_id='$resp_id' AND sec_110!=''");
                $result=$query->row();
                        if($result) return $result->t;
                        else return 0;
        }

    	
}

