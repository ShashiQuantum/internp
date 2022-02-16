<?php

class MHr extends CI_Model
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
	    public function updateTableWhere($table,$coln,$colnid,$uarr)
	    {
	        $this->db->set($uarr);
	        $this->db->where($coln, $colnid);
	        $res = $this->db->update($table);
	        if($res)
	          return true;
	        else
	          return false;
	    }

} //end of class
?>
