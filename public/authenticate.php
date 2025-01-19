<?php
session_start();

// Identifiants hachés
$correct_hashed_username = '777a025f5ca4a20f7bafee940f2820e28e1f4bbcbd9dd774bbce883166ef7c55'; 
$correct_hashed_password = '$2y$10$w7XxjAn1NC/uCFHKCfRTZeQ63iwBh67lvYpCaYb5vkqla6uXbyZ2C';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_username = hash('sha256', $username);

    // Vérifiez les identifiants
    if ($hashed_username === $correct_hashed_username && password_verify($password, $correct_hashed_password)) {
        // Authentification réussie
        $_SESSION['user_id'] = 1; 
        $_SESSION['username'] = $username;

        // Redirection vers la page principale
        header('Location: welcome.php');
        exit;
    } else {
        // Authentification échouée
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
