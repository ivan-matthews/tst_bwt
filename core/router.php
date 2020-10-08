<?php

	namespace Core;

	class Router{

		private static $instance;

		private $router = array();

		/** @var Config */
		private $config;

		private $current_url;

		private $current_url_path;
		private $current_url_query = array();

		private $current_url_segments = array();

		private $current_url_controller;
		private $current_url_action;
		private $current_url_params = array();

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __get($property){
			if(isset($this->router[$property])){
				return $this->router[$property];
			}
			return null;
		}
		public function __set($property,$value){
			$this->router[$property] = $value;
			return $this->router[$property];
		}

		public function __construct(){
			$this->config = Config::getInstance();
			$this->setRouter($_SERVER['REQUEST_URI']);
		}

		public function setRouter(string $current_url){
			$this->current_url = trim($current_url,'/');
			return $this->parseURL();
		}

		protected function parseURL(){
			$url = parse_url($this->current_url);
			$this->current_url_path = !isset($url['path']) ?: $url['path'];
			return $this->parseURLPath()->parseURLQuery(!isset($url['query']) ?: $url['query']);
		}

		protected function parseURLPath(){
			$this->current_url_segments = explode('/',$this->current_url_path);
			return $this;
		}

		public function setController(){
			$this->current_url_controller = isset($this->current_url_segments[0]) && !empty($this->current_url_segments[0]) ? $this->current_url_segments[0] : $this->config->default_controller;
			$this->current_url_action = isset($this->current_url_segments[1]) && !empty($this->current_url_segments[1]) ? $this->current_url_segments[1] : $this->config->default_action;
			$this->current_url_params = isset($this->current_url_segments[2]) ? array_slice($this->current_url_segments,2) : $this->config->default_params;
			return $this;
		}

		protected function parseURLQuery($request_string){
			parse_str($request_string,$this->current_url_query);
			return $this;
		}

		public function getController(){
			return $this->current_url_controller;
		}

		public function getAction(){
			return $this->current_url_action;
		}

		public function getParams(){
			return $this->current_url_params;
		}




























	}