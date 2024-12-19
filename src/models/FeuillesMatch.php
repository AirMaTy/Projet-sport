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
        $sql = "SELECT fm.id_feuille, fm.id_match, fm.id_joueur, fm.role, fm.poste, 
                       j.nom AS joueur_nom, j.prenom AS joueur_prenom
                FROM feuilles_match fm
                JOIN joueurs j ON fm.id_joueur = j.id_joueur
                ORDER BY fm.id_match";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les joueurs actifs
    public function getJoueursActifs()
    {
        $sql = "SELECT id_joueur, nom, prenom, poste_prefere 
                FROM joueurs 
                WHERE statut = 'Actif'";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un joueur à la feuille de match
    public function ajouterFeuilleMatch($id_match, $id_joueur, $role, $poste)
    {
        $sql = "INSERT INTO feuilles_match (id_match, id_joueur, role, poste)
                VALUES (:id_match, :id_joueur, :role, :poste)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_match' => $id_match,
            ':id_joueur' => $id_joueur,
            ':role' => $role,
            ':poste' => $poste
        ]);
    }

    // Récupérer la feuille de match par ID
    public function getFeuilleMatchById($id_match)
    {
        $sql = "SELECT fm.id_feuille, fm.id_joueur, j.nom, j.prenom, fm.role, fm.poste
                FROM feuilles_match fm
                JOIN joueurs j ON fm.id_joueur = j.id_joueur
                WHERE fm.id_match = :id_match";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_match', $id_match, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un joueur d'une feuille de match
    public function supprimerJoueurDeFeuille($id_match, $id_joueur)
    {
        $sql = "DELETE FROM feuilles_match WHERE id_match = :id_match AND id_joueur = :id_joueur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match, ':id_joueur' => $id_joueur]);
    }

    // Supprimer complètement une feuille de match
    public function supprimerFeuilleMatch($id_match)
    {
        $sql = "DELETE FROM feuilles_match WHERE id_match = :id_match";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
    }
}
