<?php

	namespace Core;

	class Form{

		private $field;
		private $fields = array();
		private $errors = array();
		private $form = array();

		private $status = true;

		public function __construct(){
			$this->setDefaultFormAttributes();
		}

		protected function setDefaultFormAttributes(){
			$this->formAttr('method','POST');
			$this->formAttr('accept-charset','UTF-8');
			$this->formAttr('autocomplete','on');
			$this->formAttr('enctype','application/x-www-form-urlencoded');
			return $this;
		}

		public function getFields(){
			return $this->fields;
		}
		public function getErrors(){
			return $this->errors;
		}
		public function getForm(){
			return $this->form;
		}

		public function formAttr($name,$value){
			$this->form[$name] = $value;
			return $this;
		}

		public function password($field_name){
			$this->field = $field_name;
			$this->setAttribute('name',$this->field)
				->setAttribute('required',true)
				->setAttribute('type','password')
				->setAttribute('min',6);
			return $this;
		}

		public function login($field_name){
			$this->field = $field_name;
			$this->setAttribute('name',$this->field)
				->setAttribute('type','email')
				->setAttribute('required',true)
				->setAttribute('email',true);
			return $this;
		}

		public function text($field_name){
			$this->field = $field_name;
			$this->setAttribute('name',$this->field)
				->setAttribute('type','text');
			return $this;
		}

		public function checkbox($field_name){
			$this->field = $field_name;
			$this->setAttribute('name',$this->field)
				->setAttribute('type','checkbox')
				->setAttribute('checked',false);
			return $this;
		}

		public function setAttribute($field_attribute_name,$field_attribute_value){
			$this->fields[$this->field][$field_attribute_name] = $field_attribute_value;
			return $this;
		}

		public function getAttribute($field_name,$attribute_name){
			if(isset($this->fields[$field_name][$attribute_name])){
				return $this->fields[$field_name][$attribute_name];
			}
			return null;
		}

		public function validate(callable $callback = null){
			if($callback){
				call_user_func($callback,$this);
			}
			$this->validateFields();
			return $this;
		}

		private function validateFields(){
			$validator = new Validator($this,$this->fields);
			foreach($this->fields as $field_name => $attributes){
				foreach($attributes as $method => $value){
					if(method_exists($validator,$method)){
						call_user_func(array($validator,$method),$field_name,$value);
					}
				}
			}
			return $this;
		}

		public function setError($field_name,$error){
			$this->status = false;
			$this->errors[$field_name][] = $error;
			return $this;
		}

		public function can(){
			return $this->status;
		}










	}