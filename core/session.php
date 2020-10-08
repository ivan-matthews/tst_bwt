<?php

	namespace Core;

	class Session{

		private static $instance;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($property){
			return $this->getSession($property);
		}
		public function __set($property,$value){
			return $this->setSession($property,$value);
		}

		public function __construct(){

		}

		public function start(){
			session_start();
			return $this;
		}

		public function get(){
			return $_SESSION;
		}

		public function getSession($session_name){
			if(isset($_SESSION[$session_name])){
				return $_SESSION[$session_name];
			}
			return null;
		}

		public function setSession($session_name,$session_value){
			$_SESSION[$session_name] = $session_value;
			return $this;
		}

		public function unsetSession($session_name){
			if(isset($_SESSION[$session_name])){
				unset($_SESSION[$session_name]);
			}
			return $this;
		}

		public function isSession($session_name){
			if(isset($_SESSION[$session_name])){
				return true;
			}
			return false;
		}

		public function setCookie($cookie_name,$cookie_value,$cookie_time,$cookie_path='/',$http_only=true,$secure=false,$domain=null){
			$cookie_time = $cookie_time ? $cookie_time + time() : 0;
			setcookie($cookie_name,$cookie_value,$cookie_time,$cookie_path,$domain,$secure,$http_only);
			return $this;
		}

		public function getCookie($cookie_name){
			if(isset($_COOKIE[$cookie_name])){
				return $_COOKIE[$cookie_name];
			}
			return null;
		}

		public function isCookie($cookie_name){
			if(isset($_COOKIE[$cookie_name])){
				return true;
			}
			return false;
		}

		public function unsetCookie($cookie_name){
			$this->setCookie($cookie_name,null,-1);
			return $this;
		}

		public function validateUser(){
			$cookie_token = $this->getCookie('member');
			$session_token = $this->getSession('member');
			if($cookie_token && $session_token){
				if(encode($session_token) === $cookie_token){
					return $this;
				}
			}
			$this->destroySession();
			return $this;
		}

		public function destroySession(){
			foreach($_SESSION as $key => $value){
				$this->unsetSession($key);
			}
			$this->unsetCookie('member');
			return $this;
		}

		public function authUser(array $user_data,$member_trigger){
			if($user_data){
				foreach($user_data as $key => $value){
					$this->setSession($key,$value);
				}
			}

			$generated = gen(64);
			$cookie_value = encode($generated);
			$cookie_token = $generated;
			$cookie_time = 0;

			if($member_trigger){
				$cookie_time = 86400;
			}

			$this->setCookie('member',$cookie_value,$cookie_time);
			$this->setSession('member',$cookie_token);

			return $this;
		}





















	}