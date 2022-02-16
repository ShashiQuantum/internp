<?php

class Routine {
     
    private $qset_id;
    private $q_id;
    private $next_qid;
    private $qsequence;
    private $op_value;
    private $qsec;
    private $routine;
    private $compare_sign;
    private $join_with;



    public function get_qsetid() {
        return $this->qset_id;
    }

    public function set_qsetid($qset_id) {
        $this->qset_id = $qset_id;
    }

    public function get_qid() {
        return $this->q_id;
    }

    public function set_qid($q_id) {
        $this->q_id = $q_id;
    }

    public function get_nextqid() {
        return $this->next_qid;
    }

    public function set_nextqid($next_qid) {
        $this->next_qid = $next_qid;
    }

    public function get_qsequence() {
        return $this->qsequence;
    }

    public function get_qsec() {
        return $this->qsec;
    }

    public function set_qsec($qsec) {
        this.$qsec = $this->qsec;
    }

    public function set_qsequence($qsequence) {
        $this->qsequence = $qsequence;
    }

    public function get_opvalue() {
        return $this->op_value;
    }

    public function set_opvalue($op_value) {
        $this->op_value = $op_value;
    }

    public function get_routine() {
        return $this->routine;
    }

    public function set_routine($routine) {
        $this->routine = $routine;
    }

    public function get_comparesign() {
        return $compare_sign;
    }

    public function set_comparesign($compare_sign) {
        $this->compare_sign = $compare_sign;
    }

    public function get_joinwith() {
        return $this->join_with;
    }

    public function set_joinwith($join_with) {
        $this->join_with = $join_with;
    }
}

?>