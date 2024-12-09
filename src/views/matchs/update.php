<?php
require '../../config/database.php';
require '../../src/models/MatchModel.php';
require '../../src/controllers/MatchsController.php';

if (!isset($pdo) || !$pdo instanceof PDO) {
    die("Erreur : La connexion PDO est invalide.");
}

$controller = new MatchsController($pdo);
$message = '';
$selectedMatch = null;

// Charger tous les matchs
try {
    $matches = $controller->afficherListe();
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Traitement des actions utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifier'])) {
        // Charger le match sélectionné pour modification
        $id_match = intval($_POST['id_match']);

        try {
            $selectedMatch = $controller->getMatchById($id_match);

            if (!$selectedMatch) {
                $message = "Erreur : Match introuvable.";
            } elseif ($selectedMatch['statut'] !== 'À venir') {
                $message = "Seuls les matchs à venir peuvent être modifiés.";
                $selectedMatch = null;
            }
        } catch (Exception $e) {
            $message = "Erreur lors de la récupération du match : " . $e->getMessage();
        }
    } elseif (isset($_POST['sauvegarder'])) {
        // Sauvegarder les modifications
        $id_match = intval($_POST['id_match']);
        $date_match = $_POST['date_match'];
        $heure_match = $_POST['heure_match'];
        $equipe_adverse = $_POST['equipe_adverse'];
        $lieu = $_POST['lieu'];
        $statut = $_POST['statut'];
        $resultat = $_POST['resultat'];

        try {
            $controller->modifierMatch($id_match, $date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat);
            $message = "Le match a été modifié avec succès.";
            $matches = $controller->afficherListe(); // Recharger la liste après modification
        } catch (Exception $e) {
            $message = "Erreur lors de la modification : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un match</title>
    <link rel="stylesheet" href="/Projet-sport/public/assets/css/formmatch.css">
</head>

<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <div class="container">
        <h2>Liste des matchs</h2>
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
                        <th>Statut</th>
                        <th>Résultat</th>
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
                            <td><?= htmlspecialchars($match['statut']) ?></td>
                            <td><?= htmlspecialchars($match['resultat']) ?></td>
                            <td>
                                <?php if ($match['statut'] === 'À venir'): ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_match" value="<?= htmlspecialchars($match['id_match']) ?>">
                                        <button type="submit" name="modifier">Modifier</button>
                                    </form>
                                <?php else: ?>
                                    <button disabled>Non modifiable</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulaire de modification -->
        <?php if ($selectedMatch): ?>
            <div class="modify-container">
                <h2>Modifier le match</h2>
                <form method="POST" action="">
                    <input type="hidden" name="id_match" value="<?= htmlspecialchars($selectedMatch['id_match']) ?>">

                    <label for="date_match">Date :</label>
                    <input type="date" id="date_match" name="date_match" 
                           value="<?= htmlspecialchars($selectedMatch['date_match']) ?>" 
                           min="<?= date('Y-m-d') ?>" required>

                    <label for="heure_match">Heure :</label>
                    <input type="time" id="heure_match" name="heure_match" 
                           value="<?= htmlspecialchars($selectedMatch['heure_match']) ?>" required>

                    <label for="equipe_adverse">Adversaire :</label>
                    <input type="text" id="equipe_adverse" name="equipe_adverse" 
                           value="<?= htmlspecialchars($selectedMatch['equipe_adverse']) ?>" required>

                    <label for="lieu">Lieu :</label>
                    <select id="lieu" name="lieu" required>
                        <option value="Domicile" <?= $selectedMatch['lieu'] === 'Domicile' ? 'selected' : '' ?>>Domicile</option>
                        <option value="Extérieur" <?= $selectedMatch['lieu'] === 'Extérieur' ? 'selected' : '' ?>>Extérieur</option>
                    </select>

                    <label for="statut">Statut :</label>
                    <select id="statut" name="statut" required>
                        <option value="À venir" <?= $selectedMatch['statut'] === 'À venir' ? 'selected' : '' ?>>À venir</option>
                        <option value="Terminé" <?= $selectedMatch['statut'] === 'Terminé' ? 'selected' : '' ?>>Terminé</option>
                    </select>

                    <label for="resultat">Résultat :</label>
                    <select id="resultat" name="resultat">
                        <option value="Victoire" <?= $selectedMatch['resultat'] === 'Victoire' ? 'selected' : '' ?>>Victoire</option>
                        <option value="Défaite" <?= $selectedMatch['resultat'] === 'Défaite' ? 'selected' : '' ?>>Défaite</option>
                        <option value="Nul" <?= $selectedMatch['resultat'] === 'Nul' ? 'selected' : '' ?>>Nul</option>
                    </select>

                    <button type="submit" name="sauvegarder">Sauvegarder les modifications</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>

</html>
