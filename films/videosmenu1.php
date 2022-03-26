<?php
require_once('../bdd/connectbdd.php');
$articles = $bdd->query('SELECT * FROM article WHERE ID_Periode = "1" ORDER BY Date_Publication DESC');
?>
<!DOCTYPE html>
<html>
<head>
   <title>videosmenu1</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="../css/panzer.css" type="text/css">
   <link href="../css/formulaire.css" rel="stylesheet" type="text/css" />
</head>
<body> 
    
    <p align="center"><h1><u>Vos vidéos:</u></h1></p></br></br>


<?php if(isset($_SESSION['id'])){ ?>
<p><a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?></p>

    
   
      <?php
      
      while($a = $articles->fetch()) { ?>
      
              
                 <?php if($a['videos'] == ""){
   echo "";
   }else{?>


                
   <video controls="controls" width="500" height="335" poster="../articles/miniatures/<?= $a['ID_Article'] ?>.jpg" >
   <source src="/Panzer/articles/videos/<?= $a['ID_Article'] ?>.mp4" type="video/mp4" />
   <source src="/Panzer/articles/videos/<?= $a['ID_Article'] ?>.avi" type="video/avi" />
   <object type="application/x-shockwave-flash" data="dewtube.swf" > <paramname="movie" value="dewtube.swf" /> <paramname="allowFullScreen" value="true" /> <paramname="wmode" value="transparent" /> </object>
   </video>
   <?php }?>
              
             
               
      <?php } ?></br></br>
   
       
           <?php if(isset($_SESSION['id'])){ ?>
           <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?>
</body>
</html>
