<?php

	namespace Controllers\Home;

	use Core\Model as ParentModel;

	class Model extends ParentModel{

		private $result;

		public function __construct(){
			parent::__construct();
		}

		public function getAllContacts(){
			$query = "SELECT * FROM contacts";
			$this->result = $this->database->exec($query);
			return $this->result->array();
		}

		public function getUserContactsIDs($user_id){
			$query = "SELECT contact_id FROM users_contacts WHERE user_id = %user_id%;";
			$replace_data = array(
				'%user_id%'	=> $user_id
			);
			$this->result = $this->database->exec($query,$replace_data)->array();
			if($this->result){
				$ids_list = array();
				foreach($this->result as $item){
					$ids_list[] = $item['contact_id'];
				}
				return $ids_list;
			}
			return $this->result;
		}

		public function getUserContacts($user_id){
			$fields = "contacts.id,users_contacts.date_created,contacts.name";
			$query = "SELECT {$fields} FROM users_contacts LEFT JOIN contacts ON contact_id = contacts.id WHERE user_id = %user_id%;";
			$replace_data = array(
				'%user_id%'	=> $user_id
			);
			$this->result = $this->database->exec($query,$replace_data);
			return $this->result->array();
		}

		public function addUserContact($user_id,$contact_id){
			$query = "INSERT INTO users_contacts (user_id, contact_id, date_created) VALUES (%user_id%, %contact_id%, %date_created%)";
			$replace_data = array(
				'%user_id%'		=> $user_id,
				'%contact_id%'	=> $contact_id,
				'%date_created%'=> time(),
			);
			$this->result = $this->database->exec($query,$replace_data);
			return $this->result->rows();
		}

		public function deleteUserContactById($user_id,$contact_id){
			$query = "DELETE FROM users_contacts WHERE contact_id = %contact_id% AND user_id = %user_id%;";
			$this->result = $this->database->exec($query,array(
				'%user_id%'	=> $user_id,
				'%contact_id%'	=> $contact_id,
			));
			return $this->result->rows();
		}

		public function makeContact(array $contact_data){
			$query = "INSERT INTO contacts (name, date_created) VALUES (%name%, %date%)";
			$this->result = $this->database->exec($query,array(
				'%name%' => $contact_data['name'],
				'%date%' => $contact_data['date'],
			));
			return $this->result->id();
		}














	}