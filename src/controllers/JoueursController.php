<?php
require_once __DIR__ . '/../models/Joueur.php';

class JoueursController {
    private $joueur;

    public function __construct($pdo) {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->joueur = new Joueur($pdo);
    }

    public function afficherListe() {
        return $this->joueur->getAll();
    }

    // Méthode pour gérer la recherche
    public function rechercherJoueurs($critere) {
        return $this->joueur->searchJoueurs($critere); // Correction ici
    }

    // Méthode pour gérer la modification
    public function modifierJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $commentaire, $poste_prefere) {
        try {
            return $this->joueur->updateJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $commentaire, $poste_prefere);
        } catch (Exception $e) {
            return "Erreur lors de la modification : " . $e->getMessage();
        }
    }   

    public function getJoueurById($id) {
        try {
            return $this->joueur->getJoueurById($id);
        } catch (Exception $e) {
            return null;
        }
    }  
    
}

