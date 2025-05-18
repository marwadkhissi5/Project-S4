<?php 
    $fichier = 'donnees/bd.json';
    $donnees = file_get_contents($fichier);
    $bd = json_decode($donnees, true);
    $nb_par_page=10;
    

    function rechercher_voyage($id){
        global $bd;
        $res=array_filter($bd['voyages'], fn($v) => $v['id'] == $id);
        $voyage = array_values($res)[0] ?? null;
        return $voyage;
    }

    function rechercher_utilisateur($login){
        global $bd;
        $res=array_filter($bd['utilisateurs'], fn($v) => $v['login'] == $login);
        $utilisateur = array_values($res)[0] ?? null;
        return $utilisateur;
    }

    function rechercher_email($email){
        global $bd;
        $res=array_filter($bd['utilisateurs'], fn($v) => $v['email'] == $email);
        $utilisateur = array_values($res)[0] ?? null;
        return $utilisateur;
    }

    function rechercher_etape($id){
        global $bd;
        $res=array_filter($bd['etapes'], fn($v) => $v['id'] == $id);
        $etape = array_values($res)[0] ?? null;
        return $etape;
    }

    function rechercher_option($id){
        global $bd;
        $res=array_filter($bd['options'], fn($v) => $v['id'] == $id);
        $option = array_values($res)[0] ?? null;
        return $option;
    }

    function Mieux_consultes(){
        global $bd;
        $utilisateurs= $bd['utilisateurs'];
        $consultes=[];
        foreach ($utilisateurs as $utilisateur) {
            foreach ($utilisateur['voyages']['consultes'] as $vg) {
                if (isset($consultes[$vg])){
                    $consultes[$vg]++;
                }
                else{
                    $consultes[$vg]=1;
                }
            }
        }
        arsort($consultes);
        
        $mieuxconsultes=[];
        foreach ($consultes as $id => $nb) {
            $mieuxconsultes[]=rechercher_voyage($id);
        }
        return $mieuxconsultes;
    }

    function liste_etapes($liste){
        global $bd;
        $res=[];
        foreach ($liste as $id) {
            $etape=rechercher_etape($id);
            if (isset($etape)){
                $res[]=$etape;
            }
        }
        return $res;
    }

    function liste_options($liste){
        global $bd;
        $res=[];
        foreach ($liste as $id) {
            $option=rechercher_option($id);
            if (isset($option)){
                $res[]=$option;
            }
        }
        return $res;
    }

    function liste_voyages($liste){
        global $bd;
        $res=[];
        foreach ($liste as $id) {
            $voyage=rechercher_voyage($id);
            if (isset($voyage)){
                $res[]=$voyage;
            }
        }
        return $res;
    }

    function Connexion($login, $mdp){
        global $bd; 
        $utilisateurs=$bd["utilisateurs"];
        $res=array_filter($bd['utilisateurs'], fn($utilisateur) => ($utilisateur['login'] === $login || $utilisateur['email'] === $login) && $utilisateur['mot_de_passe'] === $mdp);
        $utilisateur = array_values($res)[0] ?? null;
        return $utilisateur;
      }


    function SupprimerUtilisateur($login){
        global $bd, $fichier;
        $res=array_filter($bd['utilisateurs'], fn($v) => $v['login'] != $login);
        $bd['utilisateurs']=$res;
        file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));
    }

    function voyage_consulte($vg, $utilisateur){
        global $bd, $fichier;
        foreach ($bd['utilisateurs'] as &$user) {
            if ($user['login']==$utilisateur['login']){
                if (!in_array($vg, $user['voyages']['consultes'])) {
                    $user['voyages']['consultes'][]=$vg;
                    $_SESSION['utilisateur']=$user;
                }
                break;
            }
        }
        file_put_contents($fichier, json_encode($bd, JSON_PRETTY_PRINT));
    }
?>