<?php 
session_start();
include 'includes/fcts_donnees.php';
include 'vues/entete.php';

$stylesheets = [];
$javascripts = ["admin.js"];

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header("Location: index.php");
} ?>

<?php include 'vues/recherche.php' ;?>

<?php 
    $utilisateurs=$bd["utilisateurs"];
    $nombre_tot_page=ceil(count($utilisateurs)/$nb_par_page);
    $page=1;

    if (isset($_GET['page']))
        $page=$_GET['page'];

    $debutp=(($page-1)*$nb_par_page);
?>
<section>
    <div class="conteneur">
        <h2 class="title">Gestion des Utilisateurs</h2>
        
        <table class="table">
            <thead>
                <tr>
                  <th>Login</th>
                  <th>Nom</th>
                  <th>Email</th>
                  <th>Rôle</th>
                  <th>Date de naissance</th>
                  <th>Date d'inscription</th>
                  <th>Adresse</th>
                  <th>Actions</th>
                </tr>
              </thead>
            <tbody>
                <?php foreach (array_slice($utilisateurs, $debutp, $nb_par_page) as $utilisateurs): ?>
                    <tr id="<?php echo $utilisateurs['login'];?>">
                        <td><?php echo $utilisateurs['login'];?></td>
                        <td><?php echo $utilisateurs['informations']['nom'];?></td>
                        <td><?php echo $utilisateurs['email'];?></td>
                        <td><?php echo $utilisateurs['role'];?></td>
                        <td><?php echo $utilisateurs['informations']['naissance'];?></td>
                        <td><?php echo $utilisateurs['dates']['inscription'];?></td>
                        <td><?php echo $utilisateurs['informations']['adresse']?></td>
                        <td class="actions">
                            <a href="modifier_utilisateur.php?id=<?php echo $utilisateurs['login'];?>" class="btn-edit">✏️</a>
                            <button class="btn-delete" data-user="<?php echo $utilisateurs['login'];?>">🗑</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-template btn-large">➕ Ajouter un utilisateur</button>
        <div class="pagination">
            <?php 
                echo '<a href="admin.php?page='.($page-1).'" class="pagination-item">&laquo;</a>';
                for ($i=1; $i <= $nombre_tot_page; $i++) { 
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
    </div>
</section>
    

<?php include 'vues/pied.php' ;?>