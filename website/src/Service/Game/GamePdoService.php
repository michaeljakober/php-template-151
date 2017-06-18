<?php 
namespace michaeljakober\Service\Game;

class GamePdoService implements GameService
{
	private $pdo;
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	public function getRandomWord()
	{
		$stmt = $this->pdo->prepare("SELECT * FROM word ORDER BY RAND()");
		$stmt->execute();
		return $stmt->fetch()["words"];
	}
	
	public function getRandomWordFromLength($length)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM word WHERE LENGTH(word) = ? ORDER BY RAND()");
		$stmt->bindValue(1, $length);
		$stmt->execute();
		return $stmt->fetch(0)["word"];
	}
}
