<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/JoueursController.php';

$controller = new JoueursController($pdo);
$joueurs = $controller->afficherListe();

// Gérer la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_joueur'])) {
    $controller->supprimerJoueur((int)$_POST['id_joueur']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des joueurs</title>
    <link rel="stylesheet" href="../../public/assets/css/joueurs.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Liste des joueurs</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Poste préféré</th>
            <th>Numéro de licence</th>
            <th>Taille (cm)</th>
            <th>Poids (kg)</th>
            <th>Commentaires</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($joueurs as $joueur): ?>
            <tr>
                <td><?= htmlspecialchars($joueur['id']) ?></td>
                <td><?= htmlspecialchars($joueur['nom']) ?></td>
                <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                <td><?= htmlspecialchars($joueur['age']) ?></td>
                <td><?= htmlspecialchars($joueur['poste']) ?></td>
                <td><?= htmlspecialchars($joueur['num_licence']) ?></td>
                <td><?= htmlspecialchars($joueur['taille_cm']) ?></td>
                <td><?= htmlspecialchars($joueur['poids_kg']) ?></td>
                <td><?= htmlspecialchars($joueur['commentaires']) ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="id_joueur" value="<?= htmlspecialchars($joueur['id']) ?>">
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
