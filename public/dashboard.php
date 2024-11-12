<?php
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers login.php
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Utilisateur connecté, on peut afficher le tableau de bord
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Voici le tableau de bord de l'entraîneur.</p>
    <!-- Autres fonctionnalités de ton tableau de bord -->
</body>
</html>
