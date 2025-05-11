<?php 
    session_start();
    include 'vues/entete.php';
    $stylesheets = [];
    $javascripts = [];
?>

<?php include 'vues/recherche.php' ;?>
<?php
    include 'includes/fcts_donnees.php';

    if(!isset($_SESSION['utilisateur'])){
        header("Location: voyages.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['voyage'])){
            $voyage=rechercher_voyage($_POST['voyage']);
            if(!isset($voyage)){
              header("Location: voyages.php");
            }
            $options=null;
            $prix_options=0;
            if (isset($_POST['options'])){
                $options=liste_options($_POST['options']);
                foreach($options as $option){
                    $prix_options+=$option['prix_par_personne'];
                    if($_POST['nb_personne'] > $option['nombre_personnes']){
                        $nb=$_POST['nb_personne']-$option['nombre_personnes'];
                        $prix_options+=$option['prix_par_personne']*$nb;
                    }
                }
            }
            $vg=["voyage"=>$voyage,"options"=>$options,"prix"=>$prix_options+$voyage["prix_total"]*$_POST["nb_personne"]];
            if(isset($_SESSION['panier'])){
              $etat=false;
              foreach($_SESSION['panier'] as $voy){
                if($voy['voyage']['id']==$voyage['id']){
                  $etat=true;
                  break;
                }
              }
              if(!$etat){
                $_SESSION['panier'][]=$vg;
              }
            }
            else{
              $_SESSION['panier']=[$vg];
            }
        }
        
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
                      <span>Prix total : <strong><?php echo $voyage['prix_total']+$prix_options; ?>&euro;</strong></span>
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
                <?php 
                    foreach($options as $option){ ?>
                        <div class="option-item">
                        <label>
                            <?php echo $option['titre'] ?> – <?php echo $option['prix_par_personne'] ?> &euro; / personne
                        </label>
                        <span class="option-detail">Inclut <?php echo $option['nombre_personnes'] ?> personne(s)</span>
                        </div>
                    <?php } ?>
              <br />
              <a href="panier.php" class="btn btn-template">Passer à la caisse</a>
      </div>
    </section>
<?php include 'vues/pied.php' ;?>
