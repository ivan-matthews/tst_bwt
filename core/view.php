<?php

	namespace Core;

	class View{

		private static $instance;

		private $view = array();

		/** @var Response */
		private $response;

		/** @var User */
		public $user;

		private $content = array();
		private $response_code;

		private $controller;
		private $action;

		private $view_path = 'view';
		public $render_data = '';

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($property){
			if(isset($this->view[$property])){
				return $this->view[$property];
			}
			return null;
		}
		public function __set($property,$value){
			$this->view[$property] = $value;
			return $this->view[$property];
		}

		public function __construct(){
			$this->response = Response::getInstance();
			$this->user = User::getInstance();

			$this->response_code = $this->response->get('code');
			$this->controller = $this->response->get('controller');
			$this->action = $this->response->get('action');
			$this->content = $this->response->get('content');
		}

		public function printContent(){
			print $this->render_data;
			return $this;
		}

		public function ready(){
			$this->checkErrors();
			$this->renderController();
			$this->renderMainTplFile();
			return $this;
		}

		public function render($file, array $content){
			ob_start();
			extract($content);
			include $file;
			return ob_get_clean();
		}

		private function renderMainTplFile(){
			include get_path("{$this->view_path}/index.html.php");
			return $this;
		}

		private function renderController(){
			$action_file = get_path("{$this->view_path}/controllers/{$this->controller}/{$this->action}.html.php");
			if(file_exists($action_file)){
				$this->render_data .= $this->render($action_file,$this->content);
			}
			return $this;
		}

		private function checkErrors(){
			$error_file = get_path("{$this->view_path}/assets/{$this->response_code}.html.php");
			if(file_exists($error_file)){
				$this->render_data = $this->render($error_file,array());
			}
			return $this;
		}

		public function renderMenu($menu_name){
			$menu_file = get_path("{$this->view_path}/assets/{$menu_name}_menu.html.php");
			return $this->render($menu_file,array());
		}

		public function renderForm(array $form_data){
			$form_file = get_path("{$this->view_path}/assets/form_template.html.php");
			return $this->render($form_file, $form_data);
		}

		public function renderField($field_type, array $field_data, $errors = null){
			$field_file = get_path("{$this->view_path}/assets/fields/{$field_type}.html.php");
			return $this->render($field_file, array('field'=>$field_data, 'errors'=>$errors));
		}

		public function makeAttributesString($form_attributes){
			$form_string = '';
			foreach($form_attributes as $name => $attribute){
				$form_string .= "{$name}=\"{$attribute}\" ";
			}
			return trim($form_string);
		}


















	}