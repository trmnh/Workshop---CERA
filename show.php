<?php
require 'settings.php';
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

if (isset($_GET['p_id'])) {
    $p_id = intval($_GET['p_id']);
    
    // Récupérer les informations du produit à afficher
    if ($conn) {
        try {
            $sql_product = "SELECT products.*, brands.b_name FROM products JOIN brands ON products.p_fk_b_id = brands.b_id WHERE p_id = :p_id";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->bindParam(':p_id', $p_id, PDO::PARAM_INT);
            $stmt_product->execute();
            $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $product = null;
            $error = "Erreur lors de la récupération des données: " . $e->getMessage();
        }
    } else {
        $product = null;
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
} else {
    $product = null;
    $error = "Erreur: Aucun produit spécifié.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page d'affichage du produit" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Afficher un produit - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
<?php displayNavAdmin(); ?>


    <section>
        <h2 class="container-titre autre">Détails du produit</h2>
        <div class="container">
        <?php if ($product): ?>
        <section class="container-rectangle" id="rectangle">
            <div class="img-article">
                <img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>" class="<?= $product['p_category'] == 'chaussures' ? 'img-article-shoes' : 'img-article' ?>"/>
                <!-- Logo + nom de la marque -->
            </div>
            <div class="produit">
                
                <!-- Nom du produit + petite description + prix + select size -->
                <h2><?= htmlspecialchars($product['p_name']) ?></h2>
                <p><?= htmlspecialchars($product['p_mini_description']) ?></p>
                <h2 class="prix"><?= htmlspecialchars($product['p_price']) ?> €</h2>
                <label class="select">
                    <select name="Size">
                        <option value="" disabled selected hidden>Votre taille</option>
                        <?php if ($product['p_category'] == 'chaussures'): ?>
                            <?php for ($size = 36; $size <= 46; $size++): ?>
                                <option value="<?= $size ?>"><?= $size ?></option>
                            <?php endfor; ?>
                        <?php else: ?>
                            <option value="xs">XS</option>
                            <option value="s">S</option>
                            <option value="m">M</option>
                            <option value="l">L</option>
                            <option value="xl">XL</option>
                        <?php endif; ?>
                    </select>
                </label>     
                <div>
                    <button class="button-panier">Ajouter au panier</button>
                </div>
            </div>
        </section>

        <section class="container-description">
            <h2>Description du produit :</h2>
            <p><?= $product['p_description_1'] ?></p>
        </section>

        <section class="container-description">
            <h2>Livraison & retour :</h2>
            <p><?= $product['p_description_2'] ?></p>
        </section>

        <section class="container-description">
            <h2>Moyens de paiement :</h2>
            <p><?= $product['p_description_3'] ?></p>
        </section>
    <?php else: ?>
        <p>Erreur: Le produit demandé n'a pas pu être trouvé.</p>
        <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
    <?php endif; ?>
            
        </div>
        
    </section>
    <a href="admin.php" class="button-decouvrir">Retour à la gestion des produits</a>
</body>
</html>