<?php

class HomeModel extends CI_Model{
    public function getData(){
        $query=$this->db->get('credit_store');
        return $query->result();
    }

    //to get all project list based on userid
    function get_projects($uid=null)
    {   
     	$p=''; $ctr=0;
        $query1=$this->db->get_where('project_user_map',array('uid' => $uid));
         $qq=$query1->result();
	     
	      
	    foreach($qq as $r)
	    {  $ctr++;
	       if($ctr>1)
	        { $p.=','; $p.=$r->project_id; }
	       if($ctr==1) $p=$r->project_id;
	    } 
	    //return $p;
	    //$query2=$this->db->get('project');
	     $query2=$this->db->get_where('project',array('project_id'=>$p));
	    
            return $ss=$query2->result();
         
	  
    }
     
}
