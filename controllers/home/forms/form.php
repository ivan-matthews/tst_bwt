<?php

	namespace Controllers\Home\Forms;

	use Core\Form as ParentForm;
	use Core\Request;

	class Form extends ParentForm{

		private $request;

		public function __construct(Request $request){
			parent::__construct();
			$this->request = $request;
		}

	}