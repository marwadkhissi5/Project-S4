<?php 
  include 'vues/entete.php';
  $stylesheets = [];
  $javascripts = [];
?>

<?php include 'vues/recherche.php' ;?>

<section class="section-contact bg-clair" id="contact">
  <div class="conteneur">
    <h2 class="titre-principal">Contactez-nous</h2>
    <div class="row">
      <div class="col-9">
        <form class="form-contact" action="/envoyer-message" method="POST">
          <label for="nom">Votre nom</label>
          <input type="text" id="nom" name="nom" placeholder="Ex: Alice" required />

          <label for="email">Votre e-mail</label>
          <input type="email" id="email" name="email" placeholder="votre@email.com" required />

          <label for="message">Votre message</label>
          <textarea id="message" name="message" rows="6" placeholder="Écrivez votre message..." required></textarea>

          <button type="submit" class="btn btn-template btn-large">Envoyer</button>
        </form>
      </div>

      <!-- Informations -->
      <div class="col-3 bloc-infos-contact">
        <p><strong>📍 Adresse :</strong><br>123 rue du Voyage</p>
        <p><strong>📞 Téléphone :</strong><br>+33 600 000 000</p>
        <p><strong>✉️ Email :</strong><br>contact@fairyescapes.fr</p>
        <p><strong>⏰ Horaires :</strong><br>Lundi à Vendredi, 9h–17h</p>
      </div>
    </div>
  </div>
</section>


<?php include 'vues/pied.php' ;?>