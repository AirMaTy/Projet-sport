<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/FeuillesMatchController.php';

// Initialiser le contrôleur
$controller = new FeuillesMatchController($pdo);

// Récupérer les données
$feuillesMatch = $controller->afficherFeuillesMatch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Feuilles de Match</title>
    <link rel="stylesheet" href="../../public/assets/css/feuilles_match.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Feuilles de Match</h1>

    <?php if (!empty($feuillesMatch)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Feuille</th>
                    <th>ID Match</th>
                    <th>Joueur</th>
                    <th>Rôle</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feuillesMatch as $feuille): ?>
                    <tr>
                        <td><?= htmlspecialchars($feuille['id_feuille']) ?></td>
                        <td><?= htmlspecialchars($feuille['id_match']) ?></td>
                        <td><?= htmlspecialchars($feuille['joueur_nom'] . ' ' . $feuille['joueur_prenom']) ?></td>
                        <td><?= htmlspecialchars($feuille['role']) ?></td>
                        <td><?= htmlspecialchars($feuille['poste']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune feuille de match trouvée.</p>
    <?php endif; ?>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
