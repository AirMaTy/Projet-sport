<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/MatchsController.php';

$controller = new MatchsController($pdo);
$matchs = $controller->afficherListe();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des matchs</title>
    <link rel="stylesheet" href="../../public/assets/css/matchs.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Liste des matchs</h1>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Adversaire</th>
        <th>Lieu</th>
        <th>Statut de licence</th>
        <th>Résultat</th>
    </tr>
    <?php foreach ($matchs as $match): ?>
    <tr>
        <td><?= htmlspecialchars($match['id_match']) ?></td>
        <td><?= htmlspecialchars($match['date_match']) ?></td>
        <td><?= htmlspecialchars($match['heure_match']) ?></td>
        <td><?= htmlspecialchars($match['equipe_adverse']) ?></td>
        <td><?= htmlspecialchars($match['lieu']) ?></td>
        <td><?= htmlspecialchars($match['statut']) ?></td>
        <td><?= htmlspecialchars($match['resultat']) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
    </body>
</html>
