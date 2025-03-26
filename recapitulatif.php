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
if(isset($_POST['voyage'])){
    $voyage=recherche_voyage($voyages, $_POST['voyage']);
    $etapes=recherche_etapes($decoded_data['etapes'], $voyage['liste_etapes']);
    $options=array();
    foreach ($etapes as $etape) {
        $form="options".$etape['id'].'';
        if(isset($_POST[$form])){
            $options[''.$etape['id']]=$_POST[$form];
        }
    }
}
else{
    header('Location: voyages.php');
}
?>

<?php
    if(!isset($_SESSION['utilisateur'])){
        header('Location: voyages.php');
    }

    require('includes/getapikey.php');
    $api_key = "zzzz";
    $vendeur = "MI-4_I" ;
    $api_key = getAPIKey($vendeur);
    if(preg_match("/^[0-9a-zA-Z]{15}$/", $api_key)) {
        echo "API Key valide";
    }
?>
<?php $titre="Récaputilatifs "; ?>
<?php include "vues/entete.php" ?>
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

                <div class="voyage-highlights">
                    <h3>Liste des options</h3>
                    <?php
                        $prix_tot=$voyage['prix_total'];
                        foreach ($etapes as $etape) {
                            $form="options".$etape['id'].'';
                            $options=$_POST[$form];
                            $res=recherche_options($decoded_data['options'], $options);
                            foreach ($res as $option) {
                                $prix_tot=$prix_tot+$option['prix_par_personne'];
                                echo '<p>'.$option['titre'].'</p>';
                            }
                        }
                        
                        $retour="http://localhost/retour_paiement.php?session=s";
                        $montant=$prix_tot;
                        $transaction="203032CDAB";
                        $controle = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#" );
                        echo $controle;
                    ?>
                </div>
                <div class="voyage-price">
                    <span class="price-label">Prix total</span>
                    <span class="price-value"><?php echo $prix_tot; ?> €</span>
                </div>
                <div class="voyage-footer">
                    <form action='https://www.plateforme-smc.fr/cybank/index.php'method='POST'>
                        <input type='hidden' name='transaction'
                        value='154632ABCD'>
                        <input type='hidden' name='montant' value='<?php echo $prix_tot; ?>'>
                        <input type='hidden' name='vendeur' value='<?php echo $vendeur; ?>'>
                        <input type='hidden' name='retour' value='<?php echo $retour; ?>'>
                        <input type='hidden' name='control' value='<?php echo $controle; ?>'>
                        <input type='submit' value="Valider et payer" class="voyage-button">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include "vues/pied.php" ?>
