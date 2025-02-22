<?php
require_once '../../config/database.php';
require_once '../../src/controllers/FeuillesMatchController.php';

$controller = new FeuillesMatchController($pdo);
$joueurs = $controller->afficherJoueursActifs();
$message = ""; // Pour afficher les messages (erreurs ou succès)
$feuilleMatch = []; // Pour afficher les joueurs d'une feuille existante

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Gestion de la création ou modification d'une feuille de match
        if (isset($_POST['id_match']) && isset($_POST['joueurs'])) {
            $id_match = intval($_POST['id_match']);
            $joueurs = json_decode($_POST['joueurs'], true); // Exemple de format JSON pour les joueurs

            try {
                $controller->creerFeuilleMatch($id_match, $joueurs);
                $message = "Feuille de match mise à jour avec succès.";
            } catch (Exception $e) {
                $message = $e->getMessage();
            }
        }

        // Récupération de la feuille existante
        if (isset($_POST['id_match'])) {
            $id_match = intval($_POST['id_match']);
            $feuilleMatch = $controller->getFeuilleMatch($id_match);
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
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="../../public/assets/css/feuillematch.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Créer ou Modifier une Feuille de Match</h1>

    <!-- Affichage des messages -->
    <?php if (!empty($message)): ?>
        <p style="color: <?= strpos($message, 'succès') !== false ? 'green' : 'red' ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <!-- Formulaire pour afficher ou modifier une feuille -->
    <form method="POST" action="">
        <label for="id_match">ID du Match :</label>
        <input type="number" id="id_match" name="id_match" required>
        <button type="submit">Afficher/Modifier</button>
    </form>

    <?php if (!empty($feuilleMatch)): ?>
        <h2>Feuille de Match</h2>
        <table border="1">
            <tr>
                <th>ID Joueur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Poste</th>
                <th>Action</th>
            </tr>
            <?php foreach ($feuilleMatch as $joueur): ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['id_joueur']) ?></td>
                    <td><?= htmlspecialchars($joueur['nom']) ?></td>
                    <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                    <td><?= htmlspecialchars($joueur['role']) ?></td>
                    <td><?= htmlspecialchars($joueur['poste']) ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id_match" value="<?= htmlspecialchars($_POST['id_match']) ?>">
                            <input type="hidden" name="id_joueur" value="<?= htmlspecialchars($joueur['id_joueur']) ?>">
                            <button type="submit" name="supprimer_joueur">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form method="POST" action="">
            <input type="hidden" name="id_match" value="<?= htmlspecialchars($_POST['id_match']) ?>">
            <button type="submit" name="supprimer_feuille">Supprimer Feuille Complète</button>
        </form>
    <?php endif; ?>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
