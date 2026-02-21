<?php

// Interface Connectable
interface Connectable {
	public function seConnecter();
}

// Classe abstraite Equipement
abstract class Equipement {
	protected string $marque;
	protected string $adresseIP = "";

	public function __construct($marque) {
		$this->marque = $marque;
	}

	public function afficherInfos() {
		echo "Marque : {$this->marque} | IP : {$this->adresseIP} <br>";
	}

	abstract public function demarrer();
}

// Classe Ordinateur
class Ordinateur extends Equipement implements Connectable {

	public function demarrer() {
		echo "L'ordinateur {$this->marque} boot sur Windows <br>";
	}

	public function seConnecter() {
		$this->adresseIP = "192.168." . rand(0, 255) . "." . rand(1, 254);
		echo "PC {$this->marque} connecté avec l'IP : {$this->adresseIP} <br>";
	}
}

echo "<h2>Exercice 3</h2>";

$parc = [
	new Ordinateur("Dell"),
	new Ordinateur("HP")
];

foreach ($parc as $equipement) {
	$equipement->demarrer();
	$equipement->seConnecter();
	$equipement->afficherInfos();
	echo "<br>";
}

?>
