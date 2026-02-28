<?php

include_once "voyage.php";
include_once "reservable.php";

class VoyageLibre extends Voyage implements Reservable {
	private array $activitesIncluses;

	public function __construct($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles, $activitesIncluses) {
		parent::__construct($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles);
		$this->activitesIncluses = $activitesIncluses;
	}

	public function getActivitesIncluses() {
		return $this->activitesIncluses;
	}

	public function setActivitesIncluses($activitesIncluses) {
		$this->activitesIncluses = $activitesIncluses;
	}

	public function confirmerReservation() : string {
		$this->statut = "confirme";
		return "Réservation confirmée pour le voyage libre vers " . $this->destination . ".";
	}

	public function annulerReservation() : string {
		$this->statut = "annule";
		return "Réservation annulée pour le voyage libre vers " . $this->destination . ".";
	}

	public function __toString() {
		return parent::__toString() . " — Activités : " . implode(", ", $this->activitesIncluses);
	}

	public function afficherDetails() {
		echo "<h2>Voyage Libre</h2>";
		parent::afficherDetails();
		echo "<ul>";
		echo "<li> Activités incluses : " . implode(", ", $this->activitesIncluses) . "</li>";
		echo "</ul>";
	}
}

?>
