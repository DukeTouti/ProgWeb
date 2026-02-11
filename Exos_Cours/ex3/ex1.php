<?php

class Robot {
	public $nom;
	private $codeSecret;
	
	public function __construct(string $nom, int $codeSecret) {
		$this->nom = $nom;
		$this->codeSecret = $codeSecret;
	}
}

$robot1 = new Robot("Curiosity", 1234);

echo "Je suis le Robot $robot1->nom";
echo "<br>";
echo $robot1->codeSecret;

?>
