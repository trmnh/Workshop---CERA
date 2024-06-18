<?php
require 'settings.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

if (isset($_GET['b_id'])) {
    $b_id = intval($_GET['b_id']);
    
    if ($conn) {
        try {
            // Vérifier si la marque existe
            $sql_check = "SELECT * FROM brands WHERE b_id = :b_id";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':b_id', $b_id, PDO::PARAM_INT);
            $stmt_check->execute();
            $brand = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($brand) {
                // Supprimer les images associées
                if (file_exists($brand['b_image_url'])) {
                    unlink($brand['b_image_url']);
                }
                if (file_exists($brand['b_image_backgroud'])) {
                    unlink($brand['b_image_backgroud']);
                }

                // Supprimer la marque
                $sql_delete = "DELETE FROM brands WHERE b_id = :b_id";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bindParam(':b_id', $b_id, PDO::PARAM_INT);
                $stmt_delete->execute();

                $message = "Marque supprimée avec succès.";
                header("Location: admin.php");
                exit();
            } else {
                $error = "Erreur: La marque n'a pas été trouvée.";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la suppression de la marque: " . $e->getMessage();
        }
    } else {
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
} else {
    $error = "Erreur: Aucune marque spécifiée.";
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page de suppression de marque" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supprimer une marque - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
<?php displayNavAdmin(); ?>


    <section>
        <h2 class="container-titre autre">Supprimer une marque</h2>
        <div class="container">
            <?php if (isset($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php elseif (isset($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <a href="admin.php" class="button-decouvrir">Retour à la gestion des marques</a>
        </div>
    </section>
</body>
</html>