<?php
class MUser extends CI_Model
{
    function create_user($data)
    {
        $this->db->insert('web_user', $data);
        return $this->db->insert_id();
    }
/*    function login($username, $password, $s=null)
    {
        $match = array(
            'user'=>$username,
            'pass' => sha1($password)
        );
        
        $this->db->select()->from('web_user')->where($match);
        $query = $this->db->get();
        return $query->first_row('array');
    }
*/
    function get_emails()
    {
        $this->db->select('user_email');
        $this->db->from('web_user');
        $query = $this->db->get();
        return $query->result_array();
    }

    //user

    public function login($username = null,$password = null, $ut=null)
    {
			$user=$this->isUser($username);		
			if($user) 
			{  
                        	$uid=$this->getUserID($username);
                                $pass=$this->getUserPass($uid);
                                $salt=$this->getUserSalt($uid);
                                $ur=$this->getUserRole($uid);
                                if($ur==0) $ut='user'; if($ur==1) $ut='admin';

                                $check=$this->hashMake($password,$salt);
      				
				if($pass === $check)
				{  
                                   $this->session->set_userdata(array('vwebuser'=>$username, 'vwebuserid'=>$uid));
                                   $arr=array('user_id'=>$uid,'username'=>$username, 'user_type'=>$ut);
                                   return $arr; 
                                }
                                else
                                {       
                                    return false;
                                }
 
			} 
		 
     }
    public function hashMake($string, $salt = '')
    {
	return hash('sha256', $string.$salt);
    }
    public function salt($length)
    {
	return mcrypt_create_iv($length);
    }
    public function getUserDetails($uid)
    { 
        $query=$this->db->get_where('vcims_user_info',array('user_id' => $uid));
        return $query->row();
    }
    public function isUser($uemail)
    { 
        $query=$this->db->get_where('web_user',array('user' => $uemail));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }
  
    public function isUserID($uid)
    { 
        $query=$this->db->get_where('web_user',array('user_id' => $uid));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }

    public function getUserID($uid)
    { 
	        $this->db->select('user_id');
	        $query=$this->db->get_where('web_user',array('user' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->user_id;
	        else
	        	return false;
    }
    public function getUserEmail($uid)
    { 
	        $this->db->select('user');
	        $query=$this->db->get_where('web_user',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->user;
	        else
	        	return false;
    }
    public function getUserRole($uid)
    { 
	        $this->db->select('role');
	        $query=$this->db->get_where('web_user',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->role;
	        else
	        	return false;
    }
    public function getUserStatus($uid)
    { 
	        $this->db->select('status');
	        $query=$this->db->get_where('web_user',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->status;
	        else
	        	return false;
    }
    public function getUserPass($uid)
    { 
	        $this->db->select('pass');
	        $query=$this->db->get_where('web_user',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->pass;
	        else
	        	return false;
    }
    public function getUserSalt($uid)
    { 
        $this->db->select('salt');
        $query=$this->db->get_where('web_user',array('user_id' => $uid));
        $result=$query->row();
        if($result)
        	return $result->salt;
        else
        	return false;
    }

}
