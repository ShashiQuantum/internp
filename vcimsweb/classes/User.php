<?php

include_once __DIR__ .'/../classes/DB.php';
include_once __DIR__ .'/../classes/Config.php';
include_once __DIR__ .'/../classes/Input.php';
include_once __DIR__ .'/../classes/Hash.php';
include_once __DIR__ .'/../classes/Session.php';

//require_once __DIR__ . '/../Redirect.php';
class User
{
	private $_db, $_data, $_sessionName,$_cookieName, $isLoggedIn;

	public function __construct($user=null)
	{
	
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if(!$user)
		{
			if(Session::exists($this->_sessionName))	
			{
				$user = Session::get($this->_sessionName);
			
				if($this->find($user))
				{
					$this ->isLoggedIn = true;
				}
				else
					{ 
						$this->logout();
					}
			}
		} 
		else
		{
			$this->find($user);
		
		}
	}
	
	// Create User Account
	public function create($fields=array())
	{
		if($this->_db->insert('admin_user',$fields))
		{ echo 'inserted in admin_user';
			return true;
		}
		else
		{
			throw new Exception('Problem Creating account');
		}
	}

	// Find the User by its User-ID or Email-ID or Alternate-Email-ID and returns true/false
	public function find($user=null)
	{
		if($user)
		{
			$field = (is_numeric($user)) ? 'admin_user': 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data)
			{
				$this->_data = $data->first();
				return true;
			}
			else
			{
				$data = $this->_db->get('admin_user',array($field, '=', $user));
				if($data) 
				{
					$this->_data = $data->first();
					return true;
				}
			}
		}
		return false;
	}

	// Find the User by its User-ID or Email-ID or Alternate-Email-ID and returns the user-data
	public function finds($user=null)
	{
		if($user)
		{
			$field = (is_numeric($user)) ? 'admin_user': 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				$this->_data = $data->first()->user_id;
				return $this->_data;
			}
			else
			{
				$data = $this->_db->get('admin_user',array($field, '=', $user));
				if($ata) 
					{
						$this->_data = $data->first()->user_id;
					return $this->_data;
				}
			}
		}
		return false;
	}

	// Login the user by verifying its username and password
	public function login($username = null,$password = null,$remember = true)
	{
	
		if(!$username && !$password && $this->exists())	
		{
		
			Session::put($this->_sessionName,$this->data()->userid);
		}
		else
		{ 
			$user=$this->find($username);		
			if($user)
			{	
				
      				$check=Hash::make(Input::get('pass'),$this->data()->salt);
      				$this->data()->pass;
				if($this->data()->pass === $check)
				{	
					Session::put($this->_sessionName, $this->data()->user_id);
					Session::put('user_id',$this->data()->user_id);
					Session::put('user',$this->data()->user);
					if($remember)
					{
						$hashcheck = $this->_db->get('session',array('user_id','=',$this->data()->user_id));

						if(!$hashcheck->count())
						{
							$hash = Hash::unique();
							$this->_db->insert('session',array(
								'user_id' => $this->data()->user_id,
								'hash' => $hash,
								'email' => $username
								));
						}
						else
						{
							$hash = $hashcheck->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}
					
					return true;
				}
			}
		}
		return false;
	}

	// Logout the user destroying the session and cookie
	public function logout()
	{
		//$this->_db->update_last_seen($this->data()->user_id);
		//$this->_db->delete('session',array());
		session_destroy();
		Cookie::delete($this->_cookieName);
		
		//Redirect::to('login_fp.php');
	}

	// Returns the user-data
	public function data()
	{
		return $this->_data;
	}

	// Check whether user is loggedin or not
	public function isLoggedIn()
	{
		return $this->isLoggedIn;
	}

	// Check whethre user exists or not
	public function exists()
	{
		return (!empty($this->_data))? true: false;;
	}
	
	// Fetch the User-Email-ID by Its User-ID
	public function get_user_email($user=null)
	{
		if($user)
		{
			$field = 'user_id';
			$data = $this->_db->get('user_login',array($field, '=', $user));
			if($data->count())
			{
				return $data->first()->user_email;
			}
		}
		return false;
	}
	
	// Fetch the UserName by its User-ID
	public function get_user_name($user=null)
	{
		if($user)
		{
			$field = 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				$fname = $data->first()->first_name;
				$lname = $data->first()->last_name;
				return $fname.' '.$lname;
			}
		}
		return false;
	}
	
	// Fetch the User's Last seen Timestamp
	public function get_last_seen($user=null)
	{
		if($user)
		{
			$field = 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				return $data->first()->last_seen;
			}
		}
		return false;
	}
	
	// Fetch the User's Creatd Timestamp
	public function get_created($user=null)
	{
		if($user)
		{
			$field = 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				return $data->first()->created;
			}
		}
		return false;
	}
	
	// Fetch User Status
	public function get_user_status($user=null)
	{
		if($user)
		{
			$field = 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				return $data->first()->status;
			}
		}
		return false;
	}
	
	// Update User's Last Seen Timestamp
	public function update_last_seen($user=null)
	{
		if($user)
		{
			$field = 'user';
			$dt = date('Y-m-d H:i:s');
			$data = $this->_db->update('admin_user', $field, $user, array('last_login' => $dt));
			if($data)
			{
				return true;
			}
		}
		return false;
	}
	
	// Delete User
	public function delete_user($user=null)
	{
		if($user)
		{
			$field = 'user';
			$status = Dictionary::get_key('status', 'deleted');
			$data = $this->_db->update('admin_user', $field, $user, array('status' => $status));
			if($data)
			{
				return true;
			}
		}
		return false;
	}
	
	// Activate User
	public function active_user($user=null)
	{
		if($user)
		{
			$field = 'user';
			$status = Dictionary::get_key('user_status', 'active');
			$data = $this->_db->update('admin_user', $field, $user, array('status' => $status));
			if($data)
			{
				return true;
			}
		}
		return false;
	}
	
	// Inactivate User
	public function inactive_user($user=null)
	{
		if($user)
		{
			$field = 'user';
			$status = Dictionary::get_key('status', 'inactive');
			$data = $this->_db->update('admin_user', $field, $user, array('status' => $status));
			if($data)
			{
				return true;
			}
		}
		return false;
	}
	
	// Block User
	public function block_user($user=null)
	{
		if($user)
		{
			$field = 'user';
			$status = Dictionary::get_key('status', 'blocked');
			$data = $this->_db->update('admin_user', $field, $user, array('status' => $status));
			if($data)
			{
				return true;
			}
		}
		return false;
	}
	
	// Fetch User details
	public function get_user_details($user=null)
	{
		if($user)
		{
			$field = 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				return $data->first();
			}
		}
		return false;
	}
	
	// Fetch User id details
	public function get_userid($user=null)
	{
		if($user)
		{
			$field = 'user';
			$data = $this->_db->get('admin_user',array($field, '=', $user));
			if($data->count())
			{
				return $data->first()->user_id;
			}
		}
		return false;
	}
	/* Fetch User Gender
	public function get_user_details($user=null)
	{
		if($user)
		{
			$field = 'user_id';
			$data = $this->_db->get('user_info',array($field, '=', $user));
			if($data->count())
			{
				return $data->first()->gender;
			}
		}
		return false;
	}
	*/
	// Update User Details $detail = array('first_name' => $fname, 'last_name' => $lname, 'alternate_email' => $alt_email,
	//									   'birthdate' => $bday, 'landline' => $land, 'mobile' => $mobile, 'picture' => $pic,
	//									   'gender' => $gender)
	public function update_user_details($user=null, $details=array())
	{
		if($user)
		{
			$field = 'user_id';
			$data = $this->_db->update('admin_user', $field, $user, $details);
			if($data)
			{
				return true;
			}
		}
		return false;
	}
        public function reset_password($username = null, $remember = true)
	{	 
		if(!$username && $this->exists())	
		{		
			Session::put($this->_sessionName, $this->data()->user_id);
		}
		else
		{  
			$user=$this->find($username);		
			if($user)
			{		//echo 'up:'.$this->data()->pass;			
      				$check=Hash::make(Input::get('cpass'),$this->data()->salt);
      				//echo ' <br> pass:'.$this->data()->user_password;
				if($this->data()->pass === $check)
				{	 
					$uid=$this->data()->user_id;
					Session::put($this->_sessionName, $this->data()->user_id);
					Session::put('user_id',$this->data()->user_id);
					Session::put('cuser',$this->data()->user);
					if(Input::get('npass')!=Input::get('npassrepeat'))
					    {
					      $status='error';
					      $message='The passwords must match!';
					    }
					    else
					    {
					      date_default_timezone_set('Asia/Calcutta');
					      
					     $u=Session::get('user_id');
					      
					      $salt=Crypt::getToken(32);
					      $pwd=Hash::make(Input::get('npass'),$salt);
					      
					      //$update=DB::getInstance()->update('admin_user','user_id',$u,array('user_password' => $pwd,'status' =>'1' ,'salt' => $salt));
					      $ss="UPDATE admin_user SET pass = '$pwd',status = 1,salt = '$salt' WHERE user_id=$uid";
					       $update=DB::getInstance()->query($ss);
					      if($update) 
					      {
					        //$mail=DB::getInstance()->query('SELECT user_email from user_login where user_id=?',array($u))->first()->user_email;
					        Session::put('cuser',$u);
					        //Session::put('email',$mail);
					        $status='success';
					        $message='Password reset successfull, login again!';
					      }else $message='Password not reset, try again...';
					    }
                                          //echo $message;
					Session::put($this->_sessionName, $this->data()->user_id);
					Session::put('uid',$this->data()->user_id);
					Session::put('cuser',$this->data()->user);
					if($remember)
					{
						Cookie::put($this->_cookieName, $this->data()->user, Config::get('remember/cookie_expiry'));
					}
					
					return true;
				}
			}
		}
             
		return false;
	}

       public function reset_newpassword($username = null, $remember = true)
	{	
		if(!$username && $this->exists())	
		{		
			Session::put($this->_sessionName, $this->data()->user_id);
		}
		else
		{  
			$user=$this->find($username);		
			if($user)
			{		//echo 'up:'.$this->data()->pass;			
      				//$check=Hash::make(Input::get('cpass'),$this->data()->salt);
      				//echo ' <br> pass:'.$this->data()->user_password;
				//if($this->data()->pass === $check)

                                if(Input::get('npass')==Input::get('npassrepeat'))
				{	 
					$uid=$this->data()->user_id;
					Session::put($this->_sessionName, $this->data()->user_id);
					Session::put('user_id',$this->data()->user_id);
					Session::put('cuser',$this->data()->user);
					if(Input::get('npass')!=Input::get('npassrepeat'))
					    {
					      $status='error';
					      $message='The passwords must match!';
					    }
					    else
					    {
					      date_default_timezone_set('Asia/Calcutta');
					      
					     $u=Session::get('user_id');
					      
					      $salt=Crypt::getToken(32);
					      $pwd=Hash::make(Input::get('npass'),$salt);
					      
					      //$update=DB::getInstance()->update('admin_user','user_id',$u,array('user_password' => $pwd,'status' =>'1' ,'salt' => $salt));
					      $ss="UPDATE admin_user SET pass = '$pwd',status = 1,salt = '$salt' WHERE user_id=$uid";
					       $update=DB::getInstance()->query($ss);
					      if($update) 
					      {
					        //$mail=DB::getInstance()->query('SELECT user_email from user_login where user_id=?',array($u))->first()->user_email;
					        Session::put('cuser',$u);
					        //Session::put('email',$mail);
					        $status='success';
					        $message='Password reset successfull, login again!';
					      }else $message='Password not reset, try again...';
					    }
                                          //echo $message;
					Session::put($this->_sessionName, $this->data()->user_id);
					Session::put('uid',$this->data()->user_id);
					Session::put('cuser',$this->data()->user);
					if($remember)
					{
						Cookie::put($this->_cookieName, $this->data()->user, Config::get('remember/cookie_expiry'));
					}
					echo 'Password changed successfully.';
					return true;
				}
			}
		}
              echo 'Password not changed. Error...';
		return false;
	}
}