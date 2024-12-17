<?php
require_once __DIR__ . '/../models/FeuillesMatch.php';

class FeuillesMatchController
{
    private $feuillesMatch;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->feuillesMatch = new FeuillesMatch($pdo);
    }

    // Méthode pour afficher toutes les feuilles de match
    public function afficherFeuillesMatch()
    {
        try {
            // Récupérer les feuilles de match via le modèle
            $feuillesMatch = $this->feuillesMatch->getAllFeuillesMatch();

            // Inclure la vue avec les données
            require_once __DIR__ . '/../views/feuilles_match/affichage.php';
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
