<?php
require_once __DIR__ . '/../src/includes/auth_check.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../public/assets/css/dashboard.css">
</head>
<body>
    <?php include('../src/views/layouts/header.php'); ?>

    <div class="dashboard-container">
        <h1>Bienvenue, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Voici le tableau de bord de l'entraîneur.</p>

        <div class="categories">
            <!-- Catégorie Joueurs -->
            <div class="category-card">
                <h2>Joueurs</h2>
                <p>Gérez les joueurs : ajouter, modifier, ou consulter la liste.</p>
                <div class="buttons">
                    <a href="../public/joueurs/liste.php" class="button">Voir la liste</a>
                    <a href="../public/joueurs/ajouter.php" class="button secondary">Ajouter / Modifier un joueur</a>
                    <a href="../public/joueurs/supprimer.php" class="button danger">Supprimer un joueur</a>
                </div>
            </div>

            <!-- Catégorie Matchs -->
            <div class="category-card">
                <h2>Matchs</h2>
                <p>Planifiez et gérez vos matchs.</p>
                <div class="buttons">
                    <a href="../public/matchs/liste.php" class="button">Voir la liste</a>
                    <a href="../public/matchs/resultats.php" class="button secondary">Ajouter les résultats d'un match</a>
                    <a href="../public/matchs/ajouter.php" class="button secondary">Ajouter un match</a>
                    <a href="../public/matchs/modifier.php" class="button secondary">Modifier un match</a>
                    <a href="../public/matchs/delete.php" class="button danger">Supprimer un match</a>
                </div>
            </div>

            <!-- Catégorie Feuilles de match -->
            <div class="category-card">
                <h2>Feuilles de match</h2>
                <p>Créez et visualisez vos feuilles de match.</p>
                <div class="buttons">
                    <a href="../public/feuilles_match/selection.php" class="button">Créer une feuille</a>
                    <a href="../public/feuilles_match/visualiser.php" class="button secondary">Voir les feuilles</a>
                    <a href="../public/feuilles_match/evaluation.php" class="button secondary">Évaluer un joueur</a>
                    <a href="../public/feuilles_match/modifier.php" class="button danger">Modifier / Supprimer une feuille</a>
                </div>
            </div>

            <!-- Catégorie Statistiques -->
            <div class="category-card">
                <h2>Statistiques</h2>
                <p>Consultez les statistiques des joueurs et de l'équipe.</p>
                <div class="buttons">
                    <a href="../public/statistiques/index.php" class="button">Voir les statistiques</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('../src/views/layouts/footer.php'); ?>
</body>
</html>
