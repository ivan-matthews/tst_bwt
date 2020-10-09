<?php

	namespace Controllers\Auth\Actions;

	use Controllers\Auth\Controller;
	use Controllers\Auth\Model;
	use Controllers\Auth\Forms\Auth;

	class Index extends Controller{

		/** @var Auth */
		private $form;

		/** @var Model */
		protected $model;

		private $user_info = array();

		public function __construct(){
			parent::__construct();
			$this->form = new Auth($this->request);
		}

		public function getMethod(){
			$this->form->setFormFields();

			$this->response->content('form',$this->form->getForm());
			$this->response->content('fields',$this->form->getFields());
			$this->response->content('errors',$this->form->getErrors());

			return $this;
		}

		public function postMethod(){
			$this->form->setFormFields();

			$this->form->validate();

			if($this->form->can()){
				$login 		= $this->form->getAttribute('login','value');
				$password 	= $this->form->getAttribute('password','value');
				$member_trigger = $this->form->getAttribute('member_me','value');

				$this->user_info = $this->model->getUser($login);

				if($this->form->checkUser($this->user_info) && $this->form->checkPassword($this->user_info['password'],$password)){
					$this->session->authUser($this->user_info, $member_trigger);
					return $this->redirect();
				}
			}

			$this->response->content('form',$this->form->getForm());
			$this->response->content('fields',$this->form->getFields());
			$this->response->content('errors',$this->form->getErrors());

			return $this;
		}




















	}