    <footer class="pied-de-page bg-template">
        <div class="ligne-haute">
        <div class="conteneur">
            <div class="colonne-footer">
            <h4>À propos</h4>
            <p>
                Fairy Escapes vous accompagne dans la création de voyages magiques
                et sur mesure à travers le monde.
            </p>
            </div>
            <div class="colonne-footer">
            <h4>Liens utiles</h4>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="voyages.php">Destinations</a></li>
                <li><a href="voyages.php">Offres</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            </div>
            <div class="colonne-footer">
            <h4>Contact</h4>
            <p>📍 123 rue du Voyage</p>
            <p>📞 +33 600 000 000</p>
            <p>✉️ contact@fairyescapes.fr</p>
            </div>
        </div>
        </div>
        <div class="ligne-basse">
        <div class="conteneur">
            <p>&copy; 2025 Fairy Escapes — Tous droits réservés</p>
        </div>
        </div>
  </footer>

  <script src="assets/js/main.js"></script>

  <?php 
    foreach ($stylesheets as $css) {
        echo "<link rel=\"stylesheet\" href=\"assets/css/$css\" />\n";
    }
    foreach ($javascripts as $js) {
        echo "<script src=\"assets/js/$js\"></script>\n";
    }
  ?>
</body>

</html>