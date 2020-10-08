<?php

	namespace Core;

	class Model{

		private static $instance;

		/** @var Database */
		protected $database;

		public function __construct(){
			$this->database = Database::getInstance();
		}




















	}