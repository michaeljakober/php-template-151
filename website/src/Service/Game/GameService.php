<?php 
namespace michaeljakober\Service\Game;

interface GameService
{
	public function getRandomWord();
	public function getRandomWordFromLength($length);
}