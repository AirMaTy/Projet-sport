<?php
require_once __DIR__ . '/../models/Statistique.php';

class StatistiquesController {
    private $statistiques;

    public function __construct($pdo) {
        $this->statistiques = new Statistiques($pdo);
    }

    public function afficherStatsMatchs() {
        // Appel à la méthode qui calcule les statistiques
        $matchStats = $this->statistiques->getMatchStats();

        // Calcul des pourcentages si des matchs existent
        if ($matchStats['total'] > 0) {
            $matchStats['pourcentage_gagne'] = round(($matchStats['gagne'] / $matchStats['total']) * 100, 2);
            $matchStats['pourcentage_perdu'] = round(($matchStats['perdu'] / $matchStats['total']) * 100, 2);
            $matchStats['pourcentage_nul'] = round(($matchStats['nul'] / $matchStats['total']) * 100, 2);
        } else {
            $matchStats['pourcentage_gagne'] = 0;
            $matchStats['pourcentage_perdu'] = 0;
            $matchStats['pourcentage_nul'] = 0;
        }

        // Retour des statistiques
        return $matchStats;
    }
}
