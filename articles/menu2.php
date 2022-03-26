<?php
require_once('../bdd/connectbdd.php');

$videosParPage = 4;
$videosTotalesReq = $bdd->query('SELECT ID_Article FROM article WHERE ID_Periode = "2"');
$videosTotales = $videosTotalesReq->rowCount();
$pagesTotales = ceil($videosTotales/$videosParPage);

if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
   $_GET['page'] = intval($_GET['page']);
   $pageCourante = $_GET['page'];
} else {
   $pageCourante = 1;
}
$depart = ($pageCourante-1)*$videosParPage;

?>
<!DOCTYPE html>
<html>
<head>
   <title>1946 à 2017</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="../css/menu1.css" type="text/css">
   
</head>
<body> 
    
    <p align="center"><h2><u>Les tanks de 1946 à nos jours...</u></h2></b></br></br>
           </p>


    
   
      <?php
      
      $articles = $bdd->query('SELECT * FROM article WHERE ID_Periode = "2" ORDER BY Date_Publication DESC LIMIT '.$depart.','.$videosParPage);
      
      while($a = $articles->fetch()) {
          
          $texte = $a['Article_Texte'];
          
          $cont = substr($a['Article_Texte'],0,150);   
 
          
          
          
          
          ?>
      
<b><?= $a['titre'] ?> :     <a href="../articles/article.php?id=<?= $a['ID_Article'] ?>" class="lien"><font size="6"><i><?= $a['Type_de_Tank'] ?></i></font></a> </b></br></br>

       
           
                 <?php if($a['miniature'] == ""){
   echo "";
   }else{?>
 <a href="../articles/article.php?id=<?= $a['ID_Article'] ?>"><img src="miniatures/<?= $a['ID_Article'] ?>.jpg" width="140" /></a><?php echo $cont ;?><a href="../articles/article.php?id=<?= $a['ID_Article'] ?>" class="lien"><i>(....lire la suite)</i></a> <br /></br><?php }  
              
             
                
      } ?>
           
      <div id = "bas">  
          
          <?php
      for($i=1;$i<=$pagesTotales;$i++) {
         if($i == $pageCourante) {
            echo $i.' ';
         } else {
            echo '<a href="menu1.php?page='.$i.'">'.$i.'</a> ';
         }
         } ?></br></br>
      
           
           
          <?php if(isset($_SESSION['id']) AND ($_SESSION['niv'] >= 1 AND $_SESSION['niv'] <= 3  )){
           echo "Cliquer" ?> <a href="redaction2.php?id=<?= $_SESSION['id'] ?>" class="lien"> ICI </a> pour créer votre article ! <?php }?>  </br></br>
           <?php if(isset($_SESSION['id'])){ ?>
           <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?></div>
</body>
</html>