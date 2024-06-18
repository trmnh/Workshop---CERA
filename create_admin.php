<?php 
require 'settings.php';

$username = 'adm'; // Nom d'utilisateur
$password = password_hash('password', PASSWORD_DEFAULT); // Mot de passe haché

if ($conn) {
    try {
        $sql = "INSERT INTO admin_users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        echo "Admin user created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}