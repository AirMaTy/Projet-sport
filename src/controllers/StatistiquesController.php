<?php
require_once __DIR__ . '/../models/Statistique.php';

class StatistiquesController {
    private $statistiques;

    public function __construct($pdo) {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->statistiques = new Statistiques($pdo);
    }

    public function afficherStatsMatchs() {
        return $this->statistiques->getMatchStats();
    }
}
