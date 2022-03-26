
<?php
echo "<br /><br /><br />";
try {
 $database = new pdo('mysql:host=localhost;dbname=boubou;charset=utf8','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
catch (Exception $e) {
 die('Erreur '.$e->getMessage());
}

echo "<h1 style=\"color: green;\">LA CONNEXION A LA BASE DE DONNEE EST UN SUCCES !</h1><br />"; 
echo "<img src=\"https://nsm09.casimages.com/img/2021/05/26//mini_2105260108109920017433801.png\"/>";
echo "<br /><br /><br />";

$query = $database->query('SELECT * FROM utilisateurs');

echo "<h2>Les utilisateurs enregistrés sur mon site en ligne à ce jour sont:</h2><br />"; 
while ($data = $query->fetch()) {
 echo $data['Nom'].'      ';
 echo $data['Prenom'].' , ';
}
echo "<br /><br /><br />";

$query = $database->query('SELECT * FROM article');

echo "<h2>Les articles enregistrés sur mon site en ligne à ce jour sont:</h2><br /><br />"; 
while ($data = $query->fetch()) {
 echo $data['Type_de_Tank'].'........article créé par          ';
 echo $data['Login'].'.<br /> ';
}
$query->closeCursor(); // Optionnel
$query = null; // Obligatoire si non la connexion ne se ferme pas.
$database = null; // Obligatoire aussi


   ?>