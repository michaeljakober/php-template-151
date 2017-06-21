<?php

namespace michaeljakober\Controller;

use michaeljakober\SimpleTemplateEngine;
use michaeljakober\Service\Login\LoginService;

class LoginController 
{
  /**
   * @var michaeljakober\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @var michaeljakober\Service\Login\LoginService
   */
  private $loginService;
  
  private $factory;
  
  /**
   * @param michaeljakober\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, LoginService $loginService, $factory)
  {
     $this->template = $template;
     $this->loginService = $loginService;
     $this->factory = $factory;
  }

  public function showLogin($email = "", $error = "")
  {
  	$csrf = $this->factory->generateCsrf("login");
	$_SESSION["loginCsrf"] = $csrf;
  	echo $this->template->render("login.html.twig", ["loginCsrf" => $csrf, "email" => $email, "error" => $error]);
  }
  
  public function showRegister($email = "", $username = "", $error = "")
  {
  	session_regenerate_id();
  	$csrf = $this->factory->generateCsrf("register");
	$_SESSION["registerCsrf"] = $csrf;
	echo $this->template->render("register.html.twig", ["registerCsrf" => $csrf, "email" => $email, "username" => $username, "error" => $error] );
  }
  
  public function login(array $data)
  {

	if (!array_key_exists("loginCsrf", $data) && !isset($data["loginCsrf"]) && trim($data["loginCsrf"]) == '' && $_SESSION["loginCsrf"] != $data["loginCsrf"])
	{
		$this->showLogin("", "Please don't Hack");
		return;
	}

	if (!array_key_exists("email", $data) || !array_key_exists("password", $data)) {
		$this->showLogin();
		return;
	}
  	
  	$error = "";
  	if(!isset($data["email"]) || trim($data["email"] == ''))
  	{
  		$error = $error." Please enter a email!";
  	}
  	if(!isset($data["password"]) || trim($data["password"] == ''))
  	{
  		$error = $error." Please enter a password!";
	}
	if(!$this->loginService->authenticate($data["email"], $data["password"]) && (!isset($error) || trim($error == '')))
	{
		$error = $error ." Email or password is wrong!";
	}
  	
	if(!isset($error) || trim($error == '')) {
  		session_regenerate_id();
  		$_SESSION["email"] = $data["email"];
  		$_SESSION["LoggedIn"] = true;
  		header("Location: /hangman");
  		echo $this->template->render("hangman.html.twig", [
  				"email" => $data["email"]
  		]);
  	} else {
  		echo $this->showLogin($data["email"], $error);
  	}
  }
  
  public function logout()
  {
  	session_destroy();
	header("Location: /");
  	return;
  }
  
  public function register(array $data)
  {
	if (!array_key_exists("registerCsrf", $data) && !isset($data["registerCsrf"]) && trim($data["registerCsrf"]) == '' && $_SESSION["registerCsrf"] != $data["registerCsrf"])
	{
		$this->showRegister("","","Please don't Hack");
		return;
	}

  	$error = "";
  	// Check if everything is entered
  	if(!isset($data["email"]) || trim($data["email"] == ''))
  	{
  		$error = $error." Please enter a email!";
  	}
  	if(!isset($data["username"]) || trim($data["username"] == ''))
  	{
  		$error = $error." Please enter a username!";
  	}
  	if(!isset($data["password"]) || trim($data["password"] == ''))
  	{
  		$error = $error." Please enter a password!";
  	}
  	if ($this->loginService->existsEmail($data["email"]))
  	{
  		$error = $error." This Email is already in use!";
  	}
	if(!isset($error) || trim($error == ''))
  	{
  		$this->loginService->createUser($data["username"], $data["email"], $data["password"]);
		$this->login($data);
  		return;
  	}
  	echo $this->showRegister($data["email"], $data["username"], $error);
  }
}
