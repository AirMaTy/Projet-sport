-- Ajouter des joueurs
INSERT INTO joueurs (nom, prenom, num_licence, date_naissance, taille_cm, poids_kg, statut, commentaire, poste_prefere)
VALUES
('Dupont', 'Jean', '12345', '1995-04-12', 180, 75, 'Actif', 'Bon meneur de jeu', 'Milieu'),
('Martin', 'Pierre', '23456', '1990-06-18', 175, 68, 'Actif', 'Rapide et endurant', 'Attaquant'),
('Durand', 'Luc', '34567', '1988-08-22', 185, 80, 'Blessé', 'Bon défenseur central', 'Défenseur'),
('Petit', 'Thomas', '45678', '2000-01-15', 178, 73, 'Suspendu', 'Agressif sur le terrain', 'Milieu'),
('Moreau', 'Antoine', '56789', '1992-11-02', 182, 77, 'Actif', 'Bon attaquant de pointe', 'Attaquant');

-- Ajouter des matchs
INSERT INTO matchs (date_match, heure_match, equipe_adverse, lieu, statut, resultat)
VALUES
('2024-01-15', '15:00:00', 'Les Lions', 'Domicile', 'Terminé', 'Victoire'),
('2024-01-22', '18:00:00', 'Les Tigres', 'Extérieur', 'Terminé', 'Défaite'),
('2024-02-05', '16:30:00', 'Les Aigles', 'Domicile', 'À venir', NULL),
('2024-02-12', '14:00:00', 'Les Renards', 'Extérieur', 'À venir', NULL);

-- Ajouter des feuilles de match (sélection des joueurs pour les matchs)
INSERT INTO feuilles_match (id_match, id_joueur, role, poste)
VALUES
(1, 1, 'Titulaire', 'Milieu'),
(1, 2, 'Titulaire', 'Attaquant'),
(1, 3, 'Remplaçant', 'Défenseur'),
(2, 1, 'Titulaire', 'Milieu'),
(2, 4, 'Titulaire', 'Milieu'),
(2, 5, 'Remplaçant', 'Attaquant');

-- Ajouter des évaluations pour les joueurs ayant participé aux matchs
INSERT INTO evaluations (id_match, id_joueur, note, commentaire)
VALUES
(1, 1, 4, 'Bon match, bonne gestion du milieu'),
(1, 2, 5, 'Excellente performance en attaque, a marqué 2 buts'),
(2, 1, 3, 'Match correct, mais aurait pu être plus actif'),
(2, 4, 2, 'Match difficile, plusieurs fautes commises');

-- Ajouter des statistiques pour chaque joueur
INSERT INTO statistiques (id_joueur, nombre_titularisations, nombre_remplacements, moyenne_evaluation, nombre_matchs_consecutifs, pourcentage_victoires)
VALUES
(1, 2, 0, 3.5, 2, 50),
(2, 1, 0, 5.0, 1, 100),
(3, 0, 1, NULL, 0, 0),
(4, 1, 0, 2.0, 1, 0),
(5, 0, 1, NULL, 0, 0);
