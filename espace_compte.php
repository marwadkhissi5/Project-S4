<?php 
$titre="espace_compte"; 
session_start();

$erreur = '';
$valeurs = [
    'nom' => '',
    'naissance' => '',
    'login' => '',
    'email' => '',
    'age' => ''
];


if (isset($_SESSION['login'])) {

    $fichier = 'donnees/bd.json';
    $donnees = file_get_contents($fichier);
    $bd = json_decode($donnees, true);

    $utilisateur = null;

    foreach ($bd['utilisateurs'] as $user) {
        if ($user['login'] === $login_utilisateur) {
            $utilisateur = $user;
            break;
        }
    }


    if ($utilisateur) {
        $valeurs = [
            'nom' => $utilisateur['informations']['nom'],
            'naissance' => $utilisateur['informations']['naissance'],
            'login' => $utilisateur['login'],
            'email' => $utilisateur['email'],
            'age' => $utilisateur['informations']['age'] ?? '' // Ajouter une valeur pour l'âge si elle existe
        ];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs soumises
    $valeurs = [
        'nom' => $_POST['nom'],
        'naissance' => $_POST['naissance'],
        'login' => $_POST['login'],
        'email' => $_POST['email'],
        'age' => $_POST['age'],
    ];

    $password = $_POST['password'];

    // Vérification de l'existence du login et de l'email
    $login_existe = false;
    $email_existe = false;

    foreach ($bd['utilisateurs'] as $utilisateur) {
        if ($utilisateur['login'] === $valeurs['login'] && $utilisateur['login'] !== $_SESSION['login']) {
            $login_existe = true;
        }
        if ($utilisateur['email'] === $valeurs['email'] && $utilisateur['email'] !== $_SESSION['email']) {
            $email_existe = true;
        }
    }

    // Afficher un message d'erreur si le login ou l'email existe déjà
    if ($login_existe) {
        $erreur = "Ce nom d'utilisateur est déjà pris.";
    } elseif ($email_existe) {
        $erreur = 'Cet email est déjà utilisé.';
    } else {
        // Créer un tableau avec les données modifiées
        $modif_utilisateur = [
            'login' => $valeurs['login'],
            'mot_de_passe' => $password, // Vous pouvez utiliser password_hash pour sécuriser le mot de passe
            'role' => 'normal', 
            'email' => $valeurs['email'],
            'informations' => [
                'nom' => $valeurs['nom'],
                'naissance' => $valeurs['naissance'],
                'age' => $valeurs['age'],
            ],
        ];

        // Mettre à jour l'utilisateur dans le tableau
        foreach ($bd['utilisateurs'] as &$utilisateur) {
            if ($utilisateur['login'] === $_SESSION['login']) {
                $utilisateur = $modif_utilisateur;
                break;
            }
        }

        // Sauvegarder les modifications dans le fichier JSON
        file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));

        // Mettre à jour la session avec les nouvelles informations
        $_SESSION['login'] = $valeurs['login'];
        $_SESSION['email'] = $valeurs['email'];

        // Rediriger vers la page de profil ou une autre page après la mise à jour
        header('Location: esconnexion.php?success=1');
        exit();
    }
}
?>

<?php include 'vues/entete.php'; ?>
<link rel="stylesheet" type="text/css" href="style.css">
<div class="container">
    <div class="rightbox">
        <div class="Profil">
            <form enctype="multipart/form-data" method="post">
                <h1>Profil - Mon Compte</h1>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo ($valeurs['nom']); ?>" />

                <label for="login">Nom d'utilisateur:</label>
                <input type="text" id="login" name="login" value="<?php echo ($valeurs['login']); ?>" />

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo ($valeurs['email']); ?>">

                <label for="age">Âge:</label>
                <input type="number" name="age" min="18" max="100" value="<?php echo ($valeurs['age']); ?>" step="1">

                <label for="password">Mot de Passe :</label>
                <input type="password" id="password" name="password" value=""/>

                <input type="submit" value="Mettre à jour">
            </form>
        </div>
    </div>
</div>

<?php include "vues/pied.php" ?>
