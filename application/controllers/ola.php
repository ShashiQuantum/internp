<?php

class Ola extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('MOla');
    }

    function index($start = 0)//index page
    {
        $data['posts'] = $this->MOla->get_log_resp();
       //$data['posts'] = array();
        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/blog/index/';//url to set pagination
        $config['total_rows'] = 0;
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        // $this->load->view('header', $class_name);
         $this->load->view('v_search_ola', $data);
        $this->load->view('footer');
    }

    function search($query = '',$q2='')//index page
    {
        $query = $query != '' ? $query : $this->input->get('query', TRUE);
         $query2 = $q2 != '' ? $q2 : $this->input->get('query2', TRUE);
          
        $this->load->model('MApplog');
        $data['posts'] = $this->MApplog->search_applog($query,$query2);
        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'applog/search/?query=' . urlencode($query);//url to set pagination
        $config['total_rows'] = 0;
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages
        $data['query'] = $query; //Links of pages
        $data['query2'] = $query2;

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
        //$this->load->view('header', $class_name);
        $this->load->view('v_search_applog', $data);
        $this->load->view('footer');
    }

}
