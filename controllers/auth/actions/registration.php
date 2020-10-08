<?php

	namespace Controllers\Auth\Actions;

	use Controllers\Auth\Controller;
	use Controllers\Auth\Model;
	use Core\Form;

	class Registration extends Controller{

		/** @var Form */
		private $form;

		/** @var Model */
		protected $model;

		private $user_id;

		public function __construct(){
			parent::__construct();
			$this->form = new Form();
			$this->form->formAttr('action','/auth/registration');
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

			$user['login']	= $this->form->getAttribute('login','value');
			$user['name']	= $this->form->getAttribute('name','value');
			$user['password']	= $this->form->getAttribute('password','value');
			$user['password2']	= $this->form->getAttribute('password2','value');

			$this->form->validate(function(Form $form){
				$password = $form->getAttribute('password','value');
				$password2 = $form->getAttribute('password2','value');
				if($password !== $password2){
					$form->setError('form','Passwords not equal');
				}
			});

			if($this->form->can()){
				if($this->checkUser($user['login'])){
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

		private function setFormFields(){
			$this->form->text('name')
				->setAttribute('id','name')
				->setAttribute('value',$this->request->get('name'))
				->setAttribute('placeholder','Enter your name')
				->setAttribute('required',true);

			$this->form->login('login')
				->setAttribute('id','login')
				->setAttribute('placeholder','Enter your login')
				->setAttribute('value',$this->request->get('login'));

			$this->form->password('password')
				->setAttribute('id','password')
				->setAttribute('placeholder','Enter your password')
				->setAttribute('value',$this->request->get('password'));

			$this->form->password('password2')
				->setAttribute('id','password2')
				->setAttribute('placeholder','RE-Enter your password')
				->setAttribute('value',$this->request->get('password2'));

			return $this;
		}

		private function checkUser($login){
			$user = $this->model->getUser($login);
			if($user){
				$this->form->setError('login','Login already exists');
				return false;
			}
			return true;
		}

















	}