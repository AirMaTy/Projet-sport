<?php
require_once __DIR__ . '/../models/FeuillesMatch.php';

class FeuillesMatchController
{
    private $feuillesMatch;

    public function __construct($pdo)
    {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->feuillesMatch = new FeuillesMatch($pdo);
    }

    public function afficherFeuillesMatch()
    {
        return $this->feuillesMatch->getAllFeuillesMatch();
    }

    public function afficherJoueursActifs()
    {
        return $this->feuillesMatch->getJoueursActifs();
    }

    public function creerFeuilleMatch($id_match, $joueurs)
    {
        foreach ($joueurs as $joueur) {
            $this->feuillesMatch->ajouterFeuilleMatch($id_match, $joueur['id_joueur'], $joueur['role'], $joueur['poste']);
        }
    }

    public function getFeuilleMatch($id_match)
    {
        return $this->feuillesMatch->getFeuilleMatchById($id_match);
    }

    public function supprimerJoueurDeFeuille($id_match, $id_joueur)
    {
        $this->feuillesMatch->supprimerJoueurDeFeuille($id_match, $id_joueur);
    }

    public function supprimerFeuilleMatch($id_match)
    {
        $this->feuillesMatch->supprimerFeuilleMatch($id_match);
    }
}
