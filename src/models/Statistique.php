<?php
class Statistiques {
    private $db;

    public function __construct($db) {
        if (!$db instanceof PDO) {
            throw new Exception("Une instance PDO valide est requise.");
        }
        $this->db = $db;
    }

    // Méthode pour récupérer les statistiques des matchs
    public function getMatchStats() {
        $query = "SELECT 
                    COUNT(*) AS total,
                    SUM(CASE WHEN resultat = 'Victoire' THEN 1 ELSE 0 END) AS gagne,
                    SUM(CASE WHEN resultat = 'Défaite' THEN 1 ELSE 0 END) AS perdu,
                    SUM(CASE WHEN resultat = 'Nul' THEN 1 ELSE 0 END) AS nul
                  FROM matchs";
        $result = $this->db->query($query)->fetch();
    
        // Calcul des pourcentages si le total n'est pas nul
        $total = $result['total'];
        if ($total > 0) {
            $result['pourcentage_gagne'] = round(($result['gagne'] / $total) * 100, 2);
            $result['pourcentage_perdu'] = round(($result['perdu'] / $total) * 100, 2);
            $result['pourcentage_nul']   = round(($result['nul'] / $total) * 100, 2);
        } else {
            $result['pourcentage_gagne'] = $result['pourcentage_perdu'] = $result['pourcentage_nul'] = 0;
        }
    
        return $result;
    }
    
}
