<form action="ex3.php" method="POST">
	<label>Nom du Serveur</label>
	<input type="text" name="msg" required><br>
	
	<label>OS:</label>
	<input type="radio" name="os" value="Ubuntu" checked> Ubuntu (Gratuit) <br>
	<input type="radio" name="os" value="Windows"> Windows (500 DHS) <br>
	
	<label>Logiciels:</label>
	<input type="checkbox" name="logiciels[]" value="Apache"> Apache (100 DHS)
	<input type="checkbox" name="logiciels[]" value="MySQL"> MySQL (150 DHS)
	<input type="checkbox" name="logiciels[]" value="Docker"> Docker (200 DHS) <br>
	
	<button type="submit">Configurer</button>
</form>



<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$prixTotal = 0;
	$msg = $_POST['msg'];
	$os = $_POST['os'];
	
	$logicielsChoisis = isset($_POST['logiciels']) ? $_POST['logiciels'] : []; // $logicielsChoisis = $_POST['logiciels'] ?? [];
	
	if ($os == "Windows") $prixTotal += 500;
	
	foreach ($logicielsChoisis as $logiciel) {
		if ($logiciel == "Apache") $prixTotal += 100;
		if ($logiciel == "MySQL") $prixTotal += 150;
		if ($logiciel == "Docker") $prixTotal += 200;
	}

	echo "<h3>Serveur $msg configuré sous $os.</h3>";
	echo "Logiciels: " . implode(", ", $logicielsChoisis) . "<br>";
	echo "<strong>Prix Total: $prixTotal DHS</strong>";

}


?>
