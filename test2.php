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
    <meta charset="UTF-8" />
    <meta name="description" content="Page d'Accueil" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <header class="header">
        <a href="admin.php" class="logo">CERA</a>

        <input type="checkbox" id="check" />
        <label for="check" class="icons">
            <i class="bx bx-menu" id="menu-icon"></i>
            <i class="bx bx-x" id="close-icon"></i>
        </label>

        <nav class="navbar" id="nav">
            <a href="add.php" style="--i: 0">Ajouter</a>
            <a href="index.php" style="--i: 1">Déconnexion</a>
        </nav>
    </header>

    <section>
        <h2 class="container-titre autre">Gérer les produits</h2>
        <div class="box-admin">
            <div class="container-admin">
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
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="description_image"></td>
                                    <td><a href="edit.php?p_id=<?= urlencode($product['p_id']) ?>" class="anom"><?= htmlspecialchars($product['p_name']) ?></a></td>
                                    <td><?= htmlspecialchars($product['p_category']) ?></td>
                                    <td>
                                        <a href="edit.php?p_id=<?= urlencode($product['p_id']) ?>" class="button-decouvrir button-modifier">Modifier</a>
                                        <a href="view.php?p_id=<?= urlencode($product['p_id']) ?>" class="button-decouvrir button-afficher">Afficher</a>
                                        <a href="delete.php?p_id=<?= urlencode($product['p_id']) ?>" class="button-decouvrir button-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">Aucun produit disponible pour le moment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>