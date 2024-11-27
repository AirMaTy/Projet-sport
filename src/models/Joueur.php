<?php
class Joueur {
    private $db;

    public function __construct($db) {
        if (!$db instanceof PDO) {
            throw new Exception("Une instance PDO valide est requise.");
        }
        $this->db = $db;
    }

    // Récupérer tous les joueurs avec leurs commentaires groupés
    public function getAll() {
        $sql = "
            SELECT 
                j.id_joueur AS id, 
                j.nom, 
                j.prenom, 
                DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), j.date_naissance)), '%Y') + 0 AS age, 
                j.poste_prefere AS poste, 
                j.num_licence AS num_licence, 
                j.taille_cm AS taille_cm, 
                j.poids_kg AS poids_kg, 
                GROUP_CONCAT(c.commentaire SEPARATOR ' | ') AS commentaires
            FROM joueurs j
            LEFT JOIN commentaires_joueurs c ON j.id_joueur = c.id_joueur
            GROUP BY j.id_joueur, j.nom, j.prenom, j.date_naissance, j.poste_prefere, j.num_licence, j.taille_cm, j.poids_kg";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un commentaire pour un joueur
    public function ajouterCommentaire($id_joueur, $commentaire) {
        $sql = "INSERT INTO commentaires_joueurs (id_joueur, commentaire, date_commentaire)
                VALUES (:id_joueur, :commentaire, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
        return $stmt->execute();
    }


    // Mettre à jour les informations d'un joueur
    public function updateJoueur($id, $nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere) {
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
            $stmt->bindParam(':poste_prefere', $poste_prefere, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur SQL lors de la mise à jour : " . $e->getMessage());
        }
    }

    // Récupérer les commentaires d'un joueur
    public function getCommentairesByJoueurId($id_joueur) {
        $sql = "SELECT commentaire, date_commentaire FROM commentaires_joueurs WHERE id_joueur = :id_joueur ORDER BY date_commentaire DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer les détails d'un joueur par ID
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
                    poste_prefere 
                FROM joueurs 
                WHERE id_joueur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Recherche de joueurs par critère
    public function searchJoueurs($critere) {
        $critere = '%' . $critere . '%'; // Préparer le critère pour une recherche partielle
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

    // Ajouter un nouveau joueur
    public function createJoueur($nom, $prenom, $num_licence, $date_naissance, $taille_cm, $poids_kg, $statut, $poste_prefere) {
        $sql = "INSERT INTO joueurs (nom, prenom, num_licence, date_naissance, taille_cm, poids_kg, statut, poste_prefere)
                VALUES (:nom, :prenom, :num_licence, :date_naissance, :taille_cm, :poids_kg, :statut, :poste_prefere)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':num_licence', $num_licence, PDO::PARAM_STR);
        $stmt->bindParam(':date_naissance', $date_naissance, PDO::PARAM_STR);
        $stmt->bindParam(':taille_cm', $taille_cm, PDO::PARAM_INT);
        $stmt->bindParam(':poids_kg', $poids_kg, PDO::PARAM_INT);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->bindParam(':poste_prefere', $poste_prefere, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    }

    public function supprimerJoueur(int $id): void
    {
        $sql = "DELETE FROM joueurs WHERE id_joueur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function aParticipeAMatch($id_joueur) {
        $sql = "SELECT COUNT(*) AS total 
                FROM feuilles_match 
                WHERE id_joueur = :id_joueur";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_joueur', $id_joueur, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0; // Retourne vrai si le joueur a participé à au moins un match
    }
    
}
