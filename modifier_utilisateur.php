<?php 

  session_start();
  include 'includes/fcts_donnees.php';
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = ['modifier_utilisateur.js'];
  $erreurs=[];

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header("Location: connexion.php");
}

$utilisateurs=$bd['utilisateurs'];
$utilisateur= null;

if (isset($_GET["id"])){
  foreach ($utilisateurs as $user) {
      if (($user['login'] ===$_GET["id"])) {
          $utilisateur = $user;
          break;
      }
  }
}
else{
    header("Location: admin.php");
}
?>

<?php $titre="Administrateur"; ?>

<section>
<div class="conteneur">
    <h2 class="title">Utilisateur : <?php echo $utilisateur['login']; ?></h2>
    <div class="form-grid">
        <form id="modifierf" enctype="multipart/form-data" method="post">
            <input type="hidden" id="login" value="<?php echo $utilisateur['login']; ?>"/>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo ($utilisateur['informations']['nom']); ?>"/>
        <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo ($utilisateur['email']); ?>"/>
        <br>
            <label for="naissance">Date de naissance:</label>
            <input type="date" id="naissance" name="naissance" value="<?php echo ($utilisateur['informations']['naissance']); ?>"/>
        <br>
            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" value="<?php echo ($utilisateur['informations']['adresse']); ?>"/>
        <br>
            <div class="form-actions">
                <div class="timer" id="timer">Temps écoulé: 0 s</div>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                <a href="admin.php" class="btn btn-danger">Annuler</a>
            </div>
            <br>
        </form>
    </div>
</div>
</section>

<?php include "vues/pied.php" ?>
