<?php
require 'settings.php';
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

if (isset($_GET['b_id'])) {
    $b_id = intval($_GET['b_id']);
    
    if ($conn) {
        try {
            // Récupérer les informations de la marque
            $sql_brand = "SELECT * FROM brands WHERE b_id = :b_id";
            $stmt_brand = $conn->prepare($sql_brand);
            $stmt_brand->bindParam(':b_id', $b_id, PDO::PARAM_INT);
            $stmt_brand->execute();
            $brand = $stmt_brand->fetch(PDO::FETCH_ASSOC);

            if (!$brand) {
                $error = "Erreur: La marque n'a pas été trouvée.";
            }
        } catch (PDOException $e) {
            $brand = null;
            $error = "Erreur lors de la récupération de la marque: " . $e->getMessage();
        }
    } else {
        $brand = null;
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
} else {
    $brand = null;
    $error = "Erreur: Aucune marque spécifiée.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page de détail de la marque" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Détails de la marque - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
<?php displayNavAdmin(); ?>


    <section>
        <h2 class="container-titre autre">Détails de la marque</h2>
        <div class="container">
            <?php if ($brand): ?>
                <div class="box-marque">
                        <div class="left-box">
                            <div class="box-content">
                            
                                <h2 class="section-logo">
                                    <img src="<?= htmlspecialchars($brand['b_image_url']) ?>" alt="Image de <?= htmlspecialchars($brand['b_name']) ?>" class="logo-marque" />
                                    <?= htmlspecialchars($brand['b_name']) ?>
                                </h2>
                                <p><?= $brand['b_description'] ?></p>
                                <div class="btn-holder">
                                    <a href="<?= htmlspecialchars($brand['b_link']) ?>" target="_blank" class="btn btn-1 hover-filled-slide-right">
                                        <span>Découvrir</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <img src="<?= htmlspecialchars($brand['b_image_backgroud']) ?>" alt="<?= htmlspecialchars($brand['b_name']) ?>" class="image-marque" />
                    </div>
            <?php else: ?>
                <p>Erreur: La marque demandée n'a pas pu être trouvée.</p>
                <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
            <?php endif; ?>
            
        </div>
        <a href="admin.php">Retour à la gestion des marques</a>
    </section>
</body>
</html>