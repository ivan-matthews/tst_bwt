<?php

	namespace Core;

	class App{

		private static $instance;

		private $controller;
		private $action;
		private $params = array();

		private $controller_name_space;
		private $action_class;
		/** @var Controller */
		private $action_object;
		private $action_method;

		/** @var Router */
		private $router;
		/** @var Response */
		private $response;
		/** @var Request */
		private $request;
		/** @var Config */
		private $config;

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->request = Request::getInstance();
			$this->router = Router::getInstance();
			$this->response = Response::getInstance();
			$this->setControllerProperties($this->router);
			$this->setActionMethod($this->request->getRequestMethod());
		}

		public function startEngine(){
			$this->setControllerNameSpace();
			if(!$this->getAction()){
				if(!$this->getActionItem()){
					$this->response->code(404);
					return $this;
				}
			}
			return $this;
		}

		protected function getAction(){
			$this->setActionClass();
			if($this->checkAction()){
				return true;
			}
			return false;
		}

		protected function getActionItem(){
			$this->action = "item";
			return $this->getAction();
		}

		protected function setControllerNameSpace(){
			$this->controller_name_space = "Controllers\\{$this->controller}\\Actions";
			return $this;
		}

		protected function setActionClass(){
			$this->action_class = "{$this->controller_name_space}\\{$this->action}";
			return $this;
		}

		protected function checkAction(){
			if($this->getActionObject()){
				if(method_exists($this->action_class,$this->action_method)){
					if($this->countActionArguments($this->action_object,$this->action_method,$this->params)){
						if(call_user_func_array(array($this->action_object,$this->action_method),$this->params)){
							$this->setResponse();
							return true;
						}
					}
					return false;
				}
				$this->response->code(405);
				return true;
			}
			return false;
		}

		protected function setResponse(){
			$this->response->set('controller',$this->controller);
			$this->response->set('action',$this->action);
			return $this;
		}

		protected function getActionObject(){
			if(class_exists($this->action_class)){
				$this->action_object = new $this->action_class;
				return true;
			}
			return false;
		}

		protected function setControllerProperties(Router $router){
			$this->controller = $router->getController();
			$this->action = $router->getAction();
			$this->params = $router->getParams();
			return $this;
		}

		protected function setActionMethod($request_method){
			$this->action_method = "{$request_method}Method";
			return $this;
		}

		protected function countActionArguments($object,$method,$params){
			$total_params = count($params);
			$reflection = new \ReflectionMethod($object,$method);
			if($reflection->getNumberOfParameters() < $total_params){ return false; }
			if($reflection->getNumberOfRequiredParameters() > $total_params){ return false; }
			return true;
		}

		public function getCurrentController(){
			return $this->controller;
		}

		public function getCurrentAction(){
			return $this->action;
		}

		public function getCurrentParams(){
			return $this->params;
		}













	}