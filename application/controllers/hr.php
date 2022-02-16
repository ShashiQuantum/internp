<?php

class Hr extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('MHr');
    }

    function index()//index page
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $dd['msg']='';
         $this->load->view('sadm_login_form',$dd);
    }

    public function hashMake($string, $salt = '')
    {
	return hash('sha256', $string.$salt);
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

	//for siteadmin
        public function newemp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {        //$this->load->view('v_shome',$dd);
	                $str="<center>Varenia CIMS Pvt Ltd <h4>Employee Registraion Details </h4> <form method=post action='donewemp'><table> <tr><td>Emp ID *</td><td><input type=text name=empid id=empid placeholder='Emp Id as HR' required> </td></tr> ";
			$str.="<tr><td>Employee Full Name * </td><td><input type=text name=empname id=empname placeholder='Employee Name' required></td></tr>";
                        $str.="<tr><td>Email *</td><td><input type=email name=empemail id=empemail placeholder='personal or company email' required></td></tr>";
                        $str.="<tr><td>Mobile as Login *</td><td><input type=number name=empmobile id=empmobile placeholder='10 digit mobile no' required> </td></tr>";
                        $str.="<tr><td> Password *</td><td><input type=text name=emppass placeholder='Password' required> </td></tr>";
                        $str.="<tr><td> Designation *</td><td><input type=text name=empdesg id=empdesg placeholder='Designation' required> </td></tr>";
                        $str.="<tr><td>Role *</td><td><select name=emprole id=emprole><option value=1>HR</option><option value=2>MANAGER</option><option value=3>EMPLOYEE</option> </select></td></tr>";
                        $str.="<tr><td>Employee DOJ *</td><td><input type=date name=empdoj id=empdoj required> </td></tr>";
                        $str.="<tr><td>Employee DOB *</td><td><input type=date name=empdob id=empdob required ></td></tr>";
                        $str.="<tr><td>Employee DOB as Celebration *</td><td><input type=date name=empdobc id=empdob required ></td></tr>";
                        $str.="<tr><td>Shift Time Slot *</td><td><select name=empshift id=empshift><option value=1>08:00 AM - 05:00 PM</option><option value=2>09:00 AM - 06:00 PM</option> <option value=3>10:00 AM - 07:00 PM</option> </select></td></tr>";
                        $str.="<tr><td>Company *</td><td><select name=empcomp id=empcomp><option value=1>Varenia CIMS</option> </select></td></tr>";
                        $str.="<tr><td> Branch ID *</td><td><select name=empbranch id=empbranch><option value=1>Gurugram, Hariyana, India</option><option value=2>Delhi, India</option> <option value=3>Bengaluru, India</option><option value=4>Mumbai, India</option> </select></td></tr>";
                        $str.="<tr><td>Total Leave Alloted *</td><td><input type=number name=empleave min='0' max='22' placeholder='0 - 22' required></td></tr>";
                        $str.="<tr><td>Leave Alloted From *</td><td><input type=date name=empleavefrom required></td></tr>";
                        $str.="<tr><td>Leave Alloted Till *</td><td><input type=date name=empleavetill required></td></tr>";

                        $str.="<tr><td> </td><td><input type=submit name=submit value='SUBMIT'></td></tr> </table></form>";
			echo $str;
                }else
                        $this->load->view('sadm_login_form',$dd);
        }
        public function donewemp()
        {
		//print_r($_POST);
		$empid = $_POST['empid'];
		$ename = $_POST['empname'];
		$email = $_POST['empemail'];
		$emobile = $_POST['empmobile'];
                $epass = $_POST['emppass'];
                $edesg = $_POST['empdesg'];
                $erole = $_POST['emprole'];
                $edoj = strtotime( $_POST['empdoj'] ) * 1000;
                $edob = strtotime( $_POST['empdob'] ) * 1000;
                $edobc = strtotime( $_POST['empdobc'] ) * 1000;
                $eshift = $_POST['empshift'];
                $ecomp = $_POST['empcomp'];
                $eb = $_POST['empbranch'];
                $eleave = $_POST['empleave'];
                $eleavef = strtotime( $_POST['empleavefrom'] ) * 1000;
                $eleaveto = strtotime( $_POST['empleavetill'] ) * 1000;

		$uid = 0;
		//$salt='';
		 	$salt = $this->cryptGetToken(32);
			$length = 32;
			//$salt = mcrypt_create_iv($length);
			$pwd = $this->hashMake($epass, $salt);
		//echo "sa: $salt , pass: $epass , pwd: $pwd"; return;

		$chsq = "SELECT * FROM `vpms`.`vams_employee` WHERE emp_id = 'empid' OR mobile = '$emobile' OR email = '$email'";
              $sds=$this->MHr->getDataBySql($chsq);
              if(!$sds){
		$table = "vpms.vams_employee";
		$tdata = array('emp_id'=>$empid,'company_id'=>$ecomp,'branch_id'=>$eb,'name'=>$ename,'mobile'=>$emobile,'email'=>$email,'password'=>$pwd,'salt'=>$salt,'dob'=>$edob,'doj'=>$edoj, 'dobc'=>$edobc,'role'=>$erole,'img_url'=>'0','designation'=>$edesg,'timeslot_id'=>$eshift,'fcm_token'=>'0','status'=>'1' );
		$uid=$this->MHr->insertIntoTable($table,$tdata);
		//$sql1 = "INSERT INTO `vpms`.`vams_employee`(`emp_id`,`company_id`,`branch_id`,`name`,`mobile`,`email`,`password`,`salt`,`dob`,`doj`,`role`,`img_url`,`designation`,`timeslot_id`,`fcm_token`,`status`) VALUES ( '$empid', '$ecomp', '$eb', '$ename', '$emobile', '$email', '$epassword', '$salt', '$edob', '$edoj' , '$erole', '0', '$edesg', '$eshift' , 0, 1 );";
		//$rd1=$this->MProject->doSqlDML($sql1);
		

		echo $sql2 = "INSERT INTO `vpms`.`vams_leave` ( `emp_id`, `uid`, `leave_alloted`, `date_from`, `date_to`) VALUES ( '$empid', '$uid', '$eleave', '$eleavef','$eleaveto');";
		$rd=$this->MHr->doSqlDML($sql2);

		//echo "SQL1: $sql1 <br> SQL2: $sql2";
		echo "Sucessfully Done! <a href= 'base_url()hr/newemp'> Continue </a>";
	     } //end of if
	}
	
	//do emp edit
	public function doeditemp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
		//print_r($_POST);

		$uid = $_POST['uid'];
		$emp_id = $_POST['empid'];
		$name = $_POST['empname'];
		$email = $_POST['empemail'];
		//$mobile = $_POST['empmobile'];
		$c_id = $_POST['empcomp'];
		$b_id = $_POST['empbranch'];
		//$doj = $_POST['empdoj'];
                //$dob = $_POST['empdob'];
                $dobc = $_POST['empdobc'];
                $role = $_POST['emprole'];
                $des = $_POST['empdesg'];
                $tms = $_POST['empshift'];
                $st = $_POST['empstatus'];

		$table = "vpms.vams_employee";
		$coln = "id";
		//"doj"=>$doj,"dob"=>$dob,"mobile"=>$mobile,
		$adata = array("emp_id"=>$emp_id, "name"=>$name, "email"=>$email,"company_id"=>$c_id, "branch_id"=>$b_id,"dobc"=>$dobc,"role"=>$role,"designation"=>$des,"timeslot_id"=>$tms,"status"=>$st );
		$dd= $this->MHr->updateTableWhere($table,$coln,$uid,$adata);
		//$sql="UPDATE `vpms`.`vams_employee` SET  WHERE id = $uid ;";
		if($dd) echo "Sucessfully Updated details of $name";
		else	echo "Error! Something went wrong. Pls try again.";

	}

        //edit employee details
        public function editempdetail($uid)
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
			 $this->load->view('v_h');
                        //echo "<br><br><center><h4>EDIT EMPLOYEE DETAIL</h4> <br>";
                        $sql="SELECT * FROM `vpms`.`vams_employee` WHERE id = $uid ; ";
                        $data['empdata'] = $this->MHr->getDataBySql($sql);
			$data['type']='edit';
                        $this->load->view('v_viewempdetail',$data);



			/*
                        $sql="SELECT * FROM `vpms`.`vams_employee` WHERE id = $uid AND status=1 ; ";
                        $alldata = $this->MHr->getDataBySql($sql);
                        if(!empty($alldata)){ $i=0;
echo "<table border=1 cellpading=0 cellspacing=0> <tr> <td>SN </td> <td>USER ID</td> <td>EMP ID</td><td>NAME</td><td>DESIGNATION</td><td>DOJ</td>
<td>DOB</td><td>CELEBRATION DOB</td><td>COMPANY NAME</td><td>BRANCH</td> <td>ACTION</td></tr>";
                        foreach($alldata as $emp)
                        {
                                $i++;
                                $emp_uid = $emp->id;
                                $emp_id = $emp->emp_id;
                                $emp_name = $emp->name;
                                $emp_des = $emp->designation;
                                $emp_doj = date("Y-m-d",$emp->doj / 1000);
                                $emp_dob =  date("Y-m-d",$emp->dob / 1000);
                                $emp_dobc = $emp->dobc ;
                                if($emp_dobc!='') $emp_dobc =  date("Y-m-d",$emp->dobc / 1000);
                                $img_url = $emp->img_url;
                                $emp_com = $emp->company_id;
                                $emp_bra = $emp->branch_id;

echo "<tr><td> $i </td> <td>$emp_uid </td><td> $emp_id </td><td> $emp_name </td><td> $emp_des </td><td> $emp_doj </td><td> $emp_dob </td><td> $emp_dobc </td>
<td> $emp_com </td><td> $emp_bra </td> <td><a href='editempdetail/$emp_uid '> Edit </a></td></tr>";
                        }//end of loop
                        echo "</table>";
                        } //end of if
		*/	
		}
		else echo "Unauthorized Access! Re-login to continue.";
	}

	//edit employee details
        public function editemp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        $this->load->model('MHr');
                        $sql="SELECT * FROM `vpms`.`vams_employee` WHERE company_id = 1 order by id desc; ";
                        $data['alldata'] = $this->MHr->getDataBySql($sql);
                        $data['type']='edit';
                         $this->load->view('v_h');
                        $this->load->view('v_viewallemp',$data);
			
			/*
 			$this->load->view('v_h');
			echo "<style>tr:nth-child(even){background-color: #f2f2f2}</style>";
			echo "<br><br><center><h3>EDIT EMPLOYEE DETAIL</h3>";
                        $sql="SELECT * FROM `vpms`.`vams_employee` WHERE company_id = 1 AND status=1 order by id desc; ";
                        $alldata = $this->MHr->getDataBySql($sql);
		        if(!empty($alldata)){ $i=0;
echo "<table border=1 cellpading=0 cellspacing=0> <tr> <td>SN </td> <td>USER ID</td> <td>EMP ID</td><td>NAME</td><td>DESIGNATION</td><td>DOJ</td>
<td>DOB</td><td>CELEBRATION DOB</td><td>COMPANY NAME</td><td>BRANCH</td> <td>ACTION</td></tr>";
			foreach($alldata as $emp)
			{
				$i++;
        			$emp_uid = $emp->id;
				$emp_id = $emp->emp_id;
        			$emp_name = $emp->name;
        			$emp_des = $emp->designation;
        			$emp_doj = date("Y-m-d",$emp->doj / 1000);
                                $emp_dob =  date("Y-m-d",$emp->dob / 1000);
                                $emp_dobc = $emp->dobc ;
				if($emp_dobc!='') $emp_dobc =  date("Y-m-d",$emp->dobc / 1000);
			        $img_url = $emp->img_url;
				$emp_com = $emp->company_id;
				$emp_bra = $emp->branch_id;
				
echo "<tr><td> $i </td> <td>$emp_uid </td><td> $emp_id </td><td> $emp_name </td><td> $emp_des </td><td> $emp_doj </td><td> $emp_dob </td><td> $emp_dobc </td>
<td> $emp_com </td><td> $emp_bra </td> <td><a href='editempdetail/$emp_uid '> Edit </a></td></tr>";
			}//end of loop
			echo "</table>";
			} //end of if

			*/

		} //end of if
		else echo "Unauthorized Access";
	}

        //to add company details
        public function addcomp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        //echo "Currently not available";
			$this->load->view('v_addcomp');
                }
                else echo "Unauthorized Access";
        }

        //to map emp manager details
        public function map_emp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        //echo "Currently not available";
                         $this->load->view('v_h');
                        $this->load->model('MHr');
                        $sql="SELECT * FROM `vpms`.`vams_employee` WHERE company_id = 1 AND role IN (1,2) AND status = 1 order by id desc; ";
                        $gdata = $this->MHr->getDataBySql($sql);
			//$data['alldata']=$gdata;
                        //$data['type']='edit';
                        //$this->load->view('v_viewallemp',$data);
			echo "<br><br><br><br><center> <form action='viewempmap' method=post>";
			echo "Manager/HR : <select name=uid required> <option value=''>Select User</option> ";
			foreach($gdata as $dd)
			{
				$uid = $dd->id;
				$un = $dd->name;
				echo "<option value=$uid > $un </option> ";
			}
			echo "</select> <input type=submit value='View'> </form>";
			
                }
                else echo "Unauthorized Access";
        }

        //to add holiday details
        public function add_holiday()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
			$this->load->view(v_addholiday);
                }
                else echo "Unauthorized Access";
        }

        //to update leave allocation  details
        public function leave_allocation()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }
        //to approval req details
        public function approval_req()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }

        //to edit branch details
        public function editbranch()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }
        //to add branch details
        public function addbranch()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        //echo "Currently not available";
			$this->load->view('v_h');
			$this->load->view('v_addbranch');
                }
                else echo "Unauthorized Access";
        }
        //to view company list details
        public function listcomp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }

	public function monthly_attendance()
	{
		$this->load->view('v_h');
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "<br><br><br><center> <h4> Monthly Addendance Report</h4> <form action='do_monthly_attendance' method='post'>";
			echo "<input type=month name=month required>";
			echo "<input type=submit name=view name='View'></form> ";

                }
                else echo "Unauthorized Access";

	}
        public function do_monthly_attendance()
        {
		$this->load->view('v_h');
		echo "<br><br><br><center> <h4> Monthly Addendance Report</h4> <table border='1'> ";
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {

                        $dt = $_POST['month'];
                        $arr = explode('-',$dt);
                        $yr = $arr[0];
                        $mn = $arr[1];
			$ndays=0;
			if($mn==2) $ndays = 28;
                        if($mn==1 || $mn==3 || $mn==5 || $mn==7 ||$mn==8 ||$mn==10 ||$mn==12 ) $ndays = 31;
                        else $ndays = 30;
				echo "<tr><td>S.N.</td><td>EMPLOYEE</td><td>DETAILS</td><td colspan=$ndays >DATES </td></tr>";
                		echo "<tr><td></td>  <td> </td><td> </td>";
				for($i=1; $i <= $ndays; $i++)
				{
                                	echo "<td> $i </td>";
				}
				echo "</tr>";
				$ctr=0;
                                $msql="SELECT id, name, emp_id FROM `vpms`.`vams_employee` WHERE company_id = 1 AND status = 1; ";
                                $mdata = $this->MHr->getDataBySql($msql);
                                foreach($mdata as $da)
                                {
					$ctr++;
                                        $en=$da->name;
                                        $empid =$da->emp_id;
                                        $euid = $da->id;

                                        echo "<tr> <td> $ctr </td><td>  $en [code: $empid ] </td> <td>IN TIME</td>";

                                        for($i=1; $i <= $ndays; $i++)
                                        {
                   				$sql="SELECT substring( time(FROM_UNIXTIME( in_time/ 1000)) ,1,5) as in_time  FROM vpms.vams_attendance WHERE year(FROM_UNIXTIME( att_date/1000 )) = '$yr' AND month( FROM_UNIXTIME( att_date/1000 ))= '$mn' AND day( FROM_UNIXTIME( att_date/1000 )) = '$i' AND uid=$euid  limit 1;";
                        			$pdata = $this->MHr->getDataBySql($sql);
                        			if(!empty($pdata))
                        			foreach($pdata as $p)
			                        {
							$in_t = $p->in_time;
                                                	echo "<td> $in_t </td>";
						}
						else echo "<td> - </td>";
                                        }
                                        echo "</tr>";
                                        echo "<tr><td></td> <td>  <td>OUT TIME</td>";
                                        for($i=1; $i <= $ndays; $i++)
                                        {
                                                $sql="SELECT substring( time(FROM_UNIXTIME( out_time/ 1000)),1,5) as out_time FROM vpms.vams_attendance WHERE year(FROM_UNIXTIME( att_date/1000 )) = '$yr' AND month( FROM_UNIXTIME( att_date/1000 ))= '$mn' AND day( FROM_UNIXTIME( att_date/1000 )) = '$i' AND uid=$euid limit 1;";
                                                $pdata = $this->MHr->getDataBySql($sql);
                                                if(!empty($pdata))
                                                foreach($pdata as $p)
                                                {
                                                        $ou_t = $p->out_time;
                                                        echo "<td> $ou_t </td>";
                                                }
                                                else echo "<td> - </td>";

                                        }
                                        echo "</tr>";

                                        echo "<tr> <td></td> <td>  </td><td>STATUS</td> ";
                                        for($i=1; $i <= $ndays; $i++)
                                        {
                                                $sql="SELECT appr_status, manager_appr_status FROM vpms.vams_attendance WHERE year(FROM_UNIXTIME( att_date/1000 )) = '$yr' AND month( FROM_UNIXTIME( att_date/1000 ))= '$mn' AND day( FROM_UNIXTIME( att_date/1000 )) = '$i' AND uid=$euid  limit 1";
                                                $pdata = $this->MHr->getDataBySql($sql);
                                                if(!empty($pdata))
                                                foreach($pdata as $p)
                                                {
                                                        $hr_st = $p->appr_status;
							$mgr_st =$p->manager_appr_status;
                                                        echo "<td> HR: $hr_st <br> MGR: $mgr_st </td>";
                                                }
                                                else echo "<td> - </td>";

                                        }
                                        echo "</tr>";

                                        echo "<tr><td></td>  <td>  </td><td>REMARKS</td> ";
        	                        for($i=1; $i <= $ndays; $i++)
                	                {
                                                $sql="SELECT hr_remarks, manager_remarks FROM vpms.vams_attendance WHERE year(FROM_UNIXTIME( att_date/1000 )) ='$yr' AND month( FROM_UNIXTIME( att_date/1000 ))= '$mn' AND day( FROM_UNIXTIME( att_date/1000 )) = '$i' AND uid=$euid  limit 1";
                                                $pdata = $this->MHr->getDataBySql($sql);
                                                if(!empty($pdata))
                                                foreach($pdata as $p)
                                                {
                                                        $hr_rm = $p->hr_remarks;
                                                        $mgr_rm =$p->manager_remarks;
                                                        echo "<td> HR: $hr_rm <br> MGR: $mgr_rm </td>";
                                                }
                                                else echo "<td> - </td>";

	                                }
					echo "</tr>";

                                        echo "<tr><td></td>  <td>  </td><td>DURATION</td> ";
                                        for($i=1; $i <= $ndays; $i++)
                                        {
                                                //echo "<td> - </td>";
                                                $sql="SELECT time_to_sec( TIMEDIFF(time( FROM_UNIXTIME( out_time/1000 ) ) ,time( FROM_UNIXTIME( in_time/1000 ) ) ) )/3600 as hours FROM vpms.vams_attendance WHERE year(FROM_UNIXTIME( att_date/1000 )) ='$yr' AND month( FROM_UNIXTIME( att_date/1000 ))= '$mn' AND day( FROM_UNIXTIME( att_date/1000 )) = '$i' AND uid=$euid  limit 1";
                                                $pdata = $this->MHr->getDataBySql($sql);
                                                if(!empty($pdata))
                                                foreach($pdata as $p)
                                                {
                                                        $hrs = $p->hours;
                                                        echo "<td>  $hrs hour </td>";
                                                }
                                                else echo "<td> - </td>";
                                        }
                                        echo "</tr>";

                                }


                   $sql="SELECT * FROM vpms.vams_attendance WHERE year(FROM_UNIXTIME( att_date/1000 )) = '$yr' AND month( FROM_UNIXTIME( att_date/1000 )) = '$mn' ; ";
                        $pdata = $this->MHr->getDataBySql($sql);

                        if(!empty($pdata))
                        foreach($pdata as $p)
			{
				$patt = $p->att_date;
				$uid = $p->uid;
				//echo "<br> $uid / $patt ";
				
			}
			
                        //echo "echo <br><br><br><center> <h4> Monthly Addendance Report</h4>";

                }
                else echo "Unauthorized Access";

        }

        //tolist emp details
        public function listemp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }
        //to view employee manager map details
        public function viewempmap()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
			$uid = $_POST['uid'] ;
                        //echo "Currently not available";
                        $this->load->model('MHr');

		     //to get all mapped emp list
			$emp_list=array();
                        $sql="SELECT emp_uid FROM `vpms`.`vams_admin_emp` WHERE uid = $uid order by id desc; ";
                        $pdata = $this->MHr->getDataBySql($sql);
                        //$data['type']='report';
                         $this->load->view('v_h');
                        //$this->load->view('v_viewallemp',$data);
			echo "<br><br><br><center> <h4> Manager- Employee List</h4> <form action='domap' method=post> <table><input type=hidden name=muid value=$uid>";
			if(!empty($pdata))
			foreach($pdata as $p)
			{
				$emp=$p->emp_uid;
				array_push($emp_list,$emp);
				/*
				echo "emp id: $emp ";
	                        $nsql="SELECT name FROM `vpms`.`vams_employee` WHERE id = $uid; ";
        	                $ndata = $this->MHr->getDataBySql($nsql);
				foreach($ndata as $da)
				{
					$en=$da->name;
					echo "<input type=checkbox name=emplist[] $str >";
				}
				*/
			}
			else echo "<font color=red> [Note: None of employee is mapped to him/her! Select employee from below list and click on update button ] </font>";
		     //end of mapped l

                                $msql="SELECT id, name, emp_id FROM `vpms`.`vams_employee` WHERE company_id = 1 AND status = 1; ";
                                $mdata = $this->MHr->getDataBySql($msql);
                                foreach($mdata as $da)
                                {
                                        $en=$da->name;
					$empid =$da->emp_id;
					$euid = $da->id;
					$str ="";
					if(in_array($euid, $emp_list)) $str = " checked";
                                        echo "<tr><td> <input type=checkbox name=emplist[] value=$euid $str >  </td> <td> $en [code: $empid ] </td> </tr>"; 
                                }
				echo "<tr><td></td><td><input type=submit value = 'UPDATE' ></td></tr> </table></form>";

		}
                else echo "Unauthorized Access! Please login again";
        }
        //to view employee details
        public function domap()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
			$muid = $_POST['muid'];
			$emplist = $_POST['emplist'];
			if(!empty($emplist))
			foreach($emplist as $euid)
			{

				$gsql ="SELECT * from  `vpms`.`vams_admin_emp` WHERE uid = $muid AND emp_uid = $euid;";
				$gdata = $this->MHr->getDataBySql($gsql);
				if( empty($gdata))
				{
					$csql = "INSERT INTO `vpms`.`vams_admin_emp` (uid, emp_uid) values ($muid, $euid );";
				 	$ggdata = $this->MHr->doSqlDML($csql);
				}
			}
			echo "sucessfully updated";
		}
		else echo "Session has expired! Re-Login Now.";
	}

        //to view employee details
        public function viewemp()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        //echo "Currently not available";
			$this->load->model('MHr');
			$sql="SELECT * FROM `vpms`.`vams_employee` WHERE company_id = 1 order by id desc; ";
			$data['alldata'] = $this->MHr->getDataBySql($sql);
			$data['type']='report';
			 $this->load->view('v_h');
			$this->load->view('v_viewallemp',$data);
                }
                else echo "Unauthorized Access! Please login again";
        }
        //to view employee details
        public function viewempdetail($empid)
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        //echo "Currently not available";
                        $this->load->model('MHr');
                        $sql="SELECT * FROM `vpms`.`vams_employee` WHERE id = $empid ; ";
                        $data['empdata'] = $this->MHr->getDataBySql($sql);
			$data['type']='report';
                        $this->load->view('v_viewempdetail',$data);
                }
                else echo "Unauthorized Access! Please login again";
        }
        //to list branch details
        public function listbranch()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }
        //to report pending approval details
        public function approval_req_dt()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }
        //to add company details
        public function holiday_list()
        {
                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='Session Expired! Please login again.';
                $login=$this->session->userdata('sauserid');
                if($login)
                {
                        echo "Currently not available";
                }
                else echo "Unauthorized Access";
        }


} //end of class
