<?php
/* ********************************************************************** */
/* *                          TOOLS FUNCTIONS                           * */
/* *                          ---------------                           * */
/* *        FONCTIONS D'AFFICHAGE DE L'INTERFACE UTILISATEUR            * */
/* ********************************************************************** */

/**
* Retourne le code html des boutons radios indiquant 
* le status de publication de l'article
* 
* @param boolean     $published
* @param string      $typeForm  (ADD ou EDIT)
* @return string
*/


/**
 * Affichage de la section head d'une page
 * 
 * @param string $title 
 * @return void 
 */
function displayHeadSection($title = APP_NAME){

    $head = '
    <meta charset="UTF-8">
    <meta name="description" content="Page d\'Accueil">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <title>' . $title . '</title>';

    echo $head;
}


/**
 * Affichage du footer
 * 
 * @param string $app_name 
 * @param string $app_version 
 * @param string $app_update 
 * @param string $app_author 
 * @return void 
 */
function displayFooter($app_name = APP_NAME, $app_version = APP_VERSION, $app_update = APP_UPDATED, $app_author = APP_AUTHOR) {
    $footer = '
    <div class="marque">
    <h1>CERA</h1>
    <p>© 2024 CERA</p>
  </div>
  <div class="page">
    <ul>
      <li><a href="allProduits.php">Produits</a></li>
      <li><a href="marques.php">Marques</a></li>
      <li><a href="apropos.php">À propos</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
  </div>
    ';

    echo $footer;
    

}

/**
 * Affichage de la navigation
 * 
 * @return void 
 */

 function displayNav() {
     $nav = '
     <header class="header">
     <a href="index.php" class="logo">CERA</a>

     <input type="checkbox" id="check" />
     <label for="check" class="icons">
       <i class="bx bx-menu" id="menu-icon"></i>
       <i class="bx bx-x" id="close-icon"></i>
     </label>

     <nav class="navbar" id="nav">
       <a href="allProduits.php" style="--i: 0">Produits</a>
       <a href="marques.php" style="--i: 1">Marques</a>
       <a href="apropos.php" style="--i: 2">A Propos</a>
       <a href="login.php" style="--i: 3">Connexion</a>
       <a href="#" style="--i: 4">Panier</a>
     </nav>
   </header>
     ';

     echo $nav;
 }
 function displayNavAdmin() {
      $nav = '<header class="header">
    <a href="admin.php" class="logo">CERA</a>

    <input type="checkbox" id="check" />
    <label for="check" class="icons">
      <i class="bx bx-menu" id="menu-icon"></i>
      <i class="bx bx-x" id="close-icon"></i>
    </label>

    <nav class="navbar" id="nav">
      <a href="add.php" style="--i: 0">Ajouter</a>
      <a href="add_brand.php" style="--i: 1">Ajouter marque</a>
      <a href="logout.php" style="--i: 2">Déconnexion</a>
    </nav>
    </header>';
echo $nav;
  
 }
 

/**
 * Affichage de la newsletter
 * 
 * @return void 
 */

    function displayNewsletter() {
        $newsletter = '
        <section class="avantages" data-aos="fade-up" data-aos-duration="1000">
        <div class="icon">
          <i class="bx bxs-truck"></i>
          <h3>Livraison gratuite à partir de 200€</h3>
        </div>
  
        <div class="icon">
          <i class="bx bxs-credit-card-alt"></i>
          <h3>Paiement en 2,3 ou 4 fois</h3>
        </div>
  
        <div class="icon">
          <i class="bx bxs-user-check"></i>
          <h3>Marques Partenaires</h3>
        </div>
  
        <div class="icon">
          <i class="bx bxs-message-dots"></i>
          <h3>Service client réactif</h3>
        </div>
      </section>
  
      <section class="newsletter" data-aos="fade-up" data-aos-duration="1000">
        <div class="news">
          <h3>Newsletter</h3>
          <p>
            Vous inscrire et bénéficier de 10€ offerts sur votre première commande
            dès 100€ d\'achats.
          </p>
        </div>
        <div class="email">
          <form>
            <input type="email" placeholder="Email" />
            <button class="inscrire">S\'inscrire</button>
          </form>
        </div>
      </section>
        ';
    
        echo $newsletter;
    }

/**
 * Affichage de la section hero
 * 
 * 
 */

    function displayBannerIndex() {
        $bannerIndex = '
        <div class="banner autre">
      <div class="head-container" data-aos="zoom-in" data-aos-duration="1500">
        <h1>CERA</h1>
        <p>
          Des vêtements éco-responsables imaginés par des jeunes créateurs rien
          que pour vous
        </p>
        <a href="allProduits.php" class="button-decouvrir">Découvrir</a>
      </div>
    </div>
    <section>
        ';
    
        echo $bannerIndex;
    }
