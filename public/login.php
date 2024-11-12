<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>

<div class="login-container">
    <h2>Connexion Entraîneur</h2>
    
    <form action="authenticate.php" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        
        <button type="submit">Se connecter</button>
    </form>
    
    <div class="forgot-password">
        <a href="#">Mot de passe oublié ?</a>
    </div>
</div>

</body>
</html>
