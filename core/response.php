<?php

	namespace Core;

	class Response{

		private static $instance;

		private $allowed_statuses = array(
			100	=> "100 Continue",
			101	=> "101 Switching Protocol",
			200	=> "200 OK",
			201	=> "201 Created",
			202	=> "202 Accepted",
			203	=> "203 Non-Authoritative Information",
			204	=> "204 No Content",
			205	=> "205 Reset Content",
			206	=> "206 Partial Content",
			300	=> "300 Multiple Choices",
			301	=> "301 Moved Permanently",
			302	=> "302 Found",
			303	=> "303 See Other",
			304	=> "304 Not Modified",
			307	=> "307 Temporary Redirect",
			308	=> "308 Permanent Redirect",
			400	=> "400 Bad Request",
			401	=> "401 Unauthorized",
			403	=> "403 Forbidden",
			404	=> "404 Not Found",
			405	=> "405 Method Not Allowed",
			406	=> "406 Not Acceptable",
			407	=> "407 Proxy Authentication Required",
			408	=> "408 Request Timeout",
			409	=> "409 Conflict",
			410	=> "410 Gone",
			411	=> "411 Length Required",
			412	=> "412 Precondition Failed",
			413	=> "413 Payload Too Large",
			414	=> "414 URI Too Long",
			415	=> "415 Unsupported Media Type",
			416	=> "416 Range Not Satisfiable",
			417	=> "417 Expectation Failed",
			418	=> "418 I'm a teapot",
			422	=> "422 Unprocessable Entity",
			425	=> "425 Too Early",
			426	=> "426 Upgrade Required",
			428	=> "428 Precondition Required",
			429	=> "429 Too Many Requests",
			431	=> "431 Request Header Fields Too Large",
			451	=> "451 Unavailable For Legal Reasons",
			500	=> "500 Internal Server Error",
			501	=> "501 Not Implemented",
			502	=> "502 Bad Gateway",
			503	=> "503 Service Unavailable",
			504	=> "504 Gateway Timeout",
			505	=> "505 HTTP Version Not Supported",
			511	=> "511 Network Authentication Required",
			102	=> '102 Processing',
			103	=> '103 Early Hints',
			305	=> '305 Use Proxy',
			306	=> '306 Switch Proxy',
			402	=> '402 Payment Required'
		);

		private $response = array(
			'redirect_link'	=>'/',
			'code'		=> 200,
			'status'	=> "200 OK",
			'controller'=> "",
			'action'	=> "",
			'headers'	=> array(),
			'content'	=> array(),
			'debug'		=> array(),
			'errors'	=> array(),
		);

		public static function getInstance(){
			if(self::$instance === null){
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct(){

		}

		public function getResponse(){
			return $this->response;
		}

		public function code($response_code){
			$response_code = isset($this->allowed_statuses[$response_code]) ? $response_code : 500;
			$this->response['code'] = $response_code;
			return $this->status($this->allowed_statuses[$response_code]);
		}

		public function status($response_status){
			$this->response['status'] = $response_status;
			return $this;
		}

		public function get($key){
			return isset($this->response[$key]) ? $this->response[$key] : array();
		}

		public function set($key,$response_data){
			$this->response[$key] = $response_data;
			return $this;
		}

		public function header($key,$value){
			$this->response['headers'][$key] = $value;
			return $this;
		}

		public function content($key,$value){
			$this->response['content'][$key] = $value;
			return $this;
		}

		public function sendHeaders(){
			foreach($this->response['headers'] as $key=>$header){
				header("{$key}: {$header}",true,$this->response['code']);
			}
			header("HTTP/1.0 {$this->response['status']}");
			header("HTTP/1.1 {$this->response['status']}");
			header("HTTP/2 {$this->response['status']}");
			header("Status: {$this->response['status']}");
			http_response_code($this->response['code']);
			return $this;
		}



















	}