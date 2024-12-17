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
        $sql = "SELECT 
                    COUNT(*) AS total,
                    SUM(CASE WHEN resultat = 'Victoire' THEN 1 ELSE 0 END) AS victoires,
                    SUM(CASE WHEN resultat = 'Défaite' THEN 1 ELSE 0 END) AS defaites,
                    SUM(CASE WHEN resultat = 'Nul' THEN 1 ELSE 0 END) AS nuls
                FROM matchs
                WHERE statut = 'Terminé'";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
