<?php
require_once '../../config/database.php';
require_once '../../src/controllers/FeuillesMatchController.php';

$controller = new FeuillesMatchController($pdo);
$joueurs = $controller->afficherJoueursActifs();
$message = "";

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_match = intval($_POST['id_match']);
    $joueurs_selectionnes = [];

    foreach ($_POST['joueurs'] as $id_joueur => $data) {
        if (!empty($data['role']) && !empty($data['poste'])) {
            $joueurs_selectionnes[] = [
                'id_joueur' => $id_joueur,
                'role' => $data['role'],
                'poste' => $data['poste']
            ];
        }
    }

    if (!empty($joueurs_selectionnes)) {
        $controller->creerFeuilleMatch($id_match, $joueurs_selectionnes);
        $message = "Feuille de match créée avec succès.";
    } else {
        $message = "Veuillez sélectionner au moins un joueur avec un rôle et un poste.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Feuille de Match</title>
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <h1>Créer une Feuille de Match</h1>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Formulaire de sélection -->
    <form method="POST" action="">
        <label for="id_match">ID du Match :</label>
        <input type="number" id="id_match" name="id_match" required><br><br>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Poste Préféré</th>
                <th>Rôle</th>
                <th>Poste</th>
            </tr>
            <?php foreach ($joueurs as $joueur): ?>
                <tr>
                    <td><?= htmlspecialchars($joueur['id_joueur']) ?></td>
                    <td><?= htmlspecialchars($joueur['nom']) ?></td>
                    <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                    <td><?= htmlspecialchars($joueur['poste_prefere']) ?></td>
                    <td>
                        <select name="joueurs[<?= $joueur['id_joueur'] ?>][role]">
                            <option value="">Sélectionner</option>
                            <option value="Titulaire">Titulaire</option>
                            <option value="Remplaçant">Remplaçant</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="joueurs[<?= $joueur['id_joueur'] ?>][poste]" placeholder="Poste">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <button type="submit">Créer Feuille de Match</button>
    </form>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
