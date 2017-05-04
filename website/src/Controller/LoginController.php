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
  public function __construct(SimpleTemplateEngine $template, LoginService $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }

  public function showLogin()
  {
  	echo $this->template->render("login.html.php");
  }
  
  public function login(array $data)
  {
  	if (!array_key_exists("email", $data) OR !array_key_exists("password", $data)) {
  		$this->showLogin();
  		return;
  	}
  	
  	
  	if($this->LoginService->authenticate($data["email"], $data["password"])) {
  		header("location: /");
  		
  	} else {
  		echo $this->template->render("login.html.php", [
  			"email" => $data["email"]
  				
  		]);
  	}
  }
}
