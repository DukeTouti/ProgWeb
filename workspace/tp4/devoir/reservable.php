<?php

interface Reservable {
	public function confirmerReservartion() : string;
	public function annulerReservation() : string;
}

?>
