<?php

class CompteBancaire {
    private string $titulaire;
    // Change to Private for Exercice 1
    protected float $solde;
    private string $devise;

    public function __construct($titulaire, $soldeInitial, $devise = "MAD") {
        $this->titulaire = $titulaire;
        $this->solde = $soldeInitial;
        $this->devise = $devise;
    }

    public function getSolde() {
        return $this->solde;
    }

    public function deposer($montant) {
        if ($montant > 0) {
            $this->solde += $montant;
            echo "Dépôt de $montant effectué.<br>";
        }
    }

    public function retirer($montant) {
        if ($montant > 0 && $this->solde >= $montant) {
            $this->solde -= $montant;
            echo "Retrait de $montant effectué.<br>";
        } else {
            echo "Erreur : Solde insuffisant pour retirer $montant.<br>";
        }
    }

    public function __toString() {
        return "Compte de {$this->titulaire} : {$this->solde} {$this->devise}";
    }
}

// --- TEST EXERCICE 1 ---
// Remove comments to test ex1, but for ex2 comment it so you don't print
/*echo "<h3>Test Exercice 1</h3>";
$compteCourant = new CompteBancaire("Ahmed", 1000);
$compteCourant->deposer(500);
$compteCourant->retirer(2000);
$compteCourant->retirer(200);
echo $compteCourant . "<br>";*/
?>