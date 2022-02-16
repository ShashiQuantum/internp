<?php
//for client crosstab
class Crosstab extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0) //index page
    {
        $this->load->view('crosstabfp');
	//$this->load->view('footer');
    }

    function godashboard()
    {
       		$pid=$this->input->post('key');
                $mkey = $this->input->post('mkey');
                $_SESSION['mkey']=$mkey;
		$ptr=1;
		$_SESSION['ptr']=$ptr;
		$this->load->model("MHabitat");
		$arr = $this->MHabitat->get_sidonly($pid);
		$_SESSION['arr_sid']=$arr;
		//print_r($arr);
		$_SESSION['pid']=$pid;
		$_SESSION['sid']=$arr["$ptr"];
		$this->session->set_userdata('pid',$pid);
                        $this->load->model('MProject');
                        $pn = $this->MProject->get_project_name($pid);
	        if($this->MHabitat->isProject($pid) && $this->MHabitat->validate_mkey($pid,$mkey) )
		{
			redirect("https://digiadmin.quantumcs.com/vcimsweb/vareniacrosstabh.php?ctp=$pid&pn=$pn");
		}
                else{
                         echo "Invalid KEY entered";
                                $data['error']="Code is invalid/expired.";
                                $this->session->set_flashdata('flash_data', '<b style="color:red; font-size:12px">This Project ID Does not exist</b>');
                                $this->load->view('crosstabfp',$data);

                    }
    }

}
