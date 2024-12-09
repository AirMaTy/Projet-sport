<?php
require '../../config/database.php';
require '../../src/models/MatchModel.php';
require '../../src/controllers/MatchsController.php';

if (!isset($pdo) || !$pdo instanceof PDO) {
    die("Erreur : La connexion PDO est invalide.");
}

$controller = new MatchsController($pdo);
$message = '';

// Charger les matchs "À venir"
try {
    $matches = array_filter(
        $controller->afficherListe(),
        fn($match) => $match['statut'] === 'À venir'
    );
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Gestion de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $id_match = intval($_POST['id_match']);

    try {
        $controller->supprimerMatch($id_match);
        $message = "Le match a été supprimé avec succès.";
        // Recharger les matchs après suppression
        $matches = array_filter(
            $controller->afficherListe(),
            fn($match) => $match['statut'] === 'À venir'
        );
    } catch (Exception $e) {
        $message = "Erreur lors de la suppression du match : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un match</title>
    <link rel="stylesheet" href="/Projet-sport/public/assets/css/formmatch.css">
</head>

<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <div class="container">
        <h2>Supprimer un match</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Table des matchs -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Adversaire</th>
                        <th>Lieu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matches as $match): ?>
                        <tr>
                            <td><?= htmlspecialchars($match['id_match']) ?></td>
                            <td><?= htmlspecialchars($match['date_match']) ?></td>
                            <td><?= htmlspecialchars($match['heure_match']) ?></td>
                            <td><?= htmlspecialchars($match['equipe_adverse']) ?></td>
                            <td><?= htmlspecialchars($match['lieu']) ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Voulez-vous vraiment supprimer ce match ?');">
                                    <input type="hidden" name="id_match" value="<?= htmlspecialchars($match['id_match']) ?>">
                                    <button type="submit" name="supprimer">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>

</html>
