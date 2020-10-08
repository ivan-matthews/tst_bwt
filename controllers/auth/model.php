<?php

	namespace Controllers\Auth;

	use Core\Model as ParentModel;

	class Model extends ParentModel{

		private $result;

		public function __construct(){
			parent::__construct();
		}

		public function getUser($login){
			$query = "SELECT * FROM users WHERE login = %login%;";
			$this->result = $this->database->exec( $query,array(
				'%login%'		=> $login,
			));
			return $this->result->item();
		}

		public function addNewUser(array $user_data){
			$query = "INSERT INTO users (name, login, password)  VALUES (%name%, %login%, %password%);";
			$this->result = $this->database->exec($query,array(
				'%name%'	=> $user_data['name'],
				'%login%'	=> $user_data['login'],
				'%password%'	=> $user_data['password'],
			));
			return $this->result->id();
		}













	}