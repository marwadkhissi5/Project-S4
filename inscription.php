<?php 
  session_start();
  include 'includes/fcts_donnees.php';
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = ['inscription.js'];
  $erreurs=[];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $utilisateurs = $bd['utilisateurs'];

    $valeurs = [
        'nom' => $_POST['nom'],
        'login' => $_POST['login'],
        'email' => $_POST['email'],
        'naissance' => $_POST['naissance'],
        'mdp1' => $_POST['mot_de_passe1'],
        'mdp2' => $_POST['mot_de_passe2'],
        'adresse' => $_POST['adresse'],
    ];

    if ($valeurs['mdp1'] !== $valeurs['mdp2']) {
        $erreurs['mdp'] ='Les mots de passe ne correspondent pas.';
    } else {

        $user=rechercher_email($valeurs['email']);
        if($user){
          $erreurs['email'] = "Champ vide ou adresse email déjà prise.";
        }

        $user=rechercher_utilisateur($valeurs['login']);
        if($user){
          $erreurs['login'] = "Champ vide ou nom d'utilisateur déjà pris.";
        }

        if(!isset($valeurs['nom'])){
          $erreurs['nom'] = "Ce champ est obligatoire";
        }
        if(!isset($valeurs['naissance'])){
          $erreurs['naissance'] = "Ce champ est obligatoire";
        }

        if(!isset($valeurs['mdp1'])){
          $erreurs['mdp1'] = "Ce champ est obligatoire";
        }

        if(!isset($valeurs['mdp2'])){
          $erreurs['mdp2'] = "Ce champ est obligatoire";
        }

        if(!isset($valeurs['adresse'])){
          $erreurs['adresse'] = "Ce champ est obligatoire";
        }
        if(empty($erreurs)){
            $nv_utilisateur = [
                'login' => $valeurs['login'],
                'mot_de_passe' => $valeurs['mdp1'], 
                'role' => 'normal', 
                'email' => $valeurs['email'],
                'informations' => [
                    'nom' => $valeurs['nom'],
                    'naissance' => $valeurs['naissance'],
                    'adresse' => $valeurs['adresse'],
                ],
                'dates' => [
                    'inscription' => date('d-m-Y'), 
                    'derniere_connexion' => null, 
                ],
                'voyages' => [
                    'consultes' => [], 
                    'achetes' => [], 
                ],
            ];

            $bd['utilisateurs'][] = $nv_utilisateur;
            file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));
            header('Location: connexion.php?success=1');
            exit();
        }
    }
}

?>

<?php include 'vues/recherche.php' ;?>

    <div class="section-inscription bg-clair">
      <div class="carte-inscription">
        <h2>Créer un compte</h2>
        <form class="form-inscription" method="POST">
          <label for="login">Nom d'utilisateur</label>
          <input
            type="text"
            id="login"
            name="login"
            maxlength="12"
            placeholder="Nom d'utilisateur"
            required
          />
          <span id="cpt_nom"></span>
          <?php if(isset($erreurs['login'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['login'];?>
            </div>
          <?php } ?>

          <label for="email">Adresse e-mail</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="nom@gmail.com"
            required
          />
          <?php if(isset($erreurs['email'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['email'];?>
            </div>
          <?php } ?>

          <label for="nom">Nom complet</label>
          <input
            type="text"
            id="nom"
            name="nom"
            placeholder="Nom"
            required
          />
          <?php if(isset($erreurs['nom'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['nom'];?>
            </div>
          <?php } ?>

          <label for="naissance">Date de naissance</label>
          <input type="date" id="naissance" name="naissance" required />
          <?php if(isset($erreurs['naissance'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['naissance'];?>
            </div>
          <?php } ?>

          <label for="adresse">Adresse</label>
          <input
            type="text"
            id="adresse"
            name="adresse"
            placeholder="123 Rue Principale, Paris"
            required
          />
          <?php if(isset($erreurs['adresse'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['adresse'];?>
            </div>
          <?php } ?>

          <label for="password">Mot de passe</label>
          <input
            type="password"
            id="password1"
            name="mot_de_passe1"
            placeholder="••••••••"
            required
          />
          <?php if(isset($erreurs['mdp1'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['mdp1'];?>
            </div>
          <?php } ?>
          <label for="password">Confirmer le mot de passe</label>
          <input
            type="password"
            id="password2"
            name="mot_de_passe2"
            placeholder="••••••••"
            required
          />
          <?php if(isset($erreurs['mdp2'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['mdp2'];?>
            </div>
          <?php } ?>

          <?php if(isset($erreurs['mdp'])){ ?>
            <div class="alert alert-danger">
              ❌ <?php echo $erreurs['mdp'];?>
            </div>
          <?php } ?>

          <button type="submit" class="btn btn-template btn-large">
            Créer mon compte
          </button>
        </form>

        <p class="texte-connexion">
          Déjà inscrit ? <a href="connexion.php">Se connecter</a>
        </p>
      </div>
    </div>
<?php include 'vues/pied.php' ;?>
