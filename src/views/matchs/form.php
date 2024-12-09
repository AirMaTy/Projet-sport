<?php
// Inclure les fichiers nécessaires
require '../../config/database.php';
require '../../src/models/MatchModel.php';
require '../../src/controllers/MatchsController.php';

// Initialiser la connexion et le contrôleur
if (!isset($pdo) || !$pdo instanceof PDO) {
  die("Erreur : La connexion PDO est invalide.");
}
$controller = new MatchsController($pdo);

// Initialiser les variables
$message = '';
$matchs = [];

// Gestion des actions utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ajouter un match
  if (isset($_POST['ajouter_match'])) {
    $date_match = $_POST['date_match'];
    $heure_match = $_POST['heure_match'];
    $equipe_adverse = trim($_POST['equipe_adverse']);
    $lieu = trim($_POST['lieu']);
    $statut = trim($_POST['statut']);
    $resultat = trim($_POST['resultat']);

    if (!empty($date_match) && !empty($heure_match) && !empty($equipe_adverse) && !empty($lieu) && !empty($statut)) {
      try {
        $controller->ajouterMatch($date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat);
        $message = "Le match a été ajouté avec succès.";
      } catch (Exception $e) {
        $message = "Erreur lors de l'ajout du match : " . $e->getMessage();
      }
    } else {
      $message = "Veuillez remplir tous les champs obligatoires.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestion des matchs</title>
  <link rel="stylesheet" href="/Projet-sport/public/assets/css/formmatch.css">
</head>

<body>
  <?php include(__DIR__ . '/../layouts/header.php'); ?>

  <div class="container">
    <!-- Afficher les messages -->
    <?php if (!empty($message)): ?>
      <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="forms-container">
      <!-- Formulaire d'ajout de match -->
      <div class="add-container">
      <form method="POST" action="">
            <label for="date_match">Date :</label>
            <input type="date" id="date_match" name="date_match" required>

            <label for="heure_match">Heure :</label>
            <input type="time" id="heure_match" name="heure_match" required>

            <label for="equipe_adverse">Adversaire :</label>
            <input type="text" id="equipe_adverse" name="equipe_adverse" required>

            <label for="lieu">Lieu :</label>
            <select id="lieu" name="lieu" required>
                <option value="Domicile">Domicile</option>
                <option value="Extérieur">Extérieur</option>
            </select>

            <label for="statut">Statut :</label>
            <select id="statut" name="statut" required>
                <option value="À venir" <?= (isset($_POST['statut']) && $_POST['statut'] === 'À venir') ? 'selected' : '' ?>>À venir</option>
                <option value="Terminé" <?= (isset($_POST['statut']) && $_POST['statut'] === 'Terminé') ? 'selected' : '' ?>>Terminé</option>
            </select>

            <label for="resultat">Résultat :</label>
            <select id="resultat" name="resultat" 
                <?= (isset($_POST['statut']) && $_POST['statut'] === 'Terminé') || !isset($_POST['statut']) ? '' : 'disabled' ?>>
                <option value="">-- Aucun résultat --</option>
                <option value="Victoire" <?= (isset($_POST['resultat']) && $_POST['resultat'] === 'Victoire') ? 'selected' : '' ?>>Victoire</option>
                <option value="Défaite" <?= (isset($_POST['resultat']) && $_POST['resultat'] === 'Défaite') ? 'selected' : '' ?>>Défaite</option>
                <option value="Nul" <?= (isset($_POST['resultat']) && $_POST['resultat'] === 'Nul') ? 'selected' : '' ?>>Nul</option>
            </select>


            <button type="submit" name="ajouter_match">Ajouter le match</button>
        </form>


      </div>
    </div>
  </div>

  <?php include(__DIR__ . '/../layouts/footer.php'); ?>
</body>

</html>
