<?php
require 'settings.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
  <?php displayHeadSection('À propos - CERA'); ?>
  </head>
  <body>
  <?php displayNav(); ?>

    <div class="banner-apropos">
      <div class="head-container">
        <h1>L'histoire de CERA</h1>
        <p>
          Une marketplace qui met en avant les marques indépendantes depuis
          2019.
        </p>
      </div>
    </div>

    <div class="container-marque desktop">
      <div class="box-marque" data-aos="fade-right" data-aos-duration="2500">
        <div class="left-box">
          <div class="box-content">
            <h3>Notre Histoire</h3>
            <p>
              Tout a commencé début 2019. Nous nous sommes aperçus que plein de
              petites marques émergeaient sur les réseaux sociaux, proposaient
              des produits de qualité, mais n’avaient pas beaucoup de
              visibilité.
            </p>
            <p>
              Face à ce postulat du manque de visibilité, une idée de créer une
              plateforme pour répertorier toutes ces marques a émergé.
            </p>
          </div>
        </div>
        <img src="assets/img/histoire2.webp" alt="" class="image-marque" />
      </div>

      <div class="box-marque" data-aos="fade-left" data-aos-duration="2500">
        <img src="assets/img/histoire3.webp" alt="" class="image-marque" />

        <div class="left-box">
          <div class="box-content">
            <h3>Notre Engagement</h3>

            <p>
              Il est important pour nous de proposer des produits de qualité en
              cohérence avec nos valeurs et ce que nous souhaitons vous
              transmettre et vous faire découvrir.
            </p>

            <p>
              Nous souhaitons être le plus transparent possible avec vous afin
              que vous ayez toutes les réponses à vos interrogations concernant
              les marques, leurs produits et leurs processus de production.
            </p>
          </div>
        </div>
      </div>

      <div class="box-marque" data-aos="fade-right" data-aos-duration="2500">
        <div class="left-box">
          <div class="box-content">
            <h3>Notre Mission</h3>
            <p>
              Tout a commencé début 2019. Nous nous sommes aperçus que plein de
              petites marques émergeaient sur les réseaux sociaux, proposaient
              des produits de qualité, mais n’avaient pas beaucoup de
              visibilité.
            </p>
            <p>
              Face à ce postulat du manque de visibilité, une idée de créer une
              plateforme pour répertorier toutes ces marques a émergé.
            </p>
          </div>
        </div>
        <img src="assets/img/histoire4.webp" alt="" class="image-marque" />
      </div>

      <div class="box-marque" data-aos="fade-left" data-aos-duration="2500">
        <img src="assets/img/histoire5.webp" alt="" class="image-marque" />

        <div class="left-box">
          <div class="box-content">
            <h3>Un Service Client Réactif</h3>

            <p>
              Une question sur la bonne taille à choisir, nos prochaines sorties
              ou une demande urgente sur un produit ?
            </p>
            <p>
              Contactez nous ici. Notre équipe est disponible pour répondre à
              toutes vos questions du lundi au vendredi de 9h à 19h et le samedi
              de 9h à 17h.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="container-marque mobile">
      <div class="box-marque" data-aos="fade-right" data-aos-duration="2500">
        <img src="assets/img/histoire2.webp" alt="" class="image-marque" />
        <div class="left-box">
          <div class="box-content">
            <h3>Notre Histoire</h3>
            <p>
              Tout a commencé début 2019. Nous nous sommes aperçus que plein de
              petites marques émergeaient sur les réseaux sociaux, proposaient
              des produits de qualité, mais n’avaient pas beaucoup de
              visibilité.
            </p>
            <p>
              Face à ce postulat du manque de visibilité, une idée de créer une
              plateforme pour répertorier toutes ces marques a émergé.
            </p>
          </div>
        </div>
      </div>

      <div class="box-marque" data-aos="fade-left" data-aos-duration="2500">
        <img src="assets/img/histoire3.webp" alt="" class="image-marque" />

        <div class="left-box">
          <div class="box-content">
            <h3>Notre Engagement</h3>

            <p>
              Il est important pour nous de proposer des produits de qualité en
              cohérence avec nos valeurs et ce que nous souhaitons vous
              transmettre et vous faire découvrir.
            </p>

            <p>
              Nous souhaitons être le plus transparent possible avec vous afin
              que vous ayez toutes les réponses à vos interrogations concernant
              les marques, leurs produits et leurs processus de production.
            </p>
          </div>
        </div>
      </div>

      <div class="box-marque" data-aos="fade-right" data-aos-duration="2500">
        <img src="assets/img/histoire4.webp" alt="" class="image-marque" />
        <div class="left-box">
          <div class="box-content">
            <h3>Notre Mission</h3>
            <p>
              Tout a commencé début 2019. Nous nous sommes aperçus que plein de
              petites marques émergeaient sur les réseaux sociaux, proposaient
              des produits de qualité, mais n’avaient pas beaucoup de
              visibilité.
            </p>
            <p>
              Face à ce postulat du manque de visibilité, une idée de créer une
              plateforme pour répertorier toutes ces marques a émergé.
            </p>
          </div>
        </div>
      </div>

      <div class="box-marque" data-aos="fade-left" data-aos-duration="2500">
        <img src="assets/img/histoire5.webp" alt="" class="image-marque" />

        <div class="left-box">
          <div class="box-content">
            <h3>Un Service Client Réactif</h3>

            <p>
              Une question sur la bonne taille à choisir, nos prochaines sorties
              ou une demande urgente sur un produit ?
            </p>
            <p>
              Contactez nous ici. Notre équipe est disponible pour répondre à
              toutes vos questions du lundi au vendredi de 9h à 19h et le samedi
              de 9h à 17h.
            </p>
          </div>
        </div>
      </div>
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
