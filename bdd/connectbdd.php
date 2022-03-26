<?php

session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=boubou;charset=utf8', 'root');
//$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
//$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

?>