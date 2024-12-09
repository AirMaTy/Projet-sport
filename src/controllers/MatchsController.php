<?php
require_once __DIR__ . '/../models/MatchModel.php';

class MatchsController {
    private $matchModel;

    public function __construct($pdo) {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->matchModel = new MatchModel($pdo);
    }

    public function afficherListe() {
        return $this->matchModel->getAll();
    }

    // Ajouter un match
    public function ajouterMatch($date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat)
    {
        // Vérification : le résultat ne doit pas être ajouté si le statut est "À venir"
        if ($statut === 'À venir' && !empty($resultat)) {
            throw new Exception("Vous ne pouvez pas ajouter un résultat pour un match à venir.");
        }
    
        try {
            return $this->matchModel->createMatch($date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du match : " . $e->getMessage());
        }
    }
    
    
    public function modifierMatch($id_match, $date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat)
    {
        // Vérifiez que la date n'est pas dans le passé
        $date_aujourd_hui = date('Y-m-d'); // Obtenez la date actuelle
        if ($date_match < $date_aujourd_hui) {
            throw new Exception("La date d'un match ne peut pas être dans le passé.");
        }
    
        try {
            return $this->matchModel->updateMatch($id_match, $date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la modification du match : " . $e->getMessage());
        }
    }
    

        public function getMatchById($id_match)
    {
        try {
            return $this->matchModel->getMatchById($id_match);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du match : " . $e->getMessage());
        }
    }

    public function enregistrerResultat($id_match, $resultat)
    {
        try {
            return $this->matchModel->updateResultat($id_match, $resultat);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'enregistrement du résultat : " . $e->getMessage());
        }
    }
    
    public function supprimerMatch($id_match)
    {
        try {
            return $this->matchModel->deleteMatch($id_match);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression du match : " . $e->getMessage());
        }
    }
    

}
