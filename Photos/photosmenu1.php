<?php
require_once('../bdd/connectbdd.php');
$articles = $bdd->query('SELECT * FROM article WHERE ID_Periode = "1" ORDER BY Date_Publication DESC');
?>
<!DOCTYPE html>
<html>
<head>
   <title>Photos</title>
   <meta charset="utf-8">   
   <link rel="stylesheet" href="../css/photosmenu.css" type="text/css">
</head>
<body> 
    
    <div id="acceuil"><p><h1><u>Vos photos:</u></h1></p></br></br>

    
 <?php if(isset($_SESSION['id'])){ ?>
<p><a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?></p></div>

      <?php
      
      while($a = $articles->fetch()) { ?>

<section id="slideshow">
		
	<div class="container">
		<div class="c_slider"></div>
		<div class="slider">
                    
			<figure>

   
   
                 <?php if($a['miniature'] == ""){
   echo "";
   }else{?>
                <img src="../articles/miniatures/<?= $a['ID_Article'] ?>.jpg" alt="" width="640" height="400" /><?php }?> 
                
              
                <figcaption><?= $a['titre'] ?></figcaption>
     </figure>
                    
                                        </div>
	</div>
		
    <span id="timeline"><a href="../articles/article.php?id=<?= $a['ID_Article'] ?>" class="lien" title= "Cliquer pour rejoindre l'article concerné"><font size="4">Voir l'article...</font></A></span>
        
</section>
                    
               
                   
      <?php }?>
               
                    </br></br>
   
       
           <div id="acceuil"><?php if(isset($_SESSION['id'])){ ?>
           <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?></div>
</body>
</html>
