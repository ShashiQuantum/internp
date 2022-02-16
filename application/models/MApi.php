<?php

class MApi extends CI_Model {

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

}
