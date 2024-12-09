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

// Charger les matchs terminés sans résultat
try {
    $matches = array_filter(
        $controller->afficherListe(),
        fn($match) => $match['statut'] === 'Terminé' && empty($match['resultat'])
    );
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

// Traitement des actions utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['saisir_resultat'])) {
        // Charger le match sélectionné pour saisie du résultat
        $id_match = intval($_POST['id_match']);

        try {
            $selectedMatch = $controller->getMatchById($id_match);

            if (!$selectedMatch) {
                $message = "Erreur : Match introuvable.";
            }
        } catch (Exception $e) {
            $message = "Erreur lors de la récupération du match : " . $e->getMessage();
        }
    } elseif (isset($_POST['enregistrer_resultat'])) {
        // Enregistrer le résultat
        $id_match = intval($_POST['id_match']);
        $resultat = $_POST['resultat'];

        try {
            $controller->enregistrerResultat($id_match, $resultat);
            $message = "Le résultat du match a été enregistré avec succès.";
            $matches = array_filter(
                $controller->afficherListe(),
                fn($match) => $match['statut'] === 'Terminé' && empty($match['resultat'])
            ); // Recharger les matchs
        } catch (Exception $e) {
            $message = "Erreur lors de l'enregistrement du résultat : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisir le résultat d'un match</title>
    <link rel="stylesheet" href="/Projet-sport/public/assets/css/formmatch.css">
</head>

<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    <div class="container">
        <h2>Liste des matchs terminés sans résultat</h2>
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
                                <form method="POST" action="">
                                    <input type="hidden" name="id_match" value="<?= htmlspecialchars($match['id_match']) ?>">
                                    <button type="submit" name="saisir_resultat">Saisir le résultat</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulaire pour saisir le résultat -->
        <?php if ($selectedMatch): ?>
            <div class="modify-container">
                <h2>Saisir le résultat</h2>
                <form method="POST" action="">
                    <input type="hidden" name="id_match" value="<?= htmlspecialchars($selectedMatch['id_match']) ?>">

                    <p><strong>Match :</strong> <?= htmlspecialchars($selectedMatch['equipe_adverse']) ?> - <?= htmlspecialchars($selectedMatch['lieu']) ?></p>

                    <label for="resultat">Résultat :</label>
                    <select id="resultat" name="resultat" required>
                        <option value="Victoire">Victoire</option>
                        <option value="Défaite">Défaite</option>
                        <option value="Nul">Nul</option>
                    </select>

                    <button type="submit" name="enregistrer_resultat">Enregistrer le résultat</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>

</html>
