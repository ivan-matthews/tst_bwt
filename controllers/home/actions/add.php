<?php

	namespace Controllers\Home\Actions;

	use Controllers\Home\Controller;

	class Add extends Controller{

		private $user_id;
		private $contact_id;
		private $user_contact_id;

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->user->getId();
		}

		public function GET($contact_id){
			if(!$this->user->logged()){
				return $this->redirect('/auth');
			}
			$this->contact_id = $contact_id;

			$this->user_contact_id = $this->model->addUserContact($this->user_id,$this->contact_id);

			if($this->user_contact_id){
				return $this->redirect('/');
			}

			return false;
		}

	}