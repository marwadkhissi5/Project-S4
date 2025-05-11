<?php 
	session_start();
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = ['connexion.js'];
?>

<?php include 'vues/recherche.php' ;?>
<?php 

include 'includes/fcts_donnees.php';

$login=null;
$erreur = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['login']) && isset($_POST['password'])){
        $login=$_POST['login'];
        $utilisateur_connecte=Connexion($_POST['login'], $_POST['password']);
        if ($utilisateur_connecte) {
            $_SESSION['utilisateur'] = $utilisateur_connecte;
            if($utilisateur_connecte['role']=='admin'){
                header('Location: admin.php');
            }
            else{
                header('Location: profile.php');
            }
        } else {
            $erreur = true;
        }
    }
}
?>
<?php $titre="Authentification "; ?>
	<div class="section-login bg-clair">
		<div class="carte-login">
			<h2>Connexion</h2>
			<form class="form-login" method="POST">

				<?php if (isset($_GET['success'])) {?>
					<div class="alert alert-primary">
						✅ L'inscription a été effectuée avec succès !
					</div>
				<?php }?>

				<?php if ($erreur) {?>
					<div class="alert alert-danger" role="alert">
						<p>
							Le nom d'utilisateur ou le mot de passe incorrect.
						</p>
					</div>
				<?php }?>
				<label for="email">Nom d'utilisateur ou adresse e-mail</label>
				<input type="text" id="email" name="login" placeholder="exemple@email.com" required value="<?php echo $login; ?>" />
				<span id="email_erreur"></span>

				<label for="password">Mot de passe</label>
				<input type="password" id="password" name="password" placeholder="••••••••" required value=""/>
				<input type="checkbox" id="afficher_p">Afficher mot de passe
              	<span id="password_erreur"></span>

				<button type="submit" class="btn btn-template btn-large">
					Se connecter
				</button>
			</form>
			<p class="texte-connexion">
				Pas encore de compte ? <a href="inscription.php">Créer un compte</a>
			</p>
		</div>
	</div>

<?php include 'vues/pied.php' ;?>
