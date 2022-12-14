<?php

class Comments extends CI_Controller
{
    function add_comment($postID)
    {
        if(!$this->input->post())
        {
            redirect(base_url().'index.php/blog/post'.$postID);
        }
        
        $user_type = $this->session->userdata('user_type');
        if(!$user_type)
        {
            redirect(base_url().'index.php/users/login');
        }
        
        $this->load->model('MComment');
        $data = array(
            'post_id' => $postID,
            'user_id' => $this->session->userdata('user_id'),
            'comment' => $this->input->post('comment'),
        );
        $this->MComment->add_comment($data);
        redirect(base_url().'index.php/blog/post/'.$postID);
    }
}