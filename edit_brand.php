<?php
require 'settings.php';
// Redirection vers la page de login si l'utilisateur n'est pas connecté
if (!$_SESSION['IDENTIFY']) {
    header('Location: login.php');
}

if (isset($_GET['b_id'])) {
    $b_id = intval($_GET['b_id']);
    
    // Récupérer les informations de la marque à modifier
    if ($conn) {
        try {
            $sql_brand = "SELECT * FROM brands WHERE b_id = :b_id";
            $stmt_brand = $conn->prepare($sql_brand);
            $stmt_brand->bindParam(':b_id', $b_id, PDO::PARAM_INT);
            $stmt_brand->execute();
            $brand = $stmt_brand->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $brand = null;
            $error = "Erreur lors de la récupération des données: " . $e->getMessage();
        }
    } else {
        $brand = null;
        $error = "Erreur: La connexion à la base de données n'a pas pu être établie.";
    }
} else {
    $brand = null;
    $error = "Erreur: Aucune marque spécifiée.";
}

// Gérer la soumission du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['b_id'])) {
    $b_id = intval($_POST['b_id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $link = $_POST['link'];

    // Vérification et upload de l'image si une nouvelle image est fournie
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
        $image_url = $brand['b_image_url']; // Utiliser l'ancienne URL si aucune nouvelle image n'est fournie
    }

    // Vérification et upload de l'image de fond si une nouvelle image est fournie
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
        $background_image_url = $brand['b_image_backgroud']; // Utiliser l'ancienne URL si aucune nouvelle image n'est fournie
    }

    if ($uploadOk !== 0) {
        // Mettre à jour les informations de la marque dans la base de données
        if ($conn) {
            try {
                $sql = "UPDATE brands SET 
                            b_name = :b_name,
                            b_description = :b_description,
                            b_link = :b_link,
                            b_image_url = :b_image_url,
                            b_image_backgroud = :b_image_backgroud
                        WHERE b_id = :b_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':b_name', $name);
                $stmt->bindParam(':b_description', $description);
                $stmt->bindParam(':b_link', $link);
                $stmt->bindParam(':b_image_url', $image_url);
                $stmt->bindParam(':b_image_backgroud', $background_image_url);
                $stmt->bindParam(':b_id', $b_id, PDO::PARAM_INT);
                $stmt->execute();
                $message = "Marque mise à jour avec succès";
            } catch (PDOException $e) {
                $error = "Erreur lors de la mise à jour de la marque: " . $e->getMessage();
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
    <meta name="description" content="Page de modification de la marque" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modifier une marque - CERA</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://cdn.tiny.cloud/1/glnv7b4e966wxrqluk57p7wfjjs5h8rnni8w2jcdg3up00rk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>  
</head>
<body>
<?php displayNavAdmin(); ?>
    

    <section>
        <h2 class="container-titre autre">Modifier la marque</h2>
        <div class="container">
            <?php if (isset($message)): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php elseif (isset($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if ($brand): ?>
                <form action="edit_brand.php?b_id=<?= urlencode($brand['b_id']) ?>" method="POST" enctype="multipart/form-data" class="form">
                    <div class="form-admin">
                        <input type="hidden" name="b_id" value="<?= $brand['b_id'] ?>" />

                        <label for="name">Nom de la marque</label>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($brand['b_name']) ?>" required />

                        <label for="description">Description</label>
                        <textarea name="description" id="description" required class="description"><?= $brand['b_description'] ?></textarea>

                        <label for="link">Lien</label>
                        <input type="url" name="link" id="link" value="<?= htmlspecialchars($brand['b_link']) ?>" required />

                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" />
                        <img id="img-preview" src="<?= htmlspecialchars($brand['b_image_url']) ?>" alt="Aperçu de l'image" style="display: block;"/>

                        <label for="background_image">Image de fond</label>
                        <input type="file" name="background_image" id="background_image" />
                        <img id="img-preview" src="<?= htmlspecialchars($brand['b_image_backgroud']) ?>" alt="Aperçu de l'image de fond" style="display: block;"/>

                        <button type="submit" class="button-decouvrir">Sauvegarder</button>
                    </div>
                </form>
            <?php else: ?>
                <p>Erreur: La marque demandée n'a pas pu être trouvée.</p>
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