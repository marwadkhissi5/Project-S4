<?php 
session_start();
$erreur = '';
$valeurs = [
    'nom' => '',
    'naissance' => '',
    'login' => '',
    'email' => '',
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fichier = 'donnees/bd.json';
    $donnees = file_get_contents($fichier);
    $bd = json_decode($donnees, true);

    $utilisateurs = $bd['utilisateurs'];

    $valeurs = [
        'nom' => $_POST['nom'],
        'naissance' => $_POST['naissance'],
    
        'login' => $_POST['login'],
        'email' => $_POST['email'],
    ];

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        $erreur = 'Les mots de passe ne correspondent pas.';
    } else {
        $login_existe = false;
        $email_existe = false;

        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['login'] === $valeurs['login']) {
                $login_existe = true;
            }
            if ($utilisateur['email'] === $valeurs['email']) {
                $email_existe = true;
            }
        }

        if ($login_existe) {
            $erreur = "Ce nom d'utilisateur est déjà pris.";
        } elseif ($email_existe) {
            $erreur = 'Cet email est déjà utilisé.';
        } else {
            $nv_utilisateur = [
                'login' => $valeurs['login'],
                'mot_de_passe' => $password, 
                'role' => 'normal', 
                'email' => $valeurs['email'],
                'informations' => [
                    'nom' => $valeurs['nom'],
                    'naissance' => $valeurs['naissance'],
                  
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

<?php $titre="Inscription "; ?>
<?php include 'vues/entete.php'; ?>
<link rel="stylesheet" type="text/css" href="style.css">
<div class="container">
	<div class="rightbox">
		<div class="Profil">
		<?php if ($erreur) {?>
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">Erreur d'inscription</h4>
                                <p>
                                    <?php echo $erreur;?>
                                </p>
                            </div>
                            <?php }?>
		<form id="form-inscription" method="POST">
                                <!-- Informations de base -->
                                
									<label for="nom" class="form-label">Nom</label>
									<input type="text" class="form-control" name="nom" value="<?php echo $valeurs['nom']; ?>" id="nom" placeholder="Entrez votre nom" required>
										
                               
                                  
                                        <label for="naissance" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" name="naissance" id="naissance" required>
                                  
                                
                                
                                    <label for="login" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" name="login" value="<?php echo $valeurs['login']; ?>" id="login" placeholder="Entrez votre nom d'utilisateur" required>
                                
                                    <label for="email" class="form-label">Adresse email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $valeurs['email']; ?>" id="email" placeholder="Entrez votre email" required>
                              
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                           
                                    <label for="confirm-password" class="form-label">Confirmez le mot de passe</label>
                                    <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirmez votre mot de passe" required>
                              

                                <!-- Bouton d'inscription -->
                                
                                <input type="submit" value="S'inscrire">
                             

                                <!-- Lien de connexion -->
                                <div class="other">
                                    <p class="mb-0">Déjà un compte ? <a href="connexion.php" class="text-danger">Se connecter</a></p>
                                </div>
                            </form>
		</div>
	</div>
</div>



<?php include "vues/pied.php" ?>
