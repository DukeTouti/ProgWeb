<?php
include_once 'ex1.php';

class CompteEpargne extends CompteBancaire {
    private $tauxInteret;

    public function __construct($titulaire, $soldeInitial, $tauxInteret, $devise = "MAD") {
        // Appel obligatoire du constructeur parent
        parent::__construct($titulaire, $soldeInitial, $devise);
        $this->tauxInteret = $tauxInteret;
    }

    public function appliquerInterets() {
        // Accessible car $solde est protected
        $interets = $this->solde * $this->tauxInteret;
        $this->solde += $interets;
        echo "Intérêts de $interets appliqués.<br>";
    }

    // Surcharge (Overriding) de l'affichage
    public function __toString() {
        $tauxAffichage = $this->tauxInteret * 100;
        return parent::__toString() . " (Compte Épargne à {$tauxAffichage}%)";
    }
}

// --- TEST EXERCICE 2 ---
echo "<h3>Test Exercice 2</h3>";
$compteEpargne = new CompteEpargne("Ali", 5000, 0.05);
$compteEpargne->appliquerInterets();
echo $compteEpargne . "<br>";
?>