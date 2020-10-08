<?php

	namespace Core;

	use Error;
	use MySQLi;

	class Database{

		private static $instance;

		/** @var MySQLi */
		private $connect;
		private $query;
		/** @var object */
		private $result;
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->connect();
		}

		public function __destruct(){
			if($this->connect){
				$this->connect->close();
			}
		}

		public function connect(){
			try{
				$this->connect = new MySQLi(
					$this->config->db_host,
					$this->config->db_user,
					$this->config->db_pass,
					$this->config->db_name,
					$this->config->db_port
				);
			}catch(Error $error){
				dd(array(
					'code'		=> $error->getCode(),
					'message'	=> $error->getMessage(),
					'file'		=> $error->getFile(),
					'line'		=> $error->getLine(),
				));
			}

			$this->setLcMessages($this->config->locale);
			$this->setCharset($this->config->charset);
			$this->setSqlMode($this->config->mode);
			$this->setTimezone();

			return $this->connect;
		}

		private function setCharset($charset){
			$this->connect->set_charset($charset);
			return $this;
		}

		private function setLcMessages($locale){
			$this->exec("SET lc_messages = '{$locale}';");
			return $this;
		}

		private function setSqlMode($sql_mode){
			$this->exec("SET sql_mode='{$sql_mode}';");
			return $this;
		}

		private function setTimezone(){
			$this->exec("SET `time_zone` = '" . date('P') . "';");
			return $this;
		}

		public function exec($sql_query,$prepared_data=array()){
			$this->query = $sql_query;
			if($prepared_data){
				$this->query =$this->prepare($prepared_data);
			}
			$this->result = $this->connect->query($this->query);
			if($this->connect->errno){
				dd($this->connect->error_list,$this->query);
			}
			return $this;
		}

		public function getQuery(){
			return $this->query;
		}

		public function getResult(){
			return $this->result;
		}

		private function prepare(array $prepared_data){
			$data_keys = array();
			$data_values = array();
			foreach($prepared_data as $key=>$value){
				$data_keys[] = $key;
				$data_values[] = $this->prepareValue($value);
			}
			return str_replace($data_keys,$data_values,$this->query);
		}

		private function prepareValue($value){
			if(is_array($value) || is_object($value)){ return "'" . json_encode($value) . "'"; }
			if(is_null($value) || $value === ''){ return "NULL"; }
			if(!$value){ return '0'; }
			return "'" . $this->escape($value) . "'";
		}

		private function escape($data){
			return $this->connect->real_escape_string($data);
		}

		private function close(){
			if($this->result){
				$this->result->close();
			}
			return $this;
		}

		public function id(){
			return $this->connect->insert_id;
		}

		public function rows(){
			return $this->connect->affected_rows;
		}

		public function item(){
			if($this->result){
				$result = $this->result->fetch_assoc();
				$this->close();
				return $result;
			}
			return array();
		}

		public function array(){
			if($this->result){
				$data = array();
				while($data_item = $this->result->fetch_assoc()){
					$data[] = $data_item;
				}
				$this->close();
				return $data;
			}
			return array();
		}
	}