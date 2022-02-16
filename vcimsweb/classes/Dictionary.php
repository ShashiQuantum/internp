<?php

class Dictionary
{
	private $_db;

	public function __construct($user=null)
	{
		$this->_db = DB::getInstance();
	}
	
	// Fetch key for given term and value
	public function get_key($term='', $value='')
	{
		if($term != '' && $value != '')
		{
			$data = $this->_db->query("SELECT * FROM dictionary WHERE term = '".$term."' AND value = '".$value."'");
			if($data->count())
			{
				return $data->first()->keyy;
			}
		}
		echo $term.'('.$value.') Key Not Found';
		exit;
	}
	
	// Fetch value for given term and key
	public function get_value($term='', $key=null)
	{
		if($term != '' && $key != null)
		{
			$data = $this->_db->query("SELECT * FROM dictionary WHERE term = '".$term."' AND keyy = ".$key."");
			if($data->count())
			{
				return $data->first()->value;
			}
		}
		echo $term.'('.$key.') Value Not Found';
		exit;
	}
}

