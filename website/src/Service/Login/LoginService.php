<?php 
namespace michaeljakober\Service\Login;

interface LoginService
{
	public function authenticate($username, $password);
}