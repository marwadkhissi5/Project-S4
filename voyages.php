<?php 
  session_start();
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = ['voyages_tri.js'];
?>

<?php include 'vues/recherche.php' ;?>

  <section class="section-voyages bg-clair">
    <div class="conteneur">
      <h1 class="titre-principal">Nos voyages à venir</h1>
      <div class="carte-tri">
        <span class="tri-label">Trier par :</span>

        <div class="groupe-tri">
          <button class="btn-tri" data-tri="date" data-order="asc">📅 Date de début</button>
          <button class="btn-order" data-order="asc">↑</button>
        </div>

        <div class="groupe-tri">
          <button class="btn-tri" data-tri="prix" data-order="asc">💰 Prix</button>
          <button class="btn-order" data-order="asc">↑</button>
        </div>

        <div class="groupe-tri">
          <button class="btn-tri" data-tri="etapes" data-order="asc">🧭 Durée</button>
          <button class="btn-order" data-order="asc">↑</button>
        </div>
      </div>
      <div id="liste_voyages">
      <?php 
        include 'includes/fcts_donnees.php';
        $voyages=$bd["voyages"];
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
      <div class="pagination">
        <?php 
            echo '<a href="voyages.php?page='.($page-1).'" class="pagination-item">&laquo;</a>';
            for ($i=1; $i <= $nombre_tot_page; $i++) { 
                if ($page==$i){
                    echo '<a href="voyages.php?page='.$i.'" class="pagination-item active">'.$i.'</a>';
                }
                else{
                    echo '<a href="voyages.php?page='.$i.'" class="pagination-item">'.$i.'</a>';
                }
            }
            echo '<a href="voyages.php?page='.($page+1).'" class="pagination-item">&raquo;</a>'
        ?>
      </div>
    </div>
  </section>

<?php include 'vues/pied.php' ;?>
