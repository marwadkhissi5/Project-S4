<?php 
session_start();
include 'includes/fcts_donnees.php';
include 'vues/entete.php';
$stylesheets = [];
$javascripts = ["profile.js"];

if(!isset($_SESSION["utilisateur"])){
	header("Location: index.php");
}

$utilisateur=$_SESSION["utilisateur"];
$voyages=liste_voyages($utilisateur['voyages']['achetes']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs soumises
    $valeurs = [
        'nom' => $_POST['nom'],
        'email' => $_POST['email'],
        'naissance' => $_POST['naissance'],
    ];

    // Vérification de l'existence du login et de l'email
    $email_existe = false;

	$user=rechercher_email($valeurs['email']);
	if($user && ($utilisateur['login']!=$user['login'])){
		$email_existe = true;
	}

	if(!$email_existe){

		foreach ($bd['utilisateurs'] as &$user) {
			if ($user['login'] === $utilisateur['login']) {
				$user['email'] = $valeurs['email'];
				$user['informations']['naissance'] = $valeurs['naissance'];
				$user['informations']['nom'] = $valeurs['nom'];
				$utilisateur=$user;
				break;
			}
		}
		// Sauvegarder les modifications dans le fichier JSON
		file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));
	}
}

?>

<?php include 'vues/recherche.php' ;?>

				<section class="section-profil bg-clair">
					<div class="conteneur">
	
							<!-- Informations utilisateur -->
							<div class="carte-profil">
								<h2>Informations personnelles</h2>
						
								<!-- Affichage normal -->
								<div class="infos-utilisateur" id="infos-actuelles">
										<p><strong>Nom : </strong><?php echo $utilisateur['informations']['nom']; ?></p>
										<p><strong>Login : </strong><?php echo $utilisateur['login']; ?></p>
										<p><strong>Email : </strong><?php echo $utilisateur['email']; ?></p>
										<p><strong>Date de naissance : </strong><?php echo $utilisateur['informations']['naissance']; ?></p>
										<p><strong>Adresse :</strong><?php echo $utilisateur['informations']['adresse']; ?></p>
										<button class="btn btn-template btn-small" onclick="afficherForm()">Modifier mes informations</button>
								</div>
						
								<!-- Formulaire de modification (caché au départ) -->
								<form class="form-modification" id="form-modif" style="display: none;" method="POST">
										<label for="nom">Nom</label>
										<input type="text" id="nom" name="nom" value="<?php echo $utilisateur['informations']['nom']; ?>" required />
						
										<label for="email">Email</label>
										<input type="email" id="email" name="email" value="<?php echo $utilisateur['email']; ?>" required />
										<?php if(isset($email_existe) && $email_existe){ ?>
											<div class="alert alert-danger">
												❌ Cette adresse email est déjà utilisée
											</div>
										<?php } ?>
						
										<label for="naissance">Date de naissance</label>
										<input type="date" id="naissance" name="naissance" value="<?php echo $utilisateur['informations']['naissance']; ?>" required />
						
										<label for="adresse">Adresse</label>
										<input type="text" id="adresse" name="adresse" value="<?php echo $utilisateur['informations']['adresse']; ?>" required />
						
										<button type="submit" class="btn btn-success btn-large">💾 Enregistrer</button>
										<button type="button" class="btn btn-danger btn-small" onclick="afficherForm()">✖ Annuler</button>
								</form>
						</div>
	
							<!-- Voyages réservés -->
							<div class="carte-profil">
									<h2>Mes voyages réservés</h2>

									<div class="voyages-reserves">
										<?php foreach($voyages as $voyage){ ?>
											<div class="voyage-reserve">
												<h3><?php echo $voyage['titre']; ?></h3>
												<p>📅 Du <?php echo $voyage['dates']['debut']; ?> au <?php echo $voyage['dates']['fin']; ?> – <?php echo $voyage['dates']['duree']; ?> jours</p>
												<p>💰 Prix de base : <strong><?php echo $voyage['prix_total']; ?> &euro;</strong></p>
											</div>
										<?php } ?>
									</div>
							</div>
	
					</div>
			</section>
			
<?php include 'vues/pied.php' ;?>
