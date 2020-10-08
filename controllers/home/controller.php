<?php

	namespace Controllers\Home;

	use Core\Controller as ParentController;

	class Controller extends ParentController{

		/** @var Model */
		protected $model;

		public function __construct(){
			parent::__construct();
			$this->model = new Model();
		}










	}