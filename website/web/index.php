<?php

error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$tmpl = new michaeljakober\SimpleTemplateEngine(__DIR__ . "/../templates/");
$pdo = new \PDO("mysql:host=mariadb;dbname=app;charset=utf8",
  			"root",
  			"my-secret-pw",
  			[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
  			);

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		(new michaeljakober\Controller\IndexController($tmpl))->homepage();
		break;
	case "/login":
		$cnt = new michaeljakober\Controller\LoginController($tmpl, $pdo);
		if ($_SERVER["REQUEST_METHOD"] === "Get") {
			$cnt->showLogin();
		} else	{
			$cnt->login($_POST);
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new michaeljakober\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

