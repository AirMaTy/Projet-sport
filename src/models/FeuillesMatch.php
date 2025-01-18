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

    public function getAllFeuillesMatch()
    {
        $sql = "SELECT fm.id_feuille, fm.id_match, fm.id_joueur, fm.role, fm.poste, 
                       j.nom AS joueur_nom, j.prenom AS joueur_prenom
                FROM feuilles_match fm
                JOIN joueurs j ON fm.id_joueur = j.id_joueur
                ORDER BY fm.id_match";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJoueursActifs()
    {
        $sql = "SELECT id_joueur, nom, prenom, poste_prefere 
                FROM joueurs 
                WHERE statut = 'Actif'";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function supprimerJoueurDeFeuille($id_match, $id_joueur)
    {
        $sql = "DELETE FROM feuilles_match WHERE id_match = :id_match AND id_joueur = :id_joueur";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match, ':id_joueur' => $id_joueur]);
    }

    public function supprimerFeuilleMatch($id_match)
    {
        $sql = "DELETE FROM feuilles_match WHERE id_match = :id_match";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
    }

    public function isMatchFinished($id_match)
    {
        $sql = "SELECT statut FROM matchs WHERE id_match = :id_match";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchColumn() === 'Terminé';
    }

    public function countJoueursInFeuille($id_match)
    {
        $sql = "SELECT COUNT(*) FROM feuilles_match WHERE id_match = :id_match";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
        return (int) $stmt->fetchColumn();
    }

    public function ajouterEvaluation($id_match, $id_joueur, $note, $commentaire)
    {
        $sql = "INSERT INTO evaluations (id_match, id_joueur, note, commentaire)
                VALUES (:id_match, :id_joueur, :note, :commentaire)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_match' => $id_match,
            ':id_joueur' => $id_joueur,
            ':note' => $note,
            ':commentaire' => $commentaire
        ]);
    }

    public function modifierEvaluation($id_evaluation, $note, $commentaire)
    {
        $sql = "UPDATE evaluations
                SET note = :note, commentaire = :commentaire
                WHERE id_evaluation = :id_evaluation";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_evaluation' => $id_evaluation,
            ':note' => $note,
            ':commentaire' => $commentaire
        ]);
    }

    public function supprimerEvaluation($id_evaluation)
    {
        $sql = "DELETE FROM evaluations WHERE id_evaluation = :id_evaluation";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id_evaluation' => $id_evaluation]);
    }

    public function getEvaluationsByMatch($id_match)
    {
        $sql = "SELECT e.id_evaluation, e.id_match, e.id_joueur, e.note, e.commentaire, 
                       j.nom AS joueur_nom, j.prenom AS joueur_prenom
                FROM evaluations e
                JOIN joueurs j ON e.id_joueur = j.id_joueur
                WHERE e.id_match = :id_match";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJoueursPourEvaluation($id_match)
    {
        $sql = "SELECT fm.id_joueur, j.nom, j.prenom, fm.role, fm.poste
                FROM feuilles_match fm
                JOIN joueurs j ON fm.id_joueur = j.id_joueur
                JOIN matchs m ON fm.id_match = m.id_match
                WHERE fm.id_match = :id_match AND m.statut = 'Terminé'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
