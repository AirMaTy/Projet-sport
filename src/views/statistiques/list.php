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

    <table border="1">
        <tr>
            <th>Total de matchs</th>
            <th>Victoires</th>
            <th>Défaites</th>
            <th>Nuls</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($matchStats['total'] ?? 0) ?></td>
            <td><?= htmlspecialchars($matchStats['victoires'] ?? 0) ?></td>
            <td><?= htmlspecialchars($matchStats['defaites'] ?? 0) ?></td>
            <td><?= htmlspecialchars($matchStats['nuls'] ?? 0) ?></td>
        </tr>
    </table>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
