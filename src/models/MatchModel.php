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
    
        // Ajouter un nouveau match
        public function createMatch($date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat)
        {
            $sql = "INSERT INTO matchs (date_match, heure_match, equipe_adverse, lieu, statut, resultat)
                    VALUES (:date_match, :heure_match, :equipe_adverse, :lieu, :statut, :resultat)";
            $stmt = $this->db->prepare($sql);
        
            // Lier les paramètres aux colonnes de la table
            $stmt->bindParam(':date_match', $date_match, PDO::PARAM_STR);
            $stmt->bindParam(':heure_match', $heure_match, PDO::PARAM_STR);
            $stmt->bindParam(':equipe_adverse', $equipe_adverse, PDO::PARAM_STR);
            $stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
            $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
            $stmt->bindParam(':resultat', $resultat, PDO::PARAM_STR);
        
            // Exécuter la requête
            $stmt->execute();
            return true;
        }
        
        public function updateMatch($id_match, $date_match, $heure_match, $equipe_adverse, $lieu, $statut, $resultat)
        {
            $sql = "UPDATE matchs 
                    SET date_match = :date_match, 
                        heure_match = :heure_match, 
                        equipe_adverse = :equipe_adverse, 
                        lieu = :lieu, 
                        statut = :statut, 
                        resultat = :resultat
                    WHERE id_match = :id_match";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
            $stmt->bindParam(':date_match', $date_match, PDO::PARAM_STR);
            $stmt->bindParam(':heure_match', $heure_match, PDO::PARAM_STR);
            $stmt->bindParam(':equipe_adverse', $equipe_adverse, PDO::PARAM_STR);
            $stmt->bindParam(':lieu', $lieu, PDO::PARAM_STR);
            $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
            $stmt->bindParam(':resultat', $resultat, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }

        public function getMatchById($id_match)
        {
            $sql = "SELECT * FROM matchs WHERE id_match = :id_match";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateResultat($id_match, $resultat)
        {
            $sql = "UPDATE matchs SET resultat = :resultat WHERE id_match = :id_match";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
            $stmt->bindParam(':resultat', $resultat, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }

        public function deleteMatch($id_match)
        {
            $sql = "DELETE FROM matchs WHERE id_match = :id_match";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }



}
