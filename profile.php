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

?>

<?php include 'vues/recherche.php' ;?>

				<section class="section-profil bg-clair">
					<div class="conteneur">
	
							<!-- Informations utilisateur -->
							<div class="carte-profil">
								<h2>Informations personnelles</h2>
						
								<!-- Affichage normal -->
								<div class="infos-utilisateur" id="infos-actuelles">
										<p><strong>Nom : </strong><span id="label_nom"><?php echo $utilisateur['informations']['nom']; ?></span></p>
										<p><strong>Login : </strong><?php echo $utilisateur['login']; ?></p>
										<p><strong>Email : </strong><span id="label_email"><?php echo $utilisateur['email']; ?></span></p>
										<p><strong>Date de naissance : </strong><span id="label_naissance"><?php echo $utilisateur['informations']['naissance']; ?></span></p>
										<p><strong>Adresse :</strong><span id="label_adresse"><?php echo $utilisateur['informations']['adresse']; ?></span></p>
										<button class="btn btn-template btn-small" onclick="afficherForm()">Modifier mes informations</button>
								</div>
						
								<!-- Formulaire de modification (caché au départ) -->
								<form class="form-modification" id="form-modif" style="display: none;" method="POST">
									<input type="hidden" id="login" value="<?php echo $utilisateur['login']; ?>"/>
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
										<?php foreach($utilisateur['voyages']['achetes'] as $reservation){ 
												$voyage=rechercher_voyage($reservation[0]);
											?>
											<div class="voyage-reserve">
												<h3><?php echo $voyage['titre']; ?></h3>
												<p>📅 Du <?php echo $voyage['dates']['debut']; ?> au <?php echo $voyage['dates']['fin']; ?> – <?php echo $voyage['dates']['duree']; ?> jours</p>
												<p>Nombre de personnes : <strong><?php echo $reservation[3]; ?></strong></p>
												<p>💰 Prix total : <strong><?php echo $reservation[2]; ?> &euro;</strong></p>
											</div>
										<?php } ?>
									</div>
							</div>
	
					</div>
			</section>
			
<?php include 'vues/pied.php' ;?>