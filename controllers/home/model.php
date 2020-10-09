<?php

	namespace Controllers\Home;

	use Core\Model as ParentModel;

	class Model extends ParentModel{

		private $result;

		public function __construct(){
			parent::__construct();
		}

		public function getAllContacts(){
			$this->database->query("SELECT * FROM contacts");
			$this->result = $this->database->exec();
			return $this->result->array();
		}

		public function getUserContactsIDs($user_id){
			$this->database->query("SELECT contact_id FROM users_contacts WHERE user_id = %user_id%;");
			$this->database->prepare('%user_id%', $user_id);
			$this->result = $this->database->exec()->array();
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
			$this->database->query("SELECT {$fields} FROM users_contacts LEFT JOIN contacts ON contact_id = contacts.id WHERE user_id = %user_id%;");
			$this->database->prepare('%user_id%', $user_id);
			$this->result = $this->database->exec();
			return $this->result->array();
		}

		public function addUserContact($user_id,$contact_id){
			$this->database->query("INSERT INTO users_contacts (user_id, contact_id, date_created) VALUES (%user_id%, %contact_id%, %date_created%)");
			$this->database->prepare('%user_id%', $user_id);
			$this->database->prepare('%contact_id%', $contact_id);
			$this->database->prepare('%date_created%', time());
			$this->result = $this->database->exec();
			return $this->result->rows();
		}

		public function deleteUserContactById($user_id,$contact_id){
			$this->database->query("DELETE FROM users_contacts WHERE contact_id = %contact_id% AND user_id = %user_id%;");
			$this->database->prepare('%user_id%', $user_id);
			$this->database->prepare('%contact_id%',$contact_id);
			$this->result = $this->database->exec();
			return $this->result->rows();
		}

		public function makeContact(array $contact_data){
			$this->database->query("INSERT INTO contacts (name, date_created) VALUES (%name%, %date%)");
			$this->database->prepare('%name%',$contact_data['name']);
			$this->database->prepare('%date%', $contact_data['date']);
			$this->result = $this->database->exec();
			return $this->result->id();
		}














	}