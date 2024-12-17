<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/StatistiquesController.php';

// Initialisation du contrôleur
$controller = new StatistiquesController($pdo);

// Récupérer les statistiques des matchs
$matchStats = $controller->afficherStatsMatchs();

// Récupérer les statistiques des joueurs
$playerStats = $controller->afficherStatsJoueurs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Matchs et Joueurs</title>
    <link rel="stylesheet" href="../../public/assets/css/statistique.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>

    <!-- Statistiques des matchs -->
    <h1>Statistiques des Matchs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Total de matchs</th>
                <th>Victoires</th>
                <th>% Victoires</th>
                <th>Défaites</th>
                <th>% Défaites</th>
                <th>Nuls</th>
                <th>% Nuls</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($matchStats['total']) ?></td>
                <td><?= htmlspecialchars($matchStats['gagne']) ?></td>
                <td><?= htmlspecialchars($matchStats['pourcentage_gagne']) ?>%</td>
                <td><?= htmlspecialchars($matchStats['perdu']) ?></td>
                <td><?= htmlspecialchars($matchStats['pourcentage_perdu']) ?>%</td>
                <td><?= htmlspecialchars($matchStats['nul']) ?></td>
                <td><?= htmlspecialchars($matchStats['pourcentage_nul']) ?>%</td>
            </tr>
        </tbody>
    </table>

    <!-- Statistiques des joueurs -->
    <h1>Statistiques des Joueurs</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Statut</th>
                <th>Poste préféré</th>
                <th>Titularisations</th>
                <th>Remplacements</th>
                <th>Moyenne des évaluations</th>
                <th>% de victoires</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($playerStats as $player): ?>
            <tr>
                <td><?= htmlspecialchars($player['nom']) ?></td>
                <td><?= htmlspecialchars($player['statut']) ?></td>
                <td><?= htmlspecialchars($player['poste_prefere']) ?></td>
                <td><?= $player['titularisations'] ?></td>
                <td><?= $player['remplacements'] ?></td>
                <td><?= $player['moyenne_evaluation'] !== null ? number_format($player['moyenne_evaluation'], 2) : '-' ?></td>
                <td><?= $player['pourcentage_victoires'] ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>

</body>
</html>
