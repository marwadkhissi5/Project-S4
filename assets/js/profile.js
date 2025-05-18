function afficherForm() {
  const infos = document.getElementById("infos-actuelles");
  const form = document.getElementById("form-modif");
  const isHidden = form.style.display === "none";

  infos.style.display = isHidden ? "none" : "block";
  form.style.display = isHidden ? "block" : "none";
}

$(document).ready(function(){
  $("#form-modif").submit(function(event){  // L'évenement submit est declenché
    event.preventDefault(); // Désactive l'envoi du formulaire par défaut
    let donnees={ // Récupération des données
      nom: $("#nom").val(),
      login: $("#login").val(),
      email: $("#email").val(),
      naissance: $("#naissance").val(),
      adresse: $("#adresse").val()
    };
    $.ajax({ // Renvoie les données avec méthode ajax
      url: "maj_profil.php",
      type: "POST",
      data: donnees,
      dataType: "json",
      success: function(reponse){
        if(reponse.etat=='ok'){
          afficherForm();
          $("#label_nom").html(donnees['nom']); // Modifie la balise html
          $("#label_email").html(donnees['email']);
          $("#label_adresse").html(donnees['adresse']);
          $("#label_naissance").html(donnees['naissance']); 
          alert("La mise à jour a été effectuée avec succès");
        }
        else{
          alert("Erreur de mise à jour");
        }
      }
    })
  })
})