<!-- Partie 1: Formulaire HTML -->
<form action="ex2.php" method="GET">
    <label>Message:</label>
    <input type="text" name="msg" required>
    <br></br>
    <label>Type d'alerte:</label>
    <select name="type">
        <option value="success">Succès</option>
        <option value="error">Erreur</option>
    </select>
    
    <button type="submit">Générer l'alerte</button>
</form>

<?php
// Partie 2: Traitement PHP
// Fonction pour afficher l'alerte
function afficherAlerte($message, $type) {
    $couleur = "gray";
    
    if ($type == "error") {
        $couleur = "red";
    } elseif ($type == "success") {
        $couleur = "green"; 
    }
    
    return "<div style='background-color: $couleur; color: white; padding: 10px; margin-top: 10px;'>
                $message
            </div>";
}

// Recuperation des données du formulaire avec la methode GET et affichage de l'alerte
if (isset($_GET['msg']) && isset($_GET['type'])) {
    echo afficherAlerte($_GET['msg'], $_GET['type']);
}
?>