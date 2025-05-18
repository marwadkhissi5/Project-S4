$(document).ready(function(){
    $("#modifierf").submit(function(event){  // L'évenement submit est declenché
        event.preventDefault();
        $("#timer").text("Temps écoulé : 0s");
        let temps=0;
        let intervalle=setInterval(function(){
            temps++;
            $("#timer").text("Temps écoulé :"+temps+"s");
        },1000);
        document.querySelectorAll("input,select,textarea,button").forEach(function(champ){
            champ.disabled=true;
        });
        let donnees={ // Récupération des données
            login: $("#login").val(),
            nom: $("#nom").val(),
            email: $("#email").val(),
            naissance: $("#naissance").val(),
            adresse: $("#adresse").val()
          };
          $.ajax({ // Renvoie les données avec méthode ajax
            url: "maj_profil.php",
            type: "POST",
            data: donnees,
            dataType: "json",
            success: function(reponse){ //Reçoit une réponse valide
              if(reponse.etat=='ok'){
                
                alert("La mise à jour a été effectuée avec succès");
              }
              else{
                alert("Erreur de mise à jour");
              }
            },
            complete: function(){ // Communication avec le serveur terminé
                clearInterval(intervalle);
                document.querySelectorAll("input,select,textarea,button").forEach(function(champ){
                    champ.disabled=false;
                }) 
            }
          })
    });

});