<?php if (!empty($joueursActifs)): ?>
    <h2>Titulaires</h2>
    <?php foreach ($joueursActifs as $joueur): ?>
        <label>
            <input type="checkbox" name="titulares[]" value="<?= htmlspecialchars($joueur['id']); ?>">
            <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']); ?>
            (Poste : <input type="text" name="postes[<?= $joueur['id']; ?>]" placeholder="Poste">)
        </label><br>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucun joueur actif trouvé.</p>
<?php endif; ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection des Joueurs</title>
    <link rel="stylesheet" href="/assets/css/formmatch.css">
</head>
<body>
    <h1>Sélection des Joueurs pour le Match</h1>
    <form method="POST" action="/feuilles_match/saveSelection">
        <label for="match_id">ID du Match :</label>
        <input type="text" name="match_id" id="match_id" required>

        <h2>Titulaires</h2>
        <?php if (!empty($joueursActifs)): ?>
            <?php foreach ($joueursActifs as $joueur): ?>
                <label>
                    <input type="checkbox" name="titulares[]" value="<?= htmlspecialchars($joueur['id']); ?>">
                    <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']); ?>
                    (Poste : <input type="text" name="postes[<?= $joueur['id']; ?>]" placeholder="Poste">)
                </label><br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun joueur actif disponible pour ce match.</p>
        <?php endif; ?>

        <h2>Remplaçants</h2>
        <?php if (!empty($joueursActifs)): ?>
            <?php foreach ($joueursActifs as $joueur): ?>
                <label>
                    <input type="checkbox" name="remplacants[]" value="<?= htmlspecialchars($joueur['id']); ?>">
                    <?= htmlspecialchars($joueur['nom'] . ' ' . $joueur['prenom']); ?>
                    (Poste : <input type="text" name="postes[<?= $joueur['id']; ?>]" placeholder="Poste">)
                </label><br>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun joueur actif disponible pour ce match.</p>
        <?php endif; ?>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
