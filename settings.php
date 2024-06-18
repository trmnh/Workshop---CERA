<?php
<<<<<<< HEAD
// Constantes de l'application
const APP_NAME = "CERA";
const APP_VERSION = 'v1.0.0';
const APP_UPDATED = '23-05-2024 9:52';
const APP_AUTHOR = 'trmnh';

// Constante d'activation/désactivation du mode DEBUG
const DEBUG = false;

// Charge les credentials de connexion à la DB
require_once('conf/conf-db.php');

// Configuration de la session / du cookie de session
$name = session_name(str_replace(' ', '', APP_NAME).'_session');
$domain = $_SERVER['HTTP_HOST'];
$time = time() + 3600; // 3600 sec = 1 heure

setcookie($name, APP_NAME, [
    'expires' => $time,
    'path' => '/',
    'domain' => $domain,
    'secure' => false,
    'httponly' => true,
    'samesite' => 'strict',
]);

// Lancement de la session
session_start();

// Chargement des fichiers de fonctions
require_once('app/functions/fct-db.php');
require_once('app/functions/fct-ui.php');
require_once('app/functions/fct-tools.php');

// Instancier un objet de connexion
$conn = connectDB(SERVER_NAME, USER_NAME, USER_PWD, DB_NAME);
if (!$conn) {
    die('Database connection failed');
}

=======
    // Constantes de l'application
    const APP_NAME = "CERA";
    const APP_VERSION = 'v1.0.0';
    const APP_UPDATED = ' 23-05-2024 9:52';
    const APP_AUTHOR = 'trmnh';
       
    // Constante d'activation/désactivation du mode DEBUG
    const DEBUG = false;

    // Charge les credentials de connexion à la DB
    require_once('conf/conf-db.php');

    // Configuration de la session / du cookie de session
    $name = session_name(str_replace(' ', '', APP_NAME).'_session');
    $domain = $_SERVER['HTTP_HOST'];
    $time = time() + 3600; // 3600 sec = 1 heure

    setcookie($name, APP_NAME, [
        'expires' => $time,
        'path' => '/',
        'domain' => $domain,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'strict',
    ]);

    // Lancement de la session
    session_start();
>>>>>>> de63bc31fc047e70312b08a81679f24d297f2cd9
    
    // Initialisation de la variable $_SESSION['IDENTIFY'] à false (pas d'utilisateur connecté)
    if (!isset($_SESSION['IDENTIFY'])) {
        $_SESSION['IDENTIFY'] = false;
<<<<<<< HEAD
    }
=======
    }
   
    // Chargement des fichiers de fonctions
    require_once('app/functions/fct-db.php');
    require_once('app/functions/fct-ui.php');
    require_once('app/functions/fct-tools.php');

    // Instancier un objet de connexion
    $conn = connectDB(SERVER_NAME, USER_NAME, USER_PWD, DB_NAME);
>>>>>>> de63bc31fc047e70312b08a81679f24d297f2cd9
