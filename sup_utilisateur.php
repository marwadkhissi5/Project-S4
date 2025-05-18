<?php 
session_start();
header("Content-Type: application/json"); // Renvoie un fichier json ???
include("includes/fcts_donnees.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        SupprimerUtilisateur($_POST['login']);
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

