<?php
<<<<<<< HEAD
require 'settings.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}
if (isset($_GET['p_id'])) {
    $p_id = intval($_GET['p_id']);
    
    if ($conn) {
        try {
            // Vérifier si le produit existe et récupérer le chemin de l'image
            $sql_check = "SELECT * FROM products WHERE p_id = :p_id";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':p_id', $p_id, PDO::PARAM_INT);
            $stmt_check->execute();
            $product = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $image_path = $product['p_product_image_url'];

                // Supprimer le produit
                $sql_delete = "DELETE FROM products WHERE p_id = :p_id";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bindParam(':p_id', $p_id, PDO::PARAM_INT);
                $stmt_delete->execute();

                // Supprimer l'image du serveur
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                $_SESSION['message'] = "Marque supprimée avec succès.";
                header("Location: admin.php");
                exit();
            } else {
                $error = "Erreur: Le produit n'a pas été trouvé.";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la suppression du produit: " . $e->getMessage();
        }
    } else {
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
} else {
    $error = "Erreur: Aucun produit spécifié.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page de suppression de produit" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supprimer un produit - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
<?php displayNavAdmin(); ?>

    <section>
        <h2 class="container-titre autre">Supprimer un produit</h2>
        <div class="container">
            <?php if (isset($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php elseif (isset($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <a href="admin.php" class="button-decouvrir">Retour à la gestion des produits</a>
        </div>
    </section>
</body>
</html>
=======

>>>>>>> de63bc31fc047e70312b08a81679f24d297f2cd9
