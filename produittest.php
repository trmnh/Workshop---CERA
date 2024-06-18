<?php
require 'settings.php';

// Récupérer toutes les marques pour le menu déroulant
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

// Vérifier si une marque et/ou une catégorie est sélectionnée pour le filtrage
$brand_filter = isset($_GET['brand_id']) ? intval($_GET['brand_id']) : null;
$category_filter = isset($_GET['category']) ? $_GET['category'] : null;

// Récupérer tous les produits (ou filtrés par marque et/ou catégorie)
if ($conn) {
    try {
        $sql_products = "SELECT products.*, brands.b_name FROM products JOIN brands ON products.p_fk_b_id = brands.b_id";
        $params = [];

        if ($brand_filter) {
            $sql_products .= " WHERE brands.b_id = :brand_id";
            $params[':brand_id'] = $brand_filter;
        }

        if ($category_filter) {
            if ($brand_filter) {
                $sql_products .= " AND products.p_category = :category";
            } else {
                $sql_products .= " WHERE products.p_category = :category";
            }
            $params[':category'] = $category_filter;
        }

        $stmt_products = $conn->prepare($sql_products);
        foreach ($params as $key => &$val) {
            $stmt_products->bindParam($key, $val);
        }

        $stmt_products->execute();
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
    <meta charset="UTF-8" />
    <meta name="description" content="Page des produits" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nos Produits - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo">CERA</a>

        <input type="checkbox" id="check" />
        <label for="check" class="icons">
            <i class="bx bx-menu" id="menu-icon"></i>
            <i class="bx bx-x" id="close-icon"></i>
        </label>

        <nav class="navbar" id="nav">
            <a href="allProduits.php" style="--i: 0">Produits</a>
            <a href="index.php" style="--i: 1">Accueil</a>
        </nav>
    </header>

    <section>
        <h2 class="container-titre autre">Tous nos produits</h2>
        <div class="container">
            <form method="GET" action="allProduits.php">
                <label for="brand">Filtrer par marque:</label>
                <select name="brand_id" id="brand" onchange="this.form.submit()">
                    <option value="">Toutes les marques</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['b_id'] ?>" <?= $brand_filter == $brand['b_id'] ? 'selected' : '' ?>><?= htmlspecialchars($brand['b_name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="category">Filtrer par catégorie:</label>
                <select name="category" id="category" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    <option value="tshirt" <?= $category_filter == 'tshirt' ? 'selected' : '' ?>>T-shirt</option>
                    <option value="chaussures" <?= $category_filter == 'chaussures' ? 'selected' : '' ?>>Chaussures</option>
                </select>
            </form>

            <?php if (!empty($products)): ?>
                <div class="grid container-produit">
                    <?php foreach ($products as $product): ?>
                        <div class="element-item <?= htmlspecialchars($product['p_category']) ?>">
                            <a href="produit.php?p_id=<?= urlencode($product['p_id']) ?>" class="text-a zoom">
                                <img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>" class="img-produit" />
                                <h3><?= htmlspecialchars($product['b_name']) ?> <?= htmlspecialchars($product['p_name']) ?></h3>
                                <p><?= htmlspecialchars($product['p_price']) ?>€</p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun produit disponible pour le moment.</p>
                <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>