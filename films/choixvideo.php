<!DOCTYPE html>
<html>
<head>
   <title>choixvideo</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="../css/panzer.css" type="text/css">
   <link href="../css/formulaire.css" rel="stylesheet" type="text/css" />
</head>
<body> 


<div class="centre">


    <h1><u>PERIODE:</u></br></br><a href="videosmenu1.php" class="lien">1939 à 1945</a> ou 
        <a href="videosmenu2.php" class="lien">1946 à 2017</a></h1></br></br></br></br>
        
        
        
        <?php if(isset($_SESSION['id'])){ ?>
           <a href="../index/connected.php" class="lien">PAGE D'ACCUEIL</a>
           <?php } else { ?> <a href="../index/connexion.php" class="lien">PAGE D'ACCUEIL</a> <?php } ?>
        
        
        
           
</div>

</body>
</html>


