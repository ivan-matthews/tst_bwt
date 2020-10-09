<?php

	namespace Controllers\Auth;

	use Core\Controller as ParentController;

	class Controller extends ParentController{

		/** @var Model */
		protected $model;

		protected $params;

		public function __construct(){
			parent::__construct();
			$this->model = new Model();
			$this->params = $this->getConfig('auth');
		}
















	}