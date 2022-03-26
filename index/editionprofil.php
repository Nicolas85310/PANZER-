<?php
//démarrage de session et connexion à la BDD
require_once('../bdd/connectbdd.php');

if(isset($_SESSION['id'])) {
   
   
   $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE ID_Utilisateur = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   
   
   
   
   
   if(isset($_POST['newLogin']) AND !empty($_POST['newLogin']) AND $_POST['newLogin'] != $user['Login']) {
      $Login = htmlspecialchars($_POST['newLogin']);
      $reqLogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE Login = ?");
               $reqLogin->execute(array($Login));
               $Loginexist = $reqLogin->rowCount();
               if($Loginexist == 0) {
      
      $newLogin = htmlspecialchars($_POST['newLogin']);
      $insertLogin = $bdd->prepare("UPDATE utilisateurs SET Login = ? WHERE ID_Utilisateur = ?");
      $insertLogin->execute(array($newLogin, $_SESSION['id']));
      
      echo '<script>alert("Votre Login à bien été modifié !");</script>';
      header('refresh:1;../index/profil.php?id='.$_SESSION['id']);
      
      
      } else {
                  $erreur = "Login déjà utilisé !";
               }
}
   
   
       if(isset($_POST['newEmail']) AND !empty($_POST['newEmail']) AND $_POST['newEmail'] != $user['Email']) {
       $Email = htmlspecialchars($_POST['newEmail']);
       if(filter_var($Email, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE Email = ?");
               $reqmail->execute(array($Email));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
       
      $newEmail = htmlspecialchars($_POST['newEmail']);
      $insertEmail = $bdd->prepare("UPDATE utilisateurs SET Email = ? WHERE ID_Utilisateur = ?");
      $insertEmail->execute(array($newEmail, $_SESSION['id']));
      
      echo '<script>alert("Votre adresse mail à bien été modifiée !");</script>';
      header('refresh:1;../index/profil.php?id='.$_SESSION['id']);
      
   
               }else {
       $erreur = "Adresse mail déjà utilisée !";}
   } 
       }
   
  
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = hash('sha256',($_POST['newmdp1']));
      $mdp2 = hash('sha256',($_POST['newmdp2']));
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE utilisateurs SET Password = ? WHERE ID_Utilisateur = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         
         echo '<script>alert("Votre mot de passe à bien été modifié !");</script>';
         header('refresh:1;../index/profil.php?id='.$_SESSION['id']);
         
      } else {
         $erreur = "Vos deux mots de passe ne correspondent pas !";
      }
   }
   
   if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
   $tailleMax = 2097152;
   $taille = filesize($_FILES['avatar']['tmp_name']);
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
   if($taille < $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $updateavatar = $bdd->prepare("UPDATE utilisateurs SET avatar = :avatar WHERE ID_Utilisateur = :id");
            $updateavatar->execute(array(
               'avatar' => $_SESSION['id'].".".$extensionUpload,
               'id' => $_SESSION['id']));
            
            echo '<script>alert("Votre avatar à bien été modifié !");</script>';
            header('refresh:1;../index/profil.php?id='.$_SESSION['id']);
               
            
            
         } else {
            $erreur = "Erreur durant l'importation de votre photo de profil";
         }
   
   
   
   
   
   } else {
         $erreur = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   
   
   }else {
      $erreur = "Votre photo de profil ne doit pas dépasser 2Mo";
   }
   
   }
?>
<!doctype html>
<html lang="fr">
<head>
    
<meta charset="UTF-8">
    
<title>Edition du profil</title>

<link href="../css/formulaire.css" rel="stylesheet" type="text/css" />

</head>

<body>
    
    <h1><u>Edition du Profil:</u></h1>
   

<form id="monForm" action="" method="post" enctype="multipart/form-data">
 
  <fieldset>
    <legend>Profil</legend>
        <p>
            <label for="form_login">Login: </label>
            <input type="text" id="form_login" name="newLogin" placeholder="Login" value="<?php echo $user['Login']; ?>" />
        </p>
        <p>
            <label for="form_mail">Adresse email : </label>
            <input type="email" id="form_mail" name="newEmail" placeholder="Email" value="<?php echo $user['Email']; ?>" />
        </p>
        <p>
            <label for="form_password">Mot de passe : </label>
            <input type="password" id="form_password" name="newmdp1" placeholder="Mot de passe" />
        </p>
        <p>
            <label for="form_password2">Confirmer le mot de passe : </label>
            <input type="password" id="form_password2" name="newmdp2" placeholder="Confirmer Mot de passe" />
        </p>
        
        <p> <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
            <label for="form_password2">Avatar : </label>
            <input type="file" id="form_password2" name="avatar"/>
        </p>
        
     
    
    </fieldset>
    
    <p> 
        <input type="reset" value="Effacer" />
        <input type="submit" onclick="return confirm('Etes vous sûr de vouloir effectuer cette modification?');" value="Mettre à jour mon profil !" />
    </p>
    
    <h3><a href="../index/connected.php" style="background-color: orange;">PAGE D'ACCUEIL</a></h3>
</form></br></br></br></br>
            <?php if(isset($erreur)) {
            echo '<h2 align="Center"><font color="red" >'. $erreur."</font></h2>"; ?>
         </div>
      </div>
   </body>
</html>
<?php   


}
}?>