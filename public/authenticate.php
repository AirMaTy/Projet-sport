<?php
session_start();

$correct_username = 'coach123';
$correct_password = 'mdpcoach';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['username'] = $username;

        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

if (isset($error)) {
    echo "<script>alert('$error'); window.location.href = 'login.php';</script>";
}
?>
