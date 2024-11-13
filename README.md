# Projet : Gestion d'une Équipe de Sport

## Description du Projet

Votre équipe favorite a besoin de vous ! L'entraîneur souhaite une application pour :
- Administrer la liste des joueurs (nom, prénom, numéro de licence, date de naissance, taille, poids).
- Administrer la liste des matchs (date, heure, équipe adverse, lieu, résultat).
- Ajouter des notes personnelles sur chaque joueur (commentaires) et leur statut : **Actif**, **Blessé**, **Suspendu** ou **Absent**.
- Préparer les sélections pour chaque match avec des distinctions entre titulaires et remplaçants, tout en affichant les postes.

### Fonctionnalités Principales

- **Gestion des Joueurs :** Affichage, ajout, modification, suppression de joueurs.
- **Gestion des Matchs :** Affichage, ajout, modification, suppression des matchs.
- **Saisie des Feuilles de Match :** Sélection des joueurs actifs pour chaque match à venir.
- **Évaluation des Joueurs :** Notation de 1 à 5 ou par système d'étoiles.
- **Statistiques :** Analyse des performances avec nombre de victoires, défaites, matchs nuls et un tableau des performances des joueurs.

### Fonctionnalités Supplémentaires

- Sécurisation par une authentification utilisateur (nom d'utilisateur et mot de passe).
- Navigation simplifiée avec un menu présent sur chaque page.
- Prévention des injections SQL et sécurisation des données.

---

## Consignes Techniques

- **Langages Utilisés :** HTML, CSS, PHP, SQL (via PDO).
- **Séparation du Code :** Le code SQL doit être distinct du HTML/CSS (via une librairie de fonctions).
- **Sécurité des Mots de Passe :** Les mots de passe ne sont pas stockés en clair.
- **Gestion du Code Source :** Utilisation de Git.

---

## Instructions de Développement

1. **Modélisation des Données :**  
   Créez un modèle de données à valider par l'enseignant, puis implémentez la base de données MySQL.
   
2. **Gestion des Joueurs et des Matchs :**  
   Implémentez les pages pour gérer les joueurs et les matchs (CRUD).
   
3. **Saisie des Feuilles de Match :**  
   Créez une interface pour sélectionner les joueurs actifs et définir les rôles (titulaire ou remplaçant).

4. **Affichage et Modification des Matchs :**  
   Permettez la modification des sélections et des résultats.

5. **Statistiques des Joueurs :**  
   Affichez les statistiques des joueurs : statut, poste préféré, sélections, évaluations moyennes, etc.

6. **Authentification :**  
   Ajoutez une page de connexion pour sécuriser l'accès.

---

## Suggestions d'Adaptation

- **Choix du Sport :** Adaptez le projet à un sport de votre choix (ex. Football, Basketball).
- **Ergonomie et Design :** Utilisez des feuilles de style pour rendre l'application intuitive et agréable.

---

## Hébergement Gratuit

Pour déployer l'application, voici quelques options gratuites :
- [AlwaysData](https://www.alwaysdata.com/fr/)
- [InfinityFree](https://www.infinityfree.com/)
- [000webhost](https://www.000webhost.com/)
- [PlanetHoster](https://www.planethoster.com/fr/World-Lite)
- [Byet](https://byet.host/)

---

## Remarques

> Ce projet doit être réalisé dans le cadre d'un projet universitaire. La priorité reste le code et les fonctionnalités avant la mise en forme.

---

**Auteur :** _Maxime Lacoste_
