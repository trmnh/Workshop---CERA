<?php
require 'settings.php';

// Lancement de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirection vers la page de gestion si l'utilisateur est connecté
if (isset($_SESSION['IDENTIFY']) && $_SESSION['IDENTIFY']) {
    header('Location: admin.php');
    exit();
}

$user = null;
$connexionSuccessfull = null;
$msg = null;

// On vérifie l'objet de connexion $conn
if (!is_object($conn)) {
    $msg = getMessage($conn, 'error');
} else {
    // Vérifie si on reçoit le formulaire d'identification
    if (isset($_POST['form']) && $_POST['form'] == 'login') {
        // Vérifie si les champs sont vides
        if (empty($_POST['login']) || empty($_POST['pwd'])) {
            $msg = getMessage('Veuillez remplir tous les champs', 'error');
        } else {
            // On récupère les données du formulaire
            $login = filterInputs($_POST['login']);
            $pwd = filterInputs($_POST['pwd']);

            try {
                // Sélection des données dans la table admin_users
                $sql = "SELECT * FROM admin_users WHERE username = :username";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $login);
                $stmt->execute();

                // Génère un résultat si il y a correspondance
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($pwd, $user['password'])) {
                    // On supprime le mot de passe de l'objet $user
                    $user['password'] = null;
                    $_SESSION['IDENTIFY'] = true;
                    $_SESSION['user_email'] = $user['username'];
                    header('Location: admin.php');
                    exit();
                } else {
                    $msg = getMessage('Votre email et/ou votre mot de passe sont erronés', 'error');
                }
            } catch (PDOException $e) {
                $msg = getMessage('Erreur lors de la connexion: ' . $e->getMessage(), 'error');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page de Connexion" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion Admin - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo">CERA</a>
    </header>

    <section>
        <?php if (isset($msg)): ?>
                <div class="msg-pos"><?= $msg ?></div>
            <?php endif; ?> 
        <div class="container log"> 
            
            <div class="container-admin conex">
              
                <h2>Connexion admin</h2>
            <form action="login.php" method="POST" class="form">
                <input type="hidden" name="form" value="login">
                <div class="form-admin">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="login" id="username" required autocomplete="off" value="" />

                    <label for="password">Mot de passe</label>
                    <input type="password" name="pwd" id="password" required autocomplete="off" value="" />

                    <button type="submit" class="button-decouvrir">Connexion</button>
                </div>
            </form>
            </div>
           
        </div>
    </section>
</body>
</html>