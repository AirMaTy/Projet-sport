# Gestion d'une équipe de sport

## Description

Ce projet est une application web destinée aux entraîneurs sportifs pour faciliter la gestion de leur équipe. Il permet de gérer les joueurs, les matchs, les sélections avant les rencontres, et d'analyser les performances grâce à des statistiques détaillées. L'application est sécurisée et nécessite une authentification pour être utilisée.

## Lien vers le site

Accédez au site de l'application : [Gestion d'équipe sportive](http://r301-projet-sport.alwaysdata.net)
Pour obtenir les informations de connexion au site, contactez-moi.
---

## Fonctionnalités principales

### Gestion des joueurs
- Ajouter, modifier, supprimer et consulter les joueurs.
- Enregistrer des informations détaillées :
  - Nom et prénom
  - Numéro de licence
  - Date de naissance
  - Taille et poids
  - Commentaires personnels
  - Statut : Actif, Blessé, Suspendu, ou Absent

### Gestion des matchs
- Ajouter, modifier, supprimer et consulter les matchs.
- Informations des matchs :
  - Date et heure
  - Équipe adverse
  - Lieu (domicile ou extérieur)
  - Résultat (après le match)

### Feuilles de match
- Sélectionner les joueurs pour chaque match (titulaire ou remplaçant).
- Afficher les détails des joueurs (taille, poids, commentaires, évaluations).
- Validation uniquement si le nombre minimum de joueurs est atteint.

### Évaluations et statistiques
- Noter les performances des joueurs (système de notation de 1 à 5).
- Calculer des statistiques :
  - Nombre et pourcentage de victoires, défaites et nuls.
  - Statistiques individuelles des joueurs :
    - Statut actuel
    - Poste préféré
    - Nombre de titularisations et remplacements
    - Moyenne des évaluations
    - Sélections consécutives
    - Pourcentage de matchs gagnés auxquels le joueur a participé

### Sécurité et navigation
- Authentification obligatoire pour accéder à l'application.
- Gestion sécurisée des mots de passe (hashés en base de données).
- Prévention des injections SQL.
- Menu de navigation intuitif accessible sur toutes les pages.

---

## Modèle de données

### Joueurs
- **ID** (clé primaire)
- Nom
- Prénom
- Numéro de licence
- Date de naissance
- Taille
- Poids
- Commentaires
- Statut

### Matchs
- **ID** (clé primaire)
- Date
- Heure
- Équipe adverse
- Lieu (domicile ou extérieur)
- Résultat

### Feuille de match
- **ID** (clé primaire)
- ID Match (clé étrangère)
- ID Joueur (clé étrangère)
- Rôle (Titulaire ou Remplaçant)
- Poste

### Évaluations
- **ID** (clé primaire)
- ID Joueur (clé étrangère)
- ID Match (clé étrangère)
- Note

---

## Technologies utilisées

- **Backend :** PHP avec PDO pour les interactions avec la base de données.
- **Frontend :** HTML, CSS pour l'interface utilisateur.
- **Base de données :** MySQL.
- **Authentification :** Gestion des utilisateurs avec mots de passe hashés.
- **Versionnement :** Git.

---

## Installation et exécution

1. Clonez le dépôt Git :
   ```bash
   git clone <lien-du-repo>
   ```
2. Configurez la base de données MySQL à l'aide des fichiers SQL fournis.
3. Configurez les paramètres de connexion à la base de données dans le fichier `config.php`.
4. Lancez un serveur local (par exemple, avec XAMPP ou WAMP).
5. Accédez à l'application via `http://localhost/nom_du_projet`.

---

## Auteurs

- [Maxime Lacoste](https://github.com/AirMaTy)

---

## Licence

© 2025 Gestion d'équipe sportive. Tous droits réservés.
