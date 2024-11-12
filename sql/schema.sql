CREATE TABLE joueurs (
    id_joueur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    num_licence VARCHAR(20) UNIQUE NOT NULL,
    date_naissance DATE NOT NULL,
    taille_cm INT,
    poids_kg FLOAT,
    statut ENUM('Actif', 'Blessé', 'Suspendu', 'Absent') DEFAULT 'Actif',
    commentaire TEXT,
    poste_prefere VARCHAR(20)
);

CREATE TABLE matchs (
    id_match INT AUTO_INCREMENT PRIMARY KEY,
    date_match DATE NOT NULL,
    heure_match TIME NOT NULL,
    equipe_adverse VARCHAR(50) NOT NULL,
    lieu ENUM('Domicile', 'Extérieur') NOT NULL,
    statut ENUM('À venir', 'Terminé') DEFAULT 'À venir',
    resultat ENUM('Victoire', 'Défaite', 'Nul')
);

CREATE TABLE feuilles_match (
    id_feuille INT AUTO_INCREMENT PRIMARY KEY,
    id_match INT NOT NULL,
    id_joueur INT NOT NULL,
    role ENUM('Titulaire', 'Remplaçant') NOT NULL,
    poste VARCHAR(20),
    FOREIGN KEY (id_match) REFERENCES matchs(id_match),
    FOREIGN KEY (id_joueur) REFERENCES joueurs(id_joueur)
);

CREATE TABLE evaluations (
    id_evaluation INT AUTO_INCREMENT PRIMARY KEY,
    id_match INT NOT NULL,
    id_joueur INT NOT NULL,
    note INT CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    FOREIGN KEY (id_match) REFERENCES matchs(id_match),
    FOREIGN KEY (id_joueur) REFERENCES joueurs(id_joueur)
);

CREATE TABLE statistiques (
    id_joueur INT PRIMARY KEY,
    nombre_titularisations INT DEFAULT 0,
    nombre_remplacements INT DEFAULT 0,
    moyenne_evaluation FLOAT DEFAULT 0,
    nombre_matchs_consecutifs INT DEFAULT 0,
    pourcentage_victoires FLOAT DEFAULT 0,
    FOREIGN KEY (id_joueur) REFERENCES joueurs(id_joueur)
);
