<?php
require 'settings.php';
// si pagination faire un offset
if ($conn) {
    // Récupérer les produits
    try {
        $sql_products = "
                            SELECT products.*, brands.b_name 
                            FROM products 
                            JOIN brands ON products.p_fk_b_id = brands.b_id 
                            ORDER BY p_id ASC LIMIT 3
                        ";
        $stmt_products = $conn->query($sql_products);
        $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $products = [];
        $error = "Erreur lors de la récupération des produits: " . $e->getMessage();
    }

    // Récupérer les marques
    try {
        $sql_brands = "SELECT * FROM brands LIMIT 3";
        $stmt_brands = $conn->query($sql_brands);
        $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $brands = [];
        $error = "Erreur lors de la récupération des marques: " . $e->getMessage();
    }
} else {
    $products = [];
    $brands = [];
    $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php displayHeadSection('Accueil - CERA'); ?>
</head>
<body>
    <!-- Navigation -->
    <?php displayNav(); ?>
    <!-- banner -->
    <?php displayBannerIndex(); ?>

    <section>
        <h2 class="container-titre">Nouveautés</h2>
        <div class="container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                    // Déterminer la classe CSS en fonction de la catégorie du produit
                    $zoomClass = ($product['p_category'] == 'chaussures') ? 'zoom-shoes' : 'zoom';
                    $imgClass = ($product['p_category'] == 'chaussures') ? 'img-shoes' : 'img-produit';
                    ?>
                    <div data-aos="fade-right" data-aos-easing="ease-in-sine" data-aos-duration="1500" data-aos-delay="250">
                        <a href="produit.php?p_id=<?= urlencode($product['p_id']) ?>" class="<?= $zoomClass ?>">
                            <img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>" class="<?= $imgClass ?>" />
                        </a>
                        <a href="produit.php?p_id=<?= urlencode($product['p_id']) ?>" class="text-a">
                            <h3><?= htmlspecialchars($product['b_name']) ?> - <?= htmlspecialchars($product['p_name']) ?></h3>
                            <p><?= htmlspecialchars($product['p_price']) ?>€</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun produit disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <section>
        <h2 class="container-titre">Marques</h2>
        <div class="container-marque">
            <?php if (!empty($brands)): ?>
                <?php foreach ($brands as $brand): ?>
                    <a href="marques.php?b_id=<?= urlencode($brand['b_id']) ?>" class="text-a zoom" data-aos="fade-left" data-aos-easing="ease-in-sine" data-aos-duration="1500">
                        <img src="<?= htmlspecialchars($brand['b_image_backgroud']) ?>" alt="<?= htmlspecialchars($brand['b_name']) ?>" class="img-marque" />
                        <h3><?= htmlspecialchars($brand['b_name']) ?></h3>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune marque disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php displayNewsletter(); ?>

    <footer>
        <?php displayFooter(); ?>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="assets/js/script.js">
        AOS.init();
    </script>
</body>
</html>