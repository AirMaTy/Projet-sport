<?php
require_once __DIR__ . '/../models/MatchModel.php';

class MatchsController {
    private $matchModel;

    public function __construct($pdo) {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->matchModel = new MatchModel($pdo);
    }

    public function afficherListe() {
        return $this->matchModel->getAll();
    }
}
