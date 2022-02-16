<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
  
 	function __construct()
	{
		parent::__construct();
		//$this->load->library(array('session', 'form_validation'));
		//$this->load->model(array('CI_auth', 'CI_menu'));
	      	//$this->load->helper(array('html','form', 'url'));
	}
	public function index()
	{
		$this->load->helper('url');
                  
                $this->load->model('HomeModel');
                $rs['records']=$this->HomeModel->getData();
        
                $this->load->view('HomeView',$rs);  
	}
        public function login()
        { 
                $this->load->helper('url'); 
	        $this->load->helper('form');        
	        $this->load->view('_login_form');       
	}
        public function startup()
        { 
	        $this->load->helper('url'); 
	        $this->load->helper('form');        
	        $this->load->view('startup');
	}
        public function inquiry()
        {       $prdt=$_GET['pt'];
                 $dd['prd']=$prdt; 
                 $dd['msg']=':'; 
	        $this->load->helper('url'); 
	        $this->load->helper('form');        
	        $this->load->view('inquiry_form',$dd);
	}
        public function do_inquiry()
        {       //print_r($_POST);
                $idata['prd']=$idata['pt']=$pt=$_POST['pt'];
                $idata['name']=$nm=$_POST['name'];
                $idata['mobile']=$mob=$_POST['mobile'];
                $idata['email']=$email=$_POST['email'];
                $wt=$_POST['wt'];
                 
                 date_default_timezone_set("Asia/Kolkata");
                 $dt=date("d-m-Y H:i:s");
                 $idata['date']=$dt;
                
                $this->load->model('ProjectModel');
                $arr=array('name'=>$nm,'email'=>$email,'mobile'=>$mob,'work_type'=>$wt,'product'=>$pt,'time'=>$dt,);
                           
                if( $nm=='' || $mob=='' || $email=='')
                {
                     $idata['msg']="Error! All details are not filled. Please try again...";
                }
                else
                {
                    $last_id=$this->ProjectModel->insertIntoTable('inquiry_detail',$arr);
                    $idata['msg']="Thank Your interest!Your Request ID is: $last_id . Consultant from Digiadmin will call you within 48 hrs in working day.";
                }
                  
	        $this->load->helper('url'); 
	        $this->load->helper('form');        
	        $this->load->view('inquiry_form',$idata);
	}
        public function report_itest()
        { 
                $prdt=$_GET['pt'];
                 $dd['prd']=$prdt; 
	        $this->load->helper('url'); 
	        $this->load->helper('form');        
	        $this->load->view('rpt_ideatest',$dd);
        
	}
	public function register()
        {          
	        $this->load->helper('url'); 
	        $this->load->helper('form');
	        $dd['msg']='';        
	        $this->load->view('register_form',$dd);        
	}
	
	public function verify()
        {          
	        $this->load->helper('url'); 
	        $this->load->helper('form');
	        
	          $hash=$this->input->get("h");
	          $this->load->model('UserModel');
	          $mmsg=$this->UserModel->do_verify($hash);
	          if($mmsg)
	          {
	              $dd['msg']='';
	              $dd['uid']=$mmsg;
	          }
	          else
	          {
	             $dd['msg']='Invalid Request';
	             $dd['uid']=$mmsg;    
	          }    
	          $this->load->view('verify_form',$dd);   
	               
	}

	public function do_reg()
        { 
         
	        $this->load->helper('url'); 
	        $this->load->helper('form'); 
	        $useremail=$this->input->post("username");
	        $this->load->model('UserModel');
	        $mmsg=$this->UserModel->do_signup($useremail);
	        $dd['msg']=$mmsg;
	        //$dd['msg']="Please check your email and click on activate button to set password";       
	        $this->load->view('register_form',$dd);
	        
	}
	
	public function setpass()
        { 
         
	        $this->load->helper('url'); 
	        $this->load->helper('form'); 
	        $uid=$this->input->post("user");
	        $npass=$this->input->post("npass");
	        $nrpass=$this->input->post("npassrepeat");
	        $uname=$this->input->post("name");
	        $mobile1=$this->input->post("mobile1");
	        $mobile2=$this->input->post("mobile2");
	
	        if($npass==$nrpass && $uname!='' && $mobile1!='')
	        {
	           $this->load->model('UserModel');
	           $rr=$this->UserModel->do_setpass($uid,$npass,$uname,$mobile1,$mobile2);
	           if($rr)
	             $dd['msg']='Password Set Sucessfully! Please login to continue.';
	        }
	        else
	        {
	          $dd['msg']="Please check your both password not same! Retry";  
	        }     
	        $this->load->view('register_form',$dd);
        
	}
	public function process()
        {
        	$usern=$this->input->post("username");
        	$passd=$this->input->post("password");
                 
                $this->load->model('UserModel');

                $ss=$this->UserModel->login($usern, $passd);

                if($ss)
                {
                  	 $uid=$_SESSION['vwebuserid'];
                         $this->load->model('HomeModel');
                         $data['projects']=$this->HomeModel->get_projects($uid);
        		 $data['records']=$this->HomeModel->getData();
			 $data['rqpost']='';
                         $this->session->set_userdata('isLogin', TRUE);	 
                         $this->session->set_userdata('userid',$uid);
                         
                         $tempuri=$this->session->tempdata('temp');
                         if($tempuri=='')
        		    $this->load->view('mylogin',$data);
                         else
                            redirect($tempuri);
        	 
                }
        	else
        	{
        		$data['error']='Invalid Username/Password';
        		$this->load->view('_login_form',$data);
        	}

        }
        public function logout()
        {
        	 $this->session->unset_userdata('vwebuser');
                 $this->session->sess_destroy();
        	 $this->load->view('_login_form');
        }
        public function neworder()
        {
        	 $uid=$_SESSION['vwebuserid'];
                 $udata['udata']=$uid;
                 $this->load->model('ProjectModel');
                 $udata['pm']=$this->ProjectModel;
        	 $this->load->view('neworder',$udata);
        }
        public function requestprocess()
        {         //print_r($_POST);
        	 $uid=$_SESSION['vwebuserid'];
                 $_SESSION['uid']=$uid;
                 $rqdata['udata']=$uid;
                 $this->load->model('HomeModel');
                 $rqdata['projects']=$this->HomeModel->get_projects($uid);
                 $rqdata['rqpost']='Error! Please try once again';  
                 
                 date_default_timezone_set("Asia/Kolkata");
                 $d=date("d-m-Y H:i:s");
                 $roqdata['rdate']=$d;
                 $roqdata['user_id']=$uid;
                 $email='';
                 $this->load->model('UserModel');
                 $udt=$this->UserModel->getUserDetails($uid);
                  if($udt)
                  foreach($udt as $key=>$ud)
                  { echo "$key = $ud";
                    if($key=='name') $roqdata['cname'] = $ud;
                    if($key=='mobile1')$roqdata['cmobile'] = $ud;
                    if($key=='email')$roqdata['email'] = $email=$ud;
                  }
                 $roqdata['desc'] = $this->input->post('prop');
                 $roqdata['ssize'] = $this->input->post('size');
                  $roqdata['others'] = $this->input->post('others');
                 
                 $roqdata['status'] =1;

                 $arrc=array();
                 foreach($_POST as $key=>$p)
                 { 
                   if($key=='prop' || $key=='size' || $key=='ot' || $key=='others' || $key=='budget' || $key=='name' || $key=='email' || $key=='contact' || $key=='submit'){}
                   else array_push($arrc,$p);
                 }  //print_r($arrc);

                 date_default_timezone_set("Asia/Kolkata");
                 $d=date("d-mm-YY hh:m");
                 
                  $this->load->model('OrderModel');
                  $res = $this->OrderModel->insertRequest($roqdata,$arrc);
                  if($res)$rqdata['rqpost']="Thank Your interest!<br><b><font color=green>Your Request ID is: $res</font></b><br> Consultant from Digiadmin will call you within 48 hrs. We will send you a mail at your registered email id:<b><font color=green> $email </font>with us.";  
        	  $this->load->view('mylogin',$rqdata);
        }
        public function vieworderlist()
        {     
	             $uid=$_SESSION['vwebuserid'];
	             $udata['udata']=$uid;
	             $this->load->model('OrderModel');
	          
	             $olist['ord_data']=$this->OrderModel->getRequests($uid);
	             $this->load->view('requestorderlist',$olist);
             
        }
        public function newpayment()
        {  
        	 $uid=$_SESSION['vwebuserid'];
                 $udata['udata']=$uid;
        	 $this->load->view('newpayment',$udata);
        }
        public function do_pay()
        {
                $uid=$_SESSION['vwebuserid'];
                 $udata['uid']=$uid;
                $tot=$this->input->post("amount");
                $desc=$this->input->post("productinfo");                  
                $udata['amount']=$tot;
                $udata['desc']=$desc;
                $_SESSION['amount']=$tot;
                $_SESSION['productinfo']=$desc;

                $this->load->model('UserModel');
                $rs=$this->UserModel->getUserDetails($uid); 
                foreach($rs as $key=>$r)
                {
                   //echo "<br> $key= $r ";
                    if($key=='name')
                       $udata['name']=$r;
                    if($key=='email')
                       $udata['email']=$r; 
                    if($key=='mobile1')
                       $udata['mobile1']=$r;  
                }  
        		 
                         //$this->session->set_userdata('isLogin', TRUE);	

                $this->load->view('payuform',$udata);

        }
        public function viewpayment()
        {
        	 $uid=$_SESSION['vwebuserid'];
                 $udata['udata']=$uid;
                 $this->load->model('OrderModel');
          
                 $udata['paydetail']=$this->OrderModel->getPaymentDetail($uid);
        	 $this->load->view('viewpayment',$udata);
        }
        public function products()
        {  
        	  //$uid=$_SESSION['vwebuserid'];
                  //$udata['udata']=$uid;
                  $this->load->model('OrderModel');
          
                  $plist['prd_data']=$this->OrderModel->getProducts();
        	  $this->load->view('product_list',$plist);
        }
     
        //for ajax call to get product filter 
        public function filter_product($action=null)
        {     
        	if(!empty($_POST['action'])) {  
		switch($_POST['action']) {
			case "add":
				if(!empty($_POST["quantity"])) {
				       	$this->load->model('OrderModel');          
                  		 	$productByCodes['prd_data']=$this->OrderModel->getProductByCode($_POST["code"]);
  					 //print_r($productByCodes );               
					//$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_POST["code"] . "'");
				     foreach($productByCodes as $productByCode)
				     {
					$itemArray = array($productByCode->code=>array('name'=>$productByCode->name, 'code'=>$productByCode->code, 'quantity'=>$_POST["quantity"], 'price'=>$productByCode->price));
			//print_r($itemArray);		
					if(!empty($_SESSION["cart_item"])) {
						if(in_array($productByCode->code,$_SESSION["cart_item"])) {
							foreach($_SESSION["cart_item"] as $k => $v) {
									if($productByCode->code == $k)
										$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
							}
						} else {
							$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
						}
					} else {
						$_SESSION["cart_item"] = $itemArray;
					}
				     }
				}
			break;
			case "remove":
				if(!empty($_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($_POST["code"] == $k)
								unset($_SESSION["cart_item"][$k]);
							if(empty($_SESSION["cart_item"]))
								unset($_SESSION["cart_item"]);
					}
				}
			break;
			case "empty":
				unset($_SESSION["cart_item"]);
			break;		
		}
		}
		 
        	if(isset($_SESSION["cart_item"]))
        	{
    			$item_total = 0; 
    		?>
    			<table cellpadding="100" cellspacing="10">
			<tbody>
			<tr style="width:90%;" bgcolor=lightgray>
			<th style="width:40%;"><strong>Name</strong></th>
			<th style="width:10%;"><strong>Code</strong></th>
			<th style="width:10%;"><strong>Quantity</strong></th>
			<th style="width:20%;"><strong>Unit Price</strong></th>
			<th style="width:10%;"><strong>Action</strong></th>
			</tr>	
			<?php		
			    foreach ($_SESSION["cart_item"] as $item){
					?>
							<tr>
							<td style="width:40%;"><strong><?php echo $item["name"]; ?></strong></td>
							<td style="width:10%;"><?php echo $item["code"]; ?></td>
							<td style="width:10%;"><?php echo $item["quantity"]; ?></td>
							<td style="width:20%;"><?php echo "INR ".$item["price"]; ?></td>
							<td style="width:10%;"><a onClick="cartAction('remove','<?php echo $item["code"]; ?>')" class="btnRemoveAction cart-action">Remove Item</a></td>
							</tr>
							<?php
			                                  $item_total += ($item["price"]*$item["quantity"]);
                                                          $_SESSION["amount"]= $item_total;
					}
					?>
			
			<tr>
			
			<td colspan="5" align=right style="width:80%;height:40px;"><strong>Total:</strong> <?php echo "INR ".$item_total; ?></td>
			</tr>
			</tbody>
			</table>		
			<?php
    		}
        }
        
        public function checkout()
        {        
        	$tot=0;  
                $tot=$_SESSION['amount']; 
                $udata['amount']=$tot;
                $this->load->view('payuform',$udata);

        	  //$uid=$_SESSION['vwebuserid'];
                  //$udata['udata']=$uid;
                  //$this->load->model('OrderModel');
          
                  //$plist['prd_data']=$this->OrderModel->getProducts();
        	  //$this->load->view('product_list',$plist);
        }
       
        //term & policy
        public function payresponse()
        {
	             $timezone = "Asia/Calcutta";
	             if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		     $dt = date('Y-m-d H:i:s');
	
	             $rsdata['hash']=$this->input->post("hash");
	             $rsdata['key']=$this->input->post("kay");
	             $rsdata['user_id']=$this->input->post("udf1");
	             $rsdata['cname'] =  $this->input->post("firstname");
	             $rsdata['amount'] = $this->input->post("amount");
	             $rsdata['txnid'] = $this->input->post("txnid");
	             $rsdata['productinfo'] = $this->input->post("productinfo");
	             $rsdata['email'] =  $this->input->post("email");
	             $rsdata['phone'] = $this->input->post("phone");
	             $rsdata['status'] = $this->input->post("status");
	        
	             $roqdata['user_id']=$this->input->post("udf1");
	             $roqdata['cname'] =  $this->input->post("firstname");
	             $roqdata['amount'] = $this->input->post("amount");
	             $roqdata['txnid'] = $this->input->post("txnid");
	             $roqdata['productinfo'] = $this->input->post("productinfo");
	             $roqdata['email'] =  $this->input->post("email");
	             $roqdata['phone'] = $this->input->post("phone");
	             $roqdata['time'] = $dt;
	             $roqdata['status'] = $this->input->post("status");
	
	             $this->load->model('OrderModel');
	             $txnd=$this->OrderModel->getOrderIdByTxnid($this->input->post("txnid"));
	
	             if(!$txnd)
	             {
	                $res = $this->OrderModel->addPayRequest($roqdata);
	             }
	             $this->load->view('payu_response',$rsdata);
        }
        
        //term & policy
        public function termpolicy()
        {
           $this->load->view('termpolicy');
        }
        
        //change password
        public function changepass()
        {
	           $uid=$_SESSION['vwebuserid'];
	           $udata['uid']=$uid;
	           $udata['msg']='';
	           $this->load->view('changepassword',$udata);
        }
         
        
        //reset password
        public function resetpass()
        {
	           $mmsg=false;
	           $uid=$_SESSION['vwebuserid'];
	           $udata['uid']=$uid;
	           $pass=$this->input->post("npass");
	           $rpass=$this->input->post("npassrepeat");
	           //$dd['msg']='Error! Both password are not same';
	           if($pass==$rpass)
	           {
		             $this->load->model('UserModel');
		             $mmsg=$this->UserModel->reset_pass($uid,$pass);
		             $dd['msg']='Password Changed Successfully';
	             
	           }
	           else
	           {
		             $dd['msg']='Error! Both password are not same';
	           }      
	             	     $this->load->view('register_form',$dd);
            
        }
//------------------------------------------------------------------------------------------------------------------------------------------
//                                                               -- SiteAdmin --
//------------------------------------------------------------------------------------------------------------------------------------------        
        //for siteadmin
        public function siteadmin()
        {
        	$this->load->helper('url'); 
	        $this->load->helper('form');       
	        $dd['msg']=''; 
	        $this->load->view('sadm_login_form',$dd);
        }
        
         //for siteadmin login procee
        public function sadmlogin()
        {
        	//$this->load->helper('url'); 
	        //$this->load->helper('form');   
	         echo 'Hi';    
	       // $this->load->view('sadm_login_form');
	       
	       $usern=$this->input->post("username");
        	$passd=$this->input->post("password");
                 
                $this->load->model('SAUserModel');

                $ss=$this->SAUserModel->login($usern, $passd);

                if($ss)
                {
                  	 $uid=$_SESSION['sauserid'];
                         $this->load->model('SAUserModel');
                         $role=$this->SAUserModel->getuserrole($uid);
        		 $permission=$this->SAUserModel->getuserpermissionmap($uid);
			 $data['rqpost']=''; $data['msg']='';
                         $this->session->set_userdata('isSALogin', TRUE);	 
                         $this->session->set_userdata('sauserid',$uid);
                         $this->session->set_userdata('sauseridrole',$role);
                         $this->session->set_userdata('permission',$permission);

                         $satempuri=$this->session->tempdata('satemp');
                         if($satempuri=='')
        		    $this->load->view('samylogin',$data);
                         else
                            redirect($satempuri);
        	 
                }
        	else
        	{
        		$data['error']='Invalid/Blocked Username/Password';
        		$this->load->view('sadm_login_form',$data);
        	}
        }

        public function salogout()
        {
        	 $this->session->unset_userdata('sauser');
                 $this->session->sess_destroy();
        	 $this->load->view('sadm_login_form');
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
	           $uid=$_SESSION['sauserid'];
	           $udata['uid']=$uid;
	           $pass=$this->input->post("npass");
	           $rpass=$this->input->post("npassrepeat");
	           //$dd['msg']='Error! Both password are not same';
	           if($pass==$rpass)
	           {
		             $this->load->model('SAUserModel');
		             $mmsg=$this->SAUserModel->reset_pass($uid,$pass);
		             $dd['msg']='Password Changed Successfully';	             
	           }
	           else
	           {
		             $dd['msg']='Error! Both password are not same';
	           }      
	             	     $this->load->view('sadm_login_form',$dd);
            
        }
        //to get project id based qset id
         public function getpqset()
        {     
        	if(!empty($_POST['pn'])) {  $p=$_POST['pn'];
                      $this->load->model('SAUserModel');
                      $pqs=$this->SAUserModel->getPQset($p);
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
                      $this->load->model('ProjectModel');
                      $pqs=$this->ProjectModel->getPQs($p);
      
                      foreach($pqs as $d)
                      { $qid=$d->q_id;$qn=$d->qno; $qt=$d->q_type;
                         echo "<option value='$qid'> $qn / $qid -- $qt </option>";
                      }  
                       
                }
        }
        public function getpqop()
        {     
        	if(!empty($_POST['pqid'])) 
                {     $nctr=0;
                      echo "<table><tr bgcolor=lightgray><td width=50px>SN.</td><td>OPTION</td><td>CODE</td><td width=80px>CHECK</td><td>FLOW</td></tr>";
                      $p=$_POST['pqid'];
                      $this->load->model('ProjectModel');
                      $pqs=$this->ProjectModel->getPQop($p);
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
                      $this->load->model('ProjectModel');
                      $qt=$this->ProjectModel->getQType($qid);
                      $pqs=$this->ProjectModel->getPQop($qid);
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
             
             if($name==''|| $email=='' || $ph=='' || $msg=='')
             {
                 echo "Error! Fill all required details & try again.";
             }
             else
             {
                 $t='contact.vcims@gmail.com';
                 $fem=$email;
                 $s="Varenia website query  -- ".$email;
                 $m=$msg;
                 $info="<br><br><Query Sender:-<br>Name : ".$name."<br>Email : ".$email."<br>Phone : ".$ph."<br>Message: ".$msg."<br><br> From, <br>Digiadmin Website";
                 $msg.='<br><u> Hi, <br><br> Query Sender Details:</u><br>'.$info;   
                 
                 $headers  = 'MIME-Version: 1.0' . "\r\n";
                 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 $headers .= "From: info@digiadmin.quantumcs.com" . "\r\n" .'Reply-To: contact.vcims@gmail.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

                 mail($t, $s, nl2br($msg), $headers);
                 echo "Your message sent successfully";
             }
        }
         //for ajax call to get product filter 
        public function user_action($action=null)
        {     
        	if(!empty($_POST['action'])) {  
		switch($_POST['action']) {
			case "usradd":
				//echo $_POST['action'];  $data['msg']=''; print_r($_SESSION);print_r($_REQUEST);
                                $tempu= base_url(uri_string());  
                      $this->session->set_tempdata('ptemp',$tempu);
                         ?>                             
			                
					<?php echo form_open('welcome/saverify');?>
			                <tr><td>User Id </td><td><input type="email" name="email" placeholder="Enter your email"></td></tr>
			                <br><tr><td>Password </td><td><input type="password" name="pwd" placeholder="Enter your password"></td></tr> 
                                        <tr><td>User Name</td> <td><input type="text" name="name" placeholder="Enter your full name"> </td> </tr> 
                                        <tr><td>Mobile</td> <td><input type="text" name="mobile" placeholder="Enter your mobile"> </td> </tr>
               
			                <tr><td>Role </td><td> <select name="role"><option value="0">--Select--</option><option value="1">Super Admin</option><option value="2">Admin</option><option value="3">Team User</option><option value="4">Client User</option> </select></td></tr>  
                                        
                                                   
			               <br><br> <tr><td></td><td><input type="submit" name="nu_submit"></td></tr>
			                 
			        
			        <?php echo form_close(); ?>
			        <?php
			break;
			case "usredit":
				echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;
			case "usrview":
				echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;
			case "usrremove":
				echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;
			
                        case "prmadd":
				echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;
			case "prmassign":
				//echo $_POST['action']; 
				$this->load->model('SAUserModel');
                         	$prms=$this->SAUserModel->getpermissions();
                         	$usrs=$this->SAUserModel->getUsers();  
				?>
				
				<?php echo form_open('welcome/prmassign');?>
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
                        case "prmrevoke":
				echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;	
                        case "prmview":
				echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p>hh	
				
				<?php echo form_close(); ?>
		<?php
			break;
			
			case "addtab":
				echo $_POST['action'];
			?>
				
				<?php echo form_open('welcome/addtab');?>
                                <p> 	
				  <tr><td>Tab Company</td><td> <input type=text name=tab_company> </td></tr>
				  <tr><td>Tab Name</td><td> <input type=text name=tab_name> </td></tr>
				  <tr><td>Tab IMEI-1</td><td> <input type=text name=tab_imei_1> </td></tr>
				  <tr><td>Tab IMEI-2</td><td> <input type=text name=tab_imei_2> </td></tr>
				  <tr><td>Tab Email</td><td> <input type=email name=tab_email> </td></tr>
				  <tr><td>Tab SIM Provider</td><td> <input type=text name=tab_sim_p> </td></tr>
				  <tr><td>Tab SIM No</td><td> <input type=text name=tab_sim> </td></tr>
				  <tr><td>Tab Mobile</td><td> <input type=text name=tab_mob maxlength=10> </td></tr>
				  <tr><td>Tab charger Name</td><td> <input type=text name=tab_charger_name> </td></tr>
				
				
				  <tr><td></td><td colspan=2><input type=submit name="save" value=Save></td></tr>
				  
				</p>
				<?php echo form_close(); ?>
		<?php	
			break;
			case "issuetab":
				//echo $_POST['action'];
				$this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				$intvwrs=$this->TabletModel->getInterviewerDetails();
				$projects=$this->TabletModel->getProjects();
				?>
				
				<?php echo form_open('welcome/issuetab');?>
                                <p>	
					<tr><td>Tablet Name</td><td> <select name=tab_id><option value=0>--Select--</option><?php  foreach($tabs as $rd){ ?><option value=<?php echo $rd->tab_id; ?>><?php echo $rd->tab_name; ?></option><?php } ?> </select> </td></tr>
					  <tr><td>Interviewer </td><td> <select name=i_id><option value=0>--Select--</option><?php  foreach($intvwrs as $rd){ ?><option value=<?php echo $rd->i_id; ?>><?php echo $rd->i_name .' - '.$rd->i_mobile; ?></option><?php } ?> </select> </td></tr>
					  <tr><td>Project Name</td><td> <select name=p_id> <option value=0>--Select--</option><?php foreach($projects as $rd){ ?><option value=<?php echo $rd->project_id; ?>><?php echo $rd->name; ?></option><?php } ?> </select> </td></tr>
					  <tr><td>Survey Location/Area</td><td> <input type=text name=wlocation> </td></tr>
					  <tr><td>Tab Issue By</td><td> <input type=text name=tab_issue_by> </td></tr>
					  <tr><td>Tab Issue Date</td><td> <input type=date name=tab_issue_date> </td></tr>
					  <tr><td>Tab With Charger</td><td><select name=tab_charger><option value=no>No</option> <option value=yes>Yes</option></select> </td></tr>
					
					
					  <tr><td></td><td colspan=2><input type=submit name="ta_save" value=Save></td></tr>
					  
				</p>
				<?php echo form_close(); ?>
		<?php
			break;
			case "receivetab":
				//echo $_POST['action'];
				$this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				$intvwrs=$this->TabletModel->getInterviewerDetails();
				$projects=$this->TabletModel->getProjects();
				?>
				
				<?php echo form_open('welcome/receivetab');?>
                                <p> 	
				 		<tr><td>Tablet Name</td><td> <select name=tab_id><option value=0>--Select--</option><?php foreach($tabs as $rd){ ?><option value=<?php echo $rd->tab_id; ?>><?php echo $rd->tab_name; ?></option><?php } ?> </select> </td></tr>
						  <tr><td>Interviewer </td><td> <select name=i_id><option value=0>--Select--</option>
						  
						  <?php  foreach($intvwrs as $rd){ ?>
						  <option value=<?php echo $rd->i_id; ?>><?php echo $rd->i_name .' - '.$rd->i_mobile; ?></option>
						<?php } ?> 
						</select> </td></tr>
						  <tr><td>Project Name</td><td> <select name=p_id> <option value=0>--Select--</option><?php foreach($projects as $rd){ ?><option value=<?php echo $rd->project_id; ?>><?php echo $rd->name; ?></option><?php } ?> </select> </td></tr>
						  <tr><td>Tab Received By</td><td> <input type=text name=tab_receive_by> </td></tr>
						  <tr><td>Tab Receive Date</td><td> <input type="date" name=tab_receive_date> </td></tr>
						  <tr><td>Tab With Charger</td><td><select name=tab_charger><option value=no>No</option> <option value=yes>Yes</option></select> </td></tr>
						
						
						  <tr><td></td><td colspan=2><input type=submit name="tr_save" value=Save></td></tr>
						  
				<?php echo form_close(); ?>
		<?php
			break;
			case "addinterv":
				  //echo $_POST['action'];
				?>
				  
				<?php echo form_open('welcome/addtab');?>
                                <p> 	
					 <tr><td>Interviewer Name</td><td> <input type=text name=in> </td></tr>
					  <tr><td>Mobile 1</td><td> <input type=text name=im1 maxlength=10> </td></tr>
					  <tr><td>Mobile 2</td><td> <input type=text name=im2 maxlength=10> </td></tr>
					  <tr><td>Email</td><td> <input type=text name=ie> </td></tr>
					  <tr><td>Address</td><td> <input type=text name=ia> </td></tr>
					  
					  <tr><td></td><td colspan=2><input type=submit name="inr_save" value=Save></td></tr>
					
				</p>
				<?php echo form_close(); ?>
		<?php
			break;
			case "tabreport":
				//echo $_POST['action'];
				?>
				
				<?php echo form_open('welcome/tabreport');?>
                                <p> 
                                <tr><td>Report Type </td><td><select name="trp" id="trp"><option value="0">--Select--</option><option value="1"> All </option><option value="2"> Not Received </option><option value="3"> Available to Allocate </option></select></tr>
				<tr><td></td><td><input type="submit" name="trp_report" value=View> </td></tr>

                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
			case "tabprm":
				$this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				$intvwrs=$this->TabletModel->getInterviewerDetails();
				$projects=$this->TabletModel->getProjects();
				?>
				
				<?php echo form_open('welcome/tabprm');?>
                                <p>	
				<tr><td>Project </td><td><select name="pid" id="pid"><option value="0">--Select--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>

                                <tr><td>Tablets </td><td><select name="tab" id="tab" ><option value="0">--Select--</option><?php foreach($tabs as $p){?><option value="<?php echo $p->tab_id; ?>"> <?php echo $p->tab_name;  ?></option> <?php } ?></select></tr>

                                <tr><td>Permission </td><td><select name=per><option value="0">--Select--</option><option value=1>Allow</option><option value=0>Not allow</option></select></td></tr>

                                <tr><td></td><td><input type=submit name=submit value=Save> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
			case "rgtrresp":
				$this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				$intvwrs=$this->TabletModel->getInterviewerDetails();
				$projects=$this->TabletModel->getProjects();
				?>
				
				<?php echo form_open('welcome/rgtrresp');?>
                                <p>	
				    <tr><td>Project </td><td><select name="pid" id="pid"><option value="0">--Select--</option><?php foreach($projects as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
                                     <tr><td></td><td><input type=text name=mob placeholder="Enter 10 digit number"> </td></tr>
                                     <tr><td></td><td><input type=submit name=pr_mob value=Submit> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
			case "reporttabpermission":
				$this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				$intvwrs=$this->TabletModel->getInterviewerDetails();
				$projects=$this->TabletModel->getProjects();
				?>
				
				<?php echo form_open('welcome/reporttabpermission');?>
                                <p>	
				   <tr><td>Project </td><td><select name="pid" id="pid"><option value="0">--Select--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
                                  <tr><td></td><td><input type=submit name=ta_report value=View> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                case "projectdata":
				//echo $_POST['action'];
                                $this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				 
				$projects=$this->TabletModel->getProjects();
				?>
				
				<?php echo form_open('welcome/projectdata', array('target'=>'_blank', 'id'=>'myform'));?>
                                <p>	
				       Project Name:   <select name="pn" id="pn"  onchange="getpqset();"><option value="0">--Select--</option><?php  foreach($projects as $p){?><option value="<?php echo $p->project_id;?>"><?php echo $p->name;?></option><?php }?></select><br>
                                       QuestionSet ID:  <select name="qset" id="qset"><option value="select">--Select--</option> </select> <br>
                                       Is Date Filter </td><td><input type=checkbox name="isd" id="isd"> <br>
                                       Date Range </td><td><input type=date name="sdt" id="sdt"> To <input type=date name="edt" id="edt"><br>
                                       <input type=submit name=submit value="View"></td><br>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdureport":
				$this->load->model('TabletModel');
				$tabs=$this->TabletModel->getTabs();
				?>
				
				<?php echo form_open('welcome/mdureport');?>
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
				
				<?php echo form_open('welcome/mdusreport');?>
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
				
				<?php echo form_open('welcome/mdssreport');?>
                                <p> 
                                <tr><td>Month : </td><td><select name=mn id=mn><option value=1>Jan </option><option value=2>Feb </option><option value=3>Mar </option><option value=4>Apr </option><option value=5>May </option><option value=6>Jun </option><option value=7>Jul </option><option value=8>Aug </option><option value=9>Sep </option><option value=10>Oct </option><option value=11>Nov </option><option value=12>Dec </option> </select>
                                  </td><td><input type=submit name=sreport value=View> </td></tr>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdmbreport":
				 
				?>
				
				<?php echo form_open('welcome/mdmbreport');?>
                                <p>
                                   <tr><td>Month : </td><td><select name=mn id=mn><option value=0>--Select-- </option><option value=1>Jan</option><option value=2>Feb</option><option value=3>Mar</option><option value=4>Apr</option><option value=5>May</option><option value=6>Jun</option><option value=7>Jul</option><option value=8>Aug</option><option value=9>Sep</option><option value=10>Oct</option><option value=11>Nov </option><option value=12>Dec</option> </select></td></tr>
                                  <tr><td>Year : </td><td><select name=yrs id=yrs><option value=2016>2016</option><option value=2017>2017</option><option value=2018>2018</option></select></td></tr>
                                  <tr><td></td><td><input type=submit name=submit value="View"></td></tr>	
				</p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "mdbsreport":
				 $this->load->model('TabletModel');
                                 $booths=$this->TabletModel->getDataBySql("select distinct resp_id from UMEED2_40 order by resp_id");
 
				?>
				
				<?php echo form_open('welcome/mdbsreport');?>
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
				
				<?php echo form_open('welcome/mdudclean');?>
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
                        case "crosstab":
				
                                  $this->load->model('TabletModel');
				
				$projects=$this->TabletModel->getProjects();

				?>
				<center><br><br><h2><font color=red>Cross Tab Reporting Tool</font></h2></center>
            <center>
				<?php echo form_open('welcome/crosstab');?>
                                <p>	
				
<tr><td></td><td><input type="reset" value="Reset All">  <input type="submit" name="exportall" value="Export All-Y"> <input type="submit" name="showall" value="Show All-Y"></td></tr>
            <tr><td>Month</td><td> <select name=month id=month><option value=0>--Select--</option><option value=1>JAN</option><option value=2>FEB</option><option value=3>MAR</option><option value=4>APR</option><option value=5>MAY</option><option value=6>JUN</option><option value=7>JUL</option><option value=8>AUG</option><option value=9>SEP</option><option value=10>OCT</option><option value=11>NOV</option><option value=12>DEC</option></select></td></tr>
            <tr><td>Project </td><td><select name="project" id="project" onclick="getpqset()"><option value="0">--Select--</option><?php foreach($projects as $p){?><option value="<?php echo $p->project_id; ?>"> <?php echo $p->name;  ?></option> <?php } ?></select></tr>
            <tr><td>Scale </td><td><select name='measure' id="measure"><option value="tot">Total Count</option><option value="totp">Table %</option><option value="rowp">Row %</option><option value="colp">Column %</option></select> </td></tr>

            <tr><td><div style="vertical-align: top;text-align: center;display: table-cell;" >X-Axis</div> </td><td><textarea rows="2" cols="30" name="xv" id="x" readonly>   </textarea></td><td> <div style="vertical-align: top;text-align: center;display: table-cell;" > <input type="button" id="bxa" value="Reset X"> </div> </td></tr>

            <tr><td ><div style="vertical-align: top;text-align: center;display: table-cell;" >Y-Axis </div> </td><td><textarea rows="2" cols="30" name="yv"  id="y" readonly>  </textarea></td><td><div style="vertical-align: top;text-align: center;display: table-cell;" > <input type="button" id="bya" value="Reset Y"></div></td></tr>
            <tr><td> <div style="vertical-align: top;text-align: center;display: table-cell;" >Filter </div></td><td><textarea rows="2" cols="30"name="fv" id="f" readonly>  </textarea></td><td><div style="vertical-align: top;text-align: center;display: table-cell;" > <input type="button" id="bfa" value="Reset Filter"> </div> </td></tr>
              
              <tr><td></td><td><input type="submit" name="show" value="Show" color="green" style="background-color:lightgreen"></td></tr>
            </table>
            <!--<button>Hide/Show</button> Grid Parameters<br><br> -->
            </center>
              <br><br>  
             <div id="d1" name="d1"> 
                 <font color=red><i>Select project for CrossTab options</i></font>
            </div>

            <center><br><br><input type="submit" name="show" value="Show" style="background-color:lightgreen"></center><br><br>
                                </p>
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewproject":
                                $this->load->helper('url');
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewproject();
				?>
				
				<?php echo form_open('welcome/viewproject'); 
                                      echo $str;

                                ?>
                                 				
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewqb":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewqb();
				?>
				
				<?php echo form_open('welcome/viewqp'); 
                                      echo $str;

                                ?>
                                 				
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewquestion":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewquestion();
				?>
				
				<?php echo form_open('welcome/viewquestion'); 
                                      echo $str;

                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewquestionop":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewquestionop();
				?>
				
				<?php echo form_open('welcome/viewquestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewsequence":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewsequence();
				?>
				
				<?php echo form_open('welcome/viewsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "updatesequence":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getupdatesequence();
				?>
				
				<?php echo form_open('welcome/updatesequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewroutine":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewroutine();
				?>
				
				<?php echo form_open('welcome/viewroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewpcentre":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewpcentre();
				?>
				
				<?php echo form_open('welcome/viewpcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewpproduct":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewpproduct();
				?>
				
				<?php echo form_open('welcome/viewpproduct'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "viewpsec":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getviewpsec();
				?>
				
				<?php echo form_open('welcome/viewpsec'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editproject":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditproject();
				?>
				
				<?php echo form_open('welcome/editproject'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editquestion":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditquestion();
				?>
				
				<?php echo form_open('welcome/editquestion'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editquestionop":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditquestionop();
				?>
				
				<?php echo form_open('welcome/editquestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editsequence":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditsequence();
				?>
				
				<?php echo form_open('welcome/editsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editroutine":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditroutine();
				?>
				
				<?php echo form_open('welcome/editroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editpcentre":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditpcentre();
				?>
				
				<?php echo form_open('welcome/editpcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "editrule":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->geteditrule();
                                echo $str;
				?>
				
				<?php echo form_open('welcome/viewrule');?>
                                <p>	
				<?php echo form_close(); ?>
		<?php
			break;
                        
                        
                        case "createqbcat":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcreateqbcat();
				?>
				
				<?php //echo form_open('welcome/createqbcat'); 
                                      echo $str;
                                ?>			
				 
		<?php
			break;
                        case "createproject":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcreateproject();
				?>
				
				<?php echo form_open('welcome/createproject'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "createqset":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcreateqset();
				?>
				
				<?php echo form_open('welcome/createqset'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "createquestion":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcreatequestion();
				?>
				
				<?php echo form_open('welcome/createquestion'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "createsequence":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcreatesequence();
				?>
				
				<?php echo form_open('welcome/createsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "createroutine":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcreateroutine();
				?>
				
				<?php echo form_open('welcome/createroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addqbquest":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddqbquest();
				?>
				
				<?php echo form_open('welcome/addqbquest'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addqop":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddqop();
				?>
				
				<?php echo form_open('welcome/addqop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addcentre":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddcentre();
				?>
				
				<?php echo form_open('welcome/addcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addpcentre":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddpcentre();
				?>
				
				<?php echo form_open('welcome/addpcentre'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addrule":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddrule();
				?>
				
				<?php echo form_open('welcome/addrule'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addpproduct":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddpproduct();
				?>
				
				<?php echo form_open('welcome/addpproduct'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addpstore":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddpstore();
				?>
				
				<?php echo form_open('welcome/addpstore'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addpsec":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddpsec();
				?>
				
				<?php echo form_open('welcome/addpsec'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addpage":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddpage();
				?>
				
				<?php echo form_open('welcome/addpage'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addsequence":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddsequence();
				?>
				
				<?php echo form_open('welcome/addsequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addtransq":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddtransq();
				?>				
				<?php echo form_open('welcome/addtransq'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addtransqop":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddtransqop();
				?>				
				<?php echo form_open('welcome/addtransqop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "addpcrosstab":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getaddpcrosstab();
				?>				
				<?php echo form_open('welcome/addpcrosstab'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;

                        case "copyqbquest":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcopyqbquest();
				?>				
				<?php echo form_open('welcome/copyqbquest'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break; 
                        case "copyquestionop":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getcopypquest();
				?>
				
				<?php echo form_open('welcome/copyquestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "deletesequence":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getdeletesequence();
				?>
				
				<?php echo form_open('welcome/deletesequence'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                         case "deleteroutine":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getdeleteroutine();
				?>
				
				<?php echo form_open('welcome/deleteroutine'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "deletequestion":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getdeletequestion();
				?>
				
				<?php echo form_open('welcome/deletequestion'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
                        case "deletequestionop":
				$this->load->model('ProjectModel');
				$str=$this->ProjectModel->getdeletequestionop();
				?>
				
				<?php echo form_open('welcome/deletequestionop'); 
                                      echo $str;
                                ?>			
				<?php echo form_close(); ?>
		<?php
			break;
		}

		}
	
        }
        public function saverify()
        {  
	              $email= $this->input->post('email'); 
	              $pwd= $this->input->post('pwd');
	              $role= $this->input->post('role');
                      $name= $this->input->post('name');
	              $mobile= $this->input->post('mobile');
                      //$tempu= base_url(uri_string());  
                      //$this->session->set_tempdata('ptemp',$tempu);

	               if($email!='' && $pwd!='' && $role!='0')
	               {
           		 
           		 $uid=$_SESSION['sauserid'];
                         $this->load->model('SAUserModel');
                         $nu=$this->SAUserModel->create_sauser($email,$pwd,$name,$mobile,$role);
                         if($nu)
                         {
                            $data['role']=$this->SAUserModel->getuserrole($uid);
        		    $data['permission']=$this->SAUserModel->getuserpermissionmap($uid);
                            $data['msg']="Successfully add new user as $email";
                         }
			 $data['rqpost']='';
		      }
		      else
		      {
		      	 $data['msg']=''; $data['rqpost']='';
		      }
                         $this->load->view('samylogin',$data);
        }
        public function prmassign()
        {  
	              $uid= $this->input->post('uid'); 
	              $prms= $this->input->post('prms');
	              
	               //print_r($prms);
                       $tempu= base_url(uri_string());  
                       $this->session->set_tempdata('ptemp',$tempu);

	               if($uid!='' && !empty($prms))
	               {
	               		foreach($prms as $prm)
	               		{
           		              $udata=array("user_id"=>$uid,"prm_id"=>$prm,"status"=>1);  
           		 		// $uid=$_SESSION['sauserid'];
                         		$this->load->model('SAUserModel');
                         		if(!$this->SAUserModel->isuserpermissionmap($uid,$prm))
                         		{
                         		 	$nu=$this->SAUserModel->adduserpermissionmap($udata);
			 			$data['rqpost']='';
			 			$data['msg']="Successfully Permission Assign to userid: $uid";
			 		}
			 		else
			 		{	$data['rqpost']='';
			 			$data['msg']="Successfully Permission Assign to userid: $uid";
			 		}
			 	}
		      }
		      else
		      {
		      	 $data['msg']=''; $data['rqpost']='';
		      }
                         $this->load->view('samylogin',$data);
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
                         $this->load->model('TabletModel');
                         if(!$this->TabletModel->isTab($temail))
                         	$d=$this->TabletModel->addtab( array('tab_name'=>$tname,'tab_company'=>$tcomp,'tab_imei_1'=>$tim1,'tab_imei_1'=>$tim2,'tab_email'=>$temail,'sim_sp'=>$tsp,'tab_sim_no'=>$tsn,'tab_mobile'=>$tmobile,'tab_charger'=>$tch,'tab_charger_status'=>'1','tab_status'=>'1') );

			$data['rqpost']='';
                     if($d)
                         $data['msg']='Successfully Added Tablet';
                     else
                     {
                         $data['msg']='Error while added tablet'; $data['rqpost']='';
                     }
                         
                         $this->load->view('samylogin',$data);
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
                       $this->load->model('TabletModel');
                         
                            if($this->TabletModel->isTabIssuedOnce($tid))
                            {  
                                if($this->TabletModel->isTabReceived($tid))
                                {
                         	  $d=$this->TabletModel->updateIssueTab($tid,$uarr);
                                  $data['msg']="Successful allocation for Tab Id: $tid ";
                                }
                                else
                                {
                                    $data['msg']='Warning! This Tab Is Already Issued. Update Tab received process first';
                                }

                            }
                            else
                            {
                                $d=$this->TabletModel->issueTab($iarr);
                                $data['msg']="Successful first allocation for Tab Id: $tid ";
                            }
                      
                    }
                    else
                    {
                       $data['msg']="Fill all details";
                    }
                     $this->load->view('samylogin',$data);
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
                       $this->load->model('TabletModel');
                        
                            if($this->TabletModel->isTabIssued($tid))
                            {  
                                if(!$this->TabletModel->isTabReceived($tid))
                                {
                         	  $d=$this->TabletModel->updateIssueTab($tid,$uarr);
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
                      $this->load->view('samylogin',$data);   


	} 
	public function tabreport()
        {      
                      $trp= $this->input->post('trp'); 
                       $sdata='';
                       
	               $this->load->model('TabletModel');
	            
                      if($trp==1)
                      {  
                           $data=$this->TabletModel->getTabIssueDetails();
                           $sdata='<center><h5>Tablet Allocation Report</h5><table border=1>';
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
	                      $this->load->model('TabletModel');
	                      $pn=$this->TabletModel->get_project_name($pid);
	                      $ipn=$this->TabletModel->get_tablet_receiver($i_id);

                              $s="<tr><td>$tab</td><td> $pn</td><td>$ipn</td><td>$idt</td><td>$icbyn</td><td>$wl</td><td>$rdt</td><td>$rcbyn</td><td>$rby</td><td>$str </td></tr>";
                               $sdata.=$s;
                           }
                           $sdata.='</table>';
                      }
	              if($trp==2)
                      {  
                           $data=$this->TabletModel->getTabNotReceived();
                           
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
	                      $this->load->model('TabletModel');
	                      $pn=$this->TabletModel->get_project_name($pid);
	                      $ipn=$this->TabletModel->get_tablet_receiver($i_id);

                              $s="<tr><td>$tab</td><td> $pn</td><td>$ipn</td><td>$idt</td><td>$icbyn</td><td>$wl</td><td>$rdt</td><td>$rcbyn</td><td>$rby</td><td>$str </td></tr>";
                               $sdata.=$s;
                           }
                           $sdata.='</table>';

                      }
                      if($trp==3)
                      {  
                           $data=$this->TabletModel->getTabToIssue(); 
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
                      
                      $arrdata['msg']=$sdata;
                      $this->load->view('samylogin',$arrdata);   

	}

        public function tabprm()
        { 
                       $pid= $this->input->post('pid'); 
                       $tab= $this->input->post('tab');
                       $per= $this->input->post('per');
                       $updata=array("status"=>$per);
                       $indata=array("project_id"=>$pid,"tab_id"=>$tab,"status"=>1);         
	               $this->load->model('TabletModel');
                       $rrp=$this->TabletModel->isProjectTabPermission($pid,$tab);
                       if($rrp)
                       {
                            $rrp=$this->TabletModel->updateRgtrResp($updata,$pid);
                            $data['msg']="Successfully permission changed to tablet id:$tab";
                       }
                       else
                       {
                            $rrp=$this->TabletModel->rgtrResp($indata,$pid);
                            $data['msg']="Successfully added permission to tablet id:$tab";
                       }
                       $data['rqpost']='';
                       $this->load->view('samylogin',$data); 
                      
        }
        public function rgtrresp()
        { 
                       $pid= $this->input->post('pid'); 
                       $mob= $this->input->post('mob');
                       $rarr=array("project_id"=>$pid,"mobile"=>$mob,"status"=>1);
                       $data['rqpost']='';
                       $data['msg']="Failure! Registered for project id : $pid not done";
	               $this->load->model('TabletModel');
                       $rrp=$this->TabletModel->isProjectMobPermission($pid,$mob);
                       if(!$rrp)
                       {
                          $rsp=$this->TabletModel->rgtrResp($rarr);
                          if($rsp)
                          {
                             $data['msg']="Successfully! Registered for project id : $pid";
                          }
                          else
                          {
                             $data['msg']="Failure! Registered for project id : $pid not done";
                          }
                       }
                       $this->load->view('samylogin',$data); 
                      
        }
        public function reporttabpermission()
        { 
                       $pid= $this->input->post('pid'); 
                       $sdata='';
                       
	               $this->load->model('TabletModel');
                       $data=$this->TabletModel->getReportTabPermission($pid);
                       $sdata='<center><h5>Tablet Allocation Report</h5><table border=1>';
                           $a='<tr><td>S.N.</td><td> Project</td><td>Tab_Id</td><td>Key</td><td>Status</td></tr>';
                           $sdata.=$a;
                           $i=0;
                           foreach($data as $r)
                           {
                               $tab=$r->tab_id;$pid=$r->project_id;$m=$r->mobile;$s=$r->status; $i++;
                               $str="Not Allowed"; if($s==1)$str="Allowed";
	                   
                              $s="<tr><td>$i</td><td> $pid</td><td>$tab</td><td>$m</td><td>$str </td></tr>";
                               $sdata.=$s;
                           }
                          $sdata.='</table>';

                      
                      
                      $arrdata['rqpost']='';
                      
                      $arrdata['msg']=$sdata;
                      $this->load->view('samylogin',$arrdata); 
        }
        public function projectdata()
        { 
                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $isd= $this->input->post('isd');
                       
                       $sdt=$this->input->post('sdt');
                       $edt=$this->input->post('edt');
                       
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
	               $this->load->model('TabletModel');
                       $data=$this->TabletModel->getProjectData($pid,$qset,$isd,$sdt,$edt);         
        }

        public function mdusreport()
        { 
                       $m= $this->input->post('mn'); 
                       $this->load->model('TabletModel');
                       $sdata=$this->TabletModel->mdusreport($m);
                       $arrdata['rqpost']='';
                      $arrdata['msg']=$sdata;
                      $this->load->view('samylogin',$arrdata); 
        }
        public function mdssreport()
        { 
                       $m= $this->input->post('mn'); 
                       $this->load->model('TabletModel');
                       $sdata=$this->TabletModel->mdssreport($m);
                       $arrdata['rqpost']='';
                      $arrdata['msg']=$sdata;
                      $this->load->view('samylogin',$arrdata); 
        }
        public function mdureport()
        { 
                       $st= $this->input->post('st');
                       $et= $this->input->post('et');
                       $tab= $this->input->post('tab'); 

                       $this->load->model('TabletModel');
                       $sdata=$this->TabletModel->mdureport($st,$et,$tab);
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata); 
        }
        
        public function mdmbreport()
        { 
                       $mn= $this->input->post('mn');
                       $yrs= $this->input->post('yrs');
                        
                       $this->load->model('TabletModel');
                       $sdata=$this->TabletModel->mdmbreport($mn,$yrs);
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
                       $this->load->model('TabletModel');
                       $sdata=$this->TabletModel->mdbsreport($mn,$yrs,$gn,$bid);
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata); 
        }
        public function mdudclean()
        { 
                       $mn= $this->input->post('mn');
                       $bid= $this->input->post('bid');
                       $frid= $this->input->post('frid');
                       $toid= $this->input->post('toid');
 
                       $this->load->model('TabletModel');
                       $sdata=$this->TabletModel->mdudclean($mn,$bid,$frid,$toid);
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata); 
        }
        public function crosstab()
        { 
                       $mn= $this->input->post('mn');
                       
           
        }
	public function viewproject()
        {      
                     echo $pid= $this->input->post('pid'); 
	        
                       $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getProjectDetail($pid);

                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);        
	              
	}
        public function viewqb()
        {      
                      echo $pid= $this->input->post('pid'); 
	               
	              
	}
        public function viewquestion()
        {      
                       $qset= $this->input->post('qset'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getQuestionDetail($qset);

                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);        
	              
	}
        public function viewquestionop()
        {      
                       $qset= $this->input->post('qset'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getQuestionOpDetail($qset);

                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	                             
	}
        public function viewsequence()
        {      
                       $qset= $this->input->post('qset'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getSequenceDetail($qset);

                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function viewroutine()
        {      
                       $qset= $this->input->post('qset'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getRoutineDetail($qset);

                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata); 
	}
        public function viewpcentre()
        {      
                       $qset= $this->input->post('qset'); 
                       $rt= $this->input->post('rt');

	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getPCentreDetail($qset,$rt);
                       
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata); 
	}
        public function editproject()
        {      
                       $pid= $this->input->post('pn'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getEditProjectDetail($pid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function editquestion()
        {      
                       $pid= $this->input->post('pn'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getEditQuestionDetail($pid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function editquestionop()
        {      
                       $qs= $this->input->post('qs'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getEditQuestionOPDetail($qs);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function editsequence()
        {      
                       $pid= $this->input->post('pn'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getEditSequenceDetail($pid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function editroutine()
        {      
                       $pid= $this->input->post('pn'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getEditRoutineDetail($pid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function editpcentre()
        {      
                       $pid= $this->input->post('pn'); 
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->getEditCentreDetail($pid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function updatesequence()
        {       
                       $pid= $this->input->post('qset'); 
                       $ssid= $this->input->post('ssid'); 
                       $esid= $this->input->post('esid');
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->doUpdateSequence($pid,$ssid,$esid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        
        public function updateproject($action)
        {              //$pid= $this->input->get('pid');  
                       //echo $action;
                       if($action=='actionproject')
                       {
                         $pid= $this->input->get('pid');$pn= $this->input->get('pn'); $sdt= $this->input->get('sdt');
                         $edt= $this->input->get('edt'); $cn= $this->input->get('cn');$b= $this->input->get('b');
                         $v= $this->input->get('v');$rt= $this->input->get('rt');$rp= $this->input->get('rp');
                         $bk= $this->input->get('bk');
                         $rt= $this->input->get('rt');$ss= $this->input->get('ss');$st= $this->input->get('st');
                         $arr=array('name'=>$pn,'company_name'=>$cn,'brand'=>$b,'background'=>$bk,'sample_size'=>$ss,'research_type'=>$rt,'tot_visit'=>$v,'survey_start_date'=>$sdt,'survey_end_date'=>$edt,'reward_point'=>$rp,'status'=>$st);

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doProjectUpdate($pid,$arr);
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
                         $arr=array('q_title'=>$title,'qno'=>$qno,'q_type'=>$qt);

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doQuestionUpdate($qid,$arr);
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
                         $arr=array('opt_text_value'=>$txt,'value'=>$val, 'term'=>$term);
                         $rd='';
	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doQuestionOPUpdate($id,$arr);
                         if($rd)
                            echo "Qid $qid OP $val Updated Successfully";
                          else 
                            echo "Qid $qid OP Not Updated Successfully";
                         
                       }
                       if($action=='actionsequence')
                       {
                         $qset= $this->input->get('qset');
                         $id= $this->input->get('id');
	                 $qid= $this->input->get('qid');
                         $sid= $this->input->get('sid');
                         $flag= $this->input->get('flag');
                         $where=array('qid'=>$qid,'qset_id'=>$qset); 
                         $arr=array('sid'=>$sid,'chkflag'=>$flag);
                         $rd='';
	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doSequenceUpdate($id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                         
                       }
                       if($action=='actionupdatesequence')
                       {
                         $qset= $this->input->get('qset');
	                 $esid= $this->input->get('esid');
                         $ssid= $this->input->get('ssid');

                         //$where=array('qid'=>$qid,'qset_id'=>$qset);
 
                         //$arr=array('sid'=>$sid,'chkflag'=>$flag);
                         $rd='';
	                 $this->load->model('ProjectModel');
                         //$rd=$this->ProjectModel->doSequenceUpdate($id,$arr);
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

                       
                         $arr=array('qid'=>$qid,'pqid'=>$pqid,'flow'=>$flow,'opval'=>$opval);
                         $rd='';
	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doRoutineUpdate($id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                         
                       }
                       if($action=='actionstore')
                       {
	                 $this->load->model('ProjectModel');
                         //$sdata=$this->ProjectModel->getEditProjectDetail($pid);
                         echo "Updated Successfully";
                       }
                       if($action=='actionrule1')
                       { $id= $this->input->get('id');
                         $qid= $this->input->get('qid');
                         $sn= $this->input->get('sn');
                         $gc= $this->input->get('gc');
                         $arr=array('grp_code'=>$gc,'qid'=>$qid,'sno'=>$sn);

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doRuleUpdate('question_rule_1',$id,$arr);
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

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doRuleUpdate('question_rule_2',$id,$arr);
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
                         $arr=array('grp_id'=>$gc,'qid'=>$qid);

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doRuleUpdate('question_rule_3',$id,$arr);
                         if($rd)
                            echo "Qid $qid Updated Successfully";
                          else 
                            echo "Qid $qid Not Updated Successfully";
                       }
                        if($action=='actionrule1d')
                       { $id= $this->input->get('id');
                         $qid= $this->input->get('qid');
	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doSqlDML("DELETE FROM question_rule_1 where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionrule2d')
                       {
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doSqlDML("DELETE FROM question_rule_2 where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                       if($action=='actionrule3d')
                       { 
                         $qid= $this->input->get('qid');
                         $id= $this->input->get('id');

	                 $this->load->model('ProjectModel');
                         $rd=$this->ProjectModel->doSqlDML("DELETE FROM question_rule_3 where id=$id");
                         if($rd)
                            echo "Qid $qid Deleted Successfully";
                          else 
                            echo "Qid $qid Not Deleted Successfully";
                       }
                        
	}
        public function copyqbcat($action)
        {                
           ; 
                  $this->load->model('ProjectModel');
                      if($action=='actionqbycat')
                      {    $ctr=0;$str='';
                           $cat= $this->input->get('cat');
                           if($cat!=0)
                           {
                           echo "<br>Question List in Database:<br><table border=1>";
                           $sql="SELECT `id`, `cat_id`, `q_id`, `remarks` FROM `question_category` WHERE cat_id=$cat";
                           $sdata=$this->ProjectModel->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {    
                                $qqid=$d->q_id;
                                if($ctr==0) $str=$qqid;
                                if($ctr>0) $str.=','.$qqid;
                                $ctr++;
                           } 
                                $sql1="SELECT * FROM `question_detail` WHERE q_id in ( $str )";
                                $sds=$this->ProjectModel->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {     
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid/$qt </td><td><div  onclick=showhideqop($qid);>$title ";
                                        echo "<ul class='w3-ul w3-hide' id=$qid>";
                                        $qops=$this->ProjectModel->getPQop($qid);
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
                           $sdata=$this->ProjectModel->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {    
                                $qid=$d->q_id;
                                if($ctr==0) $str=$qid;
                                if($ctr>0) $str.=','.$qid;
                                $ctr++;
                           } 
                                $sql1="SELECT * FROM `question_detail` WHERE q_title like '%$sk%' AND q_id in ( $str )";
                                $sds=$this->ProjectModel->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {   
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid/$qt </td><td> $title</td></tr>";
                                }    echo "</table>"; 
                          }               
                       } 
                       if($action=='actionqbykeyp')
                       { 
                           $fp= $this->input->get('fpn');
                           $sk= $this->input->get('key');
                           $ctr=0;$str='';
                           $sql="SELECT distinct q_id FROM `question_detail` WHERE q_title like '%$sk%' OR qset_id = $fp";
                           $sdata=$this->ProjectModel->getDataBySql($sql);
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
                                $sds=$this->ProjectModel->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {   
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid/$qt </td><td> $title</td></tr>";
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
                                $sds=$this->ProjectModel->getDataBySql($sql1);
                                if($sds)
                                foreach($sds as $q)
                                {   
                                     $qid=$q->q_id; $qt=$q->q_type; $title=$q->q_title;
                                     echo "<tr><td><input type=radio name=qid value=$qid></td><td> $qid/$qt </td><td> $title</td></tr>";
                                }    echo "</table>"; 
                          }               
                       }
        }
        public function createqbcat($action)
        {                
                       $this->load->model('ProjectModel');
                       if($action=='actioncatn')
                       {
	                  $cname= $this->input->get('catname');
                          $arr=array('name'=>$cname);
                          $ic=$this->ProjectModel->isCat($cname);
                          if(!$ic)
                          {
                            $sd=$this->ProjectModel->insertIntoTable('category_detail',$arr);   
                            echo "$cname - Created Successfully";
                          }
                          if($ic) echo "$cname - Category already exist in database";
                       }
                       if($action=='actioncatv')
                       {
                           echo "<br>Category List in Database:<br>";
                           $sql="SELECT `catid`, `name`, `remarks` FROM `category_detail` order by name";
                           $sdata=$this->ProjectModel->getDataBySql($sql);
                           if($sdata)
                           foreach($sdata as $d)
                           {
                                $id=$d->catid; $n=$d->name;
                                echo "<li> $id -- $n";
                           }                         
                       }
                       
	}
        public function createproject()
        {       //print_r($_POST);
                       $pn= $this->input->post('pname'); 
                       $b= $this->input->post('brand'); 
                       $ccn= $this->input->post('ccn');
                       $bd= $this->input->post('bd'); 
                       $ss= $this->input->post('ss'); 
                       $v= $this->input->post('visit');
                       $ssid= $this->input->post('ssdt'); 
                       $esid= $this->input->post('esdt'); 
                       $rt= $this->input->post('rt');
                       $pcat= $this->input->post('pcat'); 
                       $rp= $this->input->post('rp'); 
                       
                       $parr=array('name'=>$pn,'company_name'=>$ccn,'brand'=>$b,'research_type'=>$rt,'tot_visit'=>$v,'background'=>$bd,'sample_size'=>$ss,'survey_start_date'=>$ssid,'survey_end_date'=>$esid,'category'=>$pcat,'reward_point'=>$rp);
                      
	               $this->load->model('ProjectModel');
                       $chkp=$this->ProjectModel->getDataBySql("select * from project where name='$pn'");
                       if(!$chkp)
                       {
                         $pid=$this->ProjectModel->insertIntoTable('project',$parr);
                         $dtn=$this->ProjectModel->get_project_name($pid);
                         $dtn=strtolower($dtn);$dtn.='_'.$pid;
                 
                         if($pid)
                         {
                                 $rdd2=$this->ProjectModel->doSqlDML("CREATE TABLE IF NOT EXISTS $dtn  (id int(5) primary key AUTO_INCREMENT,resp_id bigint(20) not null, q_id int(5) not null, r_name varchar(30) not null, mobile varchar(11) not null, centre_$pid varchar(2), i_date_$pid datetime, sec_$pid varchar(1) not null, gender_$pid varchar(1) not null, week_day_$pid char(1) not null, age_$pid varchar(2) not null, st_$pid varchar(2) not null, age_yrs_$pid varchar(2) not null, store_$pid varchar(1) not null, product_$pid varchar(1) not null)ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ");
                                 if($rdd2)
                                 {
                                     $rdd3=$this->ProjectModel->doSqlDML("ALTER TABLE $dtn ADD index rsp$pid (resp_id)");
                                     $rdd4=$this->ProjectModel->doSqlDML("UPDATE `project` SET  `data_table`='$dtn' ,`status`=1 WHERE `project_id`=$pid");
                                     $sdata="Project ' $pn ' created successfully";
                                 } 
                         }
                         else $sdata="Project ' $pn ' Not created , Please try again";
                       }
                       if($chkp) $sdata="Project name ' $pn ' already exist in database";
                       
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function createqset()
        {       
                       $pid= $this->input->post('pn'); 
                       $visit= $this->input->post('visit'); 
                       $parr=array('project_id'=>$pid,'visit_no'=>$visit);
	               $this->load->model('ProjectModel');
                       $chkp=$this->ProjectModel->getDataBySql("select * from questionset where project_id=$pid AND visit_no=$visit");
                       if(!$chkp)
                       {  
                         $pid=$this->ProjectModel->insertIntoTable('questionset',$parr);
                         $sdata="Project ID ' $pid ' visit $visit created successfully";
                       }
                       if($chkp) $sdata="Project id: ' $pid ' with visit: $visit already exist in database";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function createquestion()
        {         
                       $pid= $this->input->post('qset'); 
                       $ssid= $this->input->post('ssid'); 
                       $esid= $this->input->post('esid');
	               $this->load->model('ProjectModel');
                        $sdata=$this->ProjectModel->docreatequestion($_POST);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function docreatesequence()
        {         
                       $pid= $this->input->post('qset'); 
                       $sdata='Sequence Not Added';
	               $this->load->model('ProjectModel');
                       $sd=$this->ProjectModel->doCUpdateSequence($_POST,$pid);
                       if($sd) $sdata='Sequence Added Successfully';
                        
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function createsequence()
        {       
                       $pid= $this->input->post('qset'); 
                       
	               $this->load->model('ProjectModel');
                       $sd=$this->ProjectModel->viewCreateSequence($pid);
                             $arrdata['rqpost']='';
                             $arrdata['msg']=$sd;
                             $this->load->view('samylogin',$arrdata);
                       
	}
        public function docreateroutine()
        {       
                       $pid= $this->input->post('qset'); 
                       $qid= $this->input->post('qs'); 
                       $pqid= $this->input->post('pqid');
	               $this->load->model('ProjectModel');
                       //$sdata=$this->ProjectModel->doCRoutine($pid,$qid,$pqid);
 
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function createroutine()
        {      
                       $qset= $this->input->post('qset'); 
                       $qid= $this->input->post('qid');
	               $this->load->model('ProjectModel');
                       $qid='';$pqid='';$nctr=0; $opval='';
    
                             foreach($_POST as $key=>$val)
                             {
                                     if($key=='qs')
                                     {
                                       $qid=$val; continue;
                                     }
                                     if($key=='pqid')
                                     {
                                       $pqid=$val; continue;
                                     }
                                     if($key!='rsubmit')if($key!='qset')if($key!='pn')
                                     { 
                                       $f=0; 
                                       if($nctr>0 && ($val==1 ||$val ==2 ))  
                                       {
                                          if($opval!=1)
                                          {
                                          $qu="UPDATE `question_routine_check` SET `flow`=$val WHERE opval=$opval and qset_id=$qset and qid=$qid and pqid=$pqid";
                                          $e1=$this->ProjectModel->doSqlDML($qu); 
                                          }
                                          $nctr=0;
                                       }
                                         $ff="chk$val";
                                         if($key==$ff){  $opval=$val;  $nctr=1;
                                         $qi="INSERT INTO `question_routine_check`(`qset_id`, `qid`, `pqid`, `opval`, `flow`) VALUES ($qset,$qid,$pqid,$val,$f)";
                                         $e2=$this->ProjectModel->doSqlDML($qi); 
                                      }
                             }
                       }
                       $sdata= "<br>Question Id $qid Routine added successfully";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addqbquest()
        {       
                       $pid= $this->input->post('qset'); 
                       $cat= $this->input->post('cat'); 
                       $qid= $this->input->post('qs');  
	               $this->load->model('ProjectModel');
                       $arr=array('cat_id'=>$cat,'q_id'=>$qid);
                       $rr=$this->ProjectModel->isQCat($cat,$qid);
                       if(!$rr)
                       {   $sd=$this->ProjectModel->insertIntoTable('question_category',$arr);
                           if($sd) $sdata="Sucessfully Added qid:$qid to Cat:$cat";
                           if(!$sd) $sdata="Unable to Add qid:$qid to Cat:$cat";
                       }
                       if($rr) $sdata="Already exist in our database-- qid:$qid to Cat:$cat";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addqop()
        {       
                       $pid= $this->input->post('qset'); 
                       $code= $this->input->post('code'); 
                       $opt= $this->input->post('opt');
                       $qid= $this->input->post('qs');  
	               $this->load->model('ProjectModel');
                       $term=$this->ProjectModel->isQTerm($qid);
                       $arr=array('opt_text_value'=>$opt,'value'=>$code,'q_id'=>$qid,'term'=>$term);
                       $rr=$this->ProjectModel->isQOp($qid,$code);
                       if(!$rr)
                       {   $sd=$this->ProjectModel->insertIntoTable('question_option_detail',$arr);
                           if($sd) $sdata="Sucessfully Added Option in qid:$qid as $opt";
                           if(!$sd) $sdata="Unable to Add Option in qid:$qid as $opt";
                       }
                       if($rr) $sdata="Already exist in our database-- Option in qid:$qid as $opt";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function deletequestionop()
        {       
                       $pid= $this->input->post('qset'); 
                       $code= $this->input->post('code'); 
                       $qid= $this->input->post('qs');  
	               $this->load->model('ProjectModel');  
                       $rr=$this->ProjectModel->isQOp($qid,$code);
                       if($rr)
                       {   $op=$this->ProjectModel->getQopid($qid,$code);
                           $sd=$this->ProjectModel->doSqlDML("DELETE FROM `question_option_detail` WHERE `op_id`=$op");
                           if($sd) $sdata="Sucessfully Deleted Option in qid:$qid with code: $code";
                            
                       }
                       if(!$rr) $sdata="Does not exist in our database-- Option in qid:$qid & code: $code";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       //$arrdata['msg']="DELETE FROM `question_option_detail` WHERE `q_id`=$qid AND value=$code";
                       $this->load->view('samylogin',$arrdata);
	}
        public function deletequestion()
        {       
                       $pid= $this->input->post('qset'); 
                       $code= $this->input->post('code'); 
                       $qid= $this->input->post('qs');  
	               $this->load->model('ProjectModel');  
                        
                       if($qid!=0)
                       {   $sd=$this->ProjectModel->doSqlDML("DELETE from question_detail WHERE q_id=$qid");
                           if($sd) $sdata="Sucessfully Deleted Question with its Options in qid:$qid";
                           $s=$this->ProjectModel->doSqlDML("DELETE FROM `question_option_detail` WHERE `q_id`=$qid"); 
                       }
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addsequence()
        {       
                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $qid= $this->input->post('qid'); 
                       $sid= $this->input->post('sid'); 
	               $this->load->model('ProjectModel');
                       $arr=array('qset_id'=>$qset,'qid'=>$qid, 'sid'=>$sid,'chkflag'=>0);
                        $sd=$this->ProjectModel->insertIntoTable('question_sequence',$arr);
                           if($sd) $sdata="Sucessfully Sequence Added qid:$qid of Qset:$qset";
                           if(!$sd) $sdata="Unable to Sequence Added qid:$qid of Qset:$qset";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addpcentre()
        {       
                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $cn= $this->input->post('cn'); 
                        
	               $this->load->model('ProjectModel');
                       $arr=array('centre_id'=>$cn,'project_id'=>$pid, 'q_id'=>$qset);
                        $sd=$this->ProjectModel->insertIntoTable('centre_project_details',$arr);
                           if($sd) $sdata="Sucessfully Centre Added cid:$cn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Centre Added cid:$cn to Qset:$qset";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addpproduct()
        {       
                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $prdn= $this->input->post('prdn'); 
                       $c= $this->input->post('code'); 
                        
	               $this->load->model('ProjectModel');
                       $arr=array('valuee'=>$c,'project'=>$prdn, 'qset_id'=>$qset);
                        $sd=$this->ProjectModel->insertIntoTable('project_product_map',$arr);
                           if($sd) $sdata="Sucessfully Product Added :$prdn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Product Added :$prdn to Qset:$qset";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addpstore()
        {       
                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $sn= $this->input->post('sn'); 
                       $c= $this->input->post('code'); 
                        
	               $this->load->model('ProjectModel');
                       $arr=array('valuee'=>$c,'store'=>$sn, 'qset_id'=>$qset);
                        $sd=$this->ProjectModel->insertIntoTable('project_store_loc_map',$arr);
                           if($sd) $sdata="Sucessfully Store Added :$sn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Store Added :$sn to Qset:$qset";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addpsec()
        {       
                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $sn= $this->input->post('sec'); 
                       $c= $this->input->post('code'); 
                        
	               $this->load->model('ProjectModel');
                       $arr=array('valuee'=>$c,'sec'=>$sn, 'qset_id'=>$qset);
                        $sd=$this->ProjectModel->insertIntoTable('project_sec_map',$arr);
                           if($sd) $sdata="Sucessfully SEC Added :$sn to Qset:$qset";
                           if(!$sd) $sdata="Unable to SEC Added :$sn to Qset:$qset";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addpage()
        {       
                       $pid= $this->input->post('pn');
                       $qset= $this->input->post('qset'); 
                       $sn= $this->input->post('age'); 
                       $c= $this->input->post('code'); 
                        
	               $this->load->model('ProjectModel');
                       $arr=array('valuee'=>$c,'age'=>$sn, 'qset'=>$qset);
                        $sd=$this->ProjectModel->insertIntoTable('project_age_map',$arr);
                           if($sd) $sdata="Sucessfully Age Added :$sn to Qset:$qset";
                           if(!$sd) $sdata="Unable to Age Added :$sn to Qset:$qset";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addcentre()
        {        
                       $cn= $this->input->post('cn'); 
                        
	               $this->load->model('ProjectModel');
                       $arr=array('cname'=>$cn);
                        $sd=$this->ProjectModel->insertIntoTable('centre',$arr);
                           if($sd) $sdata="Sucessfully Centre Added :$cn";
                           if(!$sd) $sdata="Unable to Centre Added :$cn";
                      
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function copyqbquest()
        {       
                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $qno= $this->input->post('qno'); 
                       $qid= $this->input->post('qid');  $qno=strtolower($qno);
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->copyquestioninproject($pid, $qset, $qid, $qno);
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function copyquestionop()
        {       
                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');
                       $qno= $this->input->post('qno'); 
                       $fpn= $this->input->post('fpn'); 
                       $qid= $this->input->post('qid');  $qno=strtolower($qno);
	               $this->load->model('ProjectModel');
                       $sdata=$this->ProjectModel->copyquestioninproject($pid, $qset, $qid, $qno);
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function deletesequence()
        {       
                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');

	               $this->load->model('ProjectModel');
                      
                       $qi="DELETE FROM `question_sequence` WHERE `qset_id`= $qset";
                       $sa=$this->ProjectModel->doSqlDML($qi); 
                       $sdata="Not deleted";
                       if($sa) $sdata="Question Sequence of QSET: $qset, Deleted Successfully";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function deleteroutine()
        {       
                       $pid= $this->input->post('pn'); 
                       $qset= $this->input->post('qset');

	               $this->load->model('ProjectModel');
                      
                       $qi="DELETE FROM `question_routine_check` WHERE `qset_id`= $qset";
                       $sa=$this->ProjectModel->doSqlDML($qi); 
                       $sdata="Not deleted";
                       if($sa) $sdata="Question Routine of QSET: $qset, Deleted Successfully";
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addtransq()
        {       
                       $pid= $this->input->post('qset'); 
                       $qid= $this->input->post('qs'); 
                       $lang= $this->input->post('lang'); 
                       $title= $this->input->post('tv');  
	               $this->load->model('ProjectModel');
                       $arr=array('q_title'=>$title,'q_id'=>$qid);
                       if($lang==1)
                       {
                             $rr=$this->ProjectModel->isTransQ('hindi_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->ProjectModel->insertIntoTable('hindi_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->ProjectModel->doSqlDML("UPDATE `hindi_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==2)
                       {
                             $rr=$this->ProjectModel->isTransQ('kannar_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->ProjectModel->insertIntoTable('kannar_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->ProjectModel->doSqlDML("UPDATE `kannar_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==3)
                       {
                             $rr=$this->ProjectModel->isTransQ('malyalam_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->ProjectModel->insertIntoTable('malyalam_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->ProjectModel->doSqlDML("UPDATE `malyalam_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==4)
                       {
                             $rr=$this->ProjectModel->isTransQ('tammil_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->ProjectModel->insertIntoTable('tammil_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->ProjectModel->doSqlDML("UPDATE `tammil_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==5)
                       {
                             $rr=$this->ProjectModel->isTransQ('telgu_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->ProjectModel->insertIntoTable('telgu_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->ProjectModel->doSqlDML("UPDATE `telgu_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       if($lang==6)
                       {
                             $rr=$this->ProjectModel->isTransQ('bengali_question_detail',$qid);
                             if(!$rr)
                             {   $sd=$this->ProjectModel->insertIntoTable('bengali_question_detail',$arr); if($sd) $sdata="Sucessfully Added qid:$qid";if(!$sd) $sdata="Unable to Add qid:$qid";
                                 
                             }
                             if($rr)
                             {   $sd=$this->ProjectModel->doSqlDML("UPDATE `bengali_question_detail` SET `q_title`='$title'  WHERE `q_id`=$qid");
                                 if($sd) $sdata="Sucessfully Updated qid:$qid"; if(!$sd) $sdata="Unable to Update qid:$qid";
                             }
                       }
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addtransqop()
        {       print_r($_POST);
                       $pid= $this->input->post('qset'); 
                       $qid= $this->input->post('qs'); 
                       $lang= $this->input->post('lang'); 
                       //title= $this->input->post('tv');  
	               $this->load->model('ProjectModel');
                        

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
print_r($arr_post);
       
                       if($lang==1)
                       {
                             for($i=0;$i<$tot;$i+=2)
                             { 
                                $v1=$arr_post[$i]; $op=$arr_post[$i+1]; 

                                $oparr=array('q_id'=>$qid, 'opt_text_value'=>$op, 'code'=>$v1);
                                $rr=$this->ProjectModel->isTransQop('hindi_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->ProjectModel->insertIntoTable('hindi_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added hindi qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->ProjectModel->doSqlDML("UPDATE `hindi_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
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
                                
                                $rr=$this->ProjectModel->isTransQop('kannar_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->ProjectModel->insertIntoTable('kannar_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->ProjectModel->doSqlDML("UPDATE `kannar_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
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
                                
                                $rr=$this->ProjectModel->isTransQop('malyalam_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->ProjectModel->insertIntoTable('malyalam_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added malyalam qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->ProjectModel->doSqlDML("UPDATE `malyalam_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
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
                                
                                $rr=$this->ProjectModel->isTransQop('tammil_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->ProjectModel->insertIntoTable('tammil_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added tammil qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->ProjectModel->doSqlDML("UPDATE `tammil_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
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
                                
                                $rr=$this->ProjectModel->isTransQop('telgu_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->ProjectModel->insertIntoTable('telgu_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added telgu qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->ProjectModel->doSqlDML("UPDATE `telgu_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
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
                                
                                $rr=$this->ProjectModel->isTransQop('bengali_question_option_detail',$qid,$v1);
                                if(!$rr)
                                {   $sd=$this->ProjectModel->insertIntoTable('bengali_question_option_detail',$oparr); if($sd) $sdata="Sucessfully Added bengali qid:$qid and code:$v1";if(!$sd) $sdata="Unable to Add qid:$qid  and code:$v1";
                                }
                                if($rr)
                                {   $sd=$this->ProjectModel->doSqlDML("UPDATE `bengali_question_option_detail` SET `opt_text_value`='$op'  WHERE `q_id`=$qid and code=$v1");
                                    if($sd) $sdata="Sucessfully Updated bengali qid:$qid  and code:$v1"; if(!$sd) $sdata="Unable to Update qid:$qid  and code:$v1";
                                }
                             }
                       }
                       $arrdata['rqpost']='';
                       $arrdata['msg']=$sdata;
                       $this->load->view('samylogin',$arrdata);
	}
        public function addrule()
        {        
                       $rt= $this->input->post('rt'); 
                       $qset= $this->input->post('qset');
                       
	               $this->load->model('ProjectModel');
                       if($rt!=0 & $qset!=0)  $sdata=$this->ProjectModel->doaddrule($_POST);
                       $msg="Error!Not added rule for Grid Questions";
                       if($sdata==1) $msg="Successfully added rule for Grid Questions";
                       $ardata['rqpost']=''; 
                       $ardata['msg']=$msg; print_r($ardata);
                      $this->load->model('SAUserModel');
                        $this->load->view('samylogin',$ardata);
	}
        public function editdrule()
        { 
                       $rt= $this->input->get('rt'); 
                       $qset= $this->input->get('qset');
                       $sdata='Data not available';
	               $this->load->model('ProjectModel');
                       if($rt!=0 & $qset!=0) $sdata=$this->ProjectModel->doeditrule($qset,$rt);
                       //$arrdata['rqpost']=''; 
                       //$arrdata['msg']=$sdata; 
                       //$this->load->view('samylogin',$arrdata);
                       echo $sdata;
        }
}


