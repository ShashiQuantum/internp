<?php
class MGpi extends CI_Model
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
    	function get_shopers()
	{
	        $query=$this->db->query("SELECT  distinct resp_id, r_add,r_name,i_date_117,mobile, i_name, centre_117 FROM `prathmesh_117` WHERE mobile!='' order by resp_id ");
	        $results=$query->result();
	        if($results) return $results;
		else return 0;
    	}
    	function get_rqday1($resp)
	{
		$qr="SELECT distinct `resp_id`,`r_name`,
		(SELECT distinct `rq1_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq1_117 !='') as rq1,
		(SELECT distinct `rq2_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq2_117 !='' ) as rq2,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='1' ) as rq3_1,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='2' ) as rq3_2,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='3' ) as rq3_3,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='4' ) as rq3_4,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='5' ) as rq3_5,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='6' ) as rq3_6,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='7' ) as rq3_7,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='8' ) as rq3_8,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='9' ) as rq3_9,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='10' ) as rq3_10,
		(SELECT distinct `rq3_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3_117 ='11' ) as rq3_11,
		(SELECT distinct `rq3a_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq3a_117 !='' ) as rq3a,
		(SELECT distinct `rq4_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq4_117 !='' ) as rq4,
		(SELECT distinct `rq5_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq5_117 !='' ) as rq5,
		(SELECT distinct `rq7_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq7_117 ='1' ) as rq7_1,
		(SELECT distinct `rq7_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq7_117 ='2' ) as rq7_2,
		(SELECT distinct `rq7_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq7_117 ='3' ) as rq7_3,
		(SELECT distinct `rq7_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq7_117 ='4' ) as rq7_4,
		(SELECT distinct `rq7_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq7_117 ='5' ) as rq7_5,
		(SELECT distinct `rq7_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq7_117 ='6' ) as rq7_6,
		(SELECT distinct `rq8a_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq8a_117 !='' ) as rq8a,
		(SELECT distinct `rq8b_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq8b_117 !='' ) as rq8b,
		(SELECT distinct `rq8c_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq8c_117 !='' ) as rq8c,
		(SELECT distinct `rq9_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq9_117 !='' ) as rq9,
		(SELECT distinct `rq10_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq10_117 !='' ) as rq10,
		(SELECT distinct `rq11_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq11_117 !='' ) as rq11,
		(SELECT distinct `rq12_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq12_117 !='' ) as rq12,
		(SELECT distinct `rq13a_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13a_117 !='' ) as rq13a,
		(SELECT distinct `rq13b_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13b_117 !='' ) as rq13b,
		(SELECT distinct `rq13c_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13c_117 !='' ) as rq13c,
		(SELECT distinct `rq13d_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13d_117 !='' ) as rq13d,
		(SELECT distinct `rq13e_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13e_117 !='' ) as rq13e,
		(SELECT distinct `rq13f_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13f_117 !='' ) as rq13f,
		(SELECT distinct `rq13g_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13g_117 !='' ) as rq13g,
		(SELECT distinct `rq13h_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13h_117 !='' ) as rq13h,
		(SELECT distinct `rq13i_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13i_117 !='' ) as rq13i,
		(SELECT distinct `rq13j_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13j_117 !='' ) as rq13j,
		(SELECT distinct `rq13k_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13k_117 !='' ) as rq13k,
		(SELECT distinct `rq13l_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13l_117 !='' ) as rq13l,
		(SELECT distinct `rq13m_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13m_117 !='' ) as rq13m,
		(SELECT distinct `rq13n_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13n_117 !='' ) as rq13n,
		(SELECT distinct `rq13o_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13o_117 !='' ) as rq13o,
		(SELECT distinct `rq13p_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13p_117 !='' ) as rq13p,
		(SELECT distinct `rq13q_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13q_117 !='' ) as rq13q,
		(SELECT distinct `rq13r_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13r_117 !='' ) as rq13r,
		(SELECT distinct `rq13s_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13s_117 !='' ) as rq13s,
		(SELECT distinct `rq13t_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13t_117 !='' ) as rq13t,
		(SELECT distinct `rq13u_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq13u_117 !='' ) as rq13u,
		(SELECT distinct `rq14a_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq14a_117 !='' ) as rq14a,
		(SELECT distinct `rq14b_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq14b_117 !='' ) as rq14b,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='1' ) as rq15_1,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='2' ) as rq15_2,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='3' ) as rq15_3,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='4' ) as rq15_4,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='5' ) as rq15_5,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='6' ) as rq15_6,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='7' ) as rq15_7,
		(SELECT distinct `rq15_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq15_117 ='8' ) as rq15_8,
		(SELECT distinct `rq16_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq16_117 !='' ) as rq16,
		(SELECT distinct `rq17_117` FROM `prathmesh_117` WHERE resp_id='$resp' AND rq17_117 !='' ) as rq17
		 FROM `prathmesh_117` WHERE resp_id='$resp' AND r_name!=''";

	        $query=$this->db->query($qr);
	        $results=$query->result();
	        if($results) return $results;
		else return 0;
    	}
    	
    	function get_total_opening10($resp)
	{
		$qr="SELECT distinct `resp_id`,
			(SELECT sum( `a1_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a1_117 !='') as a1,
			(SELECT sum( `a2_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a2_117 !='' ) as a2,
			(SELECT sum( `a3_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a3_117 !='' ) as a3,
			(SELECT sum( `a4_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a4_117 !='' ) as a4,
			(SELECT sum( `a5_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a5_117 !='' ) as a5,
			(SELECT sum( `a6_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a6_117 !='' ) as a6,
			(SELECT sum( `a7_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a7_117 !='' ) as a7,
			(SELECT sum( `a8_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a8_117 !='' ) as a8, 
			(SELECT sum( `a9_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a9_117 !='' ) as a9,
			(SELECT sum( `a10_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a10_117 !='' ) as a10,
			(SELECT sum( `a11_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a11_117 !='') as a11,
			(SELECT sum( `a12_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a12_117 !='' ) as a12,
			(SELECT sum( `a13_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a13_117 !='' ) as a13,
			(SELECT sum( `a14_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a14_117 !='' ) as a14,
			(SELECT sum( `a15_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a15_117 !='' ) as a15,
			(SELECT sum( `a16_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a16_117 !='' ) as a16,
			(SELECT sum( `a17_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a17_117 !='' ) as a17,
			(SELECT sum( `a18_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a18_117 !='' ) as a18, 
			(SELECT sum( `a19_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a19_117 !='' ) as a19,
			(SELECT sum( `a20_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a20_117 !='' ) as a20,
			(SELECT sum( `a21_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a21_117 !='' ) as a21,
			(SELECT sum( `a22_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a22_117 !='' ) as a22,
			(SELECT sum( `a23_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a23_117 !='' ) as a23,
			(SELECT sum( `a24_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a24_117 !='' ) as a24,
			(SELECT sum( `a25_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a25_117 !='' ) as a25,
			(SELECT sum( `a26_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a26_117 !='' ) as a26,
			(SELECT sum( `a27_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a27_117 !='' ) as a27,
			(SELECT sum( `a28_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a28_117 !='' ) as a28,
			(SELECT sum( `a29_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a29_117 !='' ) as a29,
			(SELECT sum( `a30_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a30_117 !='' ) as a30,
			(SELECT sum( `a31_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a31_117 !='' ) as a31,
			(SELECT sum( `a32_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a32_117 !='' ) as a32,
			(SELECT sum( `a33_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a33_117 !='' ) as a33,
			(SELECT sum( `a34_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a34_117 !='' ) as a34,
			(SELECT sum( `a35_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a35_117 !='' ) as a35,
			(SELECT sum( `a36_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a36_117 !='' ) as a36,
			(SELECT sum( `a37_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a37_117 !='' ) as a37,
			(SELECT sum( `a38_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a38_117 !='' ) as a38, 
			(SELECT sum( `a39_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a39_117 !='' ) as a39,
			(SELECT sum( `a40_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a40_117 !='' ) as a40,
			(SELECT sum( `a41_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a41_117 !='') as a41,
			(SELECT sum( `a42_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a42_117 !='' ) as a42,
			(SELECT sum( `a43_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a43_117 !='' ) as a43,
			(SELECT sum( `a44_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a44_117 !='' ) as a44,
			(SELECT sum( `a45_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a45_117 !='' ) as a45,
			(SELECT sum( `a46_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a46_117 !='' ) as a46,
			(SELECT sum( `a47_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a47_117 !='' ) as a47,
			(SELECT sum( `a48_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a48_117 !='' ) as a48, 
			(SELECT sum( `a49_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a49_117 !='' ) as a49,
			(SELECT sum( `a50_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a50_117 !='' ) as a50,
			(SELECT sum( `a51_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a51_117 !='' ) as a51,
			(SELECT sum( `a52_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a52_117 !='' ) as a52,
			(SELECT sum( `a53_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a53_117 !='' ) as a53,
			(SELECT sum( `a54_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a54_117 !='' ) as a54,
			(SELECT sum( `a55_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a55_117 !='' ) as a55,
			(SELECT sum( `a56_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a56_117 !='' ) as a56,
			(SELECT sum( `a57_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a57_117 !='' ) as a57,
			(SELECT sum( `a58_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a58_117 !='' ) as a58,
			(SELECT sum( `a59_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a59_117 !='' ) as a59,
			(SELECT sum( `a60_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a60_117 !='' ) as a60,
			(SELECT sum( `a61_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a61_117 !='' ) as a61,
			(SELECT sum( `a62_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a62_117 !='' ) as a62,
			(SELECT sum( `a63_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a63_117 !='' ) as a63,
			(SELECT sum( `a64_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a64_117 !='' ) as a64,
			(SELECT sum( `a65_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a65_117 !='' ) as a65,
			(SELECT sum( `a66_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND a66_117 !='' ) as a66

		FROM `prathmesh_117` WHERE resp_id='$resp' AND r_name!=''";
		$query=$this->db->query($qr);
		$results=$query->result();
		if($results) return $results;
		else return 0;
    	}
    	function get_total_opening20($resp)
	{
			$qr="SELECT distinct `resp_id`,
				(SELECT sum( `b1_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b1_117 !='') as b1,
				(SELECT sum( `b2_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b2_117 !='' ) as b2,
				(SELECT sum( `b3_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b3_117 !='' ) as b3,
				(SELECT sum( `b4_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b4_117 !='' ) as b4,
				(SELECT sum( `b5_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b5_117 !='' ) as b5,
				(SELECT sum( `b6_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b6_117 !='' ) as b6,
				(SELECT sum( `b7_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b7_117 !='' ) as b7,
				(SELECT sum( `b8_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b8_117 !='' ) as b8, 
				(SELECT sum( `b9_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b9_117 !='' ) as b9,
				(SELECT sum( `b10_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b10_117 !='' ) as b10,
				(SELECT sum( `b11_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b11_117 !='') as b11,
				(SELECT sum( `b12_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b12_117 !='' ) as b12,
				(SELECT sum( `b13_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b13_117 !='' ) as b13,
				(SELECT sum( `b14_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b14_117 !='' ) as b14,
				(SELECT sum( `b15_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b15_117 !='' ) as b15,
				(SELECT sum( `b16_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b16_117 !='' ) as b16,
				(SELECT sum( `b17_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b17_117 !='' ) as b17,
				(SELECT sum( `b18_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b18_117 !='' ) as b18, 
				(SELECT sum( `b19_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b19_117 !='' ) as b19,
				(SELECT sum( `b20_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b20_117 !='' ) as b20,
				(SELECT sum( `b21_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b21_117 !='' ) as b21,
				(SELECT sum( `b22_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b22_117 !='' ) as b22,
				(SELECT sum( `b23_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b23_117 !='' ) as b23,
				(SELECT sum( `b24_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b24_117 !='' ) as b24,
				(SELECT sum( `b25_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b25_117 !='' ) as b25,
				(SELECT sum( `b26_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b26_117 !='' ) as b26,
				(SELECT sum( `b27_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b27_117 !='' ) as b27,
				(SELECT sum( `b28_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b28_117 !='' ) as b28,
				(SELECT sum( `b29_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b29_117 !='' ) as b29,
				(SELECT sum( `b30_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b30_117 !='' ) as b30,
				(SELECT sum( `b31_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b31_117 !='' ) as b31,
				(SELECT sum( `b32_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b32_117 !='' ) as b32,
				(SELECT sum( `b33_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b33_117 !='' ) as b33,
				(SELECT sum( `b34_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b34_117 !='' ) as b34,
				(SELECT sum( `b35_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b35_117 !='' ) as b35,
				(SELECT sum( `b36_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b36_117 !='' ) as b36,
				(SELECT sum( `b37_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b37_117 !='' ) as b37,
				(SELECT sum( `b38_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b38_117 !='' ) as b38, 
				(SELECT sum( `b39_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b39_117 !='' ) as b39,
				(SELECT sum( `b40_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b40_117 !='' ) as b40,
				(SELECT sum( `b41_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b41_117 !='' ) as b41,
				(SELECT sum( `b42_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b42_117 !='' ) as b42,
				(SELECT sum( `b43_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b43_117 !='' ) as b43,
				(SELECT sum( `b44_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b44_117 !='' ) as b44,
				(SELECT sum( `b45_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b45_117 !='' ) as b45,
				(SELECT sum( `b46_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b46_117 !='' ) as b46,
				(SELECT sum( `b47_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b47_117 !='' ) as b47,
				(SELECT sum( `b48_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b48_117 !='' ) as b48, 
				(SELECT sum( `b49_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b49_117 !='' ) as b49,
				(SELECT sum( `b50_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b50_117 !='' ) as b50,
				(SELECT sum( `b51_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b51_117 !='' ) as b51,
				(SELECT sum( `b52_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b52_117 !='' ) as b52,
				(SELECT sum( `b53_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b53_117 !='' ) as b53,
				(SELECT sum( `b54_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b54_117 !='' ) as b54,
				(SELECT sum( `b55_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b55_117 !='' ) as b55,
				(SELECT sum( `b56_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b56_117 !='' ) as b56,
				(SELECT sum( `b57_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b57_117 !='' ) as b57,
				(SELECT sum( `b58_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b58_117 !='' ) as b58,
				(SELECT sum( `b59_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b59_117 !='' ) as b59,
				(SELECT sum( `b60_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b60_117 !='' ) as b60,
				(SELECT sum( `b61_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b61_117 !='' ) as b61,
				(SELECT sum( `b62_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b62_117 !='' ) as b62,
				(SELECT sum( `b63_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b63_117 !='' ) as b63,
				(SELECT sum( `b64_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b64_117 !='' ) as b64,
				(SELECT sum( `b65_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b65_117 !='' ) as b65,
				(SELECT sum( `b66_117`) FROM `prathmesh_117` WHERE resp_id='$resp' AND b66_117 !='' ) as b66
			FROM `prathmesh_117` WHERE resp_id='$resp' AND r_name!=''";
			$query=$this->db->query($qr);
			$results=$query->result();
			if($results) return $results;
			else return 0;
	}
	function get_total_purchase10($resp)
	{
			$qr="SELECT distinct shopper_id,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310403') as a1,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310404') as a2,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330501') as a3,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='360507') as a4,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310209') as a5,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='3104211') as a6,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310202') as a7,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310203') as a8,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310204') as a9,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310206') as a10,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310207') as a11,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310208') as a12,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310101') as a13,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310103') as a14,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310119') as a15,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330121') as a16,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330109') as a17,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330111') as a18,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='360113') as a19,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310104') as a20,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310702') as a21,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='371701') as a22,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='331301') as a23,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330806') as a24,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='360825') as a25,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='370801') as a26,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='320804') as a27,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330810') as a28,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160503') as a29,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160512') as a30,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160520') as a31,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160503') as a32,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='150509') as a33,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130130') as a34,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160119') as a35,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='110109') as a36,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='110109') as a37,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160129') as a38,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130104') as a39,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160118') as a40,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130107') as a41,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130317') as a42,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160318') as a43,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130302') as a44,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160316') as a45,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130406') as a46,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210114') as a47,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210112') as a48,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210101') as a49,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210102') as a50,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210104') as a51,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210107') as a52,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='431611') as a53,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='730310') as a54,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='830602') as a55,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910903') as a56,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930943') as a57,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930967') as a58,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930965') as a59,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910905') as a60,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910401') as a61,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930957') as a62,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910948') as a63,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910907') as a64,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910909') as a65,
			(SELECT sum(`pack_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910956') as a66
	
			FROM `gpi_scaned_data` WHERE shopper_id='$resp'";
			$query=$this->db->query($qr);
			$results=$query->result();
			if($results) return $results;
			else return 0;
	}
	function get_total_purchase20($resp)
	{
			$qr="SELECT distinct shopper_id, 
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310403') as b1,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310404') as b2,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330501') as b3,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='360507') as b4,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310209') as b5,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='3104211') as b6,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310202') as b7,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310203') as b8,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310204') as b9,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310206') as b10,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310207') as b11,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310208') as b12,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310101') as b13,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310103') as b14,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310119') as b15,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330121') as b16,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330109') as b17,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330111') as b18,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='360113') as b19,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310104') as b20,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='310702') as b21,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='371701') as b22,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='331301') as b23,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330806') as b24,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='360825') as b25,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='370801') as b26,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='320804') as b27,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='330810') as b28,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160503') as b29,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160512') as b30,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160520') as b31,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160503') as b32,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='150509') as b33,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130130') as b34,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160119') as b35,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='110109') as b36,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='110109') as b37,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160129') as b38,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130104') as b39,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160118') as b40,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130107') as b41,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130317') as b42,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160318') as b43,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130302') as b44,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='160316') as b45,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='130406') as b46,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210114') as b47,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210112') as b48,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210101') as b49,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210102') as b50,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210104') as b51,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='210107') as b52,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='431611') as b53,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='730310') as b54,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='830602') as b55,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910903') as b56,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930943') as b57,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930967') as b58,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930965') as b59,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910905') as b60,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910401') as b61,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='930957') as b62,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910948') as b63,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910907') as b64,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910909') as b65,
			(SELECT sum(`cartoon_count`) FROM `gpi_scaned_data` WHERE shopper_id='$resp' AND barcode='910956') as b66
	
			FROM `gpi_scaned_data` WHERE shopper_id='$resp'";
			$query=$this->db->query($qr);
			$results=$query->result();
			if($results) return $results;
			else return 0;
	}
	
	//for closing stock
	function get_total_closing10($resp)
		{
			$qr="SELECT distinct `resp_id`,
				(SELECT sum( `a1_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a1_117 !='') as a1,
				(SELECT sum( `a2_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a2_117 !='' ) as a2,
				(SELECT sum( `a3_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a3_117 !='' ) as a3,
				(SELECT sum( `a4_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a4_117 !='' ) as a4,
				(SELECT sum( `a5_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a5_117 !='' ) as a5,
				(SELECT sum( `a6_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a6_117 !='' ) as a6,
				(SELECT sum( `a7_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a7_117 !='' ) as a7,
				(SELECT sum( `a8_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a8_117 !='' ) as a8, 
				(SELECT sum( `a9_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a9_117 !='' ) as a9,
				(SELECT sum( `a10_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a10_117 !='' ) as a10,
				(SELECT sum( `a11_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a11_117 !='') as a11,
				(SELECT sum( `a12_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a12_117 !='' ) as a12,
				(SELECT sum( `a13_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a13_117 !='' ) as a13,
				(SELECT sum( `a14_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a14_117 !='' ) as a14,
				(SELECT sum( `a15_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a15_117 !='' ) as a15,
				(SELECT sum( `a16_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a16_117 !='' ) as a16,
				(SELECT sum( `a17_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a17_117 !='' ) as a17,
				(SELECT sum( `a18_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a18_117 !='' ) as a18, 
				(SELECT sum( `a19_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a19_117 !='' ) as a19,
				(SELECT sum( `a20_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a20_117 !='' ) as a20,
				(SELECT sum( `a21_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a21_117 !='' ) as a21,
				(SELECT sum( `a22_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a22_117 !='' ) as a22,
				(SELECT sum( `a23_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a23_117 !='' ) as a23,
				(SELECT sum( `a24_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a24_117 !='' ) as a24,
				(SELECT sum( `a25_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a25_117 !='' ) as a25,
				(SELECT sum( `a26_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a26_117 !='' ) as a26,
				(SELECT sum( `a27_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a27_117 !='' ) as a27,
				(SELECT sum( `a28_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a28_117 !='' ) as a28,
				(SELECT sum( `a29_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a29_117 !='' ) as a29,
				(SELECT sum( `a30_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a30_117 !='' ) as a30,
				(SELECT sum( `a31_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a31_117 !='' ) as a31,
				(SELECT sum( `a32_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a32_117 !='' ) as a32,
				(SELECT sum( `a33_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a33_117 !='' ) as a33,
				(SELECT sum( `a34_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a34_117 !='' ) as a34,
				(SELECT sum( `a35_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a35_117 !='' ) as a35,
				(SELECT sum( `a36_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a36_117 !='' ) as a36,
				(SELECT sum( `a37_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a37_117 !='' ) as a37,
				(SELECT sum( `a38_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a38_117 !='' ) as a38, 
				(SELECT sum( `a39_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a39_117 !='' ) as a39,
				(SELECT sum( `a40_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a40_117 !='' ) as a40,
				(SELECT sum( `a41_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a41_117 !='') as a41,
				(SELECT sum( `a42_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a42_117 !='' ) as a42,
				(SELECT sum( `a43_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a43_117 !='' ) as a43,
				(SELECT sum( `a44_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a44_117 !='' ) as a44,
				(SELECT sum( `a45_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a45_117 !='' ) as a45,
				(SELECT sum( `a46_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a46_117 !='' ) as a46,
				(SELECT sum( `a47_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a47_117 !='' ) as a47,
				(SELECT sum( `a48_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a48_117 !='' ) as a48, 
				(SELECT sum( `a49_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a49_117 !='' ) as a49,
				(SELECT sum( `a50_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a50_117 !='' ) as a50,
				(SELECT sum( `a51_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a51_117 !='' ) as a51,
				(SELECT sum( `a52_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a52_117 !='' ) as a52,
				(SELECT sum( `a53_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a53_117 !='' ) as a53,
				(SELECT sum( `a54_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a54_117 !='' ) as a54,
				(SELECT sum( `a55_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a55_117 !='' ) as a55,
				(SELECT sum( `a56_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a56_117 !='' ) as a56,
				(SELECT sum( `a57_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a57_117 !='' ) as a57,
				(SELECT sum( `a58_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a58_117 !='' ) as a58,
				(SELECT sum( `a59_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a59_117 !='' ) as a59,
				(SELECT sum( `a60_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a60_117 !='' ) as a60,
				(SELECT sum( `a61_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a61_117 !='' ) as a61,
				(SELECT sum( `a62_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a62_117 !='' ) as a62,
				(SELECT sum( `a63_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a63_117 !='' ) as a63,
				(SELECT sum( `a64_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a64_117 !='' ) as a64,
				(SELECT sum( `a65_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a65_117 !='' ) as a65,
				(SELECT sum( `a66_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND a66_117 !='' ) as a66
	
			FROM `prathmesh8_117` WHERE resp_id='$resp' AND r_name!=''";
			$query=$this->db->query($qr);
			$results=$query->result();
			if($results) return $results;
			else return 0;
	    	}
	    	function get_total_closing20($resp)
		{
				$qr="SELECT distinct `resp_id`,
					(SELECT sum( `m1_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m1_117 !='') as b1,
					(SELECT sum( `m2_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m2_117 !='' ) as b2,
					(SELECT sum( `m3_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m3_117 !='' ) as b3,
					(SELECT sum( `m4_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m4_117 !='' ) as b4,
					(SELECT sum( `m5_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m5_117 !='' ) as b5,
					(SELECT sum( `m6_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m6_117 !='' ) as b6,
					(SELECT sum( `m7_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m7_117 !='' ) as b7,
					(SELECT sum( `m8_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m8_117 !='' ) as b8, 
					(SELECT sum( `m9_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m9_117 !='' ) as b9,
					(SELECT sum( `m10_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m10_117 !='' ) as b10,
					(SELECT sum( `m11_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m11_117 !='') as b11,
					(SELECT sum( `m12_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m12_117 !='' ) as b12,
					(SELECT sum( `m13_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m13_117 !='' ) as b13,
					(SELECT sum( `m14_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m14_117 !='' ) as b14,
					(SELECT sum( `m15_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m15_117 !='' ) as b15,
					(SELECT sum( `m16_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m16_117 !='' ) as b16,
					(SELECT sum( `m17_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m17_117 !='' ) as b17,
					(SELECT sum( `m18_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m18_117 !='' ) as b18, 
					(SELECT sum( `m19_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m19_117 !='' ) as b19,
					(SELECT sum( `m20_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m20_117 !='' ) as b20,
					(SELECT sum( `m21_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m21_117 !='' ) as b21,
					(SELECT sum( `m22_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m22_117 !='' ) as b22,
					(SELECT sum( `m23_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m23_117 !='' ) as b23,
					(SELECT sum( `m24_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m24_117 !='' ) as b24,
					(SELECT sum( `m25_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m25_117 !='' ) as b25,
					(SELECT sum( `m26_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m26_117 !='' ) as b26,
					(SELECT sum( `m27_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m27_117 !='' ) as b27,
					(SELECT sum( `m28_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m28_117 !='' ) as b28,
					(SELECT sum( `m29_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m29_117 !='' ) as b29,
					(SELECT sum( `m30_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m30_117 !='' ) as b30,
					(SELECT sum( `m31_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m31_117 !='' ) as b31,
					(SELECT sum( `m32_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m32_117 !='' ) as b32,
					(SELECT sum( `m33_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m33_117 !='' ) as b33,
					(SELECT sum( `m34_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m34_117 !='' ) as b34,
					(SELECT sum( `m35_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m35_117 !='' ) as b35,
					(SELECT sum( `m36_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m36_117 !='' ) as b36,
					(SELECT sum( `m37_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m37_117 !='' ) as b37,
					(SELECT sum( `m38_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m38_117 !='' ) as b38, 
					(SELECT sum( `m39_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m39_117 !='' ) as b39,
					(SELECT sum( `m40_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m40_117 !='' ) as b40,
					(SELECT sum( `m41_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m41_117 !='' ) as b41,
					(SELECT sum( `m42_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m42_117 !='' ) as b42,
					(SELECT sum( `m43_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m43_117 !='' ) as b43,
					(SELECT sum( `m44_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m44_117 !='' ) as b44,
					(SELECT sum( `m45_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m45_117 !='' ) as b45,
					(SELECT sum( `m46_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m46_117 !='' ) as b46,
					(SELECT sum( `m47_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m47_117 !='' ) as b47,
					(SELECT sum( `m48_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m48_117 !='' ) as b48, 
					(SELECT sum( `m49_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m49_117 !='' ) as b49,
					(SELECT sum( `m50_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m50_117 !='' ) as b50,
					(SELECT sum( `m51_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m51_117 !='' ) as b51,
					(SELECT sum( `m52_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m52_117 !='' ) as b52,
					(SELECT sum( `m53_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m53_117 !='' ) as b53,
					(SELECT sum( `m54_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m54_117 !='' ) as b54,
					(SELECT sum( `m55_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m55_117 !='' ) as b55,
					(SELECT sum( `m56_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m56_117 !='' ) as b56,
					(SELECT sum( `m57_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m57_117 !='' ) as b57,
					(SELECT sum( `m58_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m58_117 !='' ) as b58,
					(SELECT sum( `m59_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m59_117 !='' ) as b59,
					(SELECT sum( `m60_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m60_117 !='' ) as b60,
					(SELECT sum( `m61_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m61_117 !='' ) as b61,
					(SELECT sum( `m62_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m62_117 !='' ) as b62,
					(SELECT sum( `m63_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m63_117 !='' ) as b63,
					(SELECT sum( `m64_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m64_117 !='' ) as b64,
					(SELECT sum( `m65_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m65_117 !='' ) as b65,
					(SELECT sum( `m66_117`) FROM `prathmesh8_117` WHERE resp_id='$resp' AND m66_117 !='' ) as b66
				FROM `prathmesh8_117` WHERE resp_id='$resp' AND r_name!=''";
				$query=$this->db->query($qr);
				$results=$query->result();
				if($results) return $results;
				else return 0;
	}
	
	function get_resp($resp_id)
        {
                $query=$this->db->query("SELECT  `resp_id`,  `r_name`, `mobile`, `centre_110` FROM `zinnia_110` where mobile = (SELECT mobil FROM `app_user` WHERE user_id=$resp_id )");
                return $query->result();
        }
 } // end of class
