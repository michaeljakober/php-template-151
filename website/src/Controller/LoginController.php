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
  
  /**
   * @param michaeljakober\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, LoginService $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }

  public function showLogin()
  {
  	echo $this->template->render("login.html.twig");
  }
  
  public function showRegister($email = "", $username = "", $error = "")
  {
	echo $this->template->render("register.html.twig", ["email" => $email, "username" => $username, "error" => $error] );
  }
  
  public function login(array $data)
  {
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data)) {
  		$this->showLogin();
  		return;
  	}
  	
  	
  	if($this->loginService->authenticate($data["email"], $data["password"])) {
  		header("location: /");
  		
  	} else {
  		echo $this->template->render("login.html.twig", [
  			"email" => $data["email"]
  		]);
  	}
  }
  
  public function register(array $data)
  {
  	$error = "";
  	// Check if everything is entered
  	if(!isset($data["email"]) || trim($data["email"] == ''))
  	{
  		$error = $error."<br />Please enter a email!";
  	}
  	if(!isset($data["username"]) || trim($data["username"] == ''))
  	{
  		$error = $error."<br />Please enter a username!";
  	}
  	if(!isset($data["password"]) || trim($data["password"] == ''))
  	{
  		$error = $error."<br />Please enter a password!";
  	}
  	if ($this->loginService->existsEmail($data["email"]))
  	{
  		$error = $error."<br />Diese Email wurde bereits registriert!";
  	}
  	if(!isset($error["email"]) && !isset($error["username"]) && !isset($error["password"]))
  	{
  		$this->loginService->createUser($data["username"], $data["email"], $data["password"]);
  		return;
  	}
  	echo $this->showRegister($data["email"], $data["username"], $error);
  }
}
