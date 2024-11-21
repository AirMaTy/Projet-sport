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
    public function modifierJoueur($id, $nom, $prenom, $age, $poste) {
        return $this->joueur->updateJoueur($id, $nom, $prenom, $age, $poste); // Correction ici
    }

    public function getJoueurById($id) {
        $joueur = $this->joueur->getJoueurById($id);
        if (!$joueur) {
            throw new Exception("Aucun joueur trouvé avec l'ID $id");
        }
        return $joueur;
    }
    
}

