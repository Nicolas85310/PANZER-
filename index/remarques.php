<?php require_once('../bdd/connectbdd.php');

// N'afficher que les erreurs, pas les avertissements...
ini_set("error_reporting", "E_ALL & ~E_NOTICE");

// Adresse de réception du formulaire
$email_dest = "nicolas.lenoir52@sfr.fr";

if ($_POST['envoi']) {

// E-mail headers:
$headers ="MIME-Version: 1.0 \n";
$headers .="From: PANZER!! (Site tanks 2nd guerre mondiale)<nicolas.lenoir52@sfr.fr>\n";


$headers .="Content-Type: text/html; charset=utf8 \n";

$subject = "Remarques et suggestions";

$partie_entete = "<html><head>
<meta http-equiv=Content-Type content=text/html; charset=iso-8859-1>
</head>
<body bgcolor=#FFFFFF>";

for ($a=1; $a<= $_POST['nbre_champs_texte']; $a++) {
$partie_champs_texte .= "<font face='Verdana' size='2' color='#003366'>" . $_POST['titre_champ'.$a] . " = " . $_POST['champ'.$a] . "</font><br>";
}

if ($_POST['nbre_zone_email'] != 0) {
$partie_zone_email = "<font face='Verdana' size='2' color='#003366'>" . $_POST['titre_email'] . " = " . $_POST['zone_email'] . "</font><br>";
}

if ($_POST['nbre_zones_texte'] != 0) {
$partie_zone_texte = "<font face='Verdana' size='2' color='#003366'>" . $_POST['titre_zone'] . " = " . $_POST['zone_texte'] . "</font><br>";
$partie_zone_texte = stripslashes($partie_zone_texte);
}

$fin = "<!--SlideIn-->
<script language='javascript' type='text/javascript' src='http://a01.gestionpub.com/GP29a4247fc3293983f'></script>
</body></html>";

$sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_zone_texte . $fin;

// Send the e-mail
if (@!mail($email_dest,$subject,$sortie,$headers)) {
echo("Envoi du formulaire impossible");
} else {

if (isset($_SESSION['id'])){
header('refresh:1;../index/connected.php?id='.$_SESSION['id']);}
else {header('refresh:1;../index/connexion.php');}
echo '<script>alert("Votre message à bien été envoyé !");</script>';
exit();

} // Fin du else
} // Closing if edit
?>
<!doctype html>
<html lang="fr">
    <head>
        <title>Remarques</title>
        
   <meta charset="utf-8">
   <link rel="stylesheet" href="../css/panzer.css" type="text/css">
   <link href="../css/formulaire.css" rel="stylesheet" type="text/css" />
        
        <script language="JavaScript">function verifSelection() {if (document.mail_form.champ1.value == "") {
alert("Veuillez saisir au moins votre prénom !")
return false
} if (document.mail_form.zone_email.value == "") {
alert("Veuillez indiquer votre adresse mail !")
return false
}

invalidChars = " /:,;'"

for (i=0; i<invalidChars.length; i++) {	// does it contain any invalid characters?
badChar = invalidChars.charAt(i)

if (document.mail_form.zone_email.value.indexOf(badChar,0) > -1) {
alert("Votre adresse e-mail contient des caractères invalides. Veuillez vérifier.")
document.mail_form.zone_email.focus()
return false
}
}

atPos = document.mail_form.zone_email.value.indexOf("@",1)			// there must be one "@" symbol
if (atPos == -1) {
alert('Votre adresse e-mail ne contient pas le signe "@". Veuillez vérifier.')
document.mail_form.zone_email.focus()
return false
}

if (document.mail_form.zone_email.value.indexOf("@",atPos+1) != -1) {	// and only one "@" symbol
alert('Il ne doit y avoir qu\'un signe "@". Veuillez vérifier.')
document.mail_form.zone_email.focus()
return false
}

periodPos = document.mail_form.zone_email.value.indexOf(".",atPos)

if (periodPos == -1) {					// and at least one "." after the "@"
alert('Vous avez oublié le point "." après le signe "@". Veuillez vérifier.')
document.mail_form.zone_email.focus()
return false
}

if (periodPos+3 > document.mail_form.zone_email.value.length)	{		// must be at least 2 characters after the 
alert('Il doit y avoir au moins deux caractères après le signe ".". Veuillez vérifier.')
document.mail_form.zone_email.focus()
return false
}if (document.mail_form.zone_texte.value == "") {
alert("Votre message est vide !")
return false
} } // Fin de la fonction

</script>
    </head>
    
    
    <body><form name="mail_form" method="post" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="return verifSelection()">
  <div align="center"></div>
<p align="center">
<table width="566" border="0" align="center">
<p align="center">
    
<h1> Faites moi part de vos remarques ! Merci :) </h1</br>
</p><tr>
      <td><font face="Verdana" size="2">Nom/Prénom</font></td>
      <td><input name="champ1" type="text" required></td>
    </tr><tr>
      <td width><font face="Verdana" size="2">Votre adresse mail</font></td>
      <td width><input name="zone_email" type="text" required></td>
    </tr><tr>
      <td valign="top"><font face="Verdana" size="2">Remarques/suggestions:</font></td>
      <td><textarea name="zone_texte" cols="50" rows="10" required></textarea></td>
    </tr><tr>
      <td valign="top"><input name="nbre_champs_texte" type="hidden" id="nbre_champs_texte" value="1">
        <input name="nbre_zones_texte" type="hidden" value="1">
<input name="nbre_zone_email" type="hidden" value="1">
<input name="titre_champ1" type="hidden" value="Nom et prénom"><input name="titre_email" type="hidden" value="votre @ mail"><input name="titre_zone" type="hidden" value="Votre message"></td>
      <td><div align="center">
<input type="reset" name="Reset" value="Effacer">          
<input type="submit" name="envoi" value="Envoyer">
        </div></td>
    </tr>
  </table>
  <div align="center"></div>
</form><!--SlideIn-->
<script language='javascript' type='text/javascript' src='http://a01.gestionpub.com/GP29a4247fc3293983f'></script>
</body>
</html>




