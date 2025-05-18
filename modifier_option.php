<?php
session_start();

if (isset($_POST['index']) && isset($_POST['option'])) {
    $index = intval($_POST['index']);
    $option = $_POST['option'];

    if (isset($_SESSION['panier'][$index])) {

        $_SESSION['panier'][$index]['prix'];
        $_SESSION['panier'][$index]['options'][] = $option;
        echo "Option ajoutée avec succès !";
        
    } else {
        echo "Erreur : option ou index invalide.";
    }
} else {
    echo "Requête invalide.";
}
?>
