<?php 
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = [];
?>

<?php include 'vues/recherche.php' ;?>

    <section class="section-contenu bg-claire">
      <div class="conteneur">
        <div class="row">
          <div class="col-9">
            <div class="conteneur">
              <h1 class="titre-principal">Mascate – Détails du voyage</h1>

              <div class="carte-voyage-detaillee">
                <div class="bloc-contenu">
                  <h3 class="titre-voyage">Mascate – Séjour oriental</h3>
                  <div class="infos-voyage">
                    <div class="info-item">
                      <span class="icon">📅</span>
                      <span
                        >Du 1 au 5 octobre 2025 – <strong>5 jours</strong></span
                      >
                    </div>
                    <div class="info-item">
                      <span class="icon">📝</span>
                      <span
                        >Visite des villes historiques et dégustation de cuisine
                        locale
                      </span>
                    </div>
                    <div class="info-item">
                      <span class="icon">💰</span>
                      <span>Prix total : <strong>699,99 MAD</strong></span>
                    </div>
                  </div>
                </div>
              </div>
              <h3 class="titre bg-template">Étapes du voyage</h3>
              <ul class="liste-etapes">
                <li>
                  <h3>Exploration de Muttrah</h3>
                  <p>📍 Muttrah, Mascate, Oman</p>
                  <p>🕓 Durée : 2 jours</p>
                  <p>🔹 Options : Visite guidée, Hébergement luxe</p>
                </li>
                <li>
                  <h3>Plongée à Bandar Khayran</h3>
                  <p>📍 Bandar Khayran, Mascate, Oman</p>
                  <p>🕓 Durée : 4 jours</p>
                  <p>🔹 Options : Visite guidée, Hébergement luxe</p>
                </li>
              </ul>

              <h3 class="titre bg-template">Choisissez vos options</h3>

              <form id="form-options" class="form-options">
                <div class="option-item">
                  <label>
                    <input
                      type="checkbox"
                      name="option"
                      data-id="1"
                      data-prix="50"
                    />
                    Visite guidée – 50 MAD / personne
                  </label>
                  <span class="option-detail">Inclut 2 personnes</span>
                </div>

                <div class="option-item">
                  <label>
                    <input
                      type="checkbox"
                      name="option"
                      data-id="2"
                      data-prix="100"
                    />
                    Hébergement luxe – 100 MAD / personne
                  </label>
                  <span class="option-detail">Inclut 1 personne</span>
                </div>
              </form>
              <br />
              <a href="#" class="btn btn-template">Réserver ce voyage</a>
            </div>
          </div>
          <aside class="col-3">
            <div class="carte-recap">
              <h3>Mascate</h3>
              <p>📅 Du 1 au 5 octobre 2025 – 5 jours</p>
              <p>💰 Prix de base : <strong>699.99 MAD</strong></p>
              <label for="nb-personnes"
                ><strong>👥 Nombre de personnes :</strong></label
              >
              <input
                type="number"
                id="nb-personnes"
                value="1"
                min="1"
                style="width: 60px; margin-left: 10px"
              />
              <hr />
              <p>🧩 Options :</p>
              <ul id="liste-options">
                <li>Pension compléte : 30 MAD / P</li>
                <li>Tickets inclus : 30 MAD / P</li>
              </ul>
              <hr />
              <p>
                <strong>Total :</strong> <span id="total-prix">699.99</span> MAD
              </p>
              <a href="#" class="btn btn-template">Réserver maintenant</a>
            </div>
          </aside>
        </div>
      </div>
    </section>
<?php include 'vues/pied.php' ;?>