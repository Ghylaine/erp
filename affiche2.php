<?php

// accès à la base de données ("serveur","utilisateur","mot de passe")
mysql_connect("localhost","root","") or die("La connexion a échoué !");

// on sélectionne la base 
 mysql_select_db("groupeiseka");

// on initialise la première ligne du tableau, qui correspond au nom des champs
$xls_output = " <table border=1> <tr><td>ping_status</td><td>post_name</td></tr>";
// nom". ' '.$xls_output = "prenom
 // nom des champs séparés par un ;
$xls_output .= "\n";

//Requête SQL

$requete="select ping_status, post_name from wp_posts ";
$resultats = mysql_query($requete) or die(mysql_error()); // récupération des résultats

 //Boucle sur les resultats
while($ligne= mysql_fetch_array($resultats))
{
$xls_output .= "
<tr><td>".$ligne['ping_status']."</td><td>".$ligne['post_name']." </td></tr><br/>"; // ajout des lignes
}
print "</table>";
header("Content-type: application/vnd.ms-excel"); 
header("Content-disposition: attachment; filename=fichier.xls");
 header("Content-type: application/octet-stream" );
 print $xls_output;
exit;
?>