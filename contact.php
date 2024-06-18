<?php
require 'settings.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php displayHeadSection('Contact - CERA'); ?>
  </head>

  <body>
    <?php displayNav(); ?>

    <div class="banner-contact"></div>

    <section>
      <h2 class="container-titre">Contact</h2>
      <div class="container-contact">
        <div class="box-contact">
          <p>
            Nous sommes là pour vous aider ! Que vous ayez une question sur nos
            produits, besoin d'assistance avec une commande ou des suggestions à
            partager, n'hésitez pas à nous contacter.
          </p>
        </div>
      </div>
    </section>

    <section class="container-marque">
      <div class="box-marque">
        <div class="leftcontact-box">
          <div class="">
            <h3>Coordonnées</h3>
            <p>Nom de la Marque : CERA</p>
            <p>Adresse e-mail : contact@cera.com</p>
            <p>Téléphone : +33 (0)1 23 45 67 89</p>
          </div>
        </div>
        <div class="contact-box">
          <div class="">
            <h3>Adresse Postale</h3>
            <p>CERA 123 Rue des Créateurs</p>
            <p>75001 Paris</p>
            <p>France</p>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container-contact">
        <div class="box-contactbot">
          <p>
            N'hésitez pas à nous contacter à tout moment. Notre équipe est là
            pour vous aider et nous nous efforçons de fournir une expérience
            client exceptionnelle à tous nos clients.
          </p>
        </div>
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
