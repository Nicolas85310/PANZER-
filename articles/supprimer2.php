<?php
require_once('../bdd/connectbdd.php');

if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $suppr_id = htmlspecialchars($_GET['id']);
   $suppr = $bdd->prepare('DELETE FROM article WHERE ID_Article = ?');
   $suppr->execute(array($suppr_id));
header('refresh:1;../articles/menu2.php?id='.$_SESSION['id']);
echo '<script>alert("Votre article à bien été supprimé !");</script>';
}


?>
