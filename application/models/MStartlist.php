<?php
class MStartlist extends CI_Model
{

	function do_startlist($dt)
	{   
		$arr=array();
		$query=$this->db->query("SELECT distinct resp_id, date(start_time) as start_time FROM app_log where date(start_time) = date('$dt') AND resp_id not in (SELECT distinct resp_id FROM applog_list WHERE date(start_time)=date('$dt')) order by resp_id");
		$results=$query->result();
		if($results) 
		{
		  foreach($results as $r)
		  {  
		  	$qs=0;
			$rp=$r->resp_id; $d=$r->start_time; 
			array_push($arr,$rp);
			$qq="INSERT INTO `applog_list`(`resp_id`, `start_time`, `flag`) VALUES ('$rp','$d','0');";
			//$qs=$this->doSqlDML($qq);
			$qs=$this->db->query($qq);
		  }
			return $arr;
		}
		if(!$results) return $arr;
    	}
    	function do_eventrptgen($dt)
	{       $str='No data';
		$query=$this->db->query("SELECT distinct resp_id, date(start_time) as start_time FROM applog_list WHERE date(start_time)=date('$dt') AND flag=0 order by start_time asc, resp_id limit 30");
		$results=$query->result();
		if($results) 
		{   $str='';
		     $ab1=0;$ab2=0;$ab3=0;
		     $a1=0;$a2=0;$a3=0;$a4=0;$a5=0;$a6=0;$a7=0;$a8=0;$a9=0;$a10=0;
		     
			//for each respondent of flag=0
			foreach($results as $r)
			{  
				$str1='';$st='';
				$resp=$r->resp_id; $st=$r->start_time; 
				//testing to call procedure
				
				$evt=0;
				$ab1=0;$ab2=0;$ab3=0;$ab4=0;
				$a1=0;$a2=0;$a3=0;$a4=0;$a5=0;$a6=0;$a7=0;$a8=0;$a9=0;$a10=0;
				$a11=0;$a12=0;$a13=0;$a14=0;$a15=0;
				$a16=0;$a17=0;$a18=0;$a19=0;$a20=0;$a21=0;$a22=0;$a23=0;$a24=0;$a25=0;$a26=0;$a27=0;$a28=0;$a29=0;
				$b1=0;$b2=0;$b3=0;$b4=0;$b5=0;$b6=0;$b7=0;$b8=0;$b9=0;$b10=0;
				$b11=0;$b12=0;$b13=0;$b14=0;$b15=0;
				$b16=0;$b17=0;$b18=0;$b19=0;$b20=0;$b21=0;$b22=0;$b23=0;$b24=0;$b25=0;$b26=0;$b27=0;$b28=0;$b29=0;
				$c1=0;$c2=0;$c3=0;$c4=0;$c5=0;$c6=0;$c7=0;$c8=0;$c9=0;$c10=0;
				$c11=0;$c12=0;$c13=0;$c14=0;$c15=0;
				$c16=0;$c17=0;$c18=0;$c19=0;$c20=0;$c21=0;$c22=0;$c23=0;$c24=0;$c25=0;$c26=0;$c27=0;$c28=0;$c29=0;
				$d1=0;$d2=0;$d3=0;$d4=0;$d5=0;$d6=0;$d7=0;$d8=0;$d9=0;$d10=0;
				$d11=0;$d12=0;$d13=0;$d14=0;$d15=0;
				$d16=0;$d17=0;$d18=0;$d19=0;$d20=0;$d21=0;$d22=0;$d23=0;$d24=0;$d25=0;$d26=0;$d27=0;$d28=0;$d29=0;
				$e1=0;$e2=0;$e3=0;$e4=0;$e5=0;$e6=0;$e7=0;$e8=0;$e9=0;$e10=0;
				$e11=0;$e12=0;$e13=0;$e14=0;$e15=0;
				$e16=0;$e17=0;$e18=0;$e19=0;$e20=0;$e21=0;$e22=0;$e23=0;$e24=0;$e25=0;$e26=0;$e27=0;$e28=0;$e29=0;
				
				//$sql=" call get1_app_event_1($resp,'$st',$evt);";
				//$sql="SET @p0='10'; SET @p1='2017/09/22'; SET @p12='1'; CALL `get_event_1`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12); SELECT @p2 AS `a1`, @p3 AS `a2`, @p4 AS `a3`, @p5 AS `a4`, @p6 AS `a5`, @p7 AS `a6`, @p8 AS `a7`, @p9 AS `a8`, @p10 AS `a9`, @p11 AS `a10`;";
				//$ae1=$this->getDataBySql($sql);
				
				//App installed details
					$sql="  CALL `get_app_installed`($resp, '$st', @p2, @p3, @p4, @p5);";
					$this->db->trans_start();
					$this->db->query($sql); // not need to get output
				        $query = $this->db->query(" SELECT @p2 AS `ab1`, @p3 AS `ab2`, @p4 AS `ab3`, @p5 AS `ab4`;");
				        $this->db->trans_complete();				
				        $result = array();				
				        if($query->num_rows() > 0)
				           $re1 = $query->result();
				        if($re1);
				        foreach($re1 as $re)
				        {      //print_r($re);
				        	$ab1=$re->ab1;$ab2=$re->ab2;$ab3=$re->ab3;$ab4=$re->ab4;
				        }
				        
				$evt=1;
				  	//First app open details
					$sql=" CALL `get_event_1`($resp,'$st', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, $evt);";
					$this->db->trans_start();
					$this->db->query($sql); // not need to get output
				        $query = $this->db->query(" SELECT @p2 AS `a1`, @p3 AS `a2`, @p4 AS `a3`, @p5 AS `a4`, @p6 AS `a5`, @p7 AS `a6`, @p8 AS `a7`, @p9 AS `a8`, @p10 AS `a9`, @p11 AS `a10`;");
				        $this->db->trans_complete();				
				        $result = array();				
				        if($query->num_rows() > 0)
				           $re1 = $query->result();
				        if($re1);
				        foreach($re1 as $re)
				        {      //print_r($re);
				        	$a1=$re->a1;$a2=$re->a2;$a3=$re->a3;$a4=$re->a4;$a5=$re->a5;$a6=$re->a6;$a7=$re->a7;$a8=$re->a8;$a9=$re->a9;$a10=$re->a10;
				        }
				        
				     if($a1==1)
				     {
				        //to get app usase details
					$sql2=" CALL `get_event_2`($resp,'$a2',$evt,  @p3, @p4, @p5, @p6, @p7);";
					$this->db->trans_start();
					$this->db->query($sql2); // not need to get output
				        $query2 = $this->db->query("  SELECT @p3 AS `a11`, @p4 AS `a12`, @p5 AS `a13`, @p6 AS `a14`, @p7 AS `a15`; ");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query2->num_rows() > 0)
				           $re2 = $query2->result();
				        if($re2);
				        foreach($re2 as $re)
				        {      //print_r($re);
				        	$a11=$re->a11;$a12=$re->a12;$a13=$re->a13;$a14=$re->a14;$a15=$re->a15;
				        }
				        
 					//to get app usase details of event true timeline
					$sql3=" CALL `get_event_3`($resp,'$a2', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15);";
					$this->db->trans_start();
					$this->db->query($sql3); // not need to get output
				        $query3 = $this->db->query(" SELECT @p2 AS `a16`, @p3 AS `a17`, @p4 AS `a18`, @p5 AS `a19`, @p6 AS `a20`, @p7 AS `a21`, @p8 AS `a22`, @p9 AS `a23`, @p10 AS `a24`, @p11 AS `a25`, @p12 AS `a26`, @p13 AS `a27`, @p14 AS `a28`, @p15 AS `a29`;");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query3->num_rows() > 0)
				           $re3 = $query3->result();
				        if($re3);
				        foreach($re3 as $re)
				        {      //print_r($re);
				        	$a16=$re->a16;$a17=$re->a17;$a18=$re->a18;$a19=$re->a19;$a20=$re->a20;$a21=$re->a21;$a22=$re->a22;
				        	$a23=$re->a23;$a24=$re->a24;$a25=$re->a25;$a26=$re->a26;$a27=$re->a27;$a28=$re->a28;$a29=$re->a29;
				        }
				     }//end of only when traveyn =1
				     $s1="INSERT INTO `applog_report`(`resp_id`, `evt`, `start_time`, `tot_evt`, `instols`, `instuber`, 
				     `travel_status`, `travel_time`, `app1_name`, `app1_duration`, `app2_name`, `app2_duration`, `app3_name`, `app3_duration`, `app4_name`, `app4_duration`, `cnt_app_switch`, `resp_travel`, `travel_app`, `travel_mode`, `travel_occ`, `ola_r1`, `ola_r2`, `ola_r3`, `ola_r4`, `ola_r5`, `ola_r6`, `ola_r7`, `uber_r1`, `uber_r2`, `uber_r3`, `uber_r4`, `uber_r5`, `uber_r6`, `uber_r7`) 
				     VALUES ($resp,$evt,'$st','$ab2','$ab3','$ab4','$a1','$a2','$a3','$a4','$a5','$a6','$a7','$a8','$a9','$a10','$a11','$a12','$a13','$a14','$a15','$a16','$a17','$a18','$a19','$a20','$a21','$a22','$a23','$a24','$a25','$a26','$a27','$a28','$a29');";
				 //end of $evt=1
				 
				$evt=2;
				  	//First app open details
					$sql=" CALL `get_event_1`($resp,'$st', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, $evt);";
					$this->db->trans_start();
					$this->db->query($sql); // not need to get output
				        $query = $this->db->query(" SELECT @p2 AS `a1`, @p3 AS `a2`, @p4 AS `a3`, @p5 AS `a4`, @p6 AS `a5`, @p7 AS `a6`, @p8 AS `a7`, @p9 AS `a8`, @p10 AS `a9`, @p11 AS `a10`;");
				        $this->db->trans_complete();				
				        $result = array();				
				        if($query->num_rows() > 0)
				           $re1 = $query->result();
				        if($re1);
				        foreach($re1 as $re)
				        {      //print_r($re);
				        	$b1=$re->a1;$b2=$re->a2;$b3=$re->a3;$b4=$re->a4;$b5=$re->a5;$b6=$re->a6;$b7=$re->a7;$b8=$re->a8;$b9=$re->a9;$b10=$re->a10;
				        }
				        
				     if($b1==1)
				     {
				        //to get app usase details
					$sql2=" CALL `get_event_2`($resp,'$b2',$evt,  @p3, @p4, @p5, @p6, @p7);";
					$this->db->trans_start();
					$this->db->query($sql2); // not need to get output
				        $query2 = $this->db->query("  SELECT @p3 AS `a11`, @p4 AS `a12`, @p5 AS `a13`, @p6 AS `a14`, @p7 AS `a15`; ");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query2->num_rows() > 0)
				           $re2 = $query2->result();
				        if($re2);
				        foreach($re2 as $re)
				        {      //print_r($re);
				        	$b11=$re->a11;$b12=$re->a12;$b13=$re->a13;$b14=$re->a14;$b15=$re->a15;
				        }
				        
 					//to get app usase details of event true timeline
					$sql3=" CALL `get_event_3`($resp,'$b2', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15);";
					$this->db->trans_start();
					$this->db->query($sql3); // not need to get output
				        $query3 = $this->db->query(" SELECT @p2 AS `a16`, @p3 AS `a17`, @p4 AS `a18`, @p5 AS `a19`, @p6 AS `a20`, @p7 AS `a21`, @p8 AS `a22`, @p9 AS `a23`, @p10 AS `a24`, @p11 AS `a25`, @p12 AS `a26`, @p13 AS `a27`, @p14 AS `a28`, @p15 AS `a29`;");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query3->num_rows() > 0)
				           $re3 = $query3->result();
				        if($re3);
				        foreach($re3 as $re)
				        {      //print_r($re3)
						$b16=$re->a16;$b17=$re->a17;$b18=$re->a18;$b19=$re->a19;$b20=$re->a20;$b21=$re->a21;$b22=$re->a22;
				        	$b23=$re->a23;$b24=$re->a24;$b25=$re->a25;$b26=$re->a26;$b27=$re->a27;$b28=$re->a28;$b29=$re->a29;
				        }
				     }//end of only when traveyn =1
     				$s2="INSERT INTO `applog_report`(`resp_id`, `evt`, `start_time`, 
				     `travel_status`, `travel_time`, `app1_name`, `app1_duration`, `app2_name`, `app2_duration`, `app3_name`, `app3_duration`, `app4_name`, `app4_duration`, `cnt_app_switch`, `resp_travel`, `travel_app`, `travel_mode`, `travel_occ`, `ola_r1`, `ola_r2`, `ola_r3`, `ola_r4`, `ola_r5`, `ola_r6`, `ola_r7`, `uber_r1`, `uber_r2`, `uber_r3`, `uber_r4`, `uber_r5`, `uber_r6`, `uber_r7`) 
				     VALUES ($resp,$evt,'$st','$b1','$b2','$b3','$b4','$b5','$b6','$b7','$b8','$b9','$b10','$b11','$b12','$b13','$b14','$b15','$b16','$b17','$b18','$b19','$b20','$b21','$b22','$b23','$b24','$b25','$b26','$b27','$b28','$b29');";
				 
				   //end of $evt=2

				$evt=3;
				  	//First app open details
					$sql=" CALL `get_event_1`($resp,'$st', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, $evt);";
					$this->db->trans_start();
					$this->db->query($sql); // not need to get output
				        $query = $this->db->query(" SELECT @p2 AS `a1`, @p3 AS `a2`, @p4 AS `a3`, @p5 AS `a4`, @p6 AS `a5`, @p7 AS `a6`, @p8 AS `a7`, @p9 AS `a8`, @p10 AS `a9`, @p11 AS `a10`;");
				        $this->db->trans_complete();				
				        $result = array();				
				        if($query->num_rows() > 0)
				           $re1 = $query->result();
				        if($re1);
				        foreach($re1 as $re)
				        {      //print_r($re);
				        	$c1=$re->a1;$c2=$re->a2;$c3=$re->a3;$c4=$re->a4;$c5=$re->a5;$c6=$re->a6;$c7=$re->a7;$c8=$re->a8;$c9=$re->a9;$c10=$re->a10;
				        }
				        
				     if($c1==1)
				     {
				        //to get app usase details
					$sql2=" CALL `get_event_2`($resp,'$c2',$evt,  @p3, @p4, @p5, @p6, @p7);";
					$this->db->trans_start();
					$this->db->query($sql2); // not need to get output
				        $query2 = $this->db->query("  SELECT @p3 AS `a11`, @p4 AS `a12`, @p5 AS `a13`, @p6 AS `a14`, @p7 AS `a15`; ");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query2->num_rows() > 0)
				           $re2 = $query2->result();
				        if($re2);
				        foreach($re2 as $re)
				        {      //print_r($re);
				        	$c11=$re->a11;$c12=$re->a12;$c13=$re->a13;$c14=$re->a14;$c15=$re->a15;
				        }
				        
 					//to get app usase details of event true timeline
					$sql3=" CALL `get_event_3`($resp,'$c2', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15);";
					$this->db->trans_start();
					$this->db->query($sql3); // not need to get output
				        $query3 = $this->db->query(" SELECT @p2 AS `a16`, @p3 AS `a17`, @p4 AS `a18`, @p5 AS `a19`, @p6 AS `a20`, @p7 AS `a21`, @p8 AS `a22`, @p9 AS `a23`, @p10 AS `a24`, @p11 AS `a25`, @p12 AS `a26`, @p13 AS `a27`, @p14 AS `a28`, @p15 AS `a29`;");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query3->num_rows() > 0)
				           $re3 = $query3->result();
				        if($re3);
				        foreach($re3 as $re)
				        {      //print_r($re);
				        	$c16=$re->a16;$c17=$re->a17;$c18=$re->a18;$c19=$re->a19;$c20=$re->a20;$c21=$re->a21;$c22=$re->a22;
				        	$c23=$re->a23;$c24=$re->a24;$c25=$re->a25;$c26=$re->a26;$c27=$re->a27;$c28=$re->a28;$c29=$re->a29;
				        }
				     }//end of only when traveyn =1
     				$s3="INSERT INTO `applog_report`(`resp_id`, `evt`, `start_time`, 
				     `travel_status`, `travel_time`, `app1_name`, `app1_duration`, `app2_name`, `app2_duration`, `app3_name`, `app3_duration`, `app4_name`, `app4_duration`, `cnt_app_switch`, `resp_travel`, `travel_app`, `travel_mode`, `travel_occ`, `ola_r1`, `ola_r2`, `ola_r3`, `ola_r4`, `ola_r5`, `ola_r6`, `ola_r7`, `uber_r1`, `uber_r2`, `uber_r3`, `uber_r4`, `uber_r5`, `uber_r6`, `uber_r7`) 
				     VALUES ($resp,$evt,'$st','$c1','$c2','$c3','$c4','$c5','$c6','$c7','$c8','$c9','$c10','$c11','$c12','$c13','$c14','$c15','$c16','$c17','$c18','$c19','$c20','$c21','$c22','$c23','$c24','$c25','$c26','$c27','$c28','$c29');";
				 
				 //end of $evt=3				   
				   
				$evt=4;
				  	//First app open details
					$sql=" CALL `get_event_1`($resp,'$st', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, $evt);";
					$this->db->trans_start();
					$this->db->query($sql); // not need to get output
				        $query = $this->db->query(" SELECT @p2 AS `a1`, @p3 AS `a2`, @p4 AS `a3`, @p5 AS `a4`, @p6 AS `a5`, @p7 AS `a6`, @p8 AS `a7`, @p9 AS `a8`, @p10 AS `a9`, @p11 AS `a10`;");
				        $this->db->trans_complete();				
				        $result = array();				
				        if($query->num_rows() > 0)
				           $re1 = $query->result();
				        if($re1);
				        foreach($re1 as $re)
				        {      //print_r($re);
				        	$d1=$re->a1;$d2=$re->a2;$d3=$re->a3;$d4=$re->a4;$d5=$re->a5;$d6=$re->a6;$d7=$re->a7;$d8=$re->a8;$d9=$re->a9;$d10=$re->a10;				       
				        }
				        
				     if($d1==1)
				     {
				        //to get app usase details
					$sql2=" CALL `get_event_2`($resp,'$d2',$evt,  @p3, @p4, @p5, @p6, @p7);";
					$this->db->trans_start();
					$this->db->query($sql2); // not need to get output
				        $query2 = $this->db->query("  SELECT @p3 AS `a11`, @p4 AS `a12`, @p5 AS `a13`, @p6 AS `a14`, @p7 AS `a15`; ");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query2->num_rows() > 0)
				           $re2 = $query2->result();
				        if($re2);
				        foreach($re2 as $re)
				        {      //print_r($re);
				        	$d11=$re->a11;$d12=$re->a12;$d13=$re->a13;$d14=$re->a14;$d15=$re->a15;
				        }
				        
 					//to get app usase details of event true timeline
					$sql3=" CALL `get_event_3`($resp,'$d2', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15);";
					$this->db->trans_start();
					$this->db->query($sql3); // not need to get output
				        $query3 = $this->db->query(" SELECT @p2 AS `a16`, @p3 AS `a17`, @p4 AS `a18`, @p5 AS `a19`, @p6 AS `a20`, @p7 AS `a21`, @p8 AS `a22`, @p9 AS `a23`, @p10 AS `a24`, @p11 AS `a25`, @p12 AS `a26`, @p13 AS `a27`, @p14 AS `a28`, @p15 AS `a29`;");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query3->num_rows() > 0)
				           $re3 = $query3->result();
				        if($re3);
				        foreach($re3 as $re)
				        {      //print_r($re);
				        	$d16=$re->a16;$d17=$re->a17;$d18=$re->a18;$d19=$re->a19;$d20=$re->a20;$d21=$re->a21;$d22=$re->a22;
				        	$d23=$re->a23;$d24=$re->a24;$d25=$re->a25;$d26=$re->a26;$d27=$re->a27;$d28=$re->a28;$d29=$re->a29;
				        }
				     }//end of only when traveyn =1
     				$s4="INSERT INTO `applog_report`(`resp_id`, `evt`, `start_time`, 
				     `travel_status`, `travel_time`, `app1_name`, `app1_duration`, `app2_name`, `app2_duration`, `app3_name`, `app3_duration`, `app4_name`, `app4_duration`, `cnt_app_switch`, `resp_travel`, `travel_app`, `travel_mode`, `travel_occ`, `ola_r1`, `ola_r2`, `ola_r3`, `ola_r4`, `ola_r5`, `ola_r6`, `ola_r7`, `uber_r1`, `uber_r2`, `uber_r3`, `uber_r4`, `uber_r5`, `uber_r6`, `uber_r7`) 
				     VALUES ($resp,$evt,'$st','$d1','$d2','$d3','$d4','$d5','$d6','$d7','$d8','$d9','$d10','$d11','$d12','$d13','$d14','$d15','$d16','$d17','$d18','$d19','$d20','$d21','$d22','$d23','$d24','$d25','$d26','$d27','$d28','$d29');";
				 
				 //end of $evt=4
				 
				$evt=5;
				  	//First app open details
					$sql=" CALL `get_event_1`($resp,'$st', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, $evt);";
					$this->db->trans_start();
					$this->db->query($sql); // not need to get output
				        $query = $this->db->query(" SELECT @p2 AS `a1`, @p3 AS `a2`, @p4 AS `a3`, @p5 AS `a4`, @p6 AS `a5`, @p7 AS `a6`, @p8 AS `a7`, @p9 AS `a8`, @p10 AS `a9`, @p11 AS `a10`;");
				        $this->db->trans_complete();				
				        $result = array();				
				        if($query->num_rows() > 0)
				           $re1 = $query->result();
				        if($re1);
				        foreach($re1 as $re)
				        {      //print_r($re);
				        	$e1=$re->a1;$e2=$re->a2;$e3=$re->a3;$e4=$re->a4;$e5=$re->a5;$e6=$re->a6;$e7=$re->a7;$e8=$re->a8;$e9=$re->a9;$e10=$re->a10;
				        }
				        
				     if($e1==1)
				     {
				        //to get app usase details
					$sql2=" CALL `get_event_2`($resp,'$e2',$evt,  @p3, @p4, @p5, @p6, @p7);";
					$this->db->trans_start();
					$this->db->query($sql2); // not need to get output
				        $query2 = $this->db->query("  SELECT @p3 AS `a11`, @p4 AS `a12`, @p5 AS `a13`, @p6 AS `a14`, @p7 AS `a15`; ");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query2->num_rows() > 0)
				           $re2 = $query2->result();
				        if($re2);
				        foreach($re2 as $re)
				        {      //print_r($re);
				        	$e11=$re->a11;$e12=$re->a12;$e13=$re->a13;$e14=$re->a14;$e15=$re->a15;
				        }
				        
 					//to get app usase details of event true timeline
					$sql3=" CALL `get_event_3`($resp,'$e2', @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12, @p13, @p14, @p15);";
					$this->db->trans_start();
					$this->db->query($sql3); // not need to get output
				        $query3 = $this->db->query(" SELECT @p2 AS `a16`, @p3 AS `a17`, @p4 AS `a18`, @p5 AS `a19`, @p6 AS `a20`, @p7 AS `a21`, @p8 AS `a22`, @p9 AS `a23`, @p10 AS `a24`, @p11 AS `a25`, @p12 AS `a26`, @p13 AS `a27`, @p14 AS `a28`, @p15 AS `a29`;");
				        $this->db->trans_complete();				
				        $result = array();	
				        if($query3->num_rows() > 0)
				           $re3 = $query3->result();
				        if($re3);
				        foreach($re3 as $re)
				        {      //print_r($re);
						$e16=$re->a16;$e17=$re->a17;$e18=$re->a18;$e19=$re->a19;$e20=$re->a20;$e21=$re->a21;$e22=$re->a22;
				        	$e23=$re->a23;$e24=$re->a24;$e25=$re->a25;$e26=$re->a26;$e27=$re->a27;$e28=$re->a28;$e29=$re->a29;
				        }
				     }//end of only when traveyn =1
     				$s5="INSERT INTO `applog_report`(`resp_id`, `evt`, `start_time`, 
				     `travel_status`, `travel_time`, `app1_name`, `app1_duration`, `app2_name`, `app2_duration`, `app3_name`, `app3_duration`, `app4_name`, `app4_duration`, `cnt_app_switch`, `resp_travel`, `travel_app`, `travel_mode`, `travel_occ`, `ola_r1`, `ola_r2`, `ola_r3`, `ola_r4`, `ola_r5`, `ola_r6`, `ola_r7`, `uber_r1`, `uber_r2`, `uber_r3`, `uber_r4`, `uber_r5`, `uber_r6`, `uber_r7`) 
				     VALUES ($resp,$evt,'$st','$e1','$e2','$e3','$e4','$e5','$e6','$e7','$e8','$e9','$e10','$e11','$e12','$e13','$e14','$e15','$e16','$e17','$e18','$e19','$e20','$e21','$e22','$e23','$e24','$e25','$e26','$e27','$e28','$e29');";
		
				$sf="UPDATE `applog_list` SET `flag`= 1 WHERE `resp_id`= $resp AND `start_time`='$st';";
		 				     
				 //end of $evt=5
			   
			   //Update into table
			/*
			$this->db->trans_start();
			$this->db->query($s1); // for event-1
			$this->db->query($s2); // for event-2
			$this->db->query($s3); // for event-3
			$this->db->query($s4); // for event-4
			$this->db->query($s5); // for event-5
			$this->db->query($sf); // for flag change to 1
			//$query = $this->db->query(" SELECT @p2 AS `ab1`, @p3 AS `ab2`, @p4 AS `ab3`, @p5 AS `ab4`;");
			$this->db->trans_complete();
			   */
				//$str1.="<br> resp=$resp,Date=$st,NOSevt=$ab2,OlaIns=$ab3,UberIns=$ab4,Ty/n=$a1,Ttim=$a2,1oApp=$a3,1oAppd=$a4,2oApp=$a5,2oAppD=$a6,3oApp=$a7,3oAppD=$a8,FApp=$a9,FAD=$a10,AppCntSw=$a11,RespTyn=$a12,O/U=$a13,Mode=$a14,Occa=$a15,Or1=$a16,Or2=$a17,Or3=$a18,Or4=$a19,Or5=$a20,Or6=$a21,Or7=$a22,Ur1=$a23,Ur2=$a24,Ur3=$a25,Ur4=$a26,Ur5=$a27,Ur6=$a28,Ur7=$a29";
				
				/*
				$appbasic=$this->get_appbasic($resp,$st);
				if($appbasic)
				foreach($appbasic as $r)
				{	
					$ab1=$r->ab1;$ab2=$r->ab2;$ab3=$r->ab3;
					$str1.="<br> resp=$resp , nev: $ab1, ola: $ab2, uber: $ab3 ";
				}
				$e1=$evt=1;
				$appevt=$this->get_appevent($resp,$st,$evt);
				if($appevt)
				foreach($appevt as $r)
				{
					$a1=$r->a1;$a2=$r->a2;$a3=$r->a3;$a4=$r->a4;$a5=$r->a5;$a6=$r->a6;$a7=$r->a7;$a8=$r->a8;$a9=$r->a9;$a10=$r->a10;
					$str1.=" , a1:$a1 , a2: $a2, a3: $a3, a4: $a4, a5: $a5 ,a6: $a6, a7: $a7, a8: $a8 , a9: $a9, a10 : $a10 ";
				}
				*/
				$str.=$str1;
				$str.='<br>';
				$str.=$s1;
				$str.='<br>';
				$str.=$s2;
				$str.='<br>';
				$str.=$s3;
				$str.='<br>';
				$str.=$s4;
                                $str.='<br>';
                                $str.=$s5;
                                $str.='<br>';
                                $str.=$sf;
                        /*    
                        $a= $this->getDataBySql($s1);
                        $a=$this->getDataBySql($s2);
                        $a=$this->getDataBySql($s3);
                        $a=$this->getDataBySql($s4);
                        $a=$this->getDataBySql($s5);
                        $a=$this->getDataBySql($sf);
                         */
			}
			
			
			return $str;
		}
		if(!$results) return $str;
	}
	
	
	
    	function get_rept_list($sdt,$edt)
	{
	
		if($sdt!='' && $edt!='')
		{
			$qr="SELECT distinct `resp_id`, start_time FROM `applog_report` WHERE date(start_time) between '$sdt' AND '$edt' ";
	
		        $query=$this->db->query($qr);
		        $results=$query->result();
		        if($results) return $results;
			else return 0;
		}
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
	function get_appevent($resp,$st,$evt)
	{
			$qr="SELECT `resp_id`, `evt`, `start_time`, `tot_evt` as ab1, `instols` as ab2, `instuber` as ab3, `travel_status` as aa1, `travel_time` as aa2, `app1_name` as aa3, `app1_duration` as aa4, `app2_name` as aa5, `app2_duration` as aa6, `app3_name` as aa7, `app3_duration` as aa8, `app4_name` as aa9, `app4_duration` as aa10, `cnt_app_switch` as aa11, `resp_travel` as aa12, `travel_app` as aa13, `travel_mode` as aa14, `travel_occ` as aa15, `ola_r1` as aa16, `ola_r2` as aa17, `ola_r3` as aa18, `ola_r4` as aa19, `ola_r5` as aa20, `ola_r6` as aa21, `ola_r7` as aa22, `uber_r1` as aa23, `uber_r2` as aa24, `uber_r3` as aa25, `uber_r4` as aa26, `uber_r5` as aa27, `uber_r6` as aa28, `uber_r7` as aa29 FROM `applog_report` WHERE `resp_id`= $resp AND `start_time`=date('$st') AND `evt`=$evt";
	
		        $query=$this->db->query($qr);
		        $results=$query->result();
		        if($results) return $results;
			else return 0;
    	}

    	
}




