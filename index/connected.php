<?php
//démarrage de session et connexion à la BDD
require_once('../bdd/connectbdd.php');



if(isset($_SESSION['id']) AND $_SESSION['id'] > 0) {
   
   $getid = intval($_SESSION['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID_Utilisateur = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();      
} 
         $_SESSION['id'] = $userinfo['ID_Utilisateur'];
         $_SESSION['Login'] = $userinfo['Login'];
         $_SESSION['Email'] = $userinfo['Email'];
         $_SESSION['niv'] = $userinfo ['Code_Groupe'];
         $_SESSION['avatar'] = $userinfo['avatar'];  
         
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
    <title>accueil</title>


<script type="text/javascript" src="../javascript/horloge.js"></script>


<link rel="stylesheet" href="../css/panzer.css" type="text/css">

</head>
  
<body>
      
    
    <div id="container">
                                        
	<div id="header">
                <div id="logo"><img src="../images/logo.png"></div>
				<div id ="titre"><a href="../index/connected.php?id='.$_SESSION['id']"><img src="../images/titre.png"></a></div>
                                

                              

<div id="connexion">
    
<?php if(!empty($userinfo['avatar'])) {?>
    
<img src="membres/avatars/<?php echo $_SESSION['avatar'];?>" class="avatar"/> <?php } ?> 
<img src="../images/connect.png">
<p class="log"><?php echo $_SESSION['Login'];?></p>				
<a href="../index/profil.php?id=<?php echo $_SESSION['id'];?>" class="profil" title= "Gérer votre profil">Profil</a>
<a href="../index/deconnexion.php" class="deconnexion" title="Cliquer pour vous déconnecter">Déconnexion</a>
 
    
</div>
                     
                             
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
<a href="../index/connected.php?id='.$_SESSION['id']" class="accueil" title="Page d'accueil"></a>
<a href="../articles/menu1.php" class="ww2" title="Chars de la 2nd Guerre Mondiale"></a>
<a href="../articles/menu2.php" class="actuels" title="Chars de l'apr&egrave;s-guerre &agrave; maintenant"></a>
<a href="../Photos/choixphoto.php" class="photos" title="Consulter les photos"></a>
<a href="../films/choixvideo.php" class="vidéos" title="Consulter les vidéos"></a>

</div>


<div id="navigation">
<h3 style="text-align:center">Menu:</h3></br></br></br>
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
<h2>Bienvenue <?php echo $_SESSION['Login']; ?> !!</h2></br></br>Le site à pour but de revenir sur l'importance de l'utilisation des blindés en allemagne pendant la seconde guerre mondiale(1939-1945)
mais aussi de l'après-guerre jusqu'à maintenant et de de détailler les caractéristiques de chacun,
pourquoi ils ont été conçus et leur avantage et inconvénients lors des différentes batailles....le tout illustré de  photos et vidéos.</br></br>
Bonne lecture!</br>
<font size="1">Le site est en cours de construction,donc n'hésitez pas à faire vos remarques et suggestions en cliquant <a href="remarques.php">ICI</a> Merci :)</font></br>
</div>

<div id="footer">
    
    
<div id="horloge"></div>


    



<div id="maus"><img src="../images/maus.png"></div>
<!--Controle du niveau d'administration-->                           
 <?php
         
 if(isset($_SESSION['id']) AND $_SESSION['niv'] == 1 OR $_SESSION['niv'] == 2 ) {
 ?>
 <a href="../administration/admin.php?id=<?php echo $_SESSION['id'];?>" class="admin"><img src="../images/admin.png">                               
       
 <?php } ?>



 

</div>
    </div>

</body>
</html>




