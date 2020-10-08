<?php

	namespace Core;

	class Request{

		private static $instance;

		private $request = array();
		private $request_method = 'GET';

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($property){
			if(isset($this->request[$property])){
				return $this->request[$property];
			}
			return null;
		}
		public function __set($property,$value){
			$this->request[$property] = $value;
			return $this->request[$property];
		}

		public function __construct(){
			$this->setRequest($_REQUEST);
			$this->setRequestMethod($_SERVER['REQUEST_METHOD']);
		}

		public function setRequest(array $request){
			$this->request = $request;
			return $this;
		}

		public function setRequestMethod($request_method){
			$this->request_method = $request_method;
			return $this;
		}

		public function getRequestMethod(){
			return $this->request_method;
		}

		public function get($key){
			if(isset($this->request[$key]) && !is_array($this->request[$key])){
				return $this->request[$key];
			}
			return null;
		}





























	}