<!-- Partie 1: Formulaire HTML -->
<form action="ex3.php" method="POST">
    <label>Nom du Serveur:</label>
    <input type="text" name="nom" required><br>

    <label>OS:</label>
    <input type="radio" name="os" value="Ubuntu" checked> Ubuntu (Gratuit)
    <input type="radio" name="os" value="Windows"> Windows (+500 MAD)<br>

    <label>Logiciels:</label>
    <input type="checkbox" name="logiciels[]" value="Apache"> Apache (+100)
    <input type="checkbox" name="logiciels[]" value="MySQL"> MySQL (+150)
    <input type="checkbox" name="logiciels[]" value="Docker"> Docker (+200)<br>

    <button type="submit">Configurer</button>
</form>

<?php

// Partie 2: Traitement PHP
// Initialisation des variables
$prixTotal = 0;
$nom = $_POST['nom'];
$os = $_POST['os'];
$logicielsChoisis = isset($_POST['logiciels']) ? $_POST['logiciels'] : [];

// OS Logic
if ($os == "Windows") $prixTotal += 500; 

// Logiciels Logic
foreach ($logicielsChoisis as $logiciel) {
    if ($logiciel == "Apache") $prixTotal += 100;
    if ($logiciel == "MySQL") $prixTotal += 150;
    if ($logiciel == "Docker") $prixTotal += 200;
}

// Affichage du résultat
echo "<h3>Serveur $nom configuré sous $os.</h3>"; 
echo "Logiciels: " . implode(", ", $logicielsChoisis) . "<br>";
echo "<strong>Prix Total: $prixTotal MAD</strong>";
?>