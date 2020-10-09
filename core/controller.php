<?php

	namespace Core;

	class Controller{

		private static $instance;

		/** @var Session */
		protected $session;

		/** @var Response */
		protected $response;

		/** @var Request */
		protected $request;

		/** @var User */
		protected $user;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->request = Request::getInstance();
			$this->session = Session::getInstance();
			$this->response = Response::getInstance();
			$this->user = User::getInstance();
		}

		protected function redirect($link_to_redirect = null, $redirect_code = 302){
			$link_to_redirect = trim($link_to_redirect,'/');
			$this->response->code($redirect_code)
				->header('Location', "/{$link_to_redirect}");
			return $this;
		}

		protected function controller($controller_name){
			$this->response->set('controller',$controller_name);
			return $this;
		}

		protected function action($action_name){
			$this->response->set('action',$action_name);
			return $this;
		}

		protected function redirectLink($link){
			$this->session->setSession('redirect_link',$link);
			return $this;
		}

		protected function getConfig($controller){
			return include get_path("controllers/{$controller}/assets/config.php");
		}

























	}