<?php

	namespace Core;

	/**
	 * Class Config
	 * @package Core
	 * @property string $db_host
	 * @property string $db_port
	 * @property string $db_user
	 * @property string $db_pass
	 * @property string $db_name
	 * @property string $charset
	 * @property string $mode
	 * @property string $locale
	 * @property string $default_controller
	 * @property string $default_action
	 * @property array $default_params
	 * @property string $crypt_key
	 */
	class Config{

		private static $instance;

		private $config = array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($property){
			if(isset($this->config[$property])){
				return $this->config[$property];
			}
			return null;
		}

		public function __set($property,$value){
			$this->config[$property] = $value;
			return $this->config[$property];
		}

		public function __construct(){
			$this->setConfigFile();
		}

		public function setConfigFile($file_name = "assets/config.php"){
			$this->config = include $file_name;
			return $this;
		}

		public function getConfig(){
			return $this->config;
		}
	}