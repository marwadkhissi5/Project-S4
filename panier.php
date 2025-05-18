<?php 
    session_start();
    include 'vues/entete.php';
    $stylesheets = [];
    $javascripts = ['panier.js'];
?>

<?php include 'vues/recherche.php' ;?>

<section class="section-panier bg-clair">
  <div class="conteneur">
    <h2 class="titre-principal">🛒 Mon panier de voyages</h2>

    <div class="panier-liste">
      <?php 
        $prix_total=0;
        if(isset($_SESSION['panier'])){
          foreach($_SESSION['panier'] as $voyage){
            $prix_total+=$voyage['prix'];
            ?><div class="carte-panier" id="res-<?php echo $voyage['voyage']['id'];?>">
                <div class="info-voyage">
                  <h3><?php echo $voyage['voyage']['titre']; ?></h3>
                  <p>📅 Du <?php echo $voyage['voyage']['dates']['debut']; ?> au <?php echo $voyage['voyage']['dates']['fin']; ?> – <?php echo $voyage['voyage']['dates']['duree']; ?> jours</p>
                  <p>Nombre de personnes : <?php echo $voyage['nbpersonnes']; ?></p>
                  <p>💰 <?php echo $voyage['prix']; ?> &euro;</p>
                  
                </div>
                <button class="btn btn-danger btn-small btn-supp" data-id="<?php echo $voyage['voyage']['id'];?>">🗑 Retirer</button>
              </div>
          </div>
         <?php }
        }
      ?>
    </div>

    <?php
    require('includes/getapikey.php');
    $vendeur = "MI-4_I" ;
    $api_key = getAPIKey($vendeur);
    $retour="http://localhost/projet_fin/valider.php?session=s";
    $montant=$prix_total;
    $transaction="203032CDAB";
    $controle = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#" );
    //echo $controle;
    ?>

    <div class="total-panier">
      <p><strong>Total :</strong> <span class="prix-total"><?php echo $prix_total; ?></span>&euro;</p>
      <form action='https://www.plateforme-smc.fr/cybank/index.php'method='POST'>
        <input type='hidden' name='transaction'
        value='154632ABCD'>
        <input type='hidden' name='montant' value='<?php echo $prix_tot; ?>'>
        <input type='hidden' name='vendeur' value='<?php echo $vendeur; ?>'>
        <input type='hidden' name='retour' value='<?php echo $retour; ?>'>
        <input type='hidden' name='control' value='<?php echo $controle; ?>'>
        <input type='submit' value="Valider et payer" class="btn btn-template btn-large btn-valider">
      </form>
    </div>
  </div>
</section>


<?php include 'vues/pied.php' ;?>