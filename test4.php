<?php
require 'settings.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $sous_titre = $_POST['sous-titre'];
    $prix = $_POST['prix'];
    $description1 = $_POST['description1'];
    $description2 = $_POST['description2'];
    $description3 = $_POST['description3'];
    $categorie = $_POST['categorie'];
    $marque = $_POST['marque'];

    // Vérification et conversion de l'image en base64
    if (!empty($_FILES["fileToUpload"]["tmp_name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $error = "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $error = "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error = "Désolé, votre fichier n'a pas été téléchargé.";
        // If everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $imageBase64 = $target_file;
            } else {
                $error = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                $uploadOk = 0;
            }
        }
    } else {
        $error = "Aucune image fournie.";
        $uploadOk = 0;
    }

    if ($uploadOk !== 0) {
        if ($conn) {
            try {
                $sql = "INSERT INTO products (p_name, p_category, p_product_image_url, p_mini_description, p_description_1, p_description_2, p_description_3, p_price, p_fk_b_id)
                        VALUES (:p_name, :p_category, :p_product_image_url, :p_mini_description, :p_description_1, :p_description_2, :p_description_3, :p_price, :p_fk_b_id)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':p_name', $titre);
                $stmt->bindParam(':p_category', $categorie);
                $stmt->bindParam(':p_product_image_url', $imageBase64);
                $stmt->bindParam(':p_mini_description', $sous_titre);
                $stmt->bindParam(':p_description_1', $description1);
                $stmt->bindParam(':p_description_2', $description2);
                $stmt->bindParam(':p_description_3', $description3);
                $stmt->bindParam(':p_price', $prix);
                $stmt->bindParam(':p_fk_b_id', $marque);
                $stmt->execute();
                $message = "Produit ajouté avec succès";
            } catch (PDOException $e) {
                $error = "Erreur lors de l'ajout du produit: " . $e->getMessage();
            }
        } else {
            $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
        }
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

// Marques

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $link = $_POST['link'];

    // Vérification et upload de l'image de la marque
    $uploadOk = 1;
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
        $image_url = null;
        $uploadOk = 1;
    }

    // Vérification et upload de l'image de fond de la marque
    if (!empty($_FILES["background_image"]["name"])) {
        $target_file_background = $target_dir . basename($_FILES["background_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file_background, PATHINFO_EXTENSION));

        // Vérifiez si le fichier est une image réelle ou une fausse image
        $check = getimagesize($_FILES["background_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Vérifiez si le fichier existe déjà
        if (file_exists($target_file_background)) {
            $error = "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifiez la taille du fichier
        if ($_FILES["background_image"]["size"] > 500000) {
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
            if (move_uploaded_file($_FILES["background_image"]["tmp_name"], $target_file_background)) {
                $background_image_url = $target_file_background;
            } else {
                $error = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                $uploadOk = 0;
            }
        }
    } else {
        $background_image_url = null;
        $uploadOk = 1;
    }

    if ($uploadOk !== 0) {
        if ($conn) {
            try {
                $sql = "INSERT INTO brands (b_name, b_description, b_link, b_image_url, b_image_backgroud)
                        VALUES (:b_name, :b_description, :b_link, :b_image_url, :b_image_backgroud)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':b_name', $name);
                $stmt->bindParam(':b_description', $description);
                $stmt->bindParam(':b_link', $link);
                $stmt->bindParam(':b_image_url', $image_url);
                $stmt->bindParam(':b_image_backgroud', $background_image_url);
                $stmt->execute();
                $message = "Marque ajoutée avec succès";
            } catch (PDOException $e) {
                $error = "Erreur lors de l'ajout de la marque: " . $e->getMessage();
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
    <meta name="description" content="Page d'ajout de produit" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajouter un produit - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdn.tiny.cloud/1/glnv7b4e966wxrqluk57p7wfjjs5h8rnni8w2jcdg3up00rk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>  
</head>
<body>
<?php displayNavAdmin(); ?>


    <section>
        <h2 class="container-titrea autre">Ajouter les produits</h2>
        <div class="container">
            <div class="container-admin color-form">
            <form action="add.php" method="POST" enctype="multipart/form-data" class="form">
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

                    <label for="image">Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="previewImage(event)">
                    <img id="img-preview" src="" alt="Aperçu de l'image">
                    
                    <label for="prix">Prix (en €)</label>
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
        </div>
    </section>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            var file = event.target.files[0];
            reader.onload = function() {
                var imgElement = document.getElementById("img-preview");
                imgElement.src = reader.result;
                imgElement.style.display = "block";
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                var imgElement = document.getElementById("img-preview");
                imgElement.src = "";
                imgElement.style.display = "none";
            }
        }
    </script>
    <script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
</body> 
</html>