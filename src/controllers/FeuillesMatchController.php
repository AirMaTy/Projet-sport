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
        if ($this->feuillesMatch->isMatchFinished($id_match)) {
            throw new Exception("Impossible de modifier une feuille de match pour un match terminé.");
        }

        $nombreActuel = $this->feuillesMatch->countJoueursInFeuille($id_match);
        $nouveauxJoueurs = count($joueurs);

        if ($nombreActuel + $nouveauxJoueurs > 5) {
            throw new Exception(
                "Impossible d'ajouter ces joueurs. La feuille de match actuelle contient déjà {$nombreActuel} joueurs. "
                . "Vous ne pouvez pas dépasser la limite de 5 joueurs par feuille de match."
            );
        }

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
        if ($this->feuillesMatch->isMatchFinished($id_match)) {
            throw new Exception("Impossible de modifier une feuille de match pour un match terminé.");
        }

        $this->feuillesMatch->supprimerJoueurDeFeuille($id_match, $id_joueur);
    }

    public function supprimerFeuilleMatch($id_match)
    {
        if ($this->feuillesMatch->isMatchFinished($id_match)) {
            throw new Exception("Impossible de modifier une feuille de match pour un match terminé.");
        }

        $this->feuillesMatch->supprimerFeuilleMatch($id_match);
    }

    public function ajouterEvaluation($id_match, $id_joueur, $note, $commentaire)
    {
        return $this->feuillesMatch->ajouterEvaluation($id_match, $id_joueur, $note, $commentaire);
    }

    public function modifierEvaluation($id_evaluation, $note, $commentaire)
    {
        return $this->feuillesMatch->modifierEvaluation($id_evaluation, $note, $commentaire);
    }

    public function supprimerEvaluation($id_evaluation)
    {
        return $this->feuillesMatch->supprimerEvaluation($id_evaluation);
    }

    public function getEvaluationsByMatch($id_match)
    {
        return $this->feuillesMatch->getEvaluationsByMatch($id_match);
    }

    public function getJoueursPourEvaluation($id_match)
    {
        if (!$this->feuillesMatch->isMatchFinished($id_match)) {
            throw new Exception("Le match sélectionné n'a pas encore été joué.");
        }

        return $this->feuillesMatch->getJoueursPourEvaluation($id_match);
    }
}
