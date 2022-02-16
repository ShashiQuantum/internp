<?php

class MVpmslogin extends CI_Model
{

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function login($username = null,$password = null)
    {
			$user=$this->isUser($username);		
			if($user) 
			{
								$uid=$this->getUserID($username);
                                $pass=$this->getUserPass($uid);
                                $salt=$this->getUserSalt($uid);
                                $st=$this->getUserStatus($uid);
                                $urole=$this->getUserRole($uid);
                                $uname=$this->getUserName($uid);

                                $check=$this->hashMake($password,$salt);
      				
				if($pass === $check && $st==1)
				{  //$_SESSION['sauserid']=$uid;$_SESSION['sauser']=$username;
                                   $this->session->set_userdata(array('user_id'=>$uid,'user'=>$uname, 'role'=>$urole));
                                   return true; 
                                }
                                else
                                {       
                                    return false;
                                }
 
			} 
    }
    public function reset_password($uid = null,$password = null)
    {
			                                    				
				$salt = $this->cryptGetToken(32);
				$pwd = $this->hashMake($password, $salt);
				//$this->db->where('user_id', $uid); 
				$update = $this->db->query("UPDATE vpms.'vpms_user' SET 'pass' = '$pwd', 'salt' = '$salt' WHERE user_id=$uid");
                                   return true; 
    }
    public function cryptGetToken($length)
    {
			    $token = "";
			    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
			    $codeAlphabet.= "0123456789";
			    for($i=0;$i<$length;$i++){
			        $token .= $codeAlphabet[self::crypto_rand_secure(0,strlen($codeAlphabet))];
			    }
			    return $token;
    }
        public function crypto_rand_secure($min, $max) 
	{
	        $range = $max - $min;
	        if ($range < 0) return $min; // not so random...
	        $log = log($range, 2);
	        $bytes = (int) ($log / 8) + 1; // length in bytes
	        $bits = (int) $log + 1; // length in bits
	        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	        do {
	            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	            $rnd = $rnd & $filter; // discard irrelevant bits
	        } while ($rnd >= $range);
	        return $min + $rnd;
	}
    public function getUserID($uid)
    { 
	        $this->db->select('user_id');
	        $query=$this->db->query("select * from vpms.'vpms_user' where 'user' = $uid");
	        $result=$query->row();
	        if($result)
	        	return $result->user_id;
	        else
	        	return false;
    }
    public function getUserPass($uid)
    { 
	        $this->db->select('pass');
	        $query=$this->db->query("select * from vpms.'vpms_user' where 'user_id' = $uid");
	        $result=$query->row();
	        if($result)
	        	return $result->pass;
	        else
	        	return false;
    }
    public function getUserSalt($uid)
    { 
        $this->db->select('salt');
        $query=$this->db->query("select * from vpms.'vpms_user' where 'user_id' = $uid");
        $result=$query->row();
        if($result)
        	return $result->salt;
        else
        	return false;
    }
  
     public function getUserStatus($uid)
    { 
        $this->db->select('status');
        $query=$this->db->query("select * from vpms.'vpms_user' where 'user_id' = $uid");
        $result=$query->row();
        if($result)
        	return $result->status;
        else
        	return false;
    }
     public function getUserRole($uid)
    { 
        $this->db->select('role');
        $query=$this->db->query("select * from vpms.'vpms_user' where 'user_id' = $uid");
        $result=$query->row();
        if($result)
        	return $result->role;
        else
        	return false;
    }
    public function getUserName($uid)
    { 
        $this->db->select('name');
        $query=$this->db->query("select * from vpms.'vpms_user_info' where 'user_id' =  $uid");
        $result=$query->row();
        if($result)
        	return $result->name;
        else
        	return false;
    }

    public function isUser($uemail)
    { 
        
        $query=$this->db->query("select * from vpms.vpms_user where 'user' = '$uemail';");
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }
//------------------------------------------------------------
    public function validate_user($data)
    {
        //$this->db->where('user', $data['username']);
        //$this->db->where('pass', $data['password']);
	$usr=$data['username'];
	$pas=$data['password'];
        return $this->db->query("select * from vpms.vpms_user WHERE user='$usr' AND pass='$pas'")->row();
    }
	
	//////////////////////////////// VERIFY USER FOR RESET PASSWORD ///////////////////
	 public function verify_user($data)
	{
        //$this->db->where('email', $data['email']);
        //$this->db->where('mobile', $data['mobile']);
        $ue=$data['email'];
        $um=$data['mobile'];
        return $this->db->query("select * from vpms.vpms_user_info WHERE email='$ue' AND mobile='$um'")->row();
    }
	
	//getting permissions
	function permissions($user_id)
	{
		$query=$this->db->query("select * from vpms.vpms_user_permission_map where user_id='$user_id'");
		return $query->result();
	}
	
	
	//getting user info
	function user_info()
	{
		$query=$this->db->query("select * from vpms.vpms_user_info where user_id IN(select user_id from vpms.vpms_user where role=1 OR role=3)");
		return $query->result();
	}
	
	//getting username
	function get_user_name($user_id)
	{
		$query=$this->db->query("select name from vpms.vpms_user_info where user_id='$user_id'");
		$row=$query->row();
		if($row)
			return $row->name;
		else
			return 0;
	}
	
    public function hashMake($string, $salt = '')
    {
	return hash('sha256', $string.$salt);
    }
    public function salt($length)
    {
	return mcrypt_create_iv($length);
    }

	//getting dept
	function get_user_dept($user_id)
	{
		$query=$this->db->query("select dept from vpms.vpms_user_info where user_id='$user_id'");
		$row=$query->row();
		if($row)
			return $row->dept;
		else
			return 0;
	}
	
	//Getting Reported person details to reporting manager
	function get_rep_pers($email)
	{
		$query=$this->db->query("select * from vpms.vpms_user_info where reporting_to='$email'");
		return $query->result();
	}
	
	//Getting Reported person details for edit details
	function get_rep_pers_id($user_id)
	{
		$query=$this->db->query("select * from vpms.vpms_user_info where user_id='$user_id'");
		return $query->result();
	}
	
	// GETTING email as per uid
	function get_email($uid)
	{
		$query=$this->db->query("select email from vpms.vpms_user_info where user_id='$uid'");
		$row=$query->row();
		if($row)
			return $row->email;
		else
			return 0;
	}

    function __destruct() 
	{
        $this->db->close();
    }
}

