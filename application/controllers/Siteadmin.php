<?php

class Siteadmin extends CI_Controller {
//        echo("<script>console.log('PHP: INSIDE INDEX3');</script>");

    function __construct() {
       // echo("<script>console.log('PHP: INSIDE INDEX1');</script>");

        parent::__construct();
       // echo("<script>console.log('PHP: INSIDE INDEX1');</script>");

//        $this->load->model('my_project');
	date_default_timezone_set('Asia/Kolkata');

    }

    function index()
    {
	echo("<script>console.log('PHP: INSIDE INDEX2');</script>");
//        $this->load->model('my_project');

	date_default_timezone_set('Asia/Kolkata');
       // $data['posts'] = $this->MDb->get_posts(5, $start);
	$this->load->helper('url');
	$this->load->helper('form');
        //pagination
        //$this->load->library('pagination');
        //$data['pages'] = $this->pagination->create_links(); //Links of pages
	$dd['msg']=''; 
//	console.log('ERROR INDEX VALUE');
        //$class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
         //$this->load->view('header', $class_name);
        $this->load->view('sadm_login_form',$dd);

         //$this->load->view('footer');
    }


    function privacypolicy()
    {
        $this->load->helper('url');

        $this->load->view('termpolicy',$dd);
    }

//for siteadmin
        public function siteadmin2()
        {
        	$this->load->helper('url'); 
	        $this->load->helper('form');       
	        $dd['msg']='Session Expired! Please login again.';
		$login=$this->session->userdata('sauserid');
		if($login)
	        	$this->load->view('v_shome',$dd);
		else
			$this->load->view('sadm_login_form',$dd);
        }
        public function forgetpassword()
        {
                echo("<script>console.log('PHP FORGOT: FORGOT PASS');</script>");

                $this->load->helper('url');
                $this->load->helper('form');
                $dd['msg']='FORGOT PASSWORD';

                $this->load->view('v_forget_pass',$dd);
        }
        public function reset_password($token=null)
        {
		//print_r($_REQUEST);
		//echo "Token: $token";
                $this->load->helper('url');
                $this->load->helper('form');
                                $timezone = "Asia/Calcutta";
                                if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
                                $dt = date('Y-m-d H:i:s');

              $this->load->model('MProject');
              $sql1="SELECT * FROM admin_user_login WHERE token = '$token' AND status = 0 AND end_time >= now() limit 1;";
              $sds=$this->MProject->getDataBySql($sql1);
              if($sds){
                      foreach($sds as $q){
                             $uid=$q->uid;
				$type = $q->type;
				$st=$q->status;

					if($st == 1){
                        			$udata['msg']='Token expired or already used.';
                        			$this->load->view('v_forget_pass',$udata); break;
					}

				$udata['uid'] = $uid;
				$udata['type'] = $type ;
				$udata['msg']='Enter your new password';
                   		$this->load->view('sachangepassword',$udata); 
				break;
		      }
	      }
	      else{
			$udata['msg']='Token expired';
                   	$this->load->view('v_forget_pass',$udata);
	      }
        }
	public function req_forget_pass()
	{
		$email = $this->input->post("email");
		$this->load->model('MProject');
              $sql1="SELECT * FROM admin_user WHERE user='$email' AND status = 1;";
              $sds=$this->MProject->getDataBySql($sql1);
              if($sds){
                      foreach($sds as $q){
                             $uid=$q->user_id;

				$this->load->model('MSausermodel');
				$token = $this->MSausermodel->cryptGetToken(32);
				//$pwd = $this->hashMake($pass, $salt);
				$timezone = "Asia/Calcutta";
				if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
				$dt = date('Y-m-d H:i:s');
				$edt=date("Y-m-d H:i:s", strtotime("+30 minutes"));

				// --- Begin of Mail --
		         	$headers  = 'MIME-Version: 1.0' . "\r\n";
         			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         			$headers .= "From: noreply.vcims@gmail.com" . "\r\n" .'Reply-To: noreply.vcims@gmail.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
				$t= $email;
				$s='Digiadmin Password Reset Requested';
				$msg = "
					Hello ,<br><br> Received your password reset request.<br> Click here on <a href='http://13.232.11.235/digiamin-web/siteadmin/reset_password/$token'>Reset Password</a>  link to reset your new password. This link is valid for 30 minutes only else get expired.<br><br> Thanks,<br>Team SiteAdmin 
				";
				if(mail($t, $s, $msg, $headers))
		 		{}
				// --- END of Mail -----

				$this->load->model('MProject');
				$rd=$this->MProject->doSqlDML("INSERT INTO admin_user_login (uid,token,start_time, end_time) VALUES ($uid,'$token','$dt','$edt');" );

                		$dd['msg']="<font color=green>Sucessfull! Go to your inbox and do reset your password.</font>";
                		$this->load->view('v_forget_pass',$dd);
                      }

		}
		else{
                	$dd['msg']="<font color=red>Error! This email not found in database.</font>";
                	$this->load->view('v_forget_pass',$dd);
		}
	}
         //for siteadmin login procee
        public function sadmlogin()
        {    
	       $usern=$this->input->post("username");
        	$passd=$this->input->post("password");
                $this->load->model('MSausermodel');
                $ss=$this->MSausermodel->login($usern, $passd);

                if($ss) 
                {       
                  	 $uid=$_SESSION['sauserid'];
                        // $this->load->model('MSausermodel');  //SHASHI// THIS IS REPEATED LOADING THE MODEL
                         $role=$this->MSausermodel->getuserrole($uid);
        		 $permission=$this->MSausermodel->getuserpermissionmap($uid);
			 $data['rqpost']=''; $data['msg']='';
			 $_SESSION['suser']=$uid;
			 $_SESSION['isSALogin']=true;
			 $_SESSION['sauseridrole']=$role;
			 $_SESSION['permission']=$permission;
                         $this->session->set_userdata('isSALogin', TRUE);
                         $this->session->set_userdata('sauserid',$uid);
                         $this->session->set_userdata('sauseridrole',$role);
                         $this->session->set_userdata('permission',$permission);

                         $satempuri=$this->session->tempdata('satemp');
//print_r($_SESSION);die;
                         if($satempuri=='')
        		    	//$this->load->view('samylogin',$data);
                                 
				$this->load->view('v_shome', $data);
                         else
                          	redirect($satempuri);
                }
        	else
        	{
        		$data['error']='Invalid/Blocked Username/Password';
        		$this->load->view('sadm_login_form',$data);
        	}
        }
	function updatetabstatus()
	{
		//print_r($_POST);
		$id = $_POST['id'];
		$st = $_POST['status'];
		$sid=0;
		if($st == 'Allowed') $sid=1;
                if($st == 'Not Allowed') $sid=2;
		//echo "rid : $rid";
		if($id != '' && $st != ''){
			$up = $this->db->query("UPDATE tab_project_map SET status = $sid WHERE id=$id");
			echo "updated tab status";
		}
		else echo "Something is going wrong!";
	}
        public function salogout()
        {
        	 $this->session->unset_userdata('sauser');
                 $this->session->sess_destroy();
		 $_SESSION ='';
		 unset($_SESSION);
		 $this->load->model('MSausermodel');
		 $dd['msg']='';
        	 $this->load->view('sadm_login_form',$dd);
        }
        public function sachangepass()
        {
	           $uid=$_SESSION['sauserid'];
	           $udata['uid']=$uid;
	           $udata['msg']='';
	           $this->load->view('sachangepassword',$udata);
        }
        //reset password
        public function saresetpass()
        {
	           $mmsg=false;
	           //$uid=$_SESSION['sauserid'];
		   $uid = $this->input->post("uid");
		   $type = $this->input->post("type");
	           $udata['uid']=$uid;
	           $pass=$this->input->post("npass");
	           $rpass=$this->input->post("npassrepeat");
	           $dd['msg']='';
	           if($pass==$rpass)
	           {
		             $this->load->model('MSausermodel');
		             //$mmsg=$this->MSausermodel->reset_pass($uid,$pass);
		             //$dd['msg']='Password Changed Successfully';
				if($type == 2){
                             		$this->MSausermodel->reset_pass($uid,$pass,$type);
                             		$dd['msg']='Thank You! Your password has changed sucessfully<br> Login to your App using this password';
				}
				else{
                             		$this->MSausermodel->reset_pass($uid,$pass);
                             		$dd['msg']='Thank You! Your password has changed sucessfully<br> Login to your App using this password';
				}
			 $this->MProject->doSqlDML("UPDATE vcims.admin_user_login SET status=1 WHERE uid=$uid AND date(end_time)=curdate();");
	           }
	           else
	           {
		             $dd['msg']='Error! Both password are not same! Please enter both password same to reset';
	           }
	             	     //$this->load->view('sadm_login_form',$dd);
			     $this->load->view('v_message',$dd);
        }
        //to get project id based qset id
        public function getpqset()
        {
        	if(!empty($_POST['pn'])) {  $p=$_POST['pn'];
                      $this->load->model('MSausermodel');
                      $pqs=$this->MSausermodel->getPQset($p);
                      foreach($pqs as $d)
                      { $qid=$d->qset_id;
                         echo "<option value='$qid'> $qid </option>";
                      } 
                       
                }
        }
        //to get project's question list
         public function getpqs()
        {
        	if(!empty($_POST['pn'])) {  $p=$_POST['pn'];
                      $this->load->model('MProject');
                      $pqs=$this->MProject->getPQs($p);
                      foreach($pqs as $d)
                      { $qid=$d->q_id;$qn=$d->qno; $qt=$d->q_type;
                         echo "<option value='$qid'> $qn / $qid -- $qt </option>";
                      }  
                }
        }
	//to get edit qo for a project
         public function getpeditqs()
        {
                if(!empty($_POST['pn'])) {  $p=$_POST['pn'];
                      $this->load->model('MProject');
                      $pqs=$this->MProject->getPEQs($p);
                      foreach($pqs as $d)
                      { $qid=$d->q_id;$qn=$d->qno; $qt=$d->q_type;
                         echo "<option value='$qid'> $qn / $qid -- $qt </option>";
                      }
                }
        }


        //to get project's question list for adding routine only
         public function getpqsf()
        {
                if(!empty($_POST['pn'])) {  $p=$_POST['pn'];
                      $this->load->model('MProject');
                      $pqsf=$this->MProject->getPQsf($p);

                      foreach($pqsf as $d)
                      { $qid=$d->q_id;$qn=$d->qno; $qt=$d->q_type;
                         echo "<option value='$qid'> $qn / $qid -- $qt </option>";
                      }
                }
        }
        public function getqop()
        {
                if(!empty($_POST['qs']))
                {     $nctr=0;
                      $p=$_POST['qs'];
                      $this->load->model('MProject');
                      $pqs=$this->MProject->getPQop($p);
			if($pqs)
                      foreach($pqs as $d)
                      {
                           $nctr++;
                           $qid=$d->q_id;
                           $opid=$d->op_id;
                           $text=$d->opt_text_value;
                           $v=$d->value;
                         echo "<option value='$opid'> $qid / $text -- $v </option>";
                      }
                }
        }
        public function getpqop()
        {     
        	if(!empty($_POST['pqid'])) 
                {     $nctr=0;
                      echo "<table><tr bgcolor=lightgray><td width=50px>SN.</td><td>OPTION</td><td>CODE</td><td width=80px>CHECK</td><td>FLOW</td></tr>";
                      $p=$_POST['pqid'];
                      $this->load->model('MProject');
                      $pqs=$this->MProject->getPQop($p);
			if($pqs)
                      foreach($pqs as $d)
                      { 
                           $nctr++;
                           $qid=$d->q_id;
                           $opid=$d->op_id; 
                           $text=$d->opt_text_value; 
                           $v=$d->value;
                           $ssv=$d->scale_start_value;
                           $esv=$d->scale_end_value;
                          echo "<tr><td>$nctr</td><td>$text</td><td><input type=text name=v$v value=$v readonly></td><td align=center><input type=checkbox name=chk$v value=$v></td><td><select name=f$v ><option value=0>Continue </option><option value=1>Terminate</option><option value=2>Terminate Anyway</option></select></td></tr>";               
                      }echo "</table>";                         
                }else echo "--Options Not Available--";
        }
        public function gettqop()
        {     
        	if(!empty($_POST['qid'])) 
                {     $nctr=0;
                      echo "<table><tr bgcolor=lightgray><td width=50px>SN.</td><td  width=250px>OPTION</td><td>CODE</td><td width=480px>Translation</td></tr>";
                      $qid=$_POST['qid'];
                      $this->load->model('MProject');
                      $qt=$this->MProject->getQType($qid);
                      $pqs=$this->MProject->getPQop($qid);
                      if($qt=='radio' || $qt=='checkbox')
                      foreach($pqs as $d)
                      { 
                           $nctr++;
                           $qid=$d->q_id;
                           $opid=$d->op_id; 
                           $text=$d->opt_text_value; 
                           $v=$d->value;
                           $ssv=$d->scale_start_value;
                           $esv=$d->scale_end_value;
                          echo "<tr><td>$nctr</td><td>$text</td><td>$v <input type=hidden name=v$v value=$v> <input type=hidden name=op$opid value=$opid> </td><td><input type=text name=t$opid> </td></tr>";               
                      }echo "</table>";                         
                }else echo "--Options Not Available--";
        }
        //for contact us form
        public function sendmemail()
        {      
             $name=$_GET['name'];
             $email=$_GET['email'];
             $ph=$_GET['phone'];
             $msg=$_GET['msg'];
             $m='';
             if($name==''|| $email=='' || $ph=='' || $msg=='')
             {
                 echo "Error! Fill all required details & try again.";
             }
             else
             {
                 $t='contact.vcims@gmail.com';
                 $fem=$email;
                 $s="Varenia website query | ".$email;
                 
                 $info="<br><br><Query Sender:-<br>Name : ".$name."<br>Email : ".$email."<br>Phone : ".$ph."<br>Message: ".$msg."<br><br> From, <br>www.digiadmin.quantumcs.com";
                 $m='<br><u> Hi, <br><br>You have a web query as below :</u><br>'.$info;
                 $headers  = 'MIME-Version: 1.0' . "\r\n";
                 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 $headers .= "From: noreply@gmail.com" . "\r\n".'Reply-To: noreply.vcims@gmail.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

                 mail($t, $s, nl2br($m), $headers);
                 echo "Your message sent successfully";
             }
        }
         //for ajax call to get product filter 
        public function user_action($action=null)
        {
		
                //if($action!=null) {
		//switch($action) {
		$task=$action;
		if(!empty($_POST['action'])) {$task = $_POST['action'];}
        	if(!empty($_POST['action']) || $action!=null) {  
               // var_dump($task);
		switch($task ) {
			case "vrusradd":
                         ?>
					<?php echo form_open('siteadmin/vrusradd');?> 
			                <table>
					<tr><td>User Full Name </td> <td><input type="text" class="form-control" name="uname" placeholder="Enter name of user"></td></tr>
			                <tr><td>Password </td><td><input type="password" name="pwd" class="form-control" placeholder="Enter user password"></td></tr>
                                        <tr><td>Mobile</td> <td><input type="text" name="mobile" class="form-control" placeholder="Enter your mobile"> </td> </tr>
					<tr><td>Email</td> <td><input type="email" name="email" class="form-control" placeholder="Enter your email"> </td> </tr>
					<tr><td>User Type</td> <td><select class="form-control" name="ut"><option value="10">TRecorder</option><option value="0">Admin-MRecorder</option><option value="1">Respondent</option><option value="2">Moderator</option><option value="3">Translator</option><option value="4">Client</option></select> </td> </tr>
					<br> <tr><td></td><td><input type="submit" class="btn btn-primary" name='nusr' value="Register User"></td></tr>
			        <?php echo form_close(); ?>
			<?php
			break;
                        case "vrusredit":
                         ?>
                                        <?php echo form_open('siteadmin/vrusredit');?>
                                        <tr><td>User </td><td> <select name="user">
                                        <?php
                                        $sql1="SELECT * FROM vc_user;";
                                        $sds=$this->MProject->getDataBySql($sql1);
                                        if($sds)
                                        foreach($sds as $q)
                                        {
                                                $rm=$q->name; $rid=$q->uid;
                                                echo "<option value= $rid > $rm </option>";
                                        }
                                        ?>
                                        </select></td></tr>
                                        <tr><td></td><td><input type="submit" name="submit" value="Edit User"></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;

                        case "vrusrview":
                         ?>
                                        <?php echo form_open('siteadmin/vrusrview');?>
                                        <tr><td>User </td><td> <select name="usr"><option value="0">All</option></select></td></tr>
                                        <tr><td></td><td><input type="submit" name=view value="View User"></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;
                        case "vrradd":
                         ?>
                                        <?php echo form_open('siteadmin/vrradd');?>
                                       <table> <tr><td>Room Name</td> <td><input type="text" name="rname" placeholder="Enter room name"> </td> </tr>
					<tr><td>Time Zone</td> <td><input type="text" name="tz" placeholder="Enter timezone"> </td> </tr>
					<tr><td>Date </td> <td><input type="date" name="sdt" placeholder="Enter Date of Confrence"> </td> </tr>
					<tr><td>Start Time </td> <td><input type="text" name="stm" placeholder="Enter Start Time"> </td> </tr>
					<tr><td>End Time </td> <td><input type="text" name="etm" placeholder="Enter End Time"> </td> </tr>

                                        <tr><td></td><td><input type="submit" name="submit" value="Create Room"></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;
                        case "vrredit":
                         ?>
                                        <?php echo form_open('siteadmin/vrredit');?>
                                        <tr><td>Room </td><td> <select name="room">
					<?php
                                	$sql1="SELECT * FROM vc_room;";
                                	$sds=$this->MProject->getDataBySql($sql1);
                                	if($sds)
                                	foreach($sds as $q)
                                	{ 
						$rm=$q->room; $rid=$q->id;
						echo "<option value= $rid > $rm </option>";
					}
					?>
					</select></td></tr>
                                        <tr><td></td><td><input type="submit" name="submit" value="Edit Room"></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;

                        case "vrrview":
                         ?>
                                        <?php echo form_open('siteadmin/vrrview');?>
                                        <tr><td>Room </td><td> <select name="room"><option value="0">All</option></select></td></tr>
                                        <tr><td></td><td><input type="submit" name="submit" value="View Rooms"></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;
                        case "vrrusradd":

                         ?>
                                        <?php echo form_open('siteadmin/vrrusradd');?>
                                        <table><tr><td>User </td><td><select name="uid" id="uid" onchange="getvrut();getvrun();getvrmob();"><option value=0>Select User</option>
					<?php 
						$this->load->model('MProject');
                				$qs=$this->MProject->getDataBySql("select uid,name from vc_user where status=1 order by uid desc");
                				if($qs)
                				foreach($qs as $qd){
                        				$uid=$qd->uid;$un=$qd->name;
							echo "<option value=$uid>$un</option>";
                				}
					?>
					</select></td></tr>
					<tr><td>Room </td><td> <select name="room"><option value="0">Select Room</option>
					<?php
                                                $this->load->model('MProject');
                                                $qs=$this->MProject->getDataBySql("select id,room from vc_room order by id desc");
                                                if($qs)
                                                foreach($qs as $qd){
                                                        $rid=$qd->id;$rn=$qd->room;
                                                        echo "<option>$rn</option>";
                                                }
                                        ?>

					</select></td></tr>
					<tr><td>User Type </td><td> <select name="ut" id="ut"> <option value=0>Select User Type</option></select></td></tr>
					<tr><td>User Name</td> <td><select name="un" id="un"><option value=0>Select</option></select> </td> </tr>
					<tr><td>Mobile</td> <td><select name="mobile" id="mobile"><option value=0>Select</option></select> </td> </tr>
                                        <tr><td>QB ID</td> <td><input type="text" name="qbid" placeholder="Enter your QB ID"> </td> </tr>
                                        <br><tr><td>QB Password </td><td><input type="text" name="pwd" placeholder="Enter your QB password"></td></tr>
                                        <tr><td></td><td><input type="submit" name="nu_submit" value="Add in Room"></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;
                        case "vrrusrview":
                                $this->load->view('v_h');
                                echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                         ?>
                                        <?php echo form_open('siteadmin/vrrusrview');?>
					<tr><td>Room </td><td> <select name="room"><option value="0">Select Room</option>
					<?php 
                                                $this->load->model('MProject');
                                                $qs=$this->MProject->getDataBySql("select id,room from vc_room order by id desc"); 
                                                if($qs)
                                                foreach($qs as $qd){
                                                        $rid=$qd->id;$rn=$qd->room;
                                                        echo "<option>$rn</option>";
                                                }
                                        ?>  
					</select></td></tr>
                                        <br> <tr><td></td><td><input type="submit" name="nu_submit" value=View></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;
                        case "vrrusredit":

                         ?>
                                        <?php echo form_open('siteadmin/vrrusredit');?>
                                        <tr><td>Select User </td><td> <select name="uid">
                                        <?php
                                                $this->load->model('MProject');
                                                $qs=$this->MProject->getDataBySql("SELECT uid,name from vc_user WHERE uid in (SELECT distinct uid FROM vcims.vc_user_detail ) order by name;");
                                                if($qs)
                                                foreach($qs as $qd){
                                                        $uid=$qd->uid;$rn=$qd->name;
                                                        echo "<option value=$uid>$rn</option>";
                                                }
                                        ?>
                                        </select></td></tr>
                                        <br> <tr><td></td><td><input type="submit" name="nu_submit" value=View></td></tr>
                                <?php echo form_close(); ?>
                        <?php
                        break;

			case "usradd":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div style='margin-left:50px;'><center> <h3> New Digiadmin user</h3>";
				
                         ?>
					<?php echo form_open('siteadmin/saverify');?> 
			                <table><tr><td>User Id </td><td><br><input type="email" name="email" placeholder="Enter your email"></td></tr>
			                <tr><td>Password </td><td><input type="password" name="pwd" placeholder="Enter your password"></td></tr> 
                                        <tr><td>User Name</td> <td><input type="text" name="name" placeholder="Enter your full name"> </td> </tr> 
                                        <tr><td>Mobile</td> <td><input type="text" name="mobile" placeholder="Enter your mobile"> </td> </tr>
			                <tr><td>Role </td><td> <select name="role"><option value="0">--Select--</option><option value="1">Super Admin</option><option value="2">Admin</option><option value="3">Team User</option><option value="4">Client User</option> </select></td></tr>  
			               <br><br> <tr><td></td><td><input type="submit" name="nu_submit"></td></tr>
			        <?php echo form_close(); ?>
			<?php
			break;
			case "usredit":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				echo $_POST['action'];
				?>
				<?php echo form_open('siteadmin/addtab');?>
				
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "usrview":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->view('v_h');
				$this->load->model('MProject');
                                $ulist=$this->MProject->getuserlist();
				//echo "<br><br><br> <div style='margin-left:50px;'>";
				echo $ulist ;
				$this->load->view('footer');
				?>
				</div></div>
		<?php
			break;
			case "usrremove":
                                $this->load->view('v_h');
                                echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

				echo $_POST['action'];
				?>
				
				<?php echo form_open('siteadmin/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;
			
                        case "prmadd":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				echo $_POST['action'];
				?>
				
				<?php echo form_open('siteadmin/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "prmassign":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				//echo $_POST['action']; 
				$this->load->model('MSausermodel');
                         	$prms=$this->MSausermodel->getpermissions();
                         	$usrs=$this->MSausermodel->getUsers();  
				?>

				<?php echo form_open('siteadmin/prmassign');?>

			  <label><b>User ID</b></label>

			   <input class='form-control' list="uid" name="uid" placeholder="Please select user">
			  <datalist id="uid">
			  <?php  foreach($usrs as $usr){  ?>

			    <option value="<?php echo $usr->user_id; ?>"> <?php echo $usr->user; ?> </option>
			    <?php } ?>
			  </datalist>
			
			  <p>
			  <label><b>Select Permission</b></label></p>
			  <p>
			   <?php  foreach($prms as $prm){ $prid=$prm->prm_id; $prn=$prm->pname; ?>
			     	<input class="w3-check" type="checkbox" name="prms[]" value="<?=$prid;?>">
			  	<label> <?=$prn;?> </label><br>
			    
			    <?php } ?>
			    
			  
			  </p><br>
			 <button class="btn btn-primary">Submit</button> 
			 <?php echo form_close(); ?>
			</div></div>
		<?php	        
			break;	
                        case "prmrevoke":
                                $this->load->view('v_h');
                                echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

				$this->load->model('MSausermodel');
                         	$prms=$this->MSausermodel->getpermissions();
                         	$usrs=$this->MSausermodel->getUsers();  
				?>
				
				<?php echo form_open('siteadmin/prmrevoke');?>
                                <p>
			  <label><b>User ID</b></label><br>
			  <select class="w3-select w3-twothird w3-text-green" name="uid"><option value="" disabled selected>Choose User</option>
			  <?php  foreach($usrs as $usr){  ?>
			    
			    <option value="<?php echo $usr->user_id; ?>"> <?php echo "$usr->user_id -- $usr->user"; ?> </option>
			    <?php } ?>
			  </select></p><br>
			
			  <p>
			  <label><b>Select Permission</b></label></p>
			  <p>
			   <?php  foreach($prms as $prm){ $prid=$prm->prm_id; $prn=$prm->pname; ?>
			     	<input class="w3-check" type="checkbox" name="prms[]" value="<?=$prid;?>">
			  	<label> <?=$prn;?> </label><br>
			    
			    <?php } ?>
			    
			  
			  </p><br>
			 <button class="w3-btn w3-white w3-border w3-border-green w3-margin-left w3-round-xlarge">Submit</button> 
			 <?php echo form_close(); ?>
		<?php
			break;	
                        case "prmview":

				//echo $_POST['action'];
				$this->load->view('v_h');
				$this->load->model('MSausermodel');
                         	$prms=$this->MSausermodel->getpermissions();
                         	$usrs=$this->MSausermodel->getUsers();  
				?>
				<br><br><br>
				<div class='text-center'><label class='form-label'>VIEW USER'S PERMISSION</label></div>
				<?php echo form_open('siteadmin/prmview', array('target'=>'_blank', 'id'=>'myform'));?>
      			  <br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>
			  User ID
			  <input class='form-control' list="uid" name="uid" placeholder="Select User ...">
			  <datalist id="uid"><option value="" disabled selected>Choose User</option>
			  <?php  foreach($usrs as $usr){  ?>
			    
			    <option value="<?php echo $usr->user_id; ?>"> <?php echo "$usr->user_id -- $usr->user"; ?> </option>
			    <?php } ?>
			  </datalist><br>
			
			 <button class="btn btn-primary">View User Permissions</button> 
			 <?php echo form_close(); ?>
			</div></div>
                <?php
                        break;
			
			case "addtab":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				//echo $_POST['action'];
			?>
				<?php echo form_open('siteadmin/addtab');?>
                                  <div class='text-center'>Add New Tablet</div>
				  Tab Company<br> <input class='form-control' type=text name=tab_company>
				  Tab Name<br> <input class='form-control' type=text name=tab_name>
				  Tab IMEI-1<br> <input class='form-control' type=text name=tab_imei_1>
				  Tab IMEI-2<br> <input class='form-control' type=text name=tab_imei_2>
				  Tab Email<br> <input class='form-control' type=email name=tab_email>
				  Tab SIM Provider<br> <input class='form-control' type=text name=tab_sim_p>
				  Tab SIM No<br> <input class='form-control' type=text name=tab_sim>
				  Tab Mobile<br> <input class='form-control' type=text name=tab_mob maxlength=10>
				  Tab charger Name<br> <input class='form-control' type=text name=tab_charger_name>
				  <div class='text-center'> <input class='btn btn-primary' type=submit name="save" value=Save></div>
				<?php echo form_close(); ?>
				</div></div>
		<?php	
			break;
			case "issuetab":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";

				//echo $_POST['action'];
				$this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$intvwrs=$this->MTablet->getInterviewerDetails();
				$projects=$this->MTablet->getProjects();
				?>
				
				<?php echo form_open('siteadmin/issuetab');?>
					Tablet Name<br> <select class='form-control' name=tab_id><option value=0>--Select--</option><?php  foreach($tabs as $rd){ ?><option value=<?php echo $rd->tab_id; ?>><?php echo $rd->tab_name; ?></option><?php } ?> </select>
					  Interviewer <br> <select class='form-control' name=i_id><option value=0>--Select--</option><?php  foreach($intvwrs as $rd){ ?><option value=<?php echo $rd->i_id; ?>><?php echo $rd->i_name .' - '.$rd->i_mobile; ?></option><?php } ?> </select>
					  Project Name<br> <select class='form-control' name=p_id> <option value=0>--Select--</option><?php foreach($projects as $rd){ ?><option value=<?php echo $rd->project_id; ?>><?php echo $rd->name; ?></option><?php } ?> </select>
					  Survey Location/Area<br> <input class='form-control' type=text name=wlocation>
					  Tab Issue By<br> <input class='form-control' type=text name=tab_issue_by>
					  Tab Issue Date<br> <input class='form-control' type=date name=tab_issue_date>
					  Tab With Charger<br><select class='form-control' name=tab_charger><option value=no>No</option> <option value=yes>Yes</option></select>
					  <div class='text-center'><input class='btn btn-primary' type=submit name="ta_save" value=Save></div>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "receivetab":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				//echo $_POST['action'];
				$this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$intvwrs=$this->MTablet->getInterviewerDetails();
				$projects=$this->MTablet->getProjects();
				?>
				
				<?php echo form_open('siteadmin/receivetab');?>
                                <p> 	
				 		Tablet Name<br> <select class='form-control' name=tab_id><option value=0>--Select--</option><?php foreach($tabs as $rd){ ?><option value=<?php echo $rd->tab_id; ?>><?php echo $rd->tab_name; ?></option><?php } ?> </select>
						Interviewer <br> <select class='form-control' name=i_id><option value=0>--Select--</option>
						  
						  <?php  foreach($intvwrs as $rd){ ?>
						  <option value=<?php echo $rd->i_id; ?>><?php echo $rd->i_name .' - '.$rd->i_mobile; ?></option>
						<?php } ?> 
						</select>
						  Project Name<br> <select class='form-control' name=p_id> <option value=0>--Select--</option><?php foreach($projects as $rd){ ?><option value=<?php echo $rd->project_id; ?>><?php echo $rd->name; ?></option><?php } ?> </select>
						  Tab Received By<br> <input class='form-control' type=text name=tab_receive_by>
						  Tab Receive Date<br> <input class='form-control' type="date" name=tab_receive_date>
						  Tab With Charger<br><select class='form-control' name=tab_charger><option value=no>No</option> <option value=yes>Yes</option></select>
						  <div class='text-center'> <input class='btn btn-primary' type=submit name="tr_save" value=Save></div>
						  
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "addinterv":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				  //echo $_POST['action'];
				?>
				  
				<?php echo form_open('siteadmin/addtab');?>
                                		<div class='text-center'> ADD INTERVIEWER </div>
					  Interviewer Name<br> <input class='form-control' type=text name=in>
					  Mobile 1<br> <input class='form-control' type=text name=im1 maxlength=10>
					  Mobile 2<br> <input class='form-control' type=text name=im2 maxlength=10>
					  Email<br> <input class='form-control' type=text name=ie>
					  Address<br> <input class='form-control' type=text name=ia>
					  <div class='text-center'><input class='btn btn-primary' type=submit name="inr_save" value=Save></div>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "tabreport":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				//echo $_POST['action'];
				?>
				<?php echo form_open('siteadmin/tabreport');?>
                                Report Type <br><select class='form-control' name="trp" id="trp"><option value="0">--Select--</option><option value="1"> All </option><option value="2"> Not Received </option><option value="3"> Available to Allocate </option></select>
				<div class='text-center'> <input class='btn btn-primary' type="submit" name="trp_report" value=View> </div>

				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "tabprm":
                                $this->load->view('v_h');

				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";

				$this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$intvwrs=$this->MTablet->getInterviewerDetails();
				$projects=$this->MTablet->getProjects();
				?>
				
				<?php echo form_open('siteadmin/tabprm');?>
				Project <br><select class='form-control' name="pid" id="pid" required><option value="">--Select Project--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select>
                                Tablets <br><select class='form-control' name="tab[]" id="tab" multiple required><option value=""></option><?php foreach($tabs as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select>
                                Permission <br><select class='form-control' name=per required> <option value="">--Select Permission--</option><option value=1>Allow</option><option value=0>Not allow</option></select>
                                <div class='text-center'><input type=submit class='btn btn-primary' name=submit value='Update Existing Tablet Permission'> </div>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "rgtrresp":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$projects=$this->MTablet->getProjects();
				$this->load->model('MProject');
 				$getrgtr=$this->MProject->getaddrgtrresp();
				?>
				<?php echo form_open('siteadmin/rgtrresp');
					echo $getrgtr;
                    		?>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "reporttabpermission":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-11'>";

				$this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$intvwrs=$this->MTablet->getInterviewerDetails();
				$projects=$this->MTablet->getProjects();
				?>
				<?php echo form_open('siteadmin/reporttabpermission');?>
				   Project <select class='form-control' name="pid" id="pid"><option value="0">--Select Project--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select>
                                  <br><input class='btn btn-primary'  type=submit name=ta_report value='View Device Permission'> 
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                case "projectdata":
				$this->load->view('v_h');
				echo "<br><br><br><br> ";
                                $this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$projects=$this->MTablet->getProjects();
				?>


<?php  
                 $strExlExp = "<a href='projectdataReport'> <br><center> <button type='button' class='btn btn-primary'>Export in Excel </button></center></a></br>";
                echo $strExlExp;
         ?>  
				<?php echo form_open('siteadmin/projectdata', array('target'=>'_blank', 'id'=>'myform'));?>
                                	<div class="container" style="margin-left: 15%;">
                                        
					<div class='well col-lg-9 col-sm-9 col-md-9'>
					<div class="row">
						<div class='text-center bg-primary'> VIEW PROJECT DATA DETAILS </div>
					</div>
                                       
					<br>
					<div class="row">
					<!-- div class='col-lg-5 col-xl-4 col-sm-3 col-md-3' -->
				       Project Name: <select name="pn" class="form-control" id="pn"  onchange="getpqset();" required><option value="">--Select Project--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select><br>
                                       <!-- /div>
					 <div class='col-lg-4 col-xl-4 col-sm-3 col-md-3' -->
					QuestionSet ID <select name="qset" class="form-control" id="qset" required> <option value="">--Select QSet--</option> </select>
					<!-- /div -->
					</div><br>
					<div class="row">
					 <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
					 Date Filter
                                         <label class='form-control'> <input type=checkbox name="isd"  id="isd" style='font-size: 20px;'> Apply Date Filter </label>
					</div>
					 <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
                                        From Date <input type=date name="sdt" class="form-control" id="sdt">
					</div>
					<div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'> 
					To Date <input type=date name="edt" class="form-control" id="edt">
					</div>
					</div><br>

					<div class="row">
					 <div class='col-lg-6 col-xl-6 col-sm-6 col-md-6'>
				        Record From [ Offset ] <input class="form-control" type=number name="sl" id="sl" value=0 required>
					</div>
					 <div class='col-lg-6 col-xl-6 col-sm-6 col-md-6'>
						Record To [ Limit ] <input type=number class="form-control" name="el" id="el" value=100 required>
					</div>
					</div><br>

                                       <div class="text-center"><input type=submit class="btn btn-primary" name=submit value="View Records"></div>
  

				<?php echo form_close(); ?>
					</div></div></div></div>
		<?php
				
			break;


                        case "projectdataReport":
				$this->load->view('v_h');
				echo "<br><br><br><br> ";
                                $this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				$projects=$this->MTablet->getProjects();
				?>

				<?php echo form_open('siteadmin/projectdataexl', array('target'=>'_blank', 'id'=>'myform'));?>
                                	<div class="container" style="margin-left: 15%;">
                                        
					<div class='well col-lg-9 col-sm-9 col-md-9'>
					<div class="row">
						<div class='text-center bg-primary'> Download Report in Excel Sheet </div>
					</div>
					<br>
					<div class="row">
					<!-- div class='col-lg-5 col-xl-4 col-sm-3 col-md-3' -->
				       Project Name: <select name="pn" class="form-control" id="pn"  onchange="getpqset();" required><option value="">--Select Project--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select><br>
                                       <!-- /div>
					 <div class='col-lg-4 col-xl-4 col-sm-3 col-md-3' -->
					QuestionSet ID <select name="qset" class="form-control" id="qset" required> <option value="">--Select QSet--</option> </select>
					<!-- /div -->
					</div><br>
					<div class="row">
					 <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
					 Date Filter
                                         <label class='form-control'> <input type=checkbox name="isd"  id="isd" style='font-size: 20px;'> Apply Date Filter </label>
					</div>
					 <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
                                        From Date <input type=date name="sdt" class="form-control" id="sdt">
					</div>
					<div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'> 
					To Date <input type=date name="edt" class="form-control" id="edt">
					</div>
					</div><br>

					<div class="row">
					 <div class='col-lg-6 col-xl-6 col-sm-6 col-md-6'>
				        Record From [ Offset ] <input class="form-control" type=number name="sl" id="sl" value=0 required>
					</div>
					 <div class='col-lg-6 col-xl-6 col-sm-6 col-md-6'>
						Record To [ Limit ] <input type=number class="form-control" name="el" id="el" value=100 required>
					</div>
					</div><br>

                                       
<?php $strExlExp = "<a href='projectdataReport'> <br><center> <input type=submit class='btn btn-primary' name=submit value='Download Excel Sheet'></center></a></br>";
		       echo $strExlExp;
                                   ?>    

				<?php echo form_close(); ?>
					</div></div></div></div>
		<?php
                                break;


                                case "viewmediareport":
                                        $this->load->view('v_h');
                                        echo "<br><br><br><br> ";
                                        $this->load->model('MTablet');
                                        $tabs=$this->MTablet->getTabs();
                                        $projects=$this->MTablet->getProjects();
                                        ?>
        
        
                        <?php echo form_open('siteadmin/viewmediareport', array('target'=>'_blank', 'id'=>'myform'));?>
                                                <div class="container" style="margin-left: 15%;">
                                                
                                                <div class='well col-lg-9 col-sm-9 col-md-9'>
                                                <div class="row">
                                                        <div class='text-center bg-primary'> VIEW MEDIA PROJECT DATA DETAILS </div>
                                                </div>
                                               
                                                <br>
                                                <div class="row">
                                                <!-- div class='col-lg-5 col-xl-4 col-sm-3 col-md-3' -->
                                               Project Name: <select name="pn" class="form-control" id="pn"  onchange="getpqset();" required><option value="">--Select Project--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select><br>
                                               <!-- /div>
                                                 <div class='col-lg-4 col-xl-4 col-sm-3 col-md-3' -->
                                                QuestionSet ID <select name="qset" class="form-control" id="qset" required> <option value="">--Select QSet--</option> </select>
                                                <!-- /div -->
                                                </div><br>
                                                <div class="row">
                                                 <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
                                                 Date Filter
                                                 <label class='form-control'> <input type=checkbox name="isd"  id="isd" style='font-size: 20px;'> Apply Date Filter </label>
                                                </div>
                                                 <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'>
                                                From Date <input type=date name="sdt" class="form-control" id="sdt">
                                                </div>
                                                <div class='col-lg-4 col-xl-4 col-sm-4 col-md-4'> 
                                                To Date <input type=date name="edt" class="form-control" id="edt">
                                                </div>
                                                </div><br>
        
                                                <div class="row">
                                                 <div class='col-lg-6 col-xl-6 col-sm-6 col-md-6'>
                                                Record From [ Offset ] <input class="form-control" type=number name="sl" id="sl" value=0 required>
                                                </div>
                                                 <div class='col-lg-6 col-xl-6 col-sm-6 col-md-6'>
                                                        Record To [ Limit ] <input type=number class="form-control" name="el" id="el" value=100 required>
                                                </div>
                                                </div><br>
        
                                               <div class="text-center"><input type=submit class="btn btn-primary" name=submit value="View Media Report"></div>
          
        
                                        <?php echo form_close(); ?>
                                                </div></div></div></div>
                        <?php
                                        
                                break;
        



                        case "mdureport":
				$this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				?>
				
				<?php echo form_open('siteadmin/mdureport');?>
                                <p> 
                                <tr><td>Start Date </td><td><input type=date name=st id=st> </td></tr>

                                <tr><td>End Date </td><td><input type=date name=et id=et></td></tr>

                                <tr><td>Tablets </td><td><select name="tab" id="tab" ><option value="0">--All tabs--</option><?php foreach($tabs as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select></tr>

                                <tr><td></td><td><input type=submit name=b_report value=View> </td></tr>

                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdusreport":
				//echo $_POST['action'];
				?>
				
				<?php echo form_open('siteadmin/mdusreport');?>
                                <p> 
                                <tr><td>Month : </td><td><select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
                                </td><td><input type=submit name=sreport value=View> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdssreport":
				//echo $_POST['action'];
				?>
				
				<?php echo form_open('siteadmin/mdssreport');?>
                                <p> 
                                <tr><td>Month : </td><td><select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
                                  </td><td><input type=submit name=sreport value=View> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdmbreport":
				 
				?>
				
				<?php echo form_open('siteadmin/mdmbreport');?>
                                <p>
                                   <tr><td>Month : </td><td><select name=mn id=mn><option value=0>--Select-- </option><option value=1>Jan</option><option value=2>Feb</option><option value=3>Mar</option><option value=4>Apr</option><option value=5>May</option><option value=6>Jun</option><option value=7>Jul</option><option value=8>Aug</option><option value=9>Sep</option><option value=10>Oct</option><option value=11>Nov </option><option value=12>Dec</option> </select></td></tr>
                                  <tr><td>Year : </td><td><select name=yrs id=yrs><option value=2016>2016</option><option value=2017>2017</option><option value=2018>2018</option></select></td></tr>
                                  <tr><td></td><td><input type=submit name=submit value="View"></td></tr>	
				</p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdbsreport":
				 $this->load->model('MTablet');
                                 $booths=$this->MTablet->getDataBySql("select distinct resp_id from UMEED2_40 order by resp_id");
 
				?>
				
				<?php echo form_open('siteadmin/mdbsreport');?>
                                <p>	
				   Booth Id : <select name=booth id=booth><?php foreach($booths as $r){ $bth=$r->resp_id; echo "<option value=$bth>$bth</option>";}?></select> 

Month : <select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
Year : <select name=yrs id=yrs><option value=2016>2016 </option><option value=2017>2017</option><option value=2018>2018</option></select>
Group : <select name=gn id=gn><option value=0>--All--</option> <option value=1>Aesthetics </option><option value=4>Hygiene</option><option value=3>Convenience </option></select>
<br><input type=submit name=view value="View Booth Score">

                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdudclean":
				 
				?>
				
				<?php echo form_open('siteadmin/mdudclean');?>
                                <p>	
				  <tr><td>Month </td><td><select name="mn" id="mn" ><option value="0">--Select--</option><option value=4>Apr 2017</option><option value=5>May 2017</option><option value=6>Jun 2017</option><option value=7>July 2017</option><option value=8>Aug 2017</option><option value=9>Sep 2017</option><option value=10>Oct 2017</option><option value=11>Nov 2017</option><option value=12>Dec 2017</option></select></tr>
<tr><td>Booth</td><td><input type=text name=bid id=bid placeholder='Booth ID'> </td></tr>
<tr><td><input type=text name=frid id=frid placeholder='From ID'></td><td><input type=text name=toid id=toid placeholder='To ID'> </td></tr>
<tr><td>Remove Duplicate Data for All Booth </td><td><input type=checkbox name=all id=all value=1> </td></tr>
<tr><td></td><td><input type=submit name=submit value=DELETE> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewpcrosstab":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left:15px;'>";
				
                                  $this->load->model('MTablet');
				$projects=$this->MTablet->getProjects();

				?>
				<br><br><h5><font color=red>Cross Tabulation Data Analysis</font></h5>
            <center>
				<?php echo form_open('siteadmin/crosstab', array('target'=>'_blank', 'id'=>'myform'));?>
                                <div class='well col-lg-9 col-sm-9 col-md-9'>
            <tr><td>Project </td><td><select name="project" id="project" required ><option value="">--Select--</option><?php foreach($projects as $p){?><option value=
"<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
              <tr><td></td><td><input type="submit" name="submit" value="Go" class='btn btn-primary'></td></tr>
            </table>
                                </p>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;

                      case "viewpdummycrosstab":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MTablet');
                                $projects=$this->MTablet->getProjects();
                                ?>
                                <br><br><center><h5><font color=red>Dummy Cross Tabulation Data Analysis</font></h5>
                                <?php echo form_open('siteadmin/dummycrosstab', array('target'=>'_blank', 'id'=>'myform'));?>
                                <p>
            <tr><td>Project </td><td><select class='form-control' name="project" id="project" required ><option value="">--Select--</option><?php foreach($projects as $p){?><option value=
"<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
              <tr><td></td><td><input class='btn btn-primary' type="submit" name="submit" value="Go"></td></tr>
            </table>
                                </p>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;

                        case "createemptytable":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MTablet');
				$projects=$this->MTablet->getProjects();
				?>
				<center><br><br><h4><font color=red>Create Duplicate Empty Table from Existing Project</font></h4>
				<?php echo form_open('siteadmin/createemptytable');?>
                                <p>
            			<tr><td>Project </td><td><select name="pn" id="pn" required><option value="">--Select--</option><?php foreach($projects as $p){?>
<option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
              			<tr><td></td><td><input type="submit" name="submit" value="Create Dummy Table" color="green" style="background-color:lightgreen" 
onclick="return confirm('Are you sure to create a dummy project table?');"></td></tr>
            			</table>
                                </p>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;

                        case "setpquota":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MTablet');
                                $projects=$this->MTablet->getProjects();
                                ?>
                                <center><br><br><h4><font color=red>Update Project Quota</font></h4>
                                <?php echo form_open('siteadmin/setpquota');?>
                                <p>
                                <tr><td>Project </td><td><select class='form-control' name="pn" id="pn" onchange='getpqset();' required><option value="">--Select--</option><?php foreach($projects as $p){?>
<option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
	              </select></td><td> Question Set: <select class='form-control' name=qset id=qset onclick='getpqs();' required><option value=''>--Select--</option> 
</select></td></tr>
	              <tr><td>Question ID </td><td> <select class='form-control' name=qs[] id='qs' multiple required> <option value=''>--Select--</option></select> </td></tr>

                                <tr><td></td><td><input class='btn btn-primary' type="submit" name="submit" value="Set Quota" color="green" style="background-color:lightgreen"
onclick="return confirm('Are you sure to set project quota?');"></td></tr>
                                </table>
                                </p>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;

                        case "dummydataupload":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MTablet');
                                $projects=$this->MTablet->getProjects();
                                ?>
                                <center><br><br><h4><font color=red>Upload Dummy Table Data for Existing Project</font></h4>
                                <?php echo form_open('siteadmin/dummydataupload',array('target'=>'_blank'));?>
                                <p>
                                <tr><td>Project </td><td><select class='form-control' name="pn" id="pn" required><option value="">--Select--</option><?php foreach($projects as $p){?>
<option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
                                <tr><td></td><td><input class='btn btn-primary' type="submit" name="submit" value="Continue" onclick="return confirm('Are you sure to upload dummy project table data?');"></td></tr>
                                </table>
                                </p>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;

                        case "transdataupload":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MTablet');
                                $projects=$this->MTablet->getProjects();
                                ?>
                                <center><br><br><h4><font color=red>Upload Translated Question Options Data</font></h4>
                                <?php echo form_open('siteadmin/transdataupload',array('target'=>'_blank'));?>
                                <p>
                                <tr><td>Project </td><td><select class='form-control' name="pn" id="pn" required><option value="">--Select--</option><?php foreach($projects as $p){?>
<option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
                                <tr><td></td><td><input class='btn btn-primary' type="submit" name="submit" value="Continue" onclick="return confirm('Are you sure to upload translated project question data?');"></td></tr>
                                </table>
                                </p>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;
                        case "viewtransdataupload":
                               
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MTablet');
                                $projects=$this->MTablet->getProjects();
                                ?>
                                <center><br><br><h4><font color=red>View Project Translation Template To Upload for Existing Project</font></h4>
                                <?php echo form_open('siteadmin/viewtransdataupload',array('target'=>'_blank'));?>
                                <p>
                                <tr><td>Project </td><td><select class='form-control' name="pn" id="pn" required><option value="">--Select--</option><?php foreach($projects as $p){?> <option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
                                <tr><td></td><td><input class='btn btn-primary' type="submit" name="submit" value="Continue" onclick="return confirm('Are you sure to view project translated template');"></td></tr>
                                </table>
                                </p>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;
                        case "viewpshowcards":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->helper('url');
                                $this->load->model('MProject');
                                $str=$this->MProject->getviewproject();
                                ?>
                                <?php echo form_open('siteadmin/viewpshowcards',array('target'=>'_blank'));
                                      echo $str;
                                ?>
                                <?php echo form_close(); ?>
                                </div></div>
                <?php
			break;
			//for view project
                        case "viewproject":
				$this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->helper('url');
				$this->load->model('MProject');
				$str=$this->MProject->getviewproject();
				?>
				<?php echo form_open('siteadmin/viewproject',array('target'=>'_blank')); 
                                      echo $str;
                                ?>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewqb":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewqb();
				?>

				<?php echo form_open('siteadmin/viewqp'); 
                                      echo $str;

                                ?>
  				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewqnre":
				$this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewqnre();
				?>
				
				<?php echo form_open('siteadmin/viewqnre',array('target'=>'_blank', 'id'=>'myform')); 
                                      echo $str;

                                ?>			
				<?php echo form_close(); ?> 
				<label class='btn btn-light' style='margin-left: 15%;'> <a href='http://13.232.11.235/digiamin-web/vcimsweb/adminpanel/1236.php' target="_blank">See Translated Questionnare </a> </label>
				</div></div>
		<?php
			break;
                        case "viewquestion":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewquestion();
				?>
				
				<?php echo form_open('siteadmin/viewquestion'); 
                                      echo $str;

                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewquestionop":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewquestionop();
				?>
				
				<?php echo form_open('siteadmin/viewquestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewsequence":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewsequence();
				?>
				
				<?php echo form_open('siteadmin/viewsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "updatesequence":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getupdatesequence();
				?>
				
				<?php echo form_open('siteadmin/updatesequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewroutine":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewroutine();
				?>
				
				<?php echo form_open('siteadmin/viewroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewpcentre":
                                $this->load->view('v_h');
				echo "<br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewpcentre();
				?>
				
				<?php echo form_open('siteadmin/viewpcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewprule":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MProject');
                                $str=$this->MProject->getviewprule();
                                ?>

                                <?php echo form_open('siteadmin/viewprule');
                                      echo $str;
                                ?>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;

                        case "viewpproduct":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewpproduct();
				?>
				
				<?php echo form_open('siteadmin/viewpproduct'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "viewpsec":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getviewpsec();
				?>
				
				<?php echo form_open('siteadmin/viewpsec'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editproject":
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";

				$this->load->model('MProject');
				$str=$this->MProject->geteditproject();
				?>
				
				<?php echo form_open('siteadmin/editproject'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editquestion":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 10%;'><div class='well col-lg-11'>";
				$this->load->model('MProject');
				$str=$this->MProject->geteditquestion();
				?>
				
				<?php echo form_open('siteadmin/editquestion'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editquestionop":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-11'>";
				$this->load->model('MProject');
				$str=$this->MProject->geteditquestionop();
				?>

				<?php echo form_open('siteadmin/editquestionop', array('target'=>'_blank')); 
                                      echo $str;
                                ?>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editsequence":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->geteditsequence();
				?>
				
				<?php echo form_open('siteadmin/editsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editroutine":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->geteditroutine();
				?>
				
				<?php echo form_open('siteadmin/editroutine'); 
                                      echo $str;
                                ?>
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editpcentre":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->geteditpcentre();
				?>
				
				<?php echo form_open('siteadmin/editpcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "editpfp":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MProject');
                                $str=$this->MProject->geteditpfp();
                                ?>
                                <?php echo form_open('siteadmin/editpfp');
                                      echo $str;
                                ?>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;
                        case "editrule":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-11'>";
				$this->load->model('MProject');
				$str=$this->MProject->geteditrule();
                                echo $str;
				?>
				
				<?php echo form_open('siteadmin/viewrule');?>
                                <p>	
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
 
                        case "createqbcat":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getcreateqbcat();
				?>
				
				<?php //echo form_open('siteadmin/createqbcat'); 
                                      echo $str;
                                ?>
				 </div></div>
		<?php
			break;
                        case "createproject":
                               // echo "createporject";die;
                               
                                $this->load->view('v_h');
                                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";

				$this->load->model('MProject');
				$str=$this->MProject->getcreateproject();
				?>
				
				<?php echo form_open('siteadmin/createproject'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "createqset":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getcreateqset();
				?>
				
				<?php echo form_open('siteadmin/createqset'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "createquestion":
                                $this->load->view('v_h');
				echo "<br><br><br> <div class='content' style='margin-left: 5%; margin-right:5%;'><div class='well'>";

				$this->load->model('MProject');
				$str=$this->MProject->getcreatequestion();
				?>
				
				<?php echo form_open('siteadmin/createquestion'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "createsequence":
                                $this->load->view('v_h');
				echo "<br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getcreatesequence();
				?>
				
				<?php echo form_open('siteadmin/createsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "createroutine":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getcreateroutine();
				?>
				
				<?php echo form_open('siteadmin/createroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addqbquest":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddqbquest();
				?>
				
				<?php echo form_open('siteadmin/addqbquest'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addqop":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddqop();
				?>
				
				<?php echo form_open('siteadmin/addqop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addcentre":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddcentre();
				?>
				
				<?php echo form_open('siteadmin/addcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addpcentre":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddpcentre();
				 echo form_open('siteadmin/addpcentre'); 
                                      echo $str;
                              
				 echo form_close(); 

				?>
				</div></div>
		<?php
			break;
                        case "addrule":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-10'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddrule();
				?>
				
				<?php echo form_open('siteadmin/addrule'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addmedia":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getAddMedia();
				?>
				
				<?php echo form_open_multipart('siteadmin/addmedia'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addpproduct":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddpproduct();
				?>
				
				<?php echo form_open('siteadmin/addpproduct'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addpstore":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddpstore();
				?>
				
				<?php echo form_open('siteadmin/addpstore'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addpsec":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddpsec();
				?>
				
				<?php echo form_open('siteadmin/addpsec'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
			case "addarea":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MProject');
                                $str=$this->MProject->getaddarea();
                                ?>

                                <?php echo form_open('siteadmin/addarea');
                                      echo $str;
                                ?>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;
			case "addsubarea":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                                $this->load->model('MProject');
                                $str=$this->MProject->getaddsubarea();
                                ?>

                                <?php echo form_open('siteadmin/addsubarea');
                                      echo $str;
                                ?>
                                <?php echo form_close(); ?>
				</div></div>
                <?php
                        break;

                        case "addpage":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddpage();
				?>
				
				<?php echo form_open('siteadmin/addpage'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div>
		<?php
			break;
                        case "addsequence":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddsequence();
				?>
				
				<?php echo form_open('siteadmin/addsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addtransq":
				/* $this->load->model('MProject');
				$str=$this->MProject->getaddtransq();
								
				echo form_open('siteadmin/addtransq')); 
                                      echo $str;
                                			
				echo form_close();
 				*/
				header("Location: http://13.232.11.235/digiamin-web/vcimsweb/adminpanel/question_trans.php?st=101");
                              ?>
		<?php
			break;
                        case "addtransqop":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getaddtransqop();
				?>				
				<?php echo form_open('siteadmin/addtransqop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "addpcrosstab":
                                $this->load->view('v_h');
                                echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

				$this->load->model('MProject');
				$str=$this->MProject->getaddpcrosstab();
				?>				
				<?php echo form_open('siteadmin/addpcrosstab'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;

                        case "copyqbquest":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getcopyqbquest();
				?>				
				<?php echo form_open('siteadmin/copyqbquest'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break; 
                        case "copyquestionop":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getcopypquest();
				?>
				
				<?php echo form_open('siteadmin/copyquestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                    
                        case "deletesequence":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getdeletesequence();
				?>
				
				<?php echo form_open('siteadmin/deletesequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                         case "deleteroutine":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getdeleteroutine();
				?>
				
				<?php echo form_open('siteadmin/deleteroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "deletequestion":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
				$this->load->model('MProject');
				$str=$this->MProject->getdeletequestion();
				?>
				
				<?php echo form_open('siteadmin/deletequestion'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
                        case "deletequestionop":
                                $this->load->view('v_h');
				echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-11'>";
				$this->load->model('MProject');
				$str=$this->MProject->getdeletequestionop();
				?>
				
				<?php echo form_open('siteadmin/deletequestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
				</div></div>
		<?php
			break;
		}

		}
	
        }




	public function getvrutype($uid){
		$ut=0;
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("select user_type from vc_user where uid=$uid");
		if($qs)
		foreach($qs as $qd){
			$ut=$qd->user_type;
		}
		$str="Not Selected";
                if($ut==10) $str="CT Recorder";
                if($ut==0) $str="M Recorder-Admin";
		if($ut==1) $str="Respondent";
		if($ut==2) $str="Moderator";
		if($ut==3) $str="Translator";
		if($ut==4) $str="Client";
		echo "<option value=$ut>$str</option>";
	}
	public function getmaxpsid()
	{
		$pid = $_POST['pid'];
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("select max(sid) msid from question_sequence where qset_id = $pid");
                if($qs)
                foreach($qs as $qd){
                        $un=$qd->msid;
                        echo $un;
                }
	}
        public function getvruname($uid){
                $un='';
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("select name from vc_user where uid=$uid");
                if($qs)
                foreach($qs as $qd){
                        $un=$qd->name;
                	echo "<option>$un</option>";
                }
                //echo "<option>$un</option>";
        }
        public function getvrumobile($uid){
                $um=0;
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("select mobile from vc_user where uid=$uid");
                if($qs)
                foreach($qs as $qd){
                        $um=$qd->mobile;
                }
                echo "<option>$um</option>";
        }

	public function vrusradd(){
		 //print_r($_POST);
		$un=$this->input->post('uname');
		$pwd=$this->input->post('pwd');
		$mob=$this->input->post('mobile');
		$email=$this->input->post('email');
		$ut=$this->input->post('ut');
		$table='vc_user';
		$tdata=array('name'=>$un,'password'=>$pwd,'mobile'=>$mob,'email'=>$email,'user_type'=>$ut);
		$this->load->model('MProject');
		$id=$this->MProject->insertIntoTable($table,$tdata);
		$sdata="KENANTE user added sucessfully with uid: $id . <br><a onClick = userAction('vrusradd','');>Add more User</a>";
		$arrdata['rqpost']='';
		$arrdata['msg']=$sdata;
		$this->load->view('samylogin',$arrdata);
	}

        public function vrusrview(){
		 //print_r($_POST);
		$this->load->model('MProject');
		$qs=$this->MProject->getDataBySql("SELECT uid,name,mobile,password,status FROM vcims.vc_user order by name asc");
		$str=" KENANTE User Details</h5> <br><br><table border=1> <tr bgcolor=lightgray><td>User_ID</td><td>Name</td><td>Mobile</td><td>Password</td><td>Status</td></tr>";
		              foreach($qs as $p)
		              {
		                     $uid=$p->uid; $un=$p->name;$mob=$p->mobile;$up=$p->password;$us=$p->status;
		                     $str.="<tr><td>$uid</td><td>$un</td><td> $mob </td><td> $up </td><td> $us </td></tr>";
		              }
		              $str.="</table>";
		$arrdata['rqpost']='';
                $arrdata['msg']=$str;
                $this->load->view('samylogin',$arrdata);    
        }
        public function vrradd(){
		
		$rn=strtolower($this->input->post('rname'));
                $tz=$this->input->post('tz');
                $sdt=$this->input->post('sdt');
                $stm=$this->input->post('stm');
                $etm=$this->input->post('etm');

		$str="KENANTE ROOM:$rn is added sucessfully. <br><a onClick = userAction('vrradd','');>Add more Room</a>";
		$this->load->model('MProject');
		$isn=$this->MProject->getDataBySql("select * from vc_room where room = '$rn'");
		if($isn){
			$str="Room with this name is already exist in database. Please try diffrent room name. <br><a onClick = userAction('vrradd','');>Add more Room</a>";
		}
		else{
			$table='vc_room';
			$tdata=array('room'=>$rn,'timezone'=>$tz,'sch_start_dt'=>$sdt,'sch_start_time'=>$stm,'sch_end_time'=>$etm);
			$this->MProject->insertIntoTable($table,$tdata);
		}
                $arrdata['rqpost']='';
                $arrdata['msg']=$str;
                $this->load->view('samylogin',$arrdata);
        }
        public function vrredit(){
		$str='';
		$rid=$this->input->post('room');
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("SELECT * FROM vcims.vc_room where id=$rid");
		if($qs)
		foreach($qs as $p){
			$id=$p->id; $rn=$p->room; $tz=$p->timezone; $rdt=$p->sch_start_dt; $stm=$p->sch_start_time; $etm=$p->sch_end_time;
		?>
                                        <?php echo form_open('siteadmin/dovrredit');?>
					<center><h3>EDIT KENANTE ROOM</h3>
                                       <table> <tr><td><input type=hidden name=id value= <?=$id;?> >Room Name</td> 
					<td><input type=text name=rname value='<?= $rn;?>'> </td> </tr>
                                        <tr><td>Time Zone</td> <td><input type=text name=tz value='<?=$tz;?>'> </td> </tr>
                                        <tr><td>Date </td> <td><input type='date' name='sdt' value='<?=date($rdt);?>'> </td> </tr>
                                        <tr><td>Start Time </td> <td><input type=text name=stm value='<?= $stm;?>'> </td> </tr>
                                        <tr><td>End Time </td> <td><input type=text name=etm value = '<?= $etm;?>'> </td> </tr>

                                        <tr><td></td><td><input type=submit  value=SAVE></td></tr>
                                <?php echo form_close(); ?>
		<?php }
		$arrdata['rqpost']='';
                echo $arrdata['msg']=$str;
                //$this->load->view('samylogin',$arrdata);
        }

	public function dovrredit()
	{
		//print_r($_POST);
		$rid=$this->input->post('id');
                $rn=$this->input->post('rname');
                $tz=$this->input->post('tz');
                $sdt=$this->input->post('sdt');
                $stm=$this->input->post('stm');
                $etm=$this->input->post('etm');

		$this->MProject->doSqlDML("UPDATE `vc_room` SET room='$rn',timezone='$tz',sch_start_dt='$sdt',sch_start_time='$stm',sch_end_time='$etm' WHERE id=$rid ;");
		$sdata='Room edited sucessfully';
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$sdata;
                //$this->load->view('samylogin',$arrdata);

	}
        public function vrusredit(){
                $str='';
                $rid=$this->input->post('user');
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("SELECT * FROM vcims.vc_user where uid=$rid ");
                if($qs)
                foreach($qs as $p){
                     $uid=$p->uid; $rn=$p->name; $mob=$p->mobile; $email=$p->email; $st=$p->status; $login=$p->login;$imei=$p->imei;$ut=$p->user_type;$pa=$p->password;
                ?>
                                        <?php echo form_open('siteadmin/dovrusredit');?>
                                        <center><h3>Edit KENANTE User</h3>
                                       <table> <tr><td><input type=hidden name=uid value= <?=$uid;?> >User Name</td>
                                        <td><input type=text name=name value='<?= $rn;?>'> </td> </tr>
                                        <tr><td>Mobile</td> <td><input type=text name='mob' value='<?=$mob;?>'> </td> </tr>
                                        <tr><td>Email</td> <td><input type='email' name='email' value='<?=$email;?>'> </td> </tr>
                                        <tr><td>User Type</td> <td><input type=text name='ut' value='<?= $ut;?>'> </td> </tr>
                                        <tr><td>Status </td> <td><input type=text name='st' value = '<?= $st;?>'> </td> </tr>
                                        <tr><td>Login</td> <td><input type=text name='login' value='<?= $login;?>'> </td> </tr>
                                        <tr><td>User Password</td> <td><input type=text name='up' value='<?= $pa;?>'> </td> </tr>
                                        <tr><td>User IMEI</td> <td><input type=text name='imei' value='<?= $imei;?>'> </td> </tr>

                                        <tr><td></td><td><input type=submit  value=SAVE></td></tr>
                                <?php echo form_close(); ?>
                <?php }
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$str;
                //$this->load->view('samylogin',$arrdata);
        }
        public function dovrusredit()
        {
                //print_r($_POST);
                $uid=$this->input->post('uid');
                $rn=$this->input->post('name');
                $mob=$this->input->post('mob');
                $email=$this->input->post('email');
                $ut=$this->input->post('ut');
                $login=$this->input->post('login');
                $st=$this->input->post('st');
                $up=$this->input->post('up');
                $imei=$this->input->post('imei');

                $this->MProject->doSqlDML("UPDATE `vc_user` SET name='$rn',user_type='$ut',mobile='$mob',email='$email',password='$up',status='$st',imei='$imei',login='$login' WHERE uid=$uid;");
                $sdata="User: $rn , edited and saved sucessfully";
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$sdata;
                //$this->load->view('samylogin',$arrdata);

        }
        public function vrrusredit(){
                $str='';
                $uid=$this->input->post('uid');
               $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("SELECT * FROM vcims.vc_user_detail where uid= '$uid' limit 1;");
                if($qs){
                foreach($qs as $p){
                        $uid=$p->uid; $rn=$p->name; $ut=$p->user_type; $qbid=$p->qb_id;
                                        echo form_open('siteadmin/dovrrusredit');
                                      ?> 
					<center><h3>Edit KENANTE User QB Detail</h3>
                                       <table> <tr><td><input type=hidden name=uid value= <?=$uid;?> >User Name</td>
                                        <td><input type=text name=name value='<?= $rn;?>'> </td> </tr>
                                        <tr><td>User Type</td><td><input type=text name=ut value='<?=$ut;?>'> </td> </tr>
					<tr><td>QB ID</td><td><input type=text name=qbid value='<?=$qbid;?>'> </td> </tr>
                                        <tr><td></td><td><input type=submit  value=SAVE></td></tr>
					
                                <?php echo form_close(); ?>
                <?php }}
		else echo 'No record found to edit';

	}
        public function dovrrusredit()
        {
                //print_r($_POST);
                $uid=$this->input->post('uid');
                $rn=$this->input->post('name');
                $qbid=$this->input->post('qbid');
                $ut=$this->input->post('ut');

                $this->MProject->doSqlDML("UPDATE `vc_user_detail` SET name='$rn',user_type='$ut',qb_id='$qbid' WHERE uid=$uid;");
                $sdata="User: $rn , edited and saved sucessfully";
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$sdata;
                //$this->load->view('samylogin',$arrdata);
        }

        public function vrrview(){
		// print_r($_POST);
                $this->load->model('MProject');
                $qs=$this->MProject->getDataBySql("SELECT * FROM vcims.vc_room order by room asc");
                $str=" KENANTE Room Details</h5> <table border=1> <tr bgcolor=lightgray><td>ID</td><td>Name</td><td>Timezone</td><td>Date</td><td>Start Time</td><td>End Time</td></tr>";
			      if($qs)
                              foreach($qs as $p)
                              {
                                     $id=$p->id; $rn=$p->room; $tz=$p->timezone; $rdt=$p->sch_start_dt; $stm=$p->sch_start_time; $etm=$p->sch_end_time;
                                     $str.="<tr><td> $id </td><td> $rn </td><td> $tz </td><td> $rdt </td><td> $stm </td><td> $etm </td></tr>";
                              }
                              $str.="</table>";
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$str;
                //$this->load->view('samylogin',$arrdata);
        }
        public function vrrusradd(){
		 //print_r($_POST);
		$un='';
                $uid=$this->input->post('uid');
                $pwd=$this->input->post('pwd');
                $ut=$this->input->post('ut');
		$un=$this->input->post('un');
		$umob=$this->input->post('mobile');
		$qbid=$this->input->post('qbid');
		$tag=$this->input->post('room');
		$table='vc_user_detail';
		$tdata=array('uid'=>$uid,'name'=>$un,'mobile'=>$umob,'qb_id'=>$qbid,'qb_password'=>$pwd,'user_type'=>$ut,'tags'=>$tag);
		$this->load->model('MProject');
		try{ 
                	$id=$this->MProject->insertIntoTable($table,$tdata);
			$sdata="KENANTE user into a room:$tag , is added sucessfully with id: $id . <br><a onClick = userAction('vrrusradd','');>Add more User</a>";
		}catch(Exception $ex){
			$sdata="Error!$ex . Duplicate entry attempt: ";
		}
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$sdata;
                //$this->load->view('samylogin',$arrdata);
        }
        public function vrrusrview(){
		
                $this->load->model('MProject');
		$rid=$this->input->post('room');
                $qs=$this->MProject->getDataBySql("SELECT * FROM vcims.vc_user_detail WHERE tags='$rid'");
                $str=" KENANTE Room-User Details</h5> <br><br><table border=1> <tr bgcolor=lightgray><td>User_ID</td><td>Name</td><td>Mobile</td><td>Email</td><td>User Type</td><td>QB ID</td><td>QB Password</td><td>Room</td></tr>";
			      if($qs)
                              foreach($qs as $p)
                              {
                                     $uid=$p->uid; $ut=$p->user_type; $qbid=$p->qb_id; $qbpass=$p->qb_password; $un=$p->name;$mob=$p->mobile;$email=$p->email;$tag=$p->tags;
                                     $str.="<tr><td>$uid</td><td>$un</td><td> $mob </td><td> $email </td><td> $ut </td><td> $qbid </td><td>$qbpass</td><td>$tag</td></tr>";
                              }
                              $str.="</table>";
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$str;
                //$this->load->view('samylogin',$arrdata);
        }

        public function saverify()
        {  
	              $email= $this->input->post('email'); 
	              $pwd= $this->input->post('pwd');
	              $role= $this->input->post('role');
                      $name= $this->input->post('name');
	              $mobile= $this->input->post('mobile');

	               if($email!='' && $pwd!='' && $role!='0')
	               {

           		 $uid=$_SESSION['sauserid'];
                         $this->load->model('MSausermodel');
                         $nu=$this->MSausermodel->create_sauser($email,$pwd,$name,$mobile,$role);
                         if($nu)
                         {
                            $data['role']=$this->MSausermodel->getuserrole($uid);
        		    $data['permission']=$this->MSausermodel->getuserpermissionmap($uid);
                            $data['msg']="Successfully add new user as $email";
                         }
			 $data['rqpost']='';
		      }
		      else
		      {
		      	 $data['msg']=''; $data['rqpost']='';
		      }
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
			echo $data['msg'];
                         //$this->load->view('samylogin',$data);
        }
        public function createemptytable()
        {
                $pid=$this->input->post('pn');
		 $this->load->model('MProject');
		$ptable = $this->MProject->getProjectTable($pid);
		$nptable=$ptable."_dummy";
                $this->MProject->doSqlDML("CREATE TABLE IF NOT EXISTS $nptable LIKE $ptable ; ");
                $sdata="New Dummy table as $nptable is sucessfully";
                $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                echo $arrdata['msg']=$sdata;
                //$this->load->view('samylogin',$arrdata);

        }
        public function prmassign()
        {  
	              $uid= $this->input->post('uid'); 
	              $prms= $this->input->post('prms');
	              
	               //print_r($_POST);
                       //$tempu= base_url(uri_string());  
                       //$this->session->set_tempdata('ptemp',$tempu);

	               if($uid!='' && !empty($prms))
	               {
	               		foreach($prms as $prm)
	               		{
           		              $udata=array("user_id"=>$uid,"prm_id"=>$prm,"status"=>1);  
           		 		// $uid=$_SESSION['sauserid'];
                         		$this->load->model('MProject');
                         		if(!$this->MProject->isuserpermissionmap($uid,$prm))
                         		{
						//print_r($udata);
                         		 	$nu=$this->MProject->adduserpermissionmap($udata);
			 			$data['rqpost']='';
			 			$data['msg']="Successfully Permission Assign to userid: $uid";
			 		}
			 		else
			 		{	$data['rqpost']='';
			 			$data['msg']="Permission aready assign to userid: $uid";
			 		}
			 	}
		      }
		      else
		      {
		      	 $data['msg']='Something is going wrong...'; $data['rqpost']='';
		      }
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
			echo $data['msg'];
                         //$this->load->view('samylogin',$data);
        }
        public function prmview()
        {
		$str='';
		$this->load->view('v_h');
             $uid= $this->input->post('uid');
             $this->load->model('MProject');
             $prmd=$this->MProject->getuserpermissionmap($uid);
     		//print_r($prmd);
		echo "<br><br><br><br>";
		echo "<div class='text-center'><label class='form-label'>USER [$uid] PERMISSION DETAILS</label></div>";
		echo "<div class='contener'> <UL>";
	   if($prmd){

		foreach($prmd as $prm){
			$pnm=$this->MProject->getpermissionname($prm);
			$str.="<li> $pnm </li>";
		}
	   }
	   else{
		echo "<li> Permissions not available for this user! </li> ";
	   }
		$str.= '</UL> </div>';
             echo $ardata['msg']= $str;
             $ardata['rqpost']='';
             //$this->load->view('samylogin',$ardata);
        }

        public function addtab()
        {      

                      $tcomp= $this->input->post('tab_company'); 
	              $tname= $this->input->post('tab_name');
	              $tim1= $this->input->post('tab_imei_1'); 
	              $tim2= $this->input->post('tab_imei_2');
	              $temail= $this->input->post('tab_email'); 
	              $tsp= $this->input->post('tab_sim_p');
	              $tsn= $this->input->post('tab_sim'); 
	              $tmobile= $this->input->post('tab_mob');
	              $tch= $this->input->post('tab_charger_name'); 
	              
	              $this->load->helper('url'); 
	              $d='';
	        //$this->load->helper('form');  
                         $this->load->model('MTablet');
                         if(!$this->MTablet->isTab($temail))
                         	$d=$this->MTablet->addtab( array('tab_name'=>$tname,'tab_company'=>$tcomp,'tab_imei_1'=>$tim1,'tab_imei_2'=>$tim2,'tab_email'=>$temail,'sim_sp'=>$tsp,'tab_sim_no'=>$tsn,'tab_mobile'=>$tmobile,'tab_charger'=>$tch,'tab_charger_status'=>'1','tab_status'=>'1') );

			$data['rqpost']='';
                     if($d)
                         $data['msg']='Successfully Added Tablet';
                     else
                     {
                         $data['msg']='Error while added tablet'; $data['rqpost']='';
                     }
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                         echo $data['msg'];

                         //$this->load->view('samylogin',$data);
        }
        
        public function issuetab()
        {      

                      $tid= $this->input->post('tab_id'); 
	              $iid= $this->input->post('i_id');
	              $pid= $this->input->post('p_id'); 
	              $twl= $this->input->post('wlocation'); 
	              $tib= $this->input->post('tab_issue_by');
	              $tidt= $this->input->post('tab_issue_date'); 
	              $tch= $this->input->post('tab_charger'); 
	          if($tid!='' && $iid!='' && $pid!='' && $twl!='' && $tib!='' && $tidt!=''&& $tch!='')
                  {   
                      $iarr=array('tab_id' => $tid,'issue_by' => $tib,'work_location' => $twl,'p_id' => $pid,'i_id' => $iid,'issue_with_charger' => $tch, 'issue_date' => $tidt, 'ta_status' => '0');
                      $uarr=array('issue_by' => $tib,'work_location' => $twl,'p_id' => $pid,'i_id' => $iid,'issue_with_charger' => $tch, 'issue_date' => $tidt, 'ta_status' => '0');

                       $data['rqpost']='';
                       $this->load->model('MTablet');
                         
                            if($this->MTablet->isTabIssuedOnce($tid))
                            {  
                                if($this->MTablet->isTabReceived($tid))
                                {
                         	  $d=$this->MTablet->updateIssueTab($tid,$uarr);
                                  $data['msg']="Successful allocation for Tab Id: $tid ";
                                }
                                else
                                {
                                    $data['msg']='Warning! This Tab Is Already Issued. Update Tab received process first';
                                }

                            }
                            else
                            {
                                $d=$this->MTablet->issueTab($iarr);
                                $data['msg']="Successful first allocation for Tab Id: $tid ";
                            }
                      
                    }
                    else
                    {
                       $data['msg']="Fill all details";
                    }
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
			echo $data['msg'];
                     //$this->load->view('samylogin',$data);
	}
	public function receivetab()
        {      

                      $tid= $this->input->post('tab_id'); 
	              //$iid= $this->input->post('i_id');
	             // $pid= $this->input->post('p_id'); 
	              $trb= $this->input->post('tab_receive_by');
	              $trdt= $this->input->post('tab_receive_date'); 
	              $tch= $this->input->post('tab_charger'); 
	          if($tid!='' && $trb!='' && $trdt!=''&& $tch!='')
                  {    
                      $uarr=array('received_by' => $trb,'receive_with_charger' => $tch, 'receive_date' => $trdt, 'ta_status' => '1');
	              $data['rqpost']='';
                       $this->load->model('MTablet');
                        
                            if($this->MTablet->isTabIssued($tid))
                            {  
                                if(!$this->MTablet->isTabReceived($tid))
                                {
                         	  $d=$this->MTablet->updateIssueTab($tid,$uarr);
                                  $data['msg']="Successfully Received Tab Id: $tid ";
                                }
                                else
                                {
                                    $data['msg']="Warning! This Tab Is Already Received. Hence Cannot be received";
                                }
                            }
                            else
                            {
                                    $data['msg']="Warning! This Tab Is Not Issued To Anyone. Hence Cannot be received";

                            }
                      
                    }
                    else
                    {
                       $data['msg']="Fill all details";
                    }
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
			echo $data['msg'];
                      //$this->load->view('samylogin',$data);   


	} 
	public function tabreport()
        {      
                      $trp= $this->input->post('trp'); 
                       $sdata='';
                       
	               $this->load->model('MTablet');
	            
                      if($trp==1)
                      {  
                           $data=$this->MTablet->getTabIssueDetails();
                           $sdata='<center><h5>Tablet & Mobile Allocation Report</h5><table border=1>';
                           $a='<tr><td>Tab_Id</td><td> Project</td><td>Allocated To</td><td>Issue Data</td><td>Charger Allocated</td><td>Location</td><td>Receive Date</td><td>Received with Charger</td><td>Received By</td><td>Status</td></tr>';
                           $sdata.=$a;
                           foreach($data as $r)
                           {
                              $tab=$r->tab_id; $i_id=$r->i_id; $pid=$r->p_id; $wl=$r->work_location; $iby=$r->issue_by;
	                      $icby=$r->issue_with_charger; $idt=$r->issue_date; $rdt=$r->receive_date; $rby=$r->received_by;
	                      $rcby=$r->receive_with_charger; $s=$r->ta_status; 
	                   
	                      $str="Issued"; if($s==1)$str="Received";
	                      $icbyn="No";if($icby==1)$icbyn="Yes";
	                      $rcbyn="No";if($icby==1)$rcbyn="Yes";
	                      
	                      $this->load->helper('url');
	                      $this->load->model('MTablet');
	                      $pn=$this->MTablet->get_project_name($pid);
	                      $ipn=$this->MTablet->get_tablet_receiver($i_id);

                              $s="<tr><td>$tab</td><td> $pn</td><td>$ipn</td><td>$idt</td><td>$icbyn</td><td>$wl</td><td>$rdt</td><td>$rcbyn</td><td>$rby</td><td>$str </td></tr>";
                               $sdata.=$s;
                           }
                           $sdata.='</table>';
                      }
	              if($trp==2)
                      {  
                           $data=$this->MTablet->getTabNotReceived();
                           
                           $sdata='<center><h5>Tablet Issued But Not Yet Received Report</h5><table border=1>';
                           $a='<tr><td>Tab_Id</td><td> Project</td><td>Allocated To</td><td>Issue Data</td><td>Charger Allocated</td><td>Location</td><td>Receive Date</td><td>Received with Charger</td><td>Received By</td><td>Status</td></tr>';
                           $sdata.=$a;
                           foreach($data as $r)
                           {
                              $tab=$r->tab_id; $i_id=$r->i_id; $pid=$r->p_id; $wl=$r->work_location; $iby=$r->issue_by;
	                      $icby=$r->issue_with_charger; $idt=$r->issue_date; $rdt=$r->receive_date; $rby=$r->received_by;
	                      $rcby=$r->receive_with_charger; $s=$r->ta_status; 
	                   
	                      $str="Issued"; if($s==1)$str="Received";
	                      $icbyn="No";if($icby==1)$icbyn="Yes";
	                      $rcbyn="No";if($icby==1)$rcbyn="Yes";
	                      
	                      $this->load->helper('url');
	                      $this->load->model('MTablet');
	                      $pn=$this->MTablet->get_project_name($pid);
	                      $ipn=$this->MTablet->get_tablet_receiver($i_id);

                              $s="<tr><td>$tab</td><td> $pn</td><td>$ipn</td><td>$idt</td><td>$icbyn</td><td>$wl</td><td>$rdt</td><td>$rcbyn</td><td>$rby</td><td>$str </td></tr>";
                               $sdata.=$s;
                           }
                           $sdata.='</table>';

                      }
                      if($trp==3)
                      {  
                           $data=$this->MTablet->getTabToIssue(); 
                           $sdata='<center><h5>Tablet Availabilty Report</h5><table border=1>';
                           $a='<tr><td>S.N.</td><td>Tab_Id</td><td> Tab Name</td><td>Tab Brand</td><td>Tablet Status</td></tr>';
                           $sdata.=$a;
                           $i=0;
                           foreach($data as $r)
                           {
                               $tab=$r->tab_id;$tn=$r->tab_name;$tcmp=$r->tab_company;$ts=$r->tab_status;
	                   	$i++;
	                   	$str="Not Usable"; if($ts==1) $str="Usable"; if($ts==2) $str="Damaged";
	                   
                              $s="<tr><td>$i</td><td>$tab</td><td> $tn</td><td>$tcmp</td><td>$str</td></tr>";
                               $sdata.=$s;
                           }
                          $sdata.='</table>';

                      }
                      $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                      echo $arrdata['msg']=$sdata;
                      //$this->load->view('samylogin',$arrdata);

	}

        public function tabprm()
        {
			$dt = date('Y-m-d H:i:s');
                       $pid= $this->input->post('pid');
                       $tabs= $this->input->post('tab');
                       $per= $this->input->post('per');
                       $updata=array("status"=>$per,"updated_at"=>$dt);
                       //$indata=array("project_id"=>$pid,"tab_id"=>$tab,"status"=>1);         
	               $this->load->model('MTablet');
			//print_r($tabs);
		    foreach($tabs as $tab){
                       $rrp=$this->MTablet->isProjectTabPermission($pid,$tab);
			//print_r($rrp); 
                       if(!empty($rrp) && $rrp == true )
                       {
                            $rrp=$this->MTablet->updateRgtrResp($updata,$pid, $tab);
                            //$data['msg']="Successfully permission changed to tablet id:$tab";
                       }
                       else
                       {
			    $indata=array("project_id"=>$pid,"tab_id"=>$tab,"status"=>1,"created_at"=>$dt);
                            $rrp=$this->MTablet->rgtrResp($indata,$pid);
                            //$data['msg']="Successfully added permission to tablet id:$tab";
                       }
		    }
                       echo "<br><br><br><br> <div style='margin-left:50px;'>";
                       $data['rqpost']='';
                       		//$this->load->view('samylogin',$data); 
                       //echo $data['msg'];
			echo "Successfully, Permission applied to selected devices.";
        }
        public function rgtrresp()
        {
			
			$dt = date('Y-m-d H:i:s');
                       $pid= $this->input->post('pn');
                       $qset=$this->input->post('qset'); 
                       $mob= $this->input->post('mob');
			$cnt = $this->input->post('cnt');
                       //$rarr=array("project_id"=>$qset,"mobile"=>$mob,"status"=>1);
                       $data['rqpost']='';
                       $data['msg']="Failed! Registered for project id : $pid not done";
	               $this->load->model('MTablet');

		     for($i=0; $i < $cnt; ){
			$mob = $mob + $i;
			$i=$i + 1;
			$rarr=array("project_id"=>$qset,"mobile"=>$mob,"status"=>1,"created_at"=>$dt);
                       $rrp=$this->MTablet->isProjectMobPermission($pid,$mob);
                       if(!$rrp)
                       {
                          $rsp=$this->MTablet->rgtrResp($rarr);
                          if($rsp)
                          {
                             $data['msg']="Successfully! Registered for project id : $pid";
                          }
                          else
                          {
                             $data['msg']="Failure! Registered for project id : $pid not done";
                          }
                       }
		      } //end of for loop
                       echo "<br><br><br> <div style='margin-left:20px;'> ";
			echo $data['msg'];

                       //$this->load->view('samylogin',$data); 
                      
        }
        public function reporttabpermission()
        { 
		       $this->load->view('v_h');
                       $pid= $this->input->post('pid');
                       $this->load->model('MProject');
		       $pn = $this->MProject->get_project_name($pid); 
                       $sdata='';
	               $this->load->model('MTablet');
                       $data=$this->MTablet->getReportTabPermission($pid);
                       $sdata="<br><br><br> <div class='contener' style='margin-left: 12%;'><div class='well col-lg-11'> <b>PROJECT [ $pn ] - Tablet & Mobile Permission Details</b><table class='table table-stripped'>";
                           $a='<tr><td>S.N.</td><td> Project</td><td>Tab_Id</td><td>Key</td><td>Created At</td><td>Updated At</td><td>Status</td></tr>';
                           $sdata.=$a;
                           $i=0;
                           foreach($data as $r)
                           {
                               $id=$r->id; $tab=$r->tab_id; $pid=$r->project_id; $m=$r->mobile; $s=$r->status; $cr_at=$r->created_at; $up_at=$r->updated_at; 
				$i++;
                               $str="Not Allowed"; if($s==1)$str="Allowed";
                              $s="<tr><td>$i</td><td> $pn [$pid]</td><td>$tab</td><td>$m</td> <td>$cr_at</td><td>$up_at</td> <td id='id_$id' ondblclick='tab_prm_update($id)' > $str <i style='font-size:12px; color:blue;' class='fa'>&#xf044;</i>  </td></tr>";
                               $sdata.=$s;
                           }
                          $sdata.='</table></div></div>';

                      $arrdata['rqpost']='';

                      echo $arrdata['msg']=$sdata;
                      //$this->load->view('samylogin',$arrdata); 
        }
       
        public function projectdata()
        {

                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $isd= $this->input->post('isd');
                       //$isd=0;
                       $sdt=$this->input->post('sdt');
                       $sl = 0;
   			$el = 0;
			$edt=$this->input->post('edt');
                       $sm=0;$em=0;
                       date_default_timezone_set("Asia/Kolkata");
                       $d=date("d-m-Y H:i:s");
                       if($isd)
                       {
                            $sm=(int)date("m",strtotime($sdt)); 
                            $yrs=(int)date("Y",strtotime($sdt));
                       }
                       if(isset($_POST['edt']))
                       {
                             $em=(int)date("m",strtotime($edt)); 
                       }
    			if(isset($_POST['sl']) && isset($_POST['el']))
    			{
         			$sl=$this->input->post('sl'); 
         			$el=$this->input->post('el');
    			}                       
	               $this->load->model('MProject');
                       $_SESSION['reportGen'] = 'False';

                       $data=$this->MProject->getProjectData($pid,$qset,$isd,$sdt,$edt, $sl,$el);   
                      
                        
                //          header('Content-Type:application/xls');
                //        header('Content-Disposition:attachment;filename=report.xls');  
                        
        }




public function projectdataexl()
{

               $pid= $this->input->post('pn'); 
               $qset= $this->input->post('qset');
               $isd= $this->input->post('isd');
               //$isd=0;
               $sdt=$this->input->post('sdt');
               $sl = 0;
                   $el = 0;
                $edt=$this->input->post('edt');
               $sm=0;$em=0;
               date_default_timezone_set("Asia/Kolkata");
               $d=date("d-m-Y H:i:s");
               if($isd)
               {
                    $sm=(int)date("m",strtotime($sdt)); 
                    $yrs=(int)date("Y",strtotime($sdt));
               }
               if(isset($_POST['edt']))
               {
                     $em=(int)date("m",strtotime($edt)); 
               }
                    if(isset($_POST['sl']) && isset($_POST['el']))
                    {
                         $sl=$this->input->post('sl'); 
                         $el=$this->input->post('el');
                    }                       
               $this->load->model('MProject');
               $_SESSION['reportGen'] = 'True';
               $data=$this->MProject->getProjectData($pid,$qset,$isd,$sdt,$edt, $sl,$el);   
                
                 header('Content-Type:application/xls');
               header('Content-Disposition:attachment;filename=report.xls');  
                
}


public function viewmediareport()
{
        
               $pid= $this->input->post('pn'); 
               $qset= $this->input->post('qset');
              
                        
               $this->load->model('MProject');
               echo "<br><center><font color=red>Survey Data of Project ID: $pid </font></center><br><br><br>";
              
               $this->MProject->getMediaReport($pid,$qset); 
               
             
}

public function customdata()
	{
				$this->load->view('v_h');
				echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                                $this->load->model('MTablet');
				$tabs=$this->MTablet->getTabs();
				 
				$projects=$this->MTablet->getProjects();
				?>
				
				<?php echo form_open('siteadmin/customdatarequest', array('target'=>'_blank', 'id'=>'myform'));?>
                                <p>	
				       Project Name:   <select name="pn" id="pn"  onchange="getpqset();"><option value="0">--Select--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select><br>
                                       QuestionSet ID:  <select name="qset" id="qset"><option value="select">--Select--</option> </select> <br>
                                       Is Date Filter <input type=checkbox name="isd" id="isd"> <br>
                                       Exported Date Range <input type=date name="sdt" id="sdt"> To <input type=date name="edt" id="edt"><br>
				       Limit Record Start From <input type=number name="sl" id="sl" value=0 required> Show No of Records <input type=number name="el" id="el" value=100 required><br>
                                       <input type=submit name=submit value="View"> <br>
                                </p>
				<?php echo form_close();
	}
	public function customdatarequest()
	{
			$cols_arr=array();
			
                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $isd= $this->input->post('isd');
                       //$isd=0;
                       $sdt=$this->input->post('sdt');
                       $sl = 0;
   			$el = 0;
			$edt=$this->input->post('edt');
                       $sm=0;$em=0;

                       date_default_timezone_set("Asia/Kolkata");
                       $d=date("d-m-Y H:i:s");
                        
                       if($isd)
                       {
                            $sm=(int)date("m",strtotime($sdt)); 
                            $yrs=(int)date("Y",strtotime($sdt));
                       }
                       if(isset($_POST['edt']))
                       {
                             $em=(int)date("m",strtotime($edt)); 
                       }
    			if(isset($_POST['sl']) && isset($_POST['el']))
    			{
         			$sl=$this->input->post('sl'); 
         			$el=$this->input->post('el');
    			}                       
	               $this->load->model('MProject');
			if($qset  == 275){ $cols_arr = array('id','resp_id','q_id','r_name','mobile','timestamp','centre','c_area','c_sub_area','i_name','i_mobile',
'i_date','e_date','address',
'o_sec','n_sec','gender','week_day','age','st','age_yrs','store','product','ref_no','latt','lang','17264_275', '17267_275','17268_275', '17289_275', 
'17290_275', '17293_275', '17309_275', '17310_275', '17314_275','17349_275','17357_275','17358_275', '17361_275','17366_275','17369_275','17370_275','17373_275',
'17374_275', '17272_275','17275_275','17276_275','17278_275','17279_275','17394_275','17314_275_1_o','17314_275_2_o','17314_275_3_o'); }

			if($qset == 249) { $cols_arr = 
array( 'id','resp_id','q_id','r_name','mobile','timestamp','centre','c_area','c_sub_area','i_name','i_mobile','i_date','e_date','address','o_sec','n_sec','gender','week_day','age','st','age_yrs','store','product','ref_no','latt','lang',
'15277_249', '15072_249', '15073_249','15091_249', '15077_249', '15093_249', '15084_249', '15096_249', '15097_249', '15101_249', '17899_249', '17905_249','17906_249', '17908_249', '17909_249', '17910_249', '17911_249', '17912_249','17913_249','15152_249', '15460_249'); }

                       $data=$this->MProject->getCustomData($pid,$qset,$isd,$sdt,$edt, $sl,$el,$cols_arr);
		echo "($pid,$qset,$isd,$sdt,$edt, $sl,$el)";
	}
        public function mdusreport()
        { 
                       $m= $this->input->post('mn'); 
                       $this->load->model('MTablet');
                       $sdata=$this->MTablet->mdusreport($m);
                       $arrdata['rqpost']='';
                      $arrdata['msg']=$sdata;
                      $this->load->view('samylogin',$arrdata); 
        }
        public function mdssreport()
        { 
                       $m= $this->input->post('mn'); 
                       $this->load->model('MTablet');
                       $sdata=$this->MTablet->mdssreport($m);
                       $arrdata['rqpost']='';
                      $arrdata['msg']=$sdata;
                      $this->load->view('samylogin',$arrdata); 
        }
        public function mdureport()
        { 
                       $st= $this->input->post('st');
                       $et= $this->input->post('et');
                       $tab= $this->input->post('tab'); 

                       $this->load->model('MTablet');
                       $sdata=$this->MTablet->mdureport($st,$et,$tab);
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata); 
        }
        
        public function mdmbreport()
        { 
                       $mn= $this->input->post('mn');
                       $yrs= $this->input->post('yrs');
                        
                       $this->load->model('MTablet');
                       $sdata=$this->MTablet->mdmbreport($mn,$yrs);
                       //$arrdata['rqpost']='';
                       //$arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata); 
        }
        public function mdbsreport()
        { 
                       $bid= $this->input->post('booth');
                       $mn= $this->input->post('mn');
                       $yrs= $this->input->post('yrs');
                       $gn= $this->input->post('gn');
                       $this->load->model('MTablet');
                       $sdata=$this->MTablet->mdbsreport($mn,$yrs,$gn,$bid);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata); 
        }
        public function mdudclean()
        { 
                       $mn= $this->input->post('mn');
                       $bid= $this->input->post('bid');
                       $frid= $this->input->post('frid');
                       $toid= $this->input->post('toid');
 
                       $this->load->model('MTablet');
                       $sdata=$this->MTablet->mdudclean($mn,$bid,$frid,$toid);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata); 
        }
        public function setpquota()
        {
                       $pid = $this->input->post('pn');
                       $qset = $this->input->post('qset');
                       $qids = $this->input->post('qs');
			 $this->load->model('MProject');
			$msg = "Some Errors";
			if( !empty($qids)){
			    foreach($qids as $qid){
                                $sds=$this->MProject->getDataBySql("select qid from project_quota where qid in ( $qid ) AND qset = $qset;");
                                if(!$sds)
                                {
					$sql = "INSERT INTO project_quota (qset,qid) VALUES ( $qset, $qid);";
					$rd=$this->MProject->doSqlDML($sql);
				}
			   }
				$msg='Sucessfully Added';
			}
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$msg;
                       //$this->load->view('samylogin',$arrdata);
        }

        public function crosstab()
        {
                $pid = $this->input->post('project');
		$pn='';
		if($pid!=''){
			$_SESSION['ctpid'] = $pid;
			$this->load->model('MProject');
			$pn = $this->MProject->get_project_name($pid);
			//$_SESSION['ctpn'] = $pn;
			//print_r($_SESSION);
		}
                redirect("http://13.232.11.235/digiamin-web/vcimsweb/crosstabh.php?ctp=$pid&pn=$pn");
        }
        public function viewtransdataupload()
        {
                $pid = $this->input->post('pn');
                $pn='';
                if($pid!=''){
                        $_SESSION['qset'] = $pid;
                        $this->load->model('MProject');
                        $pn = $this->MProject->get_project_name($pid);
                        //$_SESSION['ctpn'] = $pn;
                        //print_r($_SESSION);
                }
                redirect("http://13.232.11.235/digiamin-web/dataupload/viewtransqop.php?ctp=$pid&pn=$pn");
        }

        public function transdataupload()
        {
                $pid = $this->input->post('pn');
                $pn='';
                if($pid!=''){
                        $_SESSION['ctpid'] = $pid;
                        $this->load->model('MProject');
                        $pn = $this->MProject->get_project_name($pid);
                        //$_SESSION['ctpn'] = $pn;
                        //print_r($_SESSION);
                }
                redirect("http://13.232.11.235/digiamin-web/dataupload/transqop.php?ctp=$pid&pn=$pn");
        }

        public function dummydataupload()
        {
                $pid = $this->input->post('pn');
                $pn='';
                if($pid!=''){
                        $_SESSION['ctpid'] = $pid;
                        $this->load->model('MProject');
                        $pn = $this->MProject->get_project_name($pid);
                        //$_SESSION['ctpn'] = $pn;
                        //print_r($_SESSION);
                }
                redirect("http://13.232.11.235/digiamin-web/dataupload/dummydataupload.php?ctp=$pid&pn=$pn");
        }

        public function dummycrosstab()
        {
                $pid = $this->input->post('project');
                $pn='';
                if($pid!=''){
                        $_SESSION['ctpid'] = $pid;
                        $this->load->model('MProject');
                        $pn = $this->MProject->get_project_name($pid);
                }
                redirect("http://13.232.11.235/digiamin-web/vcimsweb/dummycrosstabh.php?ctp=$pid&pn=$pn");
        }
	public function viewpshowcards()
	{
		//print_r($_POST);
                       $this->load->view('v_h');
                       $pid= $this->input->post('pid');
                       $this->load->model('MProject');
                       $sdata=$this->MProject->getProjectShowcards($pid);
                       $arrdata['rqpost']='';
                        $sdata.='</div></div>';
                       echo $arrdata['msg']=$sdata;

	}
	public function viewproject()
        {
		       $this->load->view('v_h');
                       $pid= $this->input->post('pid');
                       $this->load->model('MProject');
                       $sdata=$this->MProject->getProjectDetail($pid);
                       //echo "<br><br><br> <div class='contener' style='margin-left: 15%;'><div class='well col-lg-11'>";
			
                       $arrdata['rqpost']='';
			$sdata.='</div></div>';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);        
	              
	}
        public function viewqb()
        {      
                      echo $pid= $this->input->post('pid'); 
	               
	              
	}
        public function viewqnre()
        {      
			$this->load->view('v_h');
			echo "<br><br><br> <div class='content' style='margin-left: 5%;'><div class='well col-lg-11'>";

                       $qset= $this->input->post('qset');
                       $tl= $this->input->post('tl'); 
	               $this->load->model('MProject');
                      echo $html=$this->MProject->getQnreDetail($qset,$tl);
                       
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$html;
                       //$this->load->view('samylogin',$arrdata);    
                   /*
                       $pdfFilePath="qnr_$qset.pdf";
                       $this->load->library('m_pdf');    
	               /*$pdf = $this->m_pdf->load();
                       // $pdf->setFooter("{PAGENO}");
                       $pdf->AddPage();
                       $pdf->autoScriptToLang = true;
                       $pdf->autoLangToFont = true;
                       $pdf->shrink_tables_to_fit = 1;
                       $pdf->WriteHTML(utf8_encode($html),0);
                       $pdf->WriteHTML($est_case1);
                       $pdf->Output($pdfFilePath, "I");
                       //
                       $this->m_pdf->pdf->WriteHTML(utf8_encode($html),0);
                      $this->m_pdf->pdf->Output($pdfFilePath, "I");
                  */
	}
        public function viewquestion()
        {      
                                $this->load->view('v_h');
                       $qset= $this->input->post('qset'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getQuestionDetail($qset);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);        
	              
	}
        public function viewquestionop()
        {      
                                $this->load->view('v_h');
			//echo "<div class='contener'> <div class='well text-center'><label class='form-label'> VIEW QUESTION OPTION</label></div><br> <div class='col-lg-11'>";
			echo "<br><br><br> <div class='contener' style='margin-left: 5%;'><div class='well col-lg-11'>";
                       $qset= $this->input->post('qset'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getQuestionOpDetail($qset);
                       //echo "<br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       echo "</div></div>";
	                             
	}
        public function viewsequence()
        {      
                                $this->load->view('v_h');

                       $qset= $this->input->post('qset');
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getSequenceDetail($qset);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function viewroutine()
        {      
                                $this->load->view('v_h');
                       $qset= $this->input->post('qset'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getRoutineDetail($qset);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata); 
	}
        public function viewpcentre()
        {      
                                $this->load->view('v_h');
                       $qset= $this->input->post('qset'); 
                       $rt= $this->input->post('rt');

	               $this->load->model('MProject');
                       $sdata=$this->MProject->getPCentreDetail($qset,$rt);
                       
		       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata); 
	}
        public function viewprule()
        {
                                $this->load->view('v_h');

                       $qset= $this->input->post('qset');
                       $rt= $this->input->post('rt');

                       $this->load->model('MProject');
                       $sdata=$this->MProject->getPRuleDetail($qset,$rt);
			echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
        }

        public function editproject()
        {      
                       $this->load->view('v_h');
                       $pid= $this->input->post('pn'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getEditProjectDetail($pid);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function editquestion()
        {      
			$this->load->view('v_h');
			echo "<br><br><br><br> <div class='contener' style='margin-left: 10%;'><div class='well col-lg-11'>";
                      $pid= $this->input->post('qset'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getEditQuestionDetail($pid);
                       //echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
			echo "</div></div>";
	}
        public function editquestionop()
        {
                       $this->load->view('v_h');
                       $qs= $this->input->post('qs'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getEditQuestionOPDetail($qs);
 
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function editsequence()
        {      
                                $this->load->view('v_h');
                       $pid= $this->input->post('pn'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getEditSequenceDetail($pid);
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function editroutine()
        {      
                                $this->load->view('v_h');

                       $pid= $this->input->post('pn'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getEditRoutineDetail($pid);
 			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/editroutine'> Edit Routine </a></font> ";
                       $arrdata['rqpost']='';
                       echo "<br><br><br><br> <div style='margin-left:50px;'>";
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function editpcentre()
        {      
			$this->load->view('v_h');
                       $pid= $this->input->post('pn'); 
	               $this->load->model('MProject');
                       $sdata=$this->MProject->getEditCentreDetail($pid);
                       $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function editpfp()
        {
                                $this->load->view('v_h');

                       $pid= $this->input->post('pn');
                       $this->load->model('MProject');
                       $sdata=$this->MProject->getEditFPDetail($pid);
                       $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
        }
        public function updatesequence()
        {       
                                $this->load->view('v_h');
			$this->load->view('v_h');
                       $pid= $this->input->post('qset'); 
                       $ssid= $this->input->post('ssid');
                       $esid= $this->input->post('esid');
                       $num= $this->input->post('num');
			$submitb = $this->input->post('submit');
	               $this->load->model('MProject');
			if($submitb == 'Update-Increase')
                       		$sdata=$this->MProject->doUpdateSequence($pid,$ssid,$esid,$num);
                        if($submitb == 'Update-Decrease')
                       		$sdata=$this->MProject->doUpdateSequencedesc($pid,$ssid,$esid,$num);
                       $arrdata['rqpost']='';
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}

        public function updateproject($action)
        {              //$pid= $this->input->get('pid');  
                        //$this->load->view('v_h');
			//echo "<div><div class='text-center'>";
                       //echo $action;
                       $action="action$action";
                       echo("<script>console.log('PHP: updateproject action ');</script>");

                        $dt = date('Y-m-d H:i:s');
                        $login=$this->session->userdata('sauserid');

                       if($action=='actionproject')
                       {
                         $pid= $this->input->get('pid');
                         $pn= $this->input->get('pn');
                         $sdt= $this->input->get('sdt');
                         $edt= $this->input->get('edt'); 
                         $cn= $this->input->get('cn');
                         $b= $this->input->get('b');
                         $v= $this->input->get('v');
                         $rt= $this->input->get('rt');
                         $rp= $this->input->get('rp');
                         $bk= $this->input->get('bk');
                         $rt= $this->input->get('rt');
                         $ss= $this->input->get('ss');
                         $st= $this->input->get('st');
                         $arr=array('name'=>$pn,'company_name'=>$cn,'brand'=>$b,'background'=>$bk,'sample_size'=>$ss,'research_type'=>$rt,'tot_visit'=>$v,'survey_start_date'=>$sdt,'survey_end_date'=>$edt,'reward_point'=>$rp,'status'=>$st, 'updated_at'=>$dt,'uid'=>$login);
                         echo("<script>console.log('PHP: updateproject actionproject');</script>");

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doProjectUpdate($pid,$arr);
                         if($rd)
                            echo "$pn Updated Successfully";
                         else 
                            echo "$pn Not Updated Successfully";
                       }
                       if($action=='actionquestion')
                       {
                         $qid= $this->input->get('qid');
                         $qno= $this->input->get('qno');
                         $title= $this->input->get('title');
                         $qt= $this->input->get('qt');
                         $arr=array('q_title'=>$title,'qno'=>$qno,'q_type'=>$qt, 'updated_at'=>$dt,'uid'=>$login);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doQuestionUpdate($qid,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                         
                       }
                       if($action=='actionquestionop')
                       {
                         $id= $this->input->get('id');
	                 $qid= $this->input->get('qid');
                         $txt= $this->input->get('txt');
                         $val= $this->input->get('val');
                         $term= $this->input->get('term');
			 $f = $this->input->get('flag');
                         $arr=array('opt_text_value'=>$txt,'value'=>$val, 'term'=>$term, 'flag' => $f,'updated_at'=>$dt,'uid'=>$login);
                         $rd='';
	                 $this->load->model('MProject');
                         $rd=$this->MProject->doQuestionOPUpdate($id,$arr);
                         if($rd){
				
			      $qset=0;$ptable='';$opterm='';
	                      $sql="select qset_id from question_detail where q_id = $qid limit 1";
	                      $qs=$this->MProject->getDataBySql($sql);
	                      if($qs)
	                      foreach($qs as $q)
	                      {
	                            $qset=$q->qset_id;
				    $ptable=$this->MProject->getProjectTable($qset);
				    $opterm=$qid.'_'.$qset.'_'.$val.'_o';

				    $qr = "SELECT COUNT(*) AS opcnt FROM information_schema.COLUMNS WHERE COLUMN_NAME = '$opterm' and TABLE_NAME = '$ptable' and TABLE_SCHEMA = 'vcims';";
				    $qsd = $this->MProject->getDataBySql($qr);
				 if($qsd){
				  foreach($qsd as $qd){
					$rcnt = $qd->opcnt;
				    
				    if( ($f == 1 || $f == 3 || $f == 4) && $rcnt == 0 ){
					 $atq1="ALTER TABLE $ptable ADD column $opterm varchar(480) null;";
	                            	 $ctb1=$this->MProject->doSqlDML($atq1);
				    }
				    if($f == 2  && $rcnt == 0){
					 $atq2="ALTER TABLE $ptable ADD column $opterm varchar(10) null;";
	                            	 $ctb2=$this->MProject->doSqlDML($atq2);
				    }
				 }} //end of cont
			      }
                            echo "updated";
                         } else 
                            echo "Error! Not updated.";
                         
                       }
                       if($action=='actionsequence')
                       {
                         $qset= $this->input->get('qset');
                         $id= $this->input->get('id');
	                 $qid= $this->input->get('qid');
                         $sid= $this->input->get('sid');
                         $flag= $this->input->get('flag');
                         $where=array('qid'=>$qid,'qset_id'=>$qset,'updated_at'=>$dt,'uid'=>$login); 
                         $arr=array('sid'=>$sid,'qid'=>$qid,'chkflag'=>$flag);
                         $rd='';
	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSequenceUpdate($id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully"; 
                       }
                       if($action=='actionsequenced')
                       {
                         $qset= $this->input->get('qset');
                         $id= $this->input->get('id');
                         $qid= $this->input->get('qid');
                         $rd='';
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_sequence where id=$id");
                         if($rd)
                            echo "Qid $qid deleted Successfully";
                          else
                            echo "Qid $qid deleted Successfully";
                       }
                       if($action=='actionupdatesequence')
                       {
                         $qset= $this->input->get('qset');
	                 $esid= $this->input->get('esid');
                         $ssid= $this->input->get('ssid');
                         //$where=array('qid'=>$qid,'qset_id'=>$qset); 
                         //$arr=array('sid'=>$sid,'chkflag'=>$flag);
                         $rd='';
	                 $this->load->model('MProject');
                         //$rd=$this->MProject->doSequenceUpdate($id,$arr);
                         if($rd)
                            echo "Qid $ssid Updated Successfully";
                          else 
                            echo "Qid $ssid Not Updated Successfully";
                         
                       }
                       
                       if($action=='actionroutine')
                       {
                         $id= $this->input->get('id');
	                 $qid= $this->input->get('qid');
                         $pqid= $this->input->get('pqid');
                         $opval= $this->input->get('opval');
                         $flow= $this->input->get('flow');
                         $arr=array('qid'=>$qid,'pqid'=>$pqid,'flow'=>$flow,'opval'=>$opval,'updated_at'=>$dt,'uid'=>$login);
                         $rd='';
	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRoutineUpdate($id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully"; 
                       }
                       if($action=='actionroutined')
                       {
                         $id= $this->input->get('id');
                         $qid= $this->input->get('qid');
                         $rd='';
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_routine_check where id=$id");
                         if($rd)
                            echo "Qid $qid deleted Successfully";
                          else
                            echo "Qid $qid not deleted Successfully";
                       }
                       if($action=='actionrule1')
                       { $id= $this->input->get('id');
                         $qid= $this->input->get('qid');
                         $sn= $this->input->get('sn');
                         $gc= $this->input->get('gc');
                         $arr=array('grp_code'=>$gc,'qid'=>$qid,'sno'=>$sn);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_1',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                       if($action=='actionrule2')
                       {
                         $qid= $this->input->get('qid');
                         $tab= $this->input->get('tab');
                         $op= $this->input->get('op');
                         $id= $this->input->get('id');
                         $q= $this->input->get('q');

                         $arr=array('tab_id'=>$tab,'qid'=>$qid,'op_val'=>$op,'quota'=>$q);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_2',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                       if($action=='actionrule3')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');
                         $gc= $this->input->get('gc');
                         $qt= $this->input->get('qt');
			 $rw= $this->input->get('rw');
			 $flag= $this->input->get('flag');
                         $arr=array('grp_id'=>$gc,'qid'=>$qid,'row_no'=>$rw, 'flag'=>$flag);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_3',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                        if($action=='actionrule1d')
                       { $id= $this->input->get('id');
                         $qid= $this->input->get('qid');
	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_1 where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionrule2d')
                       {
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_2 where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionrule3d')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_3 where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionruleand')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $qt= $this->input->get('qt');
			 $flg=$this->input->get('flag');
                         $arr=array('cqid'=>$cqid,'qid'=>$qid,'flag'=>$flg);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_routine_and',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                       if($action=='actionruleandd')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_routine_and where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionruleshow')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $qt= $this->input->get('qt');
                         $arr=array('cqid'=>$cqid,'qid'=>$qid);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_show_op',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                       if($action=='actionruleshowd')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_show_op where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionrulehide')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $qt= $this->input->get('qt');
                         $arr=array('cqid'=>$cqid,'qid'=>$qid);

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_hide_op',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                       if($action=='actionrulehided')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_hide_op where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }

                       if($action=='actionrulefindreplace')
                       {
                         $rqid= $this->input->get('rqid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $opv= $this->input->get('opv');
                         $fstr= $this->input->get('fstr');
                         $rstr= $this->input->get('rstr');
                         $arr=array('cqid'=>$cqid,'rqid'=>$rqid,'op_val'=>$opv,'fstr'=>$fstr,'rstr'=>$rstr);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_word_findreplace',$id,$arr);
                         if($rd)
                            echo "Qid $cqid Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionrulefindreplaced')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_word_findreplace where id=$id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }

                       if($action=='actionruleautoselect')
                       {
                         $pqid= $this->input->get('pqid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $opv= $this->input->get('opv');
                         $fstr= $this->input->get('fstr');
                         $rstr= $this->input->get('rstr');
                         $arr=array('cqid'=>$cqid,'pqid'=>$pqid,'opv'=>$opv,'sval'=>$fstr,'eval'=>$rstr);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_autoselect',$id,$arr);
                         if($rd)
                            echo "Qid $cqid Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionruleautoselectd')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_autoselect where id=$id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }
                       if($action=='actionrulenumlimit')
                       {
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $fstr= $this->input->get('fstr');
                         $rstr= $this->input->get('rstr');
                         $arr=array('cqid'=>$cqid,'sval'=>$fstr,'eval'=>$rstr);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_numlimit',$id,$arr);
                         if($rd)
                            echo "Qid $cqid Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionrulenumlimitd')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_numlimit where id=$id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }

                       if($action=='actionrulerecording')
                       {
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('qid');
                         $arr=array('qid'=>$cqid);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_recording',$id,$arr);
                         if($rd)
                            echo "Qid $cqid Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionrulerecordingd')
                       {
                         $cqid= $this->input->get('qid');
                         $id= $this->input->get('id');

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_recording where id=$id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }
                       if($action=='actionruleautofixcode')
                       {
                         $pqid= $this->input->get('pqid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $opv= $this->input->get('copv');
                         $val= $this->input->get('val');
                         $arr=array('cqid'=>$cqid,'pqid'=>$pqid,'cqid_opv'=>$opv,'val'=>$val);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_autofixcode',$id,$arr);
                         if($rd)
                            echo "Qid $cqid $pqid - $opv - $val Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionruleautofixcoded')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_autofixcode where id=$id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }
                       if($action=='actionrulegridqopshowhide')
                       {
                         $pqid= $this->input->get('pqid');
                         $id= $this->input->get('id');
                         $cqid= $this->input->get('cqid');
                         $pqop= $this->input->get('pqop');
                         $grp= $this->input->get('group');
                         $val= $this->input->get('flag');
                         $arr=array('cqid'=>$cqid,'pqid'=>$pqid,'pqop'=>$pqop,'group'=>$grp, 'flag'=>$val);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_gridqop_showhide',$id,$arr);
                         if($rd)
                            echo "Qid $cqid $pqid - $pqop - $val Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionrulegridqopshowhided')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_gridqop_showhide where id=$id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }


                       if($action=='actionruleqoprange')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');
                         $cqopfr = $this->input->get('cqopfr');
                         $cqopto = $this->input->get('cqopto');
                         $pqid = $this->input->get('pqid');
                         $pqop= $this->input->get('pqop');
                         $arr=array('cqid'=>$cqid,'cqid_fr_op'=>$cqopfr,'cqid_to_op'=>$cqopto,'pqid'=>$pqid,'pqid_op'=>$pqop);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doRuleUpdate('question_rule_oprange',$id,$arr);
                         if($rd)
                            echo "Qid $cqid Updated Successfully";
                          else
                            echo "Qid $cqid Not Updated Successfully";
                       }
                       if($action=='actionruleqopranged')
                       {
                         $cqid= $this->input->get('cqid');
                         $id= $this->input->get('id');
                         $cqopfr = $this->input->get('cqopfr');
                         $cqopto = $this->input->get('cqopto');
                         $pqid = $this->input->get('pqid');
                         $pqop= $this->input->get('pqop');
                         $arr=array('cqid'=>$cqid,'cqid_fr_op'=>$cqopfr,'cqid_to_op'=>$cqopto,'pqid'=>$pqid,'pqid_op'=>$pqop);

                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM question_rule_oprange where id = $id");
                         if($rd)
                            echo "Qid $cqid Deleted Successfully";
                          else
                            echo "Qid $cqid Not Deleted Successfully";
                       }

                       if($action=='actioncentre')
                       {

                         $id= $this->input->get('id');
                         $pid= $this->input->get('project_id');
			 $code= $this->input->get('centre_id');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("UPDATE centre_project_details SET centre_id=$code where id=$id;");
                         if($rd)
                            echo "Centre $code updated Successfully";
                          else
                            echo "Centre $code not updated Successfully";
		       }
                       if($action=='actionstore')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset_id');
                         $code= $this->input->get('valuee');
			 $store= $this->input->get('store');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("UPDATE project_store_loc_map SET valuee=$code, store='$store' where id=$id");
                         if($rd)
                            echo "Store $code / $store updated Successfully";
                          else
                            echo "Store $code not updated Successfully";
                       }
                       if($action=='actionstored')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset_id');
                         $code= $this->input->get('valuee');
                         $store= $this->input->get('store');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM project_store_loc_map where id = $id ;");
                         if($rd)
                            echo "Store $code / $store is deleted Successfully";
                          else
                            echo "Store $code is not deleted Successfully";
                       }

                       if($action=='actionproduct')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset_id');
                         $code= $this->input->get('valuee');
			 $prod= $this->input->get('product');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("UPDATE project_product_map SET valuee=$code, product='$prod' where id=$id");
                         if($rd)
                            echo "Product $code / $prod updated Successfully";
                          else
                            echo "Product $code not updated Successfully";
                       }
                       if($action=='actionproductd')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset_id');
                         $code= $this->input->get('valuee');
                         $prod= $this->input->get('product');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM project_product_map where id=$id");
                         if($rd)
                            echo "Product $code / $prod is deleted Successfully";
                          else
                            echo "Product $code is not deleted Successfully";
                       }
                       if($action=='actionsec')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset');
                         $code= $this->input->get('valuee');
                         $sec= $this->input->get('sec');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("UPDATE project_sec_map SET valuee=$code, sec='$sec' where id=$id");
                         if($rd)
                            echo "SEC $code / $sec updated Sucessfully";
                          else
                            echo "SEC $code not updated Sucessfully";
                       }
                       if($action=='actionsecd')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset');
                         $code= $this->input->get('valuee');
                         $sec= $this->input->get('sec');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM project_sec_map where id=$id");
                         if($rd)
                            echo "SEC $code / $sec deleted Sucessfully";
                          else
                            echo "SEC $code is not deleted Sucessfully";
                       }
                       if($action=='actionage')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset');
                         $code= $this->input->get('valuee');
                         $sec= $this->input->get('age');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("UPDATE project_age_map SET valuee=$code, age='$sec' where id=$id");
                         if($rd)
                            echo "Age $code / $sec updated Sucessfully";
                          else
                            echo "Age $code not updated Sucessfully";
                       }
                       if($action=='actionaged')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset');
                         $code= $this->input->get('valuee');
                         $sec= $this->input->get('age');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM project_age_map where id=$id");
                         if($rd)
                            echo "Age $code / $sec deleted Sucessfully";
                          else
                            echo "Age $code is not deleted Sucessfully";
		       }
                       if($action=='actionaddfp')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("INSERT INTO project_fp_map (pid,fpid) VALUES($pid, $id );");
                         if($rd)
                            echo "First Page added $id / $pid updated Sucessfully";
                          else
                            echo "First Page $id not updated Sucessfully";
                       }
                       if($action=='actiondeletefp')
                       {
                         $id= $this->input->get('id');
                         $pid= $this->input->get('qset');
                         $this->load->model('MProject');
                         $rd=$this->MProject->doSqlDML("DELETE FROM project_fp_map WHERE pid=$pid AND fpid= $id ;");
                         if($rd)
                            echo "First Page $id / $pid deleted Sucessfully";
                          else
                            echo "First Page $id not deleted Sucessfully";
                       }else{
                        echo("<script>console.log('PHP: No action Met');</script>");
  
                       }
	}
        public function copyqbcat($action)
        {
			                                $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                  $this->load->model('MProject');
                      if($action=='actionqbycat')
                      {    $ctr=0;$str='';
                           $cat= $this->input->get('cat');
                           if($cat!=0)
                           {
                           echo "<br>Question List in Database:<br><table border=1>";
                           $sql="SELECT `id`, `cat_id`, `q_id`, `remarks` FROM `question_category` WHERE cat_id=$cat";
                           $sdata=$this->MProject->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {    
                                $qqid=$d->q_id;
                                if($ctr==0) $str=$qqid;
                                if($ctr>0) $str.=','.$qqid;
                                $ctr++;
                           } 
                                $sql1="SELECT * FROM `question_detail` WHERE q_id in ( $str )";
                                $sds=$this->MProject->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {     
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;$qn=$q->qno;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid - $qn /$qt </td><td><div  onclick=showhideqop($qid);>$title ";
                                        echo "<ul class='w3-ul w3-hide' id=$qid>";
                                        $qops=$this->MProject->getPQop($qid);
                                        if($qops)
                                        foreach($qops as $op)
                                        {
	                                echo "<li>$op->value -- $op->opt_text_value</li>";
                                        } echo "</ul> </div> </td></tr>";
                                }    echo "</table>"; 
                          }                    
                       }
                       if($action=='actionqbykey')
                       {
                           echo $sk= $this->input->get('key');
                           $ctr=0;$str='';
                           
                           if($sk!='')
                           {
                           echo "<br>Question List in Database:<br><table border=1>";
                           $sql="SELECT `id`, `cat_id`, `q_id`, `remarks` FROM `question_category` ";
                           $sdata=$this->MProject->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {    
                                $qid=$d->q_id;
                                if($ctr==0) $str=$qid;
                                if($ctr>0) $str.=','.$qid;
                                $ctr++;
                           } 
                                $sql1="SELECT * FROM `question_detail` WHERE q_title like '%$sk%' AND q_id in ( $str )";
                                $sds=$this->MProject->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {   
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;$qn=$q->qno;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid - $qn /$qt </td><td> $title</td></tr>";
                                }    echo "</table>"; 
                          }               
                       } 
                       if($action=='actionqbykeyp')
                       { 
                           $fp= $this->input->get('fpn');
                           $sk= $this->input->get('key');
                           $ctr=0;$str='';
                           $sql="SELECT distinct q_id FROM `question_detail` WHERE q_title like '%$sk%' OR qset_id = $fp";
                           $sdata=$this->MProject->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {    
                                $qid=$d->q_id;
                                if($ctr==0) $str=$qid;
                                if($ctr>0) $str.=','.$qid;
                                $ctr++;
                           } 
                           if($fp!=0)
                           {
                            
                                $sql1="SELECT * FROM `question_detail` WHERE q_title like '%$sk%' AND qset_id = $fp";
                                $sds=$this->MProject->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {   
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;$qn=$q->qno;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid - $qn /$qt </td><td> $title</td></tr>";
                                }    echo "</table>"; 
                          }               
                       }
                       if($action=='actionqbyp')
                       {
                           $fp= $this->input->get('fpn');
                           $ctr=0;$str='';
                           
                           if($fp!=0)
                           {
                                echo "<br>Question List in Database:<br><table border=1>";
                          
                                $sql1="SELECT * FROM `question_detail` WHERE qset_id = $fp";
                                $sds=$this->MProject->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {   
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;$qn=$q->qno;
                                     echo "<tr><td><input type=checkbox name=qid[] value=$qid></td><td> $qid - $qn /$qt </td><td> $title</td></tr>";
                                }    echo "</table>"; 
                          }               
                       }
        }
        public function createqbcat($action)
        {                
			$this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $this->load->model('MProject');
                       if($action=='actioncatn')
                       {
	                  $cname= $this->input->get('catname');
                          $arr=array('name'=>$cname);
                          $ic=$this->MProject->isCat($cname);
                          if(!$ic)
                          {
                            $sd=$this->MProject->insertIntoTable('category_detail',$arr);   
                            echo "$cname - Created Successfully";
                          }
                          if($ic) echo "$cname - Category already exist in database";
                       }
                       if($action=='actioncatv')
                       {
                           echo "<br>Category List in Database:<br>";
                           $sql="SELECT `catid`, `name`, `remarks` FROM `category_detail` order by name";
                           $sdata=$this->MProject->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {
                                $id=$d->catid; $n=$d->name;
                                echo "<li> $id -- $n";
                           }                         
                       }
                       
	}
        
 public function createproject()
 {      // print_r($_POST); die;

                $this->load->view('v_h');
                echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";  
                $dt = date('Y-m-d H:i:s');
                $crDt = date('Y-m-d');
                $login=$this->session->userdata('sauserid'); 
                $projectTypes= trim($this->input->post('select_project_types')); 
                $projectName= trim($this->input->post('pname')); 
                $brandName= $this->input->post('brand'); 
                $clientCompanyName= $this->input->post('ccn');
                          if($clientCompanyName =='')  $clientCompanyName= null;
                $surveySampleSize= $this->input->post('ss'); 
                           if($surveySampleSize=='')   $surveySampleSize= 49;
                $surveyround= $this->input->post('visit');
                if($surveyround=='') $surveyround =1;
                $surveyStartDate= $this->input->post('ssdt'); 
                $surveyEndDate= $this->input->post('esdt');   
                $researchTypes= $this->input->post('reserch_type');
                if($researchTypes=='') $researchTypes =4;
                $response_type= $this->input->post('response_types');
                $surveyTypes= $this->input->post('survey_type');
                
                $surveyOccurance= $this->input->post('survey_occurrence');
                if($surveyOccurance== '') $surveyOccurance= 'None';
                $surveyTimes= $this->input->post('survey_times');
                if($surveyTimes== '') $surveyTimes= 1;
                $occuranceTimes= $this->input->post('occurancetimes');   
                if($occuranceTimes== '') $occuranceTimes= 1;   
                $restrictHours= $this->input->post('restictHour');
                if($restrictHours== '') $restrictHours= 1;
                $rewardPoint= $this->input->post('rp'); 
                if($rewardPoint== '') $rewardPoint= 0;
                
                //ENTRY FOR THE SERVEGENICS
               
                $fps=$this->input->post('fp');
                 //previous entry for insightfix
                //$parr=array('name'=>$pn,'company_name'=>$ccn,'brand'=>$b,'research_type'=>$rt,'tot_visit'=>$v,'background'=>$bd,'sample_size'=>$ss,'survey_start_date'=>$ssid,'survey_end_date'=>$esid,'category'=>$pcat,'reward_point'=>$rp,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login);
                $parr=array('name'=>$projectName,'project_type'=>$projectTypes,'company_name'=>$clientCompanyName,'brand'=>$brandName,'research_type'=>$researchTypes, 'survey_types'=>$surveyTypes,'response_type'=>$response_type,'sample_size'=>$surveySampleSize,'survey_start_date'=>$surveyStartDate,'survey_end_date'=>$surveyEndDate,'reward_point'=>$rewardPoint,'created_at'=>$dt, 'uid'=>$login);

                if($projectName!=''){
         
                $this->load->model('MProject');
                $chkp=$this->MProject->getDataBySql("select * from project where name='$projectName'");
                if(!$chkp)
                {
                  $pid=$this->MProject->insertIntoTable('project',$parr);
                 
                  if($pid !='' && $surveyTypes == 1){
                          
          $remarray = array('project_id'=>$pid,'survey_occurence'=>$surveyOccurance,'occurance_repitation'=>$surveyTimes,'excution_time'=>$$surveyTimes,'restrict_occurance_between'=>$restrictHours);
                         $this->MProject->insertIntoTable('reminder',$remarray);
                  }
                  $dtn=trim($this->MProject->get_project_name($pid));
                  $dtn=strtolower($dtn);
                  $dtn.='_'.$pid;
                  if($pid)
                  {
                          //$rdd2=$this->MProject->doSqlDML("CREATE TABLE IF NOT EXISTS $dtn  (id int(5) primary key AUTO_INCREMENT,resp_id bigint(20) not null, q_id int(5) not null, r_name varchar(30) not null, mobile varchar(11) not null, centre_$pid varchar(2), i_date_$pid datetime, e_date_$pid datetime, latt varchar(30) null, lang varchar(30) null, sec_$pid varchar(1) not null, gender_$pid varchar(1) not null, week_day_$pid char(1) not null, age_$pid varchar(2) not null, st_$pid varchar(2) not null, age_yrs_$pid varchar(2) not null, store_$pid varchar(1) not null, product_$pid varchar(1) not null)ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ");
                          $rdd2=$this->MProject->doSqlDML("CREATE TABLE IF NOT EXISTS $dtn (id int(10) primary key AUTO_INCREMENT, resp_id bigint(20) not null, q_id int(5) not null, r_name varchar(30)  null, mobile varchar(11)  null, centre varchar(6) null ,timestamp varchar(20)  null, c_area varchar(4) null, c_sub_area varchar(4)  null,  i_name varchar(30) null, i_mobile varchar(11)  null, i_date datetime  null, e_date datetime  null,address varchar(40) null, o_sec varchar(1) null , n_sec varchar(1) null, gender varchar(1) null, week_day char(1)  null, age varchar(2) null, st varchar(2)  null, age_yrs varchar(2)  null, store varchar(2)  null, product varchar(2)  null, ref_no varchar(15) null, latt varchar(30) null, lang varchar(30) null) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ");
                          if($rdd2)
                          {
                              $rdd3=$this->MProject->doSqlDML("ALTER TABLE $dtn ADD index rsp$pid (resp_id)");
                              $rdd4=$this->MProject->doSqlDML("UPDATE `project` SET  `data_table`='$dtn' ,`status`=1 WHERE `project_id`=$pid");
                             // CREATE Q-SET ID FOR SERVEGENICS 
                             $qStparr=array('qset_id'=>$pid,'project_id'=>$pid,'visit_no'=>1,'created_at'=>$crDt, 'updated_at'=>$crDt,'uid'=>$login); 
                             $qSetid=$this->MProject->insertIntoTable('questionset',$qStparr);
                             
                             //$sdata="Qset ID ' $pid ' visit $visit created successfully";


                             // END THE CREATION OF SERVEGENIC Q-SET ID CREATION 
                             
                             
                              $sdata=" Project ' $projectName ' with Q-set Id '$pid' is created successfully";
                          }
                         //for adding project fisrt page details 
                         if(!empty($fps))
                         foreach($fps as $ffp){
                                 $atemp=array('pid'=>$pid,'fpid'=>$ffp);
                                 $tt=$this->MProject->insertIntoTable('project_fp_map',$atemp);
                         }
                  }
                  else $sdata="Project ' $pn ' Not created , Please try again";
                }
                if($chkp) $sdata="Project name ' $pn ' already exist in database";
                }else  $sdata="Error Occured! $pn";
                $arrdata['rqpost']='';
                echo $arrdata['msg']=$sdata;
                //$this->load->view('samylogin',$arrdata);
         
         
 }       
 
 public function createqset()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                        $dt = date('Y-m-d H:i:s');
                        $login=$this->session->userdata('sauserid');

                       $pid= $this->input->post('pn'); 
                       $visit= $this->input->post('visit'); 
                       
	               $this->load->model('MProject');
                       
                       // CODE FOR SERVEGENICS
                        $chkPro=$this->MProject->getDataBySql("select * from project where project_id=$pid AND project_type='servegenix' ");
                     // var_dump($chkp);die;
                     if($chkPro){
                        $chkpQset=$this->MProject->getDataBySql("select * from questionset where project_id=$pid AND visit_no=$visit"); 
                        if(!$chkpQset)
                        {  
                        $parr=array('qset_id'=>$pid,'project_id'=>$pid,'visit_no'=>$visit,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login); 
                          $qSetid=$this->MProject->insertIntoTable('questionset',$parr);
                          $sdata="Qset ID ' $pid ' visit $visit created successfully";
                        }
                        if($chkpQset) $sdata="Qset id: ' $pid ' with visit: $visit already exist in database";
                        echo $arrdata['msg']=$sdata;

                     }
                      
                     //  END THE SERVEGENICS CODE
                     if(!$chkPro){
                       $chkp=$this->MProject->getDataBySql("select * from questionset where project_id=$pid AND visit_no=$visit");
                       if(!$chkp)
                       {  
                        $parr=array('qset_id'=>$pid,'project_id'=>$pid,'visit_no'=>$visit,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login); 
                         $qSetpid=$this->MProject->insertIntoTable('questionset',$parr);
                         $sdata="Qset ID ' $pid ' visit $visit created successfully";
                       }
                       if($chkp) $sdata="Qset id: ' $pid ' with visit: $visit already exist in database";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}  }
        public function createquestion()
        {         
                
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

			$pn= $this->input->post('pn');
                       $pid= $this->input->post('qset'); 
                       $ssid= $this->input->post('ssid'); 
                       $esid= $this->input->post('esid');
	               $this->load->model('MProject');
                        $sdata=$this->MProject->docreatequestion($_POST);
			
			$_SESSION['pid']=$pn;
			$_SESSION['qset']=$pid;
			$sdata.= "<br><br>Click to more <font clolor=red> <a href = 'http://localhost/digiamin-web/siteadmin/user_action/createquestion'> New Question </a></font> "; 
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function docreatesequence()
        {         
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $sdata='Sequence Not Added';
	               $this->load->model('MProject');
                       $sd=$this->MProject->doCUpdateSequence($_POST,$pid);
                       if($sd) $sdata='Sequence Added Successfully';
                        
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function createsequence()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $pid= $this->input->post('qset'); 
	               $this->load->model('MProject');
                       //$sd=$this->MProject->viewCreateSequence($pid);
			$sd=$this->MProject->viewCreateSequenceDraggable($pid);
                             $arrdata['rqpost']='';
                             echo $arrdata['msg']=$sd;
                             //$this->load->view('samylogin',$arrdata);
	}

        public function createsequencedraggable()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
                       $pid= $this->input->post('qset');
			//$pid = 176;
                       $this->load->model('MProject');
                       $sd=$this->MProject->viewCreateSequenceDraggable($pid);
                             $arrdata['rqpost']='';
                             echo $arrdata['msg']=$sd;
                             //$this->load->view('samylogin',$arrdata);
        }

        public function docreateroutine()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $qid= $this->input->post('qs'); 
                       $pqid= $this->input->post('pqid');

			$pn= $this->input->post('pn');
                        $_SESSION['pid']=$pn;
                        $_SESSION['qset']=$pid;

	               $this->load->model('MProject');
                       	$sdata=$this->MProject->doCRoutine($pid,$qid,$pqid);
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function createroutine()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";
			$login = $this->session->userdata('sauserid');
			$dt = date('Y-m-d H:i:s');

                       $qset= $this->input->post('qset'); 
                       $qids= $this->input->post('qid');

                        $pn= $this->input->post('pn');
                        $_SESSION['pid']=$pn;
                        $_SESSION['qset']=$qset;

	               $this->load->model('MProject');
                       $qid='';$pqid='';$nctr=0; $opval='';$i=0;
				$lastid=0;$_SESSION['lastid']=0;
				//print_r($_POST);
                             foreach($_POST as $key=>$val)
                             {
                                     if($key=='qs')
                                     {
                                       $qids=$val; continue;
                                     }
                                     if($key=='pqid')
                                     {
                                       $pqid=$val; continue;
                                     }
                                     if($key!='rsubmit')if($key!='qset')if($key!='pn')
                                     {  
					//echo "<br> $key : $val";
                                          $ff="chk$val";
					  $fw="f$val";
                                     	  if($key==$ff){
						$opval=$val;  $nctr=1;
						$flow = $this->input->post($fw);
						foreach($qids as $qid){
                                        		//$qi="INSERT INTO `question_routine_check`(`qset_id`, `qid`, `pqid`, `opval`, `flow`) VALUES ($qset,$qid,$pqid,$val,$flow);";
							$insd=array("qset_id" => $qset,"qid" => $qid,"pqid" => $pqid,"opval" => $val,"flow" => $flow,'created_at'=>$dt, 'updated_at'=>$dt,'uid'=>$login );
							$lastid=$this->MProject->insertIntoTable('question_routine_check',$insd);
						} //end of foreach
                                      	}  //end of if $key == ff
                             		} //end of  if $
                       } //end of foreach
                       $sdata= "<br>Question Routine added successfully";
		       $sdata.= "<br><br>Click here to <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/createroutine'> Add Routine </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addqbquest()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $cat= $this->input->post('cat'); 
                       $qid= $this->input->post('qs');  
	               $this->load->model('MProject');
                       $arr=array('cat_id'=>$cat,'q_id'=>$qid);
                       $rr=$this->MProject->isQCat($cat,$qid);
                       if(!$rr)
                       {   $sd=$this->MProject->insertIntoTable('question_category',$arr);
                           if($sd) $sdata="Sucessfully Added qid:$qid to Cat:$cat";
                           if(!$sd) $sdata="Unable to Add qid:$qid to Cat:$cat";
                       }
                       if($rr) $sdata="Already exist in our database-- qid:$qid to Cat:$cat";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addqop()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $code= $this->input->post('code'); 
                       $opt= $this->input->post('opt');
                       $qid= $this->input->post('qs');  
	               $this->load->model('MProject');
                       $term=$this->MProject->isQTerm($qid);
                       if($term == false){
                           $qno = $this->MProject->getQno($qid);
                           $term = $qno.'_'.$pid;
                       }
                       $arr=array('opt_text_value'=>$opt,'value'=>$code,'q_id'=>$qid,'term'=>$term);
                       $rr=$this->MProject->isQOp($qid,$code);
                       if(!$rr)
                       {   $sd=$this->MProject->insertIntoTable('question_option_detail',$arr);
                           if($sd) $sdata="Sucessfully Added Option in qid:$qid as $opt <br><br>Click here to <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addqop'> Add More Options</a>";
                           if(!$sd) $sdata="Unable to Add Option in qid:$qid as $opt";
                       }
                       if($rr) $sdata="Already exist in our database-- Option in qid:$qid as $opt";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function deletequestionop()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $code= $this->input->post('code'); 
                       $qid= $this->input->post('qs');  
	               $this->load->model('MProject');  
                       //$rr=$this->MProject->isQOp($qid,$code);
                       //if($rr)
                       //{   //$op=$this->MProject->getQopid($qid,$code);
			foreach($code as $cde){
                           $sd=$this->MProject->doSqlDML("DELETE FROM `question_option_detail` WHERE `op_id`=$cde");
			}
                           if($sd) $sdata="Sucessfully Deleted Option in qid:$qid with selected code";
                            
                       //}
                       //if(!$rr) $sdata="Does not exist in our database-- Option in qid:$qid & code: $code";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function deletequestion()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $code= $this->input->post('code'); 
                       $qids= $this->input->post('qs');  
	               $this->load->model('MProject');
                       $ptable = $this->MProject->getProjectTable($pid);

                       if($qids)
		       foreach($qids as $qid)
                       {
			   $qt = $this->MProject->getQType($qid);
			   $trm = $this->MProject->isQTerm($qid);
			   $trmt = $trm.'_t';
			   $sd=$this->MProject->doSqlDML("DELETE from question_detail WHERE q_id=$qid ;");
                           if($sd) $sdata="Sucessfully Deleted Question with its Options in qid:$qid";
                           if( $qt != 'instruction' ||  $qt != 'image' ||  $qt != 'audio'  ||  $qt != 'video' ||  $qt != 'imaged' ||  $qt != 'audiod'  ||  $qt != 'videod') $s=$this->MProject->doSqlDML("DELETE FROM `question_option_detail` WHERE `q_id`=$qid ;"); 
			   if($trm !='' && ($qt != 'instruction' ||  $qt != 'image' ||  $qt != 'audio'  ||  $qt != 'video' ||  $qt != 'imaged' ||  $qt != 'audiod'  ||  $qt != 'videod') ) $s2=$this->MProject->doSqlDML("ALTER TABLE $ptable DROP column $trm ;");
                           //if($trmt != '' && ($qt != 'instruction' ||  $qt != 'image' ||  $qt != 'audio'  ||  $qt != 'video' ||  $qt != 'imaged' ||  $qt != 'audiod'  ||  $qt != 'videod') ) $s2=$this->MProject->doSqlDML("ALTER TABLE $ptable DROP column $trmt ;");
                       }
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addsequence()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset');
                       $qid= $this->input->post('qid');
                       $sid= $this->input->post('sid');
	               $this->load->model('MProject');
                       $arr=array('qset_id'=>$qset,'qid'=>$qid, 'sid'=>$sid,'chkflag'=>0);
                        $sd=$this->MProject->insertIntoTable('question_sequence',$arr);
                           if($sd) $sdata="Sucessfully Sequence Added qid:$qid of Qset:$qset <br><br>Click here to <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addsequence'> Add more sequence</a>";
                           if(!$sd) $sdata="Unable to Sequence Added qid:$qid of Qset:$qset";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}

	public function viewaddpcentre()
	{
                //$this->load->view('v_addpcentre'); 
                $this->load->view('v_h');
                echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                echo "<br><br><br><br> <div class='content' style='margin-left: 15%;'><div class='well col-lg-9'>";
                $this->load->model('MProject');
                $str=$this->MProject->getaddpcentre();
                 echo form_open('siteadmin/addpcentre'); 
                      echo $str;
              
                 echo form_close(); 

                

		
	}

        public function addpcentre()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset');
                       $cn_arr= $this->input->post('cn');
	               $this->load->model('MProject');
			$sdata="Unable to add Centre(s) to Qset:$qset , Please select centres to a project";
			//to add multiple centres
			if(!empty($cn_arr))
			foreach($cn_arr as $cn){
        	               $arr=array('centre_id'=>$cn,'project_id'=>$pid, 'q_id'=>$qset);
	                        $sd=$this->MProject->insertIntoTable('centre_project_details',$arr);
				if($sd) $sdata="Sucessfully Centre(s) Added to Qset:$qset";
			}
                       $sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addpcentre'> Add Centre </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addpproduct()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset');
                       $prdn= $this->input->post('prdn');
                       $c= $this->input->post('code');

	               $this->load->model('MProject');
                       $arr=array('valuee'=>$c,'product'=>$prdn, 'qset_id'=>$qset);
                        $sd=$this->MProject->insertIntoTable('project_product_map',$arr);
                           if($sd) $sdata="Sucessfully Product Added :$prdn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Product Added :$prdn to Qset:$qset";
                      $sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addpproduct'> Add Product </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addpstore()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset');
                       $sn= $this->input->post('sn');
                       $c= $this->input->post('code');

	               $this->load->model('MProject');
                       $arr=array('valuee'=>$c,'store'=>$sn, 'qset_id'=>$qset);
                        $sd=$this->MProject->insertIntoTable('project_store_loc_map',$arr);
                           if($sd) $sdata="Sucessfully Store Added :$sn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Store Added :$sn to Qset:$qset";
                      $sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addpstore'> Add Store </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addpsec()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset');
                       $sn= $this->input->post('sec');
                       $c= $this->input->post('code');
	               $this->load->model('MProject');
                       $arr=array('valuee'=>$c,'sec'=>$sn, 'qset'=>$qset);
                        $sd=$this->MProject->insertIntoTable('project_sec_map',$arr);
                           if($sd) $sdata="Sucessfully SEC Added :$sn to Qset:$qset";
                           if(!$sd) $sdata="Unable to SEC Added :$sn to Qset:$qset";
                      $sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addpsec'> Add SEC </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addpage()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $sn= $this->input->post('age'); 
                       $c= $this->input->post('code'); 
                        
	               $this->load->model('Mproject');
                       $arr=array('valuee'=>$c,'age'=>$sn, 'qset'=>$qset);
                        $sd=$this->MProject->insertIntoTable('project_age_map',$arr);
                           if($sd) $sdata="Sucessfully Age Added :$sn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Age Added :$sn to Qset:$qset";
                       $sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addpage'> Add Age </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addcentre()
        {        
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $cn= $this->input->post('cn'); 
	               $this->load->model('MProject');
                       $arr=array('cname'=>$cn);
                        $sd=$this->MProject->insertIntoTable('centre',$arr);
                           if($sd) $sdata="Sucessfully Centre Added :$cn";
                           if(!$sd) $sdata="Unable to Centre Added :$cn";
                      
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
	public function addarea()
	{
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

		//print_r($_REQUEST);
		$pid= $this->input->post('pn');
		$qset=$this->input->post('qset');
		$cid=$this->input->post('center');
		$code=$this->input->post('code');
		$area=$this->input->post('area');

                       $this->load->model('MProject');
                       $arr=array('qset'=>$qset,'cid'=>$cid,'area'=>$area,'value'=>$code);
                        $sd=$this->MProject->insertIntoTable('project_centre_area_map',$arr);
                           if($sd) $sdata="Sucessfully Area Added :$area";
                           if(!$sd) $sdata="Unable to Area Added :$area";
			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addarea'> Add Area </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);

	}
	public function addsubarea()
	{
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

		//print_r($_REQUEST);
		$pid= $this->input->post('pn');
                $qset=$this->input->post('qset');
                $cid = $this->input->post('center');
                $code=$this->input->post('code');
                $area=$this->input->post('subarea');

                       $this->load->model('MProject');
                       $arr=array('qset'=>$qset,'cid'=>$cid,'suarea'=>$area,'value'=>$code);
                        $sd=$this->MProject->insertIntoTable('project_centre_subarea_map',$arr);
                           if($sd) $sdata="Sucessfully SubArea Added :$area";
                           if(!$sd) $sdata="Unable to SubArea Added :$area";
			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addsubarea'> Add Sub-Area </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function copyqbquest()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $qno= $this->input->post('qno'); 
                       $qid= $this->input->post('qid');  $qno=strtolower($qno);
	               $this->load->model('MProject');
                       $sdata=$this->MProject->copyquestioninproject($pid, $qset, $qid, $qno);
			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/copyqbquest'> Copy Question </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function copyquestionop()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $qno= $this->input->post('qno'); 
                       $fpn= $this->input->post('fpn'); 
                       $qids= $this->input->post('qid'); $qno=strtolower($qno);
	               $this->load->model('MProject');
			//print_r($qids);
                       $sdata = $this->MProject->copyquestioninproject($pid, $qset, $qids, $qno);
			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/copyquestionop'> Copy Question Options </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function copytquestionop()
        {
                       
                       $this->load->view('v_copytqop');
        }
        public function copytqop()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

		      $qset= $this->input->post('qset');
		      $lang= $this->input->post('lang');
		      $arrdata['qset']=$qset;
		      echo $arrdata['lang']=$lang;
                      //$this->load->view('v_copytqop2',$arrdata);
        }
        public function docopytqop()
        {
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

		//print_r($_POST);
                       //$this->load->view('v_copytqop');
		$fqid=$this->input->post('fqid');
		$q_arr=$this->input->post('tqid');
		$lang=$this->input->post('lang');
		$table='';
		$msg= "Error! No data available to copy";

                foreach($q_arr as $q){

		if($lang==1){ $table='hindi_question_option_detail'; $sql = "select * from hindi_question_option_detail where q_id=$fqid order by code";}
		if($lang==2){$table='kannar_question_option_detail'; $sql = "select * from kannar_question_option_detail where q_id=$fqid order by code";}
		if($lang==3){$table='malyalam_question_option_detail'; $sql = "select * from malyalam_question_option_detail where q_id=$fqid order by code";}
		if($lang==4){$table='tammil_question_option_detail'; $sql = "select * from tammil_question_option_detail where q_id=$fqid order by code";}
		if($lang==5){$table='telgu_question_option_detail'; $sql = "select * from telgu_question_option_detail where q_id=$fqid order by code";}
		if($lang==6){$table='bengali_question_option_detail'; $sql = "select * from bengali_question_option_detail where q_id=$fqid order by code";}
		if($lang==7){$table='odia_question_option_detail'; $sql = "select * from odia_question_option_detail where q_id=$fqid order by code";}
		if($lang==8){$table='gujrati_question_option_detail'; $sql = "select * from gujrati_question_option_detail where q_id=$fqid order by code";}
		if($lang==9){$table='marathi_question_option_detail'; $sql = "select * from marathi_question_option_detail where q_id=$fqid order by code";}
		if($lang==10){$table='asami_question_option_detail'; $sql = "select * from asami_question_option_detail where q_id=$fqid order by code";}

		//foreach($q_arr as $q){

		$qsq=$this->MProject->getDataBySql($sql);
		if($qsq )
		//foreach($q_arr as $q){
		   foreach($qsq as $qs){
			$tqid = $qs->q_id;
			$qopt = $qs->opt_text_value;
			$code = $qs->code;
				$isql="INSERT INTO $table (q_id,opt_text_value,code) VALUES('$q','$qopt',$code);";
                                $sa=$this->MProject->doSqlDML($isql);
				$msg="Copy Translated Options sucessfully. <br> <a href ='copytquestionop'> More copy ...</a>";
		   }else $msg= "Error! No data available to copy";
		} echo $msg;
                       $arrdata['rqpost']='';
                      echo  $arrdata['msg']=$msg;
                       //$this->load->view('samylogin',$arrdata);
        }

        public function deletesequence()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');

	               $this->load->model('MProject');
                      
                       $qi="DELETE FROM `question_sequence` WHERE `qset_id`= $qset";
                       $sa=$this->MProject->doSqlDML($qi); 
                       $sdata="Not deleted";
                       if($sa) $sdata="Question Sequence of QSET: $qset, Deleted Successfully";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function deleteroutine()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');

	               $this->load->model('MProject');
                      
                       $qi="DELETE FROM `question_routine_check` WHERE `qset_id`= $qset";
                       $sa=$this->MProject->doSqlDML($qi); 
                       $sdata="Not deleted";
                       if($sa) $sdata="Question Routine of QSET: $qset, Deleted Successfully";
			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/deleteroutine'> Delete Routine </a></font> ";
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addtransq()
        {       
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $qid= $this->input->post('qs'); 
                       $lang= $this->input->post('lang'); 
                       $title= $this->input->post('tv');  
	               $this->load->model('MProject');
                       $arr=array('q_title'=>$title,'q_id'=>$qid);
                       if($lang==1)
                       {
                             $rr=$this->MProject->isTransQ('hindi_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->MProject->insertIntoTable('hindi_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->MProject->doSqlDML("UPDATE `hindi_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==2)
                       {
                             $rr=$this->MProject->isTransQ('kannar_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->MProject->insertIntoTable('kannar_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->MProject->doSqlDML("UPDATE `kannar_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==3)
                       {
                             $rr=$this->MProject->isTransQ('malyalam_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->MProject->insertIntoTable('malyalam_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->MProject->doSqlDML("UPDATE `malyalam_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==4)
                       {
                             $rr=$this->MProject->isTransQ('tammil_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->MProject->insertIntoTable('tammil_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->MProject->doSqlDML("UPDATE `tammil_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==5)
                       {
                             $rr=$this->MProject->isTransQ('telgu_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->MProject->insertIntoTable('telgu_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->MProject->doSqlDML("UPDATE `telgu_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==6)
                       {
                             $rr=$this->MProject->isTransQ('bengali_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->MProject->insertIntoTable('bengali_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->MProject->doSqlDML("UPDATE `bengali_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addtransqop()
        {       //print_r($_POST);
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $pid= $this->input->post('qset'); 
                       $qid= $this->input->post('qs'); 
                       $lang= $this->input->post('lang'); 
                       //title= $this->input->post('tv');  
	               $this->load->model('MProject');
                        

                       //to store all values
       $arr_post=array();
       foreach($_POST as $k=>$v)
       {  
            if($k=='pn' || $k=='lang' || $k=='qs'|| $k=='qset')
               continue;           
              if($v!='')if($v!='0')
                  array_push($arr_post,$v);          
       }
      $tot=count($arr_post);
      echo $t=$tot/2;
	//print_r($arr_post);
                       if($lang==1)
                       {
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 

                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                $rr=$this->MProject->isTransQop('hindi_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->MProject->insertIntoTable('hindi_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added hindi qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->MProject->doSqlDML("UPDATE `hindi_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated hindi qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       if($lang==2)
                       {
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 
                                //echo '<br>'.$sql="INSERT into `bengali_question_option_detail` (`q_id`, `opt_text_value`,code) VALUES ($qid,'$op',$v1)";
                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                
                                $rr=$this->MProject->isTransQop('kannar_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->MProject->insertIntoTable('kannar_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->MProject->doSqlDML("UPDATE `kannar_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       if($lang==3)
                       {
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 
                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                
                                $rr=$this->MProject->isTransQop('malyalam_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->MProject->insertIntoTable('malyalam_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added malyalam qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->MProject->doSqlDML("UPDATE `malyalam_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated malyalam qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       if($lang==4)
                       { 
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 
                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                
                                $rr=$this->MProject->isTransQop('tammil_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->MProject->insertIntoTable('tammil_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added tammil qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->MProject->doSqlDML("UPDATE `tammil_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated tammil qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       if($lang==5)
                       {
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 
                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                
                                $rr=$this->MProject->isTransQop('telgu_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->MProject->insertIntoTable('telgu_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added telgu qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->MProject->doSqlDML("UPDATE `telgu_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated telgu qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       if($lang==6)
                       {
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 
                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                
                                $rr=$this->MProject->isTransQop('bengali_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->MProject->insertIntoTable('bengali_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added bengali qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->MProject->doSqlDML("UPDATE `bengali_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated bengali qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);
	}
        public function addpcrosstab()
        {       //print_r($_POST);
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                $pid= $this->input->post('pn');
                $qset = $this->input->post('qset');
		$this->load->model('MProject');
		$sdata='Please select the qset';
           if($qset != 0 )
           {
                  $qtd="SELECT q_id,`q_type`,qno, q_title FROM `question_detail` WHERE `qset_id`=$qset";
                  $qtd1=$this->MProject->getDataBySql($qtd);
                 foreach($qtd1 as $val)
                 {
                  $qt=$val->q_type;
                  $qid=$val->q_id;
                  $qno=$val->qno;
                  $qtitle=$val->q_title;
                 
                  //to add into crosstab -------------------------------------------------
		          if($qt=='radio' || $qt=='checkbox')
		          {
		              $qr="SELECT  `opt_text_value`, `term` ,`value`  FROM `question_option_detail` WHERE `q_id`=$qid";
		              $dta=$this->MProject->getDataBySql($qr);
		
		             if($dta)
		             {
		               $term=$dta[0]->term; 
                               if(!$this->MProject->is_project_term_exist($term))
                               {  $dta=$this->MProject->getDataBySql($qr);
		                foreach($dta as $d)
		                {
		                   $val=$d->value;$tv=$d->opt_text_value;
		                   $qrd="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$tv',$val);";
		                   $sd=$this->MProject->doSqlDML($qrd);
		                }        
		                   $qrt="INSERT INTO `project_term_map`( `project_id`, `term`) VALUES ($pid,'$term')";
		                   $sdi=$this->MProject->doSqlDML($qrt);    
                               } //end if project term exist
		             }
		
		          } //end of radio
		              if($qt=='rating')
		              {      
		                   $qrr="SELECT  `term` ,  `scale_start_value` ,  `scale_end_value` ,  `scale_start_label` ,  `scale_end_label` FROM  `question_option_detail` WHERE  `q_id` =$qid limit 1;";
		                   $qta=$this->MProject->getDataBySql($qrr);
		                  if($qta)
		                  { 
		                        $term=$qta[0]->term;
                                  if(!is_project_term_exist($term))
                                 {      $qta=$this->MProject->getDataBySql($qrr);
                                        $term=$qta->term;
		                        $sv=$qta->scale_start_value;
		                        $lv=$qta->scale_end_value;
		                        $ssl=$qta->scale_start_label;
		                        $sel=$qta->scale_end_label;
		                        
		                     if($sv==1)   
		                     {
		                        for($i=$sv;$i<=$lv;$i++)
		                        {   $str='rating-'.$i;
		                             if($i==$sv)
		                                $str=$ssl;
		                             if($i==$lv)
		                                $str=$sel;
		
		                            $qrd1="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$str',$i);";
		                            $sddl=$this->MProject->doSqlDML($qrd1);   		                              
		                        }
		                        
		                      }else  if($sv==0)
		                      {   
		                        for($i=1;$i<=$lv;$i++)
		                        {   $str='rating-'.$i;
		                             if($i==$sv)
		                                $str=$ssl;
		                             if($i==$lv)
		                                $str=$sel;
		
		                             $qrd2="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','$str',$i);";
		                             $dta2=$this->MProject->doSqlDML($qrd2);   
		                            if($i==$lv)
		                            {
		                               $qrrd3="INSERT INTO `dictionary`( `title`, `term`, `keyy`, `value`) VALUES ('$qtitle','$term','NA/DK/CS',$i+1);";
		                               $dtaa3=$this->MProject->doSqlDML($qrrd3);
		                            }  
		                        }
		                      }  
		                        
		                       $qrt4="INSERT INTO `project_term_map`( `project_id`, `term`) VALUES ($pid,'$term')";
		                       $dta4=$this->MProject->doSqlDML($qrt4);   
                                   }
		                  }
		                 } //end of rating  crosstab---------------------------
		
                       } //end foreach
     		 	$sdata= "Project qset: $qset CrossTab added successfully";
     		}
	               $arrdata['rqpost']='';
                       echo $arrdata['msg']=$sdata;
                       //$this->load->view('samylogin',$arrdata);

	}
        public function addrule()
        {        
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $rt= $this->input->post('rt'); 
                       $qset= $this->input->post('qset');
                       
                        $pn= $this->input->post('pn');
                        $_SESSION['pid']=$pn;
                        $_SESSION['qset']=$qset;

	               $this->load->model('MProject');
                       if($rt!=0 && $qset!=0)  $sdata=$this->MProject->doaddrule($_POST);
                       $msg=" Done";
                       if($sdata==1) $msg="Successfully added rule for Questions";
			$sdata.= "<br><br>Click on  <font clolor=red> <a href='http://13.232.11.235/digiamin-web/siteadmin/user_action/addrule'> Add Rule </a></font> ";
                       $ardata['rqpost']=''; 
                       echo $ardata['msg']=$msg; 
                       $this->load->model('MSausermodel');
                        //$this->load->view('samylogin',$ardata);
	}
        public function editdrule()
        { 
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

                       $rt= $this->input->get('rt'); 
                       $qset= $this->input->get('qset');
                       $sdata='Data not available';
	               $this->load->model('MProject');
                       if($rt!=0 & $qset!=0) $sdata=$this->MProject->doeditrule($qset,$rt);
                       //$arrdata['rqpost']=''; 
                       //$arrdata['msg']=$sdata; 
                       //$this->load->view('samylogin',$arrdata);
                       echo $sdata;
        }
        public function addmedia()
        {        
                        $this->load->view('v_h');
                       echo "<br><br><br><br><br><br> <div style='margin-left:50px;'>";

             //print_r($_POST);
              //$file = $_FILES['mediaf'];
              //$file_n = $_FILES['mediaf']['name'];
              $pid = $this->input->post('pn');
              $qset = $this->input->post('qset');
              $qid = $this->input->post('qs');
              $fn="";$mpath="";
              $mt= $this->input->post('mt'); 

                if($mt == 1){
                   $fn=$qid.".jpg";
                   $mpath="/vcimsweb/uploads/image/$fn";
                   var_dump($mpath);
           	   $config['upload_path'] = $ff= dirname($_SERVER["DOCUMENT_ROOT"])."/htdocs/vcimsweb/uploads/image/";
                   //$config['upload_path'] = $ff= '/digiamin-web/vcimsweb/uploads/image/'; 
                   var_dump($config['upload_path']);
                   $config['allowed_types'] = 'jpg';
                   $config['overwrite'] = TRUE;
                   $config['file_name']= $fn;
		   //$config['max_size']	= '100';
		   //$config['max_width']  = '1024';
		   //$config['max_height']  = '768';
                   //$config['file_name'] = $_FILES['mediaf']['name'];
                }
                if($mt == 2){
                   $fn=$qid.".mp3";
                   $mpath="/vcimsweb/uploads/audio/$fn";
           	   $config['upload_path'] = dirname($_SERVER["DOCUMENT_ROOT"])."/htdocs/vcimsweb/uploads/audio/";
		   $config['allowed_types'] = 'mp3';
                   $config['overwrite'] = TRUE;
                   $config['file_name']= $fn;
                }
                if($mt == 3){
                   $fn=$qid.".mp4";
                   $mpath="/vcimsweb/uploads/video/$fn";
           	   $config['upload_path'] = dirname($_SERVER["DOCUMENT_ROOT"])."/htdocs/vcimsweb/uploads/video/";
		   $config['allowed_types'] = 'mp4';
                   $config['overwrite'] = TRUE;
                   $config['file_name']= $fn;

                }

		$this->load->library('upload', $config);

                
		if ( ! $this->upload->do_upload('mediaf'))
		{
			  $error = array('error' => $this->upload->display_errors());
                            //print_r($error);
			//$this->load->view('upload_form', $error);
			$msg = $this->upload->display_errors();
                       //$msg="Error! File type/size not allowed to upload file for qid: $qid";
                        $ardata['rqpost']=''; 
                        echo $ardata['msg']=$msg;  
                          //$this->load->model('MProject');
                        //$this->load->view('samylogin',$ardata);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
                       
                        $msg="Successfully uploaded Media file for qid: $qid";
                        $ardata['rqpost']=''; 
                        echo $ardata['msg']=$msg; 
                        $this->load->model('MProject');
                         $sql=null;
                         if($mt == 1) $sql="UPDATE question_detail SET image='$mpath' WHERE q_id=$qid";
                         if($mt == 2) $sql="UPDATE question_detail SET audio='$mpath' WHERE q_id=$qid";
                         if($mt == 3) $sql="UPDATE question_detail SET video='$mpath' WHERE q_id=$qid";
                        $rr=$this->MProject->doSqlDML($sql);
                        //$this->load->view('samylogin',$ardata);
			
		}
             

	}    
}





