$(document).ready(function () {
  $(".btn-supp").on("click", function () {
    let id = $(this).data("id");
    let rep = confirm("Êtes-vous sûr de supprimer la reservation");
    if (rep) {
      $.ajax({
        url: "demandes.php",
        type: "POST",
        dataType: "json",
        data: {
          type: 3,
          voyage: id,
        },
        success: function (reponse) {
          if (reponse.etat == "ok") {
            let prix_f = parseFloat($(".prix-total").html()) - reponse.prix;
            if (prix_f == 0) {
              $(".btn-valider").hide();
            }
            $(".prix-total").html(prix_f);
            $("#res-" + id).remove();
          }
        },
      });
    }
  });
});
