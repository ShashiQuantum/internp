<?php

class Home extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0)//index page
    {
        //$this->load->view('header');
        //$rs['records']='';
     $this->load->view('HomeView');
        //$this->load->view('footer');
    }
        public function login()
        { 
                $this->load->helper('url'); 
	        $this->load->helper('form');        
	        $this->load->view('domain_form');       
	}
        public function dologin()
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
                $dmn=$this->input->post("domain");
		//Begin for SiteAdmin Login
		if($dmn==1)
		{
                	$this->load->model('m_sausermodel');
                	$ss=$this->m_sausermodel->login($usern, $passd);
                      if($ss)
                      {
			 $uid=$_SESSION['sauserid'];
                         $this->load->model('m_sausermodel');
                         $role=$this->m_sausermodel->getuserrole($uid);
        		 $permission=$this->m_sausermodel->getuserpermissionmap($uid);
			 $data['rqpost']=''; $data['msg']='';
			 $_SESSION['isSALogin']=true;
			 $_SESSION['sauseridrole']=$role;
			 $_SESSION['permission']=$permission;
                         $this->session->set_userdata('isSALogin', TRUE);	 
                         $this->session->set_userdata('sauserid',$uid);
                         $this->session->set_userdata('sauseridrole',$role);
                         $this->session->set_userdata('permission',$permission);
                         $satempuri=$this->session->tempdata('satemp');
                         if($satempuri=='')
        		    $this->load->view('samylogin',$data);
                      }
        	      else
        	      {
        		$data['error']='Invalid Username/Password';
        		$this->load->view('_login_form',$data);
        	      }
	        } //end of if=1
		//Begin for VPMS login
                else
                {
                        $data['error']='Invalid Username/Password';
                        $this->load->view('_login_form',$data);
                } //end of if=2

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
}

