<?php

	namespace Core;

	class User{

		private $session;

		private $user_id;

		private static $instance;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->session = Session::getInstance();
			$this->user_id = $this->session->getSession('id');
		}

		public function logged(){
			if($this->user_id){
				return true;
			}
			return false;
		}

		public function getId(){
			return $this->user_id;
		}

		public function getName(){
			return $this->session->getSession('name');
		}

		public function getLogin(){
			return $this->session->getSession('login');
		}

		public function getPassword(){
			return $this->session->getSession('password');
		}

	}