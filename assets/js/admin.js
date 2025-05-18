$(document).ready(function(){
    $(".btn-delete").click(function(){
        let reponse=confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
        if(reponse){
            let donnees={ // Récupération des données
                login: $(this).data("user"),
              };
            $.ajax({ // Renvoie les données avec méthode ajax
                url: "sup_utilisateur.php",
                type: "POST",
                data: donnees,
                dataType: "json",
                success: function(reponse){
                  if(reponse.etat=='ok'){
                    $("#"+donnees['login']).remove();
                    alert("Utilisateur supprimé avec succès");
                  }
                  else{
                    alert("Erreur de mise à jour");
                  }
                }
              })
        }
    })
});

