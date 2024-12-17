<?php
require_once __DIR__ . '/../models/Statistique.php';

class StatistiquesController {
    private $statistiques;

    public function __construct($pdo) {
        $this->statistiques = new Statistiques($pdo);
    }

    // Récupérer les stats des matchs
    public function afficherStatsMatchs() {
        $matchStats = $this->statistiques->getMatchStats();
        if ($matchStats['total'] > 0) {
            $matchStats['pourcentage_gagne'] = round(($matchStats['gagne'] / $matchStats['total']) * 100, 2);
            $matchStats['pourcentage_perdu'] = round(($matchStats['perdu'] / $matchStats['total']) * 100, 2);
            $matchStats['pourcentage_nul'] = round(($matchStats['nul'] / $matchStats['total']) * 100, 2);
        } else {
            $matchStats['pourcentage_gagne'] = 0;
            $matchStats['pourcentage_perdu'] = 0;
            $matchStats['pourcentage_nul'] = 0;
        }
        return $matchStats;
    }

    // Récupérer les statistiques des joueurs
    public function afficherStatsJoueurs() {
        return $this->statistiques->getPlayerStats();
    }
}
