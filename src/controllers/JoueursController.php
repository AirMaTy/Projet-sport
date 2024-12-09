<?php
require_once __DIR__ . '/../models/Joueur.php';

class JoueursController
{
    private $joueur;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->joueur = new Joueur($pdo);
    }

    // Afficher tous les joueurs
    public function afficherListe()
    {
        return $this->joueur->getAll();
    }

    // Rechercher des joueurs
    public function rechercherJoueurs($critere)
    {
        return $this->joueur->searchJoueurs($critere);
    }

    // Modifier les informations d'un joueur
    public function modifierJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere)
    {
        try {
            return $this->joueur->updateJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere);
        } catch (Exception $e) {
            return "Erreur lors de la modification : " . $e->getMessage();
        }
    }

    // Ajouter un commentaire via le contrôleur
    public function ajouterCommentaire($id_joueur, $commentaire)
    {
        try {
            return $this->joueur->ajouterCommentaire($id_joueur, $commentaire);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du commentaire : " . $e->getMessage());
        }
    }


    // Récupérer les commentaires d'un joueur
    public function getCommentaires($id_joueur)
    {
        try {
            return $this->joueur->getCommentairesByJoueurId($id_joueur);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des commentaires : " . $e->getMessage());
        }
    }

    // Récupérer les détails d'un joueur par ID
    public function getJoueurById($id)
    {
        try {
            return $this->joueur->getJoueurById($id);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du joueur : " . $e->getMessage());
        }
    }

    // Ajouter un joueur
    public function ajouterJoueur($nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere)
    {
        try {
            return $this->joueur->createJoueur($nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du joueur : " . $e->getMessage());
        }
    }

    public function supprimerJoueur(int $id): string
    {
        // Vérifie si le joueur a participé à un match
        if ($this->joueur->aParticipeAMatch($id)) {
            return "Impossible de supprimer le joueur : il a déjà participé à un ou plusieurs matchs.";
        }

        // Si le joueur n'a pas participé, supprimer
        $this->joueur->supprimerJoueur($id);
        return "Joueur supprimé avec succès.";
    }
}
