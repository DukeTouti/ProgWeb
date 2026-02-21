<?php

interface Empruntable {
	public function emprunter();
	public function retourner();
}

abstract class Document {
	protected string $titre;
	protected string $auteur;
	protected bool $disponible = true;

	public function __construct($titre, $auteur) {
		$this->titre = $titre;
		$this->auteur = $auteur;
	}

	public function __toString() {
		$statut = $this->disponible ? "Disponible" : "Non disponible";
		return "Document : \"{$this->titre}\" par {$this->auteur} — {$statut}";
	}
}

class Livre extends Document implements Empruntable {
	private int $nombrePages;

	public function __construct($titre, $auteur, $nombrePages) {
		parent::__construct($titre, $auteur);
		$this->nombrePages = $nombrePages;
	}

	public function emprunter() {
		if ($this->disponible) {
			$this->disponible = false;
			echo "Livre emprunté avec succès <br>";
		} else {
			echo "Erreur : Livre déjà emprunté <br>";
		}
	}

	public function retourner() {
		$this->disponible = true;
		echo "Livre retourné avec succès <br>";
	}

	public function __toString() {
		return parent::__toString() . " ({$this->nombrePages} pages)";
	}
}

echo "<h2>Exercice 4</h2>";

$livre = new Livre("Une Brève Histoire du Temps", "Stephen Hawking", 236);

$livre->emprunter();
echo $livre . "<br>";
$livre->emprunter();
echo $livre . "<br>";
$livre->retourner();
echo $livre . "<br>";

?>
