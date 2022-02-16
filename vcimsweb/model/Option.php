<?php

class Option
{

    private $op_id;
    private $q_id;
    private $value;
    private $column_value;
    private $opt_text_value;
    private $term;
    private $scale_start_value;
    private $scale_end_value;
    private $scale_start_level;
    private $scale_end_level;

    public function get_scalestartvalue() {
        return $this->scale_start_value;
    }

    public function set_scalestartvalue($scale_start_value) {
        $this->scale_start_value = $scale_start_value;
    }

    public function get_scaleendvalue() {
        return $this->scale_end_value;
    }

    public function set_scaleendvalue($scale_end_value) {
        $this->scale_end_value = $scale_end_value;
    }

    public function get_scalestartlebel() {
        return $this->scale_start_level;
    }

    public function set_scalestartlabel($scale_start_level) {
        $this->scale_start_level = $scale_start_level;
    }

    public function get_scaleendlabel() {
        return $this->scale_end_level;
    }

    public function set_scaleendlabel($scale_end_level) {
        $this->scale_end_level = $scale_end_level;
    }

    

    public function get_opid() {
        return $this->op_id;
    }

    public function set_opid($op_id) {
        $this->op_id = $op_id;
    }

    public function get_qid() {
        return $this->q_id;
    }

    public function set_qid($q_id) {
        $this->q_id = $q_id;
    }

    public function get_value() {
        return $this->value;
    }

    public function set_value($value) {
        $this->value = $value;
    }

    public function get_columnvalue() {
        return $this->column_value;
    }

    public function set_columnvalue($column_value) {
        $this->column_value = $column_value;
    }

    public function get_optextvalue() {
        return $this->opt_text_value;
    }

    public function set_optextvalue($opt_text_value) {
        $this->opt_text_value = $opt_text_value;
    }

    public function get_term() {
        return $this->term;
    }

    public function set_term($term) {
        $this->term = $term;
    }
}

?>