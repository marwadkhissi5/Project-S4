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

<section class="bg-gris">
<div class="conteneur">
    <div class="form-grid">
        <form id="modifier_f" enctype="multipart/form-data" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo ($utilisateur['informations']['nom']); ?>"/>
        <br>
            <label for="login">Nom d'utilisateur:</label>
            <input type="text" id="login" name="login" value="<?php echo ($utilisateur['login']); ?>" />
        <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo ($utilisateur['email']); ?>"/>
        <br>
            <label for="naissance">Date de naissance:</label>
            <input type="date" id="naissance" name="naissance" value="<?php echo ($utilisateur['informations']['naissance']); ?>"/>
        <br>
            <label for="password">Mot de Passe :</label>
            <input type="password" id="password" name="password" value=""/>
        <br>
            <div class="form-actions">
                <button type="submit" class="btn primary">Sauvegarder</button>
                <a href="admin.php" class="btn primary">Annuler</a>
            </div>
        </form>
    </div>
</div>
</section>

<?php include "vues/pied.php" ?>
