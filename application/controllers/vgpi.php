<?php

class Vgpi extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('MGpi');
    }

    function index($start = 0)//index page
    {
         $data['posts'] = $this->MGpi->get_shopers();
       //$data['posts'] = array();
        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/vgpi/';//url to set pagination
        $config['total_rows'] = 10;
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        // $this->load->view('header', $class_name);
         $this->load->view('v_gpi', $data);
        $this->load->view('footer');
    }

    
   
}
