<?php 
  session_start();
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = [];


?>

  <!-- Bande d'accueil -->
  <section class="section-accueil">
    <div class="superposition">
      <div class="contenu-accueil conteneur">
        <h2>Explorez le monde avec <span>Fairy Escapes</span></h2>
        <p>
          Des séjours inoubliables, conçus pour rêver, explorer et s’évader.
        </p>
        <a href="voyages.php" class="btn btn-template">Voir nos destinations</a>
      </div>
    </div>
  </section>
  
  <?php 
    include 'includes/fcts_donnees.php';
    $destination = Mieux_consultes();
    $mieuxconsultes=array_slice($destination, 0, 3);
  ?>
  <section class="section-destinations" id="destinations">
    <div class="conteneur">
      <h2 class="titre-section">Nos destinations populaires</h2>
      <div class="grille-destinations">
      <?php 
        foreach ($mieuxconsultes as $voyage) {
          ?>
             <div class="carte-destination">
              <img src="<?php echo $voyage['img']; ?>" alt="<?php echo $voyage['titre']; ?>" />
              <h3><?php echo $voyage['titre']; ?></h3>
              <p><?php echo $voyage['specificites']; ?></p>
              <a href="voyages.php" class="btn btn-template">Voir les détails</a>
            </div>
          <?php 
        }
      ?>
      </div>
    </div>
  </section>

  <section class="section-avantages bg-gris">
    <div class="conteneur">
      <h2 class="titre-section">Pourquoi choisir Fairy Escapes ?</h2>
      <div class="grille-avantages">
        <div class="avantage">
          <img src="img/help.png" alt="Conseil personnalisé" />
          <h3>Conseil personnalisé</h3>
          <p>
            Un expert à votre écoute pour concevoir un voyage qui vous
            ressemble.
          </p>
        </div>
        <div class="avantage">
          <img src="img/prix.png" alt="Prix compétitifs" />
          <h3>Meilleurs prix</h3>
          <p>
            Des offres négociées au meilleur rapport qualité-prix, sans
            surprise.
          </p>
        </div>
        <div class="avantage">
          <img src="img/assistance.png" alt="Assistance 24/7" />
          <h3>Assistance 24h/24</h3>
          <p>Un accompagnement avant, pendant et après votre voyage, 7j/7.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section-avis">
    <div class="conteneur">
      <h2 class="titre-section">Ce que disent nos voyageurs</h2>
      <div class="grille-avis">
      <?php 
        foreach ($bd['avis'] as $avis) {
          ?>
              <div class="carte-avis">
                <h3><?php echo $avis['client']?></h3>
                <div class="etoiles"><?php echo $avis['note']?></div>
                <p>
                <?php echo $avis['description']?>
                </p>
              </div>
          <?php 
        }
      ?>
      </div>
    </div>
  </section>

<?php include 'vues/pied.php' ;?>
