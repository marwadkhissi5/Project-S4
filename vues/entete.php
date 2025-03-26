<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Fairy Escapes - <?php echo $titre; ?></title>
</head>
<body>
    <div class="content-wrapper">
        <header>
            <div class="container header-content">
                <div class="logo">Fairy Escapes</div>
                <nav>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="voyages.php">Séjours</a></li>
                        <li><a href="presentation.php">À propos de nous</a></li>
                        <?php if(isset($_SESSION['utilisateur'])){ ?>
                            <li><a href="deconnexion.php">Se déconnecter</a></li>
                            <li><a href="espace_compte.php">Votre espace</a></li>
                        <?php }else{?>
                            <li><a href="connexion.php">Se connecter</a></li>
                            <li><a href="inscription.php">S'inscrire</a></li>
                        <?php }?>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header>
