<?php

	namespace Controllers\Auth\Forms;

	use Core\Form;
	use Core\Request;

	class Registration extends Form{

		private $request;

		public function __construct(Request $request){
			parent::__construct();
			$this->request = $request;
			$this->formAttr('action','/auth/registration');
		}

		public function setFormFields(){
			$this->text('name')
				->setAttribute('id','name')
				->setAttribute('value',$this->request->get('name'))
				->setAttribute('placeholder','Enter your name')
				->setAttribute('required',true);

			$this->login('login')
				->setAttribute('id','login')
				->setAttribute('placeholder','Enter your login')
				->setAttribute('value',$this->request->get('login'));

			$this->password('password')
				->setAttribute('id','password')
				->setAttribute('placeholder','Enter your password')
				->setAttribute('value',$this->request->get('password'));

			$this->password('password2')
				->setAttribute('id','password2')
				->setAttribute('placeholder','RE-Enter your password')
				->setAttribute('value',$this->request->get('password2'));

			return $this;
		}

		public function checkPassword($db_password_hash, $request_password){
			if(!eq(encode($request_password), $db_password_hash)){
				$this->setError('password','Wrong password');
				return false;
			}
			return true;
		}

		public function checkUser($user){
			if($user){
				$this->setError('login','Login already exists');
				return false;
			}
			return true;
		}

	}