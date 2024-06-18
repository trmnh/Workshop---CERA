<?php
/* ********************************************************************** */
/* *                           DB FUNCTIONS                             * */
/* *                           ------------                             * */
/* *    FONCTIONS RELATIVES AUX INTERACTIONS AVEC LA BASE DE DONNEES    * */
/* ********************************************************************** */

 /**
 * Connexion à la base de données
 * 
 * @param string $serverName
 * @param string $userName
 * @param string $userPwd
 * @param string $dbName
 * 
 * @return object $conn
 */
 function connectDB($serverName, $userName, $userPwd, $dbName) {
    try {
        // Création d'une connexion à la base de données
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $userName, $userPwd);

        // Définition du mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error : Database connexion";            
        return $st; 
    }
}


function userIdentificationWithHashPwdDB($conn, $datas) {
    try {
        $user = null;
        $isConnected = false;

        $login = filterInputs($datas['login']);
        $pwd = filterInputs($datas['pwd']);

        $req = $conn->prepare("SELECT * FROM users WHERE email = :login");
        $req->bindParam(':login', $login);
        $req->execute();

        $user = $req->fetch(PDO::FETCH_ASSOC);

        if (!empty($user['email'])) {
            $isConnected = password_verify($pwd, $user['passwd']);
        }

        $req = null;
        $conn = null;

        if ($isConnected) {
            $user['passwd'] = null;
            return $user;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        return 'Error : ' . $e->getMessage();
    }
}

function userIdentificationDB($conn, $datas) {
    try{
        $user = null;

        // Préparation des données avant insertion dans la base de données
        $login = filterInputs($datas['login']);
        $pwd = filterInputs($datas['pwd']);

        // Sélection des données dans la table users
        $req = $conn->prepare("SELECT * FROM users WHERE email = :login AND passwd = :pwd");
        $req->bindParam(':login', $login);
        $req->bindParam(':pwd', $pwd);
        $req->execute();

        // Génère un résultat si il y a correspondance
        $user = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        if((isset($user['email']) && $user['email'] === $login) && (isset($user['passwd']) && $user['passwd'] === $pwd)){
            // On supprime le mot de passe de l'objet $user
            $user['passwd'] = null; 
            return $user;
        }else
            return false;
        

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : userIdentificationDB() function";            
        return $st;      
    }       
}