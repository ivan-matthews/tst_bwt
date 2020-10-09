<?php

	use Core\App;
	use Core\Request;
	use Core\Config;
	use Core\Response;
	use Core\Router;
	use Core\Session;
	use Core\View;

	require "loader.php";

	$config = Config::getInstance();
	$request = Request::getInstance();

	$session = Session::getInstance();
	$session->start();
	$session->validateUser();

	$router = Router::getInstance();
	$router->setController();

	$core = App::getInstance();
	$core->startEngine();

	$response = Response::getInstance();
	$response->sendHeaders();

	$view = View::getInstance();
	$view->ready();



	/* GENERATE SIMPLE CONTACTS */
/*
	$model = new \Controllers\Home\Model;
	$date = time();
	for($i=0;$i<20;$i++){
		$contact_name = "Simple contact {$i}";
		$model->makeContact(array(
			'name'	=> $contact_name,
			'date'	=> $date
		));
	}
*/
