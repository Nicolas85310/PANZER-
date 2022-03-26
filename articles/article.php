<?php require_once('../bdd/connectbdd.php');
 
 
   
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   
   $getid = htmlspecialchars($_GET['id']);
   
   $article = $bdd->prepare('SELECT * FROM article WHERE ID_Article = ?');
   $article->execute(array($getid));
   if($article->rowCount() == 1) {
      $article = $article->fetch();
      
      if(isset($_POST['submit_commentaire'])) {
      if(isset($_POST['commentaire'])AND !empty($_POST['commentaire'])) {
         
         $ut = htmlspecialchars($_SESSION['id']);
         $commentaire = htmlspecialchars($_POST['commentaire']);
        
            $ins = $bdd->prepare('INSERT INTO commentaire (Contenu, Date_Publication, heure, ID_Article, ID_Utilisateur) VALUES (?,CURDATE(),CURTIME(),?,?)');
            $ins->execute(array($commentaire,$getid,$ut));
            
            header('refresh:1;../articles/article.php?id='.$getid);
            echo '<script>alert("Votre commentaire à bien été posté !");</script>';
            
        
      } else {
         $c_msg = "Erreur: Tous les champs doivent être complétés";
      }
   }
   $commentaires = $bdd->prepare('SELECT * FROM commentaire WHERE ID_Article = ? ORDER BY ID_Commentaire DESC');
   $commentaires->execute(array($getid));
   

   
      $titre = $article['titre'];
      $type = $article['Type_de_Tank'];
      $contenu = $article['Article_Texte'];
      $id_art = $article['ID_Article'];
      $id_ut = $article['ID_Utilisateur'];
      $Date_pub = $article['Date_Publication'];
      $Date_ed = $article['Date_Edition'];
      $Date_pub=date('d-m-y', strtotime($Date_pub));
      $Date_ed=date('d-m-y', strtotime($Date_ed));
   } else {
      die('Cet article n\'existe pas !');
   }
} else {
   die('Erreur');
}



  
?>
<!DOCTYPE html>
<html>
<head>
   <title>Articles</title>
   <meta charset="utf-8">
   <link href="../css/formulaire.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="../css/panzer.css" type="text/css">
</head>
<body>
    <div id="haut"></div>
    <h1><?= $titre ?></h1><a href="#com"><font size="1" color="orange"><i>Voir les commentaires ?</i></font></a>
   <h3><?= $type ?></h3>
   <?php if($article['miniature'] == ""){
   echo "";
   }else{?>
   
   <img src="miniatures/<?= $article['ID_Article'] ?>.jpg" width="400" /><?php }?>
   <p><?= $contenu ?></p>
   
   <?php if($article['videos'] == ""){
   echo "";
   }else{?>
   
   
   
   <!-- lecteur vidéo-->
   <p>
   <video controls="controls" width="500" height="335" poster="miniatures/<?= $article['ID_Article'] ?>.jpg">
   <source src="videos/<?= $article['ID_Article'] ?>.mp4" type="video/mp4" />
   <source src="videos/<?= $article['ID_Article'] ?>.avi" type="video/avi" />
   <object type="application/x-shockwave-flash" data="dewtube.swf" > <paramname="movie" value="dewtube.swf" /> <allowFullScreen="true" /> <paramname="wmode" value="transparent" /> </object>
   </video>
   <p><?php }?>
   
   
   <font size="1">Créé le <?= $Date_pub ?> par <?= $article['Login'] ?> 
   
   <?php if($article['LoginED'] != NULL) { ?> et édité le <?= $Date_ed ?>
   par <?= $article['LoginED'] ?><?php } ?>.</font></br></br>
      
   
   
   
   <?php 
   //Droits d'édition (seulement le créateur et le staff)
   if(!isset($_SESSION['id'])){
       echo "";
   }
   elseif(isset($_SESSION['id']) AND ($_SESSION['niv'] >= 1 AND $_SESSION['niv'] <= 2  ) OR $_SESSION['id'] == $id_ut){
   
       ?> <a href="redaction.php?edit=<?= $id_art ?> " class="lien" >Modifier</a> | 
       
   
   <?php  if ($article['ID_Periode'] == 1){?>
       <a href="supprimer.php?id=<?= $id_art ?>"onclick="return confirm('Etes vous sûr de vouloir supprimer cet article?');" class="lien">Supprimer</a> <?php }
       elseif ($article['ID_Periode'] == 2){?>
       <a href="supprimer2.php?id=<?= $id_art ?>"onclick="return confirm('Etes vous sûr de vouloir supprimer cet article?');" class="lien">Supprimer</a> <?php }?>
       
       
       
       
       
        <?php }?></br></br>
   
   
   <?php if ($article['ID_Periode'] == 1){?>
   
   
   Retour à la </br><a href="menu1.php" class="lien">LISTE</a><?php }
   else {?> Retour à la </br><a href="menu2.php" class="lien">LISTE</a><?php } ?>
   
   
   ou <?php if(isset($_SESSION['id'])){ ?>
           <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>?
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a>? <?php } ?>
<div id="com"><h2>Commentaires:</h2></div>
<a href="#haut"><font size="1" color="orange"><i>Retour en haut de page</i></font></a>
<?php
//Droits de dépôt de commentaires(seulement les membres/staff)
if(!isset($_SESSION['id'])){
echo "";}else{?>
   <form method="POST">
   <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br /><br />
   <input type="submit" value="Poster mon commentaire" name="submit_commentaire" /><br />
</form><?php } ?>
<?php if(isset($c_msg)) { echo $c_msg; } ?>
<br />
<?php while($c = $commentaires->fetch()) {
   $idav = $c['ID_Utilisateur'];
   $avatar = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID_Utilisateur = ?');
   $avatar->execute(array($idav));
   $av = $avatar->fetch();
   $img = $av['avatar'];
   $log = $av['Login'];
   $datecom = $c['Date_Publication'];
   $datecom = date('d-m-y', strtotime($datecom));?>
<img src="../index/membres/avatars/<?php echo $img ?>" class="avatarcom"/>
<span style="font-weight:bold; color:blue"><font size="6" face="georgia" color="red"><?= $log ?>:</font></span><?= $c['Contenu'] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p align="center"><font size="1">Dernier message le <?= $datecom ?> à <?= $c['heure'] ?></font></p> <br />
<?php } ?>




</body>
</html>



