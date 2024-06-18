<?php
require 'settings.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirection vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['IDENTIFY']) || !$_SESSION['IDENTIFY']) {
    header('Location: login.php');
    exit();
}


// Récupérer tous les produits
if ($conn) {
    try {
        $sql_products = "SELECT products.*, brands.b_name FROM products JOIN brands ON products.p_fk_b_id = brands.b_id";
        $stmt_products = $conn->query($sql_products);
        $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $products = [];
        $error = "Erreur lors de la récupération des produits: " . $e->getMessage();
    }
} else {
    $products = [];
    $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
}

// Marques

if ($conn) {
    try {
        $sql_brands = "SELECT * FROM brands";
        $stmt_brands = $conn->query($sql_brands);
        $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $brands = [];
        $error = "Erreur lors de la récupération des marques: " . $e->getMessage();
    }
} else {
    $brands = [];
    $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page d'Accueil" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <?php displayNavAdmin(); ?>

    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'produits')">Gérer les produits</button>
        <button class="tablinks" onclick="openTab(event, 'marques')">Gérer les marques</button>
    </div>

    <div id="produits" class="tabcontent">
        <h2 class="titre-admin">Gérer les produits</h2>
        
            <?php if (isset($_SESSION['message'])) {
            echo "<div class=\"msg-success\">";
            echo "<p>{$_SESSION['message']}</p>";
            echo "</div>";
            // Supprimer le message de la session après l'affichage
            unset($_SESSION['message']);
        }?>
        
        <div class="box-admin">
            <div class="container-admin">
                <?php if (!empty($products)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nom du produit</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="Image de <?= htmlspecialchars($product['p_name']) ?>"></td>
                                    <td><a href="edit.php?p_id=<?= urlencode($product['p_id']) ?>" class="anom"><?= htmlspecialchars($product['b_name']) ?> <?= htmlspecialchars($product['p_name']) ?></a></td>
                                    <td><?= htmlspecialchars($product['p_category']) ?></td>
                                    <td>
                                        <a href="edit.php?p_id=<?= urlencode($product['p_id']) ?>" class="button-decouvrir button-modifier">Modifier</a>
                                        <a href="show.php?p_id=<?= urlencode($product['p_id']) ?>" class="button-decouvrir button-afficher">Afficher</a>
                                        <a href="delete.php?p_id=<?= urlencode($product['p_id']) ?>" class="button-decouvrir button-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun produit disponible pour le moment.</p>
                    <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="marques" class="tabcontent">
        <h2 class="titre-admin">Gérer les marques</h2>
        <div class="box-admin">
            <div class="container-admin">
                <?php if (!empty($brands)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nom de la marque</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td><img src="<?= htmlspecialchars($brand['b_image_url']) ?>" alt="Image de <?= htmlspecialchars($brand['b_name']) ?>" class="img-logo"></td>
                                    <td><a href="edit_brand.php?b_id=<?= urlencode($brand['b_id']) ?>" class="anom"><?= htmlspecialchars($brand['b_name']) ?></a></td>
                                    <td>
                                        <a href="edit_brand.php?b_id=<?= urlencode($brand['b_id']) ?>" class="button-decouvrir button-modifier">Modifier</a>
                                        <a href="show_brand.php?b_id=<?= urlencode($brand['b_id']) ?>" class="button-decouvrir button-afficher">Afficher</a>
                                        <a href="delete_brand.php?b_id=<?= urlencode($brand['b_id']) ?>" class="button-decouvrir button-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette marque ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune marque disponible pour le moment.</p>
                    <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    // Open the default tab
    document.querySelector('.tablinks').click();
    </script>
</body>
</html>