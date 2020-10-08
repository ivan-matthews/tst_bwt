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

//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//

		public function required($field_name,$value){
			if($value && !$this->fields[$field_name]['value']){
				$this->setError($field_name,'Field required!');
			}
			return $this;
		}

		public function email($field_name,$value){
			if($value && $value != filter_var($this->fields[$field_name]['value'],FILTER_VALIDATE_EMAIL)){
				$this->setError($field_name,'Field must be valid email');
			}
			return $this;
		}

		public function min($field_name,$value){
			if($value && mb_strlen($this->fields[$field_name]['value']) < $value){
				$this->setError($field_name,'Min size: ' . $value);
			}
			return $this;
		}

		public function max($field_name,$value){
			if($value && mb_strlen($this->fields[$field_name]['value']) > $value){
				$this->setError($field_name,'Max size: ' . $value);
			}
			return $this;
		}

//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//
//----------------------------------------------------------------------------------------//

		public function validate(callable $callback = null){
			if($callback){
				call_user_func($callback,$this);
			}
			$this->validateFields();
			return $this;
		}

		private function validateFields(){
			foreach($this->fields as $field_name => $attributes){
				foreach($attributes as $method => $value){
					if(method_exists($this,$method)){
						call_user_func(array($this,$method),$field_name,$value);
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