<?php 
session_start();
include "includes/fcts_donnees.php";
header("Content-Type: application/json");


function CalculerPrix(&$reservation){ // Calculer le prix de la réservation
    $prix_base=$reservation['voyage']['prix_total'] * $reservation['nbpersonnes'];
    $prix_options=0;
    foreach($reservation['options'] as $option) {
        $nbsup=max(0, $reservation['nbpersonnes']-$option['nombre_personnes']);
        $prix_options+=$nbsup*$option['prix_par_personne']+$option['prix_par_personne'];
    }
    $prix_base+=$prix_options;
    $reservation['prix']=$prix_base; 
}

function AjouterOption($vg_id,$opt_id, $nbp){ 
    if(isset($_SESSION['panier'])){
        foreach($_SESSION['panier'] as &$res){
            if($res['voyage']['id']==$vg_id){
                foreach ($res['options'] as $opt){
                    if($opt_id==$opt['id']){
                        return;
                    }
                }
                $option=rechercher_option($opt_id); // Récupère les détails de l'option
                if($option){
                    $res['options'][]=$option; // Ajouter l'option dans les options de la réservation
                    CalculerPrix($res);
                    Reponse($res);
                    return;
                }
                $res['nbpersonnes']=$nbp; // Mettre à jour le nombre de personnes dans la réservation
            }
        }
    }
}

function SupprimerOption($vg_id, $opt_id, $nbp){
    if(isset($_SESSION['panier'])){
        foreach($_SESSION['panier'] as &$res){
            if($res['voyage']['id']==$vg_id){
                foreach ($res['options'] as $indice => $option){
                    if($opt_id==$option['id']){
                        unset($res['options'][$indice]); // Supprimer l'option de la réservation
                        $res['options']=array_values($res['options']);
                        CalculerPrix($res);
                        Reponse($res);
                        return;
                    }
                }
                $res['nbpersonnes']=$nbp;
            }

        }
    }
}

function UpdateNBPersonnes($vg_id, $nbp){ 
    if(isset($_SESSION['panier'])){
        foreach($_SESSION['panier'] as &$res){
            if($res['voyage']['id']==$vg_id){
                $res['nbpersonnes']=$nbp;
                CalculerPrix($res);
                Reponse($res);
                return;
            }
        }
    }
}

function SupprimerReservation($res_id){
    if(isset($_SESSION['panier'])){
        foreach($_SESSION['panier'] as $indice =>$res){
            if($res['voyage']['id']==$res_id){
                $prix=$res['prix'];
                unset($_SESSION['panier'][$indice]); // Supprimer la réservation du panier
                $_SESSION['panier']=array_values($_SESSION['panier']);
                echo json_encode([ // Retourne la réponse au client
                    "etat"=>"ok",
                    'prix'=> $prix,
                ]);
                return;
            }
        }
    }
    echo json_encode([
        "etat"=>"erreur"
    ]);
}

function Reponse($res){ // La réponse après l'ajout et la suppression d'options et màj du nb de personne
    echo json_encode([
        "etat"=>"ok",
        "reservation"=>$res
    ]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['type'])){
        switch($_POST['type']) {
            case '1':
                AjouterOption($_POST['voyage'],$_POST['option'],$_POST['nbpersonnes']);
                break;
            case '2':
                SupprimerOption($_POST['voyage'],$_POST['option'],$_POST['nbpersonnes']);
                break;
            case '3':
                SupprimerReservation($_POST['voyage']);
                break;
            case '4':
                UpdateNBPersonnes($_POST['voyage'],$_POST['nbpersonnes']);
                break;
            default :
                echo json_encode([
                    "etat"=>"ok"
                ]);
                break;
        }
    }
} 
?>