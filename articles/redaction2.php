<?php require_once('../bdd/connectbdd.php');


//edition de l'article
   $mode_edition = 0;
if(isset($_GET['edit']) AND !empty($_GET['edit'])) {
   $mode_edition = 1;
   $edit_id = htmlspecialchars($_GET['edit']);
   $edit_article = $bdd->prepare('SELECT * FROM article WHERE ID_Article = ?');
   $edit_article->execute(array($edit_id));
   if($edit_article->rowCount() == 1) {
      $edit_article = $edit_article->fetch();
   } else {
      die('Erreur : l\'article n\'existe pas...');
   }
}



//création de l'article
if(isset($_POST['article_titre'], $_POST['article_tank'], $_POST['article_contenu'])) {
   if(!empty($_POST['article_titre']) AND !empty($_POST['article_tank']) AND !empty($_POST['article_contenu'])) {
        
       
      $periode = "2" ;
      $Login = htmlspecialchars($_SESSION['Login']);
      $ID_Utilisateur = htmlspecialchars($_SESSION['id']);
      $article_titre = htmlspecialchars($_POST['article_titre']);
      $article_tank = htmlspecialchars($_POST['article_tank']);
      $article_contenu = htmlspecialchars($_POST['article_contenu']);
      $miniature = "";
      $video = "";
      
      if($mode_edition == 0) {
        //var_dump($_FILES);
        //var_dump(exif_imagetype($_FILES['miniature']['tmp_name']));
      $ins = $bdd->prepare('INSERT INTO article (Login, titre, Type_de_Tank, Article_Texte, Date_Publication, ID_Utilisateur, ID_Periode, approuve, miniature, videos) VALUES (?, ?, ?, ?, CURDATE(), ?, "2", "0", ?, ?)');
      $ins->execute(array($Login, $article_titre, $article_tank, $article_contenu, $ID_Utilisateur, $miniature, $video));
      $lastid = $bdd->lastInsertId();
      
      
    
    if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) {
             
            $miniature = $_FILES['miniature']['name'];
             
            if(exif_imagetype($_FILES['miniature']['tmp_name']) == 2 OR exif_imagetype($_FILES['miniature']['tmp_name']) == 3){
            $typemed = "Image" ;
            $tailleMax = 2097152;
            $taille = filesize($_FILES['miniature']['tmp_name']);
            $extensionsValides = array('jpg', 'jpeg', 'png');
            if($taille < $tailleMax) {
                
            $extensionUpload = strtolower(substr(strrchr($_FILES['miniature']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides)) {
            $chemin = 'miniatures/'.$lastid.'.jpg';
            $resultat = move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
            if($resultat){
                    
            $insert = $bdd->prepare("UPDATE article SET miniature = :miniature WHERE ID_Article = :id");
            $insert->execute(array('miniature' => $lastid.".".$extensionUpload, 'id' => $lastid ));
            
            $ins = $bdd->prepare('INSERT INTO media (Titre, Type_Media, Chemin, Date_Publication, ID_Article, ID_Utilisateur, ID_Periode) VALUES (?, ?, ?, CURDATE(), ?, ?, ?)');
            $ins->execute(array($article_titre, $typemed, $chemin, $lastid, $ID_Utilisateur, $periode));
            
                   } else {
            $erreur = "Erreur durant l'importation de votre image !";
         }
   
   } else {
         $erreur = "Votre image doit être au format jpg, jpeg,ou png";
      }
   
   
   }else {
      $erreur = "Votre image ne doit pas dépasser 2Mo";
   }
   
   }
         }
                
         
   if(isset($_FILES['videos']['name']) AND !empty($_FILES['videos']['name'])){
                
                
     $periode = "1" ;
     $typemed = "Video" ;      
     $taillevid = 1000000000;
     $vid = filesize($_FILES['videos']['tmp_name']);
     $extensionsValides = array('mp4', 'avi');
     if($vid <= $taillevid) {
     $extensionUpload = strtolower(substr(strrchr($_FILES['videos']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides)) {
            $chemin = 'videos/'.$lastid.'.mp4';
            $result = move_uploaded_file($_FILES['videos']['tmp_name'], $chemin);
     if ($result) {
         
            
           
            
            $insert = $bdd->prepare("UPDATE article SET videos = :videos WHERE ID_Article = :id");
            $insert->execute(array('videos' => $lastid.".".$extensionUpload, 'id' => $lastid ));
            
            $ins = $bdd->prepare('INSERT INTO media (Titre, Type_Media, Chemin, Date_Publication, ID_Article, ID_Utilisateur, ID_Periode) VALUES (?, ?, ?, CURDATE(), ?, ?, ?)');
            $ins->execute(array($article_titre, $typemed, $chemin, $lastid, $ID_Utilisateur, $periode));
     
         } else{
             
             
             $erreur = "Erreur durant l'importation de votre vidéo !";
         }
         
         }else{
      $erreur = "Votre vidéo doit-être au format mp4 ou avi !";
   }
         
         }else{
      $erreur = "Votre vidéo ne doit pas dépasser 1Go";
   }
   
            }   
               
               header('refresh:2;../articles/article.php?id='.$lastid);
               echo '<script>alert("Votre article à bien été créé !");</script>';
      
      
      }
            
    
      else{
         $update = $bdd->prepare('UPDATE article SET LoginED = ?,  titre = ?, Type_de_Tank = ?, Article_Texte = ?, Date_Edition = CURDATE() WHERE ID_Article = ?');
         $update->execute(array($Login, $article_titre, $article_tank, $article_contenu, $edit_id));
         
         if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) {
             
            if(exif_imagetype($_FILES['miniature']['tmp_name']) == 2 OR exif_imagetype($_FILES['miniature']['tmp_name']) == 3){
            
            $tailleMax = 2097152;
            $taille = filesize($_FILES['miniature']['tmp_name']);
            $extensionsValides = array('jpg', 'jpeg', 'png');
            if($taille < $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['miniature']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides)) {
            $chemin = 'miniatures/'.$edit_id.'.jpg';
            $resultat = move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
            if($resultat) {
                
            $update = $bdd->prepare("UPDATE article SET LoginED = :LoginED, Date_Edition = CURDATE(),  miniature = :miniature WHERE ID_Article = :id");
            $update->execute(array('LoginED' => $Login, 'miniature' => $edit_id.".".$extensionUpload, 'id' => $edit_id));
            
            $insert = $bdd->prepare("UPDATE media SET Chemin = ? WHERE ID_Article = ? AND Type_Media = 'Image' ");
            $insert->execute(array($chemin, $edit_id ));
               
            
            
          } else {
            $erreur = "Erreur durant l'importation de votre image !";
         }
   
   } else {
         $erreur = "Votre image doit être au format jpg, jpeg,ou png";
      }
   
   
   }else {
      $erreur = "Votre image ne doit pas dépasser 2Mo";
   }
   
   }
         } 
         
         
         
    if(isset($_FILES['videos']['name']) AND !empty($_FILES['videos']['name'])){
                
     $periode = "1" ;
     $typemed = "Video" ;      
     $taillevid = 1000000000;
     $vid = filesize($_FILES['videos']['tmp_name']);
     $extensionsValides = array('mp4', 'avi');
     if($vid <= $taillevid) {
     $extensionUpload = strtolower(substr(strrchr($_FILES['videos']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides)) {
            $chemin = 'videos/'.$edit_id.'.mp4';
            $result = move_uploaded_file($_FILES['videos']['tmp_name'], $chemin);
            
     if ($result) {          
            
            $insert = $bdd->prepare("UPDATE article SET LoginED = :LoginED, Date_Edition = CURDATE(), videos = :videos WHERE ID_Article = :id");
            $insert->execute(array('LoginED' => $Login, 'videos' => $edit_id.".".$extensionUpload, 'id' => $edit_id ));
            
            $insert = $bdd->prepare("UPDATE media SET Chemin = ? WHERE ID_Article = ? AND Type_Media = 'Video' ");
            $insert->execute(array($chemin, $edit_id ));
     
     
         } else{
             
             
             $erreur = "Erreur durant l'importation de votre vidéo !";
         }
         
         }else{
      $erreur = "Votre vidéo doit-être au format mp4 ou avi !";
   }
         
         }else{
      $erreur = "Votre vidéo ne doit pas dépasser 1Go";
   }
   
            }        
            
       header('refresh:2;../articles/article.php?id='.$edit_id);
       echo '<script>alert("Votre article à bien été mis à jour !");</script>';
        
   } 
            
        
}else {
      $erreur = 'Veuillez remplir tous les champs';
      }
}


?>
<!--affichage-->
<!doctype html>
<html lang="fr">
<head>
    
<meta charset="UTF-8">
<link href="../css/formulaire.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/panzer.css" type="text/css">
    
<title>Rédaction/Edition</title>



<link href="../css/formulaire.css" rel="stylesheet" type="text/css" />

</head>

<body>
    
    
    
    <form method="POST" enctype="multipart/form-data">
      <input type="text" name="article_titre" placeholder="Titre"<?php if($mode_edition == 1) { ?> value="<?= 
      $edit_article['titre'] ?>"<?php } ?> /><br /><br />
      <input type="text" name="article_tank" placeholder="Type de tank"<?php if($mode_edition == 1) { ?> value="<?= 
      $edit_article['Type_de_Tank'] ?>"<?php } ?> /><br /><br />
      <textarea name="article_contenu" placeholder="Contenu de l'article"><?php if($mode_edition == 1) { ?><?= 
      $edit_article['Article_Texte'] ?><?php } ?></textarea><br /><br />
      <?php if($mode_edition == 0) { ?>
      
      <!--importation image-->
      <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
      <u>Importer votre image:</u><input type="file" name="miniature" /><br />
      <font size="1">(Attention format jpg ou png,taille maxi 2MO !)</font><br /><br />
      
      <!--importation vidéo-->
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
      <u>Importer votre vidéo:</u><input type="file" name="videos" /><br />
      <font size="1">(Attention format mp4 ou avi,taille maxi 1GO !)</font><br />
      
      <?php } 
      else{ ?>
      
      <!--modification image-->
      <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
      <u>Modifier votre image:</u><input type="file" name="miniature" /><br />
      <font size="1">(Attention format jpg ou png,taille maxi 2MO !)</font><br /><br />
      
      <!--modification vidéo-->
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
      <u>Modifier votre vidéo:</u><input type="file" name="videos" /><br />
      <font size="1">(Attention format mp4 ou avi,taille maxi 1GO !)</font><br /><br /><?php } ?>
      
      <input type="submit" value="Envoyer l'article" />
   </form>
   <br />
   <?php if(isset($erreur)) { echo'<h3><font color="red">'. $erreur."</font></h3>"; } ?>
   
    </body
    
</html>
     
  

    
    
    
   










