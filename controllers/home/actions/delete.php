<?php

	namespace Controllers\Home\Actions;

	use Controllers\Home\Controller;

	class Delete extends Controller{

		private $user_id;
		private $contact_id;
		private $redirect_link;

		public function __construct(){
			parent::__construct();
			$this->user_id = $this->user->getId();
			$this->redirect_link = $this->session->getSession('redirect_link');
		}

		public function GET($contact_id){
			if(!$this->user->logged()){
				return $this->redirect('/auth');
			}
			$this->contact_id = $contact_id;

			if($this->model->deleteUserContactById($this->user_id,$this->contact_id)){
				return $this->redirect($this->redirect_link);
			}

			return false;
		}

	}