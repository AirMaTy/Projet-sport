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
    // Ajouter un joueur
    if (isset($_POST['ajouter_joueur'])) {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $num_licence = trim($_POST['num_licence']);
        $date_naissance = $_POST['date_naissance'];
        $taille_cm = intval($_POST['taille_cm']);
        $poids_kg = intval($_POST['poids_kg']);
        $statut = trim($_POST['statut']);
        $poste_prefere = trim($_POST['poste_prefere']);

        if (!empty($nom) && !empty($prenom) && !empty($num_licence) && !empty($date_naissance) && $taille_cm > 0 && $poids_kg > 0 && !empty($statut) && !empty($poste_prefere)) {
            try {
                $controller->ajouterJoueur($nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, '', $poste_prefere);
                $message = "Le joueur a été ajouté avec succès.";
            } catch (Exception $e) {
                $message = "Erreur lors de l'ajout : " . $e->getMessage();
            }
        } else {
            $message = "Veuillez remplir tous les champs correctement.";
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
        $poste_prefere = trim($_POST['poste_prefere']);

        if (!empty($nom) && !empty($prenom) && !empty($num_licence) && !empty($date_naissance) && $taille_cm > 0 && $poids_kg > 0 && !empty($statut) && !empty($poste_prefere)) {
            try {
                $controller->modifierJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere);
                $message = "Le joueur a été modifié avec succès.";
            } catch (Exception $e) {
                $message = "Erreur lors de la modification : " . $e->getMessage();
            }
        } else {
            $message = "Veuillez remplir tous les champs correctement.";
        }
    }

    // Ajouter un commentaire
    if (isset($_POST['ajouter_commentaire'])) {
      $id_joueur = intval($_POST['id']);
      $commentaire = trim($_POST['nouveau_commentaire']);
  
      if (!empty($commentaire)) {
          try {
              $controller->ajouterCommentaire($id_joueur, $commentaire);
              $message = "Le commentaire a été ajouté avec succès.";
          } catch (Exception $e) {
              $message = "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
          }
      } else {
          $message = "Veuillez entrer un commentaire valide.";
      }
    }
  

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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des joueurs</title>
    <link rel="stylesheet" href="/Projet-sport/public/assets/css/formjoueurs.css">
</head>
<body>
<?php include(__DIR__ . '/../layouts/header.php'); ?>

<div class="container">
    <!-- Afficher les messages -->
    <?php if (!empty($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="forms-container">
        <!-- Formulaire d'ajout -->
        <div class="add-container">
            <form method="POST" action="">
                <h2>Ajouter un nouveau joueur</h2>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="num_licence">Numéro de licence :</label>
                <input type="text" id="num_licence" name="num_licence" required>

                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" required>

                <label for="taille_cm">Taille (cm) :</label>
                <input type="number" id="taille_cm" name="taille_cm" required>

                <label for="poids_kg">Poids (kg) :</label>
                <input type="number" id="poids_kg" name="poids_kg" required>

                <label for="statut">Statut :</label>
                <select id="statut" name="statut" required>
                    <option value="Actif">Actif</option>
                    <option value="Blessé">Blessé</option>
                    <option value="Suspendu">Suspendu</option>
                </select>

                <label for="poste_prefere">Poste préféré :</label>
                <input type="text" id="poste_prefere" name="poste_prefere" required>

                <button type="submit" name="ajouter_joueur">Ajouter</button>
            </form>
        </div>

        <!-- Formulaire de recherche -->
        <div class="search-container">
            <h2>Rechercher un joueur</h2>
            <form method="POST" action="">
                <input type="text" name="recherche" placeholder="Rechercher un joueur par nom, poste ou ID...">
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
                        <?php foreach ($resultats as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars($res['id']) ?></td>
                                <td><?= htmlspecialchars($res['nom']) ?></td>
                                <td><?= htmlspecialchars($res['prenom']) ?></td>
                                <td><?= htmlspecialchars($res['age']) ?></td>
                                <td><?= htmlspecialchars($res['poste']) ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($res['id']) ?>">
                                        <button type="submit" name="modifier">Modifier</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Formulaire de modification -->
        <?php if ($joueur): ?>
            <div class="modify-container">
                <h2>Modifier le joueur</h2>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($joueur['id']) ?>">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($joueur['nom']) ?>" required>

                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($joueur['prenom']) ?>" required>

                    <label for="num_licence">Numéro de licence :</label>
                    <input type="text" id="num_licence" name="num_licence" value="<?= htmlspecialchars($joueur['num_licence']) ?>" required>

                    <label for="date_naissance">Date de naissance :</label>
                    <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($joueur['date_naissance']) ?>" required>

                    <label for="taille_cm">Taille (cm) :</label>
                    <input type="number" id="taille_cm" name="taille_cm" value="<?= htmlspecialchars($joueur['taille_cm']) ?>" required>

                    <label for="poids_kg">Poids (kg) :</label>
                    <input type="number" id="poids_kg" name="poids_kg" value="<?= htmlspecialchars($joueur['poids_kg']) ?>" required>

                    <label for="statut">Statut :</label>
                    <select id="statut" name="statut" required>
                        <option value="Actif" <?= $joueur['statut'] === 'Actif' ? 'selected' : '' ?>>Actif</option>
                        <option value="Blessé" <?= $joueur['statut'] === 'Blessé' ? 'selected' : '' ?>>Blessé</option>
                        <option value="Suspendu" <?= $joueur['statut'] === 'Suspendu' ? 'selected' : '' ?>>Suspendu</option>
                    </select>

                    <label for="poste_prefere">Poste préféré :</label>
                    <input type="text" id="poste_prefere" name="poste_prefere" value="<?= htmlspecialchars($joueur['poste_prefere']) ?>" required>

                    <button type="submit" name="sauvegarder">Sauvegarder</button>
                </form>

                <!-- Ajouter un commentaire -->
                <div class="add-comment-container">
                    <h3>Ajouter un commentaire</h3>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($joueur['id'] ?? '') ?>">
                        <textarea id="nouveau_commentaire" name="nouveau_commentaire" placeholder="Ajouter un commentaire..." required></textarea>
                        <button type="submit" name="ajouter_commentaire">Ajouter le commentaire</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>
</html>
