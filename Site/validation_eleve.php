<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Inscription</titres></br></br>
	<?php
		date_default_timezone_set('Europe/Paris');
		$date = date("Y\-m\-d");

		$name=strtoupper($_POST['nom']);
		$surname=strtoupper($_POST['prenom']);
		$birthday=strtoupper($_POST['naissance']);

		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); // Connexion à la DB

		$requete_verif_doublon = "SELECT * FROM eleves WHERE nom = '$name' and prenom = '$surname';"; // requête pour voir si un élève ayant déjà ce nom et prénom existe déjà

		$verif_doublon_eleve_query = mysqli_query($connect, $requete_verif_doublon);
		$verif_doublon_eleve = mysqli_fetch_array($verif_doublon_eleve_query, MYSQL_NUM);


		if($verif_doublon_eleve) // Si un doublon existe, on demande confirmation en signalant qu'un doublon existe
		{
			echo "</br><subtitle>La personne ".$surname." ".$name." est déjà enregistrée dans nos bases de données. Êtes-vous bien un nouvel élève ?</subtitle></br></br></br>";
			echo "<table>";

			echo "<FORM METHOD='POST' ACTION='ajouter_eleve.php' >";
			echo "<tr><td><INPUT TYPE='radio' VALUE='1' NAME='choix' ID='choix1'><label for='choix1'>Oui</label></td><td><INPUT TYPE='radio' VALUE='0' NAME='choix' ID='choix2'><label for='choix2'>Non</label></td></tr>";
			echo "<input type='hidden' name='nom' value='".$name."'>";
			echo "<input type='hidden' name='prenom' value='".$surname."'>";
			echo "<input type='hidden' name='naissance' value='".$birthday."'>";
			echo "<tr><td><INPUT TYPE='submit' VALUE='Valider'></td></tr>";
			echo "</form>";	
			echo "</table>";
		}
		else // Sinon, on demande juste confirmation des infos entrées
		{		
			echo "</br><subtitle>Confirmer votre envoi ? $birthday</subtitle></br></br></br>";	
			echo "<FORM METHOD='POST' ACTION='ajouter_eleve.php' >";
			echo "<tr><td><INPUT TYPE='radio' VALUE='1' NAME='choix' ID='choix1'><label for='choix1'>Oui</label></td><td><INPUT TYPE='radio' VALUE='0' NAME='choix' ID='choix2'><label for='choix2'>Non</label></td></tr>";
			echo "<input type='hidden' name='nom' value='".$name."'>";
			echo "<input type='hidden' name='prenom' value='".$surname."'>";
			echo "<input type='hidden' name='naissance' value='".$birthday."'>";
			echo "<tr><td><br><br><INPUT TYPE='submit' VALUE='Valider'></tr></td>";
			echo "</table>";
			echo "</form>";		
		}
	?>

	
</body>
</html>

