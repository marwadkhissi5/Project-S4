<?php
session_start();
$fichier = 'donnees/bd.json';
$voyages = [];

$donnees = file_get_contents($fichier);
$decoded_data = json_decode($donnees, true);
$voyages = $decoded_data['voyages'];
$nb_par_page=6;
$nombre_tot_page=ceil(count($voyages)/$nb_par_page);

$page=1;
if (isset($_GET['page']))
    $page=$_GET['page'];
?>

<?php $titre="Nos voyages"; ?>
<?php include "vues/entete.php" ?>

<section class="bg-blanc">
    <div class="container">
        <h2 class="section-title">Nos séjours</h2>
        <div class="articles">
        <?php 
             $debutp=(($page-1)*$nb_par_page);
            foreach (array_slice($voyages, $debutp, $nb_par_page) as $voyage) {
                ?>
                    <article class="article-card">
                        <div class="article-img" style="background-image: url('<?php echo $voyage['img']; ?>')"></div>
                        <div class="article-content">
                            <h3><?php echo $voyage['titre']; ?></h3>
                            <p><?php echo $voyage['specificites']; ?></p>
                            <a href="reservation.php?id=<?php echo $voyage['id']; ?>" class="btn">Reserver ce voyage</a>
                        </div>
                    </article>
                <?php
            }
        ?>
        </div>
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
</section>

<?php include "vues/pied.php" ?>
