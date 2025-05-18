const b_prix = document.getElementById("total_prix");
const b_checked = document.querySelectorAll("input[name='options[]']"); 
const b_personne = document.getElementById("nb_personnes");

function updateOptions(options) {
  if (options.length > 0) {
    $("#liste-options").html("");
    $.each(options, function (index, opt) {
      $("#liste-options").append("<li>" + opt.titre + "</li>");
    });
  }
}
$(document).ready(function () {
  b_checked.forEach((box) => {
    box.addEventListener("change", function () {
      let id = $("#voyage").val(); //id voyage
      let opt = $(this).data("id"); //id option
      let nbp = $("#nb_personnes").val(); // id nb personnes
      if (this.checked) { // Si option choisie
        $.ajax({
          url: "demandes.php",
          type: "POST",
          dataType: "json",
          data: {
            type: 1,
            voyage: id,
            option: opt,
            nbpersonnes: nbp,
          },
          success: function (reponse) { // Reçoit une reponse valide
            if (reponse.etat == "ok") {
              $("#total_prix").html(reponse.reservation.prix + " &euro;"); // Mets à jour le prix
              updateOptions(reponse.reservation.options); // Mets à jour les options
            } else {
              alert("Erreur d'ajout");
            }
          },
        });
      } else { // Si option supprimée
        $.ajax({
          url: "demandes.php",
          type: "POST",
          dataType: "json",
          data: {
            type: 2, // Supprimer l'option
            voyage: id,
            option: opt,
            nbpersonnes: nbp,
          },
          success: function (reponse) { 
            if (reponse.etat == "ok") {
              $("#total_prix").html(reponse.reservation.prix + " &euro;"); // Mets à jour le prix
              updateOptions(reponse.reservation.options); // Mets à jour les options
            } else {
              alert("Erreur de suppression");
            }
          },
        });
      }
    });
  });

  b_personne.addEventListener("input", function () { // Changement du nb de personnes
    let nbp = $(this).val();
    let id = $("#voyage").val();
    $("#nb_p").val(nbp); 
    $.ajax({
      url: "demandes.php",
      type: "POST",
      dataType: "json",
      data: {
        type: 4, // Changer le nb de personnes
        voyage: id,
        nbpersonnes: nbp,
      },
      success: function (reponse) {
        if (reponse.etat == "ok") {
          $("#total_prix").html(reponse.reservation.prix + " &euro;");
        } else {
          alert("Erreur de mise à jour");
        }
      },
    });
  });
});
