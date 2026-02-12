<?php
// Classe parente
abstract class Personne {
	protected string $nom;
	protected string $prenom;
	protected float $salaire;
	protected int $age;
	protected float $taux;

	public function __construct(string $nom, string $prenom, float $salaire, int $age, float $taux) {
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->salaire = $salaire;
		$this->age = $age;
		$this->taux = $taux;
	}

	public function getSalaire(): float {
		return $this->salaire;
	}
	
	public function setSalaire(float $salaire): void {
		$this->salaire = $salaire;
	}

	abstract public function calc_Impot(): float;

	public function __toString(): string {
		return "{$this->nom} {$this->prenom}, Salaire: {$this->salaire} €, Age: {$this->age}";
	}
}

// Classe Etudiant
class Etudiant extends Personne {
	public function __construct(string $nom, string $prenom, float $salaire, int $age) {
		parent::__construct($nom, $prenom, $salaire, $age, 2.5);
	}

	public function calc_Impot(): float {
		return $this->salaire * ($this->taux / 100);
	}
}

// Classe Professeur
class Professeur extends Personne {
	protected string $specialite;

	public function __construct(string $nom, string $prenom, float $salaire, int $age, string $specialite) {
		parent::__construct($nom, $prenom, $salaire, $age, 5);
		$this->specialite = $specialite;
	}

	public function calc_Impot(): float {
		return $this->salaire * ($this->taux / 100);
	}

	public function __toString(): string {
		return parent::__toString() . ", Spécialité: {$this->specialite}";
	}
}

// Classe Chef de Département
class ChefDepartement extends Professeur {
	private int $experience;

	public function __construct(string $nom, string $prenom, float $salaire, int $age, string $specialite, int $experience) {
		parent::__construct($nom, $prenom, $salaire, $age, $specialite);
		$this->taux = 6;
		$this->experience = $experience;
	}

	public function __toString(): string {
		return parent::__toString() . ", Expérience: {$this->experience} ans";
	}
}


$etudiant = new Etudiant("ZEFIZEF", "Sami", 3600, 22);
$professeur = new Professeur("BELAL", "Anaïs", 5000, 21, "Informatique");
$chefDept = new ChefDepartement("FERGOUCH", "Yahya", 7000, 45, "Génie Logiciel", 15);

echo "<h2>Calcul des Impôts</h2>";
echo "Étudiant: " . $etudiant . "<br/>Impôt: " . $etudiant->calc_Impot() . " €<br/><br/>";
echo "Professeur: " . $professeur . "<br/>Impôt: " . $professeur->calc_Impot() . " €<br/><br/>";
echo "Chef Dept: " . $chefDept . "<br/>Impôt: " . $chefDept->calc_Impot() . " €<br/>";
?>
