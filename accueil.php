<?php 
session_start();
    $fichier = 'donnees/bd.json';
    $donnees = file_get_contents($fichier);
    $bd = json_decode($donnees, true);

    function vg_consultes($utilisateurs){
        $consultes=[];
        foreach ($utilisateurs as $utilisateur) {
            foreach ($utilisateur['voyages']['consultes'] as $vg) {
                if (isset($consultes[$vg])){
                    $consultes[$vg]++;
                }
                else{
                    $consultes[$vg]=1;
                }
            }
        }
        return $consultes;
    }
    $consultation=vg_consultes($bd['utilisateurs']);
    arsort($consultation);

    $mieuxconsultes=[];
    foreach ($consultation as $id => $nb) {
        foreach ($bd['voyages'] as $vg) {
            if($vg['id']==$id){
                $mieuxconsultes[]=$vg;
                break;
            }
        }
    }

    arsort($consultation);
    
?>

<?php $titre="Bienvenue dans notre site"; ?>
<?php include "vues/entete.php" ?>

<section class="bienvenue">
    <div class="container">
        <h1>Voyagez comme une princesse</h1>
        <p>Découvrez nos voyages inspirés des héroïnes légendaires et créez des souvenirs inoubliables !</p>
        <div class="articles">
        <?php 
            $mieuxconsultes=array_slice($mieuxconsultes, 0, 3);
            foreach ($mieuxconsultes as $voyage) {
                ?>
                    <article class="article-card">
                        <div class="article-img" style="background-image: url('<?php echo $voyage['img']; ?>')"></div>
                        <div class="article-content">
                            <h3><?php echo $voyage['titre']; ?></h3>
                            <p><?php echo $voyage['specificites']; ?></p>
                            <a href="#" class="btn">Read more</a>
                        </div>
                    </article>
                <?php
            }
        ?>
        </div>
        <br>
        <a href="voyages.php" class="btn">Nos séjours</a>
    </div>
</section>

<section class="bg-blanc">
    <div class="container">
        <h2 class="section-title">Concrètement, il se passe quoi pendant un voyage Fairy Escape ?</h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><img src="https://i.postimg.cc/P5nS7YqP/1.jpg" width="100%" alt="Voyage entre amis"></div>
                <h3>AVENTURE</h3>
                <p>Des compagnons d’aventure inoubliables !</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><img src="https://i.postimg.cc/Vk30gWsV/2.jpg" width="100%" alt="Voyage entre amis"></div>
                <h3>PLAISIR</h3>
                <p>Un voyage sans stress, 100 % plaisir !</p>
            </div>
            <div class="service-card">
                <div class="service-icon"><img src="https://i.postimg.cc/3Rh7Jd9R/magie.jpg" width="100%" alt="Voyage entre amis"></div>
                <h3>MAGIE</h3>
                <p>Vivez la magie du voyage !</p>
            </div>
        </div>
    </div>
</section>

<section class="clt-avis">
    <div class="container">
        <h2 class="section-title">Avis de nos clients</h2>
        <div class="clt-avis-grid">
            <?php foreach ($bd['avis'] as $avis) {
                ?>
                <div class="avis-card">
                    <p class="avis-text"><?php echo $avis['description']?></p>
                    <p class="avis-author">- <?php echo $avis['client']?></p>
                </div>
                <?php
            }?>
        </div>
    </div>
</section>
<section class="bg-orange">
    <div class="container">
        <h2 class="section-title">Devenez membre !</h2>
        <p>Accédez à votre espace personnel pour gérer vos réservations et découvrir des offres exclusives.</p>  <br>
        <?php if(isset($_SESSION['utilisateur'])){ ?>
            <a href="#" class="btn">Se connecter</a>
            <a href="#" class="btn">Inscription</a>
        <?php }?>
        
    </div>
</section>
<?php include "vues/pied.php" ?>
