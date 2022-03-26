<?php require_once('../bdd/connectbdd.php');
if(isset($_GET['id']) AND $_GET['id'] > 0) {
   
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID_Utilisateur = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();}
    
?>
  


<!doctype html>
<html lang="fr">
<head>
    
<meta charset="UTF-8">
    
<title>Profil</title>



<link href="../css/formulaire.css" rel="stylesheet" type="text/css" />

</head>

<body>
    
    
    
     
  

    
    
    <h1><u>Votre Profil:</u></h1>
   

<div id="monForm">
 
  <fieldset>
      <legend>Profil de <?php echo $userinfo['Login']; ?></legend></br>
        <p>
            <label for="form_login">Login: </label>
        <div id="form_login"> <?php echo '<h3>' .$userinfo['Login']."</h3>"; ?></div>
  </p>
        
        
        
  <p>
      <label for="form_mail">Adresse email : </label>
            <div id="form_mail"> <?php echo '<h3>' .$userinfo['Email']."</h3>"; ?></div>
            
</p>
<p>
        
            <label for="form_avatar">Avatar: </label>
        <?php
        if(!empty($userinfo['avatar']))
        {?>
        <div id="form_avatar"><img src="membres/avatars/<?php echo $userinfo['avatar'];?>" width= "150" /></div>

            
        <?php } ?>
  </p>
        
        
        </fieldset>

       

      
   
         <?php
         
         if(isset($_SESSION['id']) AND $userinfo['ID_Utilisateur'] == $_SESSION['id']) {
         ?>
         </br>
         <h3><a href="editionprofil.php" style="background-color: orange;">Editer mon profil</a></h3>
         <h3><a href="../index/connected.php?id=<?php $_SESSION ['id']?>" style="background-color: orange;">PAGE D'ACCUEIL</a></h3>
         <h3><a href="../index/deconnexion.php" style="background-color: orange;">Se déconnecter</a></h3>
         <?php
         }
         

?>
</div>
         </body>
</html>






