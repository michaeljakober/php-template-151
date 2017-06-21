<?php

error_reporting(E_ALL);
session_start();

require_once("../vendor/autoload.php");
$factory = michaeljakober\Factory::createFromIniFile(__DIR__. "/../config.ini");

$loginService = $factory->getLoginService();

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->showIndex();
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
	case "/logout":
		$cnt = $factory->getLoginController();
		$cnt->logout();
		break;
	case "/hangman":
		$cnt = $factory->getGameController();
		if($_SERVER["REQUEST_METHOD"] === "POST") {
			$cnt->addWord($_POST);
		} else {
			$cnt->showGame();
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		else if (preg_match("/hangman\?length\=/", $_SERVER["REQUEST_URI"])){
			$cnt = $factory->getGameController();
			if($_GET["length"] == "random") {
				$cnt->getWord();
			} else {
				$cnt->getWordFromLength($_GET["length"]);
			}
			break;
		}
		else {
			$factory->getIndexController()->showIndex();
			break;
		}
}

