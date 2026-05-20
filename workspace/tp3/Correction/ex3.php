<?php

// Interface => An Interface lets you define which public methods a class MUST implement,
// without defining how they should be implemented.
interface Connectable {
    public function seConnecter();
}

// Abstract =>  An abstract class is a class that contains at least one abstract method.
// An abstract method is a method that is declared, but not implemented in the abstract class.
abstract class Equipement {
    protected $marque;
    protected $adresseIP;

    public function __construct($marque) {
        $this->marque = $marque;
        $this->adresseIP = "Non assignée";
    }

    public function afficherInfos() {
        echo "Équipement {$this->marque} - IP : {$this->adresseIP}<br>";
    }

    abstract public function demarrer();
}


class Ordinateur extends Equipement implements Connectable {
    
    // Obligatoire à cause de 'abstract Equipement'
    public function demarrer() {
        echo "L'ordinateur {$this->marque} boot sur Windows.<br>";
    }

    // Obligatoire à cause de 'implements Connectable'
    public function seConnecter() {
        $this->adresseIP = "192.168.1." . rand(2, 254);
        echo "PC Connecté au réseau.<br>";
    }
}

// --- TEST ---
echo "<h3>Test Exercice 3 : Le Parc Informatique</h3>";

$parc = [
    new Ordinateur("Dell"),
    new Ordinateur("HP")
];

foreach ($parc as $machine) {
    $machine->demarrer();
    $machine->seConnecter();
    $machine->afficherInfos();
    echo "<hr>";
}

?>