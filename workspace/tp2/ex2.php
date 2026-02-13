<form action="ex2.php" method="GET">
	<label>Message:</label>
	<input type="text" name="msg" required>
	<br></br>
	<label>Type d'alerte:</label>
	<select name="type">
		<option value="success">Succès</option>
		<option value="error">Erreur</option>
	</select>
	
	<button type="submit">Générer l'alert</button>
</form>



<?php

function afficherAlerte($message, $type) {
	$couleur = "grey" ;
	
	if ($type == "success") {
		$couleur = "green" ;
	} elseif ($type == "error") {
		$couleur = "red" ;
	}

	return "<div style='background-color: $couleur; color: white; padding: 10px;'> $message </div>";
}

if (isset($_GET['msg']) && isset($_GET['type'])) {
	echo afficherAlerte($_GET['msg'], $_GET['type']);
}

?>
