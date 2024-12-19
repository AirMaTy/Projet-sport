<?php
require_once '../../config/database.php';
require_once '../../src/controllers/FeuillesMatchController.php';

$controller = new FeuillesMatchController($pdo);
$joueurs = $controller->afficherJoueursActifs();
$message = "";
$feuilleMatch = [];

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_match'])) {
        $id_match = intval($_POST['id_match']);
        $feuilleMatch = $controller->getFeuilleMatch($id_match);
    }

    if (isset($_POST['supprimer_joueur'])) {
        $controller->supprimerJoueurDeFeuille($_POST['id_match'], $_POST['id_joueur']);
        $message = "Joueur supprimé de la feuille de match.";
    }

    if (isset($_POST['supprimer_feuille'])) {
        $controller->supprimerFeuilleMatch($_POST['id_match']);
        $message = "Feuille de match supprimée.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Feuille de Match</title>
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Créer ou Modifier une Feuille de Match</h1>
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
                    <td><?= $joueur['id_joueur'] ?></td>
                    <td><?= $joueur['nom'] ?></td>
                    <td><?= $joueur['prenom'] ?></td>
                    <td><?= $joueur['role'] ?></td>
                    <td><?= $joueur['poste'] ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="id_match" value="<?= $_POST['id_match'] ?>">
                            <input type="hidden" name="id_joueur" value="<?= $joueur['id_joueur'] ?>">
                            <button type="submit" name="supprimer_joueur">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form method="POST" action="">
            <input type="hidden" name="id_match" value="<?= $_POST['id_match'] ?>">
            <button type="submit" name="supprimer_feuille">Supprimer Feuille Complète</button>
        </form>
    <?php endif; ?>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
