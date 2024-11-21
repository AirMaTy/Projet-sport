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
        $joueur = $controller->getJoueurById($id);
        if (!$joueur) {
            $message = "Joueur introuvable.";
        }
    }

    

    // Sauvegarder les modifications d'un joueur
    if (isset($_POST['sauvegarder'])) {
        $id = intval($_POST['id']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $num_licence = trim($_POST['num_licence']);
        $date_naissance = $_POST['date_naissance'];
        $taille_cm = intval($_POST['taille_cm']);
        $poids_kg = intval($_POST['poids_kg']);
        $statut = trim($_POST['statut']);
        $commentaire = trim($_POST['commentaire']);
        $poste_prefere = trim($_POST['poste_prefere']);
    
        if (!empty($nom) && !empty($prenom) && !empty($num_licence) && !empty($date_naissance) && $taille_cm > 0 && $poids_kg > 0 && !empty($statut) && !empty($poste_prefere)) {
            try {
                // Appel de la méthode avec tous les paramètres requis
                $controller->modifierJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $commentaire, $poste_prefere);
                $message = "Le joueur a été modifié avec succès.";
            } catch (Exception $e) {
                $message = "Erreur lors de la modification : " . $e->getMessage();
            }
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
    <link rel="stylesheet" href="/Projet-sport/public/assets/css/formjoueurs.css">
</head>
<body>
    <?php include(__DIR__ . '/../layouts/header.php'); ?>
    
    <!-- Section de recherche -->
    <div class="search-container">
        <h1>Rechercher et modifier un joueur</h1>
        <form method="POST" action="">
            <label for="recherche">Rechercher un joueur :</label>
            <input type="text" id="recherche" name="recherche" placeholder="ID, nom, poste..." value="<?= htmlspecialchars($_POST['recherche'] ?? '') ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <!-- Résultats de recherche -->
    <?php if (!empty($resultats)): ?>
        <div class="table-container">
            <h2>Résultats de la recherche</h2>
            <table>
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
        </div>
    <?php elseif (isset($_POST['recherche'])): ?>
        <p style="text-align: center;">Aucun joueur trouvé.</p>
    <?php endif; ?>


    <!-- Formulaire de modification -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier']) && $joueur): ?>
        <h2>Modifier le joueur</h2>
        <form method="POST" action="">
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($joueur['nom'] ?? '') ?>" required>
            </div>

            <div>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($joueur['prenom'] ?? '') ?>" required>
            </div>

            <div>
                <label for="num_licence">Numéro de licence :</label>
                <input type="text" id="num_licence" name="num_licence" value="<?= htmlspecialchars($joueur['num_licence'] ?? '') ?>" required>
            </div>

            <div>
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($joueur['date_naissance'] ?? '') ?>" required>
            </div>

            <div>
                <label for="taille_cm">Taille (en cm) :</label>
                <input type="number" id="taille_cm" name="taille_cm" value="<?= htmlspecialchars($joueur['taille_cm'] ?? '') ?>" required>
            </div>

            <div>
                <label for="poids_kg">Poids (en kg) :</label>
                <input type="number" id="poids_kg" name="poids_kg" value="<?= htmlspecialchars($joueur['poids_kg'] ?? '') ?>" required>
            </div>

            <div>
                <label for="statut">Statut :</label>
                <select id="statut" name="statut" required>
                    <option value="Actif" <?= ($joueur['statut'] ?? '') === 'Actif' ? 'selected' : '' ?>>Actif</option>
                    <option value="Blessé" <?= ($joueur['statut'] ?? '') === 'Blessé' ? 'selected' : '' ?>>Blessé</option>
                    <option value="Suspendu" <?= ($joueur['statut'] ?? '') === 'Suspendu' ? 'selected' : '' ?>>Suspendu</option>
                </select>
            </div>

            <div>
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire"><?= htmlspecialchars($joueur['commentaire'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="poste_prefere">Poste préféré :</label>
                <input type="text" id="poste_prefere" name="poste_prefere" value="<?= htmlspecialchars($joueur['poste_prefere'] ?? '') ?>" required>
            </div>

            <button type="submit" name="sauvegarder">Sauvegarder</button>
        </form>
    <?php else: ?>
        <p>Aucun joueur sélectionné pour modification.</p>
    <?php endif; ?>

    <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>

