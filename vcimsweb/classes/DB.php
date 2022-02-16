<?php

	class DB 																	
	{
		public $_id;
		private static $_instance = null;
		private $_pdo, $_query, $_results, $_count=0, $error=false;

		private function __construct()							//Instantiates PDO connection, called from getInstance() method		 	
		{
			try
			{
				ini_set('max_execution_time', 3000);
				$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/user'),Config::get('mysql/pass'));
			}
			catch(PDOException $e)
			{
				die($e->getMessage());
			}
		}
               

		public static function getInstance()					//Used to instantiate an object
			{													//Checks if instance already created else creates a new Instance																	
			if(!isset(self::$_instance))
			{
				self::$_instance=new DB();
			}
			return self::$_instance;
		}
               
                
		public function query($sql,$params=array())				//Automatically runs query, arguments-($sql - query string, $params - array of parameters to bind)
		{														//Usage - DB::getInstance->query("Select * from Users where id=?",array('1'));
			$this->_error=false;
			if($this->_query=$this->_pdo->prepare($sql))
			{
				$x=1; 
				if(count($params))
				{
					foreach($params as $param)
					{
						$this->_query->bindValue($x,$param);
						$x++;
					}
				
				}
			

				if($this->_query->execute()){
					$this->_results=$this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count=$this->_query->rowCount();
				} else {
					$this->_error =true;
				}
			}

			return $this;
		}
		
		public function nquery($sql)
		{
			if($this->_query=$this->_pdo->prepare($sql))
			{
				if($this->_query->execute()){
					$this->_results=$this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count=$this->_query->rowCount();
				} else {
					$this->_error =true;
				}
		
			}
			return $this;
		}
		
		public function action($action,$table,$where=array())	//Automates running a query
		{														//Usage - DB::getInstance->action('Select *','users',array('id','=','1'));
			if(count($where)===3)								
			{													
				$operators=array('=','>','<','<=','>=');		
				$field=$where[0];
				$operator=$where[1];
				$value=$where[2];
			

				if(in_array($operator,$operators))
				{
					$sql= "{$action} FROM {$table} WHERE {$field} {$operator} ?";
					if(!$this->query($sql,array($value))->error())
					{
						return $this;
					}
				}
			}
			return false;
		}

		public function insert($table,$fields = array())		//Automates Insertion into a table 
		{														//Usage - DB::getInstance->insert('users',array('username' =>'Prateek', 'password=>'foobar'))
			if(count($fields))
			{
				$keys = array_keys(($fields));
				$values='';
				$x=1;

				foreach($fields as $field)
				{
					$values.='?';
					if($x<count($fields))
					{
						$values.=',';
					}
					$x++;
				}

			$sql="INSERT INTO {$table} (`".implode('`,`',$keys)."`) VALUES ({$values})"; 
				if(!$this->query($sql,$fields)->error())
				{return $this;}
			}
			return false;
		}

		public function update($table,$col,$id,$fields)				//Updates the database based on the $id provided
		{														//Usage - DB::getInstance->update('users',2,array('username' => 'updated_username'));
			$set='';
			$x=1;
			foreach($fields as $name => $value)
			{
				$set.="{$name} = ?";
				
				if($x<count($fields))
				{
					$set .= ',';
				}
				
				$x++;
			}
		
			$sql = "UPDATE {$table} SET {$set} WHERE {$col}={$id}";

			if(!$this->query($sql,$fields)->error())
			{
				return true;
			}

			return false;
		}

		public function results()								//returns results as an object
		{
			return $this->_results;  
		}

 		public function first()									//returns the first row of the results
		{ 
			$var = $this->results();
			return $var[0];

		}
 
		public function get($table,$where)						//Select * from $table $where condition
		{
			return $this->action('SELECT *', $table, $where);	//Usage - DB::getInstance->get('users',array('id','=','1'))

		}

		public function getall($table)						//Select * from $table $where condition
		{
				//Usage - DB::getInstance->get('users',array('id','=','1'))
			$sql= "SELECT * FROM {$table}";
			$this->_query=$this->_pdo->prepare($sql);
			if($this->_query->execute()){
					$this->_results=$this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count=$this->_query->rowCount();
					return $this;
				} else {
					$this->_error =true;
				}
		}

		public function delete($table,$where)					//Delete from table where condition
		{
			return$this->action('DELETE', $table, $where);
		}

		public function error()									//Returns true if error
		{
			return $this->_error;
		}

		public function count()									//Returns the number of rows affected
		{
			return $this->_count;
		}

		public function last()
		{
			return $this->_id=$this->_pdo->lastInsertId();
		}


	}
?>