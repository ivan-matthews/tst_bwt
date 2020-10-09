<?php

	namespace Controllers\Auth\Actions;

	use Controllers\Auth\Controller;

	class Logout extends Controller{

		public function __construct(){
			parent::__construct();
		}

		public function getMethod(){
			if(!$this->user->logged()){
				return $this->redirect('/auth');
			}
			$this->session->destroySession();
			return $this->redirect('/');
		}

	}