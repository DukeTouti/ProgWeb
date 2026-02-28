<?php

class Voyage {
	public string $destination;
	public string $dateDepart;
	public string $dateRetour;
	protected float $prix;
	protected int $placesDisponibles;
	protected string $statut;

	public function __construct($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles) {
		$this->destination       = $destination;
		$this->dateDepart        = $dateDepart;
		$this->dateRetour        = $dateRetour;
		$this->prix              = $prix;
		$this->placesDisponibles = $placesDisponibles;
		$this->statut            = "en attente";
	}

	public function getPrix() {
		return $this->prix;
	}

	public function setPrix($prix) {
		$this->prix = $prix;
	}

	public function getPlacesDisponibles() {
		return $this->placesDisponibles;
	}

	public function setPlacesDisponibles($placesDisponibles) {
		$this->placesDisponibles = $placesDisponibles;
	}

	public function getStatut() {
		return $this->statut;
	}

	public function setStatut($statut) {
		$this->statut = $statut;
	}

	public function __toString() {
		return "Voyage vers " . $this->destination . " — Du " . $this->dateDepart . " au " . $this->dateRetour .
		       " — Prix : " . $this->prix . " MAD — Places : " . $this->placesDisponibles . " — Statut : " . $this->statut;
	}

	public function afficherDetails() {
		echo "<ul>";
		echo "<li> Destination : " . $this->destination . "</li>";
		echo "<li> Date de départ : " . $this->dateDepart . "</li>";
		echo "<li> Date de retour : " . $this->dateRetour . "</li>";
		echo "<li> Prix : " . $this->prix . " MAD</li>";
		echo "<li> Places disponibles : " . $this->placesDisponibles . "</li>";
		echo "<li> Statut : " . $this->statut . "</li>";
		echo "</ul>";
	}
}

?>
