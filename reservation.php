<?php 
    session_start();
    include 'vues/entete.php';
    $stylesheets = [];
    $javascripts = ["reservation.js"];
?>

<?php include 'vues/recherche.php' ;?>
<?php
    if(!isset($_SESSION['utilisateur'])){
        header("Location: voyages.php");
    }
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
        <div class="row">
          <div class="col-9">
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
                      <span>Prix : <strong><?php echo $voyage['prix_total']; ?>&euro;</strong></span>
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
                      <p>Description : <?php 
                        foreach($etape['options'] as $option){
                          echo $option." | "; 
                        }
                      }?></p>
                    </li>
                </ul>
              
              <h3 class="titre bg-template">Choisissez vos options</h3>

              <form id="form-options" class="form-options" method="POST" action="recapitulatif.php">
                <input type="hidden" name="voyage" value="<?php echo $voyage['id']; ?>" />
                <input type="hidden" id="nb_p" name="nb_personne" value="1"/>
                <?php 
                    $options=liste_options($voyage['liste_options']);

                    foreach($options as $option){ ?>
                        <div class="option-item">
                        <label>
                            <input
                            type="checkbox"
                            value="<?php echo $option['id']; ?>"
                            name="options[]"
                            data-id="<?php echo $option['id'] ?>"
                            data-prix="<?php echo $option['prix_par_personne'] ?>"
                            data-nb="<?php echo $option['nombre_personnes'] ?>"
                            />
                            
                            <?php echo $option['titre'] ?> – <?php echo $option['prix_par_personne'] ?> &euro; / personne
                        </label>
                        <span class="option-detail">Inclut <?php echo $option['nombre_personnes'] ?> personne(s)</span>
                        </div>
                    <?php } ?>
                <input type="submit" class="btn btn-template" value="Ajouter au panier">
              </form>
              <br />
            </div>
          </div>
          <aside class="col-3">
            <div class="carte-recap">
              <h3><?php echo $voyage['titre']; ?></h3>
              <p>📅 Du <?php echo $voyage['dates']['debut']; ?> au <?php echo $voyage['dates']['fin']; ?> – <?php echo $voyage['dates']['duree']; ?> jours</p>
              <p>💰 Prix de base : <strong><?php echo $voyage['prix_total']; ?>&euro;</strong></p>
              <input type="hidden" id="prix_init" value="<?php echo $voyage['prix_total']; ?>">
              <label for="nb-personnes"
                ><strong>👥 Nombre de personnes :</strong></label
              >
              <input
                type="number"
                id="nb_personnes"
                value="1"
                min="1"
                style="width: 60px; margin-left: 10px"
              />
              <hr />
              <p>🧩 Options :</p>
              <ul id="liste-options">
              </ul>
              <hr />
              <p>
                <strong>Total :</strong> <span id="total_prix"><?php echo $voyage['prix_total']; ?>&euro;</span>
              </p>
            </div>
          </aside>
        </div>
      </div>
    </section>
<?php include 'vues/pied.php' ;?>
