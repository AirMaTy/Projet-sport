<?php
class Joueur {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "
            SELECT 
                id_joueur AS id, 
                nom, 
                prenom, 
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_naissance)), '%Y') + 0 AS age, 
                poste_prefere AS poste, 
                num_licence AS `num_licence`, 
                taille_cm AS `taille_cm`, 
                poids_kg AS `poids_kg`, 
                commentaire AS `commentaire` 
            FROM joueurs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
