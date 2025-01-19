<?php
$key = '2dd5d9323942569cc1d9e981b3d90c0d';

// Identifiants chiffrés
$encrypted_user = 'stA2PH3k0+2+PR+fxWF3q0VwSlBna3hqVnN6SkVQa0JrSGZwQmc9PQ==';
$encrypted_pass = '/XJlDyXXwEA1Xw+hcvnV9kZzQzkyTUdrY0xnaHRqY2h5ditpdEE9PQ==';

// Fonction de déchiffrement
function decrypt($data, $key)
{
    $data = base64_decode($data); // Décoder le texte base64
    $iv = substr($data, 0, 16); // Extraire le vecteur d'initialisation
    $encrypted = substr($data, 16); // Extraire le texte chiffré
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

// Déchiffrez les identifiants
$db_user = decrypt($encrypted_user, $key);
$db_pass = decrypt($encrypted_pass, $key);

// Informations de connexion à la base de données
$host = 'localhost';
$dbname = 'gestion_equipe';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}
?>

