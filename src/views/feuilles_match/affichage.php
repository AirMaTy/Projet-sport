<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Feuilles de Match</title>
    <link rel="stylesheet" href="/assets/css/matchs.css">
</head>
<body>
    <h1>Liste des Feuilles de Match</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>ID Feuille</th>
                <th>ID Match</th>
                <th>ID Joueur</th>
                <th>Rôle</th>
                <th>Poste</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($feuillesMatch)): ?>
                <?php foreach ($feuillesMatch as $feuille): ?>
                    <tr>
                        <td><?= htmlspecialchars($feuille['id_feuille']); ?></td>
                        <td><?= htmlspecialchars($feuille['id_match']); ?></td>
                        <td><?= htmlspecialchars($feuille['id_joueur']); ?></td>
                        <td><?= htmlspecialchars($feuille['role']); ?></td>
                        <td><?= htmlspecialchars($feuille['poste']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune feuille de match trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
