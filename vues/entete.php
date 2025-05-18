<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fairy Escapes – Agence de voyage</title>
  <link rel="stylesheet" href="assets/css/couleur.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="assets/css/elements.css" />
  <script src="assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
  <!-- Barre supérieure -->
  <div class="barre-sup bg-template">
    <div class="conteneur">
      <div class="infos-contact">
        +33 600 000 000 — contact@fairyescapes.fr
      </div>
      <div class="liens-haut">
        <?php if(isset($_SESSION['utilisateur'])){ ?>
          <a href="deconnexion.php">Se déconnecter</a>
          <a href="profile.php">Votre espace</a>
        <?php }else{?>
          <a href="connexion.php">Se connecter</a>
          <a href="inscription.php">S'inscrire</a>
        <?php }?>
        <a href="#" onclick="ModifMode('mode-clair')">Clair</a>
        <a href="#" onclick="ModifMode('mode-sombre')">Sombre</a>
        <a href="#" onclick="ModifMode('mode-malvoyant')">Malvoyant</a>
      </div>
    </div>
  </div>
  <header class="entete-principal">
        <div class="conteneur">
        <div class="logo">
            <div class="nom-agence">
            <h1>Fairy Escapes</h1>
            <span>Créateurs de voyages enchantés</span>
            </div>
        </div>
        <nav class="navigation-principale">
            <a href="index.php">Accueil</a>
            <a href="voyages.php">Destinations</a>
            <a href="about.php">À propos de nous</a>
            <a href="contact.php">Contact</a>
        </nav>
        <div class="panier">
            <a href="panier.php" class="panier-lien">
                🛒 <span class="compteur-panier">
                  <?php 
                    if(isset($_SESSION['panier'])){
                      echo count($_SESSION['panier']);
                    }
                    else{
                      echo 0;
                    }
                  ?>
                </span>
            </a>
            </div>
        </div>
    </header>