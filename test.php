<?php








?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php displayHeadSection('Accueil - CERA'); ?>
  </head>
  <body>
    <!-- Navigation -->
    <?php displayNav(); ?>
    <!-- banner -->
    <?php displayBannerIndex(); ?>

      <h2 class="container-titre">Nouveautés</h2>

      <div class="container">
        <div
          data-aos="fade-right"
          data-aos-easing="ease-in-sine"
          data-aos-duration="1500"
          data-aos-delay="250"
        >
          <a href="produit.html" class="zoom">
            <img
              src="assets/img/uniqlo-t-shirt.webp"
              alt="T-Shirt Uniqlo KAWS Pink Graphic"
              class="img-produit"
            />
          </a>
          <a href="produit.html" class="text-a">
            <h3>Uniqlo T-Shirt KAWS Pink Graphic</h3>
            <p>65€</p>
          </a>
        </div>

        <div
          data-aos="fade-right"
          data-aos-easing="ease-in-sine"
          data-aos-duration="1500"
          data-aos-delay="125"
        >
          <a href="produit.html" class="zoom-shoes">
            <img src="assets/img/dunk.webp" alt="Nike Dunk" class="img-shoes" />
          </a>
          <a href="produit.html" class="text-a">
            <h3>Nike Dunk Low Black White</h3>
            <p>110€</p>
          </a>
        </div>

        <div
          data-aos="fade-right"
          data-aos-easing="ease-in-sine"
          data-aos-duration="1500"
        >
          <a href="produit.html" class="zoom-shoes">
            <img
              src="assets/img/adidas-campus-00s-grey-white-3.webp"
              alt="Adidas Campus Grey"
              class="img-shoes"
            />
          </a>
          <a href="produit.html" class="text-a">
            <h3>Adidas Campus 00s Grey White</h3>
            <p>120€</p>
          </a>
        </div>
      </div>
    </section>

    <section>
      <h2 class="container-titre">Marques</h2>
      <div class="container-marque">
        <a
          href="produit.html"
          class="text-a zoom"
          data-aos="fade-left"
          data-aos-easing="ease-in-sine"
          data-aos-duration="1500"
        >
          <img
            src="assets/img/ADIDAS carre.png"
            alt="Adidas"
            class="img-marque"
          />
          <h3>ADIDAS</h3>
        </a>

        <a
          href="produit.html"
          class="text-a zoom"
          data-aos="fade-left"
          data-aos-easing="ease-in-sine"
          data-aos-duration="2500"
          data-aos-delay="125"
          ><img
            src="assets/img/marque nike.png"
            alt="Nike"
            class="img-marque"
          />
          <h3>NIKE</h3>
        </a>

        <a
          href="produit.html"
          class="text-a zoom"
          data-aos="fade-left"
          data-aos-easing="ease-in-sine"
          data-aos-duration="2500"
          data-aos-delay="250"
          ><img
            src="assets/img/Marque New Balance.png"
            alt="New Balance"
            class="img-marque"
          />
          <h3>NEW BALANCE</h3>
        </a>
      </div>
    </section>

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
