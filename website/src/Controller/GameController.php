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
  
  public function showGame(){
  	echo $this->template->render("hangman.html.twig");
  }
  
  public function getWord($length){
  	$word = "Sorry, hadn't enough time to make the game. Here's a word with $length Letters: ".$this->gameService->getRandomWordFromLength($length);
  	echo $this->template->render("hangman.html.twig", ["word" => $word]);
  }
}
