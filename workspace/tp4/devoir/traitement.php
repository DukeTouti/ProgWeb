<?php

include "voyage_organise.php";
include "voyage_libre.php";

$destination       = isset($_POST['destination'])       ? $_POST['destination']       : '';
$dateDepart        = isset($_POST['dateDepart'])        ? $_POST['dateDepart']        : '';
$dateRetour        = isset($_POST['dateRetour'])        ? $_POST['dateRetour']        : '';
$prix              = isset($_POST['prix'])              ? (float) $_POST['prix']      : 0;
$placesDisponibles = isset($_POST['placesDisponibles']) ? (int) $_POST['placesDisponibles'] : 0;
$type              = isset($_POST['type'])              ? $_POST['type']              : 'VoyageOrganise';
$guideNom          = isset($_POST['guideNom'])          ? $_POST['guideNom']          : '';
$activites         = isset($_POST['activites'])         ? $_POST['activites']         : [];
$action            = isset($_POST['action'])            ? $_POST['action']            : 'confirmer';

if ($type === 'VoyageOrganise') {
	$voyage  = new VoyageOrganise($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles, $guideNom);
} else {
	$voyage  = new VoyageLibre($destination, $dateDepart, $dateRetour, $prix, $placesDisponibles, $activites);
}

if ($action === 'confirmer') {
	$message = $voyage->confirmerReservation();
} else {
	$message = $voyage->annulerReservation();
}

$voyage->afficherDetails();
echo "<p><strong>" . $message . "</strong></p>";

?>
