<?php

	namespace Core;

	class Validator{

		/** @var Form */
		private $form_instance;

		private $fields = array();

		public function __construct(Form $form_instance, $fields){
			$this->form_instance = $form_instance;
			$this->fields = $fields;
		}

		public function required($field_name,$value){
			if($value && !$this->fields[$field_name]['value']){
				$this->form_instance->setError($field_name,'Field required!');
			}
			return $this;
		}

		public function email($field_name,$value){
			if($value && $value != filter_var($this->fields[$field_name]['value'],FILTER_VALIDATE_EMAIL)){
				$this->form_instance->setError($field_name,'Field must be valid email');
			}
			return $this;
		}

		public function min($field_name,$value){
			if($value && mb_strlen($this->fields[$field_name]['value']) < $value){
				$this->form_instance->setError($field_name,'Min size: ' . $value);
			}
			return $this;
		}

		public function max($field_name,$value){
			if($value && mb_strlen($this->fields[$field_name]['value']) > $value){
				$this->form_instance->setError($field_name,'Max size: ' . $value);
			}
			return $this;
		}

	}