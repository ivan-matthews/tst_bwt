<?php

	namespace Controllers\Auth\Forms;

	use Core\Form;
	use Core\Request;

	class Auth extends Form{

		private $request;

		public function __construct(Request $request){
			parent::__construct();
			$this->request = $request;
			$this->formAttr('action','/auth');
		}

		public function setFormFields(){
			$this->login('login')
				->setAttribute('id','login')
				->setAttribute('placeholder','Enter your login')
				->setAttribute('value',$this->request->get('login'));

			$this->password('password')
				->setAttribute('id','password')
				->setAttribute('placeholder','Enter your password')
				->setAttribute('value',$this->request->get('password'));

			$this->checkbox('member_me')
				->setAttribute('id','member_me')
				->setAttribute('value',$this->request->get('member_me'));

			return $this;
		}

		public function checkPassword($db_password_hash, $request_password){
			if(!eq(encode($request_password), $db_password_hash)){
				$this->setError('password','Wrong password');
				return false;
			}
			return true;
		}

		public function checkUser($user_info){
			if(!$user_info){
				$this->setError('form','User not found');
				return false;
			}
			return true;
		}

	}