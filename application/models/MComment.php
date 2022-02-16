<?php

class MComment extends CI_Model
{
    function add_comment($data)
    {
        $this->db->insert('comments',$data);
        return $this->db->insert_id();
    }
    
    function get_comment($post_id)
    {
        $this->db->select('comments.*,web_user.user');
        $this->db->from('comments');
        $this->db->join('web_user','web_user.user_id = comments.user_id', 'left');
        $this->db->where('post_id',$post_id);
        $this->db->order_by('date_added','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
}

