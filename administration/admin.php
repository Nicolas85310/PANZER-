<?php
//démarrage de session et connexion à la BDD
require_once('../bdd/connectbdd.php');




if(!isset($_SESSION['id']) OR $_SESSION['niv'] > 2 OR $_SESSION['niv'] < 1 ){
exit;}

if(isset($_GET['type']) AND $_GET['type'] == 'membre') {
    
    
    
    if(isset($_GET['rangid']) AND !empty($_GET['rangid'])AND
        isset($_POST['rang']) AND !empty($_POST['rang'])){
        
      $rangid = (int) $_GET['rangid'];
      $rang = (int) $_POST['rang'];
      $req = $bdd->prepare("UPDATE utilisateurs SET Code_Groupe = ? WHERE ID_Utilisateur = ?");
      $req->execute(array($rang, $rangid));
    }

   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM utilisateurs WHERE ID_Utilisateur = ?');
      $req->execute(array($supprime));
}
}

elseif(isset($_GET['type']) AND $_GET['type'] == 'article') {
   if(isset($_GET['approuve']) AND !empty($_GET['approuve'])) {
      $approuve = (int) $_GET['approuve'];
      $req = $bdd->prepare('UPDATE article SET approuve = 1 WHERE ID_Article = ?');
      $req->execute(array($approuve));
   }
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM article WHERE ID_Article = ?');
      $req->execute(array($supprime));
   }
} 
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM commentaire WHERE ID_Commentaire = ?');
      $req->execute(array($supprime));
   }
 elseif(isset($_GET['type']) AND $_GET['type'] == 'media') {
      if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM media WHERE ID_Media = ?');
      $req->execute(array($supprime));
   }
}





  
$membres = $bdd->query('SELECT * FROM utilisateurs ORDER BY ID_Utilisateur');
$articles = $bdd->query('SELECT * FROM article ORDER BY ID_Article DESC LIMIT 0,20');
$commentaires = $bdd->query('SELECT * FROM commentaire ORDER BY ID_Commentaire DESC LIMIT 0,20');
$medias = $bdd->query('SELECT * FROM media ORDER BY ID_Media DESC LIMIT 0,20');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>Administration</title>
   <link href="../css/formulaire.css" rel="stylesheet" type="text/css" />
   <link href="../css/panzer.css" rel="stylesheet" type="text/css" />
   
</head>
<body>
<center><img src="../images/admin2.png"></center>

      <?php //Afffichage Droits administrateur(tout):
      if(isset($_SESSION['id']) AND $_SESSION['niv'] == 1  ){?>
          
          <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
          
          <h2> <?php echo "Bienvenue dans la section Administration " .$_SESSION['Login'] ;?></h2></br>
          
          <h3><u>Gestion des utilisateurs:</u></h3></br>
          
          <table>
<tr>

       <td>LOGIN</td>

       <td>Niveau de Privilège</td>

       <td>Attribution de Privilège</td>
       
       <td> Bannissement</td>

 </tr>
   
      <?php 
      
      $p="";
      
      while($m = $membres->fetch()) {
      if($m['Code_Groupe'] == 1){$p = "Administrateur";}elseif($m['Code_Groupe'] == 2){$p = "Modérateur";} else {$p = "Membre";}?>
    
       <tr><td><?= $m['Login'] ?></td>
       <td><?= $p  ?></td>
       <td>
       <form method="POST" action="admin.php?type=membre&rangid=<?= $m['ID_Utilisateur'] ?>"  >
        <select name="rang">
            <option value="3">Membre</option>
            <option value="2">Modérateur</option>
            <option value="1">Administrateur</option>
        </select>
        
        <input type="submit" onclick="return confirm('Changer les droits de cet utilisateur ?');" value="Attribuer"/>
    </form>
       </td>
       <td><a href="admin.php?type=membre&supprime=<?= $m['ID_Utilisateur'] ?>" onclick="return confirm('Etes vous sûr de vouloir supprimer cet utilisateur ? (cette action est irréversible!)');">Supprimer L'utilisateur ?</a></td>
   </tr>
          
    
    

    
      <?php }?></table>
    
    <?php }?>

   <br /><br />
   
   
   
      <?php //Affichage Droits Modérateurs:
      if(isset($_SESSION['id']) AND ($_SESSION['niv'] >= 1 AND $_SESSION['niv'] <= 2  )){
         if ($_SESSION['niv'] == 2) {
         ?>
         <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
         <h2> <?php echo "Bienvenue dans la section Modérateur " .$_SESSION['Login'] ;?></h2></br><?php }?>
         
         <h3><u>Gestion des articles:</u></h3></br>
         
<table>
    <tr>

       <td>ID_Article</td>

       <td>Titre</td>

       <td>Login</td>
       
       <td>Contenu</td>
       
       <td>Approbation</td>

       <td>Suppression</td>
       
 </tr>
         
      <?php
      while($c = $articles->fetch()) { ?>
 <tr><td><?= $c['ID_Article'] ?></td><td><?= $c['titre'] ?></td><td><?= $c['Login'] ?></td><td><?= $c['Article_Texte'] ?></td><td><?php if($c['approuve'] == 0) { ?><a href="admin.php?type=article&approuve=<?= $c['ID_Article'] ?>">Approuver</a><?php } ?></td><td><a href="admin.php?type=article&supprime=<?= $c['ID_Article'] ?>" onclick="return confirm('Etes vous sûr de vouloir supprimer cet article?');">Supprimer</a></td></tr><?php } ?></table>
   
   <br /><br />
   
       <h3><u>Gestion des commentaires:</u></h3></br>
       
 <table>
       
       <tr>

       <td>ID_Commentaire</td>
 
       <td>Contenu</td>
       
       <td>Suppression</td>
       
 </tr>
         
      <?php while($c = $commentaires->fetch()) { ?>
 <tr><td><?= $c['ID_Commentaire'] ?></td><td><?= $c['Contenu'] ?></td><td><a href="admin.php?type=commentaire&supprime=<?= $c['ID_Commentaire'] ?>" onclick="return confirm('Etes vous sûr de vouloir supprimer ce commentaire?');">Supprimer</a></td></tr>
      <?php } ?></table>
   
   <br /><br />
   
       <h3><u>Gestion des médias:</u></h3></br>
       
<table>
       
  <tr>

       <td>ID_Media</td>
       
       <td>Titre</td>
       
       <td>Type de Media</td>
       
       <td>Suppression</td>
       
  </tr>
       
      <?php while($c = $medias->fetch()) { ?>
  <tr><td><?= $c['ID_Media'] ?></td><td><?= $c['Titre'] ?></td><td><?= $c['Type_Media'] ?></td><td><a href="admin.php?type=media&supprime=<?= $c['ID_Media'] ?>" onclick="return confirm('Etes vous sûr de vouloir supprimer ce Média?');">Supprimer</a></td></tr>
      <?php }} ?></table></br>
       <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
   
</body>
</html>


























