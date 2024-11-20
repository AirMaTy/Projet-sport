<?php
class MatchModel {
    private $db;

    public function __construct($db) {
        if (!$db) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->db = $db;
    }

    public function getAll() {
        $sql = "
            SELECT 
                id_match AS id_match, 
                date_match AS date_match, 
                heure_match AS heure_match, 
                equipe_adverse AS equipe_adverse, 
                lieu AS lieu, 
                statut AS statut, 
                resultat AS resultat 
            FROM matchs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
