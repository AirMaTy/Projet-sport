<?php
class FeuillesMatch
{
    private $db;

    public function __construct($db)
    {
        if (!$db instanceof PDO) {
            throw new Exception("Une instance PDO valide est requise.");
        }
        $this->db = $db;
    }

    // Récupérer toutes les feuilles de match
    public function getAllFeuillesMatch()
    {
        $sql = "SELECT * FROM feuilles_match";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle feuille de match
    public function createFeuilleMatch($match_id, $joueur_id, $role, $poste)
    {
        $sql = "INSERT INTO feuilles_match (id_match, id_joueur, role, poste) VALUES (:match_id, :joueur_id, :role, :poste)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
        $stmt->bindParam(':joueur_id', $joueur_id, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':poste', $poste, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Mettre à jour une feuille de match existante
    public function updateFeuilleMatch($id_feuille, $match_id, $joueur_id, $role, $poste)
    {
        $sql = "UPDATE feuilles_match 
                SET id_match = :match_id, id_joueur = :joueur_id, role = :role, poste = :poste 
                WHERE id_feuille = :id_feuille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_feuille', $id_feuille, PDO::PARAM_INT);
        $stmt->bindParam(':match_id', $match_id, PDO::PARAM_INT);
        $stmt->bindParam(':joueur_id', $joueur_id, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':poste', $poste, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Supprimer une feuille de match
    public function deleteFeuilleMatch($id_feuille)
    {
        $sql = "DELETE FROM feuilles_match WHERE id_feuille = :id_feuille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_feuille', $id_feuille, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Récupérer une feuille de match par ID
    public function getFeuilleMatchById($id)
    {
        $sql = "SELECT * FROM feuilles_match WHERE id_feuille = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si un joueur participe à un match
    public function joueurAParticipe($id_joueur)
    {
        $sql = "SELECT COUNT(*) as total FROM feuilles_match WHERE id_joueur = :id_joueur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }

}
