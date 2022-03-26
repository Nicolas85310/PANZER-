<?php
require_once('../bdd/connectbdd.php');

$videosParPage = 3;
$videosTotalesReq = $bdd->query('SELECT ID_Article FROM article WHERE ID_Periode = "1"');
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
   <title>1939 à 1945</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="../css/menu1.css" type="text/css">
   
</head>
<body> 
    
    <p align="center"><h2><u>Les tanks entre 1939 et 1945</u></h2></b></br></br>
           </p>


    
   
      <?php
      
      $articles = $bdd->query('SELECT * FROM article WHERE ID_Periode = "1" ORDER BY Date_Publication DESC LIMIT '.$depart.','.$videosParPage);
      
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
          <!--<?php $i = $pageCourante; 
          if ($i == 0){$i = 1;}?>
          
          <a href="menu1.php?page=<?= $i -1  ?>"><font size="6" class="lien"><b> << </b></font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--><?php
      for($i=1;$i<=$pagesTotales;$i++) {
         if($i == $pageCourante) {
            echo $i.' ';
         } else {
            echo '<a href="menu1.php?page='.$i.'">'.$i.'</a> ';
         }
         } ?><!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu1.php?page=<?= $i ?>"><font size="6" class="lien"><b> >> </b></font></a>--></br></br>
      
           
           
          <?php if(isset($_SESSION['id']) AND ($_SESSION['niv'] >= 1 AND $_SESSION['niv'] <= 3  )){
           echo "Cliquer" ?> <a href="redaction.php?id=<?= $_SESSION['id'] ?>" class="lien"> ICI </a> pour créer votre article ! <?php }?>  </br></br>
           <?php if(isset($_SESSION['id'])){ ?>
           <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?></div>
</body>
</html>