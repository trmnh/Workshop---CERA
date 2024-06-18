<?php
require 'settings.php';

if ($conn) {
    // Récupérer tous les produits avec le nom de la marque
    try {
        $sql_products = "SELECT products.*, brands.b_name 
                         FROM products 
                         JOIN brands ON products.p_fk_b_id = brands.b_id 
                         ORDER BY p_id ASC";
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php displayHeadSection('Produits - CERA'); ?>
</head>
<body>
    <?php displayNav(); ?>

    <h2 class="container-titre autre">Tous nos produits</h2>

    

    <div class="button-group filters-button-group container-filter">
        <button data-filter="*">All</button>
        <button data-filter=".t-shirt">T-Shirt</button>
        <button data-filter=".shoes">Chaussures</button>
    </div>

    <div class="grid container-produit">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <?php
                // Déterminer la classe CSS en fonction de la catégorie du produit
                $categoryClass = ($product['p_category'] == 'chaussures') ? 'shoes' : 't-shirt';
                $zoomClass = ($product['p_category'] == 'chaussures') ? 'zoom-shoes' : 'zoom';
                $imgClass = ($product['p_category'] == 'chaussures') ? 'img-shoes' : 'img-produit';
                ?>
                <div class="element-item <?= $categoryClass ?>">
                    <a href="produit.php?p_id=<?= urlencode($product['p_id']) ?>" class="text-a <?= $zoomClass ?>">
                        <img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>" class="<?= $imgClass ?>" />
                        <h3><?= htmlspecialchars($product['b_name']) ?> - <?= htmlspecialchars($product['p_name']) ?></h3>
                        <p><?= htmlspecialchars($product['p_price']) ?>€</p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit disponible pour le moment.</p>
        <?php endif; ?>
    </div>
    
    <section>
      <?php displayNewsletter(); ?>
    </section>
    

    <footer>
        <?php displayFooter(); ?>
    </footer>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script>
        // external js: isotope.pkgd.js

        // init Isotope
        var iso = new Isotope(".grid", {
            itemSelector: ".element-item",
            layoutMode: "fitRows",
        });

        // bind filter button click
        var filtersElem = document.querySelector(".filters-button-group");
        filtersElem.addEventListener("click", function (event) {
            // only work with buttons
            if (!matchesSelector(event.target, "button")) {
                return;
            }
            var filterValue = event.target.getAttribute("data-filter");
            iso.arrange({ filter: filterValue });
        });
    </script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="assets/js/script.js">
        AOS.init();
    </script>
</body>
</html>