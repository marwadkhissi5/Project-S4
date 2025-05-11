<section class="barre-recherche bg-gris">
    <form method="POST" action="recherche.php">
    <div class="conteneur">
            <input name="destination" type="text" placeholder="Destination" class="champ-recherche" />
            <input name="budget_max" type="number" placeholder="Budget max (Euros)" class="champ-recherche" min="0" />
            <input name="date_debut" type="date" class="champ-recherche" />
            <select name="nb_jours" class="champ-recherche">
                <option value="">Nombre de jours</option>
                <option value="1">1–3 jours</option>
                <option value="2">4–7 jours</option>
                <option value="3">8–14 jours</option>
                <option value="4">15+ jours</option>
            </select>
            <button class="btn btn-template">Rechercher</button>
    </div>
    </form>
</section>