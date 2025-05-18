<?php 
    session_start();
    include 'includes/fcts_donnees.php';
    include 'vues/entete.php';
    $stylesheets = [];
    $javascripts = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
        $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
        $nb_jours = isset($_POST['nb_jours']) ? $_POST['nb_jours'] : 1;
        $budget_max = isset($_POST['budget_max']) ? $_POST['budget_max'] : '';
        $resultats=[];

        foreach ($bd['voyages'] as $voyage) {
            $ajouter = true;
    
            // Filtrage par destination
            if (!empty($destination) && strpos(strtolower($voyage['titre']), strtolower($destination)) === false) {
                $ajouter = false;
            }
    
            // Filtrage par date de début
            if (!empty($date_debut)) {
                $date_debut_voyage = strtotime($voyage['dates']['debut']);
                if ($date_debut_voyage < strtotime($date_debut)) {
                    $ajouter = false;
                }
            }
    
            // Filtrage par budget
            if (!empty($budget_max) && $voyage['prix_total'] > $budget_max) {
                $ajouter=false;
            }
    
            // Filtrage par nombre de jours
            if (!empty($nb_jours)) {
                if($nb_jours=="1" && $voyage['dates']['duree'] > 3)
                    $ajouter = false;
                else if($nb_jours=="2" && ($voyage['dates']['duree'] < 4 || $voyage['dates']['duree'] > 7))
                    $ajouter = false;
                else if($nb_jours=="3" && ($voyage['dates']['duree'] < 8 || $voyage['dates']['duree'] > 14))
                    $ajouter = false;
                else if($nb_jours=="4" && ($voyage['dates']['duree'] < 15))
                    $ajouter = false;
            }
    
            // Ajout du voyage si tous les critères sont remplis
            if ($ajouter) {
                //print_r($voyage);
                $resultats[] = $voyage;
            }
        }
        $voyages=$resultats;
        $_SESSION['voyages']=$voyages;
        
    }

?>

<?php include 'vues/recherche.php' ;?>

  <section class="section-voyages bg-clair">
    <div class="conteneur">
      <h1 class="titre-principal">Nos voyages à venir</h1>
      <div class="carte-tri">
        <span class="tri-label">Trier par :</span>

        <div class="groupe-tri">
          <button class="btn-tri active" data-tri="date" data-order="asc">📅 Date de début</button>
          <button class="btn-order" data-order="asc">↑</button>
        </div>

        <div class="groupe-tri">
          <button class="btn-tri" data-tri="prix" data-order="asc">💰 Prix</button>
          <button class="btn-order" data-order="asc">↑</button>
        </div>

        <div class="groupe-tri">
          <button class="btn-tri" data-tri="etapes" data-order="asc">🧭 Étapes</button>
          <button class="btn-order" data-order="asc">↑</button>
        </div>
      </div>
      <?php 
        if(isset($_SESSION['voyages'])){
            $voyages=$_SESSION['voyages'];
        }
        $nombre_tot_page=ceil(count($voyages)/$nb_par_page);
        $page=1;
        if (isset($_GET['page']))
            $page=$_GET['page'];

        $debutp=(($page-1)*$nb_par_page);
        foreach (array_slice($voyages, $debutp, $nb_par_page) as $voyage) {
          ?>
          <div class="carte-voyage-detaillee">
            <div class="bloc-image">
              <img src="<?php echo $voyage['img']; ?>" alt="<?php echo $voyage['titre']; ?>" />
            </div>
            <div class="bloc-contenu">
              <h3 class="titre-voyage"><?php echo $voyage['titre']; ?></h3>
              <div class="infos-voyage">
                <div class="info-item">
                  <span class="icon">📅</span>
                  <span>Du <?php echo $voyage['dates']['debut']; ?> à <?php echo $voyage['dates']['fin']; ?>  – <strong><?php echo $voyage['dates']['duree']; ?> jours</strong></span>
                </div>
                <div class="info-item">
                  <span class="icon">📝</span>
                  <span><?php echo $voyage['specificites']; ?>
                  </span>
                </div>
                <div class="info-item">
                  <span class="icon">💰</span>
                  <span>Prix total : <strong><?php echo $voyage['prix_total']; ?>&euro;</strong></span>
                </div>
              </div>
              <a href="voyage_details.php?id=<?php echo $voyage['id']; ?>" class="btn btn-template">Plus d'infos</a>
            </div>
          </div>
          <?php 

        }

      ?>
    </div>
  </section>

<?php include 'vues/pied.php' ;?>