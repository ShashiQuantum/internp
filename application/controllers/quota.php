<?php
//for client crosstab
class Quota extends CI_Controller {

    private $mkey;
    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0) //index page
    {
        $this->load->view('quotareportfp');
        //$this->load->view('footer');
    }

    function godashboard()
    {
                $pid=$this->input->post('key');
		$mkey = $this->input->post('mkey');
		$centre =$this->input->post('ccode'); //centre code

                $ptr=1;
                $_SESSION['ptr']=$ptr;
		$_SESSION['mkey']=$mkey;
		$_SESSION['ccode'];
                $this->load->model("MHabitat");
                $_SESSION['pid']=$pid;
                $this->session->set_userdata('pid',$pid);
                $this->session->set_userdata('ccode',$centre);
                redirect('quota/dashboarddtl');
    }
    function dashboard()
    {
        $this->load->model("MHabitat");
	$mkey = $_SESSION['mkey'];
	$pid='';
	if(isset($_SESSION['pid']))
	$pid=$_SESSION['pid'];
	if($pid!=''){
		if($this->MHabitat->isProject($pid) && $this->MHabitat->validate_mkey($pid,$mkey) )
		{
			$this->load->model("MHabitat");
            		$result = $this->MHabitat->validate_mkey($pid,$mkey);
            		if(!empty($result))
			{
                		$data = array('qset_id' => $pid,'sid' => $result->sid);
                		$this->session->set_userdata($data);
				//$this->load->view('habitat_dash',$data);
				$url="quota/dshb/$csid/r";
				redirect("$url");
            		}
        	}
		else{
                                $data['error']="Code is invalid/expired.";
                                $this->session->set_flashdata('flash_data', '<b style="color:red; font-size:12px">This Project ID Does not exist</b>');
                                $this->load->view('quotareportfp',$data);

		    }
	}
	else{ 
		 $data['error']="<p>Error! KEY is blank.</p>";
                 $this->load->view('quotareportfp',$data);
	}
    }

    function dshb($sid=0,$n='s')
    {
	$nptr=$_SESSION['ptr'];
	if($n=='n') $_SESSION['ptr']=++$nptr;
	if($n=='p' && $nptr > 1) $_SESSION['ptr']=--$nptr;
	$_SESSION['sid']=$sid;
	$data['csid'] = $sid;
	$this->load->model("MHabitat");
	$this->load->view('quota_dash2',$data);
    }

    function dashboarddtl()
    {
        //print_r($_POST);
        $mkey=$_SESSION['mkey'];
        $pid=$this->session->userdata('pid');
        $this->load->model("MHabitat");
        //$ptable=$this->MHabitat->getPTable($pid);
        $pid=$_SESSION['pid'];
        //$this->load->view('habitat_dash');
        if($pid!=''){
                if($this->MHabitat->isProject($pid) && $this->MHabitat->validate_mkey($pid,$mkey) )
                {
                        $this->load->model("MHabitat");
			$this->load->view('quota_dashdtl');
                }
                else{
                         echo "Invalid KEY entered";
                                $data['error']="Code is invalid/expired.";
                                $this->session->set_flashdata('flash_data', '<b style="color:red; font-size:12px">This Project ID Does not exist</b>');
                                $this->load->view('quotareportfp',$data);

                    }
        }
        else{
		echo $this->session->userdata('pid');
		echo "KEY is blank/expired.";
	}
    }
}

