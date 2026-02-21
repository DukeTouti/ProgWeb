<?php

class CompteBancaire {
	protected string $titulaire ;
	protected float $solde ;
	protected string $devise ;
	
	public function __construct($titulaire, $soldeInitial, $devise = "MAD") {
		$this->titulaire = $titulaire ;
		$this->solde = $soldeInitial ;
		$this->devise = $devise ;
	}
	
	public function getSolde() {
		return $this->solde ;
	}
	
	public function deposer($montant) {
		if ($montant > 0) {
			$this->solde += $montant ;
			echo "Dépôt de {$montant} {$this->devise} effectué <br>" ;
		}
	}
	
	public function retirer($montant) {
		if ($montant <= $this->solde) {
			$this->solde -= $montant ;
			echo "Retrait de {$montant} {$this->devise} effectué <br>" ;
		} else {
			echo "Votre solde est insuffisant <br>" ;
		}
	}
	
	public function __toString() {
		return "Compte de {$this->titulaire} : {$this->solde} {$this->devise}";
	}
}
echo "<h2>Exercice 1 </h2>" ;

$compteBancaire1 = new CompteBancaire("HATHOUTI Mohammed Taha", 500000, "€");
$compteBancaire1->deposer(300000);
$compteBancaire1->retirer(100000);
echo $compteBancaire1 . "<br>"

?>
