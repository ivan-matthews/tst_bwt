<?php

	namespace Controllers\Home\Actions;

	use Controllers\Home\Controller;

	class Index extends Controller{

		private $contacts = array();
		private $my_contacts = array();
		private $user_id;

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->user->getId();
			$this->redirectLink('/');
		}

		public function GET(){
			if(!$this->user->logged()){
				return $this->redirect('/auth');
			}

			$this->contacts = $this->model->getAllContacts();
			if($this->contacts){
				$this->my_contacts = $this->model->getUserContactsIDs($this->user_id);

				$this->response->content('contacts',$this->contacts);
				$this->response->content('my_contacts',$this->my_contacts);
				return $this;
			}

			return false;
		}

	}