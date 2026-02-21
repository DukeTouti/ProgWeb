<?php

include 'ex1.php';

class CompteEpargne extends CompteBancaire {
	private $tauxInteret;
	
	public function __construct($titulaire, $soldeInitial, $tauxInteret, $devise = "MAD") {
		parent::__construct($titulaire, $soldeInitial, $devise) ;
		$this->tauxInteret = $tauxInteret ;
	}
	
	public function appliquerInterets() {
		$interets = $this->solde * $this->tauxInteret;
		$this->solde += $interets;
		echo "Intérêts de $interets appliqués <br>";
	}
	
	public function __toString() {
		$tauxAffichage = $this->tauxInteret * 100 ;
		return parent::__toString() . "(Compte Épargne à {$this->tauxInteret})<br>";
	}
}

echo "<h2>Exercice 2</h2>";
$epargne = new CompteEpargne("HATHOUTI Mohammed Taha", 500000, 1.5, "€") ;
$epargne->appliquerInterets() ;
echo $epargne . "<br>" ;

?>
