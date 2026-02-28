<?php

interface Reservable {
	public function confirmerReservation() : string;
	public function annulerReservation() : string;
}

?>
