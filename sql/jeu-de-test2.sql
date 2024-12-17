-- Réinitialisation complète des tables
DROP TABLE IF EXISTS `commentaires_joueurs`, `evaluations`, `feuilles_match`, `statistiques`, `matchs`, `joueurs`;

-- Création de la table joueurs
CREATE TABLE `joueurs` (
  `id_joueur` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `num_licence` VARCHAR(20) UNIQUE NOT NULL,
  `date_naissance` DATE NOT NULL,
  `taille_cm` INT,
  `poids_kg` FLOAT,
  `statut` ENUM('Actif', 'Blessé', 'Suspendu', 'Absent') DEFAULT 'Actif',
  `poste_prefere` VARCHAR(20)
);

-- Insertion des joueurs
INSERT INTO `joueurs` (`id_joueur`, `nom`, `prenom`, `num_licence`, `date_naissance`, `taille_cm`, `poids_kg`, `statut`, `poste_prefere`) VALUES
(1, 'Lemoine', 'Lucas', 'L567890', '1997-09-18', 185, 80, 'Actif', 'Défenseur'),
(2, 'Morel', 'Sophie', 'L456789', '1992-03-22', 170, 65, 'Actif', 'Gardien'),
(3, 'Dupont', 'Jean', 'L123456', '1995-05-10', 180, 75, 'Actif', 'Attaquant'),
(4, 'Martin', 'Claire', 'L234567', '1998-08-15', 165, 60, 'Actif', 'Milieu'),
(5, 'Durand', 'Paul', 'L345678', '2000-12-05', 175, 68, 'Actif', 'Défenseur');

-- Création de la table matchs
CREATE TABLE `matchs` (
  `id_match` INT AUTO_INCREMENT PRIMARY KEY,
  `date_match` DATE NOT NULL,
  `heure_match` TIME NOT NULL,
  `equipe_adverse` VARCHAR(50) NOT NULL,
  `lieu` ENUM('Domicile', 'Extérieur') NOT NULL,
  `statut` ENUM('À venir', 'Terminé') DEFAULT 'À venir',
  `resultat` ENUM('Victoire', 'Défaite', 'Nul') DEFAULT NULL
);

-- Insertion des matchs
INSERT INTO `matchs` (`id_match`, `date_match`, `heure_match`, `equipe_adverse`, `lieu`, `statut`, `resultat`) VALUES
(1, '2024-01-15', '15:00:00', 'Les Lions', 'Domicile', 'Terminé', 'Victoire'),
(2, '2024-01-22', '18:00:00', 'Les Tigres', 'Extérieur', 'Terminé', 'Défaite'),
(3, '2024-02-05', '16:30:00', 'Les Aigles', 'Domicile', 'Terminé', 'Nul');

-- Création de la table feuilles_match
CREATE TABLE `feuilles_match` (
  `id_feuille` INT AUTO_INCREMENT PRIMARY KEY,
  `id_match` INT NOT NULL,
  `id_joueur` INT NOT NULL,
  `role` ENUM('Titulaire', 'Remplaçant') NOT NULL,
  `poste` VARCHAR(20),
  FOREIGN KEY (`id_match`) REFERENCES `matchs`(`id_match`),
  FOREIGN KEY (`id_joueur`) REFERENCES `joueurs`(`id_joueur`)
);

-- Insertion des feuilles de match
INSERT INTO `feuilles_match` (`id_match`, `id_joueur`, `role`, `poste`) VALUES
(1, 1, 'Titulaire', 'Défenseur'),
(1, 3, 'Titulaire', 'Attaquant'),
(1, 4, 'Remplaçant', 'Milieu'),
(2, 2, 'Titulaire', 'Gardien'),
(2, 5, 'Titulaire', 'Défenseur');

-- Création de la table evaluations
CREATE TABLE `evaluations` (
  `id_evaluation` INT AUTO_INCREMENT PRIMARY KEY,
  `id_match` INT NOT NULL,
  `id_joueur` INT NOT NULL,
  `note` INT,
  `commentaire` TEXT,
  FOREIGN KEY (`id_match`) REFERENCES `matchs`(`id_match`),
  FOREIGN KEY (`id_joueur`) REFERENCES `joueurs`(`id_joueur`)
);

-- Insertion des évaluations
INSERT INTO `evaluations` (`id_match`, `id_joueur`, `note`, `commentaire`) VALUES
(1, 1, 4, 'Solide en défense'),
(1, 3, 5, 'A marqué un but décisif'),
(2, 2, 3, 'Bonne gestion du jeu'),
(2, 5, 2, 'Quelques erreurs en défense');

-- Création de la table statistiques
CREATE TABLE `statistiques` (
  `id_joueur` INT PRIMARY KEY,
  `nombre_titularisations` INT DEFAULT 0,
  `nombre_remplacements` INT DEFAULT 0,
  `moyenne_evaluation` FLOAT DEFAULT 0,
  `nombre_matchs_consecutifs` INT DEFAULT 0,
  `pourcentage_victoires` FLOAT DEFAULT 0,
  FOREIGN KEY (`id_joueur`) REFERENCES `joueurs`(`id_joueur`)
);

-- Insertion des statistiques
INSERT INTO `statistiques` (`id_joueur`, `nombre_titularisations`, `nombre_remplacements`, `moyenne_evaluation`, `nombre_matchs_consecutifs`, `pourcentage_victoires`) VALUES
(1, 1, 0, 4, 1, 100),
(2, 1, 0, 3, 0, 0),
(3, 1, 0, 5, 1, 100),
(4, 0, 1, 0, 0, 0),
(5, 1, 0, 2, 0, 0);

-- Création de la table commentaires_joueurs
CREATE TABLE `commentaires_joueurs` (
  `id_commentaire` INT AUTO_INCREMENT PRIMARY KEY,
  `id_joueur` INT NOT NULL,
  `date_commentaire` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `commentaire` TEXT,
  FOREIGN KEY (`id_joueur`) REFERENCES `joueurs`(`id_joueur`)
);

-- Insertion des commentaires
INSERT INTO `commentaires_joueurs` (`id_joueur`, `commentaire`) VALUES
(1, 'Excellent match, toujours présent dans les duels'),
(2, 'Bonne gestion du jeu mais quelques imprécisions'),
(3, 'Décisif en attaque avec un but marqué'),
(5, 'Besoin de travailler les placements défensifs');
