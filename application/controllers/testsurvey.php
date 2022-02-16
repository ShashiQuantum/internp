<?php

class TestSurvey extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0) //index page
    {
        $this->load->view('testsurveyfp');
        //$this->load->view('footer');
    }
    function gototest()
    {
       	$pid=$this->input->post('key');
	$_SESSION['pid']=$pid;
	$_SESSION['sid']=0;
	$this->session->set_userdata('pid',$pid);
        $this->session->set_userdata('sid',0);
	//redirect('habitat/dasboard');
	$this->fp();
    }
    function fp()
    {
	//print_r($_POST);
	//$pid=$this->input->post('key');
	$pid=$this->session->userdata('pid');
        $this->load->model("MHabitat");
	//$ptable=$this->MHabitat->getPTable($pid);
	$pid=$_SESSION['pid'];
        //$this->load->view('habitat/dash');
	if($pid!=''){
		if($this->MHabitat->isProject($pid))
		{
			$this->load->model("MHabitat");
			//$csid=$this->session->userdata('sid');
			$csid=$_SESSION['sid'];
            		$result = $this->MHabitat->validate_qset($pid,1);
            		if(!empty($result))
			{
				//$data = array('qset_id' => $pid,'sid' => 1);
                		$data = array('qset_id' => $pid,'sid' => $result->sid);
                		$this->session->set_userdata($data);
				//$this->load->view('testprojectfp',$data);
				redirect("https://www.digiadmin.quantumcs.com/test/111.php");
            		}
        	}
		else{
			 echo "Invalid KEY entered";
                                $data['error']="Code is invalid/expired.3 $pid";
                                $this->session->set_flashdata('flash_data', '<b style="color:red; font-size:12px">This Project ID Does not exist</b>');
                                $this->load->view('testsurveyfp',$data);

		    }
	}
	else{ print_r($_SESSION); echo $this->session->userdata('pid'); echo "KEY is blank/expired.";}
    }



}
