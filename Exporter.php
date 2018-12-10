<!DOCTYPE html>
<html>
<head>
	<title><h1 style=" border:0px solid">Rapport Journalier</h1></title>
</head>
<style type="text/css">
	
	body{
		background-color: lightblue;
	}
	table{
		margin:auto;
		margin-top: 10%;
	}

</style>
<body>
	<div style="border: 0px solid">
<table border=1 cellpadding="0" cellspacing="1" style='background: white'>

<?php

// accès à la base de données ("serveur","utilisateur","mot de passe")
mysql_connect("localhost","root","") or die("La connexion a échoué !");

// on sélectionne la base 
 mysql_select_db("groupeiseka");

// on initialise la première ligne du tableau, qui correspond au nom des champs
$xls_output = " <tr><td>ping_status</td><td>post_name</td></tr>";
// nom". ' '.$xls_output = "prenom
 // nom des champs séparés par un ;
$xls_output .= "\n";

//Requête SQL

$requete="select ping_status, post_name from wp_posts "; // requête
$resultats = mysql_query($requete) or die(mysql_error()); // récupération des résultats

 //Boucle sur les resultats
while($ligne= mysql_fetch_array($resultats))
{
$xls_output .= "
<tr><td>".$ligne['ping_status']."</td><td>".$ligne['post_name']." </td></tr>"; // ajout des lignes
}
echo $xls_output;

?>




	
	
	
</table>
</div>
<table style="border: 0px solid;margin-top: 10px;margin-bottom: 80px" >
	<tr>
		
		
			<td><form method="POST" id="#myForm" action="affiche2.php" enctype="">
				<input style="padding: 10px; border-radius: 10px 10px 10px 10px;box-shadow: 0.5px 0.5px 0.5px 0.5px #aaa"type="submit" name="submit" value="Exporter">
				
 <script>

     $(document).ready(function() {
        $('#myForm').submit;
     });
    </script>
			</form></td>

		<td>
		<form  method="POST" action="maillundi.php" enctype="">
				<input  style="padding: 10px; border-radius: 10px 10px 10px 10px;box-shadow: 0.5px 0.5px 0.5px 0.5px #aaa" type="submit" name="submit" value="Envoyer par mail">
			</form></td>
	</tr>
</table>



</body>
</html>

