<?php
class MOla extends CI_Model
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
    	public function getProjects()
	{ 
	        $query=$this->db->query('select * from project order by project_id desc');
	        return $query->result();
    	}
    	function get_log_resp()
	{
	        $query=$this->db->query("SELECT distinct `resp_id`,`start_time` FROM `app_log` group by `resp_id`, date(`start_time`) ORDER BY `resp_id` asc, `start_time` desc ");
	        $results=$query->result();
	        if($results) return $results;
		else return 0;
    	}
    	function get_basic($resp)
	{
		$qr="SELECT distinct `resp_id`,
		(SELECT `gender_57` FROM `mangopinion_57` WHERE resp_id = '$resp' AND email!='' limit 1) as rq1,
		(SELECT `age_yrs` FROM `mangopinion_57` WHERE resp_id = '$resp' AND email!='' limit 1) as rq2,
		(SELECT `state` FROM `mangopinion_57` WHERE resp_id = '$resp' AND email!='' limit 1) as rq3
		
		 FROM `mangopinion_57` WHERE resp_id='$resp' AND email!=''";

	        $query=$this->db->query($qr);
	        $results=$query->result();
	        if($results) return $results;
		else return 0;
    	}
    	
    	function get_appbasic($resp,$st)
	{
			$qr="SELECT distinct `resp_id`,
			(SELECT  count(distinct day_event) FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND app_status=3 limit 1) as ab1,
			(SELECT  app_status FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND app='Ola' AND app_status in (1,3) limit 1) as ab2,
			(SELECT  app_status FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND app='Uber' AND app_status in (1,3) limit 1) as ab3
			
			 FROM `app_log` WHERE resp_id='$resp' AND date(start_time)=date('$st') limit 1";
	
		        $query=$this->db->query($qr);
		        $results=$query->result();
		        if($results) return $results;
			else return 0;
    	}
    	
    	function get_appevent($resp,$st,$evt)
	{
				$qr="SELECT distinct `resp_id`,
				(SELECT  travel_status FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND travel_status=1 AND day_event=$evt limit 1) as a1,
				(SELECT  start_time FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND travel_status=1 AND day_event=$evt limit 1) as a2,
				(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time asc limit 0,1 ) as a3,
				(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 0,1) as a4,
				(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time asc limit 1,1 ) as a5,
				(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 1,1) as a6,
		                (SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1 ) as a7,
				(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time desc limit 0,1) as a8,
				(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1 ) as a9,
				(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time desc limit 1) as a10
				
								
				 FROM `app_log` WHERE resp_id='$resp' AND date(start_time)=date('$st') limit 1";
		
			        $query=$this->db->query($qr);
			        $results=$query->result();
			        if($results) return $results;
				else return 0;
    	}

    	function get_app1($resp,$st,$evt)
	{
				$qr="SELECT distinct `resp_id`,
				(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time asc limit 0,1 ) as a3,
				(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 0,1) as a4
												
				 FROM `app_log` WHERE resp_id='$resp' limit 1";		
			        $query=$this->db->query($qr);
			        $results=$query->result();
			        if($results) return $results;
				else return 0;
    	}
    	function get_app2($resp,$st,$evt)
	{
					$qr="SELECT distinct `resp_id`,
				(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time asc limit 1,1 ) as a5,
				(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc limit 1,1) as a6
				
					 FROM `app_log` WHERE resp_id='$resp' limit 1";		
				        $query=$this->db->query($qr);
				        $results=$query->result();
				        if($results) return $results;
					else return 0;
    	}
    	function get_app3($resp,$st,$evt)
	{
		$qr="SELECT distinct `resp_id`,
		(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1 ) as a7,
		(SELECT  duration  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time desc limit 0,1) as a8
					
		FROM `app_log` WHERE resp_id='$resp' limit 1";		
					        $query=$this->db->query($qr);
					        $results=$query->result();
					        if($results) return $results;
						else return 0;
    	}
    	function get_app4($resp,$st,$evt)
	{
		$qr="SELECT distinct `resp_id`,
		(SELECT  app FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt order by start_time desc limit 0,1 ) as a9,
		(SELECT  sum(duration)  FROM `app_log` WHERE resp_id=$resp and date(start_time)=date('$st') AND day_event=$evt  order by start_time asc ) as a10
					
		FROM `app_log` WHERE resp_id='$resp' limit 1";		
					        $query=$this->db->query($qr);
					        $results=$query->result();
					        if($results) return $results;
						else return 0;
    	}
    	
 } // end of class
