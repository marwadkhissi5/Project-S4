<?php 
session_start();
header("Content-Type: application/json"); // Renvoie un fichier json ???
include 'includes/fcts_donnees.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs soumises
    $valeurs = [
        'login'=>$_POST['login'], 
        'nom' => $_POST['nom'],
        'email' => $_POST['email'],
        'naissance' => $_POST['naissance'],
        'adresse' => $_POST['adresse'],
    ];

    try{ 
        $email_existe = false;

        // Vérification de l'existence du login et de l'email
        $user=rechercher_email($valeurs['email']);
        if($user && ($valeurs['login']!=$user['login'])){
            $email_existe = true;
        }
        if(!$email_existe){
            foreach ($bd['utilisateurs'] as &$user) {
                if ($user['login'] === $valeurs['login']) {
                    $user['email'] = $valeurs['email'];
                    $user['informations']['naissance'] = $valeurs['naissance'];
                    $user['informations']['nom'] = $valeurs['nom'];
                    $user['informations']['adresse'] = $valeurs['adresse'];
                    $_SESSION['utilisateur']=$user;
                    break;
                }
            }
            // Sauvegarder les modifications dans le fichier JSON
            file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));
        }
        echo json_encode([
            "etat"=>"ok"
        ]);
    }
    catch(Exception $e){
        echo json_encode([
            "etat"=>"erreur" // Execute si erreur
        ]);
    }
}

?>