<?php

class Habitat extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0) //index page
    {
        $this->load->view('habitatfp');
	//$this->load->view('footer');
    }

    function godashboard()
    {
       	$pid=$this->input->post('key');
	$ptr=1;
	$_SESSION['ptr']=$ptr;
	$this->load->model("MHabitat");
	$arr = $this->MHabitat->get_sidonly($pid);
	$_SESSION['arr_sid']=$arr;
//print_r($arr);
	$_SESSION['pid']=$pid;
	$_SESSION['sid']=$arr["$ptr"];
	$this->session->set_userdata('pid',$pid);
        //$this->session->set_userdata('sid',1);
	redirect('habitat/dashboard');
		//$this->dashboard();
    }

    function dashboard()
    {
        $this->load->model("MHabitat");
	$pid='';
	if(isset($_SESSION['pid']))
	$pid=$_SESSION['pid'];
	if($pid!=''){
		if($this->MHabitat->isProject($pid))
		{
			$this->load->model("MHabitat");
			$csid=$_SESSION['sid'];
            		$result = $this->MHabitat->validate_qset($pid,$csid);
            		if(!empty($result))
			{
                		$data = array('qset_id' => $pid,'sid' => $result->sid);
                		$this->session->set_userdata($data);
				//$this->load->view('habitat_dash',$data);
				$url="habitat/dshb/$csid/r";
				redirect("$url");
            		}
        	}
		else{
                                $data['error']="Code is invalid/expired.";
                                $this->session->set_flashdata('flash_data', '<b style="color:red; font-size:12px">This Project ID Does not exist</b>');
                                $this->load->view('habitatfp',$data);

		    }
	}
	else{ 
		 $data['error']="<p>Error! KEY is blank.</p>";
                 $this->load->view('habitatfp',$data);
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
	$this->load->view('habitat_dash2',$data);
    }

    function dashboarddtl()
    {
        //print_r($_POST);
        //$pid=$this->input->post('key');
        $pid=$this->session->userdata('pid');
        $this->load->model("MHabitat");
        //$ptable=$this->MHabitat->getPTable($pid);

        $pid=$_SESSION['pid'];
        //$this->load->view('habitat_dash');
        if($pid!=''){
                if($this->MHabitat->isProject($pid))
                {
                        $this->load->model("MHabitat");
			$this->load->view('habitat_dashdtl');
                }
                else{
                         echo "Invalid KEY entered";
                                $data['error']="Code is invalid/expired.";
                                $this->session->set_flashdata('flash_data', '<b style="color:red; font-size:12px">This Project ID Does not exist</b>');
                                $this->load->view('habitatfp',$data);

                    }
        }
        else{
		echo $this->session->userdata('pid');
		echo "KEY is blank/expired.";
	}
    }

}
