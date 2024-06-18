<?php
require 'settings.php';

// Récupérer toutes les marques
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
    <?php displayHeadSection('Toutes nos marques - CERA'); ?>
</head>
<body>
    <?php displayNav(); ?>

    <h2 class="container-titre autre">Toutes nos marques</h2>

    <div class="container-marque desktop">
        <?php if (!empty($brands)): ?>
            <?php foreach ($brands as $index => $brand): ?>
                <?php if ($index % 2 == 0): ?>
                    <div class="box-marque" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine" data-aos-duration="2500">
                        <div class="left-box">
                            <div class="box-content">
                                <h3><?= htmlspecialchars($brand['b_name']) ?></h3>
                                <p><?= $brand['b_description'] ?></p>
                                <div class="btn-holder">
                                    <a href="<?= htmlspecialchars($brand['b_link']) ?>" target="_blank" class="btn btn-1 hover-filled-slide-right">
                                        <span>Découvrir</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <img src="<?= htmlspecialchars($brand['b_image_backgroud']) ?>" alt="<?= htmlspecialchars($brand['b_name']) ?>" class="image-marque" />
                    </div>
                <?php else: ?>
                    <div class="box-marque" data-aos="fade-left" data-aos-offset="300" data-aos-easing="ease-in-sine" data-aos-duration="2500">
                        <img src="<?= htmlspecialchars($brand['b_image_backgroud']) ?>" alt="<?= htmlspecialchars($brand['b_name']) ?>" class="image-marque" />
                        <div class="left-box">
                            <div class="box-content">
                                <h3><?= htmlspecialchars($brand['b_name']) ?></h3>
                                <p><?= $brand['b_description'] ?></p>
                                <div class="btn-holder">
                                    <a href="<?= htmlspecialchars($brand['b_link']) ?>" target="_blank" class="btn btn-2 hover-slide-right">
                                        <span>Découvrir</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune marque disponible pour le moment.</p>
            <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
        <?php endif; ?>
    </div>

    <div class="container-marque mobile">
        <?php if (!empty($brands)): ?>
            <?php foreach ($brands as $index => $brand): ?>
                <div class="box-marque" data-aos="fade-<?= $index % 2 == 0 ? 'right' : 'left' ?>" data-aos-offset="300" data-aos-easing="ease-in-sine" data-aos-duration="2500">
                    <img src="<?= htmlspecialchars($brand['b_image_backgroud']) ?>" alt="<?= htmlspecialchars($brand['b_name']) ?>" class="image-marque" />
                    <div class="left-box">
                        <div class="box-content">
                            <h3><?= htmlspecialchars($brand['b_name']) ?></h3>
                            <p><?= $brand['b_description'] ?></p>
                            <div class="btn-holder">
                                <a href="<?= htmlspecialchars($brand['b_link']) ?>" target="_blank" class="btn btn-<?= $index % 2 == 0 ? '1 hover-filled-slide-right' : '2 hover-slide-right' ?>">
                                    <span>Découvrir</span>
                                </a> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune marque disponible pour le moment.</p>
            <?php if (isset($error)) echo '<p>' . htmlspecialchars($error) . '</p>'; ?>
        <?php endif; ?>
    </div>

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