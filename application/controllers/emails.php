<?php

class Emails extends CI_Controller
{
    function email()
    {
        $this->load->model('MUser');
        $email = $this->MUser->get_emails();
        $this->load->library('email');
        
        foreach ($email as $row)
        {
            if($row['email'])
            {
                $this->email->from('al.imran.cse@gmail.com');
                $this->email->to($row['email']);
                $this->email->subject('New Letter form Imran Blogs');
                $this->email->message('Hi, This a news letter form imran\'s blog. Thank you for being connected');
                $this->email->send();
                $this->email->clear();
            }
        }
    }
}

