<?php
require 'settings.php';
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

if (isset($_GET['p_id'])) {
    $p_id = intval($_GET['p_id']);
    
    // Récupérer les informations du produit à modifier
    if ($conn) {
        try {
            $sql_product = "SELECT * FROM products WHERE p_id = :p_id";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->bindParam(':p_id', $p_id, PDO::PARAM_INT);
            $stmt_product->execute();
            $product = $stmt_product->fetch(PDO::FETCH_ASSOC);

            // Récupérer les marques pour le formulaire
            $sql_brands = "SELECT * FROM brands";
            $stmt_brands = $conn->query($sql_brands);
            $brands = $stmt_brands->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $product = null;
            $brands = [];
            $error = "Erreur lors de la récupération des données: " . $e->getMessage();
        }
    } else {
        $product = null;
        $brands = [];
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
} else {
    $product = null;
    $brands = [];
    $error = "Erreur: Aucun produit spécifié.";
}

// Gérer la soumission du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['p_id'])) {
    $p_id = intval($_POST['p_id']);
    $titre = $_POST['titre'];
    $sous_titre = $_POST['sous-titre'];
    //$status = isset($_POST['status']) ? 1 : 0;
    $prix = $_POST['prix'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $description3 = $_POST['description3'];
    $categorie = $_POST['categorie'];
    $marque = $_POST['marque'];

    $uploadOk = 1; // Initialisation de la variable

    // Vérification et upload de l'image si une nouvelle image est fournie
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifiez si le fichier est une image réelle ou une fausse image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Vérifiez si le fichier existe déjà
        if (file_exists($target_file)) {
            $error = "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifiez la taille du fichier
        if ($_FILES["image"]["size"] > 500000) {
            $error = "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichiers
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérifiez si $uploadOk est défini sur 0 par une erreur
        if ($uploadOk == 0) {
            $error = "Désolé, votre fichier n'a pas été téléchargé.";
        // Si tout est ok, essayez de télécharger le fichier
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            } else {
                $error = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                $uploadOk = 0;
            }
        }
    } else {
        $image_url = $product['p_product_image_url']; // Utiliser l'ancienne URL si aucune nouvelle image n'est fournie
    }

    if ($uploadOk !== 0) {
        // Mettre à jour les informations du produit dans la base de données
        if ($conn) {
            try {
                $sql = "UPDATE products SET 
                            p_name = :p_name,
                            p_category = :p_category,
                            p_product_image_url = :p_product_image_url,
                            p_mini_description = :p_mini_description,
                            p_description_1 = :p_description_1,
                            p_description_2 = :p_description_2,
                            p_description_3 = :p_description_3,
                            p_price = :p_price,
                            p_fk_b_id = :p_fk_b_id
                        WHERE p_id = :p_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':p_name', $titre);
                $stmt->bindParam(':p_category', $categorie);
                $stmt->bindParam(':p_product_image_url', $image_url);
                $stmt->bindParam(':p_mini_description', $sous_titre);
                $stmt->bindParam(':p_description_1', $description1);
                $stmt->bindParam(':p_description_2', $description2);
                $stmt->bindParam(':p_description_3', $description3);
                $stmt->bindParam(':p_price', $prix);
                $stmt->bindParam(':p_fk_b_id', $marque);
                $stmt->bindParam(':p_id', $p_id, PDO::PARAM_INT);
                $stmt->execute();
                $message = "<p class=\"msg-success\">Produit mis à jour avec succès</p>";
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour du produit: " . $e->getMessage();
            }
        } else {
            $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Page de modification du produit" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modifier un produit - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdn.tiny.cloud/1/glnv7b4e966wxrqluk57p7wfjjs5h8rnni8w2jcdg3up00rk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
<?php displayNavAdmin(); ?>


    <section>
        <h2 class="container-titre autre">Modifier le produit</h2>
        <div class="container">
            <?php if (isset($message)): ?>
                <?= $message ?>
            <?php elseif (isset($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($product): ?>
                <form action="edit.php?p_id=<?= urlencode($product['p_id']) ?>" method="POST" enctype="multipart/form-data" class="form">
                    <div class="form-admin">
                        <input type="hidden" name="p_id" value="<?= $product['p_id'] ?>" />

                        <label for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie" required>
                            <option value="tshirt" <?= $product['p_category'] == 'tshirt' ? 'selected' : '' ?>>T-shirt</option>
                            <option value="chaussures" <?= $product['p_category'] == 'chaussures' ? 'selected' : '' ?>>Chaussures</option>
                        </select>

                        <label for="marque">Marque</label>
                        <select name="marque" id="marque" required>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand['b_id'] ?>" <?= $product['p_fk_b_id'] == $brand['b_id'] ? 'selected' : '' ?>><?= htmlspecialchars($brand['b_name']) ?></option>
                            <?php endforeach; ?>
                        </select                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="titre" value="<?= htmlspecialchars($product['p_name']) ?>" required />

                    <label for="sous-titre">Sous-titre</label>
                    <input type="text" name="sous-titre" id="sous-titre" value="<?= htmlspecialchars($product['p_mini_description']) ?>" required />

                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" />
                    <img id="img-preview" src="<?= htmlspecialchars($product['p_product_image_url']) ?>" alt="Aperçu de l'image" style="display: block;"/>

                   <!-- <label for="status">Status</label>
                    <input type="checkbox" name="status" id="status" <?= $product['status'] ? 'checked' : '' ?> /> -->

                    <label for="prix">Prix</label>
                    <input type="number" name="prix" id="prix" value="<?= htmlspecialchars($product['p_price']) ?>" required />

                    <label for="description1">Description 1</label>
                    <textarea name="description1" id="description1" required class="description"><?= htmlspecialchars($product['p_description_1']) ?></textarea>

                    <label for="description2">Description 2</label>
                    <textarea name="description2" id="description2" required class="description"><?= htmlspecialchars($product['p_description_2']) ?></textarea>

                    <label for="description3">Description 3</label>
                    <textarea name="description3" id="description3" required class="description"><?= htmlspecialchars($product['p_description_3']) ?></textarea>

                    <button type="submit" class="button-decouvrir">Sauvegarder</button>
                    <!-- bouton annuler-->
                    <a href="admin.php" class="button-decouvrir">Annuler</a>
                </div>
            </form>
        <?php else: ?>
            <p>Erreur: Le produit demandé n'a pas pu être trouvé.</p>
            <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
        <?php endif; ?>
    </div>
</section>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
</body>
</html>
