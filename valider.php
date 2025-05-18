<?php
    session_start();
    include 'includes/fcts_donnees.php';
    if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['panier'])){
        header("Location: voyages.php");
    }
    
    if(isset($_GET['status']) && $_GET['status']=='accepted'){
        foreach ($bd['utilisateurs'] as &$user) {
            if ($user['login']==$_SESSION['utilisateur']['login']){
                foreach ($_SESSION['panier'] as $res) {
                    $ids_options = array_map(function($option) {
                        return $option['id'];
                    }, $res['options']);
                    $user['voyages']['achetes'][]=[$res['voyage']['id'], $ids_options, $res['prix'], $res['nbpersonnes']];
                }
                $_SESSION['utilisateur']=$user;
            }
        }
        file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));
        header('Location: profile.php');
    }
    else{
        header('Location: voyages.php');
    }
?>