<?php

error_reporting(E_ALL);
session_start();

require_once("../vendor/autoload.php");
$factory = michaeljakober\Factory::createFromIniFile(__DIR__. "/../config.ini");

$loginService = $factory->getLoginService();

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		break;
	case "/login":
		$cnt = $factory->getLoginController();
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$cnt->login($_POST);
		} else	{
			$cnt->showLogin();
		}
		break;
	case "/register":
		$cnt = $factory->getLoginController();
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$cnt->register($_POST);
		} else	{
			$cnt->showRegister();
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

