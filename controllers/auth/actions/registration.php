<?php

	namespace Controllers\Auth\Actions;

	use Controllers\Auth\Controller;
	use Controllers\Auth\Model;
	use Controllers\Auth\Forms\Registration as RegistrationForm;

	class Registration extends Controller{

		/** @var RegistrationForm */
		private $form;

		/** @var Model */
		protected $model;

		private $user_id;

		public function __construct(){
			parent::__construct();
			$this->form = new RegistrationForm($this->request);
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

			$user['login']	= $this->form->getAttribute('login','value');
			$user['name']	= $this->form->getAttribute('name','value');
			$user['password']	= $this->form->getAttribute('password','value');
			$user['password2']	= $this->form->getAttribute('password2','value');

			$this->form->validate(function(RegistrationForm $form){
				$password = $form->getAttribute('password','value');
				$password2 = $form->getAttribute('password2','value');
				if($password !== $password2){
					$form->setError('form','Passwords not equal');
				}
			});

			if($this->form->can()){
				if($this->form->checkUser($this->model->getUser($user['login']))){
					$user['password'] = encode($user['password']);
					$this->user_id = $this->model->addNewUser($user);
					if($this->user_id){
						return $this->redirect('/home');
					}
					$this->form->setError('form','Some error problem...');
				}
			}

			$this->response->content('form',$this->form->getForm());
			$this->response->content('fields',$this->form->getFields());
			$this->response->content('errors',$this->form->getErrors());

			return $this;
		}


















	}