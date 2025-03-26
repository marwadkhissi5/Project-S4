<?php
session_start();
// Vérification de l'existence du fichier JSON
$fichier = 'donnees/bd.json';
$voyages = [];

$donnees = file_get_contents($fichier);
$decoded_data = json_decode($donnees, true);
$voyages = $decoded_data['voyages'];

function recherche_voyage($donnees,$id){
    $resultat=array_filter($donnees, function($vg) use ($id){
        return $vg['id']==$id;
    });
    return array_values($resultat)[0];
}

function recherche_etapes($etapes, $liste){
    $res=[];
    foreach ($liste as $id) {
        $resultat=array_filter($etapes, function($etape) use ($id){
            return $etape['id']==$id;
        });
        if(!empty($resultat)){
            $res[]=array_values($resultat)[0];
        }
    }
    
    return $res;
}

function recherche_options($options, $liste){
    $res=[];
    foreach ($liste as $id) {
        $resultat=array_filter($options, function($option) use ($id){
            return $option['id']==$id;
        });
        if(!empty($resultat)){
            $res[]=array_values($resultat)[0];
        }
    }
    
    return $res;
}

$voyage=null;
$etapes=[];
if(isset($_GET['id'])){
    $voyage=recherche_voyage($voyages, $_GET['id']);
    $etapes=recherche_etapes($decoded_data['etapes'], $voyage['liste_etapes']);
}
else{
    header('Location: voyages.php');
}
?>

<?php
    if(!isset($_SESSION['utilisateur'])){
        header('Location: voyages.php');
    }
?>

<?php $titre="Voyage  : ".$voyage['titre']; ?>
<?php include "vues/entete.php" ?>
<link rel="stylesheet" type="text/css" href="css/form.css">

<section class="bg-fairy">
    <div class="container">
        <div class="voyage-card">
            <div class="voyage-header" style="background-image: url('<?php echo $voyage['img'];?>')">
                <div class="voyage-overlay">
                <h2 class="voyage-title"><?php echo $voyage['titre'];?></h2>
                </div>
            </div>
            
            <div class="voyage-body">
                <div class="voyage-dates">
                <div class="date-item">
                    <span class="date-label">Départ</span>
                    <span class="date-value"><?php echo $voyage['dates']['debut']; ?></span>
                </div>
                <div class="date-item">
                    <span class="date-label">Retour</span>
                    <span class="date-value"><?php echo $voyage['dates']['fin']; ?></span>
                </div>
                </div>
                
                <div class="voyage-highlights">
                    <h3>Spécificités du voyage</h3>
                    <p><?php echo $voyage['specificites']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div>
            <form action="recapitulatif.php" class="form" method="POST">
            <input type="hidden" name="voyage" value="<?php echo $voyage['id'];?>">
            <h3>Etapes :</h3>
            <?php 
            foreach ($etapes as $etape) {
                    echo '<label class="form-label">Etape '.$etape['id'].' : '.$etape['titre'].'</label>';
                    echo '<label class="form-label">Durée : '.$etape['duree'].'</label>';
                    $options=recherche_options($decoded_data['options'], $etape['options']);
                    foreach ($options as $option) {
                    echo '<input type="checkbox" name="options'.$etape['id'].'[]" value="'.$option["id"].'"> '.$option['titre'];
                    echo '<br>';
                    }
            }
            ?>
            <input type='submit' class="btn" value="Confirmer la réservation">
            </form>
        </div>
    </div>
</section>
<?php include "vues/pied.php" ?>
