<?php
//démarrage de session et connexion à la BDD
require_once('../bdd/connectbdd.php');

//Vérification des champs et doublons
if(isset($_POST['valider']))
{
         $Nom = htmlspecialchars($_POST['Nom']);
         $Prenom = htmlspecialchars($_POST['Prenom']);
         $Age = htmlspecialchars($_POST['Age']);
         $Date_Naissance = $_POST['Date_Naissance'];
         $Adresse = htmlspecialchars($_POST['Adresse']);
         $Email = htmlspecialchars($_POST['Email']);
         $Email2 = htmlspecialchars($_POST['Email2']);
         $Login = htmlspecialchars($_POST['Login']);
         $Password = hash('sha256',($_POST['Password']));
         $passe2 = hash('sha256',($_POST['passe2']));
         
         
         
         if(!empty($_POST['Nom']) AND !empty($_POST['Prenom']) AND !empty($_POST['Age']) AND !empty($_POST['Date_Naissance']) AND !empty($_POST['Adresse']) AND !empty($_POST['Email']) AND !empty($_POST['Email2']) AND !empty($_POST['Login']) AND !empty($_POST['Password']) AND !empty($_POST['passe2']))
         
          
         {$pseudolength = strlen($Login);
      if($pseudolength <= 255) {
         if($Email == $Email2) {
            if(filter_var($Email, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE Email = ?");
               $reqmail->execute(array($Email));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
               $reqLogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE Login = ?");
               $reqLogin->execute(array($Login));
               $Loginexist = $reqLogin->rowCount();
               if($Loginexist == 0) {
                  if($Password == $passe2) {
                     $avatar = "";
                     $valider = $bdd->prepare('INSERT INTO utilisateurs(ID_Utilisateur,Code_Groupe,Nom,Prenom,Age,Date_Naissance,Adresse,Email,Date_Inscription,Login,Password,avatar) VALUES(NULL, "3", :Nom, :Prenom, :Age, :Date_Naissance, :Adresse, :Email, CURDATE(), :Login, :Password, :avatar)');
                     $valider->execute(array(':Nom' =>$Nom,':Prenom' => $Prenom,':Age' => $Age,':Date_Naissance' => $Date_Naissance,':Adresse' => $Adresse,':Email' => $Email,':Login' => $Login,':Password' => $Password, ':avatar' => $avatar));
                     $lastid = $bdd->lastInsertId();
                     echo '<script>alert("votre compte à bien été crée vous pouvez maintenant vous connectez !");</script>';
                     //$message = "Votre compte a bien été créé ! Cliquer <a href=\"../index/connexion.php\">ICI</a> pour vous connecter.";
                     header("refresh:1;url=../index/connexion.php");
                     
                     
                      } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
                 } else {
                  $erreur = "Login déjà utilisé !";
               }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
      
         
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
   
                      $avatar = $_FILES['avatar']['name'];
                      
                      if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
                      $tailleMax = 2097152;
                      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
                      if($_FILES['avatar']['size'] <= $tailleMax) {
                      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                      if(in_array($extensionUpload, $extensionsValides)) {
                      $chemin = '../index/membres/avatars/'.$lastid.'.jpg';
                      $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                      if($resultat) {
                          
                          $insert = $bdd->prepare("UPDATE utilisateurs SET avatar = :avatar WHERE ID_Utilisateur = :id");
                          $insert->execute(array('avatar' => $lastid.".".$extensionUpload, 'id' => $lastid ));
                          
                          
                          
                         // echo '<script>alert("votre compte à bien été crée vous pouvez maintenant vous connectez !");</script>';
                          //$message = "Votre compte a bien été créé ! Cliquer <a href=\"../index/connexion.php\">ICI</a> pour vous connecter.";
                          //header("refresh:1;url=../index/connexion.php");
                          
                          
                          
   
   } else {
            $erreur = "Erreur durant l'importation de votre photo de profil";
         }
   
   
   
   
   
   } else {
         $erreur = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   
   
   }else {
      $erreur = "Votre photo de profil ne doit pas dépasser 2Mo";
                      }}      
   
}

   ?>

<!-- formulaire d'inscription -->

<!doctype html>
<html lang="fr">
<head>
    
<meta charset="UTF-8">
    
<title>Inscription</title>

<link href="../css/formulaire.css" rel="stylesheet" type="text/css" />

</head>

<body>
    
    <h1><u>Inscription:</u></h1>
 
 
<p><h3>Pour vous inscrire, veuillez remplir les champs suivants :</h3></p>
    

<form id="monForm" action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Informations personnelles</legend>
        <p>
            <label for="form_Nom">Nom : </label>
            <input type="text" id="form_Nom" name="Nom" />
        </p>
        <p>
            <label for="form_Prenom">Prenom : </label>
            <input type="text" id="form_Prenom" name="Prenom" />
        </p>
        <p>
            <label for="form_Age">Age : </label>
            <input type="text" id="form_Age" name="Age" />
        </p>
        
        <p>
            <label for="form_DateNaissance">Date de naissance : </label>
            <input type="date" id="form_DateNaissance" placeholder="jour/mois/année" name="Date_Naissance" />
        </p>
        <p>
            <label for="form_address">Adresse : </label>
            <input type="text" id="form_address" name="Adresse" />
        </p>
        <p>
  
    </fieldset>
    
    <fieldset>
    <legend>Compte</legend>
        <p>
            <label for="form_mail">Adresse email : </label>
            <input type="email" id="form_mail" name="Email" />
        </p>
        <p>
            <label for="form_mail">Confirmer votre Adresse email : </label>
            <input type="email" id="form_mail" name="Email2" />
        </p>
        <p>
            <label for="form_login">Login : </label>
            <input type="text" id="form_login" name="Login" />
        </p>
        <p>
            <label for="form_password">Mot de passe : </label>
            <input type="password" id="form_password" name="Password" />
        </p>
        <p>
            <label for="form_password2">Confirmer le mot de passe : </label>
            <input type="password" id="form_password2" name="passe2" />
        </p>
        
        <p>
            <label for="form_password2">Choisissez votre Avatar : </label>
            <input type="file" id="form_password2" name="avatar"/>
        </p>
        
     
    
    </fieldset>
    
    <p>
        <input type="reset" value="Effacer" />
        <input type="submit" value="S'inscrire!" name="valider" />
    </p>
</form></br></br></br></br>

<?php
       
  if (isset($erreur))
  {echo'<h1><font color="red">'. $erreur."</font></h1>";}
  if (isset($message))
  {echo'<h1><font color="#B4F7BE">'. $message."</font></h1>";}
  ?>
</body>
</html>
