<?php

class Applog extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('MDb');
    }

    function index($start = 0)//index page
    {
      $data['posts'] = $this->MDb->get_posts(5, $start);

        //pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url() . 'index.php/applog/';//url to set pagination
        $config['total_rows'] = $this->MDb->get_post_count();
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links(); //Links of pages

        $class_name = array('home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => '');
         //$this->load->view('header', $class_name);
         $this->load->view('v_mapplog', $data);
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
        $config['total_rows'] = $this->MApplog->get_post_count();
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

    function post($post_id)//single post page
    {
        $this->load->model('MComment');
        $data['comments'] = $this->MComment->get_comment($post_id);
        $data['post'] = $this->MDb->get_post($post_id);
        $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
        $this->load->view('header', $class_name);
        $this->load->view('v_single_post', $data);
        $this->load->view('footer');
    }

    function new_post()//Creating new post page
    {
        //when the user is not an admin and author
        if (!$this->check_permissions('author'))
        {
            redirect(base_url() . 'index.php/users/login');
        }
        if ($this->input->post()) {
            $data = array('post_title' => $this->input->post('post_title'), 'post' => $this->input->post('post'), 'active' => 1,);
            $this->MDb->insert_post($data);
            redirect(base_url() . 'index.php/blog/');
        } else {

            $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
            $this->load->view('header', $class_name);
            $this->load->view('v_new_post');
            $this->load->view('footer');
        }
    }

    function check_permissions($required)//checking current user's permission
    {
        $user_type = $this->session->userdata('user_type');//current user
        if ($required == 'user') {
            return isset($user);

        } elseif ($required == 'author') {
            return $user_type == 'author' || $user_type == 'admin';

        } elseif ($required == 'admin') {
            return $user_type == 'admin';
        }
    }

    function editpost($post_id)//Edit post page
    {
        if (!$this->check_permissions('author'))//when the user is not an admin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        $data['success'] = 0;

        if ($this->input->post()) {
            $data = array('post_title' => $this->input->post('post_title'), 'post' => $this->input->post('post'), 'active' => 1);
            $this->MDb->update_post($post_id, $data);
            $data['success'] = 1;
        }
        $data['post'] = $this->MDb->get_post($post_id);

        $class_name = ['home_class' => 'current', 'login_class' => '', 'register_class' => '', 'upload_class' => '', 'contact_class' => ''];
        $this->load->view('header', $class_name);
        $this->load->view('v_edit_post', $data);
        $this->load->view('footer');
    }

    function deletepost($post_id)//delete post page
    {
        if (!$this->check_permissions('author'))//when the user is not an andmin and author
        {
            redirect(base_url() . 'index.php/users/login');
        }
        $this->MDb->delete_post($post_id);
        redirect(base_url() . 'index.php/blog/');
    }
}
