<?php
// Vérifier si le formulaire a été soumis
$recherche_effectuee = ($_SERVER["REQUEST_METHOD"] == "POST");

// Initialisation des variables
$destination = isset($_POST['destination']) ? $_POST['destination'] : '';
$date_debut = isset($_POST['date_depart']) ? $_POST['date_depart'] : '';
$date_fin = isset($_POST['date_retour']) ? $_POST['date_retour'] : '';
$personnes = isset($_POST['personnes']) ? $_POST['personnes'] : 1;
$budget = isset($_POST['budget']) ? $_POST['budget'] : '';

// Initialisation du tableau des résultats
$resultats = [];

// Vérification de l'existence du fichier JSON
$fichier = 'donnees/bd.json';
$voyages = [];

if (file_exists($fichier) && filesize($fichier) > 0) {
    $donnees = file_get_contents($fichier);
    $decoded_data = json_decode($donnees, true);
// Charger les étapes depuis le JSON
$etapes = [];
if ($decoded_data && isset($decoded_data['etapes'])) {
    $etapes = $decoded_data['etapes'];
}
$options = [];
if ($decoded_data && isset($decoded_data['options'])) {
    $options = $decoded_data['options'];
}
    if ($decoded_data && isset($decoded_data['voyages'])) {
        $voyages = $decoded_data['voyages'];
    }
}

// Si une recherche a été effectuée, on filtre les voyages
if ($recherche_effectuee) {
    foreach ($voyages as $voyage) {
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

        // Filtrage par date de fin
        if (!empty($date_fin)) {
            $date_fin_voyage = strtotime($voyage['dates']['fin']);
            if ($date_fin_voyage > strtotime($date_fin)) {
                $ajouter = false;
            }
        }

        // Filtrage par budget
        if (!empty($budget)) {
            if ($budget == "0" && $voyage['prix_total'] > 1000) {
                $ajouter = false;
            } elseif ($budget == "1000" && ($voyage['prix_total'] < 1000 || $voyage['prix_total'] > 2000)) {
                $ajouter = false;
            } elseif ($budget == "2000" && $voyage['prix_total'] < 2000) {
                $ajouter = false;
            }
        }

        // Filtrage par nombre de personnes
        if (!empty($personnes) && isset($voyage['places_max']) && $voyage['places_max'] < $personnes) {
            $ajouter = false;
        }

        // Ajout du voyage si tous les critères sont remplis
        if ($ajouter) {
            $resultats[] = $voyage;
        }
    }
}
?>

<?php $titre="Recherche "; ?>
<?php include "vues/entete.php" ?>

<div class="container">
	<div class="rightbox">
        <div class="search-box">
            <h1>Voyagez comme une princesse</h1>
            <form method="POST">
                <div class="date-selection">
   			<span>DU</span>
   			<input type="date" id="date_depart" name="date_depart">
    			<span>AU</span>
    			<input type="date" id="date_retour" name="date_retour">
		</div>

                <label for="destination">Destination :</label>
                <input type="text" id="destination" name="destination">
                
		<label for="personnes">Nombre de personnes :</label>
                <input type="number" id="personnes" name="personnes" min="1" value="1" required>
		<div class="budget-section">

   		 <span>Budget :</span>
            <input type="radio" name="budget" id="budget1" value="0">
    			<label for="budget1">500€ - 1000€</label>

    			<input type="radio" name="budget" id="budget2" value="1000">
   			<label for="budget2">1000€ - 2000€</label>

 		   	<input type="radio" name="budget" id="budget3" value="2000">
  			<label for="budget3">Plus de 2000€</label>
		</div>
                <input type="submit" value="Rechercher">
            </form>
        </div>
	</div>
</div>	

<div class="carousel">
    <div class="slides">

        <div class="slide">
            
                <div class="slide-header">Séjour Jasmine - Oman</div>
                <img src="https://i.postimg.cc/yYQhzRnV/jasmine.jpg" alt="Oman - Séjour Jasmine">
           
            <div class="activities-container">
                <div class="activity-card">
                    <h3>Voyage complet - Séjour Jasmine à Oman</h3>
                    <span class="title">Safari dans le désert:</span> <p>Traversez les dunes d'Oman en 4x4.</p>
                    <span class="title">Visite du souk:</span> <p>Découvrez les trésors cachés des marchés omanais.</p>
                    <span class="title">Croisière en dhow:</span> <p>Naviguez sur la mer d’Arabie comme dans un conte.</p>
                    <span class="price">À partir de 699,99€</span>
                </div>
            </div>
        </div>


        <div class="slide">
           
                <div class="slide-header">Séjour Amérique - Pocahontas</div>
                <img src="https://i.postimg.cc/wvq3vfTn/pocahontas.jpg" alt="Amérique - Séjour Pocahontas">
        
            <div class="activities-container">
                <div class="activity-card">
                    <h3>Voyage complet - Séjour Pocahontas aux États-Unis</h3>
                    <span class="title">Kayak en rivière:</span> <p>Explorez les rivières de Williamsburg comme Pocahontas.</p>
                    <span class="title">Randonnée en forêt:</span> <p>Partez sur les traces des tribus amérindiennes.</p>
                    <span class="title">Soirée feu de camp:</span> <p>Vivez une soirée typique avec chants.</p>
                    <span class="price">À partir de 759,99€</span>
                </div>
            </div>
        </div>

        <div class="slide">

                <div class="slide-header">Séjour Mulan - Chine</div>
                <img src="https://i.postimg.cc/W1cNzW5S/mulan.jpg" alt="Chine - Séjour Mulan">
     
            <div class="activities-container">
                <div class="activity-card">
                    <h3>Voyage complet - Séjour Mulan en Chine</h3>
                    <span class="title">Randonnée sur la Muraille:</span> <p>Marchez sur les traces des guerriers de l'Empire.</p>
                    <span class="title">Cours de Kung-Fu:</span> <p>Apprenez les bases du Kung-Fu, l'art des guerriers.</p>
                    <span class="title">Dégustation de thé:</span> <p>Découvrez les secrets du thé chinois.</p>
                    <span class="price">À partir de 899,99€</span>
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Résultats de la recherche -->
<div class="search-results">
    <h2>Résultats de la recherche</h2>

    <?php if ($recherche_effectuee) { ?>
        <?php if (count($resultats) > 0) { ?>
            <ul>
                <?php foreach ($resultats as $voyage) { ?>
                    <li>
                        <h3><?php echo ($voyage['titre']); ?></h3>
                        <p>Date de début: <?php echo ($voyage['dates']['debut']); ?></p>
                        <p>Date de fin: <?php echo ($voyage['dates']['fin']); ?></p>
                        <p>Prix total: <?php echo ($voyage['prix_total']); ?> €</p>
                        

                        <!-- Affichage des étapes sous le voyage -->
                        <h4>Choisissez une étape pour ce voyage :</h4>
                            <ul>
                            <?php 
                            if (!empty($voyage['liste_etapes']) && count($voyage['liste_etapes']) >= 2) {
                            $id_etape_1 = $voyage['liste_etapes'][0]; // Première étape
                            $id_etape_2 = $voyage['liste_etapes'][1]; // Deuxième étape
        
                            if (isset($etapes[$id_etape_1]) && isset($etapes[$id_etape_2])) {
                            $etape1 = $etapes[$id_etape_1];
                            $etape2 = $etapes[$id_etape_2];
                            ?>
                            <li>
                            <input type="radio" name="etape_<?php echo $voyage['id']; ?>" value="<?php echo $id_etape_1; ?>">
                            <p><?php echo $etape1['titre']; ?></p><br>
                            <p> <span style="font-weight: bold;">Position:</span> <?php echo $etape2['position']['lieu']; ?><br></p>
                            <p>   <span style="font-weight: bold;"> Durée:</span> <?php echo $etape1['duree']; ?><br></p>
                            <p>   <span style="font-weight: bold;">Options:</span> <?php echo isset($etape1['options']) ? implode(", ", $etape1['options']) : 'Aucune option'; ?></p>
                            </li>

                            <li>
                            <input type="radio" name="etape_<?php echo $voyage['id']; ?>" value="<?php echo $id_etape_2; ?>">
                            <p><?php echo $etape2['titre']; ?></p><br>
                            <p>  <span style="font-weight: bold;">Position:</span> <?php echo $etape2['position']['lieu']; ?><br></p>
                            <p>  <span style="font-weight: bold;">Durée:</span> <?php echo $etape2['duree']; ?><br></p>
                            <p>   <span style="font-weight: bold;">Options: <?php echo isset($etape2['options']) ? implode(", ", $etape2['options']) : 'Aucune option'; ?></p>
                            </li>
                             <?php
                            } else {
                                echo "<li>Erreur : Une ou plusieurs étapes non trouvées.</li>";
                            }
                            } else {
                                echo "<li>Pas assez d'étapes disponibles pour ce voyage.</li>";
                            }
                            ?>
                            </ul>
                            <!-- Affichage des options sous le voyage -->
                            <h4>Choisissez une option pour ce voyage :</h4>
<ul>
                                 <?php 
                                if (!empty($voyage['liste_options']) && count($voyage['liste_options']) >= 2) {
                                $id_option_1 = $voyage['liste_options'][0]; // Première option
                                $id_option_2 = $voyage['liste_options'][1]; // Deuxième option

                                if (isset($options[$id_option_1]) && isset($options[$id_option_2])) {
                                $option1 = $options[$id_option_1];
                                $option2 = $options[$id_option_2];
                                ?>
                                <li>
                                <input type="radio" name="option_<?php echo $voyage['id']; ?>" value="<?php echo $id_option_1; ?>">
                                <p><span style="font-weight: bold;">Sélection:</span> <?php echo $option1['titre']; ?></p>
                                <p><span style="font-weight: bold;">Nombre de personne:</span> <?php echo $option1['nombre_personnes']; ?></p>
                                <p><span style="font-weight: bold;">Prix:</span> <?php echo $option1['prix_par_personne']; ?> €</p>
                                </li>

                                <li>
                                <input type="radio" name="option_<?php echo $voyage['id']; ?>" value="<?php echo $id_option_2; ?>">
                                <p><span style="font-weight: bold;">Sélection:</span> <?php echo $option2['titre']; ?></p>
                                <p><span style="font-weight: bold;">Nombre de personne:</span> <?php echo $option2['nombre_personnes']; ?></p>
                                <p><span style="font-weight: bold;">Prix:</span> <?php echo $option2['prix_par_personne']; ?> €</p>
                                </li>
                                <?php
                                } else {
                                echo "<li>Erreur : Une ou plusieurs options non trouvées.</li>";
                                }
                                } else {
                                echo "<li>Pas assez d'options disponibles pour ce voyage.</li>";
                                }
                                ?>
                                </ul>
                    </li>
                    <p><a href="paiements.php?<?php echo ($voyage['id']); ?>">Réserver</a></p>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p style="margin-top: 20px;">Aucun voyage ne correspond à votre recherche.</p>
        <?php } ?>
    <?php } ?>
</div>

<?php include "vues/pied.php" ?>
