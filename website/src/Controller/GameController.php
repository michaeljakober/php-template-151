<?php

namespace michaeljakober\Controller;

use michaeljakober\SimpleTemplateEngine;
use michaeljakober\Service\Game\GameService;

class GameController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $gameService;
  private $factory;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, GameService $gameService, $factory)
  {
     $this->template = $template;
     $this->gameService = $gameService;
     $this->factory = $factory;
  }
  
  public function showGame($error = "", $info= ""){
	header("Location: /hangman");
	echo $this->template->render("hangman.html.twig", ["error" => $error, "info" => $info]);
  }

  public function getWord($length){
  	$word = "Sorry, hadn't enough time to make the game. Here's a word with $length Letters: ".$this->gameService->getRandomWordFromLength($length);
  	echo $this->template->render("hangman.html.twig", ["word" => $word]);
  }

  public function addWord(array $data) {
	$info = "";
	$error = "";
	if(strlen($data["inputWord"]) >= 2 && strlen($data["inputWord"]) <= 9) {
		$this->gameService->addWord($data["inputWord"]);
		$info = "Word successfully added";
	} else {
		$error = "Word must be between 2 and 9 Letters";
	}
	$this->showGame($error, $info);
	return;
  }
}
