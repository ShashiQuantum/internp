<?php

class Question 
{

    private $q_title='';
    private $q_id='';
    private $q_type='';
    private $image='';
    private $video='';
    private $audio='';
    private $qno='';
 
    public function get_qtitle() {
        
        return $this->q_title;
    }

    public function set_qtitle($q_t) {
         $this->q_title = $q_t;
    }

    public function get_qid() {
        return $this->q_id;
    }

    public function set_qid($qid) {
        $this->q_id = $qid;
    }
     public function get_qno() {
        return $this->qno;
    }

    public function set_qno($qno) {
         $this->qno = $qno;
    }
    public function get_qtype() {
        return $this->q_type;
    }

    public function set_qtype($qtype) {
        $this->q_type = $qtype;
    }

    public function get_image() {
        return $this->image;
    }

    public function set_image($img) {
         $this->image = $img;
    }

    public function get_video() {
        return $this->video;
    }

    public function set_video($vd) {
         $this->video = $vd;
    }

    public function get_audio() {
        return $this->audio;
    }

    public function set_audio($aud) {
         $this->audio = $aud;
    }

  
}

?>