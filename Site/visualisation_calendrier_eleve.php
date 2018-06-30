<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Consulter le calendrier d'un élève</titres></br></br>
	<?php
		$dbhost = 'xxxxx'; //Remplacer xxxxx par votre dbhost
		$dbuser = 'xxxxx'; //Remplacer xxxxx par votre dbuser
		$dbname = 'xxxxx'; //Remplacer xxxxx par votre dbname
		$dbpass = 'xxxxx'; //Remplacer xxxxx par votre dbpass

		$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql'); //Connexion à la DB	
		$result = mysqli_query($connection,"SELECT * FROM eleves");	//requête pour selectionner tous les élèves

		//Formulaire pour sélectionner l'élève dont on veut afficher le calendrier

		echo "<table>";

		echo "<FORM METHOD='POST' ACTION='visualiser_calendrier_eleve.php'>";
		echo "<tr><td><subtitles>Choix de l'élève :</subtitles></td><td><select name='eleve' BORDER='1'>";

		while ($lister_eleves = mysqli_fetch_array($result, MYSQL_NUM))
		{
			echo "<option value=".$lister_eleves[0].">".$lister_eleves[1]." ".$lister_eleves[2]." né le ".$lister_eleves[3]."</option>";
		}

		echo "<tr><td><br><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connection);
	?>

	
</body>
</html>
