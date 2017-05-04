<?php 

namespace michaeljakober;

class Factory{
	private $config;
	public static function createFromIniFile($filename)
	{
		return new Factory(
				parse_ini_file($filename, true)
			);
	}
	
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	
	public function getTemplateEngine() {
		return new SimpleTemplateEngine(__DIR__."/../templates/");
	}
	
	public function getMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance("smtp.gmail.com", 465, "ssl")
				->setUsername("gibz.module.151@gmail.com")
				->setPassword("Pe$6A+aprunu")
				);
	}
	
	public function getIndexController(){
		return new Controller\IndexController(
				$this->getTemplateEngine()
			);
	}
	
	public function getLoginController(){
		return new Controller\LoginController($this->getTemplateEngine(), $this->getLoginService());
	}
	
	public function getPdo() {
		return new \PDO("mysql:host=mariadb;dbname=app;charset=utf8",
				$this->config["database"]["user"],
				"my-secret-pw",
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
				);
	}
	
	public function getLoginService() {
		return new Service\Login\LoginPdoService($this->getPdo());
	}
}