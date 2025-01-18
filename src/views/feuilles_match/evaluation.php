<?php
require_once '../../config/database.php';
require_once '../../src/controllers/FeuillesMatchController.php';

$controller = new FeuillesMatchController($pdo);
$message = "";
$joueurs = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les joueurs d'un match terminé
        if (isset($_POST['id_match']) && !isset($_POST['ajouter_evaluation'])) {
            $id_match = intval($_POST['id_match']);
            try {
                $joueurs = $controller->getJoueursPourEvaluation($id_match);
                if (empty($joueurs)) {
                    $message = "Aucun joueur n'a participé à ce match.";
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        // Ajouter une évaluation pour un joueur
        if (isset($_POST['ajouter_evaluation'])) {
            $controller->ajouterEvaluation(
                $_POST['id_match'],
                $_POST['id_joueur'],
                $_POST['note'],
                $_POST['commentaire']
            );
            $message = "Évaluation ajoutée avec succès.";
            $joueurs = $controller->getJoueursPourEvaluation($_POST['id_match']); // Rafraîchir les joueurs
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluer les Joueurs</title>
    <link rel="stylesheet" href="../../public/assets/css/feuillematch.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Évaluer les Joueurs</h1>

    <!-- Affichage des messages -->
    <?php if (!empty($message)): ?>
        <p style="color: <?= strpos($message, 'succès') !== false ? 'green' : 'red' ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <!-- Formulaire pour afficher les joueurs d'un match -->
    <form method="POST" action="">
        <label for="id_match">ID du Match :</label>
        <input type="number" id="id_match" name="id_match" required>
        <button type="submit">Afficher Joueurs</button>
    </form>

    <?php if (!empty($joueurs)): ?>
        <h2>Joueurs ayant participé au match</h2>
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Poste</th>
                <th>Évaluation</th>
            </tr>
            <?php foreach ($joueurs as $joueur): ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['nom']) ?></td>
                    <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                    <td><?= htmlspecialchars($joueur['role']) ?></td>
                    <td><?= htmlspecialchars($joueur['poste']) ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id_match" value="<?= htmlspecialchars($_POST['id_match']) ?>">
                            <input type="hidden" name="id_joueur" value="<?= htmlspecialchars($joueur['id_joueur']) ?>">
                            <label for="note">Note :</label>
                            <input type="number" name="note" min="1" max="5" required>
                            <label for="commentaire">Commentaire :</label>
                            <input type="text" name="commentaire" required>
                            <button type="submit" name="ajouter_evaluation">Ajouter</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
