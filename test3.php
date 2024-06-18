<?php
require 'settings.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $sous_titre = $_POST['sous-titre'];
    $status = isset($_POST['status']) ? 1 : 0;
    $prix = $_POST['prix'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $description3 = $_POST['description3'];
    $categorie = $_POST['categorie'];
    $marque = $_POST['marque'];
    $image_url = $_POST['image_url']; // New field for image URL

    if ($conn) {
        try {
            $sql = "INSERT INTO products (p_name, p_category, p_product_image_url, p_mini_description, p_description_1, p_description_2, p_description_3, p_price, p_fk_b_id, status)
                    VALUES (:p_name, :p_category, :p_product_image_url, :p_mini_description, :p_description_1, :p_description_2, :p_description_3, :p_price, :p_fk_b_id, :status)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':p_name', $titre);
            $stmt->bindParam(':p_category', $categorie);
            $stmt->bindParam(':p_product_image_url', $image_url); // Updated to bind the image URL
            $stmt->bindParam(':p_mini_description', $sous_titre); // Assuming this is the mini description
            $stmt->bindParam(':p_description_1', $description1);
            $stmt->bindParam(':p_description_2', $description2);
            $stmt->bindParam(':p_description_3', $description3);
            $stmt->bindParam(':p_price', $prix);
            $stmt->bindParam(':p_fk_b_id', $marque);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            $message = "Produit ajouté avec succès";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'ajout du produit: " . $e->getMessage();
        }
    } else {
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
}

// Récupérer les marques pour le formulaire
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
    <title>Ajouter un produit - CERA</title>
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
        <h2 class="container-titre autre">Ajouter les produits</h2>
        <div class="container">
            <?php if (isset($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php elseif (isset($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form action="add.php" method="POST" class="form">
                <div class="form-admin">

                    <label for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" required>
                        <option value="tshirt">T-shirt</option>
                        <option value="chaussures">Chaussures</option>
                    </select>

                    <label for="marque">Marque</label>
                    <select name="marque" id="marque" required>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['b_id'] ?>"><?= htmlspecialchars($brand['b_name']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="titre" required />

                    <label for="sous-titre">Sous-titre</label>
                    <input type="text" name="sous-titre" id="sous-titre" required />

                    <label for="image_url">Image URL</label>
                    <input type="text" name="image_url" id="image_url" required />

                    <label for="status">Status</label>
                    <input type="checkbox" name="status" id="status" />

                    <label for="prix">Prix</label>
                    <input type="number" name="prix" id="prix" required />

                    <label for="description1">Description 1</label>
                    <textarea name="description1" id="description1" required class="description"></textarea>

                    <label for="description2">Description 2</label>
                    <textarea name="description2" id="description2" required class="description"></textarea>

                    <label for="description3">Description 3</label>
                    <textarea name="description3" id="description3" required class="description"></textarea>

                    <button type="submit" class="button-decouvrir">Sauvegarder</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>