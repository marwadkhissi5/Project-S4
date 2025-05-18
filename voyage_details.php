<?php 
  session_start();
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = [];
?>

<?php include 'vues/recherche.php' ;?>
<?php
    if(!isset($_GET['id'])){
        header("Location: voyages.php");
    }
    include 'includes/fcts_donnees.php';
    $voyage=rechercher_voyage($_GET['id']);
    if(!isset($voyage)){
        header("Location: voyages.php");
    }
?>

    <section class="section-contenu bg-claire">
      <div class="conteneur">
              <h1 class="titre-principal"><?php echo $voyage['titre']; ?></h1>

              <div class="carte-voyage-detaillee">
                <div class="bloc-contenu">
                  <h3 class="titre-voyage"><?php echo $voyage['titre']; ?></h3>
                  <div class="infos-voyage">
                    <div class="info-item">
                      <span class="icon">📅</span>
                      <span
                        >Du <?php echo $voyage['dates']['debut']; ?> à <?php echo $voyage['dates']['fin']; ?><strong> - <?php echo $voyage['dates']['duree']; ?> jours</strong></span
                      >
                    </div>
                    <div class="info-item">
                      <span class="icon">📝</span>
                      <span
                        ><?php echo $voyage['specificites']; ?>
                      </span>
                    </div>
                    <div class="info-item">
                      <span class="icon">💰</span>
                      <span>Prix total : <strong><?php echo $voyage['prix_total']; ?>&euro;</strong></span>
                    </div>
                  </div>
                </div>
              </div> 
              <h3 class="titre bg-template">Étapes du voyage</h3>
              <?php  
                $etapes=liste_etapes($voyage['liste_etapes']);
                $options=[];

              ?>
              <ul class="liste-etapes">
                <?php 
                  foreach($etapes as $etape){
                    ?>
                    <li>
                      <h3><?php echo $etape['titre'];?></h3>
                      <p>Lieu : <?php echo $etape['position']['lieu'];?></p>
                      <p>Durée : <?php echo $etape['duree'];?> jours</p>
                      <p>Options : <?php 
                        foreach($etape['options'] as $option){

                          echo $option." | ";

                        }
                      ?></p>
                    </li>
                    <?php 

                  }
                ?>
              </ul>
              <br />
              <?php if(isset($_SESSION['utilisateur'])){?>
                <a href="reservation.php?id=<?php echo $voyage['id'] ?>" class="btn btn-template">Réserver ce voyage</a>
              <?php }else {?>
                <div class="alert alert-danger">
                  Vous devez vous <a href="connexion.php">connecter</a> à votre compte ou en <a href="inscription.php">créer un</a> pour réserver ce voyage
                </div>
              <?php }?>
            </div>
    </section>
<?php include 'vues/pied.php' ;?>