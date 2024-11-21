<?php
class Joueur {
    private $db;

    public function __construct($db) {
        if (!$db instanceof PDO) {
            throw new Exception("Une instance PDO valide est requise.");
        }
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

    // Recherche de joueurs
    public function searchJoueurs($critere) {
        $critere = '%' . $critere . '%';
        $sql = "SELECT 
                    id_joueur AS id, 
                    nom, 
                    prenom, 
                    FLOOR(DATEDIFF(CURDATE(), date_naissance) / 365.25) AS age, 
                    poste_prefere AS poste 
                FROM joueurs 
                WHERE nom LIKE :critere 
                   OR prenom LIKE :critere 
                   OR poste_prefere LIKE :critere 
                   OR id_joueur LIKE :critere";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':critere', $critere, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Mise à jour des informations d'un joueur
    public function updateJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $commentaire, $poste_prefere) {
        try {
            $sql = "UPDATE joueurs 
                    SET 
                        nom = :nom, 
                        prenom = :prenom, 
                        num_licence = :num_licence, 
                        date_naissance = :date_naissance, 
                        taille_cm = :taille_cm, 
                        poids_kg = :poids_kg, 
                        statut = :statut, 
                        commentaire = :commentaire, 
                        poste_prefere = :poste_prefere 
                    WHERE id_joueur = :id";
    
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);
            $stmt->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
            $stmt->bindParam(':taille_cm', $taille_cm, PDO::PARAM_INT);
            $stmt->bindParam(':poids_kg', $poids_kg, PDO::PARAM_INT);
            $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
            $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
            $stmt->bindParam(':poste_prefere', $poste_prefere, PDO::PARAM_STR);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur SQL lors de la mise à jour : " . $e->getMessage());
        }
    }
    
    public function getJoueurById($id) {
        $sql = "SELECT 
                    id_joueur AS id, 
                    nom, 
                    prenom, 
                    num_licence, 
                    date_naissance, 
                    taille_cm, 
                    poids_kg, 
                    statut, 
                    commentaire, 
                    poste_prefere 
                FROM joueurs 
                WHERE id_joueur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    
}
