<?php
session_start();

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header("Location: connexion.php");
}

$fichier = 'donnees/bd.json';
$donnees = file_get_contents($fichier);
$decoded_data = json_decode($donnees, true);
$utilisateurs=$decoded_data['utilisateurs'];

$utilisateurs_par_page = 2;
$utilisateurs_tot = count($utilisateurs);
$pages_tot = ceil($utilisateurs_tot / $utilisateurs_par_page);

$page=1;
if (isset($_GET['page']))
    $page=$_GET['page'];


$debutp = ($page - 1) * $utilisateurs_par_page;
?>

<?php $titre="Administrateur"; ?>
<?php include "vues/entete.php" ?>

<section class="bg-fairy">
    <div class="container">
        <h2 class="title">Gestion des Utilisateurs</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Nom</th>
                    <th>Naissance</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($utilisateurs, $debutp, $utilisateurs_par_page) as $utilisateurs): ?>
                    <tr>
                        <td><?php echo $utilisateurs['login'];?></td>
                        <td><?php echo $utilisateurs['informations']['nom'];?></td>
                        <td><?php echo $utilisateurs['informations']['naissance'];?></td>
                        <td><?php echo $utilisateurs['informations']['adresse']?></td>
                        <td><?php echo $utilisateurs['email'];?></td>
                        <td><?php echo $utilisateurs['role'];?></td>
                        <td><?php echo $utilisateurs['dates']['inscription'];?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <?php 
            echo '<a href="admin.php?page='.($page-1).'" class="pagination-item">&laquo;</a>';
            for ($i=1; $i <= $pages_tot; $i++) { 
                if ($page==$i){
                    echo '<a href="admin.php?page='.$i.'" class="pagination-item active">'.$i.'</a>';
                }
                else{
                    echo '<a href="admin.php?page='.$i.'" class="pagination-item">'.$i.'</a>';
                }
            }
            echo '<a href="admin.php?page='.($page+1).'" class="pagination-item">&raquo;</a>'
        ?>
    </div>
</section>

<?php include "vues/pied.php" ?>
