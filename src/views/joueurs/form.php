<?php
// Inclure les fichiers nécessaires
require '../../config/database.php';
require '../../src/models/Joueur.php';
require '../../src/controllers/JoueursController.php';

// Initialiser la connexion et le contrôleur
if (!isset($pdo) || !$pdo instanceof PDO) {
    die("Erreur : La connexion PDO est invalide.");
}
$controller = new JoueursController($pdo);

// Initialiser les variables
$resultats = [];
$joueur = null;
$message = '';

// Gestion des actions utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recherche de joueurs
    if (isset($_POST['recherche'])) {
        $critere = trim($_POST['recherche']);
        if (!empty($critere)) {
            $resultats = $controller->rechercherJoueurs($critere);
        } else {
            $message = "Veuillez entrer un critère de recherche.";
        }
    }

    // Sélectionner un joueur pour modification
    if (isset($_POST['modifier'])) {
        $id = intval($_POST['id']);
        $joueur = $controller->rechercherJoueurs($id)[0] ?? null;
    }

    // Sauvegarder les modifications d'un joueur
    if (isset($_POST['sauvegarder'])) {
        $id = intval($_POST['id']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $age = intval($_POST['age']);
        $poste = trim($_POST['poste']);
        if (!empty($nom) && !empty($prenom) && !empty($poste) && $age > 0) {
            $controller->modifierJoueur($id, $nom, $prenom, $age, $poste);
            $message = "Le joueur a été modifié avec succès.";
            $joueur = null; // Réinitialiser le joueur sélectionné
        } else {
            $message = "Veuillez remplir tous les champs correctement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher et modifier un joueur</title>
</head>
<body>
    <h1>Rechercher et modifier un joueur</h1>

    <!-- Message -->
    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Formulaire de recherche -->
    <form method="POST" action="">
        <label for="recherche">Rechercher un joueur :</label>
        <input type="text" id="recherche" name="recherche" placeholder="ID, nom, poste..." value="<?= htmlspecialchars($_POST['recherche'] ?? '') ?>">
        <button type="submit">Rechercher</button>
    </form>

    <!-- Tableau des résultats -->
    <?php if (!empty($resultats)): ?>
        <h2>Résultats de la recherche</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Poste</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultats as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['id']) ?></td>
                        <td><?= htmlspecialchars($joueur['nom']) ?></td>
                        <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                        <td><?= htmlspecialchars($joueur['age']) ?></td>
                        <td><?= htmlspecialchars($joueur['poste']) ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="id" value="<?= $joueur['id'] ?>">
                                <button type="submit" name="modifier">Modifier</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_POST['recherche'])): ?>
        <p>Aucun joueur trouvé.</p>
    <?php endif; ?>

    <!-- Formulaire de modification -->
    <?php if ($joueur): ?>
    <h2>Modifier le joueur</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($joueur['id_joueur'] ?? '') ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($joueur['nom'] ?? '') ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($joueur['prenom'] ?? '') ?>" required>

        <label for="num_licence">Numéro de licence :</label>
        <input type="text" id="num_licence" name="num_licence" value="<?= htmlspecialchars($joueur['num_licence'] ?? '') ?>" required>

        <label for="date_naissance">Date de naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($joueur['date_naissance'] ?? '') ?>" required>

        <label for="taille_cm">Taille (en cm) :</label>
        <input type="number" id="taille_cm" name="taille_cm" value="<?= htmlspecialchars($joueur['taille_cm'] ?? '') ?>" required>

        <label for="poids_kg">Poids (en kg) :</label>
        <input type="number" id="poids_kg" name="poids_kg" value="<?= htmlspecialchars($joueur['poids_kg'] ?? '') ?>" required>

        <label for="statut">Statut :</label>
        <select id="statut" name="statut" required>
            <option value="Actif" <?= ($joueur['statut'] ?? '') === 'Actif' ? 'selected' : '' ?>>Actif</option>
            <option value="Suspendu" <?= ($joueur['statut'] ?? '') === 'Suspendu' ? 'selected' : '' ?>>Suspendu</option>
            <option value="Blessé" <?= ($joueur['statut'] ?? '') === 'Blessé' ? 'selected' : '' ?>>Blessé</option>
        </select>

        <label for="commentaire">Commentaire :</label>
        <textarea id="commentaire" name="commentaire"><?= htmlspecialchars($joueur['commentaire'] ?? '') ?></textarea>

        <label for="poste_prefere">Poste préféré :</label>
        <input type="text" id="poste_prefere" name="poste_prefere" value="<?= htmlspecialchars($joueur['poste_prefere'] ?? '') ?>" required>

        <button type="submit" name="sauvegarder">Sauvegarder</button>

    </form>
    <?php else: ?>
        <p>Aucun joueur sélectionné pour modification.</p>
    <?php endif; ?>




</body>
</html>
