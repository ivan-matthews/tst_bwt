<?php

	namespace Controllers\Home\Actions;

	use Controllers\Home\Controller;

	class Contacts extends Controller{

		private $user_id;
		protected $contacts = array();

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->user->getId();
			$this->redirectLink('/home/contacts');
		}

		public function getMethod(){
			if(!$this->user->logged()){
				return $this->redirect('/auth');
			}

			$this->contacts = $this->model->getUserContacts($this->user_id);

			if($this->contacts){
				$this->response->content('contacts',$this->contacts);

				return $this;
			}
			return false;
		}

	}