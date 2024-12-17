<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/StatistiquesController.php';

// Initialisation du contrôleur
$controller = new StatistiquesController($pdo);
$matchStats = $controller->afficherStatsMatchs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Matchs</title>
    <link rel="stylesheet" href="../../public/assets/css/statistique.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>

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

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
