<?php
//démarrage de session et connexion à la BDD
require_once('../bdd/connectbdd.php');


if(isset($_POST['formconnexion'])) {
   $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
   $mdpconnect = hash('sha256',($_POST['mdpconnect']));
   if(!empty($pseudoconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM utilisateurs WHERE Login = ? AND Password = ?");
      $requser->execute(array($pseudoconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['ID_Utilisateur'];
         $_SESSION['Login'] = $userinfo['Login'];
         $_SESSION['Email'] = $userinfo['Email'];
         $_SESSION['niv'] = $userinfo ['Code_Groupe'];
 
        
         header("location:../index/connected.php?id=<?php $_SESSION ['id']?>");
         
         
         
    } else {
         $erreur = "Mauvais login ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}

//Moteur de recherche

if (isset($_GET['search'])){
    
    
    if ($_GET ['search'] == ""){
        
     header("refresh:0;../index/connexion.php"); 
       echo '<script>alert("Vous devez remplir le champ recherche");</script>';
    }else{
            
   
 
    $recherche=$_GET['search']; 

    
    $reponse = $bdd->query("SELECT ID_Article FROM article WHERE UCase(Type_de_Tank) LIKE UCase('%$recherche%') ORDER BY ID_Article DESC");
    
    
    
    
    
    if($reponse->rowCount()> 0) 
     {
        
        
        header("refresh:0;../index/recherche.php?recherche=$recherche"); 
        //echo '<script>alert("Votre recherche à aboutie !");</script>';
        
     }
     

      
    else 
    {
    header('refresh:0;../index/connexion.php'); 
    echo '<script>alert("Aucun résultat pour votre recherche");</script>';
    }
    
}

}
?>



<!-- Page d'accueil-->

<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <title>Panzer!! - Accueil</title>
    <meta name="description" content="Panzer!! - Chars d'assaut allemands - est un site wiky documentaires relatant l'histoire des tanks allemands nommés PANZER pendant la période de la seconde guerre mondiale (1939-1945)" />
    <meta name="robots" content="index,follow" />
<script type="text/javascript" src="../javascript/kaboum.js"></script>
<script type="text/javascript" src="../javascript/horloge.js"></script>


<link rel="stylesheet" href="../css/panzer.css" type="text/css">

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5ML857P');</script>
<!-- End Google Tag Manager -->

</head>
  
<body>
    <main>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5ML857P"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
      
    
    <div id="container">
                                        
	<div id="header">
                <div id="logo"><img src="../images/logo.png" alt="Tous sur les chars allemands de la 2nd guerre mondiale"></div>
				<div id ="titre"><a href="connexion.php"><img src="../images/titre.png"></a></div>
                                

                              

<div id="connexion">
    
    <img src="../images/connexion.png">
				
<form action="" method="post" >
<input  class="login" type="text" name="pseudoconnect" />
<input  class="mdp" type="password" name="mdpconnect">
<input class="annuler" type="reset" value="" Onclick="son()">
<input class="valider" type="submit" value="" name="formconnexion">

</form>
<a href="../inscription/inscription.php" class="inscription" title= "Cliquer pour vous inscrire">Pas encore inscrit ?</a>
<a href="../motdepasse/recuperation.php" class="mdp_oublié" title="Retrouver votre mot de passe">Mot de passe oublié ?</a>
    
</div>
                                                               
         <?php
         if(isset($erreur)) {
            echo'<h3 align="right"><font color="red" >'. $erreur."</font></h3>";
         }
         ?>
                                
</div>
        
<div id="section1">

<div id="recherche">
        <form method="GET">
        <input class="champ" type="search" name="search" placeholder="Recherche..."/>       
        <input class="bouton" type="submit" value="Ok" />
        </form>
</div>
    

    
    
    
    
    
    
 
<a href="https://www.youtube.com/user/panzer4351" target="_blank" class="youtube"></a>
<a href="https://www.facebook.com/nicolas.lenoir.9678" target="_blank" class="facebook"></a>
<a href="http://www.museedesblindes.fr/" target="_blank" class="musée"></a>
<a href="connexion.php" class="accueil" title="Page d'accueil"></a>
<a href="../articles/menu1.php" class="ww2" title="Chars de la 2nd Guerre Mondiale"></a>
<a href="../articles/menu2.php" class="actuels" title="Chars de l'apr&egrave;s-guerre &agrave; maintenant"></a>
<a href="../Photos/choixphoto.php" class="photos" title="Consulter les photos"></a>
<a href="../films/choixvideo.php" class="vidéos" title="Consulter les vidéos"></a>

</div>


<div id="navigation">
<h3 style="text-align:center">MENU:</h3></br></br></br>
<ul>
        <li><a href="#">Avant-propos</a></li></br>
        <li><a href="#">Seconde Guerre Mondiale</a></li></br>
        <li><a href="#">De la guerre froide à nos jours</a></li></br>
		<li><a href="#">Ce qu'il reste maintenant.</a></li></br>
        <li><a href="#">Le futur des chars allemands.</a></li></br>
        <li><a href="#">Le café</a></li></br>
        
        
    </ul>

</div>

<div id="section2">
</br>

<h2>Bienvenue sur PANZER!!</h2></br></br>Le site à pour but de revenir sur l'importance de l'utilisation des <strong>blindés en allemagne</strong> pendant la seconde guerre mondiale(1939-1945)
mais aussi de l'après-guerre jusqu'à maintenant et de de détailler les caractéristiques de chacun,
pourquoi ils ont été conçus et leur avantage et inconvénients lors des différentes batailles....le tout illustré de  photos et vidéos.</br></br>
Bonne lecture!</br>
<font-size="1">Le site est en cours de construction,donc n'hésitez pas à faire vos remarques et suggestions en cliquant <a href="remarques.php">ICI</a> Merci :) </font></br>

</div>
</main>



<footer>


<div id="horloge"></div>



<div id="maus"><img src="../images/maus.png" alt="Le Mauss,chard allemand secret,sortie seulement en 3 exemplaires"></div> 
 

</div>
<a href="test_conx_bdd.php" class="testbdd"></a> 
</footer>      
       
        
  
</body>
</html>
