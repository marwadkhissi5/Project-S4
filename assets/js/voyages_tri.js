document.addEventListener("DOMContentLoaded", function () {
  const boutons = document.querySelectorAll(".btn-tri");
  const conteneur = document.getElementById("liste_voyages");
  const voyagesOriginaux = Array.from(document.querySelectorAll(".carte-voyage-detaillee"));
  let dernierCritere = null;

  function getValeur(carte, critere) {
    if (critere === "date") {
      const dateTexte = carte.querySelector(".info-item:nth-child(1)").textContent;
      const match = dateTexte.match(/Du\s+(\d{4}-\d{2}-\d{2})/);
      return match ? new Date(match[1]).getTime() : 0;
    }

    if (critere === "prix") {
      const prixTexte = carte.querySelector(".info-item:nth-child(3)").textContent;
      return parseFloat(prixTexte.replace(/[^\d.]/g, ""));
    }

    if (critere === "duree") {
      const dureeTexte = carte.querySelector(".info-item:nth-child(1)").textContent;
      const match = dureeTexte.match(/–\s*(\d+)/);
      return match ? parseInt(match[1]) : 0;
    }

    return 0;
  }

  boutons.forEach(btn => {
    btn.addEventListener("click", function () {
      const critere = this.getAttribute("data-tri");
      if (critere === dernierCritere) return;

      dernierCritere = critere;

      const voyages = voyagesOriginaux.slice();
      voyages.sort((a, b) => getValeur(a, critere) - getValeur(b, critere));
      voyages.forEach(v => conteneur.appendChild(v));

      boutons.forEach(b => b.classList.remove("active"));
      this.classList.add("active");
    });
  });
});