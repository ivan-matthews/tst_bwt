<?php

	define('ROOT',__DIR__);
	define('TIME',microtime(true));

	date_default_timezone_set("Europe/London");

	error_reporting(E_ALL);
	ini_set('display_errors','1');

	spl_autoload_register('autoload');

	function autoload($class_name){
		$class_file_path = str_replace('\\','/',$class_name);
		$class_file = strtolower(get_path("{$class_file_path}.php"));
		if(file_exists($class_file)){
			include_once $class_file;
			return true;
		}
		return false;
	}

	function get_path($file_name){
		$file_name = trim($file_name,'/');
		return ROOT . "/{$file_name}";
	}

	function pre(...$data){
		print "<pre>";
		print_r(...$data);
		print "</pre>";
		die;
	}

	function dd(...$data){
		print "<pre>";
		var_dump($data);
		print "</pre>";
		die;
	}

	function encode($decode_value){
		$crypt_key = \Core\Config::getInstance()->crypt_key;
		return md5(
			sha1(
			md5($decode_value) . $crypt_key .
				sha1($decode_value) . $crypt_key
			) .
			md5(
				sha1($decode_value) . $crypt_key .
				md5($decode_value) . $crypt_key
			)
		);
	}

	function gen($length = 32){
		$letters[] = range('a','z');
		$letters[] = range('A','Z');
		$letters[] = range('0','9');
		$letters = array_merge(...$letters);
		shuffle($letters);
		$last_pos = max(array_keys($letters));
		$new_string = '';
		for($increment = 0; $increment < $length; $increment++){
			$new_string .= $letters[rand(0,$last_pos)];
		}
		return $new_string;
	}


















