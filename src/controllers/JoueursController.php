<?php
require_once __DIR__ . '/../models/Joueur.php';

class JoueursController {
    private $joueur;

    public function __construct($pdo) {
        if (!$pdo) {
            throw new Exception("Connexion à la base de données non valide.");
        }
        $this->joueur = new Joueur($pdo);
    }

    public function afficherListe() {
        return $this->joueur->getAll();
    }
}
