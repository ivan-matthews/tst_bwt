<?php

	namespace Controllers\Auth\Actions;

	use Controllers\Auth\Controller;
	use Controllers\Auth\Model;
	use Core\Form;

	class Index extends Controller{

		/** @var Form */
		private $form;

		/** @var Model */
		protected $model;

		private $user_info;

		public function __construct(){
			parent::__construct();
			$this->form = new Form();
			$this->form->formAttr('action','/auth');
		}

		public function GET(){
			$this->setFormFields();

			$this->response->content('form',$this->form->getForm());
			$this->response->content('fields',$this->form->getFields());
			$this->response->content('errors',$this->form->getErrors());

			return $this;
		}

		public function POST(){
			$this->setFormFields();

			$this->form->validate();

			if($this->form->can()){
				$login 		= $this->form->getAttribute('login','value');
				$password 	= $this->form->getAttribute('password','value');
				$member_trigger = $this->form->getAttribute('member_me','value');

				$this->user_info = $this->model->getUser($login);

				if($this->checkUser() && $this->checkPassword($this->user_info['password'],$password)){
					$this->session->authUser($this->user_info, $member_trigger);
					return $this->redirect();
				}
			}

			$this->response->content('form',$this->form->getForm());
			$this->response->content('fields',$this->form->getFields());
			$this->response->content('errors',$this->form->getErrors());

			return $this;
		}

		private function setFormFields(){
			$this->form->login('login')
				->setAttribute('id','login')
				->setAttribute('placeholder','Enter your login')
				->setAttribute('value',$this->request->get('login'));

			$this->form->password('password')
				->setAttribute('id','password')
				->setAttribute('placeholder','Enter your password')
				->setAttribute('value',$this->request->get('password'));

			$this->form->checkbox('member_me')
				->setAttribute('id','member_me')
				->setAttribute('value',$this->request->get('member_me'));

			return $this;
		}

		private function checkPassword($db_password_hash, $request_password){
			if(encode($request_password) !== $db_password_hash){
				$this->form->setError('password','Wrong password');
				return false;
			}
			return true;
		}

		private function checkUser(){
			if(!$this->user_info){
				$this->form->setError('form','User not found');
				return false;
			}
			return true;
		}




















	}