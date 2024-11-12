<?php
// session_start();
// if (!isset($_SESSION['user'])) {
//     header('Location: login.php');
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion de l'Équipe Sportive</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

    <?php include('../src/views/layouts/header.php'); ?>

    <main>
        <section class="introduction">
            <h2>Présentation de l'Application</h2>
            <p>
                Cette application a été conçue pour vous aider, en tant qu'entraîneur, à gérer efficacement votre équipe. Vous pouvez gérer la liste des joueurs, programmer et suivre les matchs, sélectionner les joueurs pour chaque rencontre, et analyser les performances de chaque joueur pour optimiser vos décisions.
            </p>
        </section>

        <section class="fonctionnalites">
            <h2>Fonctionnalités Principales</h2>
            <ul>
                <li><strong>Gestion des Joueurs</strong> : Ajouter, modifier, et supprimer des joueurs. Vous pouvez également ajouter des notes personnelles sur chaque joueur (commentaires, statut).</li>
                <li><strong>Gestion des Matchs</strong> : Ajouter et gérer les matchs, enregistrer le résultat à la fin de chaque rencontre.</li>
                <li><strong>Feuilles de Match</strong> : Sélectionner les joueurs pour chaque match, définir les titulaires, les remplaçants et le poste occupé par chaque joueur.</li>
                <li><strong>Évaluations</strong> : Noter la performance des joueurs après chaque match, pour suivre leur progression et leur contribution.</li>
                <li><strong>Statistiques</strong> : Consulter les statistiques d'équipe (pourcentage de victoires, défaites, etc.) et les statistiques individuelles de chaque joueur.</li>
            </ul>
        </section>

        <section class="utilisation">
            <h2>Comment utiliser l'application ?</h2>
            <p>
                Utilisez le menu de navigation ci-dessus pour accéder aux différentes sections de l'application :
            </p>
            <ul>
                <li><a href="joueurs/liste.php">Gestion des Joueurs</a> : pour voir, ajouter, et modifier les informations de vos joueurs.</li>
                <li><a href="matchs/liste.php">Gestion des Matchs</a> : pour consulter les matchs, ajouter de nouveaux matchs, et enregistrer les résultats.</li>
                <li><a href="feuilles_match/liste.php">Feuilles de Match</a> : pour préparer la sélection des joueurs pour chaque rencontre.</li>
                <li><a href="statistiques/statistiques.php">Statistiques</a> : pour consulter les statistiques d'équipe et individuelles des joueurs.</li>
            </ul>
        </section>

        <section class="informations-supplementaires">
            <h2>Informations Complémentaires</h2>
            <p>
                Avant de commencer, assurez-vous que tous les joueurs et les matchs sont bien enregistrés dans le système. Seuls les joueurs "Actifs" seront proposés pour les sélections de matchs. Les résultats et évaluations des joueurs peuvent être enregistrés après chaque match pour obtenir des statistiques précises.
            </p>
        </section>
    </main>
    <?php include('../src/views/layouts/footer.php'); ?>
    </body>
</html>
