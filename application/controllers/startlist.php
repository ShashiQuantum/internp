<?php

class Startlist extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0)//index page
    {
       // $data['posts'] = $this->MDb->get_posts(5, $start);
       $data['posts'] = array();
        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/blog/index/';//url to set pagination
        $config['total_rows'] = 0;
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        // $this->load->view('header', $class_name);
         $this->load->view('v_startlist', $data);
        $this->load->view('footer');
    }

	function report($query = '',$q2='')//report page
        {
      		
      		$this->load->view('v_report_form');
        	$this->load->view('footer');  	
      	}
	function do_report($query = '',$q2='')//report page
	{
	      		$query = $query != '' ? $query : $this->input->get('query', TRUE);
			$query2 = $q2 != '' ? $q2 : $this->input->get('query2', TRUE);
			          
			$this->load->model('MStartlist');
	        	$data['posts'] = $this->MStartlist->get_rept_list($query,$query2);
	      		$this->load->view('v_startlist_report', $data);
	        	$this->load->view('footer');  	
      	}


    function do_start($query = '',$q2='')//to get the list of repid & start_date for pending as 0 or generated flag as 1
    {
            $query = $query != '' ? $query : $this->input->get('query', TRUE);
                           
            $this->load->model('MStartlist');
            $data['posts'] = $this->MStartlist->do_startlist($query);
     
    
            $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
            //$this->load->view('header', $class_name);
            $this->load->view('v_startlist', $data);
            $this->load->view('footer');
    }
    function do_eventrpt($query='')
    {
    	$query = $query != '' ? $query : $this->input->get('query', TRUE);
	                           
	    $this->load->model('MStartlist');
	    $data['str'] = $this->MStartlist->do_eventrptgen($query);
	     
	    $this->load->view('v_startlistgen', $data);
            $this->load->view('footer');
    }
    function v_eventrpt()
    {
        	//$query = $query != '' ? $query : $this->input->get('query', TRUE);
    	                           
    	    //$this->load->model('MStartlist');
    	    //$data['posts'] = $this->MStartlist->do_eventrptgen($query);
    	     $data['str'] = '';
    	    $this->load->view('v_startlistgen', $data);
                $this->load->view('footer');
    }
   
}
