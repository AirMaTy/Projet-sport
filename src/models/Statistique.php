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

    public function getPlayerStats() {
        $query = "SELECT 
                    j.nom, 
                    j.poste_prefere,
                    j.statut,
                    COALESCE(s.nombre_titularisations, 0) AS titularisations,
                    COALESCE(s.nombre_remplacements, 0) AS remplacements,
                    COALESCE(s.moyenne_evaluation, 0) AS moyenne_evaluation,
                    COALESCE(s.pourcentage_victoires, 0) AS pourcentage_victoires
                  FROM joueurs j
                  LEFT JOIN statistiques s ON j.id_joueur = s.id_joueur";
        
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
