<?php
// login.php - Formulaire d'authentification + verification
session_start();

// Si deja connecte, rediriger vers le catalogue
if (isset($_SESSION['utilisateur'])) {
    header('Location: catalogue.php');
    exit;
}

require_once 'connexion.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']        ?? '');
    $mdp   = trim($_POST['mot_de_passe'] ?? '');

    // --- Etape 3 : verification via requete preparee ---
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
    $stmt->execute([$login]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && password_verify($mdp, $utilisateur['mot_de_passe'])) {
        // Ouverture de la session
        $_SESSION['utilisateur'] = $utilisateur['login'];

        // --- Devoir : stocker le role en session ---
        $_SESSION['role'] = $utilisateur['role'] ?? 'visiteur';

        // --- Devoir : cookie de derniere connexion (30 jours) ---
        $dateConnexion = date('d/m/Y H:i');
        setcookie('derniere_connexion', $dateConnexion, time() + 30 * 24 * 3600, '/');

        header('Location: catalogue.php');
        exit;
    } else {
        // Message volontairement vague (securite : pas d'enumeration de comptes)
        $erreur = "Identifiants incorrects. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – CinemaBD</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px;
               margin: 80px auto; padding: 0 20px; }
        h2   { color: #0054a6; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input  { width: 100%; padding: 8px; margin-top: 4px;
                 box-sizing: border-box; border: 1px solid #ccc;
                 border-radius: 4px; }
        button { margin-top: 16px; padding: 10px 24px;
                 background: #0054a6; color: white;
                 border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #003d80; }
        .erreur { color: red; background: #fff0f0;
                  border-left: 4px solid red; padding: 8px 12px;
                  margin-top: 12px; }
    </style>
</head>
<body>
    <h2>🎬 Connexion – CinemaBD</h2>

    <?php if ($erreur): ?>
        <div class="erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="login">Login :</label>
        <input type="text" id="login" name="login"
               value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
               required autofocus>

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
