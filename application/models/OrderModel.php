<?php

class OrderModel extends CI_Model{

    public function getRequests($uid){ 
        
        $query=$this->db->get_where('vcims_user_request',array('user_id' => $uid));
        return $query->result();
    }
    
    public function insertRequest($rdata,$arrc){
         
         $query=$this->db->insert('vcims_user_request',$rdata);
         $last_id = $this->db->insert_id();
         if(!empty($arrc))
         {  foreach($arrc as $c)
            {  $narr=array();$narr['req_id']=$last_id;$narr['centre_id']=$c;
              $qu=$this->db->insert('vcims_user_request_centre',$narr);
            }
         }

        // return $last_id;
        if($last_id)
          return $last_id;
        else
          return false;
    }
   
    public function addPayRequest($od){
         
         $query=$this->db->insert('vcims_user_order_pay',$od);
         
    }

    public function getOrderIdByTxnid($code){ 
        $this->db->select('ord_id');
        $query=$this->db->get_where('vcims_user_order_pay',array('txnid' => $code));
        $result= $query->row();
        if($result)
	        	return $result->ord_id;
	        else
	        	return false;
    }

    public function getProducts(){ 
        
        $query=$this->db->get('tblproduct');
        return $query->result();
    }
    public function getProductByCode($code){ 
        
        $query=$this->db->get_where('tblproduct',array('code' => $code));
        return $query->row();
    }
    public function getPaymentDetail($uid){ 
        
        $query=$this->db->get_where('vcims_user_order_pay',array('user_id' => $uid));
        return $query->result();
    }
    
}