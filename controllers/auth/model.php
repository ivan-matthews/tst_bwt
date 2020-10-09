<?php

	namespace Controllers\Auth;

	use Core\Database;
	use Core\Model as ParentModel;

	class Model extends ParentModel{

		/** @var Database */
		private $result;

		public function __construct(){
			parent::__construct();
		}

		public function getUser($login){
			$this->database->query("SELECT * FROM users WHERE login = %login%;");
			$this->database->prepare('%login%', $login);
			$this->result = $this->database->exec();
			return $this->result->item();
		}

		public function addNewUser(array $user_data){
			$this->database->query("INSERT INTO users (name, login, password)  VALUES (%name%, %login%, %password%);");
			$this->database->prepare('%name%', $user_data['name']);
			$this->database->prepare('%login%', $user_data['login']);
			$this->database->prepare('%password%', $user_data['password']);
			$this->result = $this->database->exec();
			return $this->result->id();
		}













	}