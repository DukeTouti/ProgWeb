<?php

include_once "voyage.php";
include_once "reservable.php";

class VoyageOrganise extends Voyage implements Reservable {
	private string $guideNom;

	public function __construct($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles, $guideNom) {
		parent::__construct($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles);
		$this->guideNom = $guideNom;
	}

	public function getGuideNom() {
		return $this->guideNom;
	}

	public function setGuideNom($guideNom) {
		$this->guideNom = $guideNom;
	}

	public function confirmerReservation() : string {
		$this->statut = "confirme";
		return "Réservation confirmée pour le voyage organisé vers " . $this->destination . " avec le guide " . $this->guideNom . ".";
	}

	public function annulerReservation() : string {
		$this->statut = "annule";
		return "Réservation annulée pour le voyage organisé vers " . $this->destination . ".";
	}

	public function __toString() {
		return parent::__toString() . " — Guide : " . $this->guideNom;
	}

	public function afficherDetails() {
		echo "<h2>Voyage Organisé</h2>";
		parent::afficherDetails();
		echo "<ul>";
		echo "<li> Guide : " . $this->guideNom . "</li>";
		echo "</ul>";
	}
}

?>
