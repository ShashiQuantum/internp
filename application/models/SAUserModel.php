<?php

class SAUserModel extends CI_Model{
    public function getPQset($pid)
    { 
	    
	        $query=$this->db->query("SELECT distinct `qset_id` FROM `questionset` WHERE project_id='$pid'");
	        $results=$query->result();
	        if($results)
	        	return $results;
	        else
	        	return false;
    }
    public function getUser($uid)
    { 
        
        $query=$this->db->get_where('admin_user',array('user' => $uid));
        return $query->row();
    }
    public function getUsers()
    { 
        
        $query=$this->db->get('admin_user');
        return $query->result();
    }
    public function getUserDetails($uid)
    { 
        
        $query=$this->db->get_where('admin_user_info',array('user_id' => $uid));
        return $query->row();
    }
    public function isUser($uemail)
    { 
        
        $query=$this->db->get_where('admin_user',array('user' => $uemail));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }
  
    public function isUserID($uid)
    { 
        
        $query=$this->db->get_where('admin_user',array('user_id' => $uid));
        $res=$query->result();
        if($res)
          return true;
        else
          return false;
    }

    public function getUserID($uid)
    { 
	        $this->db->select('user_id');
	        $query=$this->db->get_where('admin_user',array('user' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->user_id;
	        else
	        	return false;
    }
    public function getUserEmail($uid)
    { 
	        $this->db->select('user');
	        $query=$this->db->get_where('admin_user',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->user;
	        else
	        	return false;
    }
    public function getUserPass($uid)
    { 
	        $this->db->select('pass');
	        $query=$this->db->get_where('admin_user',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->pass;
	        else
	        	return false;
    }
    public function getUserSalt($uid)
    { 
        $this->db->select('salt');
        $query=$this->db->get_where('admin_user',array('user_id' => $uid));
        $result=$query->row();
        if($result)
        	return $result->salt;
        else
        	return false;
    }
  
     public function getUserStatus($uid)
    { 
        $this->db->select('status');
        $query=$this->db->get_where('admin_user',array('user_id' => $uid));
        $result=$query->row();
        if($result)
        	return $result->status;
        else
        	return false;
    }
    public function insertUser($udata,$uinfo)
    {        
        $res=$this->db->insert('admin_user',$udata);
        //$res1=$this->db->insert('admin_user_info',$uinfo);

        //$res=1;
        if($res)
          return true;
        else
          return false;
    }

    public function hashMake($string, $salt = '')
    {
	return hash('sha256', $string.$salt);
    }
    public function salt($length)
    {
	return mcrypt_create_iv($length);
    }
    public static function unique()
    {
		return self::make(uniqid());
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

                                $check=$this->hashMake($password,$salt);
      				
				if($pass === $check && $st==1)
				{  
                                   $this->session->set_userdata(array('sauser'=>$username, 'sauserid'=>$uid));
                                   return true; 
                                }
                                else
                                {       
                                    return false;
                                }
 
			} 
		 
	}
	
	//do sign up
	public function do_signup($email=null)
	{
		
	        $check=$this->isUser($email);
	        if(!$check)
	 	{
		        $hash=$this->UserModel->signup($email);
		        if($hash)
		        {  
		        	$rv=$this->verification($email, $hash);
		          	return 'Please check your mail & get enlightened!';          	 
		        }
		        else
		        {
		           return 'Error';
		        } 
		}        
	        else
	        {
	           return 'Oops, You are already registered!';
	        } 
	        	
	}
  
      // SignUp User
	public function signup($email=null)
	{
		if($email)
		{
		        $timezone = "Asia/Calcutta";
			if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
	
		 	$hash = $this->cryptGetToken(32);
		 	$pass = rand(1000,9000);
	
			$this->insertUser(array(
                                 'user' => $email,
				'user_email' => $email,
				'pass' => $pass,
				'hash' => $hash,
				'create_date'=> $date
				),array(
				'email' => $email
				)
			);
			return $hash;
		}
		return false;
	}
 
        // Signup Verification Mail
	public function verification($email, $hash)
	{
		$subject = 'Welcome On-Board ! Verify your email and Login to Digiadmin.';
		$base_url=base_url();		
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href= $base_url title=digiadmin.quantumcs.com target=_blank><img alt=digiadmin.quantumcs.com src=$base_url></a>
			
			<b>Welcome to Digiadmin!</b>
			
			Digiadmin lets you offer to Online Payment, View Project Detail, etc.
			
			So Let&#39;s get you started !

			To complete your registration, please click on the link below:

			Link : <a href="https://www.digiadmin.quantumcs.com/v/welcome/verify?h=' . $hash . '">Activate</a>
			
			If the above link doesn&#39;t work, please copy and paste the link in your web browser address bar.
			
			If you are still having problem in signing up, please contact:
			<a href="vcims.contact@gmail.com" target="_blank"> vcims.contact@gmail.com </a>
			Contact No: 0124-4055205
			
			Here is how we make viewing project details/payment online so easy for you.
			<ol>
			<li>Just Login</li>
			<li>Select the Project/Dashboard/Payment in sidebar.</li>
			<li>For Payment Make the Initial Payment via Online Payments, etc.</li>
			
			</ol>
			
			<b>Enjoy With Services!
			Team, digiadmin.quantumcs.com</b>
			
			<font size="2px"><center><b>digiadmin.quantumcs.com</b>
			Contact No: 0124-4055205 Email: vcims.contact@gmail.com</center></font>
			</body>
			</html>';

		$this->sendMail($email,$subject,nl2br($message));
	}
	public function sendMail($email,$subject,$message)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: info@digiadmin.quantumcs.com' . "\r\n" .'Reply-To: $email';
			
		return $fs= mail($email, $subject, nl2br($message), $headers);
	}
	// Forgot Password Mail
	public function forgot_password($email, $hash)
	{
		$subject = 'digiadmin.quantumcs.com - Password Change Request';
					
		$message = '<html>
			<body bgcolor="#ffffff">
			<a href="'.$this->base.'" title="digiadmin.quantumcs.com" target="_blank"><img alt="digiadmin.quantumcs.com" src="'.$this->logo.'"></a>
			
			<b>Hi,</b>
			
			We have received a password change request for your Digiadmin account: '.$email.'
			
			If you made this request, then please click on the link below:
			Link : '.$this->base.'welcome/forgot.php?h='.$hash.'
			
			If the above link doesn&#39;t work, please copy and paste the link in your web browser address bar.
			
			This link will work for 2 hours or until you reset your password.
			
			If you did not ask to change your password, then please ignore this email. No changes will be made to your account.
			
			Please remember not to share your password with anyone.

			We hope to see you at digiadmin.quantumcs.com
			
			<b>Enjoy Reading!
			Team, IndiaReads.com</b>
			
			<font size="2px"><center><b>digiadmin.quantumcs.com</b>
			Contact No: 0124-4055205 Email: vcims.contact@gmail.com</center></font>
			</body>
			</html>';

		$this->sendMail($email,$subject,nl2br($message));
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
       
        public function update_user_details($user=null, $details=array())
	{
		if($user)
		{
			$field = 'user_id';
			$data = $this->db->update('admin_user_info', $field, $user, $details);
			if($data)
			{
				return true;
			}
		}
		return false;
	}

        // Fetch user from hash -- forgot password
	public function get_user_by_hash($hash=null)
	{
		if($hash)
		{
                        $this->db->select('user_id');
                        $query=$this->db->get_where('admin_user',array('hash' => $hash));
                        $result=$query->row();
                        if($result)
                         return $result->user_id;
                        else
                         return false;
			
		}
		return false;
	}
        // Fetch user from hash -- forgot password
	public function isverify_user_by_hash($hash=null)
	{
		if($hash)
		{
                         $this->db->select('status');
                         $query=$this->db->get_where('admin_user',array('hash' => $hash));
                         $result=$query->row();
                        //$sql="select verify from web_user where hash='$hash'";
                        //$result=$this->db->query($sql);
                        if($result)
                         return $result->status;
                        else
                         return false;
			
		}
		return false;
	}
	
	// Fetch user from hash
	public function get_hash_by_user($uid=null)
	{
		if($user)
		{
                        $this->db->select('hash');
                        $query=$this->db->get_where('admin_user',array('user_id' => $uid));
                        $result=$query->row();
                        return $result->hash;

		}
		return false;
	}
	//do user verify
        public function do_verify($hash=null)
        {
           $uid = $this->get_user_by_hash($hash);  
           $ps=$this->isverify_user_by_hash($hash);
           if($uid && $ps==0)
           {
                
               
               return $uid;
           }
           else
           {
               return false;
           }
          
        }
        //do set the user password
        public function do_setpass($uid=null,$npass=null,$uname=null,$mobile1=null,$mobile2=null)
        {
           $email=$this->getUserEmail($uid);
           $uid = $this->verify($uid,$npass,$uname,$mobile1,$mobile2,$email);  
           if($uid)
           {
               return true;
           }
           else
           {
               return false;
           }
          
        }
	// Verify User
	public function verify($user=null, $pass=null,$uname=null,$mobile1=null,$mobile2=null,$email=null)
	{
		if($user && $pass)
		{
			$timezone = "Asia/Calcutta";
			if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$dt = date('Y-m-d H:i:s');
			
			$salt = $this->cryptGetToken(32);
			$pwd = $this->hashMake($pass, $salt);
                        
			//$create = $this->_db->insert('admin_user_info',array('user_id'=> $user)); 

			$update = $this->db->set(array('pass' => $pwd, 'status' => 1, 'salt' => $salt, 'verify' => $dt));
                        $this->db->where('user_id', $user);
                        $update = $this->db->update('admin_user');

                        
			$update1 = $this->db->set(array('user_id' => $user,'name' => $uname, 'mobile1' => $mobile1, 'mobile2' => $mobile2));
                        $this->db->where('email', $email);
                        $update1 = $this->db->update('admin_user_info');

			return true;
		}
		return false;
	}
	
	// Reset New User Password while Forgot Password
	public function reset_pass($user=null, $pass=null)
	{
		if($user && $pass)
		{
			$timezone = "Asia/Calcutta";
			if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
			
			$salt = $this->cryptGetToken(32);
			$pwd = $this->hashMake($pass, $salt);
			$this->db->where('user_id', $user); 
			$update = $this->db->update('admin_user',array('pass' => $pwd, 'status' => 1, 'salt' => $salt));
			return true;
		}
		return false;
	}

        //
        public function getroles()
        {
                $this->db->select('*');
	        $query=$this->db->get('user_role_detail');
	        $results=$query->result();
	        if($results)
	        	return $results();
	        else
	        	return false;
        }

        public function getuserrole($uid=null)
        {
                $this->db->select('role_id');
	        $query=$this->db->get_where('admin_user_role',array('user_id' => $uid));
	        $result=$query->row();
	        if($result)
	        	return $result->role_id;
	        else
	        	return false;
        }

        public function adduserrole($udata)
        {
               $res=$this->db->insert('admin_user_role',$udata);
        
               if($res)
                   return true;
               else
                  return false;
        }

        public function updateuserrole()
        {
               
        }
    
        public function getpermissions()
        {
                $this->db->select('*');
	        $query=$this->db->get('user_permission');
	        $results=$query->result();
	        if($results)
	        	return $results;
	        else
	        	return false;
        }

        public function getuserpermissionmap($uid=null)
        {
                $this->db->select('prm_id');
	        $query=$this->db->get_where('user_permission_map',array('user_id' => $uid, 'status' => 1 ));
	            
	        $results=$query->result();
	        if($results)
	        {    
	         	$out=array();
	        	foreach($results as $p)
                        {
                             array_push($out,$p->prm_id);
                        }
	        	return $out;
	        }
	        else
	        	return false;
        }

        public function getuserpermissionrolemap($uid=null)
        {
                $this->db->select('*');
	        $query=$this->db->get_where('user_permission_role_map',array('user_id' => $uid));
	        $results=$query->result();
	        if($results)
	        	return $results;
	        else
	        	return false;
        }

        public function addpermission($udata=null)
        {
                 $res=$this->db->insert('user_permission',$udata);
         
                 if($res)
                    return true;
                 else
                    return false;
        }
        
        public function adduserpermissionmap($udata=null)
        {
                 $res=$this->db->insert('user_permission_map',$udata);
         
                 if($res)
                    return true;
                 else
                    return false;
        }
        public function isuserpermissionmap($uid=null,$prm=null)
        {
                $this->db->select('*');
	        $query=$this->db->get_where('user_permission_map',array('user_id' => $uid,'prm_id' => $prm));
	        $results=$query->result();
	        if($results)
	        	return true;
	        else
	        	return false;
        }
        public function deletepermission()
        {

        }


        public function deleteuserpermissionmap()
        {

        }

        public function addgetuserpermisionrolemap()
        {
                 $res=$this->db->insert('user_permission_role_map',$udata);
         
                 if($res)
                    return true;
                 else
                    return false;
        }

        public function deleteuserpermisionrolemap()
        {

        }
        public function create_sauser($email,$pass,$name,$mobile,$r)
        {
                  if(!$this->isUser($email))
                  {
                        $timezone = "Asia/Calcutta";
			if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
	
		 	$salt = $this->cryptGetToken(32);
			$pwd = $this->hashMake($pass, $salt);
                        
			
                        $create = $this->db->insert('admin_user',array('user'=> $email,'pass'=> $pwd,'salt'=> $salt,'role'=> $r,'create_date'=> $date,'status'=> 1));
                        $userid=$this->getUserID($email);
                        if($userid)
                        {
                             $create1 = $this->db->insert('admin_user_info',array('user_id'=> $userid,'name'=> $name,'email'=> $email,'mobile1'=> $mobile)); 
                             $create2 = $this->db->insert('admin_user_role',array('user_id'=> $userid,'role_id'=> $r,'date'=> $date));
                             return true;
                        }
                       
                  } //end of isuserid
              return false;
                        
        }
} //end of the class UserModel

