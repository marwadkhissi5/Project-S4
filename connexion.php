<?php 
session_start();
$login = null;
$mot_de_passe = null;
$erreur = false;

function Connexion($login, $mdp, $utilisateurs){
  $utilisateur_connecte = null;
  foreach ($utilisateurs as $utilisateur) {
      if (($utilisateur['login'] === $login || $utilisateur['email'] === $login) && $utilisateur['mot_de_passe'] === $mdp) {
          $utilisateur_connecte = $utilisateur;
          break;
      }
  }
  return $utilisateur_connecte;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fichier = 'donnees/bd.json';
    $donnees = file_get_contents($fichier);
    $utilisateurs = json_decode($donnees, true)['utilisateurs'];

    if (isset($_POST['login']) && isset($_POST['password'])){
        $login = $_POST['login'];
        $mot_de_passe = $_POST['password'];
        
        $utilisateur_connecte=Connexion($login, $mot_de_passe, $utilisateurs);
        if ($utilisateur_connecte) {
            $_SESSION['utilisateur'] = $utilisateur_connecte;
            if($utilisateur_connecte['role']=='admin'){
                header('Location: admin.php');
            }
            else{
                header('Location: espace_compte.php');
            }
        } else {
            $erreur = true;
        }
    }
}
?>
<?php $titre="Authentification "; ?>
<?php include "vues/entete.php" ?>
<link rel="stylesheet" type="text/css" href="css/form.css">

<section class="bg-fairy">
    <div class="container">
        <div class="form-grid">
          <form class="form" method="POST">
            <h2 class="form-title">Connexion</h2>
            <div>
              <?php if ($erreur) {?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Erreur d'authentification</h4>
                    <p>
                        Le nom d'utilisateur ou le mot de passe incorrect.
                    </p>
                </div>
              <?php }?>
            </div>
            <div class="form-group">
              <label for="titre">Nom d'utilisateur ou Email :</label>
              <input type="text" id="email" name="login" value="<?php echo $login; ?>"/>
            </div>

            <div class="form-group">
              <label for="titre">Mot de Passe :</label>
              <input type="password" id="password" name="password" value=""/>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn primary">Se connecter</button>
            </div>

            <div class="form-group">
              Toujours pas inscrite ?
              <a href="inscription.php">Inscrivez-vous</a>
            </div>
          </form>
        </div>
    </div>
</section>
<?php include "vues/pied.php" ?>
