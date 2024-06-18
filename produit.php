<?php
require 'settings.php';

if (isset($_GET['p_id'])) {
    $p_id = intval($_GET['p_id']);
    
    if ($conn) {
        // Récupérer les informations du produit avec le nom de la marque
        try {
            $sql_product = "SELECT products.*, brands.b_name, brands.b_image_url 
                            FROM products 
                            JOIN brands ON products.p_fk_b_id = brands.b_id 
                            WHERE products.p_id = :p_id";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->bindParam(':p_id', $p_id, PDO::PARAM_INT);
            $stmt_product->execute();
            $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $product = null;
            $error = "Erreur lors de la récupération du produit: " . $e->getMessage();
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
    <?php displayHeadSection($product['p_name'] . ' - CERA'); ?>
    <link rel="stylesheet" href="assets/css/select.css">
    <script src="https://cdn.tiny.cloud/1/glnv7b4e966wxrqluk57p7wfjjs5h8rnni8w2jcdg3up00rk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <?php displayNav(); ?>

    <?php if ($product): ?>
        <section class="container-rectangle" id="rectangle">
            <div class="img-article">
                <img src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>" class="<?= $product['p_category'] == 'chaussures' ? 'img-article-shoes' : 'img-article' ?>"/>
                <!-- Logo + nom de la marque -->
            </div>
            <div class="produit">
                <div class="section-logo">
                    <h2>
                        <img src="<?= htmlspecialchars($product['b_image_url']) ?>" class="logo-marque" alt="">
                        <?= htmlspecialchars($product['b_name']) ?>
                    </h2>
                </div>
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

    <?php displayNewsletter(); ?>

    <footer>
        <?php displayFooter(); ?>
    </footer>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="assets/js/script.js">
        AOS.init();
    </script>
    <script src="assets/js/select.js"></script>
    <script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
</body>
</html>